<?php

namespace Oradt\CommonBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\WeixinCard;
use Oradt\StoreBundle\Entity\WeixinUser;
use Oradt\StoreBundle\Entity\WeixinOtherPic;
use Oradt\StoreBundle\Entity\WxFiexdQrcode;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\RandomString;
use Oradt\Utils\Tables;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Oradt\ServiceBundle\Services\CurlService;
use Oradt\Utils\Str2PY;
use Oradt\Utils\SaveFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Oradt\StoreBundle\Entity\WeixinOrder;
use Oradt\StoreBundle\Entity\WeixinTagInfo;
use Oradt\StoreBundle\Entity\WeixinUnsubscribe;

class WeChatController extends BaseController {
    /**
     *搜索返回集
     *
     * @var type
     */
    protected $collect = array();
    private $request;
    private $wechatService;
    private $wechatid;


    public function getAction($act){
        $this->accesstime = $this->getTimestamp1();
        $this->request = Request::createFromGlobals();
        $this->wechatid = $this->request->get('wechatid');
        if(isset($this->wechatid)){
            $this->accountId = $this->wechatid;
        }

        switch($act){
            case 'getwechat'://获取微信名片
                return $this->getwechat();
                break;
            case 'getwechatcard'://获取微信名片
                return $this->getwechatcard();
                break;
            case 'getwechatuser'://获取用户信息
                return $this->getwechatuser();
                break;
            case 'otherpic'://微信任意扫 添加接口
                return $this->_getOtherOcrPic();
                break;
            case 'otherauto'://根据类型获取扫描数量
                return $this->_getOtherAuto();
                break;
            case 'getplace'://根据地址获取列表接口
                return $this->_getScanLocation();
                break;
            case 'getscans'://根据经纬度获取列表接口
                return $this->_getScansBylonglat();
                break;
            case 'anytag'://获取类型列表接口
                return $this->_getWxAnytag();
                break;
            case 'paylog'://获取支付记录
                return $this->_getOrderPayLog();
                break;
            case 'cardsbytag': //根据类型获取扫描数量
                return $this->_getOtherOcrPicBytag();
                break;
            case 'taginfo'://用户任意扫分类获取分类列表
                return $this->_getTagInfo();
                break;
            case 'qrcodeinfo'://获取微信固定二维码信息
                return $this->_getQrcodeInfo();
                break;
            case 'authuser'://获取企业员工信息
                return $this->_getAuthUserInfo();
                break;
            case 'test':
                return $this->testdemo();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /***
     * @deprecated
     * 用于数据迁移使用 更新UUID
     */
    private function testdemo(){
        set_time_limit(0);
        $sql = "select * from `weixin_card_2` WHERE  card_type = 2";
        $list = $this->getConnection()->executeQuery($sql)->fetchAll();
        $this->getManager()->beginTransaction();
        var_dump(" total :".count($list));
        try{
            foreach($list as $v){
                if($v['card_type']==2&&$v['old_pid']>0)
                $uuid = RandomString::make(32, Codes::C);
                //更新weixin_Card_2表
                $updateSql1 = "update `weixin_card_2` set `uuid` = '{$uuid}' WHERE id = {$v['id']}";
                $this->getConnection()->executeQuery($updateSql1);

                //更新anyscan_tags_card表
                $updateSql2 = "update `anyscan_tags_card` set `card_uuid` = '{$uuid}' WHERE `pic_id` = {$v['old_pid']} AND `batch_id`='anyscan'";
                $this->getConnection()->executeQuery($updateSql2);

                //更新anyscan_tags_card表
                $updateSql3 = "update `" . Tables::TBANYSCANFEATURECARD . "` set `card_uuid` = '{$uuid}' WHERE `pic_id` = {$v['old_pid']}  AND `batch_id`='anyscan'";
                $this->getConnection()->executeQuery($updateSql3);
            }
            $this->getManager()->commit();
            var_dump("uuid:".$uuid."  old+pid:".$v['old_pid']);
        }catch(\Exception $ex){
            $this->getManager()->rollback();
        }
        exit;
    }

    /***
     * @TODO 根据微信id和企业id查询用户认证信息
     * @param bizid string  企业id
     * @param wechatid string 用户微信id
     * @return Response
     * @version 0.0.1 2017-10-20
     * @Author qiuzhigang
     */
    private function _getAuthUserInfo(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $bizId    = $this->strip_tags($this->request->get('bizid')); //关键词
        if(empty($bizId) || !isset($bizId) || empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $this->wechatService = $this->container->get('wechat_service');
        //1、查询用户是否存在
        $wechatUser = $this->wechatService->getWeChatUserInfoById($this->wechatid);
        if(!isset($wechatUser) || empty($wechatUser)){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_NOTEXISTS_USER);
        }
        if(empty($wechatUser['bizid']) || $bizId != $wechatUser['bizid']){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $this->em = $this->getManager();
        $where    = "`biz_id` = :bizid AND `open_id` = :openid order by id desc limit 1 ";
        $sql      = "SELECT `biz_id`,`code`,`mobile`,`email`,`name`,`superior`,`department`,`created_time`,`enable`,`open_id`,`union_id`,`role_id`,`import_status`,`re_from`,`ident_status`,`ident_time` FROM `wx_biz_employee` WHERE " . $where;
        $params   = [':bizid' => $bizId, ':openid' => $this->wechatid];
        $result   = $this->em->getConnection()->executeQuery($sql, $params)->fetch();
        if(!isset($result) || empty($result)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        return $this->renderJsonSuccess($result);
    }

    /**
     * 获取微信名片
     */
    public function getwechat(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $content  = $this->request->get('kwds'); //关键词
        $new      = intval($this->request->get('new', 0));//搜索类型

        if(empty($this->wechatid)){
            return $this->renderJsonSuccess();
        }
        $type     = intval($this->request->get('type', 0));//1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份 6可分享的名片
        $typekwds = $this->request->get('typekwds');


        $keds = ' a.status=1 ';
        $sort = ' ORDER BY a.created_time DESC';
        $sql  = 'SELECT %s FROM `weixin_card` as a %s%s';
        //如果有type有走连表
        if(!empty($type)){
            $sql = 'SELECT %s FROM `weixin_card` as a LEFT JOIN `weixin_card_industry_function` as b on b.card_id = a.id  %s%s';
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
                    $sql  = 'SELECT %s FROM `weixin_card` as a LEFT JOIN `weixin_card_mobile_province` as b on b.card_id = a.id  %s%s';
                    $keds = " a.status=1 AND b.mobile_province = '{$typekwds}' ";//地图
                    break;
                case 6:
                    $sql  = 'SELECT %s FROM `weixin_card` as a LEFT JOIN `weixin_card_share` as b on b.card_id = a.id  %s%s';
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
            $this->collect               = $this->getcardids($content, $this->wechatid, $new);
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
        $cardid = intval(trim($this->request->get("cardid")));
        //针对 单张名片分享信息处理 20171025 qiuzhigang
        if(!empty($cardid)&&isset($cardid)&&$cardid>0){
            $shareInfo = $this->getConnection()->executeQuery("select * from `weixin_card_share` WHERE card_id = {$cardid}")->fetch();
            $data['wechats'][0]['share'] = 0;
            if(!empty($shareInfo)&&isset($shareInfo)){
                $data['wechats'][0]['share'] = 1;
            }
        }
        $this->paramdata['getselect_time'] = $this->getTimestamp1() - $starttime1;

        return $this->renderJsonSuccess($data);
    }
    public function getwechatV2(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $content  = $this->request->get('kwds'); //关键词
        $wechatid = $this->request->get('wechatid');
        $new      = intval($this->request->get('new', 0));//搜索类型

        if(empty($wechatid)){
            return $this->renderJsonSuccess();
        }
        $type     = intval($this->request->get('type', 0));//1名片公司名,2名片二级行业信息,3名片职位信息,4名片职能信息，5地图省份 6可分享的名片
        $typekwds = $this->request->get('typekwds');
        $appType = $this->request->get('apptype', 0);//名片上传来源1、微信2、line3、其他

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
            $this->collect               = $this->getcardids($content, $wechatid, $new);
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
        $cardid = intval(trim($this->request->get("cardid")));
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
     * 获取微信名片，根据批次号和名片ID查询
     * @return Response
     */
    public function getwechatcard(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $batchid  = intval($this->request->get('batchid'));
        if(empty($this->wechatid) || !$batchid){
            return $this->renderJsonSuccess();
        }

        $sqlCount = "SELECT COUNT(id) AS count FROM " . Tables::TBWEIXINCARD . " WHERE batchid=:batchid AND status=1";
        $countRes = $this->getConnection()->executeQuery($sqlCount, array(':batchid'=>$batchid))->fetch();
        if ($countRes['count'] > 0) {
            $count = $countRes['count'];
        } else {
            return $this->renderJsonSuccess();
        }

        $keds = ' a.status=1 ';
        $sort = ' ORDER BY a.created_time DESC';
        $sql  = 'SELECT %s FROM `' . Tables::TBWEIXINCARD . '` as a %s%s';

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
            'provide_max_fields' => 'cardid,wechatid,picpatha,picpathb,picture,createdtime,modifytime,isself,startid,batchid'
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'wechats', 'callable_data_wechat');
        $data['count'] = $count;
        //针对 单张名片分享信息处理 20171025 qiuzhigang
        /*$cardid = intval(trim($this->getRequest()->get("cardid")));
        if(!empty($cardid)&&isset($cardid)&&$cardid>0){
            $shareInfo = $this->getConnection()->executeQuery("select * from `" . Tables::TBWEIXINCARDSHARE . "` WHERE card_id = :cardid", [':cardid' => $cardid])->fetch();
            $data['wechats'][0]['share'] = 0;
            if(!empty($shareInfo)&&isset($shareInfo)){
                $data['wechats'][0]['share'] = 1;
            }
        }*/
        $this->paramdata['getselect_time'] = $this->getTimestamp1() - $starttime1;

        return $this->renderJsonSuccess($data);
    }

    /**
     * 处理回显字段信息
     */
    protected function callable_data_wechat($item){
        if(isset($item['cardid'])){
            $id = $item['cardid'];
        }else{
            $id = $item['id'];
        }
        $collect_info = $this->deep_in_array($id, $this->collect);
        $item['isfb'] = 'front';
        if($collect_info){
            $item['isfb'] = $collect_info['isfb'];
        }
        if(isset($this->collect['label'])){
            $item['label'] = $this->collect['label'];
        }

        return $item;
    }

    private function getcardids($kwds, $wechatid, $new = 0){
        $res = '';
        if($this->container->hasParameter('fullsearch')){
            $api_url = $this->container->getParameter('fullsearch') . "/CloudSearch/wechat/search";
            // /CloudSearch/wechat/search  /WeixinCard/sideresearch
        }else{
            return $res;
        }
        $post_string    = array('search_word' => $kwds, 'wechat_id' => $wechatid);
        $post_string    = json_encode($post_string);
        $params['text'] = $post_string;
        $curl           = new CurlService();
        $result         = $curl->exec($api_url, $params, 'post');
        self::ssLog('getcardids', $result);
        $result = json_decode($result, true);

        if(!empty($result['match_rel'])){
            $res = $result['match_rel'];
        }

        return $res;
    }

    /**
     *
     * @param type $value
     * @param type $array
     * @return boolean
     */
    private function deep_in_array($value, $array){
        foreach($array as $item){
            if(!is_array($item)){
                if($item == $value){
                    return $item;
                }else{
                    continue;
                }
            }

            if(in_array($value, $item)){
                return $item;
            }else if($this->deep_in_array($value, $item)){
                return $item;
            }
        }

        return false;
    }

    /**
     * 获取用户信息
     */
    private function getwechatuser(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $userid   = $this->request->get('userid');
        if(empty ($userid) && empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqldata = array('fields' => array(
            'userid' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :userid'),
            'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
            'accountid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :accountid'),
            'unionid' => array('mapdb' => 'a.union_id', 'w' => ' AND a.union_id = :unionid'),
            'wechatinfo' => array('mapdb' => 'a.wechat_info'),
            'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
            'modifiedtime' => array('mapdb' => 'a.modified_time', 'w' => 'Range'),
            'scannerinfo' => array('mapdb' => 'a.scanner_info'),
            'avatarpath' => array('mapdb' => 'a.avatar_path'),
            'bizid' => array('mapdb' => 'a.biz_id'),),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_user` as a %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'userid,wechatid,wechatinfo,createdtime,modifiedtime,scannerinfo,accountid,unionid,avatarpath,bizid',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'wechats', 'getBasic');

        return $this->renderJsonSuccess($data);

    }

    /**
     * @deprecated
     * @param $item
     * @return mixed
     */
    public function getBasic($item){
        $mobile = $realname = '';
        $userId = $item['accountid'];
        if(!empty($userId)){
            $sql    = "SELECT a.mobile,b.real_name as realname FROM account_basic as a LEFT JOIN account_basic_detail as b on a.user_id = b.user_id where a.user_id = '{$userId}';";
            $result = $this->getManager('api')->getConnection()->executeQuery($sql)->fetch();
            if(!empty($result)){
                $mobile   = isset($result['mobile']) ? (empty($result['mobile']) ? '' : $result['mobile']) : '';
                $realname = isset($result['realname']) ? (empty($result['realname']) ? '' : $result['realname']) : '';
            }
        }

        $item['mobile']   = $mobile;
        $item['realname'] = $realname;

        return $item;
    }

    /**
     * 获取其他图片OCR结果
     */
    public function _getOtherOcrPic(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $userid   = $this->request->get('userid');
        $content  = $this->request->get('kwds');   //搜索关键词
        if(empty ($userid) && empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //权限添加
        $where        = '';
        $order        = '';

        $sqldata      = array(
            'fields' => array(
                'id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'userid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                'type' => array('mapdb' => 'a.type', 'w' => ' AND a.type = :type'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'vcard' => array('mapdb' => 'a.vcard'),
                'picturea' => array('mapdb' => 'a.picturea'),
                'pictureb' => array('mapdb' => 'a.pictureb'),
                'thum' => array('mapdb' => 'a.picture_thum'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                'upway' => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'tag' => array('mapdb' => 'a.tag'),
                'batchid' => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus' => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'deviceid' => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude' => array('mapdb' => 'a.longitude'),
                'latitude' => array('mapdb' => 'a.latitude'),
                ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_other_pic` as a  %s%s",
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,userid,wechatid,type,createdtime,modifytime,vcard,picturea,pictureb,thum,status,upway,tag,batchid,buystatus,deviceid,longitude,latitude',);
        if(!empty($content)){
            $cardids      = '';
            $starttime    = $this->getTimestamp1();
            if(null==$this->wechatService){
                $this->wechatServer = $this->container->get('wechat_service');
            }
            $result       = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
            if(isset($result['match_rel']) && !empty($result['match_rel'])){
                $this->collect = $result['match_rel'];
            }

            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
            if(!empty($this->collect)){
                // 随机生成一条10位字符串
                $this->collect = array_map(function (&$v){
                    $v['elasid'] = RandomString::make(10);

                    return $v;
                }, $this->collect);
                // 如果不为空存入到临时表中
                $this->wechatServer->insertIntoElasTemp($this->collect);
                $elasids = $this->i_array_column($this->collect, 'elasid');
                $elasids = array_map(function (&$elasid){
                    return "'" . $elasid . "'";
                }, $elasids);
                $elasids = implode(',', $elasids);
            }
            if(!empty($elasids)){
                $cardids = trim($elasids, ',');
                $where   = " b.elasid IN ({$cardids}) ";
                $order   = " order by b.id ASC";
            }else{
                $data = array('numfound' => 0, 'start' => 0, 'wechats' => array());

                return $this->renderJsonSuccess($data);
            }
            $sqldata = array(
                'fields' => array(
                    'id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                    'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                    'userid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                    'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                    'type' => array('mapdb' => 'a.type', 'w' => ' AND a.type = :type'),
                    'picturea' => array('mapdb' => 'a.picturea'),
                    'pictureb' => array('mapdb' => 'a.pictureb'),
                    'thum' => array('mapdb' => 'a.picture_thum'),
                    'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                    'isfb' => array('mapdb' => 'b.isfb'),
                    ),
                'default_dataparam' => array(),
                'sql' => "SELECT %s FROM weixin_other_elas as b LEFT JOIN weixin_other_pic as a  on b.cardid = a.id %s%s",
                'where' => "" . $where,
                'order' => '' . $order,
                'provide_max_fields' => 'id,startid,userid,wechatid,type,picturea,pictureb,thum,status,isfb',);
            if(isset($result['label'])){
                $this->collect['label'] = $result['label'];
            }
        }
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        // $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'list', 'get_list_label');
        // 删除临时表
        if(!empty($content)){
            $this->wechatServer->deleteElasTemp();
        }

        return $this->renderJsonSuccess($data);
    }
    public function _getOtherOcrPicV2(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $userid   = $this->request->get('userid');
        $content  = $this->request->get('kwds');   //搜索关键词
        if(empty ($userid) && empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //权限添加
        $where        = '';
        $order        = '';

        $sqldata      = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'startid'     => array('mapdb' => 'a.id', 'w' => 'Range'),
                'wechatid'    => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                'cardtype'    => array('mapdb' => 'a.cardtype', 'w' => ' AND a.cardtype = :cardtype'),//【PS】原来的type改为现在cardtype
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime'  => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'vcard'       => array('mapdb' => 'a.vcard'),
                'picturea'    => array('mapdb' => 'a.wechat_picture'),
                'pictureb'    => array('mapdb' => 'a.wechat_picture_b'),
                'thum'        => array('mapdb' => 'a.small_wechat_picture'),
                'status'      => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                'upway'       => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'batchid'     => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus'   => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'deviceid'    => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude'   => array('mapdb' => 'a.longitude'),
                'latitude'    => array('mapdb' => 'a.latitude'),
            ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `{$this->tbWeixinCard}` as a  %s%s",
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,wechatid,cardtype,createdtime,modifytime,vcard,picturea,pictureb,thum,status,upway,batchid,buystatus,deviceid,longitude,latitude');
        if(!empty($content)){
            $cardids      = '';
            $starttime    = $this->getTimestamp1();
            if(null==$this->wechatService){
                $this->wechatServer = $this->container->get('wechat_service');
            }
            $result       = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
            if(isset($result['match_rel']) && !empty($result['match_rel'])){
                $this->collect = $result['match_rel'];
            }

            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
            if(!empty($this->collect)){
                // 随机生成一条10位字符串
                $this->collect = array_map(function (&$v){
                    $v['elasid'] = RandomString::make(10);

                    return $v;
                }, $this->collect);
                // 如果不为空存入到临时表中
                $this->wechatServer->insertIntoElasTemp($this->collect);
                $elasids = $this->i_array_column($this->collect, 'elasid');
                $elasids = array_map(function (&$elasid){
                    return "'" . $elasid . "'";
                }, $elasids);
                $elasids = implode(',', $elasids);
            }
            if(!empty($elasids)){
                $cardids = trim($elasids, ',');
                $where   = " b.elasid IN ({$cardids}) ";
                $order   = " order by b.id ASC";
            }else{
                $data = array('numfound' => 0, 'start' => 0, 'wechats' => array());

                return $this->renderJsonSuccess($data);
            }
            $sqldata = array(
                'fields' => array(
                    'id'       => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                    'startid'  => array('mapdb' => 'a.id', 'w' => 'Range'),
                    'userid'   => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                    'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                    //'type'     => array('mapdb' => 'a.type', 'w' => ' AND a.type = :type'),
                    'picturea' => array('mapdb' => 'a.wechat_picture'),
                    'pictureb' => array('mapdb' => 'a.wechat_picture_b'),
                    'thum'     => array('mapdb' => 'a.small_wechat_picture'),
                    'status'   => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),//【PS】status原来100正常，99删除，现在1、正常2、删除
                    'isfb'     => array('mapdb' => 'b.isfb'),
                ),
                'default_dataparam' => array(),
                'sql' => "SELECT %s FROM weixin_other_elas as b LEFT JOIN {$this->tbWeixinCard} as a  on b.cardid = a.id %s%s",
                'where' => "" . $where,
                'order' => '' . $order,
                'provide_max_fields' => 'id,startid,userid,wechatid,picturea,pictureb,thum,status,isfb');
            if(isset($result['label'])){
                $this->collect['label'] = $result['label'];
            }
        }
        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        // $this->setParam('function', __FUNCTION__);
        $data = $this->getData($sqldata, 'list', 'get_list_label');
        // 删除临时表
        if(!empty($content)){
            $this->wechatServer->deleteElasTemp();
        }

        return $this->renderJsonSuccess($data);
    }

    public function get_list_label($item){
        if(isset($this->collect['label'])){
            $item['label'] = $this->collect['label'];
        }

        return $item;
    }

    /**
     * @todo 获取任意扫关联字段
     */
    public function _getOtherAuto(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $content  = $this->request->get('kwds');
        if(empty($this->wechatid)){
            return $this->renderJsonSuccess();
        }
        $res          = '';
        if(null==$this->wechatService){
            $this->wechatServer = $this->container->get('wechat_service');
        }
        $result       = $this->wechatServer->searchFromElas($content, $this->wechatid, 3);
        if(isset($result['match_words'])){
            $res = $result['match_words'];
        }
        $data = array('lists' => $res);

        return $this->renderJsonSuccess($data);
    }

    /**
     * 获取位置
     */
    public function _getScanLocation(){
        $sqldata = array(
            'fields' => array(
                'id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'scanid' => array('mapdb' => 'a.scan_id', 'w' => ' AND a.scan_id = :scanid'),
                'location' => array('mapdb' => 'a.location'),
                'longitude' => array('mapdb' => 'a.longitude', 'w' => ' AND a.longitude = :longitude'),
                'latitude' => array('mapdb' => 'a.latitude', 'w' => ' AND a.latitude = :latitude'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'telephone' => array('mapdb' => 'a.telephone'),
                'address' => array('mapdb' => 'a.address'),
                ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_location` as a  %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'id,startid,scanid,location,longitude,latitude,createdtime,modifytime,telephone,address',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /**
     * @todo 根据经纬度获取范围内的扫描仪
     * @param str longitude  经度
     * @param str latitude   纬度
     * @param int dist       距离(单位m)
     */
    public function _getScansBylonglat(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $longitude = $this->request->get('longitude');
        $latitude  = $this->request->get('latitude');
        $start     = $this->request->get('start');
        $rows      = $this->request->get('rows');
        $dist      = $this->request->get('dist');
        if(empty ($longitude) || empty($latitude)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(empty($start)){
            $start = 0;
        }
        if(empty($rows)){
            $rows = 10;
        }
        $data = array('numfound' => 0,);
        $mk   = intval($dist);
        if(!$mk){
            $mk = $this->container->getParameter('MAP_DEFAULT_METRES');
        }
        $mapService        = $this->container->get("map_service");
        $m                 = $mapService->getAround($longitude, $latitude, $mk);
        $params[':latmin'] = $m[1];
        $params[':latmax'] = $m[3];
        $params[':logmin'] = $m[0];
        $params[':logmax'] = $m[2];
        $where             = ' WHERE a.latitude>:latmin AND a.latitude<:latmax AND a.longitude>:logmin AND a.longitude<:logmax';
        $order             = " ORDER BY ROUND(6378.138*2*ASIN(SQRT(POW(SIN(({$latitude}*PI()/180-a.latitude*PI()/180)/2),2)+COS({$latitude}*PI()/180)*COS(a.latitude*PI()/180)*POW(SIN(({$longitude}*PI()/180-a.longitude*PI()/180)/2),2)))*1000) ASC ";//排序
        $limit             = " LIMIT {$start},{$rows}";
        $sql               = " SELECT %s FROM weixin_location as a ";
        $sqlcount          = sprintf($sql . $where . $limit, 'COUNT(*)');
        $numfound          = intval($this->getConnection()->executeQuery($sqlcount, $params)->fetchColumn());
        if(!$numfound){
            return $this->renderJsonSuccess($data);
        }
        $data['numfound'] = $numfound;
        $fields           = " a.id,a.scan_id as scanid,a.location,a.longitude,a.latitude,a.created_time as createdtime,a.modify_time as modifytime ,a.telephone,a.address ";
        $lastsql          = sprintf($sql . $where . $order . $limit, $fields);
        $result           = $this->getConnection()->executeQuery($lastsql, $params)->fetchAll();
        $data['start']    = $start;
        $data['list']     = $result;

        return $this->renderJsonSuccess($data);

    }

    /**
     * @todo   获取任意扫标签
     * @return
     * @version 2017-8-2
     * @author xinggm
     */
    public function _getWxAnytag(){
        $sqldata = array(
            'fields' => array(
                'id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'tag' => array('mapdb' => 'a.tag', 'w' => ' AND a.tag = :tag'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_other_tag` as a  %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'id,tag,status,createdtime,modifytime',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /**
     * 获取支付记录
     */
    public function _getOrderPayLog(){
        $this->checkWxAccount();
        $sqldata = array('fields' => array(
            'id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
            'orderid' => array('mapdb' => 'a.order_id', 'w' => ' AND a.order_id = :orderid'),
            'wechatid' => array('mapdb' => 'b.open_id', 'w' => ' AND b.open_id = :wechatid'),
            'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
            'resultdata' => array('mapdb' => 'a.result_data'),
            'batchid' => array('mapdb' => 'b.batch_id', 'w' => ' AND b.batch_id = :batchid'),
            'paystatus' => array('mapdb' => 'b.paystatus', 'w' => ' AND b.paystatus = :paystatus'),
            'price' => array('mapdb' => 'b.price'),
            'type' => array('mapdb' => 'b.type', 'w' => ' AND b.type = :type'),
            'resultcode' => array('mapdb' => 'a.result_code'),),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_order_info` as a  LEFT JOIN weixin_order as b on a.order_id = b.order_id %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'id,orderid,wechatid,createdtime,resultdata,batchid,paystatus,price,type,resultcode',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /**
     * 获取任意扫同一批次分类数量
     */
    public function _getOtherOcrPicBytag(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $batchid  = $this->request->get('batchid');

        if(empty($batchid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqldata = array(
            'fields' => array(
                'wechatid' => array('mapdb' => " IF( ISNULL(b.wechat_id),'{$this->wechatid}',b.wechat_id ) "),
                'batchid' => array('mapdb' => " IF( ISNULL(b.batchid),'{$batchid}',b.batchid ) "),
                'type' => array('mapdb' => 'a.id'),
                'tag' => array('mapdb' => 'a.tag'),
                'numfound' => array('mapdb' => "IF( ISNULL(b.num),0,b.num )"),
                ),
                'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_other_tag` as a LEFT JOIN (SELECT *,COUNT(id) as num FROM weixin_other_pic  WHERE batchid = '{$batchid}' AND wechat_id = '{$this->wechatid}' GROUP BY type ) as b on a.id = b.type %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'wechatid,batchid,type,tag,numfound',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /***
     * 用户任意扫分类获取分类列表
     *
     * @return Response
     */
    public function _getTagInfo(){
        $sqldata = array(
            'fields' => array(
                'wechatid' => array('mapdb' => "a.wechat_id", 'w' => ' AND a.wechat_id = :wechatid'),
                'info' => array('mapdb' => 'a.tag_json'),
                'tag' => array('mapdb' => 'a.tag'),
                ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `weixin_tag_info` as a %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'wechatid,tag,info',);
        $check   = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /***
     * 获取设备二维码信息
     *
     * @return Response
     */
    private function _getQrcodeInfo(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $deviceSn = trim($this->request->get('device_sn'));
        if(empty($deviceSn)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $logger  = $this->get('logger');
        $sqldata = array(
            'fields' => array(
                'uuid' => array('mapdb' => "a.uuid", 'w' => ' AND a.uuid = :uuid'),
                'device_sn' => array('mapdb' => "a.device_sn", 'w' => ' AND a.device_sn = :device_sn'),
            ),
            'default_dataparam' => array(),
            'sql' => "SELECT %s FROM `wx_fiexd_qrcode` as a %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'ticket,uuid,scene_value,scene_type,device_sn,device_type',);

        $check = $this->parseSql($sqldata);
        $logger->info("_getQrcodeInfo parseSql info{}", $sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata);

        return $this->renderJsonSuccess($data);
    }


    public function postAction($act){
        $this->accesstime = $this->getTimestamp1();
        set_include_path(dirname(dirname(__DIR__)) . '/Utils/');
        require_once('Zend/Http/Client.php');
        $this->baseInit();
        $this->request = Request::createFromGlobals();
        $this->wechatid = $this->request->get('wechatid');
        if(isset($this->wechatid)){
            $this->accountId = $this->wechatid;
        }
        switch($act){
            case 'addcard'://公众号添加个人名片
                return $this->addcard();
                break;
            case 'wechatmodify'://修改名片
                return $this->wechatmodify();
                break;
            case 'deletecard'://删除微信名片
                return $this->deletecard();
                break;
            case 'wechatsavemany2'://批量保存
                return $this->wechatsavemany2();
                break;
            case 'bindingwechat'://绑定用户
                return $this->bindingwechat();
                break;
            case 'bindingwechat2'://绑定用户2
                return $this->bindingwechat();//bindingwechat2
                break;
            case 'edituser':
                return $this->bindingwechat();//_editWechatUser
                break;
            case 'wechatsave2'://保存微信数据2
                return $this->GearmanSave();
                break;
            case 'testocr':
                return $this->testOcr();//测试OCR是否正常使用
                break;
            case 'wechatpush'://发送消息
                return $this->WechatPush();
                break;
            case 'wechathandlepush'://处理消息
                return $this->WechatHandlePush();
                break;
            case 'devicepush':
                return $this->_devicePushToWechat(); //APP设备通知微信当前状态
                break;
            case 'otherpic'://微信任意扫添加接口
                return $this->_otherOcrPic();
                break;
            case 'order':
                return $this->_addWxOrder();        //微信公众号下单
                break;
            case 'ordertrade':
                return $this->_wxOrderTrading();    //微信公众号获取
                break;
            case 'times':
                return $this->_returnNowTime();     //返回扫描仪当前时间戳
                break;
            case 'taginfo':
                return $this->_addTagInfo();        //添加用户分类
                break;
            case 'inserttag':
                return $this->_insertTag();         //插入标签
                break;
            case 'qrcodeinfo':
                return $this->_addQrcodeInfo();        //添加微信二维码与设备的关系
                break;
            case 'wechatshare':
                return $this->_wechatshare();           //分享名片
                break;
            case 'unsubscribe':
                return $this->_unsubscribe();           //取消微信号关注
                break;
            case 'synccardtobiz':
                return $this->_syncwxcardtobiz();           //微信分享名片同步到企业 按照批次号
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     * @todo 根据企业id查询和微信id查询企业员工信息 认证用户和正式员工
     * @param $wechatid
     * @param $bizId
     * @return mixed
     */
    private function _checkWxBizEmployeeInfoByWechatIdAndBizId($wechatid, $bizId){
        $querySql = "SELECT * from `wx_biz_employee` WHERE `biz_id`='{$bizId}' AND `open_id`='{$wechatid}'  AND `enable`=1 limit 1";
        $res      = $this->getConnection()->executeQuery($querySql)->fetch();
        if(empty($res) || !isset($res)){
            $data = $this->getFailed(Errors::$ACCOUNT_EMPLOYEE_CONNOT_IDENT);
            $this->outputJson($data);
        }
        return $res;
    }

    /***
     * @TODO 微信分享名片同步到企业 根据批次号处理
     * @param wechatid string 微信openid
     * @param batchid string 微信名片扫描批次id
     * @return Response
     * @version 0.0.1 2017-10-20
     * @author qiuzhigang
     */
    public function _syncwxcardtobiz(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $batchId  = $this->strip_tags($this->request->get('batchid'));
        if(empty($this->wechatid) || empty($batchId)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $param = array(":wechatid" => $this->wechatid, ":batchid" => $batchId);

        $getUserSql = "SELECT a.* FROM weixin_user as a INNER JOIN weixin_card as b ON a.wechat_id=b.wechat_id  WHERE a.wechat_id=:wechatid AND b.batchid = :batchid limit 1";
        $res        = $this->getConnection()->executeQuery($getUserSql, $param)->fetch();
        if(empty($res) || empty($res['biz_id'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }

        $wxBizEmployeeInfo = $this->_checkWxBizEmployeeInfoByWechatIdAndBizId($this->wechatid, $res['biz_id']);

        $getUserMateSql = "SELECT * FROM wx_usermeta WHERE wechat_id=:wechatid  limit 1";
        $resMate        = $this->getConnection()->executeQuery($getUserMateSql, $param)->fetch();

        if(empty($resMate)){
            $insertMateSql = "INSERT INTO wx_usermeta (wechat_id,meta_key,meta_value,medified_time) VALUES(:wechatid,:batchid,1,:time)";
            $this->getConnection()->executeQuery($insertMateSql, array(":wechatid" => $this->wechatid, ":batchid" => $batchId, ":time" => $this->getTimestamp()));
        }else{
            $updateMateSql = "UPDATE wx_usermeta SET meta_key=:batchid,medified_time=:time WHERE id=:id";
            $this->getConnection()->executeQuery($updateMateSql, array(":batchid" => $batchId, ":time" => $this->getTimestamp(), ":id" => $resMate['id']));
        }

        $gearmanService = $this->container->get('gearman_service');
        $gearman_name   = $this->container->getParameter('gearman_wxcard_sync');
        $param          = array('batchid' => $batchId, 'bizid' => $res['biz_id'], 'userid' => $wxBizEmployeeInfo['id']);
        $gearmanService->push_job($gearman_name, $param);
        return $this->renderJsonSuccess($param);
    }

    /**
     * 添加新的标签
     */
    public function _insertTag(){
        $sql = "SELECT * FROM weixin_other_tag LIMIT 100; ";
        $res = $this->getConnection()->executeQuery($sql)->fetchAll();
        if(!empty($res)){
            return $this->renderJsonSuccess();
        }
        $values = '';
        $time   = $this->getTimestamp();
        $tag    = '';
        for($i = 1; $i <= 51; $i++){
            if(1 == $i){
                $tag = '银行卡类';
            }elseif(2 == $i){
                $tag = '名片类';
            }elseif(3 == $i){
                $tag = '票据类';
            }elseif(4 == $i){
                $tag = '车票类';
            }elseif(51 == $i){
                $i   = 999;
                $tag = '未分类';
            }else{
                $num = intval($i - 4);
                $tag = '类别' . $num;
            }
            $values .= "('{$tag}',0,{$time},{$time} ) ,";
        }
        $values = trim($values, ',');
        $sql    = " INSERT INTO weixin_other_tag (tag,status,created_time,modify_time) values {$values} ;";
        $this->getConnection()->executeUpdate($sql);

        return $this->renderJsonSuccess();
    }

    /**
     * 微信公众号下单支付
     */
    public function _addWxOrder(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $openId  = $this->strip_tags($this->request->get('openid'));      //openid 用户id
        $batchId = $this->strip_tags($this->request->get('batchid'));     //批次id
        $dec     = $this->strip_tags($this->request->get('dec'));         //商品描述
        $price   = $this->strip_tags($this->request->get('price'));      //价格
        $type    = $this->strip_tags($this->request->get('type'));        //订单类型
        $this->checkWxAccount();
        if(empty($openId) || empty($batchId) || empty($dec) || empty($price)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        //判断batchid存在否
        $params = [':batchid'=>$batchId,':wechatid'=>$openId];
        $sql      = " SELECT COUNT(*) FROM weixin_card as a where a.batchid = :batchid AND a.wechat_id = :wechatid AND a.buystatus = 1 ";
        $numfound = intval($this->getConnection()->executeQuery($sql,$params)->fetchColumn());
        if(!$numfound){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $price   = $price * $numfound;
        $orderId = 'W' . date('Ymd') . rand(10000000, 99999999);
        if(empty($type) || !in_array($type, array(1, 2))){
            $type = 1;
        }

        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $createTime = $this->getTimestamp();
            $wxorder    = new WeixinOrder();
            $wxorder->setOrderId($orderId);
            $wxorder->setBatchId($batchId);
            $wxorder->setOpenId($openId);
            $wxorder->setPaystatus(1);
            $wxorder->setPrice($price);
            $wxorder->setCreateTime($createTime);
            $wxorder->setEndTime(0);
            $wxorder->setTradeNo('');
            $wxorder->setType($type);
            $em->persist($wxorder);
            $em->flush();
            $returnArr = array('orderid' => $orderId);          //返回数组
            //调用微信支付接口下单
            $WxPayService = $this->container->get("weixin_pay_service");
            $wxResult     = $WxPayService->GetWxPublicNumOrder($orderId, $price, $dec, $openId);
            if(!$wxResult){
                return $this->renderJsonFailed(Errors::$OAUTH_ERROR_UNKNOWN);
            }
            $returnArr = array_merge($returnArr, $wxResult);
            $em->getConnection()->commit();

            return $this->renderJsonSuccess($returnArr);
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 微信订单获取
     */
    public function _wxOrderTrading(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $orderId  = $this->strip_tags($this->request->get('orderid'));          //订单Id
        if(empty($orderId)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $this->checkWxAccount();

        //查看订单是否存在
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $order = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinOrder')->findOneBy(array('orderId' => $orderId, 'openId' => $this->wechatid));
            if(empty($order)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $batchid = $order->getBatchId();
            $cardObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinCard')->findOneBy(array('batchid' => $batchid, 'wechatId' => $this->wechatid));
            if(empty($cardObj)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $orderStatue = $order->getPaystatus();     //订单状态
            if(!in_array($orderStatue, array(1,
                2))){    //未支付和已支付订单才能调用
                return $this->renderJsonFailed(Errors::$ORDER_STATUS_ERROR);
            }
            $orderType     = $order->getType();  //获取微信订单类型 1普通扫描名片2任意扫
            $orderTime     = $order->getCreateTime(); //订单生成时间
            $transactionId = $order->getTradeNo();
            $tradeState    = '';       //微信返回的交易状态
            //查询微信支付结果
            $WxPayService = $this->container->get("weixin_pay_service");
            $orderQuery   = $WxPayService->getWxPayOrderQuery($orderId, $transactionId, 'JSAPI');
            // 支付成功
            if(array_key_exists("return_code", $orderQuery) && $orderQuery["return_code"] == "SUCCESS"){

                if(array_key_exists("result_code", $orderQuery) && $orderQuery["result_code"] == "SUCCESS"){
                    $tradeState = $orderQuery["trade_state"];                   //微信交易状态
                    if($tradeState == 'SUCCESS'){   //表示支付成功
                        $transactionId = $orderQuery["transaction_id"];
                        $time          = $this->getTimestamp();
                        $order->setEndTime($time);
                        $order->setTradeNo($transactionId);
                        //更新订单状态 只有订单状态为 1 时执行
                        if($orderStatue == '1'){
                            $orderStatue = 2;
                            $order->setPaystatus($orderStatue);
                        }
                        // 根据订单类型修改支付状态 1普通名片2任意扫
                        $params = [':batchid'=>$batchid,':orderTime'=>$orderTime,':wechatid'=>$this->wechatid];
                        if(1 == $orderType){
                            $sql_card = "UPDATE `weixin_card` SET buystatus = 2 WHERE batchid= :batchid AND created_time < :orderTime AND wechat_id = :wechatid ;";
                        }else{
                            $sql_card = "UPDATE `weixin_other_pic` SET buystatus = 2 WHERE batchid= :batchid AND created_time < :orderTime AND wechat_id = :wechatid  ;";
                        }
                        $this->getConnection()->executeUpdate($sql_card,$params);
                        $result_data = json_encode($orderQuery, true);
                        $WxPayService->insertPayLog($orderId, $result_data, $orderQuery["result_code"]);
                    }
                }
            }
            $em->persist($order);
            $em->flush();
            $returnArr = array(
                'orderid' => $orderId, //订单id
                'status' => $orderStatue, //订单状态
                'paystatus' => $tradeState, //微信支付交易状态
                'tradeno' => $transactionId//微信订单号
            );
            $em->getConnection()->commit();

            return $this->renderJsonSuccess($returnArr);
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 添加个人名片
     * @return Response
     * @throws \Exception
     */
    public function addcard()
    {
        try{
            // 权限判断
            $this->checkWxAccount();
            $request  = $this->getRequest();
            $wechatid = $this->strip_tags($request->get('wechatid'));
            $picture   = $request->files->get('picture');//缩略图
            $picpatha  = $request->files->get('picpatha');//正面大图
            $picpathb  = $request->files->get('picpathb');//背面大图
            $vcard     = $this->strip_tags($request->get("vcard"));
            $uuid      = RandomString::make(32, Codes::C);

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
            /*if(!empty($vcardinfo)) {
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
            }*/

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
     * 删除个人名片
     * @return
     */
    public function deletecard(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $cardids = $this->strip_tags($this->request->get('cardid'));
        // 权限判断
        if(empty ($cardids) || empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        try{
            $cardidsArr = explode(",", $cardids);
            foreach ($cardidsArr as $cardid) {
                $params = array('id' => $cardid, 'status' => 1);
                if(!empty($this->wechatid)){
                    $params['wechatId'] = $this->wechatid;
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
                    $userObj = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy(array('wechatId' => $this->wechatid));
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

    /**
     * 修改个人名片
     * @return type
     */
    private function wechatmodify(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $cardid  = $this->request->get('cardid');
        $vcard   = $this->request->get('vcard');
        $oneself = $this->request->get('isself');

        // 权限判断
        $this->checkWxAccount();

        if(empty($cardid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $wechatinfo = $this->vcard2($vcard);
        if(empty($wechatinfo)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }

        $WeixinCard = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinCard')->findOneBy(array("id" => $cardid,'wechatId' => $this->wechatid));
        if(empty($WeixinCard)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        //更新库中的自己名片
        if($oneself == 1){
            $params = [':wechatid'=>$this->wechatid,':id'=>$cardid];
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
        $params[':wechatid'] = $this->wechatid;

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

    }

    /**
     *
     * @param type $wechatpicture
     * @param type $request
     * @return type
     */
    private function md5return($request){
        $wechatid        = $request->get('wechatid', 0);
        //$userid          = intval($request->get('userid', 0));
        $wechatpicture_a = $request->files->get('picpatha');
        $wechatpicture_b = $request->files->get('picpathb');

        $picturename_a  = $wechatpicture_a->getPathName();
        $picturenamemd5 = md5_file($picturename_a);
        $arr            = array(
            ':picturenamemd5' => $picturenamemd5,
            ':picturenamefmd5' => $picturenamemd5,
            ':wechatid' => $wechatid,
            //':userid' => $userid
        );
        if(!empty($wechatpicture_b)){
            $picturename_b           = $wechatpicture_b->getPathName();
            $picturenamemd5          .= ',' . md5_file($picturename_b);
            $picturenamemd5_arr      = explode(',', $picturenamemd5);
            $picturenamefmd5         = $picturenamemd5_arr[1] . ',' . $picturenamemd5_arr[0];
            $arr[':picturenamemd5']  = $picturenamemd5;
            $arr[':picturenamefmd5'] = $picturenamefmd5;
        }

        $sql  = "SELECT id as cardid,wechat_picture as picture,ocr_status as ocrstatus,wechat_picture as picpatha,wechat_picture_b as picpathb,ocr_result as ocr 
                  FROM weixin_card 
                  WHERE (md5_picture_name=:picturenamemd5 or md5_picture_name=:picturenamefmd5) and wechat_id = :wechatid LIMIT 1";//and user_id = :userid
        $data = $this->getConnection()->executeQuery($sql, $arr)->fetch();
        if(empty($data)){
            return $picturenamemd5;
        }

        return $data;
    }

    /**
     * @param String $key
     * @param number $len 汉字为3
     * @param string $separator
     * @return string
     */
    public $vcard_json = array();

    private function explodeItem($key, $len = 10, $ke = '', $k = '', $separator = ','){
        $str = $separator;
        if($ke == 'company'){
            if(!isset($this->vcard_json[$ke][$k][$key])) return '';
            foreach($this->vcard_json[$ke][$k][$key] as $k => $v){
                if($k < 4){
                    if(strlen($str . $v) >= $len) $str .= mb_substr($v . $separator, 0, $len, 'utf-8');else
                        $str .= $v . $separator;
                }
            }
        }else{
            if(!isset($this->vcard_json[$key])) return '';
            foreach($this->vcard_json[$key] as $k => $v){
                if(strlen($str . $v) >= $len) $str .= mb_substr($v . $separator, 0, $len, 'utf-8');else
                    $str .= $v . $separator;
            }
        }

        return trim($str, $separator);
    }

    //后期修改，此处相关card_开头的字段
    private function vcard2($data){
        $return = array(
            'name' => '', 'email' => '', 'job' => '', 'company_name' => '', 'address' => '',
            'card_zipcode' => '', //邮编没有
            'department' => '', 'telephone' => '', 'mobile' => '', 'fax' => '', 'web' => '',
            'card_industry' => '', //行业没有
            'wechat_card_xml' => '', //
            'vcard' => '');
        if(!empty($data)){
            $vcardJsonService = $this->container->get("vcard_json_service");
            $this->vcard_json = $vcardJsonService->loadVcard($data);

            foreach($this->vcard_json as $key => $val){
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

    /**
     * 微信绑定id
     *
     * @return type
     */
    private function bindingwechat(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $wechatinfo  = $this->request->get('info', '');
        $scannerinfo = $this->request->get('scannerinfo', '');
        $avatarpath  = $this->strip_tags($this->request->get('avatarpath'));//头像
        $userid      = $this->strip_tags($this->request->get('userid'));
        if(empty($userid)) {
            $userid = '';
        }
        if(empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        // 1、首先检验wechatinfo 是否为正确的格式，避免失效的情况
        $json_info = json_decode($wechatinfo, true);
        if(isset($json_info['errcode']) && !empty($json_info['errcode'])){
            $msg = isset($json_info['errmsg']) ? $json_info['errmsg'] : 'error';

            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, $msg);
        }
        $unionid = isset($json_info['unionid']) ? $json_info['unionid'] : '';
        $bizid   = $this->strip_tags($this->request->get('bizid'));
        $sbizid  = "";//字符串企业ID
        if(intval($bizid) > 0){
            $wxBizService = $this->container->get("wx_biz_service");
            $bizinfo      = $wxBizService->getBizInfoByID($bizid);
            if(!empty($bizinfo)){
                $sbizid = $bizinfo['biz_id'];
            }
        }
        //$this->getManager("api");
        if(!empty($unionid)){
            $accountres = $this->getManager("api")->getConnection()->executeQuery("SELECT account_id FROM `account_common` WHERE account=:unionid LIMIT 1", array(':unionid' => $unionid))->fetch();
            if(!empty($accountres)){
                $userid = $accountres['account_id'];
            }
        }

        $time = $this->getTimestamp();

        $weixinuser = $this->getDoctrine()->getRepository('OradtStoreBundle:WeixinUser')->findOneBy(array('wechatId' => $this->wechatid));
        //源来不存在，第一次实例化
        if(empty($weixinuser)){
            $weixinuser = new WeixinUser();
            $weixinuser->setWechatId($this->wechatid);
            $weixinuser->setCreatedTime($time);
            $weixinuser->setWechatInfo($wechatinfo);
            $weixinuser->setUserId($userid);
            $weixinuser->setBizId($sbizid);
            $weixinuser->setUnionId($unionid);
            $weixinuser->setAvatarPath('');
            $weixinuser->setScannerInfo('');
        }

        $em = $this->getDoctrine()->getManager(); //添加事务
        $em->getConnection()->beginTransaction();
        try{
            //微信登陆信息
            if(!empty($wechatinfo)){
                $weixinuser->setWechatInfo($wechatinfo);
            }
            //橙岽用户ID
            if(!empty($userid)){
                $weixinuser->setUserId($userid);
            }
            //微信唯一用户ID
            if(!empty($unionid)) {
                $weixinuser->setUnionId($unionid);
            }
            //企业ID
            if(!empty($sbizid)) {
                $weixinuser->setBizId($sbizid);
            }
            //扫描议信息
            if(!empty($scannerinfo)) {
                $weixinuser->setScannerInfo($scannerinfo);
            }
            //头像
            if(!empty($avatarpath)) {
                $weixinuser->setAvatarPath($avatarpath);
            }

            $weixinuser->setModifiedTime($time);

            $em->persist($weixinuser);
            $em->flush();
            $em->getConnection()->commit();
            $id   = $weixinuser->getId();
            $data = array('wechatid' => $this->wechatid, 'userid' => $id, 'user_id' => $id, 'bizid' => $sbizid);

            return $this->renderJsonSuccess($data);
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }

    }

    /**
     * 微信数据保存
     *
     * @return type
     * @throws \Exception
     */
    private function wechatsave2(){
        @set_time_limit(60);
        $starttimew      = $this->getTimestamp1();
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }

        $userid          = intval($this->request->get('userid', 0));
        $wechatpicture   = $this->request->files->get('picpatha');
        $wechatpicture_b = $this->request->files->get('picpathb');
        $language        = $this->request->files->get('language', 2);
        self::ssLog('picpatha_files', $wechatpicture);
        if(empty($this->wechatid) && empty($userid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(empty($wechatpicture)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //如果名片用户上传过，直接返回结果
        $data = $this->md5return($this->request);

        if(is_array($data)){
            //以前上传失败过
            if($data['ocrstatus'] > 0){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
            }
            $datas = $data;

            return $this->renderJsonSuccess($datas);
        }else{
            $md5picturename = $data;
        }
        self::ssLog('pic_null', 1);

        $data        = array();
        $ocr_service = $this->container->get('ocr_service1');
        $starttime   = $this->getTimestamp1();
        $data        = $ocr_service->run($wechatpicture, $language);

        self::ssLog('data', $data);
        self::ssLog('ocr_time', $this->getTimestamp1() - $starttime);//自己调用ocr花去的时间

        $dirs_upload    = $this->container->get('dirs_service');
        $starttimepa    = $this->getTimestamp1();
        $data['picurl'] = $dirs_upload->getFolderPath($data['upobject'], $this->wechatid, 'res', $this->wechatid, '_a');
        self::ssLog('picpatha_size', $data['upobject']->getClientSize()); //正面图片上传时间
        self::ssLog('picpatha_time', $this->getTimestamp1() - $starttimepa); //正面图片上传时间

        $starttimes = $this->getTimestamp1();
        if($data['status'] == 0){
            $data['smallwechatpicture'] = $dirs_upload->getThumbPath($data['filepath'], 600, 300);
        }else{
            $data['smallwechatpicture'] = '';
        }

        self::ssLog('small_time', $this->getTimestamp1() - $starttimes); //缩略图保存时间日志

        unset($data['upobject']);
        //如果有b面
        if(!empty($wechatpicture_b)){

            self::ssLog('pic_null', 2);
            $data_b = array();
            $data_b = $ocr_service->run($wechatpicture_b, $language);
            self::ssLog('data_b', $data_b);
            if(!empty($data_b['vcard'])){
                $data_b_vcard        = json_decode($data_b['vcard'], true);
                $data_bvcard['back'] = $data_b_vcard['front'];
                $starttimepb         = $this->getTimestamp1();
                $data_b['picurl']    = $dirs_upload->getFolderPath($data_b['upobject'], $this->wechatid, 'res', $this->wechatid, '_a');
                self::ssLog('picpathb_size', $data_b['upobject']->getClientSize()); //
                self::ssLog('picpathb_time', $this->getTimestamp1() - $starttimepb); //反面图片上传时间

                //A面B面都识别成功合并数据，A面成功B面不成功则只有front，A面不成功B面成功则front的数据来源B面识别的数据
                if(!empty($data['vcard']) && $data['status'] == 0){
                    $data['vcard'] = array_merge(json_decode($data['vcard'], true), $data_bvcard);
                    $data['vcard'] = json_encode($data['vcard']);
                }else{
                    $data['vcard']              = $data_b['vcard'];
                    $data['picurl']             = $dirs_upload->getFolderPath($data_b['upobject'], $this->wechatid, 'res', $this->wechatid, '_a');
                    $data['smallwechatpicture'] = $dirs_upload->getThumbPath($data_b['filepath'], 600, 300);
                }
                if($data['ocr_status'] != 0 && $data_b['ocr_status'] == 0){
                    $data['ocr_status'] = -1;
                }
            }

            self::ssLog('ocr_time_two', $this->getTimestamp1() - $starttime);//两次ocr总时间
        }

        $return = $this->vcard2($data['vcard']);

        self::ssLog('AWS_S3', $dirs_upload->s3_time); //

        $time = $this->getTimestamp();
        $em   = $this->getDoctrine()->getManager(); //添加事务
        $em->getConnection()->beginTransaction();
        try{
            $weixincard = new WeixinCard();

            $weixincard->setWechatId($this->wechatid);
            $weixincard->setCardType(1);

            /*$weixincard->setUserId($userid);
            $weixincard->setCardName($return['name']);
            $weixincard->setCardJob($return['job']);
            $weixincard->setCardCompany($return['company_name']);
            $weixincard->setCardAddress($return['address']);
            $weixincard->setCardZipcode($return['card_zipcode']);//
            $weixincard->setCardTelephone($return['telephone']);
            $weixincard->setCardMobile($return['mobile']);
            $weixincard->setCardFax($return['fax']);
            $weixincard->setCardCompanyUrl($return['web']);
            $weixincard->setCardEmali($return['email']);
            $weixincard->setCardIndustry($return['card_industry']);
            $weixincard->setWechatCardXml($return['wechat_card_xml']);
            $weixincard->setSearchPy('');
            $weixincard->setSearchCn('');*/

            $weixincard->setVcard($data['vcard']);
            $weixincard->setWechatPicture($data['picurl']);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime($time);
            $weixincard->setMd5PictureName($md5picturename);
            $weixincard->setSmallWechatPicture($data['smallwechatpicture']);
            $weixincard->setOcrStatus($data['ocr_status']);
            $weixincard->setOcrResult(json_encode($ocr_result, true));
            if(!empty($data_b['picurl'])){
                $weixincard->setWechatPictureB($data_b['picurl']);
            }else{
                $weixincard->setWechatPictureB('');
            }
            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();
            $id = $weixincard->getId();
            if($id){
                $return['cardid']   = $datas['cardid'] = $id;
                $return['wechatid'] = $this->wechatid;
                $return['picture']  = $datas['picpatha'] = $data['picurl'];
                if(!empty($data_b['picurl'])){
                    $datas['picpathb'] = $data_b['picurl'];
                }
                $return['created_time'] = $time;
                $return['modify_time']  = $time;
                // 同步es
                //$this->putesdatas($return);
                //异步矫正数据
                $kafkadata                  = json_encode(array('cardid' => $id, 'operation' => 'add'));
                $kafka_Fbusinesscardcorrect = '';
                if($this->container->hasParameter('kafka_fbusinesscardcorrect')){
                    $kafka_Fbusinesscardcorrect = $this->container->getParameter('kafka_fbusinesscardcorrect');
                }
                if(!empty($kafka_Fbusinesscardcorrect)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_Fbusinesscardcorrect, $kafkadata);
                    $kafkaService->disConnect();
                }

                self::ssLog('cardid', $id);// 日志完成的id
                self::ssLog('wechatsave_time', $this->getTimestamp1() - $starttimew);//自己调用ocr花去的时间


                if($data['status'] != 0 && empty($wechatpicture_b)){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
                }
                if($data['status'] != 0 && $data_b['status'] != 0){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
                }

                return $this->renderJsonSuccess($datas);
            }
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    private $cmd_path = '/home/ocrfile/';

    private function wechatsavemany2(){
        header("Cache-Control: no-cache, must-revalidate");
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-Type: multipart/form-data');
        flush();

        if($this->container->hasParameter('OCRFILE')){
            $this->cmd_path = $this->container->getParameter('OCRFILE');
        }

        $starttimed = $this->getTimestamp1();
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $userid     = intval($this->request->get('userid', 0));
        $picpatha   = $this->request->files->get('picpatha');
        $picpathb   = $this->request->files->get('picpathb');
        self::ssLog('getpictime', $this->getTimestamp1() - $starttimed);
        if(empty($this->wechatid) && empty($userid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(empty($picpatha)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //如果名片用户上传过，直接返回结果
        $data = $this->md5return($this->request);

        if(is_array($data)){
            //以前上传失败过
            if($data['ocrstatus'] > 0){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
            }
            $datas = $data;

            return $this->renderJsonSuccess($datas);
        }else{
            $md5picturename = $data;
        }
        self::ssLog('pic_null', 1);

        $gearmanService = $this->container->get('gearman_service');
        //图片A保存到公共目录
        $savef = new SaveFile($picpatha->getPathname(), $picpatha->getClientOriginalName());
        $fname = 'a_' . $picpatha->getFileName();
        $fpath = $this->cmd_path . $fname;
        $savef->copy($fpath);

        //图片A走gearman
        $starttime1 = $this->getTimestamp1();
        $gearOp     = array("fname" => $fname, "type" => "wechatOcr");
        $data       = $gearmanService->doNormal("WeChat", $gearOp);
        $data       = json_decode($data, true);
        self::ssLog('serveripa', $data['serverip']);
        self::ssLog('ocr_analysis_time', $this->getTimestamp1() - $starttime1);//ocr解析时间1

        //返回数据都是有图片的
        $dirs_upload = $this->container->get('dirs_service');
        $picpatha    = $this->pic($this->cmd_path . $data['fname']);

//        $logger->info('wechatsavemany2: fpath:'.$fpath."===picpatha==".json_encode($picpatha));
        @unlink($fpath);//删除老文件
        $picpatha_aws = $dirs_upload->getFolderPath($picpatha, 'wechat_aws', 'res', $this->wechatid, '_a');

        //如果有b面
        if(!empty($picpathb)){
            self::ssLog('pic_null', 2);
            //图片B保存到公共目录
            $savef = new SaveFile($picpathb->getPathname(), $picpathb->getClientOriginalName());
            $fname = 'a_' . $picpathb->getFileName();
            $fpath = $this->cmd_path . $fname;
            $savef->copy($fpath);
            //图片B走gearman
            $starttime1 = $this->getTimestamp1();
            $gearOp     = array("fname" => $fname, "type" => "wechatOcr");
            $datab      = $gearmanService->doNormal("WeChat", $gearOp);
            $datab      = json_decode($datab, true);
            self::ssLog('ocr_analysis_time_2', $this->getTimestamp1() - $starttime1);//ocr解析时间1
        }


        //如果有b面成功
        if(!empty($datab['vcard'])){
            self::ssLog('serveripb', $data['serverip']);
            $data_b_vcard        = json_decode($datab['vcard'], true);
            $data_bvcard['back'] = $data_b_vcard['front'];
            //
            $picpathb = $this->pic($this->cmd_path . $datab['fname']);
            @unlink($fpath);//删除老文件
            $picpathb_aws = $dirs_upload->getFolderPath($picpathb, 'wechat_aws', 'res', $this->wechatid, '_a');

            //A面B面都识别成功合并数据，A面成功B面不成功则只有front，A面不成功B面成功则front的数据来源B面识别的数据
            if(!empty($data['vcard'])){
                $data['vcard'] = array_merge(json_decode($data['vcard'], true), $data_bvcard);
                $data['vcard'] = json_encode($data['vcard']);
            }else{
                $data['vcard'] = $datab['vcard'];
                $picpatha_aws  = $picpathb_aws;
            }
            if($data['ocr_status'] != 0 && $datab['ocr_status'] == 0){
                $data['ocr_status'] = -1;
            }
        }

        //有效数据才生成缩略图
        if($picpatha_aws){
            $data['smallwechatpicture'] = $dirs_upload->getThumbPath($picpatha_aws, 600, 300);
        }else{
            $data['smallwechatpicture'] = '';
        }


        $time   = $this->getTimestamp();
        $return = $this->vcard2(array());
        $em     = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $weixincard = new WeixinCard();

            $weixincard->setWechatId($this->wechatid);
            $weixincard->setCardType(1);

            /*$weixincard->setUserId($userid);
            $weixincard->setCardName($return['name']);
            $weixincard->setCardJob($return['job']);
            $weixincard->setCardCompany($return['company_name']);
            $weixincard->setCardAddress($return['address']);
            $weixincard->setCardZipcode($return['card_zipcode']);//
            $weixincard->setCardTelephone($return['telephone']);
            $weixincard->setCardMobile($return['mobile']);
            $weixincard->setCardFax($return['fax']);
            $weixincard->setCardCompanyUrl($return['web']);
            $weixincard->setCardEmali($return['email']);
            $weixincard->setCardIndustry($return['card_industry']);
            $weixincard->setWechatCardXml($return['wechat_card_xml']);
            $weixincard->setSearchPy('');
            $weixincard->setSearchCn('');*/

            $weixincard->setVcard($data['vcard']);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime($time);
            $weixincard->setMd5PictureName($md5picturename);
            $weixincard->setSmallWechatPicture($data['smallwechatpicture']);
            $weixincard->setOcrStatus($data['ocr_status']);
            $weixincard->setWechatPicture($picpatha_aws);
            if(!empty($picpathb_aws)){
                $weixincard->setWechatPictureB($picpathb_aws);
                $datas['picpathb'] = $picpathb_aws;
            }else{
                $weixincard->setWechatPictureB('');
            }

            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();
            $id = $weixincard->getId();
            if($id){
                $return['cardid']   = $datas['cardid'] = $id;
                $return['wechatid'] = $this->wechatid;
                $return['picture']  = $datas['picpatha'] = $picpatha_aws;

                $return['created_time'] = $time;
                $return['modify_time']  = $time;

                //异步矫正数据
                $kafkadata = json_encode(array('cardid' => $id, 'operation' => 'add'));
                $kafka_Fbusinesscardcorrect = '';
                if($this->container->hasParameter('kafka_fbusinesscardcorrect')){
                    $kafka_Fbusinesscardcorrect = $this->container->getParameter('kafka_fbusinesscardcorrect');
                }
                if(!empty($kafka_Fbusinesscardcorrect)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_Fbusinesscardcorrect, $kafkadata);
                    $kafkaService->disConnect();
                }

                self::ssLog('cardid', $id);// 日志完成的id

                if($data['status'] != 0 && empty($picpathb)){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
                }
                if($data['status'] != 0 && $datab['status'] != 0){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR, " Identification failure ");
                }
                return $this->renderJsonSuccess($datas);
            }

        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }


    private function GearmanSave(){
        self::ssLog('start_time', $this->getTimestamp1());
        $starttimes = $this->getTimestamp1();
        @set_time_limit(60);
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        //$userid    = intval($request->get('userid', 0));
        $picpatha  = $this->request->files->get('picpatha');
        $picpathb  = $this->request->files->get('picpathb');
        $language  = $this->request->files->get('language', 2);
        $batchid   = $this->request->get('batchid');
        $iscut     = $this->strip_tags($this->request->get("iscut", 2)); //默认2裁切1不裁切
        $upway     = $this->strip_tags($this->request->get('upway', 1)); //默认1拍照2扫描
        $appType   = $this->strip_tags($this->request->get('apptype'));    //来源类型1、微信2、line3、其他
        $isreturn  = $this->strip_tags($this->request->get('isreturn'));   //是否返回识别结果1是，其他不返回
        $isself    = (int)$this->strip_tags($this->request->get('isself')); //0不属于自己1属于自己
        $deviceid  = $this->strip_tags($this->request->get('deviceid')); //设备id
        $longitude = floatval($this->strip_tags($this->request->get('longitude'))); //经度
        $latitude  = floatval($this->strip_tags($this->request->get('latitude')));  //纬度
        //self::ssLog('picpatha_files', $picpatha);
        if(empty($this->wechatid) /*&& empty($userid)*/ || empty($picpatha)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        /**
         * 1、验证wechaid是否存在
         */
        $sql_user = "SELECT user_id,id FROM weixin_user where wechat_id = :wechatid;";
        $res_user = $this->getConnection()->executeQuery($sql_user,[':wechatid'=>$this->wechatid])->fetch();
        // if (empty($res_user)) {
        //     return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        // }
        //如果名片用户上传过，直接返回结果
        $data_md5 = $this->md5return($this->request);

        if(is_array($data_md5)){
            //以前上传失败过
            //if($data_md5['ocrstatus'] > 0){
            //return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR," Identification failure ");
            //}
            return $this->renderJsonSuccess($data_md5);
        }else{
            $md5picturename = $data_md5;
        }
        $uuid = RandomString::make(32, Codes::C);
        self::ssLog('ocr_pic_start_time', $this->getTimestamp1());
        //组织文件存放目录
        $dirs_upload = $this->container->get('dirs_service');
        $user_dir    = 'wechat_aws/';
        if(!empty($this->wechatid)){
            $user_dir .= $this->wechatid;
        }/*else if(!empty($userid)){
            $user_dir .= $userid;
        }*/
        $dirs_upload->user_dir = $user_dir;

        $ocr_service  = $this->container->get('ocr_service');
        $json_service = $this->container->get('vcard_json_service');

        //mark点默认为空
        $markpoint = '';
        $vcard     = '';
        //start 正面
        //缩略图文件 ,默认取正面图
        $picture_file = '';

        //$ocr_data_a = $ocr_service->run($picpatha,$language);


        $ocr_status   = 0;
        $ocr_b_status = 0;
        if(isset($iscut) && in_array($iscut, array(1, 2))){
            $ocr_service->setIsCat($iscut); //是否裁切
        }
        //合并处理正反面
        $ocr_result = $ocr_service->runMulti($picpatha, $picpathb, $language);
        //处理正面
        if(!empty($ocr_result) && is_array($ocr_result) && isset($ocr_result['a'])){
            $ocr_data_a = $ocr_result['a'];
            $picpatha   = $ocr_data_a['upobject'];
            $vcard      = $ocr_data_a['vcard'];
            $markpoint  = $ocr_data_a['markpoint'];
            if($ocr_data_a['ocr_status'] == 0 && !empty($ocr_data_a['vcard'])){
                $isocr_vcard = true;
            }
            //缩略图文件 ,默认取正面图
            $picture_file = $ocr_data_a['filepath'];
            $ocr_status   = intval($ocr_data_a['ocr_status']);
        }
        $json_service->load($vcard);
        $a_ensum = $json_service->getEnSum();
        self::ssLog('ocr_result', json_encode($ocr_result));

        //start 背面->lo
        $pic_url_b = '';
        if(!empty($picpathb) && !empty($ocr_result) && is_array($ocr_result) && isset($ocr_result['b'])){
            $ocr_data_b   = $ocr_result['b'];
            $ocr_b_status = intval($ocr_data_b['ocr_status']);
            $picpathb     = $ocr_data_b['upobject'];
            if($ocr_b_status === 0 && $ocr_status !== 0){
                $ocr_status = -1;
                $vcard      = $ocr_data_b['vcard'];
                //正面ocr失败时，取反面图为缩略图
                $picpathb     = $picpatha;
                $picture_file = $ocr_data_b['filepath'];
                $picpatha     = $ocr_data_b['upobject'];

            }else{
                //合并正反面vcard 和 markpoint
                //check en name
                $json_service->load($ocr_data_b['vcard']);
                $b_ensum = $json_service->getEnSum();

                if($a_ensum > 0 && $ocr_b_status === 0 && !empty($ocr_data_b['vcard']) && $b_ensum < 1){
                    $vcard        = $ocr_service->merge_vcard($ocr_data_b['vcard'], $vcard);
                    $picpathb     = $picpatha;
                    $picpatha     = $ocr_data_b['upobject'];
                    $picture_file = $picpatha;
                }else{
                    $vcard = $ocr_service->merge_vcard($vcard, $ocr_data_b['vcard']);
                }
            }

            //上传背面
            $pic_url_b = $dirs_upload->getFolderPath($picpathb, $user_dir, 'res', $this->wechatid, '_b');

        }
        //上传正面图
        $pic_url_a = $dirs_upload->getFolderPath($picpatha, $user_dir, 'res', $this->wechatid, '_a');

        //end 背面
        /**
         * 取缩略图 */
        $picture = $dirs_upload->getThumbPath($picture_file, 600, 300);
        self::ssLog('ocr_pic_end_time', $this->getTimestamp1());
        $starttime1 = $this->getTimestamp1();
        self::ssLog('save_start_time', $this->getTimestamp1());
        //清除文件
        unlink($picpatha->getPathname());
        if(!empty($picpathb)) unlink($picpathb->getPathname());
        //清除文件结束
        /**
         * 添加到名片夹
         * 1、验证是否绑定橙子用户
         */
        $userId = '';
        if(isset($res_user['user_id'])){
            $userId = $res_user['user_id'];
        }
        $namepre               = ''; //名片名称首字母
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
        $time = $this->getTimestamp();
        //$return = $this->vcard2(array());
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $weixincard = new WeixinCard();
            $weixincard->setWechatId($this->wechatid);
            $weixincard->setCardType(1);
            $weixincard->setUuid($uuid);
            $weixincard->setVcard($vcard);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime($time);
            $weixincard->setMd5PictureName($md5picturename);
            $weixincard->setSmallWechatPicture($picture);
            $weixincard->setOcrStatus($ocr_status);
            $weixincard->setOcrResult('');//json_encode($ocr_result,true)2017-9-3日默认为空
            $weixincard->setWechatPicture($pic_url_a);
            $weixincard->setWechatPictureB($pic_url_b);
            if(!isset($upway) || empty($upway) || !in_array($upway, array(1, 2))){
                $upway = 1;
            }
            $weixincard->setUpway($upway);
            if(!isset($batchid)) $batchid = $this->getTimestamp1();
            $weixincard->setBatchid($batchid);
            $status = 1;
            if(1 == $upway){
                $status = 2;
            }
            if(!isset($appType) || empty($appType) || !in_array($appType, array(1, 2, 3))){
                $appType = 1;
            }
            if(2 == $appType){
                $status = 2;
            }
            $status = 2; //2017-8-25 ：默认都能看（默认都是支付的）
            $weixincard->setBuystatus($status);//购买状态1未购买2购买
            $weixincard->setAppTYpe($appType);
            $weixincard->setInitial($namepre);//首字母
            $weixincard->setMarkPoint($markpoint);//
            if(!in_array($isself, array(0, 1))){
                $isself = 0;
            }
            $weixincard->setIsSelf($isself);
            $weixincard->setDeviceId($deviceid);
            $weixincard->setLongitude($longitude);
            $weixincard->setLatitude($latitude);
            $weixincard->setStatus(1);
            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();
            $id = $weixincard->getId();
            if($id){
                $datas['cardid']   = $id;
                $datas['picpatha'] = $pic_url_a;
                if(!empty($pic_url_b)) $datas['picpathb'] = $pic_url_b;
                $datas['uuid'] = $uuid;
                //异步矫正数据
                $kafkadata                  = json_encode(array('cardid' => $id,
                    'operation' => 'add'));
                $kafka_Fbusinesscardcorrect = '';
                if($this->container->hasParameter('kafka_fbusinesscardcorrect')){
                    $kafka_Fbusinesscardcorrect = $this->container->getParameter('kafka_fbusinesscardcorrect');
                }
                if(!empty($kafka_Fbusinesscardcorrect)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_Fbusinesscardcorrect, $kafkadata);
                    $kafkaService->disConnect();
                }
                self::ssLog('save_end_time', $this->getTimestamp1());
                self::ssLog('cardid', $id);// 日志完成的id
                self::ssLog('total_time', $this->getTimestamp1() - $starttimes);
                self::ssLog('save_time', $this->getTimestamp1() - $starttime1);
                self::ssLog('end_time', $this->getTimestamp1());
                //无一ocr成功时，直接返回ocr识别失败
//    			if( ($ocr_status!== 0 && empty($picpathb)) ||
//    			     ($ocr_status!== 0 && $ocr_b_status !== 0) ){
//    				return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR," Identification failure ");
//    			}
                // userid 不为空保存名片并发kafka
                if(!empty($userId)){
                    $result = $accountContactService->syncWeCard($userId, $uuid, $vcard, $markpoint, $pic_url_a, $pic_url_a, $pic_url_b);
                    $accountContactService->kafkaContactCard();
                }
                if(1 == $isreturn){
                    $datas['ocr'] = json_encode($ocr_result, true);

                    return $this->renderJsonSuccess($datas);
                }

                return $this->renderJsonSuccess($datas);
            }

        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 测试OCR识别是否正常运行
     */
    public function testOcr(){
        self::ssLog('start_time', $this->getTimestamp1());
        $starttimes = $this->getTimestamp1();
        @set_time_limit(60);
        $request  = $this->getRequest();
        $picpatha = $request->files->get('picpatha');
        $picpathb = $request->files->get('picpathb');
        if(empty($picpatha) && empty($picpathb)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $wechatid = 'weixin1234567890';

        $ocr_service = $this->container->get('ocr_service');
        self::ssLog('ocr_pic_start_time', $this->getTimestamp1());
        $json_service = $this->container->get('vcard_json_service');
        $ocr_service->setIsCat(2);
        $ocr_result = $ocr_service->runMulti($picpatha, $picpathb, 2);

        self::ssLog('ocr_result', json_encode($ocr_result));
        //mark点默认为空
        $markpoint    = '';
        $vcard        = '';
        $ocr_status   = 0;
        $ocr_b_status = 0;
        //图片上传地址
        $dirs_upload = $this->container->get('dirs_service');
        $user_dir    = 'wechat_aws/';
        if(!empty($wechatid)){
            $user_dir .= $wechatid;
        }else if(!empty($userid)){
            $user_dir .= '1234567890';
        }
        $dirs_upload->user_dir = $user_dir;

        if(!empty($ocr_result) && is_array($ocr_result) && isset($ocr_result['a'])){
            $ocr_data_a = $ocr_result['a'];
            $picpatha   = $ocr_data_a['upobject'];
            $vcard      = $ocr_data_a['vcard'];
            $markpoint  = $ocr_data_a['markpoint'];
            if($ocr_data_a['ocr_status'] == 0 && !empty($ocr_data_a['vcard'])){
                $isocr_vcard = true;
            }
            //缩略图文件 ,默认取正面图
            $picture_file                = $ocr_data_a['filepath'];
            $ocr_status                  = intval($ocr_data_a['ocr_status']);
            $pic_url_a                   = $dirs_upload->getFolderPath($picpatha, $user_dir, 'res', $wechatid, '_a');
            $ocr_result['a']['filepath'] = $pic_url_a;
            unlink($picpatha->getPathname());
        }
        $json_service->load($vcard);
        $a_ensum = $json_service->getEnSum();


        //start 背面->lo
        $pic_url_b = '';
        if(!empty($picpathb) && !empty($ocr_result) && is_array($ocr_result) && isset($ocr_result['b'])){
            $ocr_data_b   = $ocr_result['b'];
            $ocr_b_status = intval($ocr_data_b['ocr_status']);
            $picpathb     = $ocr_data_b['upobject'];
            if($ocr_b_status === 0 && $ocr_status !== 0){
                $ocr_status = -1;
                $vcard      = $ocr_data_b['vcard'];
                //正面ocr失败时，取反面图为缩略图
                $picpathb     = $picpatha;
                $picture_file = $ocr_data_b['filepath'];
                $picpatha     = $ocr_data_b['upobject'];

            }else{
                //合并正反面vcard 和 markpoint
                //check en name
                $json_service->load($ocr_data_b['vcard']);
                $b_ensum = $json_service->getEnSum();

                if($a_ensum > 0 && $ocr_b_status === 0 && !empty($ocr_data_b['vcard']) && $b_ensum < 1){
                    $vcard        = $ocr_service->merge_vcard($ocr_data_b['vcard'], $vcard);
                    $picpathb     = $picpatha;
                    $picpatha     = $ocr_data_b['upobject'];
                    $picture_file = $picpatha;
                }else{
                    $vcard = $ocr_service->merge_vcard($vcard, $ocr_data_b['vcard']);
                }
            }
            $pic_url_b = $dirs_upload->getFolderPath($picpathb, $user_dir, 'res', $wechatid, '_b');
            unlink($picpathb->getPathname());
            $ocr_result['b']['filepath'] = $pic_url_b;
            //上传背面
        }
        self::ssLog('ocr_pic_end_time', $this->getTimestamp1());

        return $this->renderJsonSuccess($ocr_result);
    }

    private function pic($fpath){

        $pic1               = pathinfo($fpath);
        $pic2               = getimagesize($fpath);
        $pic                = $pic1 + $pic2;
        $clientoriginalname = $pic['basename'] . '.jpg';
        $clientmimetype     = $pic['mime'];
        $clientsize         = filesize($fpath);
        $savef              = new UploadedFile($fpath, $clientoriginalname, $clientmimetype, $clientsize);

        return $savef;
    }

    /**
     * 发送消息
     *
     * @return type
     */
    public function WechatPush(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $deviceid = $this->request->get('deviceid', 0);
        $info     = $this->request->get('info', 0);
        if(empty($deviceid) || empty($info)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $title = '微信推送';
        if(!empty($info)){
            $info    = json_decode($info, true);
            $batchid = $this->getTimestamp1();
            if(!empty($info)){
                $info['batchid'] = $batchid;
            }
            $info = json_encode($info, JSON_UNESCAPED_UNICODE);
        }
        $params['info'] = $info;
        $this->pushMessage(1000, $deviceid, $params, $deviceid, $title);

        return $this->renderJsonSuccess();
    }

    /**
     * 处理消息
     *
     * @return type
     */
    public function WechatHandlePush(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $messageid = $this->request->get('messageid', 0);
        $status    = intval($this->request->get('status', 2));
        if(empty($messageid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $params = [':status'=>$status,':id'=>$messageid];
        $this->getConnection()->executeQuery("UPDATE `message_queue_history` SET `status`= :status WHERE id= :id LIMIT 1",$params);

        $res = $this->getConnection()->executeQuery("select id,content from `message_queue_history` WHERE id={$messageid}  and `status` = 2 LIMIT 1")->fetch();;
        $data = '';
        if(!empty($res)){
            $weburl = '';
            if($this->container->hasParameter('WEB_HOST_URL')){
                $weburl = $this->container->getParameter('WEB_HOST_URL');
            }

            $content      = json_decode($res['content'], true);
            $content_info = json_decode(stripslashes($content['params']['info']), true);

            $api_url = $weburl . '/Demo/Wechat/scannerPushInfo';

            $curl   = new CurlService();
            $params = array(//'text' => $content_info['wechatid'],
                'openid' => $content_info['wechatid']);
            $data   = $curl->exec($api_url, $params, 'post');
        }

        return $this->renderJsonSuccess($data);
    }

    /**
     * @todo app设备提交信息，通知微信某账号可以进行下一步操作了
     * @param int $type 1、准备好了2、完成3、异常
     * @param str $wechatid 微信ID
     * @author xinggm
     * @version 2017-6-22
     * @return json
     */
    public function _devicePushToWechat(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $type     = intval($this->request->get('type', 1));
        if(empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        /**
         * 判断该微信是否存在
         */
        $sql       = "SELECT * FROM  weixin_user where id = :id ; ";
        $param     = array(':id' => $this->wechatid);
        $wechatObj = $this->getConnection()->executeQuery($sql, $param);
        $data      = '';
        // 微信存在就发布消息
        if($wechatObj){
            $weburl = '';
            if($this->container->hasParameter('WEB_HOST_URL')){
                $weburl = $this->container->getParameter('WEB_HOST_URL');
            }
            // 需调用web端地址来处理
            $api_url = $weburl . '/Demo/Wechat/scannerPushInfo';
            $curl    = new CurlService();
            $params  = array('text' => $type, 'openid' => $this->wechatid);
            //$em = $this->getDoctrine()->getManager(); //添加事物
            try{
                $data = $curl->exec($api_url, $params, 'post');
            }catch(\Exception $ex){
                //$em->getConnection()->rollback();
                throw $ex;
            }
        }

        return $this->renderJsonSuccess($data);
    }


    /***
     * 获取图片的Hash值 64位 注意：名令需要根据部署位置调整
     * @param $picpath
     * @return bool|string
     * @version 0.0.1 2017-10-25
     * @Author qiuzhigang
     */
    private function getPicHash($picpath){
        $command = "/home/pHash/pHash ".$picpath;
        $last_line = trim(shell_exec($command));
        return $last_line;
    }

    /**
     * @deprecated
     * 获取图片识别信息 暂未启用
     * @param $picpatha
     * @param $picpath
     * @version 0.0.1 2017-10-25
     * @Author qiuzhigang
     */
    private function getPictureRecognition($picpatha,$picpathb){
        if(empty($picpatha)&&empty($picpathb)){
            return "";
        }
        if($this->container->hasParameter('picture_recognition')){
            $api_url = $this->container->getParameter('picture_recognition');
        }else{
            return "";
        }
        $post_string    = array('pica' => $picpatha, 'picb' => $picpathb);
        $curl           = new CurlService();
        $result         = $curl->exec($api_url, $post_string, 'post');
        return $result;
    }


    /**
     *ocr处理其他图片并返回结果
     *
     * @todo 非名片图片
     * @version 2017-7-20
     */
    public function _otherOcrPic(){
        self::ssLog('start_time', $this->getTimestamp1());
        $starttimes = $this->getTimestamp1();
        @set_time_limit(60);
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $picpatha  = $this->request->files->get('picturea');
        $picpathb  = $this->request->files->get('pictureb');
        $upway     = $this->strip_tags($this->request->get('upway'));
        $test      = $this->request->get('test');
        $batchid   = $this->request->get('batchid');
        $deviceid  = $this->strip_tags($this->request->get('deviceid')); //设备id
        $longitude = floatval($this->strip_tags($this->request->get('longitude'))); //经度
        $latitude  = floatval($this->strip_tags($this->request->get('latitude')));  //纬度
        if(empty($picpatha) || empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $batchid = empty($batchid) ? $this->getTimestamp1() : $batchid;
        //1、首先判断微信id存不存在
        $sql    = "select id from `weixin_user` where wechat_id = :wechatid ";
        $userid = $this->getConnection()->executeQuery($sql,[':wechatid'=>$this->wechatid])->fetchColumn();
        if(empty($userid)){
            //return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            $userid = '0';
        }
        $ocr_service = $this->container->get('ocr_service');
        self::ssLog('ocr_pic_start_time', $this->getTimestamp1());
        ///2、OCR处理
        $ocr_result = $ocr_service->runOcrForOtherPic($picpatha, $picpathb, 2, $this->wechatid);
        self::ssLog('ocr_result', json_encode($ocr_result));
        $type      = isset($ocr_result['type']) ? $ocr_result['type'] : 0;
        $tag       = isset($ocr_result['tag']) ? $ocr_result['tag'] : '';
        $vcard     = isset($ocr_result['vcard']) ? $ocr_result['vcard'] : '';
        $status    = isset($ocr_result['status']) ? $ocr_result['status'] : '';
        $files     = isset($ocr_result['files']) ? $ocr_result['files'] : '';
        $pic_url_a = '';
        $pic_url_b = '';
        $pic_thum  = '';

        $ocr_hash_a = $ocr_hash_b='';
        if(!empty($files)){
            if(isset($files['a'])&&!empty($files['a']['path'])){
                $ocr_hash_a = $this->getPicHash($files['a']['path']);
            }

            if(isset($files['b'])&&!empty($files['b']['path'])){
                $ocr_hash_b = $this->getPicHash($files['b']['path']);
            }
        }


        //获取ocr_result中vcard信息
        $vcardArray = json_decode($vcard,true);

        $ocr_result_a = $ocr_result_b = '';
        if(!empty($vcardArray)){
            if(!empty($vcardArray['a'])&&isset($vcardArray)&&count($vcardArray['a'])>0){
                $ocr_result_a = json_encode($vcardArray['a'],JSON_UNESCAPED_UNICODE);
            }
            if(!empty($vcardArray['b'])&&isset($vcardArray['b'])&&count($vcardArray['b'])>0){
                $ocr_result_b = json_encode($vcardArray['b'],JSON_UNESCAPED_UNICODE);
            }
        }

        //组织文件存放目录
        $dirs_upload = $this->container->get('dirs_service');
        $user_dir    = 'wechat_aws/';
        if(!empty($this->wechatid)){
            $user_dir .= $this->wechatid;
        }else if(!empty($userid)){
            $user_dir .= $userid;
        }
        $dirs_upload->user_dir = $user_dir;
        // 3-1、图片a上传
        if(!empty($files) && is_array($files) && isset($files['a'])){
            $picpatha = $files['a']['obj'];
            // $picture_file = $ocr_data_a['path'];
            $pic_url_a = $dirs_upload->getFolderPath($picpatha, $user_dir, 'res', $this->wechatid, '_a');
            $pic_thum  = $dirs_upload->getThumbPath($picpatha, 600, 300);
            unlink($picpatha->getPathname());
            //上传正面
            self::ssLog('ocr_pic_end_time', $this->getTimestamp1());
        }
        // 3-2、图片b上传
        if(!empty($files) && is_array($files) && isset($files['b'])){
            $picpathb = $files['b']['obj'];
            // $picture_file = $ocr_data_a['path'];
            $pic_url_b = $dirs_upload->getFolderPath($picpathb, $user_dir, 'res', $this->wechatid, '_b');
            // 如果a不成功b成功，取b面做缩略图
            if(2 == $status){
                $pic_thum = $dirs_upload->getThumbPath($picpathb, 600, 300);
            }
            unlink($picpathb->getPathname());
        }

        $time = $this->getTimestamp();
        $em   = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $weixincard = new WeixinOtherPic();
            $weixincard->setWechatId($this->wechatid);
            $weixincard->setUserId($userid);
            $weixincard->setVcard($vcard);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime(0);
            $weixincard->setPicturea($pic_url_a);
            $weixincard->setPictureb($pic_url_b);
            $weixincard->setPictureThum($pic_thum);
            $weixincard->setType($type);
            $weixincard->setTag($tag);
            $weixincard->setStatus($status);
            if(!isset($upway) || empty($upway) || !in_array($upway, array(1, 2))){
                $upway = 1;
            }
            $weixincard->setUpway($upway);
            $weixincard->setBatchid($batchid);
            $weixincard->setBuystatus(1);//默认为未购买
            $weixincard->setDeviceId($deviceid);
            $weixincard->setLongitude($longitude);
            $weixincard->setLatitude($latitude);
            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();

            $id = $weixincard->getId();
            if($id){
                $kafkadata   = $kafkadata = json_encode(array('cardid' => $id, 'operation' => 'add'));
                $kafka_topic = '';
                if($this->container->hasParameter('kafka_any_scan')){
                    $kafka_topic = $this->container->getParameter('kafka_any_scan');
                }
                if(!empty($kafka_topic)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_topic, $kafkadata);
                    $kafkaService->disConnect();
                }
                $afInsertSql = "INSERT INTO `" . Tables::TBANYSCANFEATURE . "` (`batch`,`pic_id`,`ocr_result_a`,`ocr_result_b`,`ocr_hash_a`,`ocr_hash_b`) VALUES ('anyscan', :id , :ocr_result_a , :ocr_result_b , :ocr_hash_a , :ocr_hash_b )";
                $anyscan = [':id'=>$id,':ocr_result_a'=>$ocr_result_a,':ocr_result_b'=>$ocr_result_b,':ocr_hash_a'=>$ocr_hash_a,'ocr_hash_b'=>$ocr_hash_b];
                $this->getConnection()->executeQuery($afInsertSql,$anyscan);
//                $this->logger($afInsertSql,$userid,'weixin');
            }
            return $this->renderJsonSuccess($ocr_result);
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    public function _otherOcrPicV2(){
        self::ssLog('start_time', $this->getTimestamp1());
        $starttimes = $this->getTimestamp1();
        @set_time_limit(60);
        if(null==$this->request){
            $this->request =Request::createFromGlobals();
        }
        $picpatha  = $this->request->files->get('picturea');
        $picpathb  = $this->request->files->get('pictureb');
        $upway     = $this->strip_tags($this->request->get('upway'));
        $test      = $this->request->get('test');
        $batchid   = $this->request->get('batchid');
        $deviceid  = $this->strip_tags($this->request->get('deviceid')); //设备id
        $longitude = floatval($this->strip_tags($this->request->get('longitude'))); //经度
        $latitude  = floatval($this->strip_tags($this->request->get('latitude')));  //纬度
        if(empty($picpatha) || empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $batchid = empty($batchid) ? $this->getTimestamp1() : $batchid;
        //1、首先判断微信id存不存在
        $sql    = "select id from `weixin_user` where wechat_id = :wechatid";
        $userid = $this->getConnection()->executeQuery($sql, array(':wechatid' => $this->wechatid))->fetchColumn();
        if(empty($userid)){
            $userid = '0';
        }
        $ocr_service = $this->container->get('ocr_service');
        self::ssLog('ocr_pic_start_time', $this->getTimestamp1());
        ///2、OCR处理
        $ocr_result = $ocr_service->runOcrForOtherPic($picpatha, $picpathb, 2, $this->wechatid);
        self::ssLog('ocr_result', json_encode($ocr_result));
        $cardtype  = 2;//【PS】原来的type字段改为card_type，此处值为 2任意扫
        //$tag       = isset($ocr_result['tag']) ? $ocr_result['tag'] : '';
        $vcard     = isset($ocr_result['vcard']) ? $ocr_result['vcard'] : '';
        $status    = isset($ocr_result['status']) ? $ocr_result['status'] : '';
        $files     = isset($ocr_result['files']) ? $ocr_result['files'] : '';
        $pic_url_a = '';
        $pic_url_b = '';
        $pic_thum  = '';

        $ocr_hash_a = $this->getPicHash($files['a']['path']);
        $ocr_hash_b = $this->getPicHash($files['b']['path']);

        //获取ocr_result中vcard信息
        $vcardArray = json_decode($vcard,true);

        $ocr_result_a = $ocr_result_b = '';
        if(!empty($vcardArray)){
            if(!empty($vcardArray['a'])&&isset($vcardArray)&&count($vcardArray['a'])>0){
                $ocr_result_a = json_encode($vcardArray['a'],JSON_UNESCAPED_UNICODE);
            }
            if(!empty($vcardArray['b'])&&isset($vcardArray['b'])&&count($vcardArray['b'])>0){
                $ocr_result_b = json_encode($vcardArray['b'],JSON_UNESCAPED_UNICODE);
            }
        }

        //组织文件存放目录
        $dirs_upload = $this->container->get('dirs_service');
        $user_dir    = 'wechat_aws/';
        if(!empty($this->wechatid)){
            $user_dir .= $this->wechatid;
        }else if(!empty($userid)){
            $user_dir .= $userid;
        }
        $dirs_upload->user_dir = $user_dir;
        // 3-1、图片a上传
        if(!empty($files) && is_array($files) && isset($files['a'])){
            $picpatha = $files['a']['obj'];
            // $picture_file = $ocr_data_a['path'];
            $pic_url_a = $dirs_upload->getFolderPath($picpatha, $user_dir, 'res', $this->wechatid, '_a');
            $pic_thum  = $dirs_upload->getThumbPath($picpatha, 600, 300);
            unlink($picpatha->getPathname());
            //上传正面
            self::ssLog('ocr_pic_end_time', $this->getTimestamp1());
        }
        // 3-2、图片b上传
        if(!empty($files) && is_array($files) && isset($files['b'])){
            $picpathb = $files['b']['obj'];
            // $picture_file = $ocr_data_a['path'];
            $pic_url_b = $dirs_upload->getFolderPath($picpathb, $user_dir, 'res', $this->wechatid, '_b');
            // 如果a不成功b成功，取b面做缩略图
            if(2 == $status){
                $pic_thum = $dirs_upload->getThumbPath($picpathb, 600, 300);
            }
            unlink($picpathb->getPathname());
        }
        $uuid = RandomString::make(32, Codes::C);
        $time = $this->getTimestamp();
        $em   = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $weixincard = new WeixinCard();
            $weixincard->setWechatId($this->wechatid);
            $weixincard->setCardType($cardtype);
            $weixincard->setVcard($vcard);
            $weixincard->setCreatedTime($time);
            $weixincard->setModifyTime(0);
            $weixincard->setWechatPicture($pic_url_a);
            $weixincard->setWechatPictureB($pic_url_b);
            $weixincard->setSmallWechatPicture($pic_thum);
            $weixincard->setStatus($status);
            if(!isset($upway) || empty($upway) || !in_array($upway, array(1, 2))){
                $upway = 1;
            }
            $weixincard->setUpway($upway);
            $weixincard->setUuid($uuid);
            $weixincard->setBatchid($batchid);
            $weixincard->setBuystatus(1);//默认为未购买
            $weixincard->setDeviceId($deviceid);
            $weixincard->setLongitude($longitude);
            $weixincard->setLatitude($latitude);
            $em->persist($weixincard);
            $em->flush();
            $em->getConnection()->commit();

            $id = $weixincard->getId();
            if($id){
                $kafkadata   = $kafkadata = json_encode(array('cardid' => $id, 'operation' => 'add'));
                $kafka_topic = '';
                if($this->container->hasParameter('kafka_any_scan')){
                    $kafka_topic = $this->container->getParameter('kafka_any_scan');
                }
                if(!empty($kafka_topic)){
                    $kafkaService = $this->container->get('kafka_service');
                    $kafkaService->sendKafkaMessage($kafka_topic, $kafkadata);
                    $kafkaService->disConnect();
                }
                $afInsertSql = "INSERT INTO `" . Tables::TBANYSCANFEATURE . "` (`batch`,`pic_id`,`ocr_result_a`,`ocr_result_b`,`ocr_hash_a`,`ocr_hash_b`,`card_uuid`) VALUES ('anyscan', :id , :ocr_result_a , :ocr_result_b , :ocr_hash_a , :ocr_hash_b , :card_uuid )";
                $anyscan = [':id'=>$id,':ocr_result_a'=>$ocr_result_a,':ocr_result_b'=>$ocr_result_b,':ocr_hash_a'=>$ocr_hash_a,'ocr_hash_b'=>$ocr_hash_b,':card_uuid'=>$uuid];
                $this->getConnection()->executeQuery($afInsertSql,$anyscan);
            }
            return $this->renderJsonSuccess($ocr_result);
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 返回当前时间戳
     */
    public function _returnNowTime(){
        $time = $this->getTimestamp();
        $data = array('time' => $time,);

        return $this->renderJsonSuccess($data);
    }

    /**
     * 添加用户分类 用户任意扫分类
     */
    public function _addTagInfo(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $tag      = $this->request->get('tag');
        $tagJson  = $this->request->get('info');
        if(empty($this->wechatid) || empty($tagJson)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $time = $this->getTimestamp();
        $em   = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $tagInfo = new WeixinTagInfo();
            $tagInfo->setWechatId($this->wechatid);
            $tagInfo->setTag($tag);
            $tagInfo->setTagJson($tagJson);
            $tagInfo->setCreatedTime($time);
            $em->persist($tagInfo);
            $em->flush();
            $em->getConnection()->commit();

            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /***
     * @TODO 新增二维码
     * @return Response
     * @throws \Exception
     */
    private function _addQrcodeInfo(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $logger      = $this->get('logger');
        $ticket      = $this->request->get("ticket");
        $scene_value = $this->request->get("scene_value");
        $uuid        = $this->request->get("uuid");
        $scene_type  = $this->request->get("scene_type");
        $device_sn   = $this->request->get("device_sn");
        $device_type = $this->request->get("device_type", 0);

        if(empty($ticket) || empty($scene_value) || empty($ticket) || empty($uuid) || empty($scene_type)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $res = $this->getConnection()->executeQuery("select count(id) from `wx_fiexd_qrcode` WHERE `uuid`= :uuid  OR `device_sn` = :devicesn ",[':uuid'=>$uuid,':devicesn'=>$device_sn])->fetchColumn();

        if($res > 0){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
        }
        $logger->info('_addQrcodeInfo into BD start');
        $createTime = $this->getTimestamp();
        $em         = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $wxFiexdQrcode = new WxFiexdQrcode();
            $wxFiexdQrcode->setCreateTime($createTime);
            if(isset($device_sn)){
                $wxFiexdQrcode->setDeviceSn($device_sn);
            }
            if(isset($device_sn)){
                $wxFiexdQrcode->setDeviceType($device_type);
            }
            $wxFiexdQrcode->setSceneType($scene_type);
            $wxFiexdQrcode->setSceneValue($scene_value);
            $wxFiexdQrcode->setTicket($ticket);
            $wxFiexdQrcode->setUuid($uuid);
            $wxFiexdQrcode->setModifyTime($createTime);
            $em->persist($wxFiexdQrcode);
            $em->flush();
            $em->getConnection()->commit();
            $logger->info('_addQrcodeInfo into BD end ID:' . $wxFiexdQrcode->getId());

            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /***
     * 名片分享 批量分享与单张分享
     *
     * @param wechatid
     * @param cardid array 名片id数组
     * @author qiuzhigang 2017-10-12
     *
     */
    private function _wechatshare(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }

        $cardId   = $this->request->get("cardid");

        if(empty($cardId) || empty($this->wechatid) || !is_array($cardId)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $wechatService = $this->get('wechat_service');

        //1、查询用户是否存在
        $wechatUser = $wechatService->getWeChatUserInfoById($this->wechatid);
        if(!isset($wechatUser) || empty($wechatUser)){
            return $this->renderJsonFailed(Errors::$OAUTH_ERROR_NOTEXISTS_USER);
        }

        //2、判断用户的企业信息
        if(empty($wechatUser['bizid']) || strlen($wechatUser['bizid']) < 1){
            return $this->renderJsonFailed(Errors::$ERROR_NOT_HAVE_PERMISSION);
        }
        $bizid             = $wechatUser['bizid'];

        //获取员工id号
        $wxBizEmployeeInfo = $this->_checkWxBizEmployeeInfoByWechatIdAndBizId($this->wechatid, $bizid);
        $wxBizEmployeeId   = $wxBizEmployeeInfo['id'];

        //根据用户微信id与名片id查询数据 这个是该用户的
        $field         = "id";
        $wechatCardList = $wechatService->getWechatUserCardListByIds($cardId, $this->wechatid, $field);
        if(!isset($wechatCardList) || empty($wechatCardList)){
            return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS);
        }
        //剔除用户已分享的的名片id;
        $cardIds                = [];
        $wechatCardShareIdArray = $wechatService->getWechatCareShareColumnByCardIds($cardId, array('card_id'));
        foreach($wechatCardList as $card){
            if(is_array($wechatCardShareIdArray) && count($wechatCardShareIdArray) > 0){
                if(!in_array($card['id'], $wechatCardShareIdArray)){
                    $cardIds[] = $card['id'];
                }
            }else{
                $cardIds[] = $card['id'];
            }
        }
        if(empty($cardIds) || count($cardIds) < 1){
            return $this->renderJsonFailed(Errors::$RELATION_ERROR_VCARD_SHARED);
        }
        //执行批量同步
        $bizid  = $wechatUser['bizid'];
        $cardId = implode(',', $cardIds);
        $result = $this->_syncCardFromWxToBiz($this->wechatid, $cardId, $bizid, $wxBizEmployeeId);
        //权限问题
        if(is_array($result) && !empty($result['code']) && isset($result['code'])){
            return $this->renderJsonFailed($result['code']);
        }
        if(empty($result['success'])&&empty($result['beensync'])){
            //同步失败
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR);
        }
        $data = ['count' => (count($result['success']) + count($wechatCardShareIdArray)+count($result['beensync']))];

        return $this->renderJsonSuccess($data);
    }

    /**
     * @TODO 名片同步操作
     * @param $wechatId 用户微信openid
     * @param $cardId weixin_card 标准id字段
     * @param $bizid 企业id
     * @return array|int
     */
    private function _syncCardFromWxToBiz($wechatid, $cardIds, $bizid, $userId){
        //提交数据信息 同于企业同步
        $logger = $this->get('logger');//打印日志
        $logger->info("_syncCardFromWxToBiz start");
        $params['wxcardid'] = $cardIds;
        $params['wechatid'] = $wechatid;
        $params['bizid']    = $bizid;
        $params['userid']   = $userId;
        //$wxBiz              = $this->get('wx_biz_service');//new WxBizService();
        $commonBiz          = $this->get('common_service');
        $logger->info("_syncCardFromWxToBiz param:", array($params));
        $logger->info("syncCardFromWxToBizLots param:", array($params));
        $result = $commonBiz->syncCardFromWxToBizLots($params);
        $logger->info("syncCardFromWxToBizLots result info:", array($result));
        return $result;
    }

    /**
     * @TODO 取消微信
     * @param openid 用户微信openid
     */
    private function _unsubscribe(){
        if(null==$this->request){
            $this->request = Request::createFromGlobals();
        }
        $open_id = $this->request->get("open_id");
        $app_id  = $this->request->get("app_id");
        if(empty($open_id) || empty($app_id)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $createTime = $this->getTimestamp();
        $logger     = $this->get('logger');//打印日志
        $em         = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try{
            $weixinUnsubscribe = new WeixinUnsubscribe();
            $weixinUnsubscribe->setCreateTime($createTime);
            $weixinUnsubscribe->setOpenId($open_id);
            $weixinUnsubscribe->setAppId($app_id);
            $em->persist($weixinUnsubscribe);
            $em->flush();
            $em->getConnection()->commit();

            $logger->info('weixin unsubscribe:' . $open_id);

            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            //var_dump($ex->getMessage());
            $em->getConnection()->rollback();
            $logger->error("weixin unsubscribe error info: ", ['msg' => $ex->getMessage(), 'code' => $ex->getCode()]);
            throw $ex;
        }
    }
}