<?php
namespace Oradt\WeixinBizBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\PhpZip;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\Tables;
use Oradt\Utils\Str2PY;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\WeixinCard;
use Oradt\StoreBundle\Entity\WxBizCard;
use Oradt\StoreBundle\Entity\WxBizEmployee;
use PDO;

class BizCardController extends BaseController
{
    public function postAction($act)
    {
        switch ($act) {
            case 'addcard'://添加企业名片
                return $this->_addcard();
                break;
            case 'editcard'://修改企业名片
                return $this->_editcard();
                break;
            case 'deletecard'://删除企业名片
                return $this->_deletecard();
                break;
            case 'addcardtag'://名片标签更新
                return $this->_addcardtag();
                break;
            case 'updatecardrecycle'://删除，撤销回收站名片
                return $this->_updateCardRecycle();
                break;
            case 'addpersonalcard'://添加个人名片
                return $this->_addpersonalcard();
                break;
            case 'editpersonalcard'://修改个人名片
                return $this->_editpersonalcard();
                break;
            case 'deletepersonalcard'://删除个人名片
                return $this->_deletepersonalcard();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    public function _addcard()
    {
        $this->checkAccountV2();
        $userId = $this->accountId;
        $bizid  = $this->bizId;
        $request = $this->getRequest();
        $vcard     = $this->strip_tags($request->get('vcard','')); //vcard
        $markpoint = $this->strip_tags($request->get('markpoint',''));//mark点
        $picture   = $request->files->get('picture');//缩略图
        $picpatha  = $request->files->get('picpatha');//正面大图
        $picpathb  = $request->files->get('picpathb');//背面大图
        $remark    = $this->strip_tags($request->get('remark',''));//标签
        $cardfrom = $request->get('scan','');
        $cardtype = $request->get('cardtype','custom');
        //$clientid = $this->strip_tags($request->get('clientid'));//用户id
        if (empty($vcard)  ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $WxBizCard = new WxBizCard();
        $uuid = RandomString::make(32);
        $time = $this->getTimestamp();
        $dirs_upload = $this->container->get('dirs_service');
        $vcardJsonService = $this->container->get("vcard_json_service");
        $vcardinfo = $vcardJsonService->setVcard($vcard);
        $picture_Url = '';
        $picturea_Url = '';
        $pictureb_Url = '';
        $vcards = '';
        $tel='';
        $newtel =array();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try{
            if($picture)
            {
                $uparr = $dirs_upload->getCardDir($bizid,$uuid);
                $uparr['filename'] = 'p_' . RandomString::make(10).date('YmdHis');
                $picture_Url = $dirs_upload->uploadFile($picture,$uparr);
            }

            if($picpatha)
            {
                $picturea_Url = $dirs_upload->getFolderPath($picpatha,$bizid,'res',$uuid,'_a');
                if(!empty($picturea_Url))
                {
                    if(empty($picture)){
                        $picture_Url = $dirs_upload->getThumbPath($picturea_Url,1200/2,720/2, 'width');
                    }
                }
            }
            if($picpathb)
            {
                //获取名片文件保存文件夹信息
                $pictureb_Url = $dirs_upload->getFolderPath($picpathb,$bizid,'res',$uuid,'_b');
            }
            if(!empty($vcardinfo)){
                if(!empty($vcardinfo['TEL'])){
                    $TELarr =  explode(',',$vcardinfo['TEL']);
                    if(!empty($TELarr)){
                        foreach($TELarr as $val){
                            if (empty($val)) continue;
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
            }

            $WxBizCard->setBizId($bizid);
            $WxBizCard->setVcard($vcard);
            $WxBizCard->setUserId($userId);
            $WxBizCard->setCardId($uuid);
            $WxBizCard->setCardFrom($cardfrom);
            $WxBizCard->setMarkPoint($markpoint);
            $WxBizCard->setPicture($picture_Url);
            $WxBizCard->setRemark($remark);
            $WxBizCard->setStatus('active');
            $WxBizCard->setCreateTime($time);
            $WxBizCard->setModifiedTime($time);
            $WxBizCard->setPicPathA($picturea_Url);
            $WxBizCard->setPicPathB($pictureb_Url);
            $WxBizCard->setCardType($cardtype);
            $WxBizCard->setVcardtxt($vcards);
            $em->persist ( $WxBizCard );
            $em->flush ();
            $em->getConnection()->commit();
            $id = $WxBizCard->getId();
            $insertShareSql = "INSERT INTO wx_biz_card_share (user_id,card_id,type,module_id,biz_id) VALUES(:userid,:cardid,:type,:moduleid,:bizid)";
            $this->getConnection()->executeQuery($insertShareSql , array(':userid'=>$userId,':cardid'=>$id,':type'=>1,':moduleid'=>$userId,':bizid'=>$bizid));
            //kafka消息的cardid传的是字符串类型的id
            $kafkadata = json_encode(array(
                'cardid' => $id,
                'operation' => 'add'
            ));
            $kafka_Fscancardcorrect = '';
            if($this->container->hasParameter('kafka_fscancardcorrect')){
                $kafka_Fscancardcorrect = $this->container->getParameter('kafka_fscancardcorrect');
            }
            if(!empty($kafka_Fscancardcorrect)){
                $kafkaService = $this->container->get('kafka_service');
                $kafkaService->sendKafkaMessage($kafka_Fscancardcorrect,$kafkadata);
                $kafkaService->disConnect();
            }
            $datas = array(
                'vcardid'=>$id,
                'picture'=>$picture_Url,
                'picturea'=>$picturea_Url,
                'pictureb'=>$pictureb_Url,
                'modifiedtime'=>$time,
            );
            return $this->renderJsonSuccess($datas);
        }catch (\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }

    }

    public function _editcard(){
        $this->checkAccountV2();
        $bizid = $this->bizId;
        $userId = $this->accountId;
        $request  = $this->getRequest();
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

    public function _deletecard(){
        try{
            $this->checkAccountV2();
            $request = $this->getRequest();
            $bizId = $this->bizId;
            $roid  = $this->roleId;
            $userId = $this->accountId;
            $uuids   = $this->strip_tags($request->get('vcardid'));
            $uuids = explode(",", $uuids);
            if(empty($uuids)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();

            foreach ($uuids as $uuid) {
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
            }

            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }

    }

    public function _addcardtag(){
        $this->checkAccountV2();
        $request = $this->getRequest();
        $tags = $this->strip_tags($request->get('remark'));//标签字符串
        $uuid = $this->strip_tags($request->get('vcardid'));
        if(empty($uuid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $wxBizService = $this->container->get('wx_biz_service');
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
            /*$newRemarkArr = explode(",",$tags);
            if(!empty($newRemarkArr)){
                if(!empty($keyword)){//原记录中有标签内容，即编辑标签
                    $keyword = trim($keyword, ',');
                    $oldRemarkArr =  explode(",",$keyword);
                    if(!empty($oldRemarkArr)){
                        //需要删除的
                        $deleteList = array_diff($oldRemarkArr, $newRemarkArr);
                        if(!empty($deleteList)){
                            foreach($oldRemarkArr as $val ){
                                if(in_array($val,$deleteList)){
                                    continue;
                                }
                                $remarkArr[] = $val;
                            }
                            if(!empty($remarkArr)){
                                $flag = true;
                                $remark = implode(",",$remarkArr);
                            }
                        }else{
                            $remark = $keyword.',';
                        }
                        //需要添加
                        $insertList = array_diff($newRemarkArr, $oldRemarkArr);
                        if(!empty($insertList)){
                            $flag = true;
                            $remark .=implode(",",$insertList);
                        }
                        if($flag){
                            $param['remark'] = $remark;
                            $wxBizService->updateCard($param);
                        }
                    }
                }else{//新增标签
                    $param['remark'] = ',' . $tags . ',';
                    $wxBizService->updateCard($param);
                }
            }*/
            $param['remark'] = ',' . $tags . ',';
        }else{
            $param['remark'] = '';
        }
        $wxBizService->updateCard($param);
        return $this->renderJsonSuccess();
    }

    public function _updateCardRecycle(){
        $this->checkAccountV2();
        $request = $this->getRequest();
        $userId = $this->accountId;
        $roleid = $this->roleId;
        $bizId = $this->bizId;
        $id = $this->strip_tags($request->get('id'));
        $cardid = $this->strip_tags($request->get('vcardid'));
        $type = $this->strip_tags($request->get('type'));
        if(empty($cardid) || !isset($type)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        try {
            $wxBizService = $this->container->get('wx_biz_service');
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

    //个人名片相关接口
    /**
     * 添加个人名片
     * @return Response
     * @throws \Exception
     */
    public function _addpersonalcard()
    {
        try{
            $this->checkAccountV2();
            $wechatid = $this->wechatId;
            $request  = $this->getRequest();
            $picture   = $request->files->get('picture');//缩略图
            $picpatha  = $request->files->get('picpatha');//正面大图
            $picpathb  = $request->files->get('picpathb');//背面大图
            $vcard     = $this->strip_tags($request->get("vcard"));
            $uuid      = RandomString::make(32, Codes::C);

            if(empty($wechatid) || empty($picpatha)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }

            $dirs_upload = $this->container->get('dirs_service');
            $vcardJsonService = $this->container->get("vcard_json_service");
            $vcardinfo = $vcardJsonService->setVcard($vcard);
            if($picture) {
                $uparr = $dirs_upload->getCardDir($wechatid, $uuid);
                $uparr['filename'] = 'p_' . RandomString::make(10).date('YmdHis');
                $picture_Url = $dirs_upload->uploadFile($picture,$uparr);
            }
            if($picpatha) {
                $picturea_Url = $dirs_upload->getFolderPath($picpatha,$wechatid,'res',$uuid,'_a');
                if(!empty($picturea_Url))
                {
                    if(empty($picture)){
                        $picture_Url = $dirs_upload->getThumbPath($picturea_Url,1200/2,720/2, 'width');
                    }
                }
            }
            if($picpathb) {
                //获取名片文件保存文件夹信息
                $pictureb_Url = $dirs_upload->getFolderPath($picpathb,$wechatid,'res',$uuid,'_b');
            }

            $cardType  = 1;//名片来源 1非任意扫(名片) 2任意扫，此处是个人自己手动添加名片
            $pic_url_a = '';
            $pic_url_b = '';
            $time      = $this->getTimestamp();
            $md5picturename = '';
            $smallpicture   = '';
            $ocr_status = 0;
            $isself     = 1;//0不属于自己 1属于自己
            $upway      = 3;//1拍照 2扫描 3手动添加
            $buystatus  = 2;//购买状态1、未购买 2、购买
            $batchid    = $this->getTimestamp1();
            $appType    = 1;//来源类型1、微信2、line3、其他
            $namepre    = '';//名片名称首字母
            $markpoint  = $this->strip_tags($request->get('markpoint',''));//mark点
            $deviceid   = '';//设备id
            $longitude  = floatval($this->strip_tags($request->get('longitude', 0))); //经度
            $latitude   = floatval($this->strip_tags($request->get('latitude', 0)));  //纬度
            $status     = 1;

            $accountContactService = $this->container->get("account_contact_service");
            $contactName           = '';
            $insertArray           = array();
            if(!empty($vcard)){
                $insertArray = $accountContactService->setVcard($vcard);
            }
            if(isset($insertArray['FN'])){
                $contactName = $insertArray['FN'];
            }
            if(!empty($contactName)){
                $strpy   = new Str2PY();
                $namepre = $strpy->getPre($contactName);
            }

            self::ssLog('ocr_pic_start_time', $this->getTimestamp1());
            $em = $this->getDoctrine()->getManager(); //添加事物
            $em->getConnection()->beginTransaction();
            $weixincard = new WeixinCard();
            $weixincard->setWechatId($wechatid);
            $weixincard->setCardType($cardType);
            $weixincard->setUuid($uuid);
            $weixincard->setVcard($vcard);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime($time);
            $weixincard->setMd5PictureName($md5picturename);
            $weixincard->setSmallWechatPicture($smallpicture);
            $weixincard->setOcrStatus($ocr_status);
            $weixincard->setOcrResult('');//json_encode($ocr_result,true)2017-9-3日默认为空
            $weixincard->setWechatPicture($pic_url_a);
            $weixincard->setWechatPictureB($pic_url_b);
            $weixincard->setUpway($upway);
            $weixincard->setBatchid($batchid);
            $weixincard->setBuystatus($buystatus);//购买状态1未购买2购买
            $weixincard->setAppTYpe($appType);
            $weixincard->setInitial($namepre);//首字母
            $weixincard->setMarkPoint($markpoint);
            $weixincard->setIsSelf($isself);
            $weixincard->setDeviceId($deviceid);
            $weixincard->setLongitude($longitude);
            $weixincard->setLatitude($latitude);
            $weixincard->setStatus($status);
            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();
            $id = $weixincard->getId();
            if($id){
                return $this->renderJsonSuccess(['id' => $id]);
            }
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 修改个人名片
     * @return type
     */
    private function _editpersonalcard(){
        try {
            $request = $this->getRequest();
            $cardid  = $request->get('vcardid');
            $vcard   = $request->get('vcard');
            $oneself = $request->get('isself');

            $this->checkAccountV2();
            $wechatId = $this->wechatId;

            if(empty($cardid)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            $wechatinfo = $this->vcard2($vcard);
            if(empty($wechatinfo)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            }

            $WeixinCard = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinCard')->findOneBy(array("id" => $cardid,'wechatId' => $wechatId));
            if(empty($WeixinCard)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            //更新库中的自己名片
            if($oneself == 1){
                $params = [':wechatid'=>$wechatId,':id'=>$cardid];
                $sql1       = "SELECT id FROM `" . Tables::TBWEIXINCARD . "` WHERE wechat_id = :wechatid AND id= :id and is_self = 1 ";
                $infoisself = $this->getConnection()->executeQuery($sql1,$params)->fetchColumn();
                if(!empty($infoisself)){
                    $sql1 = "UPDATE `" . Tables::TBWEIXINCARD . "` SET is_self=0 WHERE id=:id LIMIT 1";
                    $this->getConnection()->executeUpdate($sql1, [':id' => $infoisself]);
                }
            }

            $wechatinfo['cardid'] = $cardid;
            $wechatinfo['vcard']  = $vcard;

            $where               = '';
            $params= [];
            $params[':cardid']   = $wechatinfo['cardid'];
            $params[':wechatid'] = $wechatId;

            if($oneself == 1 || !is_null($oneself)){
                $params[':isself'] = $oneself;
                $where             .= "is_self=:isself,";
            }
            if(!empty($wechatinfo['vcard'])){
                $params[':vcard'] = $wechatinfo['vcard'];
                $where            .= "vcard=:vcard,";
            }
            /*if(!empty($wechatinfo['name'])){
                        $params[':cardname'] = $wechatinfo['name'];
                        $where               .= "card_name=:cardname,";
                    }
                    if(!empty($wechatinfo['telephone'])){
                        $params[':cardtelephone'] = $wechatinfo['telephone'];
                        $where                    .= "card_telephone=:cardtelephone,";
                    }
                    if(!empty($wechatinfo['mobile'])){
                        $params[':cardmobile'] = $wechatinfo['mobile'];
                        $where                 .= "card_mobile=:cardmobile,";
                    }
                    if(!empty($wechatinfo['address'])){
                        $params[':cardaddress'] = $wechatinfo['address'];
                        $where                  .= "card_address=:cardaddress,";
                    }
                    if(!empty($wechatinfo['company_name'])){
                        $params[':cardcompany'] = $wechatinfo['company_name'];
                        $where                  .= "card_company=:cardcompany,";
                    }
                    if(!empty($wechatinfo['web'])){
                        $params[':cardcompanyurl'] = $wechatinfo['web'];
                        $where                     .= "card_company_url=:cardcompanyurl,";
                    }*/

            $currentTime           = $this->getTimestamp();
            $params[':modifytime'] = $currentTime;
            $sql = "UPDATE `" . Tables::TBWEIXINCARD . "` SET  " . $where . " modify_time=:modifytime WHERE id=:cardid AND wechat_id = :wechatid LIMIT 1";
            $res = $this->getConnection()->executeUpdate($sql, $params);
            //异步矫正数据
            if($res){
                $kafkadata = json_encode(array('cardid' => $wechatinfo['cardid'], 'operation' => 'modify'));

                $kafka_Fbusinesscardcorrect = '';
                if($this->container->hasParameter('kafka_fbusinesscardcorrect')){
                    $kafka_Fbusinesscardcorrect = $this->container->getParameter('kafka_fbusinesscardcorrect');
                }
                if(!empty($kafka_Fbusinesscardcorrect)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_Fbusinesscardcorrect, $kafkadata);
                    $kafkaService->disConnect();
                }
                $uuid = $WeixinCard->getUuid();
                if(!empty($uuid)){
                    $kafka_data          = array("uuid" => $uuid, "operation" => 'modify');
                    $this->pushVcardId[] = $kafka_data;
                    $this->kafkaContactCard();
                }
                $data           = array();
                $data['cardid'] = $cardid;
                $data['vcard']  = $vcard;

                return $this->renderJsonSuccess($data);
            }else{
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
            }
        } catch(\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 删除个人名片
     * @return
     */
    public function _deletepersonalcard(){
        try{
            $this->checkAccountV2();
            $wechatId = $this->wechatId;
            $request = $this->getRequest();
            $cardids = $this->strip_tags($request->get('vcardid'));
            // 权限判断
            if(empty ($cardids) || empty($wechatId)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            $cardidsArr = explode(",", $cardids);
            foreach ($cardidsArr as $cardid) {
                $params = array('id' => $cardid, 'status' => 1);
                if(!empty($wechatId)){
                    $params['wechatId'] = $wechatId;
                }
                $res = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinCard')->findOneBy($params);
                if(empty($res)){
                    return $this->renderJsonSuccess();
                }
                $em = $this->getDoctrine()->getManager(); //添加事务
                $em->getConnection()->beginTransaction();

                if(!empty($res)){
                    $picture = $res->getWechatPicture();
                    //删除名片图
                    $dirs_upload = $this->container->get('dirs_service');
                    $dirs_upload->deleteFile($picture);
                    //kafka消息
                    $kafkadata    = json_encode(array('cardid' => $cardid, 'operation' => 'delete'));
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage('business-card-correct', $kafkadata);
                    $kafkaService->disConnect();
                    // app名片须发kafka消息
                    $uuid    = $res->getUuid();
                    $userObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy(array('wechatId' => $wechatId));
                    $userId  = '';
                    if(!empty($userObj)){
                        $userId = $userObj->getUserId();
                    }
                    if(!empty($uuid)){
                        $kafka_data          = array("uuid" => $uuid, "operation" => 'delete');
                        $this->pushVcardId[] = $kafka_data;
                        $this->kafkaContactCard();
                    }
                    $res->setStatus(2);
                    $em->persist($res);
                    $em->flush();
                    $em->getConnection()->commit();
                }
            }
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    //后期修改，此处相关card_开头的字段
    private function vcard2($data){
        $return = array(
            'name'            => '', 'email' => '', 'job' => '', 'company_name' => '', 'address' => '',
            'card_zipcode'    => '', //邮编没有
            'department'      => '', 'telephone' => '', 'mobile' => '', 'fax' => '', 'web' => '',
            'card_industry'   => '', //行业没有
            'wechat_card_xml' => '', //
            'vcard'           => '');
        if(!empty($data)){
            $vcardJsonService = $this->container->get("vcard_json_service");
            $vcard_json = $vcardJsonService->loadVcard($data);

            foreach($vcard_json as $key => $val){
                if($key == 'company'){
                    foreach($val as $k => $v){
                        foreach($v as $ke => $vl){
                            if($ke != 0) {//字段入值目前只取第一个公司的
                                continue;
                            }
                            if($ke == 'address') {
                                $return[$ke] = $this->explodeItem($ke, 80, $key, $k);
                            }else if($ke == 'company_name') {
                                $return[$ke] = str_replace(",", "###", $this->explodeItem($ke, 40, $key, $k));
                            }else if($ke == 'job' || $ke == 'card_industry' || $ke == 'email') {
                                $return[$ke] = $this->explodeItem($ke, 40, $key, $k);
                            }else
                                $return[$ke] = $this->explodeItem($ke, 30, $key, $k);
                        }
                    }
                }else{
                    $return[$key] = $this->explodeItem($key, 30);
                }
            }
        }

        return $return;
    }

    private function explodeItem($key, $len = 10, $ke = '', $k = '', $separator = ','){
        $vcard_json = array();
        $str = $separator;
        if($ke == 'company'){
            if(!isset($vcard_json[$ke][$k][$key])) return '';
            foreach($vcard_json[$ke][$k][$key] as $k => $v){
                if($k < 4){
                    if(strlen($str . $v) >= $len) $str .= mb_substr($v . $separator, 0, $len, 'utf-8');else
                        $str .= $v . $separator;
                }
            }
        }else{
            if(!isset($vcard_json[$key])) return '';
            foreach($vcard_json[$key] as $k => $v){
                if(strlen($str . $v) >= $len) $str .= mb_substr($v . $separator, 0, $len, 'utf-8');else
                    $str .= $v . $separator;
            }
        }

        return trim($str, $separator);
    }
    


    public function getAction($act)
    {
        switch ($act) {
            case 'getcardinfo'://获取企业名片详情
                return $this->_getCardInfo();
                break;
            case 'getbizcard'://获取企业名片列表
                return $this->_getBizCard();
                break;
            case 'bizcardcount'://获取企业名片数量
                return $this->_bizCardCount();
                break;
            case 'getbizcardsenior'://获取企业名片列表（高级搜索）
                return $this->_getBizCardSenior();
                break;
            case 'getrecyclecard'://获取回收站名片
                return $this->_getRecycleCard();
                break;
            case 'synccardfromwxtobiz'://同步微信名片到企业名片表，单张
                return $this->_syncCardFromWxToBiz();
                break;
            case 'syncbatchcardfromwxtobiz'://同步微信名片到企业名片表，按批次
                return $this->_syncBatchCardFromWxToBiz();
                break;
            case 'getwechat'://获取个人名片
                return $this->getwechat();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    public function _getCardInfo() {
        try {
            $request   = $this->getRequest();
            $id = intval($request->get('id'));
            $this->checkAccountV2();
            $userId =  $this->accountId;
            $wxBizService = $this->container->get('wx_biz_service');
            $card = $wxBizService->getCardInfo($id);
            return $this->renderJsonSuccess($card);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function _getBizCard(){
        $request   = $this->getRequest();
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $roid = $this->roleId;
        $arr = array();

        $wxBizService = $this->container->get('wx_biz_service');
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
                'vcid'          => array('mapdb' => 'bc.id' , 'w' => 'Range'),
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
            'provide_max_fields' => 'vcardid,vcid,uuid,bizid,accountid,accountname,vcard,remark,modifiedtime,createdtime,status,markpoint,picture,picpatha,picpathb,cardfrom,cardtype,vcardtxt,section',
        );
        if($roid == 1 ){
            $sqldata['where'] = '';
        }else{
            $sqldata['where'] = " r.id is NULL AND bc.status='active' ";
        }

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata,'list','callable_data_wechat');
        return $this->renderJsonSuccess ( $data );
    }

    public function _getBizCardSenior() {
        try {
            $request   = $this->getRequest();
            $this->checkAccountV2();
            $userId =  $this->accountId;
            $bizid = $this->bizId;
            $roid = $this->roleId;
            $arr = array();

            $wxBizService = $this->container->get('wx_biz_service');
            if($roid == 1 ){
                $sql = $wxBizService->getAllSql($userId, $bizid) . " LEFT JOIN wx_biz_card_info ci ON ci.card_id = bc.id %s%s";
            }else{
                $openstatus = $wxBizService->getBizOpenStatus($bizid);
                if($openstatus == 1){//开启
                    $sql = $wxBizService->getAllSql($userId, $bizid) . " LEFT JOIN wx_biz_card_info ci ON ci.card_id = bc.id %s%s";
                }
                if ($openstatus == 2){//不开启
                    $sql = $wxBizService->getPrivateSqlSenior();
                    $arr['userId'] = '';
                }
            }

            $sqldata = array(
                'fields' => array(
                    'vcardid'       => array('mapdb' => 'bc.id' , 'w' => ' AND bc.id = :vcardid'),
                    'vcid'          => array('mapdb' => 'bc.id' , 'w' => 'Range'),
                    'uuid'          => array('mapdb' => 'bc.card_id'),
                    'bizid'         => array('mapdb' => 'bc.biz_id' , 'w' => ' AND bc.biz_id = :bizid'),
                    'accountid'     => array('mapdb' => 'bc.user_id' , 'w' => ' AND bc.user_id = :accountid'),
                    'accountname'   => array('mapdb' => 'em.name', 'w' => ' AND em.name LIKE :accountname'),
                    'section'       => array('mapdb' => 'section' , 'w' => ' AND section = :section'),
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

                    //高级搜索涉及字段
                    'createdtimeinfo'   => array('mapdb' => 'ci.create_time' , 'w' => 'Range'),
                    'modifiedtimeinfo'  => array('mapdb' => 'ci.modified_time' , 'w' => 'Range'),
                    'creatorid'     => array('mapdb' => 'bc.user_id', 'w' => ' AND bc.user_id IN (:creatorid)'),
                    'creatorname'   => array('mapdb' => 'em.name', 'w' => ' AND em.name LIKE :creatorname'),
                    'cardname'      => array('mapdb' => 'ci.FN', 'w' => ' AND ci.FN LIKE :cardname'),
                    'org'           => array('mapdb' => 'ci.ORG' , 'w' => ' AND ci.ORG LIKE :org' ),
                    'depar'         => array('mapdb' => 'ci.DEPAR' , 'w' => ' AND ci.DEPAR LIKE :depar' ),
                    'title'         => array('mapdb' => 'ci.TITLE' , 'w' => ' AND ci.TITLE LIKE :title' ),
                    'cell'          => array('mapdb' => 'ci.CELL' , 'w' => ' AND ci.CELL LIKE :cell' ),
                    'tel'           => array('mapdb' => 'ci.TEL' , 'w' => ' AND ci.TEL LIKE :tel' ),
                    'fax'           => array('mapdb' => 'ci.FAX' , 'w' => ' AND ci.FAX LIKE :fax' ),
                    'email'         => array('mapdb' => 'ci.EMAIL' , 'w' => ' AND ci.EMAIL LIKE :email' ),
                    'adr'           => array('mapdb' => 'ci.ADR' , 'w' => ' AND ci.ADR LIKE :adr' ),
                    'industry'      => array('mapdb' => 'ci.INDUSTRY' , 'w' => ' AND ci.INDUSTRY LIKE :industry' ),
                    'co'            => array('mapdb' => 'ci.CO' , 'w' => ' AND ci.CO LIKE :co' ),
                    'pr'            => array('mapdb' => 'ci.PR' , 'w' => ' AND ci.PR LIKE :pr' ),
                    'cy'            => array('mapdb' => 'ci.CY' , 'w' => ' AND ci.CY LIKE :cy' ),
                    'rd'            => array('mapdb' => 'ci.RD' , 'w' => ' AND ci.RD LIKE :rd' ),
                    'pc'            => array('mapdb' => 'ci.PC' , 'w' => ' AND ci.PC LIKE :pc' ),
                    'bind'          => array('mapdb' => 'ci.bind' , 'w' => ' AND ci.bind LIKE :bind' ),
                    'hasemail'      => array('mapdb' => 'ci.EMAIL' , 'w' => ' AND ci.EMAIL != :hasemail', 'neq' => '' ),
                    'hascell'       => array('mapdb' => 'ci.CELL' , 'w' => ' AND ci.CELL != :hascell', 'neq' => '' ),
                    'hastel'        => array('mapdb' => 'ci.TEL' , 'w' => ' AND ci.TEL != :hastel', 'neq' => '' ),
                    'hasfax'        => array('mapdb' => 'ci.FAX' , 'w' => ' AND ci.FAX != :hasfax', 'neq' => '' ),
                ),
                'default_dataparam' => $arr,
                'sql'   => $sql,
                'order' => ' ORDER BY bc.modified_time DESC',
                'provide_max_fields' => 'vcardid,vcid,uuid,bizid,accountid,accountname,vcard,remark,modifiedtime,createdtime,status,markpoint,picture,picpatha,picpathb,cardfrom,cardtype,vcardtxt,section',
            );
            if($roid == 1 ){
                $sqldata['where'] = '';
            }else{
                $sqldata['where'] = " r.id is NULL AND bc.status='active' ";
            }

            $check = $this->parseSql($sqldata);
            if(true !== $check){
                return $this->renderJsonFailed($check);
            }
            $this->setParam('function', __FUNCTION__);
            $data = $this->getData($sqldata,'list','callable_data_wechat');
            return $this->renderJsonSuccess ( $data );
        } catch (\Exception $e) {
            throw $e;
            /*$logger = $this->container->get('logger');
            $logger->err($e->getFile().' '.$e->getLine().' '.$e->getMessage());*/
        }
    }

    public function _bizCardCount(){
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $roid = $this->roleId;
        $arr = array();

        $wxBizService = $this->container->get('wx_biz_service');
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
    }

    public function _getRecycleCard(){
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $roid = $this->roleId;
        $bizId = $this->bizId;
        $userName = $this->name;

        $wxBizService = $this->container->get('wx_biz_service');
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
        $check = $this->parseSql($sqldata);
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
                $wxBizService = $this->container->get('wx_biz_service');
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
    }

    /**
     * 微信名片同步到企业名片表，单张/多张名片同步
     * @return Response
     * @throws \Exception
     */
    public function _syncCardFromWxToBiz() {
        $request   = $this->getRequest();
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $roleId = $this->roleId;

        try {
            $wxcardid = $this->strip_tags($request->get('wxcardid'));
            $wechatid = $this->strip_tags($request->get('wechatid',''));

            //执行service
            $commonService = $this->container->get('common_service');
            $result = $commonService->syncCardFromWxToBizLots(array('wxcardid' => $wxcardid, 'wechatid' => $wechatid, 'bizid' => $bizid, 'userid'=>$userId));//多张同步
            return $this->renderJsonSuccess($result);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 微信名片同步到企业名片表，按批次同步
     * @return Response
     * @throws \Exception
     */
    public function _syncBatchCardFromWxToBiz() {
        $request   = $this->getRequest();
        $this->checkAccountV2();
        $userId =  $this->accountId;
        $bizid = $this->bizId;
        $roleId = $this->roleId;

        try {
            $batchid = intval($request->get('batchid'));//批次号

            //执行service
            $commonService = $this->container->get('common_service');
            $result = $commonService->syncBatchCardFromWxToBiz(array('batchid' => $batchid, 'bizid' => $bizid, 'userid' => $userId));
            return $this->renderJsonSuccess($result);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 获取个人名片列表
     */
    public function getwechat(){
        $this->checkAccountV2();
        $wechatId = $this->wechatId;
        $request   = $this->getRequest();
        $content  = $request->get('kwds'); //关键词
        $new      = intval($request->get('new', 0));//搜索类型

        if(empty($wechatId)){
            return $this->renderJsonSuccess();
        }
        $type     = intval($request->get('type', 0));//1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份 6可分享的名片
        $typekwds = $request->get('typekwds');


        $keds = ' a.status=1 ';
        $sort = ' ORDER BY a.created_time DESC';
        $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a %s%s';
        //如果有type有走连表
        if(!empty($type)){
            $sql = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDINDUSTRYFUNCTION . '` as b on b.card_id = a.id  %s%s';
            switch($type){
                case 1:
                    $keds = " a.status=1 AND b.card_company = '{$typekwds}' ";//名片公司名
                    break;
                case 2:
                    $keds = " a.status=1 AND b.card_industry = '{$typekwds}' ";//名片二级行业信息
                    break;
                case 3:
                    $keds = " a.status=1 AND b.card_job = '{$typekwds}' "; //名片职位信息
                    break;
                case 4:
                    $keds = " a.status=1 AND b.card_function = '{$typekwds}' ";//名片职能信息
                    break;
                case 5:
                    $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDMOBILEPROVINCE . '` as b on b.card_id = a.id  %s%s';
                    $keds = " a.status=1 AND b.mobile_province = '{$typekwds}' ";//地图
                    break;
                case 6:
                    $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDSHARE . '` as b on b.card_id = a.id  %s%s';
                    $keds = " a.status=1 AND b.card_id is NULL ";//分享名片使用
                    break;
                default:
                    return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                    break;
            }

        }

        //不管有没有别的只要有关键词就走搜索
        if(!empty($content)){
            $cardids                     = '';
            $starttime                   = $this->getTimestamp1();
            $this->collect               = $this->getcardids($content, $wechatId, $new);
            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
            if(!empty($this->collect)){
                $cardids = $this->i_array_column($this->collect, 'id');
                $cardids = implode(',', $cardids);
            }
            if(!empty($cardids)){
                $keds = " a.status=1 AND a.id in ({$cardids}) ";
                $sort = " order by field(cardid,{$cardids})";
            }else{
                $data = array('numfound' => 0, 'start' => 0, 'wechats' => array());

                return $this->renderJsonSuccess($data);
            }
        }
        if(!empty($keds)){
            $keds = " (" . $keds . ") ";
        }

        $starttime1 = $this->getTimestamp1();
        $sqldata    = array(
            'fields' => array(
                'cardid' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :cardid'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                'picpatha' => array('mapdb' => 'a.wechat_picture'),
                'picpathb' => array('mapdb' => 'a.wechat_picture_b'),
                'picture' => array('mapdb' => 'a.small_wechat_picture'),
                'vcard' => array('mapdb' => 'a.vcard'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'isself' => array('mapdb' => 'a.is_self', 'w' => ' AND a.is_self = :isself'),
                'upway' => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'batchid' => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus' => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'ocrstatus' => array('mapdb' => 'a.ocr_status', 'w' => ' AND a.ocr_status = :ocrstatus'),
                'ocr' => array('mapdb' => 'a.ocr_result'),
                'apptype' => array('mapdb' => 'a.app_type', 'w' => ' AND a.app_type = :apptype'),
                'uuid' => array('mapdb' => 'a.uuid', 'w' => ' AND a.uuid = :uuid'),
                'markpoint' => array('mapdb' => 'a.mark_point'),
                'deviceid' => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude' => array('mapdb' => 'a.longitude'),
                'latitude' => array('mapdb' => 'a.latitude'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),

                /*'userid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                'smallpicture' => array('mapdb' => 'a.small_wechat_picture'),
                'FN' => array('mapdb' => 'a.card_name', 'w' => ' AND a.card_name LIKE :FN'),
                'TITLE' => array('mapdb' => 'a.card_job', 'w' => ' AND a.card_job LIKE :TITLE'),
                'ORG' => array('mapdb' => 'a.card_company', 'w' => ' AND a.card_company LIKE :ORG'),
                'ADR' => array('mapdb' => 'a.card_address', 'w' => ' AND a.card_address LIKE :ADR'),
                'cardzipcode' => array('mapdb' => 'a.card_zipcode', 'w' => ' AND a.card_zipcode LIKE :cardzipcode'),
                'CELL' => array('mapdb' => 'a.card_telephone', 'w' => ' AND a.card_telephone = :CELL'),
                'TEL' => array('mapdb' => 'a.card_mobile', 'w' => ' AND a.card_mobile = :TEL'),
                'cardfax' => array('mapdb' => 'a.card_fax', 'w' => ' AND a.card_fax = :cardfax'),
                'INDUSTRY' => array('mapdb' => 'a.card_industry', 'w' => ' AND a.card_industry = :INDUSTRY'),
                'EMAIL' => array('mapdb' => 'a.card_emali', 'w' => ' AND a.card_emali = :EMAIL'),
                'URL' => array('mapdb' => 'a.card_company_url'),*/
            ),
            'default_dataparam' => array(),
            'sql' => "{$sql}",
            'where' => "{$keds}",
            'order' => "{$sort}",
            'provide_max_fields' => 'cardid,wechatid,picpatha,picpathb,picture,createdtime,modifytime,vcard,isself,startid,upway,batchid,buystatus,ocrstatus,apptype,ocr,uuid,markpoint,deviceid,longitude,latitude,status',);//userid,smallpicture,FN,TITLE,ORG,ADR,cardzipcode,CELL,TEL,cardfax,INDUSTRY,EMAIL,URL,
        $check      = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'wechats', 'callable_data_wechat');
        $cardid = intval(trim($request->get("cardid")));
        //针对 单张名片分享信息处理 20171025 qiuzhigang
        if(!empty($cardid)&&isset($cardid)&&$cardid>0){
            $shareInfo = $this->getConnection()->executeQuery("select * from `" . Tables::TBWEIXINCARDSHARE . "` WHERE card_id = :cardid", [':cardid' => $cardid])->fetch();
            $data['wechats'][0]['share'] = 0;
            if(!empty($shareInfo)&&isset($shareInfo)){
                $data['wechats'][0]['share'] = 1;
            }
        }
        $this->paramdata['getselect_time'] = $this->getTimestamp1() - $starttime1;

        return $this->renderJsonSuccess($data);
    }
    public function getwechatV2(){
        $this->checkAccountV2();
        $wechatId = $this->wechatId;
        $request   = $this->getRequest();
        $content  = $request->get('kwds'); //关键词
        $new      = intval($request->get('new', 0));//搜索类型

        if(empty($wechatId)){
            return $this->renderJsonSuccess();
        }
        $type     = intval($request->get('type', 0));//1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份 6可分享的名片
        $typekwds = $request->get('typekwds');
        $appType = $request->get('apptype', 0);//名片上传来源1、微信2、line3、其他

        $keds = ' a.status=1 AND a.card_type=1 ';//非任意扫（目前只有名片）
        if ($appType) {
            $keds .= " AND app_type=:apptype ";
        }
        $sort = ' ORDER BY a.created_time DESC';
        $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a %s%s';
        //如果有type有走连表
        if(!empty($type)){
            $sql = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDINDUSTRYFUNCTION . '` as b on b.card_id = a.id  %s%s';
            switch($type){
                case 1:
                    $keds = " a.status=1 AND b.card_company = '{$typekwds}' ";//名片公司名
                    break;
                case 2:
                    $keds = " a.status=1 AND b.card_industry = '{$typekwds}' ";//名片二级行业信息
                    break;
                case 3:
                    $keds = " a.status=1 AND b.card_job = '{$typekwds}' "; //名片职位信息
                    break;
                case 4:
                    $keds = " a.status=1 AND b.card_function = '{$typekwds}' ";//名片职能信息
                    break;
                case 5:
                    $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDMOBILEPROVINCE . '` as b on b.card_id = a.id  %s%s';
                    $keds = " a.status=1 AND b.mobile_province = '{$typekwds}' ";//地图
                    break;
                case 6:
                    $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a LEFT JOIN `' . Tables::TBWEIXINCARDSHARE . '` as b on b.card_id = a.id  %s%s';
                    $keds = " a.status=1 AND b.card_id is NULL ";//分享名片使用
                    break;
                default:
                    return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                    break;
            }

        }

        //不管有没有别的只要有关键词就走搜索
        if(!empty($content)){
            $cardids                     = '';
            $starttime                   = $this->getTimestamp1();
            $this->collect               = $this->getcardids($content, $wechatId, $new);
            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
            if(!empty($this->collect)){
                $cardids = $this->i_array_column($this->collect, 'id');
                $cardids = implode(',', $cardids);
            }
            if(!empty($cardids)){
                $keds = " a.status=1 AND a.id in ({$cardids}) ";
                $sort = " order by field(cardid,{$cardids})";
            }else{
                $data = array('numfound' => 0, 'start' => 0, 'wechats' => array());

                return $this->renderJsonSuccess($data);
            }
        }
        if(!empty($keds)){
            $keds = " (" . $keds . ") ";
        }

        $starttime1 = $this->getTimestamp1();
        $sqldata    = array(
            'fields' => array(
                'cardid' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :cardid'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                'picpatha' => array('mapdb' => 'a.wechat_picture'),
                'picpathb' => array('mapdb' => 'a.wechat_picture_b'),
                'picture' => array('mapdb' => 'a.small_wechat_picture'),
                'vcard' => array('mapdb' => 'a.vcard'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'isself' => array('mapdb' => 'a.is_self', 'w' => ' AND a.is_self = :isself'),
                'upway' => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'batchid' => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus' => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'ocrstatus' => array('mapdb' => 'a.ocr_status', 'w' => ' AND a.ocr_status = :ocrstatus'),
                'ocr' => array('mapdb' => 'a.ocr_result'),
                'apptype' => array('mapdb' => 'a.app_type', 'w' => ' AND a.app_type = :apptype'),
                'uuid' => array('mapdb' => 'a.uuid', 'w' => ' AND a.uuid = :uuid'),
                'markpoint' => array('mapdb' => 'a.mark_point'),
                'deviceid' => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude' => array('mapdb' => 'a.longitude'),
                'latitude' => array('mapdb' => 'a.latitude'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
            ),
            'default_dataparam' => array(),
            'sql' => "{$sql}",
            'where' => "{$keds}",
            'order' => "{$sort}",
            'provide_max_fields' => 'cardid,wechatid,picpatha,picpathb,picture,createdtime,modifytime,vcard,isself,startid,upway,batchid,buystatus,ocrstatus,apptype,ocr,uuid,markpoint,deviceid,longitude,latitude,status',);
        $check      = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        if ($appType) {
            $this->setParam('apptype', $appType);
            $sqldata['data'][':apptype'] = array($appType, \PDO::PARAM_INT);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'wechats', 'callable_data_wechat');
        $cardid = intval(trim($request->get("cardid")));
        //针对 单张名片分享信息处理 20171025 qiuzhigang
        if(!empty($cardid)&&isset($cardid)&&$cardid>0){
            $shareInfo = $this->getConnection()->executeQuery("SELECT * FROM `" . Tables::TBWEIXINCARDSHARE . "` WHERE card_id = :cardid", [':cardid' => $cardid])->fetch();
            $data['wechats'][0]['share'] = 0;
            if(!empty($shareInfo)&&isset($shareInfo)){
                $data['wechats'][0]['share'] = 1;
            }
        }
        $this->paramdata['getselect_time'] = $this->getTimestamp1() - $starttime1;

        return $this->renderJsonSuccess($data);
    }
    /**
     * 处理回显字段信息
     */
    protected function callable_data_wechat($item)
    {
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
