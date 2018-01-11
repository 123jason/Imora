<?php

namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Oradt\Utils\Tables;

class BizCardShareController extends BaseController
{
    public function postAction($act)
    {
        switch ($act) {
            case 'settings':
                return $this->_postShare();
                break;
            case 'addshare':
                return $this->_addShare();
                break;
            case 'delshare':
                return $this->_delShare();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     * 分享名片
     */
    public function _addShare() {
        try {
            $this->checkAccountV2();
            $userId = $this->accountId;
            $userName = $this->name;
            $userMobile = $this->mobile;
            $bizId = $this->bizId;
            $request = $this->getRequest();
            $cardid = $this->strip_tags($request->get("cardid"));//字符串：1,2,3
            $type = intval($request->get("type"));//type: 1员工分享给员工 2员工分享给部门 3部门分享给部门
            $moduleids = $this->strip_tags($request->get("moduleids",""));//字符串：1,2,3
            $moduleids = explode(",", $moduleids);
            $itemIds = explode( ",", $cardid );

            if ($type == 3) {//部门分享给部门，不需要cardid参数，且只能本部门管理员设置，超管可设置任意部门
                $wxBizService = $this->container->get('wx_biz_service');
                $departId = intval($request->get('dep'));
                //校验当前登录用户角色是否为管理员
                if ($this->roleId <> 1 && $this->roleId <> 2) {
                    return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);//非管理员不能分享
                }
                //判断当前要被分享的部门，管理员是否设置部门内不可见或公司不可见，设置不可见时则不可分享
                $res = $wxBizService->getDepartById($departId);
                if ($res['status'] == 2 || $res['is_del'] == 1) {
                    return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);//管理员已设置该部门内不可见或该部门已被删除
                }
                //校验被分享名片所属部门是否与当前登录管理员用户为同一部门
                if ($this->roleId == 1) {
                    if ($this->bizId <> $res['biz_id']) {
                        return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);//该超级管理员与要分享的部门不同一公司
                    }
                }
                if ($this->roleId == 2) {
                    if ($departId <> $this->department) {
                        return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);//该管理员与要分享的部门不同一公司
                    }
                }

                foreach($moduleids as $val){
                    if(empty($val) || ($departId == $val) ){
                        continue;
                    }
                    $params = array(
                        ":userId"   => $departId,
                        ":cardid"   => 0,
                        ":type"     => $type,
                        ":moduleid" => $val,
                        ":bizId"    => $bizId
                    );
                    $sql = "INSERT INTO `wx_biz_card_share`(user_id, card_id, type, module_id, biz_id)
                            VALUES( :userId, :cardid, :type, :moduleid, :bizId )";
                    $this->getConnection()->executeQuery( $sql, $params );

                    //部门分享给部门不再发系统消息给管理员
                    /*$wxBizService = $this->container->get("wx_biz_service");
                    if ($type == 1) {//员工给员工分享
                        $receiverInfo = $wxBizService->getEmpById($val);
                        $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : $receiverInfo['mobile'];
                    }
                    if ($type == 2) {//员工给部门分享
                        $receiverInfo = $wxBizService->getDepartById($val);
                        $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : '';
                    }
                    $sendername   = !empty($userName) ? $userName : $userMobile;
                    $objname = '';
                    $content = json_encode(array('sender'=>$userId,'sendername'=>$sendername,'receiver'=>$val,'receivername'=>$receivername,'cardid'=>$itemid));

                    $params = array(':sender' => $userId, ':receiver' => $val, ':objid' => $itemid);
                    $sqlCheck = "SELECT id FROM wx_biz_msg WHERE type=1 AND is_deal=0 AND status=1 AND sender=:sender AND receiver=:receiver AND obj_id=:objid";
                    $res = $this->getConnection()->executeQuery($sqlCheck, $params)->fetch();
                    if (!empty($res)) {//已有对应的未处理的有效状态的系统消息，不再重复入库
                        continue;
                    } else {
                        $params = array(
                            ":type"         => 1,
                            ":sender"       => $userId,
                            ":sendername"   => $sendername,
                            ":receiver"     => $val,
                            ":receivername" => $receivername,
                            ":objid"        => $itemid,
                            ":objname"      => $objname,
                            ":bizid"        => $bizId,
                            ":content"      => $content,
                            ":isdeal"       => 0,//未处理消息
                            ":status"       => 1,//有效消息
                            ":createtime"   => $this->getTimestamp(),
                        );
                        $sqlSys = "INSERT INTO wx_biz_msg (type,sender,sender_name,receiver,receiver_name,obj_id,obj_name,biz_id,content,is_deal,status,create_time) 
                                      VALUES (:type,:sender,:sendername,:receiver,:receivername,:objid,:objname,:bizid,:content,:isdeal,:status,:createtime)";
                        $this->getConnection()->executeQuery( $sqlSys, $params );
                    }*/
                }
            } else if ($type == 1 || $type == 2) {
                foreach ($itemIds as $itemid) {
                    if( empty($itemid) ) continue;
                    $params = array(
                        ":cardid" => $itemid,
                        ":bizId"  => $bizId,
                        ":userId" => $userId
                    );
                    //查询是否自己的名片，不是则不能分享
                    if( 1 == $this->roleId ){
                        $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId LIMIT 1";
                    }else{
                        $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId AND user_id=:userId LIMIT 1";
                    }
                    $iflag = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
                    if( $iflag < 1 ){
                        continue;
                    }

                    //type=1时名片所有者，不再执行所有者给自己的共享
                    if ($type == 1) {
                        $sql = "SELECT user_id FROM " . Tables::TBWXBIZCARD . " WHERE id=:id";
                        $res = $this->getConnection()->executeQuery($sql, array(':id' => $itemid))->fetchColumn();
                        if (isset($res['user_id'])) {
                            $cardUser = $res['user_id'];
                            foreach ($moduleids as $key => $user) {
                                if ($cardUser == $user) unset($moduleids[$key]);
                            }
                        }
                    }

                    foreach($moduleids as $val){
                        if(empty($val) || ($userId === $val) ){
                            continue;
                        }
                        $params = array(
                            ":userId"   => $userId,
                            ":cardid"   => $itemid,
                            ":type"     => $type,
                            ":moduleid" => $val,
                            ":bizId"    => $bizId
                        );
                        $sql = "INSERT INTO `" . Tables::TBWXBIZCARDSHARE . "`(user_id, card_id, type, module_id, biz_id)
                            VALUES( :userId, :cardid, :type, :moduleid, :bizId )";
                        $this->getConnection()->executeQuery( $sql, $params );

                        //生成【分享名片】系统消息，后期可将此操作放入队列异步执行
                        $wxBizService = $this->container->get("wx_biz_service");
                        if ($type == 1) {//员工给员工分享
                            $receiverInfo = $wxBizService->getEmpById($val);
                            $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : $receiverInfo['mobile'];
                        }
                        if ($type == 2) {//员工给部门分享
                            $receiverInfo = $wxBizService->getDepartById($val);
                            $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : '';
                        }
                        $sendername   = !empty($userName) ? $userName : $userMobile;
                        $objname = '';
                        $content = json_encode(array('sender'=>$userId,'sendername'=>$sendername,'receiver'=>$val,'receivername'=>$receivername,'cardid'=>$itemid));

                        $params = array(':sender' => $userId, ':receiver' => $val, ':objid' => $itemid);
                        $sqlCheck = "SELECT id FROM " . Tables::TBWXBIZMSG . " WHERE type=1 AND is_deal=0 AND status=1 AND sender=:sender AND receiver=:receiver AND obj_id=:objid";
                        $res = $this->getConnection()->executeQuery($sqlCheck, $params)->fetch();
                        if (!empty($res)) {//已有对应的未处理的有效状态的系统消息，不再重复入库
                            continue;
                        } else {
                            $params = array(
                                ":type"         => 1,
                                ":sender"       => $userId,
                                ":sendername"   => $sendername,
                                ":receiver"     => $val,
                                ":receivername" => $receivername,
                                ":objid"        => $itemid,
                                ":objname"      => $objname,
                                ":bizid"        => $bizId,
                                ":content"      => $content,
                                ":isdeal"       => 0,//未处理消息
                                ":status"       => 1,//有效消息
                                ":createtime"   => $this->getTimestamp(),
                            );
                            $sqlSys = "INSERT INTO " . Tables::TBWXBIZMSG . " (type,sender,sender_name,receiver,receiver_name,obj_id,obj_name,biz_id,content,is_deal,status,create_time) 
                                      VALUES (:type,:sender,:sendername,:receiver,:receivername,:objid,:objname,:bizid,:content,:isdeal,:status,:createtime)";
                            $this->getConnection()->executeQuery( $sqlSys, $params );
                        }
                    }
                }
            }

            return $this->renderJsonSuccess();
        } catch(\Exception $e){
            throw $e;
        }
    }
    public function _addShareV1() {
        try {
            $this->checkAccountV2();
            $userId = $this->accountId;
            $userName = $this->name;
            $userMobile = $this->mobile;
            $bizId = $this->bizId;
            $request = $this->getRequest();
            $cardid = $request->get("cardid");//字符串：1,2,3
            $type = $request->get("type");//type: 1员工分享给员工 2员工分享给部门 3部门分享给部门
            $moduleids = $request->get("moduleids","");//字符串：1,2,3
            $moduleids = explode(",", $moduleids);
            $itemIds = explode( ",", $cardid );

            foreach ($itemIds as $itemid) {
                if( empty($itemid) ) continue;
                $params = array(
                    ":cardid" => $itemid,
                    ":bizId"  => $bizId,
                    ":userId" => $userId
                );
                //查询是否自己的名片，不是则不能分享
                if( 1 == $this->roleId ){
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId LIMIT 1";
                }else{
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId AND user_id=:userId LIMIT 1";
                }
                $iflag = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
                if( $iflag < 1 ){
                    continue;
                }

                //type=1时名片所有者，不再执行所有者给自己的共享
                if ($type == 1) {
                    $sql = "SELECT user_id FROM " . Tables::TBWXBIZCARD . " WHERE id=:id";
                    $res = $this->getConnection()->executeQuery($sql, array(':id' => $itemid))->fetchColumn();
                    if (isset($res['user_id'])) {
                        $cardUser = $res['user_id'];
                        foreach ($moduleids as $key => $user) {
                            if ($cardUser == $user) unset($moduleids[$key]);
                        }
                    }
                }

                foreach($moduleids as $val){
                    if(empty($val) || ($userId === $val) ){
                        continue;
                    }
                    $params = array(
                        ":userId"   => $userId,
                        ":cardid"   => $itemid,
                        ":type"     => $type,
                        ":moduleid" => $val,
                        ":bizId"    => $bizId
                    );
                    $sql = "INSERT INTO `" . Tables::TBWXBIZCARDSHARE . "`(user_id, card_id, type, module_id, biz_id)
                            VALUES( :userId, :cardid, :type, :moduleid, :bizId )";
                    $this->getConnection()->executeQuery( $sql, $params );

                    //生成【分享名片】系统消息，后期可将此操作放入队列异步执行
                    $wxBizService = $this->container->get("wx_biz_service");
                    if ($type == 1) {//员工给员工分享
                        $receiverInfo = $wxBizService->getEmpById($val);
                        $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : $receiverInfo['mobile'];
                    }
                    if ($type == 2) {//员工给部门分享
                        $receiverInfo = $wxBizService->getDepartById($val);
                        $receivername = !empty($receiverInfo['name']) ? $receiverInfo['name'] : '';
                    }
                    $sendername   = !empty($userName) ? $userName : $userMobile;
                    $objname = '';
                    $content = json_encode(array('sender'=>$userId,'sendername'=>$sendername,'receiver'=>$val,'receivername'=>$receivername,'cardid'=>$itemid));

                    $params = array(':sender' => $userId, ':receiver' => $val, ':objid' => $itemid);
                    $sqlCheck = "SELECT id FROM " . Tables::TBWXBIZMSG . " WHERE type=1 AND is_deal=0 AND status=1 AND sender=:sender AND receiver=:receiver AND obj_id=:objid";
                    $res = $this->getConnection()->executeQuery($sqlCheck, $params)->fetch();
                    if (!empty($res)) {//已有对应的未处理的有效状态的系统消息，不再重复入库
                        continue;
                    } else {
                        $params = array(
                            ":type"         => 1,
                            ":sender"       => $userId,
                            ":sendername"   => $sendername,
                            ":receiver"     => $val,
                            ":receivername" => $receivername,
                            ":objid"        => $itemid,
                            ":objname"      => $objname,
                            ":bizid"        => $bizId,
                            ":content"      => $content,
                            ":isdeal"       => 0,//未处理消息
                            ":status"       => 1,//有效消息
                            ":createtime"   => $this->getTimestamp(),
                        );
                        $sqlSys = "INSERT INTO " . Tables::TBWXBIZMSG . " (type,sender,sender_name,receiver,receiver_name,obj_id,obj_name,biz_id,content,is_deal,status,create_time) 
                      VALUES (:type,:sender,:sendername,:receiver,:receivername,:objid,:objname,:bizid,:content,:isdeal,:status,:createtime)";
                        $this->getConnection()->executeQuery( $sqlSys, $params );
                    }
                }
            }
            return $this->renderJsonSuccess();
        } catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * 取消分享名片
     */
    public function _delShare() {
        try {
            $this->checkAccountV2();
            $userId = $this->accountId;
            $bizId = $this->bizId;
            $request = $this->getRequest();
            $cardid = $request->get("cardid");//字符串：1,2,3
            $type = $request->get("type");
            $moduleids = $request->get("moduleids","");//字符串：1,2,3
            $moduleids = explode(",", $moduleids);
            $itemIds = explode( ",", $cardid );

            foreach ($itemIds as $itemid) {
                if( empty($itemid) ) continue;
                $params = array(
                    ":cardid" => $itemid,
                    ":bizId"  => $bizId,
                    ":userId" => $userId
                );
                //查询是否自己的名片，不是则不能取消
                if( 1 == $this->roleId ){
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId LIMIT 1";
                }else{
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId AND user_id=:userId LIMIT 1";
                }
                $iflag = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
                if( $iflag < 1 ){
                    continue;
                }

                //type=1时名片所有者，不能取消所有者给自己的共享
                if ($type == 1) {
                    $sql = "SELECT user_id FROM " . Tables::TBWXBIZCARD . " WHERE id=:id";
                    $res = $this->getConnection()->executeQuery($sql, array(':id' => $itemid))->fetchColumn();
                    if (isset($res['user_id'])) {
                        $cardUser = $res['user_id'];
                        foreach ($moduleids as $key => $user) {
                            if ($cardUser == $user) unset($moduleids[$key]);
                        }
                    }
                }

                $inDelete = implode(",",$moduleids);
                if( 1 == $this->roleId ){
                    $param_sync = array(':type' => $type, ':cardid' => $cardid, ':moduleid' => $inDelete);
                    $syncSql = "DELETE FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE type=:type AND card_id=:cardid AND find_in_set(module_id, :moduleid)";
                }else{
                    $param_sync = array(':type' => $type, ':bizid' => $bizId, ':userid' => $userId, ':cardid' => $cardid, ':moduleid' => $inDelete);
                    $syncSql = "DELETE FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE type=:type AND biz_id=:bizid AND user_id=:userid AND card_id=:cardid AND find_in_set(module_id, :moduleid)";
                }
                $param_del = array(':receiver' => $inDelete);
                $delSql = "UPDATE " . Tables::TBWXBIZMSG . " SET status=0 WHERE status=1 AND is_deal=0 AND find_in_set(receiver, :receiver)";//未处理的有效系统消息更新为无效消息
                $this->getConnection()->executeQuery($syncSql, $param_sync);
                $this->getConnection()->executeQuery($delSql, $param_del);
            }
            return $this->renderJsonSuccess();
        } catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * 修改名片分享权限
     */
    public function _postShare(){
        $this->checkAccountV2();
        $userId = $this->accountId;
        $bizId  = $this->bizId;

        $request = $this->getRequest();
        $cardid  = $request->get("cardid");//字符串
        $type    = $request->get("type");
        $moduleids = $request->get("moduleids","");//数组
        if( empty($cardid) || empty($type) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $itemIds = explode( ",", $cardid );

        $this->getConnection()->beginTransaction();
        try{
            foreach( $itemIds as $itemid ){
                if( empty($itemid) ) continue;
                $params = array(
                    ":cardid" => $itemid,
                    ":bizId" => $bizId,
                    ":userId" => $userId
                );
                //查询是否自己的名片
                if( 1 == $this->roleId ){
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId LIMIT 1";
                }else{
                    $querySql = "SELECT 1 FROM `" . Tables::TBWXBIZCARD . "` WHERE id=:cardid AND biz_id=:bizId AND user_id=:userId LIMIT 1";
                }
                $iflag = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
                if( $iflag < 1 ){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                }

                //名片所有者，不能共享或取消共享所有者给自己的共享
                $sql = "SELECT user_id FROM " . Tables::TBWXBIZCARD . " WHERE id=:id";
                $res = $this->getConnection()->executeQuery($sql, array(':id' => $itemid))->fetchColumn();
                if (isset($res['user_id'])) {
                    $cardUser = $res['user_id'];
                    foreach ($moduleids as $key => $user) {
                        if ($cardUser == $user) unset($moduleids[$key]);
                    }
                }

                $rs = $this->cardShares( $itemid, $type, $moduleids );
                if( true !== $rs ){
                    return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
                }
            }
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $e){
            $this->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * 名片分享人、部门列表
     * 此方法2017.10.19废弃，因为有情况不能实现：当员工1分享给员工2一张名片，员工1再次取消给员工2的分享时就不能取消，
     * 因为获得的最终要取消的用户ID为空，此时也无法知道是增还是减
     * @param string $cardid 名片ID
     * @param array $moduleArray 用户数组
     * @return boolean
     */
    public function cardShares($cardid, $type, $moduleArray){
        if( empty($cardid) || empty($type) ){
            return false;
        }
        $userId =  $this->accountId;
        $bizId = $this->bizId;
        //查询邀请人真实姓名
        $inviteUsers = explode(',', $moduleArray);
        $em = $this->getManager();
        $em->getConnection()->beginTransaction();
        try{
            if( 1 == $type ){//分享给员工
                //查询所有的被分享员工
                $params = array(':cardid' => $cardid, ':type' => $type, ':moduleid' => $userId);
                $sql = "SELECT module_id AS clientid,user_id  FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE card_id=:cardid AND type=:type AND module_id!=:moduleid";
            }else{//分享给部门
                $params = array(':cardid' => $cardid, ':type' => $type);
                $sql = "SELECT module_id AS clientid,user_id  FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE card_id=:cardid AND type=:type";
            }

            $clientsArray = $this->getConnection()->executeQuery($sql, $params)->fetchAll();
            $listArray = array(); //初始化已分享人列表
            foreach($clientsArray as $val){
                $listArray[] = $val['clientid'];
            }

            /**
             * 此处判断是删除还是新增有问题
             */
            //需删除分享员工或部门
            $deleteList = array_diff($listArray, $inviteUsers);
            //相同员工或部门
            //$commonList = array_intersect($listArray, $inviteUsers);
            //需要增加员工或部门
            $insertList = array_diff($inviteUsers, $listArray);

            //处理需删除员工或部门
            if(!empty($deleteList)){
                $inDelete = implode(",",$deleteList);
                if( 1 == $this->roleId ){
                    $params_sync = array(':cardid' => $cardid, ':type' => $type, ':moduleid' => $inDelete);
                    $syncSql = "DELETE FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE card_id=:cardid AND type=:type AND find_in_set(module_id, :moduleid)";
                }else{
                    $params_sync = array(':cardid' => $cardid, ':type' => $type, ':moduleid' => $inDelete, ':bizid' => $bizId, ':userid' => $userId);
                    $syncSql = "DELETE FROM `" . Tables::TBWXBIZCARDSHARE . "` WHERE card_id=:cardid AND type=:type AND find_in_set(module_id, :moduleid) AND biz_id=:bizid AND user_id!=:userid";
                }
                $params_del = array(':receiver' => $inDelete);
                $delSql = "UPDATE " . Tables::TBWXBIZMSG . " SET status=0 WHERE status=1 AND is_deal=0 AND find_in_set(receiver, :receiver)";//未处理的有效系统消息更新为无效消息
                $this->getConnection()->executeQuery($syncSql, $params_sync);
                $this->getConnection()->executeQuery($delSql, $params_del);
            }
            //处理需增加员工或部门
            if(!empty($insertList)){
                foreach($insertList as $val){
                    if(empty($val) || ($userId === $val) ){
                        continue;
                    }
                    $params = array(
                        ":userId" => $userId,
                        ":cardid" => $cardid,
                        ":type" => $type,
                        ":moduleid" => $val,
                        ":bizId" => $bizId
                    );
                    $sql = "INSERT INTO `" . Tables::TBWXBIZCARDSHARE . "`(user_id, card_id, type, module_id, biz_id)
                            VALUES( :userId, :cardid, :type, :moduleid, :bizId )";
                    $this->getConnection()->executeQuery( $sql, $params );

                    //生成【分享名片】系统消息
                    $content = json_encode(array('sender'=>$userId,'receiver'=>$val,'cardid'=>$cardid));
                    $params = array(':sender' => $userId, ':receiver' => $val, ':content' => $content);
                    $sqlCheck = "SELECT id FROM " . Tables::TBWXBIZMSG . " WHERE type=1 AND is_deal=0 AND status=1 AND sender=:sender AND receiver=:receiver AND content=:content";
                    $res = $this->getConnection()->executeQuery($sqlCheck, $params)->fetch();
                    if (!empty($res)) {//已有对应的未处理的有效状态的系统消息，不再重复入库
                        continue;
                    } else {
                        $params = array(
                            ":type"     => 1,
                            ":sender"   => $userId,
                            ":receiver" => $val,
                            ":objid"    => $cardid,
                            ":bizid"    => $bizId,
                            ":content"  => $content,
                            ":isdeal"   => 0,//未处理消息
                            ":status"   => 1,//有效消息
                            ":createtime" => $this->getTimestamp(),
                        );
                        $sqlSys = "INSERT INTO " . Tables::TBWXBIZMSG . " (type,sender,receiver,obj_id,biz_id,content,is_deal,status,create_time) 
                      VALUES (:type,:sender,:receiver,:objid,:bizid,:content,:isdeal,:status,:createtime)";
                        $this->getConnection()->executeQuery( $sqlSys, $params );
                    }
                }
            }

            $em->getConnection()->commit();
            return true;
        }catch(\Exception $e){
            $em->getConnection()->rollBack();
            throw $e;
        }
    }

    /**
     * 获取某张名片分享权限
     */
    public function getAction(){
        $this->checkAccountV2();
        $request = $this->getRequest();
        $bizId = $this->bizId;

        $sqldata = array(
            'fields' => array(
                'cardid'    => array('mapdb' => 'p.card_id' , 'w' => ' AND p.card_id=:cardid'),
                'type'      => array('mapdb' => 'p.type' , 'w' => ' AND p.type = :type'),
                'moduleid'  => array('mapdb' => 'p.module_id' , 'w' => ' AND p.module_id = :moduleid'),
                'clientid'  => array('mapdb' => 'p.user_id')
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZCARDSHARE . "` as p %s%s",
            'where' => "p.biz_id=:bizid",
            'order' => ' ORDER BY p.id DESC',
            'provide_max_fields' => 'cardid,type,moduleid,clientid',
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $this->setParam('bizid', $bizId);
        $sqldata['data'][':bizid'] = array($bizId, \PDO::PARAM_STR);
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata);

        return $this->renderJsonSuccess ( $data );

    }
    protected function callable_data($item)
    {
        $roleId = $this->roleId ;
        $userId = $this->accountId;
        if (isset( $roleId ) && ! empty ( $item ['user_id'] )) {
            if( $roleId == 1 ){
                $item ['isedit'] = 1;
            }else{
                if( $userId === $item ['user_id'] ){
                    $item ['isedit'] = 1;
                }else{
                    $item ['isedit'] = 0;
                }
            }
        }
        return $item;

    }
}
