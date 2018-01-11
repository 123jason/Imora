<?php

namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;

class SystemMsgController extends BaseController
{
    public function postAction($act)
    {
        switch ($act) {
            case 'setmsgdeal':
                return $this->_setMsgDeal();
                break;
            case 'delmsg':
                return $this->delMsg();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    /**
     * 更新分享名片、等加入同事审核等系统消息状态为已处理
     */
    public function _setMsgDeal(){
        $this->checkAccountV2();
        $request = $this->getRequest();
        $userId = $this->accountId;
        $bizId = $this->bizId;
        $roleid = $this->roleId;

        try {
            $type = intval($request->get('type')) ? intval($request->get('type')) : 1;//消息类型，1名片分享 2任务协作 3待加入同事
            $id = $this->strip_tags($request->get('id'));
            $id = trim($id, ",");
            $uids = $mids = $oids = '';

            /*//如果当前管理员，首先查找全部的管理员
            $wxBizService = $this->container->get('wx_biz_service');
            $uids = $wxBizService->getAllAdmin($bizId);*/

            //验证当前登录用户是否有权限操作该系统消息
            $sql = "SELECT id,obj_id FROM wx_biz_msg WHERE type=:type AND status=1 AND is_deal=0 AND find_in_set(id, :id) AND find_in_set(receiver, :uids)";
            $res = $this->getConnection()->executeQuery($sql, array(':type'=>$type, ':id'=>$id, ':uids'=>$userId))->fetchAll();
            if (empty($res)) {
                return $this->renderJsonFailed(Errors::$ACCOUNT_EMPLOYEE_CONNOT_IDENT);//无权操作或已操作过
            } else {
                $mids = $oids = array();
                foreach ($res as $key => $val) {
                    $mids[] = $val['id'];
                    $oids[] = $val['obj_id'];
                }
                $mids = implode(",", $mids);//消息ID，当前员工有权操作的消息
                $oids = implode(",", $oids);//待审核对象ID
            }

            if ($type == 1) {//分享名片消息处理
                $sql = "UPDATE wx_biz_msg SET is_deal=1 WHERE find_in_set(id, :id)";
                $this->getConnection()->executeQuery($sql, array(':id' => $mids));
            } else if ($type == 3) {//审核新员工，多个管理员的情况
                //处理该员工状态由待审核更新为正常状态
                $sql = "UPDATE wx_biz_employee SET enable=1 WHERE find_in_set(id, :oid)";
                $re = $this->getConnection()->executeQuery($sql, array(':oid' => $oids));

                if ($re) {
                    //查找该条消息所涉及到的全部消息
                    $sql = "SELECT id FROM wx_biz_msg WHERE type=:type AND status=1 AND is_deal=0 AND find_in_set(obj_id, :oids)";
                    $res = $this->getConnection()->executeQuery($sql, array(':type'=>$type, ':oids'=>$oids))->fetchAll();
                    if (!empty($res)) {
                        $ids = array();
                        foreach ($res  as $key => $val) {
                            $ids[] = $val['id'];
                        }
                        $ids = implode(",", $ids);
                    }
                    $updateSql = "UPDATE wx_biz_msg SET is_deal=1 WHERE find_in_set(id, :ids)";
                    $this->getConnection()->executeQuery($updateSql, array(':ids' => $ids));
                }
            }
            return $this->renderJsonSuccess();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 更新消息状态为无效，即删除
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     */
    public function delMsg() {
        $this->checkAccountV2();
        $request = $this->getRequest();
        $userId = $this->accountId;
        $bizId = $this->bizId;

        try {
            $id = $this->strip_tags($request->get('id'));
            $id = trim($id, ",");
            $sql = "UPDATE wx_biz_msg SET status=0 WHERE receiver=:receiver AND find_in_set(id, :id)";
            $this->getConnection()->executeQuery($sql, array(':receiver' => $userId, ':id' => $id));
            return $this->renderJsonSuccess();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAction($act)
    {
        switch ($act) {
            case 'getmsglist':
                return $this->_getMsgList();
                break;
            case 'getmsgcount':
                return $this->_getMsgCount();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }
    /**
     * 获取分享名片、等加入同事审核等系统消息
     */
    public function _getMsgList(){
        $this->checkAccountV2();
        $request = $this->getRequest();
        $roleId = $this->roleId;
        $userId = $this->accountId;
        $userName = $this->name;
        $userMobile = $this->mobile;
        $bizId = $this->bizId;
        try {
            $sql = "SELECT %s FROM wx_biz_msg AS bm %s%s";
            $sqldata = array(
                'fields' => array(
                    'id'          => array('mapdb' => 'bm.id'),
                    'type'        => array('mapdb' => 'bm.type', 'w' => ' AND bm.type = :type'),
                    'sender'      => array('mapdb' => 'bm.sender', 'w' => ' AND bm.sender = :sender'),
                    'sendername'  => array('mapdb' => 'bm.sender_name', 'w' => ' AND bm.sender_name LIKE :sendername'),
                    'receiver'    => array('mapdb' => 'bm.receiver'),
                    'receivername'=> array('mapdb' => 'bm.receiver_name'),
                    'objid'       => array('mapdb' => 'bm.obj_id', 'w' => ' AND bm.obj_id = :objid'),
                    'objname'     => array('mapdb' => 'bm.obj_name', 'w' => ' AND bm.obj_name LIKE :objname'),
                    'bizid'       => array('mapdb' => 'bm.biz_id'),
                    'content'     => array('mapdb' => 'bm.content'),
                    'isdeal'      => array('mapdb' => 'bm.is_deal', 'w' => ' AND bm.is_deal = :isdeal'),
                    'status'      => array('mapdb' => 'bm.status'),
                    'createdtime' => array('mapdb' => 'bm.create_time', 'w' => 'Range'),
                    'updatetime'  => array('mapdb' => 'bm.update_time'),
                ),
                'default_dataparam' => array(),
                'sql'   => $sql,
                'where' => " receiver=:receiver AND status=1",
                'order' => ' ORDER BY bm.id DESC',
                'provide_max_fields' => 'id,type,sender,sendername,receiver,receivername,objid,objname,bizid,content,isdeal,status,createdtime,updatetime',
            );

            $check = $this->parseSql($sqldata);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('receiver', $userId);
            $sqldata['data'][':receiver'] = array($userId, \PDO::PARAM_INT);
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');

            if (!empty($data['list'])) {
                $new = array('share' => array('deal'=>0, 'nodeal'=>0),
                             'cooperation' => array('deal'=>0, 'nodeal'=>0),
                             'audit' => array('deal'=>0, 'nodeal'=>0));
                if (isset($data['list'])) {
                    foreach ($data['list'] as $key => $value) {
                        switch ($value['type']) {
                            case 1:
                                if ($value['isdeal'] == 1) {
                                    $new['share']['deal']++;
                                } else {
                                    $new['share']['nodeal']++;
                                }
                                break;
                            case 2:
                                if ($value['isdeal'] == 1) {
                                    $new['cooperation']['deal']++;
                                } else {
                                    $new['cooperation']['nodeal']++;
                                }
                                break;
                            case 3:
                                if ($value['isdeal'] == 1) {
                                    $new['audit']['deal']++;
                                } else {
                                    $new['audit']['nodeal']++;
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
                $data['count'] = $new;
            }
            return $this->renderJsonSuccess($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 获取系统消息相关总数
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function _getMsgCount() {
        $this->checkAccountV2();
        $request = $this->getRequest();
        $roleId = $this->roleId;
        $userId = $this->accountId;
        $userName = $this->name;
        $userMobile = $this->mobile;
        $bizId = $this->bizId;
        $type = intval($request->get('type'));//1：分享名片 2：任务协作 3：待加入同事审核
        $isdeal = intval($request->get('isdeal'));//0未处理 1已处理
        try {
            if ($type) {
                $sql = "SELECT COUNT(id) AS count FROM wx_biz_msg WHERE type=:type AND receiver=:receiver AND status=1 AND is_deal=:isdeal";
            } else {
                $sql = "SELECT COUNT(id) AS count FROM wx_biz_msg WHERE receiver=:receiver AND status=1 AND is_deal=:isdeal";
            }
            $result = $this->getConnection()->executeQuery($sql, array(':type' => $type, ':receiver' => $userId, ':isdeal' => $isdeal))->fetch();
            return $this->renderJsonSuccess($result);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
