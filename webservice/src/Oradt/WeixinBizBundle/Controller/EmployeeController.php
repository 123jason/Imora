<?php
namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;

use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\RandomString;

/**
 *
 * @var 员工接口类
 * @version 0.0.1
 * @author ZG
 */
class EmployeeController extends BaseController
{

    public function postAction($act)
    {
        switch ($act) {
            case 'addemps':
                return $this->_bizAddOrEditEmployee(1); // 批量添加员工
                break;
            case 'editemps':
                return $this->_bizAddOrEditEmployee(2); // 批量修改员工
                break;
            case 'empcheckmobile':
                return $this->_empCheckMobile(); // 检查手机号码是否重复
                break;
            default:  
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     *
     * @todo 批量修改添加员工
     * @var 2017-10-11
     * @param
     *            [json] json_data 需要添加的员工json数据
     * @return [json] [<status:0|1>]
     */
    private function _bizAddOrEditEmployee($type)
    {
        $this->checkAccountV2();
        $bizId = $this->bizId;
        $accountId = $this->accountId;
        $request = $this->getRequest();
        $params = array();
        $json_data = $this->strip_tags($request->get('json_data')); //
        
        if (empty($json_data)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $data_arr = json_decode($json_data, true);
        
        $wxBizService = $this->container->get('wx_biz_service');
        
        $error_data_superior_arr = array();
        $error_data_depart_arr = array();
        $error_data_emp_moblie_exist = array();
        $error_data_emp_exist = array();
        $error_data_emp_email_exist = array();
        $error_data_emp_id = array();
        $error_data = array();
        $res_empid = array();
        foreach ($data_arr as $key => $value) {
            $value['superior'] = $accountId;
            // 判断上级是否属于自己
            $res_superior = $wxBizService->checkUserIfExist($value['superior'], 3, $bizId);
            if (empty($res_superior)) {
                $error_data_superior_arr[] = $value["name"] . ':' . $value["mobile"];
                continue;
            }
            // 部门是否存在
            $res_depart_name = $wxBizService->checkDepartByBizAndName($bizId, $value['depart']);
            if ($res_depart_name) {
                $value['depart'] = $res_depart_name["id"];
                // 判断部门是否属于自己
                $res_depart_id = $wxBizService->checkDepartByParentid($bizId, $value['depart']);
                if (empty($res_depart_id)) {
                    $error_data_depart_arr[] = $value["name"] . ':' . $value["mobile"];
                    continue;
                }
            } else {
                // 部门不存在新建部门
                $department_params["bizId"] = $bizId;
                $department_params["addid"] = $accountId;
                $department_params["name"] = $value['depart'];
                $res_depart_id = $wxBizService->insertIntoDepartment($department_params);
                if ($res_depart_id)
                    $value['depart'] = $res_depart_id["departid"];
            }
            
            $value['bizid'] = $bizId;
            
            /**
             *
             * @todo 1、添加员工2、修改员工
             */
            if (1 == $type) {
                $res_emp = $wxBizService->insertIntoEmployee($value);
                if ($res_emp["empid"]) {
                    $res_empid["empid"][] = $res_emp["empid"];
                }
            } else {
                $res_emp = $wxBizService->updateEmployee($value);
                if ($res_emp["empid"]) {
                    $res_empid["empid"][] = $res_emp["empid"];
                }
            }
            switch ($res_emp) {
                case 2:
                    $error_data_emp_moblie_exist[] = $value["name"] . ':' . $value["mobile"];
                    ;
                    break;
                case 110012:
                    $error_data_emp_email_exist[] = $value["name"] . ':' . $value["mobile"];
                    ;
                    break;
                case 999020:
                    $error_data_emp_exist[] = $value["name"] . ':' . $value["mobile"];
                    ;
                    break;
                case 999003:
                    $error_data_emp_id[] = $value["name"] . ':' . $value["mobile"];
                    ;
                    break;
            }
        }
        // 错误输出
        if ($error_data_superior_arr) { // 判断上级是否属于自己
            $error_data_superior = Errors::$ERROR_NOTEXISTS;
            $error_data_superior['description'] = sprintf($error_data_superior['description'], 'superior');
            $error_data_superior['name'] = $error_data_superior_arr;
            $error_data[] = $error_data_superior;
        }
        if ($error_data_depart_arr) { // 判断部门是否属于自己
            $error_data_depart = Errors::$ERROR_NOTEXISTS;
            $error_data_depart['description'] = sprintf($error_data_depart['description'], 'depart');
            $error_data_depart['name'] = $error_data_depart_arr;
            $error_data[] = $error_data_depart;
        }
        if ($error_data_emp_moblie_exist) { // 手机号已经注册过
            $error_data_emp_moblie = Errors::$ERROR_SUB_EXISTS;
            $error_data_emp_moblie['description'] = sprintf($error_data_emp_moblie['description'], 'moblie');
            $error_data_emp_moblie['name'] = $error_data_emp_moblie_exist;
            $error_data[] = $error_data_emp_moblie;
        }
        if ($error_data_emp_exist) { // 员工不存在
            $error_data_emp = Errors::$ERROR_NOTEXISTS;
            $error_data_emp['description'] = sprintf($error_data_emp['description'], 'employee');
            $error_data_emp['name'] = $error_data_emp_exist;
            $error_data[] = $error_data_emp;
        }
        if ($error_data_emp_email_exist) { // 邮箱已经注册过
            $error_data_emp_email = Errors::$DESIGN_ERROR_EMAIL;
            $error_data_emp_email['name'] = $error_data_emp_email_exist;
            $error_data[] = $error_data_emp_email;
        }
        if ($error_data_emp_id) { //
            $error_data_emp_id_not_enough = Errors::$ERROR_PARAMETER_NOT_ENOUGH;
            $error_data_emp_id_not_enough['name'] = $error_data_emp_id;
            $error_data[] = $error_data_emp_id_not_enough;
        }
        $return_str["Success"] = $res_empid;
        $return_str["Failed"] = $error_data;
        return $this->renderJsonSuccess($return_str);
    }
    
    // 检查手机号码是否重复
    private function _empCheckMobile()
    {
        $request = $this->getRequest();
        $mobile = $this->strip_tags($request->get('mobile')); // 手机号
        if (empty($mobile)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $wxBizService = $this->container->get('wx_biz_service');
        // $empObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WxBizEmployee')->findOneBy( array('mobile'=>$mobile,"isDel"=>0));
        $empObj = $wxBizService->checkUserIfExist($mobile);
        if ($empObj) {
            $res["name"] = $empObj["name"];
            $res["biz_id"] = $empObj["biz_id"];
            return $this->renderJsonSuccess($res);
        } else {
            return $this->renderJsonSuccess();
        }
    }
}