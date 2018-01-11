<?php  
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Errors;
use Oradt\Utils\Password;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PDO;
use Oradt\Utils\Codes; 

use Oradt\StoreBundle\Entity\WxBizSuiteMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
* 企业套餐
* 2017-10-25
*/
class BizSuiteController extends BaseController{
    private $request;
    private $wxBizService;

	/**
	 * POST
	 */
	public function postAction($act)
	{
        $this->checkAccount();
		switch ($act) {  
		    case 'add':
		        return $this->_addSuite();
		        break;
            case 'suite':
                return $this->_addSuiteTerm();
                break;
		    case 'update':
		        return $this->_updateSuite();
		        break; 
		    case 'updatesuitefree':
		        return $this->_updateSuiteFree();
		         break;
			default:
				return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
				break;
		}
	}

    /***
     * @TODO 企业套餐新增 续费 升级 处理
     * @version 0.0.1 qiuzhigang
     * @time 2017-11-14 18:16
     */
	public function _addSuiteTerm(){

        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $metaid = $this->strip_tags(intval(trim($this->request->get('metaid'))));
        $bizid = $this->strip_tags(trim($this->request->get('bizid')));
        $orderType = $this->strip_tags(intval(trim($this->request->get('orderType')))); //1新增 3续费 4升级

        if($metaid>0&&!empty($bizid)&&isset($bizid)&&$orderType>0){
            if($this->wxBizService == null){
                $this->wxBizService = $this->get("wx_biz_payment_service");
            }
            $result = $this->wxBizService->givetrialsuite($bizid,$metaid,$orderType,$this->accountId,$this->accountRealName);
            if($result['errorcode']!=Errors::$SUCCESS_OK){
                return $this->renderJsonFailed($result);
            }
            return $this->renderJsonSuccess($result['data']);
        }
        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
    }

	/**
	 * @todo  套餐添加信息
	 */
	private function _addSuite()
	{
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
	    $name = $this->strip_tags( $this->request->get('name'));//
	    $desc = $this->strip_tags( $this->request->get('suite_desc'));//
	    $level = $this->strip_tags( $this->request->get('level'));//
	    if(empty($level)&&$level!="0")$level=1;
	    $type = $this->strip_tags( $this->request->get('type'));//
	    if(empty($type)&&$type!="0")$type=1;
	    $price = $this->strip_tags( $this->request->get('price'));//
	    $num = $this->strip_tags( $this->request->get('num'));//
	    $sheet = $this->strip_tags( $this->request->get('sheet'));//
	    $buy_month = $this->strip_tags( $this->request->get('buy_month'));//

        $status = $this->strip_tags(intval(trim($this->request->get('status'))));
        if(!in_array($status,[0,99,100])){
            $status = 100;
        }
	    
	    if(empty($name)||empty($price)|empty($buy_month)||empty($num)||empty($sheet)){
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    } 
	    
	    $em = $this->getDoctrine()->getManager(); // 添加事物
	    $em->getConnection()->beginTransaction();
	    try {
	        $createTime = $this->getTimestamp();
	    
	        $wxSuite = new WxBizSuiteMetadata();
	        // 添加信息
	        $wxSuite->setName($name);
	        $wxSuite->setSuiteDesc($desc);
	        $wxSuite->setLevel($level);
	        $wxSuite->setType($type);
	        $wxSuite->setPrice($price);
	        $wxSuite->setNum($num);
	        $wxSuite->setSheet($sheet);
	        $wxSuite->setBuyMonth($buy_month); 
	        $wxSuite->setStatus($status);
	        $wxSuite->setCreateTime($createTime);
	      
	        $em->persist($wxSuite);
	        $em->flush();
	    
	        $suiteId  = $em->getConnection()->lastInsertId();
	           
	        $em->getConnection()->commit();
	        return $this->renderJsonSuccess();
	    } catch (\Exception $ex) {
	        $em->getConnection()->rollback();
	        throw $ex;
	    } 
	    return $this->renderJsonSuccess($suiteId);
	}
	/**
	 * @todo  套餐修改信息
	 */
	private function _updateSuite()
	{
	    $request  = $this->getRequest();
	    $id = $this->strip_tags( $request->get('id'));//
	    $name = $this->strip_tags( $request->get('name'));//
	    $desc = $this->strip_tags( $request->get('desc'));//
	    $level = $this->strip_tags( $request->get('level'));//
	    $type = $this->strip_tags( $request->get('type'));//
	    $price = $this->strip_tags( $request->get('price'));//
	    $num = $this->strip_tags( $request->get('num'));//
	    $sheet = $this->strip_tags( $request->get('sheet'));//
	    $buy_month = $this->strip_tags( $request->get('buy_month'));//
	    $status = $this->strip_tags( $request->get('status'));//
	    
	    if(empty($id)){
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	    
	    $em = $this->getDoctrine()->getManager(); // 添加事物
	    $em->getConnection()->beginTransaction();
	    try {
	         
            $wxSuite = $this->getDoctrine()
                ->getRepository('OradtStoreBundle:WxBizSuiteMetadata')
                ->findOneBy(array(
                'id' => $id
            )); 
            $modifyTime = $this->getTimestamp();
	    
	        // 添加信息
	        if(!empty($name)){
	           $wxSuite->setName($name);
	        }
	        if(!empty($desc))
	           $wxSuite->setSuiteDesc($desc);
	        if(empty($level)||$level=="0")
	           $wxSuite->setLevel($level);
	        if(!empty($type))
	           $wxSuite->setType($type);
	        if(!empty($price))
	           $wxSuite->setPrice($price);
	        if(!empty($num))
	           $wxSuite->setNum($num);
	        if(!empty($sheet))
	            $wxSuite->setSheet($sheet);
	        if(!empty($buy_month))
	           $wxSuite->setBuyMonth($buy_month);  
	        if(!empty($status)||$status=="0"){ 
	            $wxSuite->setStatus($status);
	        }
	        $wxSuite->setModifyTime($modifyTime);
	      
	        $em->persist($wxSuite);
	        $em->flush();
	    
	        $suiteId  = $em->getConnection()->lastInsertId();
	           
	        $em->getConnection()->commit();
	        return $this->renderJsonSuccess();
	    } catch (\Exception $ex) {
	        $em->getConnection()->rollback();
	        throw $ex;
	    } 
	    return $this->renderJsonSuccess($id);
	}
	
	/**
	 * @todo  套餐赠送信息
	 */
	private function _updateSuiteFree()
	{
	    $request  = $this->getRequest(); 
	    $suiteid = $this->strip_tags( $request->get('suite_id'));//0：关闭  
	    if(empty($suiteid)&&$suiteid==""){
	        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
	    }
	    if($suiteid!=0){
	        $_Service = $this->container->get('wx_biz_payment_service');
	        $res=$_Service->getSuiteMetadataById($suiteid,"id");
	        if(empty($res)){
	            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA); 
	        }
	    }
	   
	    $updSql = "UPDATE `wx_system_config` SET option_value=:suiteid WHERE option_name='SUITE_FREE_ID' LIMIT 1";
	    $paramArr[":suiteid"] = $suiteid;
	    $this->getConnection()->executeUpdate($updSql, $paramArr);
	    return $this->renderJsonSuccess();
	}
	 
	/**
	 * get
	 */
	public function getAction($act)
	{
        $this->checkAccount();
	    switch ($act) {
	        case 'getsuitemetadatalist':
	            return $this->_getSuiteMetadataList();
	            break; 
	        case 'getsuitelist':
	            return $this->_getSuiteList();
	            break;
	        case 'suitefree':
	            return $this->_getSuiteFree();
	            break;
	         default:
	            return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
	            break;
	    }
	}

	/**
	 * @todo 获取套餐列表信息
	 */
	private function _getSuiteMetadataList()
	{
	    $where   = '';
        $this->request = Request::createFromGlobals();
        $level = $this->request->get('level');
        if(isset($level)){
            //针对升级套餐获取数据和筛选套餐信息
            $update = $this->request->get('update');
            if($update==1){
                $where .= " level > {$level} ";
            }else{
                $where .= " level = {$level} ";
            }
        }

        $sort = $this->request->get('sort');
        $order = '';
        if(empty($sort)){
            $order .= ' order by level asc, id asc ';
        }
	    $sqldata = array(
	        'fields' => array(
	            'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
	            'name'     => array('mapdb' => 'a.name'),
	            'suite_desc'     => array('mapdb' => 'a.suite_desc'),
	            'type'     => array('mapdb' => 'a.type', 'w' => ' AND a.type = :type'),
	            'level'    => array('mapdb' => 'a.level'),
	            'sheet'        => array('mapdb' => 'a.sheet'),
	            'num'     => array('mapdb' => 'a.num'),
	            'price'    => array('mapdb' => 'a.price'),
	            'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
	            'buy_month'     => array('mapdb' => 'a.buy_month'), 
	            'create_time' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
	            'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
	        ),
	        'default_dataparam' => array(),
	        'sql'   => "SELECT %s FROM `wx_biz_suite_metadata` as a  %s%s ",
	        'where' => "".$where,
	        'order' => ' '.$order,
	        'provide_max_fields' => 'id,name,suite_desc,type,level,sheet,num,price,buy_month,create_time,status,modifytime',
	    );
	    $check = $this->parseSql($sqldata);
	    if(true !== $check){
	        return $this->renderJsonFailed($check);
	    }
	    $data = $this->getData($sqldata,'list');
	    return $this->renderJsonSuccess ( $data );
	}
	 
	/**
	 * @todo 获取套餐列表信息
	 */
	private function _getSuiteList()
	{
	    $where   = '';
        $this->request = Request::createFromGlobals();
        $kwds = $this->request->get('kwds');
        if(isset($kwds)){
            $where .= "b.biz_name like '%{$kwds}%' ";
        }
	    $sqldata = array(
	        'fields' => array(
	            'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
	            'bizid'       => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
                'metaid'       => array('mapdb' => 'a.metaid' , 'w' => ' AND a.metaid = :metaid'),
	            'bizname'     => array('mapdb' => 'b.biz_name'),
	            'term'     => array('mapdb' => 'a.term'),
	            'suitejson'     => array('mapdb' => 'a.suite_json'),
	            'level'    => array('mapdb' => 'a.level','w' => ' AND a.level = :level'),
	            'sheet'        => array('mapdb' => 'a.sheet'),
	            'num'     => array('mapdb' => 'a.num'),
	            'amount'    => array('mapdb' => 'a.amount'),
	            'start_time'     => array('mapdb' => 'a.start_time'),
	            'end_time'     => array('mapdb' => 'a.end_time'), 
	            'create_time' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
	            'modifytime'  => array('mapdb' => 'a.modify_time' , 'w' => 'Range'), 
	        ),
	        'default_dataparam' => array(),
	        'sql'   => "SELECT %s FROM `wx_biz_suite_term` as a  
 	                   left join `wx_biz` b on a.biz_id=b.biz_id
	                    %s%s ",
	        'where' => "".$where,
	        'order' => '',
	        'provide_max_fields' => 'id,bizid,bizname,term,suitejson,level,sheet,num,amount,start_time,end_time,create_time,modifytime',
	    );
	    $check = $this->parseSql($sqldata);
	    if(true !== $check){
	        return $this->renderJsonFailed($check);
	    }
	    $data = $this->getData($sqldata,'list');
	    return $this->renderJsonSuccess ( $data );
	}
	
	/**
	 * @todo 是否有赠送的套餐
	 */
	private  function  _getSuiteFree(){
	    //套餐购买(是否有赠送套餐)
	    $wxBizPaymentService = $this->get("wx_biz_payment_service");
	    $gift_suite=$wxBizPaymentService->getSystemConfig("SUITE_FREE_ID");
	    $res["suite_id"]=0;
	    if(!empty($gift_suite)){   
	         $res["suite_id"]=$gift_suite["option_value"];
	    }
	    return $this->renderJsonSuccess ( $res );
	    
	}
}
