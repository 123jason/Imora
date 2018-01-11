<?php
/**
 * @var common_service
 */
namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\Utils\Errors;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\SecurityQuestionVerification;
use Oradt\Utils\Codes;
use Oradt\Utils\Tables;
use Oradt\Utils\Password;
use Oradt\Utils\RedisTrait;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\AccountTagmap;
use Oradt\StoreBundle\Entity\WxBizEmployee;
use Oradt\StoreBundle\Entity\WxBizDepartment;
use Oradt\StoreBundle\Entity\WxBizCard;
use Oradt\Utils\Str2PY;
use Doctrine\Common\Cache\FilesystemCache;

class CommonService extends BaseService
{
    public function __construct(EntityManager $entityManager, ContainerInterface $container) {
        parent::__construct($container);
    }

    /**
     * 待审核新同事入系统消息
     * 管理员可审核
     * @return mixed
     */
    public function auditEmployee($params)
    {
        $wxBizService = $this->container->get('wx_biz_service');
        $objid      = intval($params['emid']);//新员工ID
        $objInfo    = $wxBizService->getEmpById($objid);//新员工姓名
        $objname    = !empty($objInfo['name']) ? $objInfo['name'] : $objInfo['mobile'];
        $audit      = $params['audit'];//新员工所属公司管理员信息
        $sender     = intval($params['userid']);//创建新员工的员工ID即当前登录用户ID
        $sendeInfo  = $wxBizService->getEmpById($sender);
        $sendername = !empty($sendeInfo['name']) ? $sendeInfo['name'] : $sendeInfo['mobile'];//创建新员工的员工姓名
        $bizid      = $params['bizid'];//员工所属公司
        foreach ($audit as $value) {
            $receiver = $value['id'];
            $receivername = !empty($value['name']) ? $value['name'] : $value['mobile'];
            $data = array('sender'=>$sender, 'sendername'=>$sendername, 'receiver'=>$receiver,
                          'receivername'=>$receivername, 'objid'=>$objid, 'objname'=>$objname, 'bizid'=>$bizid);
            $this->insertIntoMsg($data, 3);
        }
    }

    /**
     * 生成系统消息
     * @param $data['sender']       系统消息发起人，type=1分享名片人 type=3为空或员工创建者
     * @param $data['sendername']   系统消息发起人姓名，type=1分享名片人 type=3为空或员工创建者
     * @param $data['receiver']     系统消息接收人，type=1名片分享接收人 type=3审核的新员工的公司管理员
     * @param $data['receivername'] 系统消息接收人姓名，type=1名片分享接收人 type=3审核的新员工的公司管理员
     * @param $data['objid']        操作对象ID：type=1时为名片ID，type=3时为员工ID
     * @param $data['objname']      操作对象名称
     * @param $data['bizid']        员工所属公司
     * @param $type                 消息类型，1名片分享 2任务协作 3待加入同事
     */
    public function insertIntoMsg($data, $type=1) {
        $sender       = $data['sender'];
        $sendername   = $data['sendername'];
        $receiver     = $data['receiver'];
        $receivername = $data['receivername'];
        $objid        = $data['objid'];
        $objname      = $data['objname'];
        $bizid        = $data['bizid'];
        $content      = json_encode(array('sender'=>$sender,'sendername'=>$sendername,'receiver'=>$receiver,'receivername'=>$receivername,'employeeid'=>$objid));
        $time = time();
        $sql = "INSERT INTO " . Tables::TBWXBIZMSG . " (type,sender,sender_name,receiver,receiver_name,obj_id,obj_name,biz_id,content,is_deal,status,create_time) 
                  VALUES({$type},{$sender},'{$sendername}',{$receiver},'{$receivername}',{$objid},'{$objname}','{$bizid}','{$content}',0,1,{$time})";
        $this->getConnection()->executeQuery($sql);
        return true;
    }

    /**
     * 同步微信名片到企业名片表
     * @param $data
     * @return int
     * @throws \Exception
     */
    public function setBizCard($data) {
        try{
            $bizid     = $data['bizid'];
            $userId    = $data['userid'];
            $vcard     = $data['vcard']; //vcard
            $markpoint = $data['mark_point'];//mark点
            $picture   = $data['small_wechat_picture'];//缩略图
            $picpatha  = $data['wechat_picture'];//正面大图
            $picpathb  = $data['wechat_picture_b'];//背面大图
            $remark    = '';//标签
            switch ($data['app_type']) {
                case 1:
                    $app_type = 'wechat';
                    break;
                case 2:
                    $app_type = 'line';
                    break;
                case 3:
                    $app_type = 'other';
                    break;
                default:
                    break;
            }
            $cardfrom = $app_type;//名片来源
            $cardtype = 'scan';//名片类型，扫描
            $wechatid = $data['wechat_id'];
            $cardid   = $data['id'];

            $WxBizCard = new WxBizCard();
            $uuid = $data['uuid'];//card_id
            $time = $this->getTimestamp();
            $vcardJsonService = $this->container->get("vcard_json_service");
            $vcardinfo = $vcardJsonService->setVcard($vcard);
            $vcards = '';
            $tel = '';
            $newtel = array();
            $this->em->getConnection()->beginTransaction();

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
                $EMAIL   = empty($vcardinfo['EMAIL']) ? '' : $vcardinfo['EMAIL'].',';
                $ORG     = empty($vcardinfo['ORG']) ? '' : $vcardinfo['ORG'].',';
                $ADR     = empty($vcardinfo['ADR']) ? '' : $vcardinfo['ADR'].',';
                $TITLE   = empty($vcardinfo['TITLE']) ? '' : $vcardinfo['TITLE'].',';
                $FN      = empty($vcardinfo['FN']) ? '' : $vcardinfo['FN'];
                $MOBILES = empty($vcardinfo['MOBILES']) ? '' : $vcardinfo['MOBILES'].',';
                $vcards  = $tel.$MOBILES.$EMAIL.$ORG.$ADR.$TITLE.$FN;
            }
            $WxBizCard->setBizId($bizid);
            $WxBizCard->setVcard($vcard);
            $WxBizCard->setUserId($userId);
            $WxBizCard->setCardId($uuid);
            $WxBizCard->setCardFrom($cardfrom);
            $WxBizCard->setMarkPoint($markpoint);
            $WxBizCard->setPicture($picture);
            $WxBizCard->setRemark($remark);
            $WxBizCard->setStatus('active');
            $WxBizCard->setCreateTime($time);
            $WxBizCard->setModifiedTime($time);
            $WxBizCard->setPicPathA($picpatha);
            $WxBizCard->setPicPathB($picpathb);
            $WxBizCard->setCardType($cardtype);
            $WxBizCard->setVcardtxt($vcards);
            $this->em->persist ( $WxBizCard );
            $this->em->flush ();
            $id = $WxBizCard->getId();
            if ($id) {
                $insertShareSql = "INSERT INTO " . Tables::TBWXBIZCARDSHARE . " (user_id,card_id,type,module_id,biz_id) VALUES(:userid,:cardid,:type,:moduleid,:bizid)";
                $res = $this->getConnection()->executeQuery($insertShareSql , array(':userid'=>$userId,':cardid'=>$id,':type'=>1,':moduleid'=>$userId,':bizid'=>$bizid));

                $sql = "SELECT id FROM " . Tables::TBWEIXINUSER . " WHERE wechat_id='{$wechatid}'";
                $wxuserInfo = $this->getConnection()->executeQuery($sql)->fetch();
                if (empty($wxuserInfo['id'])) {
                    $wxuserid = $userId;
                } else {
                    $wxuserid = $wxuserInfo['id'];
                }
                $wxuserid = $wxuserInfo['id'];
                $insertShareSql = "INSERT INTO " . Tables::TBWEIXINCARDSHARE . " (card_id,create_time) VALUES(:cardid,:createtime)";
                $this->getConnection()->executeQuery($insertShareSql , array(':cardid'=>$cardid,':createtime'=>time()));

                $this->em->getConnection()->commit();

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

                if ($res) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $ex){
            $this->em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 多张微信名片同步到企业名片表
     * @param $params
     * @return array|int
     * @throws \Exception
     */
    public function syncCardFromWxToBizLotsV1($params)
    {
        // 1、判断参数是否都有
        if (!isset($params['wxcardid']) || empty($params['wxcardid'])
            || !isset($params['wechatid']) || empty($params['wechatid'])
            || !isset($params['bizid']) || empty($params['bizid'])
            || !isset($params['userid']) || empty($params['userid'])) {
            return array('code' => Errors::$ERROR_PARAMETER_NOT_ENOUGH);//参数传递有误，请检查
        }
        $wxcardid = $this->strip_tags($params['wxcardid']);
        $wechatid = $this->strip_tags($params['wechatid']);
        $bizid    = $this->strip_tags($params['bizid']);
        $userId   = intval($params['userid']);//执行同步操作的登录用户ID
        $success  = $fail = $beenSync = array();

        try {
            $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE id IN ({$wxcardid}) AND wechat_id='{$wechatid}' AND status=1";
            $list = $this->getConnection()->executeQuery($sql)->fetchAll();
            foreach ($list as $key => $result) {
                if (!empty($result['uuid'])) {
                    $sql_2 = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE biz_id='{$bizid}' AND card_id='{$result['uuid']}'";
                    $result_2 = $this->getConnection()->executeQuery($sql_2)->fetch();
                    if (!empty($result_2)) {
                        $sql = "SELECT id FROM " . Tables::TBWEIXINCARDSHARE . " WHERE card_id={$result['id']}";
                        $result_4 = $this->getConnection()->executeQuery($sql)->fetch();
                        if (!isset($result_4['id'])) {
                            $time = time();
                            $insertSql = "INSERT INTO " . Tables::TBWEIXINCARDSHARE . " (card_id, create_time) VALUES ({$result['id']}, {$time})";
                            $this->getConnection()->executeQuery($insertSql);
                        }
                        $beenSync[] = $result['uuid'];//该名片已同步过
                        continue;
                    }
                }

                $uuid = $result['uuid'] ? $result['uuid'] : RandomString::make(32);//card_id
                $result['bizid'] = $bizid;
                $result['userid'] = $userId;
                $res = $this->setBizCard($result);
                if ($res) {
                    $success[] = $uuid;
                } else {
                    $fail[] = $uuid;
                }
            }
            return array('success' => $success, 'fail' => $fail, 'beensync' => $beenSync);
        } catch (\Exception $ex){
            throw $ex;
        }
    }
    public function syncCardFromWxToBizLots($params)
    {
        // 1、判断参数是否都有
        if (!isset($params['wxcardid']) || empty($params['wxcardid'])
            || !isset($params['wechatid']) || empty($params['wechatid'])
            || !isset($params['bizid']) || empty($params['bizid'])
            || !isset($params['userid']) || empty($params['userid'])) {
            return array('code' => Errors::$ERROR_PARAMETER_NOT_ENOUGH);//参数传递有误，请检查
        }
        $wxcardid = $this->strip_tags($params['wxcardid']);
        $wechatid = $this->strip_tags($params['wechatid']);
        $bizid    = $this->strip_tags($params['bizid']);
        $userId   = intval($params['userid']);//执行同步操作的登录用户ID
        $success  = $fail = $beenSync = array();

        try {
            $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE status=1 AND card_type=1 AND wechat_id=:wechatid AND find_in_set(id, :wxcardid)";
            $list = $this->getConnection()->executeQuery($sql, array(':wechatid' => $wechatid, ':wxcardid' => $wxcardid))->fetchAll();
            foreach ($list as $key => $result) {
                if (!empty($result['uuid'])) {
                    $sql_2 = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE biz_id=:bizid AND card_id=:cardid";
                    $result_2 = $this->getConnection()->executeQuery($sql_2, array(':bizid' => $bizid, ':cardid' => $result['uuid']))->fetch();
                    if (!empty($result_2)) {
                        $sql = "SELECT id FROM " . Tables::TBWEIXINCARDSHARE . " WHERE card_id={$result['id']}";
                        $result_4 = $this->getConnection()->executeQuery($sql)->fetch();
                        if (!isset($result_4['id'])) {
                            $time = time();
                            $insertSql = "INSERT INTO " . Tables::TBWEIXINCARDSHARE . " (card_id, create_time) VALUES (:cardid, :createtime)";
                            $this->getConnection()->executeQuery($insertSql, array(':cardid' => $result['id'], ':createtime' => $time));
                        }
                        $beenSync[] = $result['uuid'];//该名片已同步过
                        continue;
                    }
                }

                $uuid = $result['uuid'] ? $result['uuid'] : RandomString::make(32);//card_id
                $result['bizid'] = $bizid;
                $result['userid'] = $userId;
                $res = $this->setBizCard($result);
                if ($res) {
                    $success[] = $uuid;
                } else {
                    $fail[] = $uuid;
                }
            }
            return array('success' => $success, 'fail' => $fail, 'beensync' => $beenSync);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**
     * 微信名片同步到企业名片表，按批次同步
     * @return array|int
     * @throws \Exception
     */
    public function syncBatchCardFromWxToBizV1($params) {
        if (!isset($params['batchid']) || empty($params['batchid'])
            || !isset($params['bizid']) || empty($params['bizid'])
            || !isset($params['userid']) || empty($params['userid'])) {
            return array('code' => Errors::$ERROR_PARAMETER_NOT_ENOUGH);//参数传递有误，请检查
        }

        try {
            $success = $fail = $beenSync = array();
            $batchid = intval($params['batchid']);//批次号
            $bizid   = $this->strip_tags($params['bizid']);
            $userId  = intval($params['userid']);
            $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE batchid={$batchid} AND status=1";
            $result = $this->getConnection()->executeQuery($sql)->fetchAll();
            if (empty($result)) {
                return array('code' => Errors::$ERROR_PARAMETER_NOT_DATA);//该批次没有名片
            }

            //判断该名片是否已同步过，已同步过不再同步
            foreach ($result as $key => $value) {
                $sql_3 = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE biz_id='{$bizid}' AND card_id='{$value['uuid']}'";
                $result_3 = $this->getConnection()->executeQuery($sql_3)->fetch();
                if (!empty($result_3)) {
                    $sql = "SELECT id FROM " . Tables::TBWEIXINCARDSHARE . " WHERE card_id={$value['id']}";
                    $result_4 = $this->getConnection()->executeQuery($sql)->fetch();
                    if (!isset($result_4['id'])) {
                        $time = time();
                        $insertSql = "INSERT INTO " . Tables::TBWEIXINCARDSHARE . " (card_id, create_time) VALUES ({$value['id']}, {$time})";
                        $this->getConnection()->executeQuery($insertSql);
                    }
                    $beenSync[] = $value['uuid'];//该名片已同步过
                    unset($result[$key]);
                }
            }

            foreach ($result as $key => $value) {
                $uuid = $value['uuid'] ? $value['uuid'] : RandomString::make(32);//card_id
                $value['bizid'] = $bizid;
                $value['userid'] = $userId;
                $res = $this->setBizCard($value);
                if ($res) {
                    $success[] = $uuid;
                } else {
                    $fail[] = $uuid;
                }
            }
            return array('success' => $success, 'fail' => $fail, 'beensync' => $beenSync);
        } catch (\Exception $ex){
            throw $ex;
        }
    }
    public function syncBatchCardFromWxToBiz($params) {
        if (!isset($params['batchid']) || empty($params['batchid'])
            || !isset($params['bizid']) || empty($params['bizid'])
            || !isset($params['userid']) || empty($params['userid'])) {
            return array('code' => Errors::$ERROR_PARAMETER_NOT_ENOUGH);//参数传递有误，请检查
        }

        try {
            $success = $fail = $beenSync = array();
            $batchid = intval($params['batchid']);//批次号
            $bizid   = $this->strip_tags($params['bizid']);
            $userId  = intval($params['userid']);
            $sql = "SELECT * FROM " . Tables::TBWEIXINCARD . " WHERE batchid=:batchid AND status=1 AND card_type=1";
            $result = $this->getConnection()->executeQuery($sql, array(':batchid' => $batchid))->fetchAll();
            if (empty($result)) {
                return array('code' => Errors::$ERROR_PARAMETER_NOT_DATA);//该批次没有名片
            }

            //判断该名片是否已同步过，已同步过不再同步
            foreach ($result as $key => $value) {
                $sql_3 = "SELECT * FROM " . Tables::TBWXBIZCARD . " WHERE biz_id=:bizid AND card_id=:cardid";
                $result_3 = $this->getConnection()->executeQuery($sql_3, array(':bizid' => $bizid, ':cardid' => $value['uuid']))->fetch();
                if (!empty($result_3)) {
                    $sql = "SELECT id FROM " . Tables::TBWEIXINCARDSHARE . " WHERE card_id=:cardid";
                    $result_4 = $this->getConnection()->executeQuery($sql, array(':cardid' => $value['id']))->fetch();
                    if (!isset($result_4['id'])) {
                        $time = time();
                        $insertSql = "INSERT INTO " . Tables::TBWEIXINCARDSHARE . " (card_id, create_time) VALUES (:cardid, :createtime)";
                        $this->getConnection()->executeQuery($insertSql, array(':cardid' => $value['id'], ':createtime' => $time));
                    }
                    $beenSync[] = $value['uuid'];//该名片已同步过
                    unset($result[$key]);
                }
            }

            foreach ($result as $key => $value) {
                $uuid = $value['uuid'] ? $value['uuid'] : RandomString::make(32);//card_id
                $value['bizid'] = $bizid;
                $value['userid'] = $userId;
                $res = $this->setBizCard($value);
                if ($res) {
                    $success[] = $uuid;
                } else {
                    $fail[] = $uuid;
                }
            }
            return array('success' => $success, 'fail' => $fail, 'beensync' => $beenSync);
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    /**获取文档备注列表
     * @param $obj
     * @param $objType
     * @param null $owner
     * @param null $publisher
     * @return string
     */
    public function getCommentSql($obj, $objType, $owner=null, $publisher=null) {
        $sql = "SELECT %s FROM " . Tables::TBWEIXINDOCCOMMENT . " AS dc WHERE find_in_set(obj, :obj) AND obj_type=:objtype AND status=1";
        if (!empty($owner) || intval($owner)) {
            $sql .= " AND owner=:owner";
        }
        if (!empty($publisher) || intval($publisher)) {
            $sql .= " AND publisher=:publisher";
        }
        $sql .= " %s%s";
        return $sql;
    }

    /**
     * 获取文档备注详情
     * @param $id
     * @return mixed
     */
    public function getCommentInfo($id) {
        $sql = "SELECT * FROM " . Tables::TBWEIXINDOCCOMMENT . " WHERE id=:id";
        $comment = $this->getConnection()->executeQuery($sql, array(':id'=>$id))->fetch();
        return $comment;
    }

    /**
     * 查询企业员工
     * @param $bizid
     * @param string $depart
     * @param int $enable
     * @return array|mixed
     * @throws \Exception
     */
    public function getBizUser($bizid, $depart = '', $enable = 1) {
        try {
            $result = array();
            if (!empty($depart)) {//查询企业下指定部门的员工
                $param = array(':bizid' => $bizid, ':depart' => $depart, ':enable' => $enable);
                $sql = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE biz_id=:bizid AND department=:depart AND `enable`=:enable";
            } else {
                $param = array(':bizid' => $bizid, ':enable' => $enable);
                $sql = "SELECT * FROM " . Tables::TBWXBIZEMPLOYEE . " WHERE biz_id=:bizid AND `enable`=:enable";
            }
            $result = $this->getConnection()->executeQuery($sql, $param)->fetchAll();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function getBizDepartment($bizid, $parentid = 'all', $isdel = 0) {
        try {
            $result = array();
            if ($parentid != 'all') {//查询企业下指定部门
                $param = array(':bizid' => $bizid, ':isdel' => $isdel);
                $sql = "SELECT * FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE biz_id=:bizid AND `is_del`=:isdel";
            } else {
                $param = array(':bizid' => $bizid, ':parentid' => $parentid, ':isdel' => $isdel);
                $sql = "SELECT * FROM " . Tables::TBWXBIZDEPARTMENT . " WHERE biz_id=:bizid AND parent_id=:parentid AND `is_del`=:isdel";
            }
            $result = $this->getConnection()->executeQuery($sql, $param)->fetchAll();
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }

    public function doTables() {
        try {
            $result = '';
            $sql = "SHOW TABLES";
            $resultTable = $this->getConnection()->executeQuery($sql)->fetchAll();
            foreach ($resultTable as $key => $value) {
                $KEY = "TB".mb_strtoupper(str_replace("_", "", $value['Tables_in_wechatdb']));
                $VALUE = $value['Tables_in_wechatdb'];
                $table[] = "const {$KEY} = '{$VALUE}';";
                $result .= "const {$KEY} = '{$VALUE}';\r\n";
            }
            return $result;
        } catch (\Exception $ex){
            throw $ex;
        }
    }
}
