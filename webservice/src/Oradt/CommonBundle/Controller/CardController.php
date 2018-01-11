<?php
namespace Oradt\CommonBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Tables;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\PushToken;

class CardController extends BaseController
{
    public function postAction($act)
    {
        $this->accesstime = $this->getTimestamp1();
        $wechatid = $this->strip_tags($this->getRequest()->get('wechatid'));
        if(isset($wechatid)){
            $this->accountId = $wechatid;
        }
        switch ($act) {
            case 'wxeditcard'://编辑企业名片
                return $this->_wxeditCard();
                break;
            case 'wxdeletecard'://删除企业名片
                return $this->_wxdeleteCard();
                break;
            case 'wxaddcardtag'://企业名片标签更新
                return $this->_wxaddCardTag();
                break;
            case 'wxupdatecardrecycle';//删除、恢复企业名片
                return $this->_wxupdateCardRecycle();
                break;
            case 'wxaddshare'://公众号企业名片分享
                return $this->_wxaddShare();
                break;
            case 'wxdelshare'://公众号企业名片取消分享
                return $this->_wxdelShare();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    public function _wxeditCard(){
        $wxBizService = $this->container->get('wx_biz_service');
        $request  = $this->getRequest();
        $wechatid = $this->strip_tags($request->get('wechatid'));
        $user = $wxBizService->getUserByWechatId($wechatid);
        if (empty($user)) {
            return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
        }
        $userId = $user['id'];
        $bizid = $user['biz_id'];

        $uuid   = $this->strip_tags($request->get('vcardid'));
        $vcard  = $this->strip_tags($request->get('vcard','')); //vcard
        $picture    =$request->files->get('picture');//缩略图
        $picpatha   = $request->files->get('picpatha');//正面大图
        $picpathb   = $request->files->get('picpathb');//背面大图
        $remark = $this->strip_tags($request->get('remark',''));//标签
        if(empty($uuid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $time = $this->getTimestamp();
        $wxBizService = $this->container->get("wx_biz_service");
        $dirs_upload = $this->container->get('dirs_service');
        $findArray = array('id' => $uuid );
        $WxBizCard = $wxBizService->findBizCardOneBy($findArray);
        if(empty($WxBizCard) || $WxBizCard->getStatus() == 'delete'){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try{
            if(!empty($vcard)){
                $WxBizCard->setVcard($vcard);
                $vcardJsonService = $this->container->get("vcard_json_service");
                $vcardinfo = $vcardJsonService->setVcard($vcard);
                $tel = '';
                if(!empty($vcardinfo)){
                    if(!empty($vcardinfo['TEL'])){
                        $TELarr =  explode(',',$vcardinfo['TEL']);
                        if(!empty($TELarr)){
                            foreach($TELarr as $val){
                                $newtel[] =  trim(substr($val,strpos($val,":")+1),'+');
                            }
                            if(!empty($newtel)){
                                $tel = implode(',',$newtel).',';
                            }
                        }
                    }
                    $MOBILES = empty($vcardinfo['MOBILES']) ? '' : trim($vcardinfo['MOBILES'], ',').',';
                    $EMAIL   = empty($vcardinfo['EMAIL']) ? '' : trim($vcardinfo['EMAIL'], ',').',';
                    $ORG     = empty($vcardinfo['ORG']) ? '' : trim($vcardinfo['ORG'], ',').',';
                    $ADR     = empty($vcardinfo['ADR']) ? '' : trim($vcardinfo['ADR'], ',').',';
                    $TITLE   = empty($vcardinfo['TITLE']) ? '' : trim($vcardinfo['TITLE'], ',').',';
                    $FN      = empty($vcardinfo['FN']) ? '' : $vcardinfo['FN'];
                    $vcards = $tel.$MOBILES.$EMAIL.$ORG.$ADR.$TITLE.$FN;
                    $WxBizCard->setVcardtxt($vcards);
                }
            }
            if(!empty($picture))
            {
                //获取名片文件保存文件夹信息
                $uparr =  $dirs_upload->getCardDir($bizid,$uuid);
                $uparr['filename'] = RandomString::make(10).date('YmdHis');
                $picture_Url = $dirs_upload->uploadFile($picture,$uparr);
                if(!empty($picture_Url))
                {
                    $WxBizCard->setPicture($picture_Url);
                }
            }
            if(!empty($picpatha)){
                //获取名片文件保存文件夹信息
                $uparr =  $dirs_upload->getCardDir($bizid,$uuid);
                $uparr['filename'] = RandomString::make(10).date('YmdHis');
                $picpatha_Url = $dirs_upload->uploadFile($picpatha,$uparr);
                if(!empty($picpatha_Url))
                {
                    $WxBizCard->setPicPathA($picpatha_Url);
                }
            }
            if(!empty($picpathb)){
                //获取名片文件保存文件夹信息
                $uparr =  $dirs_upload->getCardDir($bizid,$uuid);
                $uparr['filename'] = RandomString::make(10).date('YmdHis');
                $picpathb_Url = $dirs_upload->uploadFile($picpathb,$uparr);
                if(!empty($picpathb_Url))
                {
                    $WxBizCard->setPicPathB($picpathb_Url);
                }
            }
            if(!empty($remark)){
                $WxBizCard->setRemark($remark);
            }
            $WxBizCard->setModifiedTime($time);
            $em->persist ( $WxBizCard );
            $em->flush ();
            $em->getConnection()->commit();
            //kafka消息的cardid传的是字符串类型的id
            $kafkadata = json_encode(array(
                'cardid' => $uuid,
                'operation' => 'modify'
            ));
            $kafka_Fscancardcorrect = '';
            if($this->container->hasParameter('kafka_fscancardcorrect')){
                $kafka_Fscancardcorrect = $this->container->getParameter('kafka_fscancardcorrect');
            }
            if(!empty($kafka_Fscancardcorrect)) {
                $kafkaService = $this->container->get('kafka_service');
                $kafkaService->sendKafkaMessage($kafka_Fscancardcorrect, $kafkadata);
                $kafkaService->disConnect();
            }
            $datas = array(
                'picture' => $this->getCommondUrl($WxBizCard->getPicture()),
                'picpatha' => $this->getCommondUrl($WxBizCard->getPicPathA()),
                'picpathb' => $this->getCommondUrl($WxBizCard->getPicPathB()),
                'modifiedtime'=>$time,
                'vcard' =>$WxBizCard->getVcard(),
                'markpoint'=>$WxBizCard->getMarkPoint(),
            );
            return $this->renderJsonSuccess($datas);
        }catch (\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }

    }

    public function _wxdeleteCard(){
        $wxBizService = $this->container->get('wx_biz_service');
        $request  = $this->getRequest();
        $wechatid = $this->strip_tags($request->get('wechatid'));
        $user = $wxBizService->getUserByWechatId($wechatid);
        if (empty($user)) {
            return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
        }
        $userId = $user['id'];
        $bizId = $user['biz_id'];
        $roid = $user['role_id'];


        $uuid   = $this->strip_tags($request->get('vcardid'));
        if(empty($uuid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager();
        $getCardResSql = "SELECT * FROM wx_biz_card WHERE id=:uuid AND status='active' limit 1 ";
        $cardRes = $em->getConnection()->executeQuery($getCardResSql, array(':uuid'=>$uuid))->fetch();
        if(empty($cardRes)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        } else {
            //已删除过的不再重复删除，即已放入回收站的不再重复放入回收站
            $sql = "SELECT id FROM wx_biz_card_recycle WHERE user_id=:userid AND card_id=:uuid AND status=0";
            $res = $em->getConnection()->executeQuery($sql, array(':userid' => intval($userId), ':uuid' => $uuid))->fetch();
            if ($res) {
                return $this->renderJsonSuccess();
            }
        }
        $em->getConnection()->beginTransaction();
        try{
            if ($roid == 1) {//超级管理员删除，多个超管删除同一名片只删除一次
                $wxBizService = $this->container->get('wx_biz_service');
                $admin = array();
                $adminArr = $wxBizService->getAllAdmin($bizId, 1);
                foreach ($adminArr as $aid => $val) {
                    $admin[] = $aid;
                }
                $admin = implode(",", $admin);
                $param = array(':uuid' => $uuid, ':userid' => $admin);
                $sql = "SELECT id FROM wx_biz_card_recycle WHERE card_id=:uuid AND status=0 AND find_in_set(user_id, :userid)";
                $res = $em->getConnection()->executeQuery($sql, $param)->fetchAll();
                if (empty($res)) {//未删除过该名片
                    $isnertRecycleSql = "INSERT INTO wx_biz_card_recycle (user_id,card_id,create_time,biz_id,del_user) VALUES(:userid,:cardid,:createtime,:bizid,:deluser)";
                    $em->getConnection()->executeQuery($isnertRecycleSql, array(':userid'=>$userId,':cardid'=>$uuid,':createtime'=>$this->getTimestamp(),':bizid'=>$bizId,':deluser'=>0));
                    $updateCardSql = "UPDATE wx_biz_card SET status='deleted',modified_time=:modifytime WHERE id=:uuid";
                    $em->getConnection()->executeQuery($updateCardSql, array(':uuid'=>$uuid,':modifytime'=>$this->getTimestamp()));
                }
            } else {//员工直接删除进回收站
                $isnertRecycleSql = "INSERT INTO wx_biz_card_recycle (user_id,card_id,create_time,biz_id,del_user) VALUES(:userid,:cardid,:createtime,:bizid,:deluser)";
                $em->getConnection()->executeQuery($isnertRecycleSql, array(':userid'=>$userId,':cardid'=>$uuid,':createtime'=>$this->getTimestamp(),':bizid'=>$bizId,':deluser'=>0));
            }
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }

    }

    public function _wxaddCardTag(){
        $wxBizService = $this->container->get('wx_biz_service');
        $request  = $this->getRequest();
        $wechatid = $this->strip_tags($request->get('wechatid'));
        $user = $wxBizService->getUserByWechatId($wechatid);
        if (empty($user)) {
            return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
        }

        $request  = $this->getRequest();
        $tags = $this->strip_tags($request->get('remark'));//标签字符串
        $uuid = $this->strip_tags($request->get('vcardid'));
        if(empty($uuid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager();
        $getResSql = "SELECT * FROM wx_biz_card  WHERE status='active' AND id=:uuid limit 1";
        $cardRes = $em->getConnection()->executeQuery($getResSql, array(':uuid'=>$uuid))->fetch();
        if(empty($cardRes)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $keyword = $cardRes['remark'];
        $flag = false;
        $remarkArr = array();
        $remark = '';
        $param = array(':uuid'=>$uuid);
        if(!empty($tags)){
            $param['remark'] = ',' . $tags . ',';
        }else{
            $param['remark'] = '';
        }
        $wxBizService->updateCard($param);
        return $this->renderJsonSuccess();
    }

    public function _wxupdateCardRecycle(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId = $user['biz_id'];
            $roleid = $user['role_id'];

            $id = $this->strip_tags($request->get('id'));
            $cardid = $this->strip_tags($request->get('vcardid'));
            $type = $this->strip_tags($request->get('type'));
            if(empty($cardid) || !isset($type)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }

            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            if ($roleid == 1) {//同一公司的多个超管可以恢复和删除互相的名片
                $adminArr = $wxBizService->getAllAdmin($bizId, 1);//全部超管
                //判断当前用户和删除该名片人是否同一公司，是则可以操作，否则不能操作
                $cardInfo = $wxBizService->getRecycleInfoById($id);//获取当前要操作的回收站名片的信息
                foreach ($cardInfo as $key => $item) {
                    $userid = $item['user_id'];//删除人
                    $recycle_id = $item['id'];//$id可能是多个，所以下边操作使用此$recycle_id
                    $card_id = $item['card_id'];//$id可能是多个，所以下边操作使用此$card_id
                    if ($adminArr[$userid]) {
                        if ($type == 1) {//恢复名片即撤销删除操作
                            $wxBizService->delRecycleCard($recycle_id);
                            $wxBizService->changeCardStatus($card_id, 'active');
                        } else {//超管彻底删除名片
                            $wxBizService->completeDelRecycleCard($recycle_id, $userId);
                        }
                    }
                }
            } else {//普通管理员和员工只能操作自己名下的名片
                $cardRes = $wxBizService->getRecycleInfo($cardid, $userId);
                if(empty($cardRes)){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                } else {
                    $idsArr = array();
                    foreach ($cardRes as $key => $val) {
                        if ($val['status'] == 0) {//回收站可见，即未彻底删除
                            $idsArr[] = $val['id'];
                        }
                    }
                    $ids = implode(",", $idsArr);
                }
                if ($type == 1) {//恢复名片即撤销删除操作
                    $wxBizService->delRecycleCard($ids);
                    $wxBizService->changeCardStatus($cardid, 'active');
                } else {//彻底删除名片
                    $wxBizService->completeDelRecycleCard($ids, $userId);
                }
            }
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 公众号企业版分享名片
     */
    public function _wxaddShare() {
        try {
            // 权限判断
            $this->checkWxAccount();
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            //判断是否已绑定公司的正式员工
            $wxBizService = $this->container->get('wx_biz_service');
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId     = $user['id'];
            $bizId      = $user['biz_id'];
            $roleId     = $user['role_id'];
            $userName   = $user['name'];
            $userMobile = $user['mobile'];

            $cardid    = $this->strip_tags($request->get("cardid"));//字符串：1,2,3
            $type      = intval($request->get("type"));//type: 1员工分享给员工 2员工分享给部门 3部门分享给部门
            $moduleids = $this->strip_tags($request->get("moduleids",""));//字符串：1,2,3
            $moduleids = explode(",", $moduleids);
            $itemIds   = explode( ",", $cardid );

            foreach ($itemIds as $itemid) {
                if( empty($itemid) ) continue;
                $params = array(
                    ":cardid" => $itemid,
                    ":bizId"  => $bizId,
                    ":userId" => $userId
                );
                //查询是否自己的名片，不是则不能分享
                if( 1 == $roleId ){
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
     * 公众号企业版取消分享名片
     */
    public function _wxdelShare() {
        try {
            // 权限判断
            $this->checkWxAccount();
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            //判断是否已绑定公司的正式员工
            $wxBizService = $this->container->get('wx_biz_service');
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId  = $user['biz_id'];
            $roleId = $user['role_id'];

            $cardid    = $request->get("cardid");//字符串：1,2,3
            $type      = $request->get("type");
            $moduleids = $request->get("moduleids","");//字符串：1,2,3
            $moduleids = explode(",", $moduleids);
            $itemIds   = explode( ",", $cardid );

            foreach ($itemIds as $itemid) {
                if( empty($itemid) ) continue;
                $params = array(
                    ":cardid" => $itemid,
                    ":bizId"  => $bizId,
                    ":userId" => $userId
                );
                //查询是否自己的名片，不是则不能取消
                if( 1 == $roleId ){
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
                if( 1 == $roleId ){
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

    public function getAction($act)
    {
        $this->accesstime = $this->getTimestamp1();
        $wechatid = $this->strip_tags($this->getRequest()->get('wechatid'));
        if(isset($wechatid)){
            $this->accountId = $wechatid;
        }
        switch ($act) {
            case 'wxgetcardinfo'://公众号获取企业名片详情
                return $this->_wxgetCardInfo();
                break;
            case 'wxgetcard'://公众号获取企业名片列表
                return $this->_wxgetCard();
                break;
            case 'wxgetcardcount'://公众号获取企业名片总数
                return $this->_wxgetCardCount();
                break;
            case 'wxgetrecyclecard'://公众号获取企业回收站名片
                return $this->_wxgetRecycleCard();
                break;
            case 'wxgetuser'://公众号获取企业员工列表
                return $this->_wxgetUser();
                break;
            case 'wxgetdepartment'://公从号获取企业部门列表
                return $this->_wxgetDepartment();
                break;
            case 'wxgetbiztag':
                return $this->_wxgetBizTag();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     * 公众号获取企业名片详情
     * @return Response
     * @throws \Exception
     */
    public function _wxgetCardInfo() {
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $id = intval($request->get('id'));
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];

            $card = $wxBizService->getCardInfo($id);
            return $this->renderJsonSuccess($card);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 公众号获取企业名片列表
     * @return Response
     */
    public function _wxgetCard(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizid = $user['biz_id'];
            $roid = $user['role_id'];

            $arr = array();
            if($roid == 1 ){
                $sql = $wxBizService->getAllSql($userId, $bizid) . " %s%s";
            }else{
                $openstatus = $wxBizService->getBizOpenStatus($bizid);
                if ($openstatus == 1){//开启
                    $sql = $wxBizService->getAllSql($userId, $bizid) . " %s%s";
                }
                if($openstatus == 2){//不开启
                    $sql = $wxBizService->getPrivateSql();
                    $arr['userId'] = '';
                }
            }

            $sqldata = array(
                'fields' => array(
                    'vcardid'       => array('mapdb' => 'bc.id' , 'w' => ' AND bc.id = :vcardid'),
                    'uuid'          => array('mapdb' => 'bc.card_id'),
                    'bizid'         => array('mapdb' => 'bc.biz_id' , 'w' => ' AND bc.biz_id = :bizid'),
                    'accountid'     => array('mapdb' => 'bc.user_id' , 'w' => ' AND bc.user_id = :accountid'),
                    'accountname'   => array('mapdb' => 'em.name', 'w' => ' AND em.name LIKE :accountname'),
                    'section'       => array('mapdb' => 'section' , 'w' => ' AND section = :section'),
                    'vcard'         => array('mapdb' => 'bc.vcard' ),
                    'remark'        => array('mapdb' => 'bc.remark' , 'w' => ' AND (bc.remark LIKE :remark)', 'or' => 1),
                    'createdtime'   => array('mapdb' => 'bc.create_time' , 'w' => 'Range'),
                    'modifiedtime'  => array('mapdb' => 'bc.modified_time' , 'w' => 'Range'),
                    'status'        => array('mapdb' => 'bc.status', 'w' => ' AND bc.status = :status' ),
                    'markpoint'     => array('mapdb' => 'bc.mark_point' ),
                    'picture'       => array('mapdb' => 'bc.picture' ),
                    'picpatha'      => array('mapdb' => 'bc.pic_path_a' ),
                    'picpathb'      => array('mapdb' => 'bc.pic_path_b' ),
                    'cardfrom'      => array('mapdb' => 'bc.card_from' ),
                    'cardtype'      => array('mapdb' => 'bc.card_type' ),
                    'vcardtxt'      => array('mapdb' => 'bc.vcardtxt' , 'w' => ' AND bc.vcardtxt LIKE :vcardtxt' ),
                ),
                'default_dataparam' => $arr,
                'sql'   => $sql,
                'order' => ' ORDER BY bc.modified_time DESC',
                'provide_max_fields' => 'vcardid,uuid,bizid,accountid,accountname,vcard,remark,modifiedtime,createdtime,status,markpoint,picture,picpatha,picpathb,cardfrom,cardtype,vcardtxt,section',
            );
            if($roid == 1 ){
                $sqldata['where'] = '';
            }else{
                $sqldata['where'] = " r.id is null AND bc.status='active' ";
            }

            $check = $this->parseSql($sqldata, $userId);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 公众号获取企业名片总数
     * @return Response
     */
    public function _wxgetCardCount(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizid = $user['biz_id'];
            $roid = $user['role_id'];

            $where = '';
            $selfcount = 0;
            $bindcount = 0;
            if($roid == 1){
                $dataCount = $wxBizService->getCardCountAdmin($userId, $bizid);
                $data = array(
                    'selfcount' => $dataCount['self'],
                    'bindcount' => $dataCount['share']
                );
            }else{
                $openstatus = $wxBizService->getBizOpenStatus($bizid);
                if($openstatus == 1){//开启
                    $dataCount = $wxBizService->getCardCountAdmin($userId, $bizid, " r.id is null AND bc.status='active' ");
                    $data = array(
                        'selfcount' => $dataCount['self'],
                        'bindcount' => $dataCount['share']
                    );
                }else{
                    //自己持有名片的数量
                    $where = 'c.user_id = :userId';
                    $selfcount = $wxBizService->getCardCount($userId,$where);
                    //共享名片数量
                    $where = 'c.user_id <> :userId';
                    $bindcount = $wxBizService->getCardCount($userId,$where,1);
                    $data = array(
                        'selfcount' => $selfcount,
                        'bindcount' => $bindcount
                    );
                }
            }

            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 公众号获取企业回收站名片
     * @return Response
     * @throws \Exception
     */
    public function _wxgetRecycleCard(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId = $user['biz_id'];
            $roid = $user['role_id'];
            $userName = $user['name'];

            $arr = array();
            $where = '';
            if(1 == $roid){//超级管理员
                $sql = $wxBizService->getAdminRecycle();
                $where = " AND r.user_id IN (SELECT id FROM wx_biz_employee WHERE role_id=1 AND biz_id=:bizid)";
            } else {
                $openstatus = $wxBizService->getBizOpenStatus($bizId);
                if ($openstatus == 1) {//开启全部共享
                    $sql = $wxBizService->getAdminRecycle();
                    $where = " AND bc.`status`='active' AND r.user_id=:userid ";
                } else {//关闭全部共享
                    $sql = $wxBizService->getPrivateSql();
                    $arr['userId'] = '';
                    $where = " AND bc.`status`='active' ";
                }
            }
            $sqldata = array(
                'fields' => array(
                    'id'            => array('mapdb' => 'r.id'),
                    'vcardid'       => array('mapdb' => 'bc.id' , 'w' => ' AND bc.id = :vcardid'),
                    'bizid'         => array('mapdb' => 'bc.biz_id' , 'w' => ' AND bc.biz_id = :bizid'),
                    'accountid'     => array('mapdb' => 'bc.user_id' , 'w' => ' AND bc.user_id = :accountid'),
                    'accountname'   => array('mapdb' => 'em.name', 'w' => ' AND em.name LIKE :accountname'),
                    'vcard'         => array('mapdb' => 'bc.vcard' ),
                    'remark'        => array('mapdb' => 'bc.remark' , 'w' => ' AND bc.remark LIKE :remark'),
                    'createdtime'   => array('mapdb' => 'bc.create_time' , 'w' => 'Range'),
                    'modifiedtime'  => array('mapdb' => 'bc.modified_time' , 'w' => 'Range'),
                    'status'        => array('mapdb' => 'bc.status', 'w' => ' AND bc.status = :status' ),
                    'markpoint'     => array('mapdb' => 'bc.mark_point' ),
                    'picture'       => array('mapdb' => 'bc.picture' ),
                    'picpatha'      => array('mapdb' => 'bc.pic_path_a' ),
                    'picpathb'      => array('mapdb' => 'bc.pic_path_b' ),
                    'cardfrom'      => array('mapdb' => 'bc.card_from' ),
                    'cardtype'      => array('mapdb' => 'bc.card_type' ),
                    'vcardtxt'      => array('mapdb' => 'bc.vcardtxt' , 'w' => ' AND bc.vcardtxt LIKE :vcardtxt' ),
                    'delid'         => array('mapdb' => 'r.user_id'),
                ),
                'default_dataparam' => $arr,
                'sql'   => $sql,
                'where' => " r.id is not null AND r.status = 0 ".$where,
                'order' => ' ORDER BY bc.modified_time DESC',
                'provide_max_fields' => 'id,vcardid,bizid,accountid,accountname,vcard,remark,modifiedtime,createdtime,status,markpoint,picture,picpatha,picpathb,cardfrom,cardtype,vcardtxt,delid',
            );
            $check = $this->parseSql($sqldata, $userId);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            if ($roid != 1 && $openstatus == 1) {
                $this->setParam('userid', $userId);
                $sqldata['data'][':userid'] = array($userId, \PDO::PARAM_INT);
            }
            $this->setParam('bizid', $bizId);
            $sqldata['data'][':bizid'] = array($bizId, \PDO::PARAM_STR);
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');
            if (isset($data['list']) && !empty($data['list'])) {
                if ($roid == 1) {//超管可以看到互相的数据，也可操作相互的回收站数据
                    $uidInfo = $wxBizService->getAllAdmin($bizId, $roid);
                    foreach ($data['list'] as $key => &$value) {
                        $delid = $value['delid'];
                        if ($uidInfo[$delid]) {
                            $value['delname'] = $uidInfo[$delid]['name'];
                        } else {
                            $value['delname'] = $userName;
                        }
                    }
                } else {//普通管理员和员工，当前登录用户即删除人
                    foreach ($data['list'] as $key => &$value) {
                        $value['delname'] = $userName;
                    }
                }
            }
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 公众号获取企业员工
     * @return Response
     * @throws \Exception
     */
    public function _wxgetUser() {
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $commonService = $this->container->get('common_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $depart   = $request->get('depart');
            $depart   = isset($depart) ? intval($request->get('depart')) : '';
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId = $user['biz_id'];

            $userList = $commonService->getBizUser($bizId, $depart);
            return $this->renderJsonSuccess($userList);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 公众号获取企业部门
     * @return Response
     * @throws \Exception
     */
    public function _wxgetDepartment() {
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $commonService = $this->container->get('common_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $parentid   = $request->get('parentid');
            $parentid   = isset($parentid) ? intval($request->get('parentid')) : 'all';
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId = $user['biz_id'];

            $depatList = $commonService->getBizDepartment($bizId, $parentid);
            return $this->renderJsonSuccess($depatList);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /*
     * 公众号获取企业标签
     * */
    public function _wxgetBizTag(){
        try {
            $wxBizService = $this->container->get('wx_biz_service');
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $user = $wxBizService->getUserByWechatId($wechatid);
            if (empty($user)) {
                return $this->renderJsonFailed(Errors::$WECHAT_ERROR_INVALID_USER);//无效用户
            }
            $userId = $user['id'];
            $bizId = $user['biz_id'];

            $where = " a.biz_id = '{$bizId}' ";
            $sqldata = array(
                'fields' => array(
                    'id'         => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
                    'bizid'      => array('mapdb' => 'a.biz_id' , 'w' => ' AND a.biz_id = :bizid'),
                    'tagid'      => array('mapdb' => 'a.tag_id' , 'w' => ' AND a.tag_id = :tagid'),
                    'tags'       => array('mapdb' => 'a.tags'),
                    'createtime' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
                    'modifytime' => array('mapdb' => 'a.modify_time' , 'w' => 'Range'),
                    'addid'      => array('mapdb' => 'a.add_id' , 'w' => ' AND a.add_id = :addid'),
                ),
                'default_dataparam' => array(),
                'sql'   => "SELECT %s FROM `" . Tables::TBWXBIZTAGS . "` as a  %s%s",
                'where' => "".$where,
                'order' => '',
                'provide_max_fields' => 'id,bizid,tagid,tags,addid,createtime,modifytime',
            );
            $check = $this->parseSql($sqldata);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $data = $this->getData($sqldata,'list');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    protected function callable_data_wechat($item) {
        if (isset ( $item ['picture'] ) && ! empty ( $item ['picture'] )) {
            $item ['picture'] = $this->getCommondUrl($item['picture']);
        }
        if (isset($item ['picpatha']) && ! empty ( $item ['picpatha'] )) {
            $item ['picpatha'] = $this->getCommondUrl( $item ['picpatha'] );
        }
        if (isset($item ['picpathb']) && ! empty ( $item ['picpathb'] )) {
            $item ['picpathb'] = $this->getCommondUrl( $item ['picpathb'] );
        }
        return $item;
    }
}