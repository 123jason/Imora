<?php

namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Oradt\Utils\Tables;

class DocCommentController extends BaseController
{
    public function postAction($act)
    {
        switch ($act) {
            case 'adddoccomment':
                return $this->_addDocComment(); //添加文档备注
                break;
            case 'editdoccomment':
                return $this->_editDocComment(); //编辑文档备注
                break;
            case 'deldoccomment':
                return $this->_delDocComment(); //删除文档备注
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     * 添加名片备注
     */
    public function _addDocComment(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $objs = $this->strip_tags($request->get('ids'));//添加备注的文档ID
            $objType = $request->get('type', 1);//文档类型，1：wx_biz_card名片，2：weixin_card表名片，3：weixin_other_pic任意扫
            $comment = $this->strip_tags($request->get('comment'));
            $createTime = time();
            $status = 1;

            $this->getConnection()->beginTransaction();
            $objsArr = explode(",", $objs);
            foreach ($objsArr as $obj) {
                if ($objType == 1) {//企业后台
                    $cardInfo = $wxBizService->getCardInfo($obj, 'active');
                    if (empty($cardInfo)) {//无效文档，此处无效名片
                        return $this->renderJsonFailed(Errors::$ACCOUNT_BASIC_BIZCARD_NOT_EXISTS);
                    } else {
                        $owner = $cardInfo['user_id'];
                        $userInfo = $wxBizService->getEmpById($owner);
                        $ownerName = (isset($userInfo['name'])&&!empty($userInfo['name'])) ? $userInfo['name'] : '';
                        $this->checkAccountV2();
                        $publisher = $this->accountId;
                        $publisherName = $this->name;
                    }
                } else {//公众号或任意扫
                    $wechatid = $this->strip_tags($request->get('wechatid'));//发表备注人wechatid
                    if (empty($wechatid) || !isset($wechatid)) {
                        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
                    }
                    $userId = '';
                    $userName = '';
                    /*$user = $wxBizService->getUserByWechatId($wechatid);
                    if (!empty($user)) {//已绑定公司
                        $userId = $user['id'];
                        $userName = $user['name'];
                    } else {
                        return $this->renderJsonFailed(Errors::$OAUTH_ERROR_INVALID_USER);//无效用户，未绑定公司
                    }*/
                    if ($objType == 2) {//公众号
                        $cardInfo = $wxBizService->getWeixinCardInfo($obj, 1);
                    }
                    if ($objType == 3) {//扫描仪任意扫
                        $cardInfo = $wxBizService->getWeixinOtherPicInfo($obj, 100);
                        //$cardInfo = $wxBizService->getWeixinCardInfo($obj, 1);//任意扫合并到weixin_card表后用此
                    }
                    if (empty($cardInfo)) {//无效文档
                        return $this->renderJsonFailed(Errors::$ACCOUNT_BASIC_BIZCARD_NOT_EXISTS);
                    } else {
                        $ownerInfo = $wxBizService->getUserByWechatId($cardInfo['wechat_id']);//文档所有者信息
                        if (empty($ownerInfo)) {//员工表没有该用户
                            $owner = $cardInfo['wechat_id'];
                            $ownerName = '';
                        } else {
                            $owner = $ownerInfo['id'];
                            $ownerName = $ownerInfo['name'];
                        }
                    }

                    $publisher = !empty($userId) ? $userId : $wechatid;
                    $publisherName = $userName;
                }

                $values = "($obj,$objType,'$owner','$ownerName','$comment','$publisher','$publisherName',$createTime,$status)";
                $sql = "INSERT INTO " . Tables::TBWEIXINDOCCOMMENT . " (obj,obj_type,owner,owner_name,comment,publisher,publisher_name,create_time,status) values {$values};";
                $this->getConnection()->executeQuery($sql);
            }
            $this->getConnection()->commit();

            return $this->renderJsonSuccess();
        } catch (\Exception $ex){
            $this->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 编辑名片备注
     */
    public function _editDocComment(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $id = intval($request->get('id'));//被编辑备注的ID
            $comment = $this->strip_tags($request->get('comment'));

            //判断是否能编辑该备注，只能自己编辑自己的或有权限的编辑他人的
            $commonService = $this->container->get('common_service');
            $commentInfo = $commonService->getCommentInfo($id);
            if (empty($commentInfo)) {
                return $this->renderJsonFailed(Errors::$ERROR_DATA_NULL);
            }
            $publisherDoc = $commentInfo['publisher'];//文档原来的发表者
            $objType = $commentInfo['obj_type'];//文档类型，1：wx_biz_card名片，2：weixin_card表名片，3：weixin_other_pic任意扫

            $publisher = '';
            if ($objType == 1) {//企业后台
                $this->checkAccountV2();
                $publisher = $this->accountId;
            } else if ($objType == 2 || $objType == 3) {//公众号或任意扫
                $wechatid = $this->strip_tags($request->get('wechatid'));//发表备注人wechatid
                if (empty($wechatid) || !isset($wechatid)) {
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
                }
                $userId = '';
                /*$user = $wxBizService->getUserByWechatId($wechatid);
                if (!empty($user)) {//已绑定公司
                    $userId = $user['id'];
                    $userName = $user['name'];
                } else {
                    return $this->renderJsonFailed(Errors::$OAUTH_ERROR_INVALID_USER);//无效用户，未绑定公司
                }*/
                $publisher = !empty($userId) ? $userId : $wechatid;
            }

            if ($publisher != $publisherDoc) {
                return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
            }
            $param = array(':id' => $id, ':comment' => $comment);
            $sql = "UPDATE " . Tables::TBWEIXINDOCCOMMENT . " set comment=:comment WHERE id=:id;";
            $this->getConnection()->executeQuery($sql, $param);

            return $this->renderJsonSuccess();
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 删除文档备注
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     */
    public function _delDocComment() {
        try {
            $request = $this->getRequest();
            $ids = $this->strip_tags($request->get('ids'));
            $idsArr = explode(",", $ids);
            foreach ($idsArr as $key => $id) {
                //判断是否能编辑该备注，只能自己编辑自己的或有权限的编辑他人的
                $commonService = $this->container->get('common_service');
                $commentInfo = $commonService->getCommentInfo($id);
                if (empty($commentInfo)) {
                    return $this->renderJsonFailed(Errors::$ERROR_DATA_NULL);
                }
                $publisherDoc = $commentInfo['publisher'];//文档原来的发表者
                $objType = $commentInfo['obj_type'];//文档类型，1：wx_biz_card名片，2：weixin_card表名片，3：weixin_other_pic任意扫

                if ($objType == 1) {//企业后台
                    $this->checkAccountV2();
                    $publisher = $this->accountId;
                }
                if ($objType == 2 || $objType == 3) {//公众号或任意扫
                    $wxBizService = $this->container->get('wx_biz_service');
                    $wechatid = $this->strip_tags($request->get('wechatid'));
                    if (empty($wechatid) || !isset($wechatid)) {
                        return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
                    }
                    /*$user = $wxBizService->getUserByWechatId($wechatid);
                    if (!empty($user)) {//已绑定公司
                        $publisher = $user['id'];
                    } else {
                        return $this->renderJsonFailed(Errors::$OAUTH_ERROR_INVALID_USER);//无效用户，未绑定公司
                    }*/
                    $publisher = $wechatid;
                }

                //判断是否能删除备注，自己的或有权限才可以删
                if ($commentInfo['status'] == 0) {//已被删除不再执行删除
                    unset($idsArr[$key]);
                    continue;
                } else {
                    $publisherDoc = $commentInfo['publisher'];
                    $type = $commentInfo['obj_type'];
                    if ($type != $objType || ($publisher != $publisherDoc)) {
                        unset($idsArr[$key]);
                        continue;
                    }
                }
            }

            if (empty($idsArr)) {
                //没有可以被有效删除的文档备注
            } else {
                $ids = implode(",", $idsArr);
                $sql = "UPDATE " . Tables::TBWEIXINDOCCOMMENT . " SET status=0 WHERE find_in_set(id, :ids)";
                $this->getConnection()->executeQuery($sql, array(':ids' => $ids));
            }

            return $this->renderJsonSuccess();
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function getAction($act)
    {
        switch ($act) {
            case 'getdoccommentforwx'://obj_type=2：weixin_card表名片, obj_type=3：weixin_other_pic任意扫
                return $this->_getDocCommentForWx();
                break;
            case 'getdoccommentforbiz'://obj_type=1：wx_biz_card名片
                return $this->_getDocCommentForBiz();
                break;
            case 'dotable':
                return $this->_doTable();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    public function _doTable() {
        $commonService = $this->container->get('common_service');
        $result = $commonService->doTables();
        var_dump($result);exit;
    }

    /**
     * 公众号或扫描仪获取名片备注（包括任意扫）
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function _getDocCommentForWx() {
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $objId = intval($request->get('id'));
            $objType = intval($request->get('type'));//obj_type=2：weixin_card表名片, obj_type=3：weixin_other_pic任意扫
            $wechatid = $request->get('wechatid');
            if (!$objId) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            if (!in_array($objType, [2,3])) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);//无效访问
            }

            return $this->getDocComment($request, $wechatid, $objId, $objType, $wechatid);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 企业后台获取名片备注，用户是登录状态
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function _getDocCommentForBiz() {
        try {
            $request  = $this->getRequest();
            $objId = intval($request->get('id'));//文档ID
            $objType = 1;
            $this->checkAccountV2();
            $userId = $this->accountId;
            if (!$objId) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }

            return $this->getDocComment($request, $userId, $objId, $objType, $userId);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    private function getDocComment($request, $userId, $objId, $objType, $owner=null, $publisher=null) {
        try {
            $commonService = $this->container->get('common_service');
            $arr = array();
            $sql = $commonService->getCommentSql($objId, $objType, $owner, $publisher);

            $sqldata = array(
                'fields' => array(
                    'id'            => array('mapdb' => 'dc.id'),
                    'obj'           => array('mapdb' => 'dc.obj' , 'w' => ' AND dc.obj = :obj'),
                    'objtype'       => array('mapdb' => 'dc.obj_type', 'w' => ' AND dc.obj_type = :objtype'),
                    'owner'         => array('mapdb' => 'dc.owner' , 'w' => ' AND dc.owner = :owner'),
                    'ownername'     => array('mapdb' => 'dc.owner_name'),
                    'comment'       => array('mapdb' => 'dc.comment'),
                    'publisher'     => array('mapdb' => 'dc.publisher', 'w' => ' AND dc.publisher = :publisher'),
                    'publishername' => array('mapdb' => 'dc.publisher_name'),
                    'createdtime'   => array('mapdb' => 'dc.create_time' , 'w' => 'Range'),
                    'updatedtime'   => array('mapdb' => 'dc.update_time' , 'w' => 'Range'),
                    'status'        => array('mapdb' => 'dc.status', 'w' => ' AND dc.status = :status' ),
                ),
                'default_dataparam' => $arr,
                'sql'   => $sql,
                'where' => '',
                'order' => ' ORDER BY dc.update_time DESC',
                'provide_max_fields' => 'id,obj,objtype,owner,ownername,comment,publisher,publishername,createdtime,updatedtime',
            );

            if (empty($userId)) {
                $check = $this->parseSql($sqldata);
            } else {
                $check = $this->parseSql($sqldata, $userId);
            }
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('obj', $objId);
            $sqldata['data'][':obj'] = array($objId, \PDO::PARAM_INT);
            $this->setParam('objtype', $objType);
            $sqldata['data'][':objtype'] = array($objType, \PDO::PARAM_INT);
            $this->setParam('function', __FUNCTION__);
            if (!empty($owner)) {
                $this->setParam('owner', $owner);
                $sqldata['data'][':owner'] = array($owner, \PDO::PARAM_STR);
            }
            if (!empty($publisher)) {
                $this->setParam('publisher', $publisher);
                $sqldata['data'][':publisher'] = array($publisher, \PDO::PARAM_STR);
            }
            $data = $this->getData($sqldata,'list');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $ex){
            throw $ex;
        }
    }
}
