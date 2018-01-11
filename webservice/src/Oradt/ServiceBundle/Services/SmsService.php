<?php

namespace Oradt\ServiceBundle\Services;

use Oradt\Utils\RandomString;
use Oradt\Utils\Errors;
use Oradt\StoreBundle\Entity\SmsMessage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SmsService extends BaseService {
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    /**
     * 发送短信，通过接口切换，可任意选中某个通道
     * @param type $mobile
     * @param type $content
     * 注：目前只有密码重置 使用这个方法 其他的都用 sendSmsByType 这个方法 
     */
    public function sendSms($mobile, $content, $module)
    {
        $globalBase = $this->container->get('global_base');

        $random = new RandomString();
        $smsId = $random->make(32);   //获取32位字符串ID
        $code = $random->randomNum(); //获得4位随机数字验证码
        //短信内容
        $content = sprintf($content, $code);
        //基本信息赋值
        $emailMessage = array(
            'SmsId' => $smsId, //ID
            'Mobile' => $mobile, //手机号码
            'Type' => 'verify', //类型
            'Content' => $code, //内容
            'CreatedTime' => $this->getDateTime(), //创建时间,
            'Module'    => $module,        //验证模块,
            'Status'    => '0'              //短信发送状态
        );
        //添加数据
        $rs = $globalBase->execute($emailMessage, new SmsMessage());
        $data = false;
        if ($rs) {
            //$data = array('messageid' => $smsId);
            #短信接口配置，1华兴软通，2亿美软通
            $smsType = $this->container->getParameter('SMS_ID');
            if ($smsType === 1) {
                //华兴软通
                $smsService = $this->container->get('file_hx_sms_service');
                $result = $smsService->sendSms($mobile, $content);
            } else {
                //亿美软通
                $smsService = $this->container->get('file_ym_sms_service');
                $result = $smsService->sendSms($mobile, $content);
                //$result = $smsService->getBalance();                          //查询余额
            }
            //通过成功状态返回成功信息
            if (strpos($result, 'result=0') !== FALSE || $result == 0) {
                $data = array('messageid' => $smsId);
            } else {
                $data = $result;
            }
            //记录第3方发送日志
            $smsContent = $globalBase->findOneBy('SmsMessage',array("smsId"=>$smsId));
            if(!empty($smsContent)){
                $globalBase->update(array('Status'=>$result), new SmsMessage(), $smsContent);
            }
            //记录发送日志
            $this->logger->info($this->container->get('request')->getClientIp() . '  /verification/sms  messageid：' . $smsId . '-----mobile：' . $mobile . '-----content：' . $content . '-----return：' . $result);           
        }
        return $data;
    }
    
    
    
    /**
     * 发送短信方法封装（支持国内和国外）
     * @param string $mcode     国内外手机号区号
     * @param string $mobile    手机号不带区号
     * @param string $content   短信内容
     * @param string $module    发送短信模块（比如：注册等等）
     * @param string $ifsendSms 是否真的发送短信（默认发送，可不发）
     */
    public $sendSmsType   = 'verify';           //发送短信类型 verify 验证类  text 文本类
    public $ifCheckIpBlacklist  = true;        //是否检测ip 黑名单 （默认检测，不检测可在外面配置）
    public $setSendSmsAccount   = NULL;        //设置发送短信的通道的账号（目前亿美有3个账号主账号短信验证，有营销账号等）
    public $isAbroadMobile      = false;       //是否是国外的手机号默认false(国内)
    public function sendSmsByTypeNew($mcode,$mobile,$content,$module,$ifsendSms=true){
        $ip='';
        //检查ip黑名单
        if($this->ifCheckIpBlacklist == true){
            $ip = $this->get_real_ip();
            //查看是否是黑名单
            $ipsql = "SELECT id FROM ip_blacklist WHERE ip =:ip;";
            $ipCon = $this->getManager("api")->getConnection()->executeQuery($ipsql, array("ip"=>$ip))->fetch();
            if(!empty($ipCon)){
                return 1;
            }
        }
        //判断国内或国外手机号
        if($mcode != '86'){
            $this->isAbroadMobile = true;
        }
        $random = new RandomString();
        $smsId  = $random->make(32);   //获取32位字符串ID
        //短信内容
        if($this->sendSmsType == 'verify' ){
            $code = $random->randomNum(6);           //获得6位随机数字验证码
            $content = sprintf($content, $code);     //短信内容
            $insertContent = $code;
        }elseif($this->sendSmsType == 'text'){
            $content = sprintf('【橙脉APP】%s', $content);
            $insertContent = $content;
        }else{
            return FALSE;
        }
        $mobile      = $mcode.$mobile;   //手机号和区号绑定
        $fseqId      = $this->getTimestamp();
        $createdTime = $this->getDateTime()->format("Y-m-d H:i:s");
        $params = array( 
            ':smsid'    => $smsId,         //ID
            ':mobile'   => $mobile,        //手机号码 区号.手机号 （上面已处理）
            ':type'     => $this->sendSmsType,  //类型
            ':content'  => $insertContent,      //内容
            ':createdtime'  => $createdTime,    //创建时间,
            ':module'       => $module,                 //验证模块
            ':fseqid'       => $fseqId,   //短信唯一标示，获取短信发送报告时使用
            ':ip'           => $ip              //ip
        );
        $insertQuery = "INSERT INTO sms_message (sms_id,mobile,type,content,created_time,module,fseq_id,ip) 
                VALUES(:smsid,:mobile,:type,:content,:createdtime,:module,:fseqid,:ip)";
        $rs = $this->getManager("default")->getConnection()->executeUpdate($insertQuery , $params);
        
        $data = array('messageid' => $smsId);
        if ($rs && $ifsendSms) {
            #短信接口配置，1美联软通，2亿美软通
            $smsType = $this->container->getParameter('SMS_ID');
            if ($smsType === 1) {
                //美联软通(不用区分国内外手机号直接发送就好)
                $smsService = $this->container->get('file_ml_sms_service');
                $result = $smsService->sendSMS($mobile, $content);
            } else {
                if($this->isAbroadMobile == true){  //如果是国外手机号就用美联通道发
                    $smsService = $this->container->get('file_ml_sms_service');
                    $result = $smsService->sendSMS($mobile, $content);
                }else{
                    //亿美软通
                    $smsService = $this->container->get('file_ym_sms_service');
                    if(!empty($this->setSendSmsAccount)){
                        $smsService->setUseAccount($this->setSendSmsAccount);     //设置发送短信使用的账号配置
                    }
                    $result = $smsService->sendSms($mobile, $content,$fseqId);
                    //$result = $smsService->getBalance();                          //查询余额
                }
            }
            //通过成功状态返回成功信息
            if (strpos($result, 'result=0') !== FALSE || $result == 0 || strpos($result,"success")>-1) {
                $data = array('messageid' => $smsId);
            } else {
                $data = $result;
            }
            //记录第3方发送日志
            $upStatusSql = "UPDATE sms_message SET status =:status WHERE sms_id =:sms_id;";
            $this->getManager("default")->getConnection()->executeUpdate($upStatusSql, array(':status'=>$result,':sms_id'=>$smsId));
            //记录发送日志
            if($this->ifCheckIpBlacklist == true){
                $this->baseLogger->info($this->container->get('request')->getClientIp() . '  /verification/sms  messageid：' . $smsId . '-----mobile：' . $mobile . '-----content：' . $content . '-----return：' . $result);
            }
        }
        //先将之前有效的验证码 设置为无效
        $updateParams = array(':usestatue'=>2,':mobile'=>$mobile,':smsid'=>$smsId);
        $updateSql    = "UPDATE sms_message SET use_status = 2 WHERE mobile = :mobile AND sms_id !=:smsid;";
        $this->getManager("default")->getConnection()->executeUpdate($updateSql, $updateParams);
        return $data;
    }

    /**
     * 发送短消息文本格式
     * @param type $mobile      //手机号
     * @param type $content     //短信内容
     * @param type $module      //验证模块
     * @param type $type        //验证类型   verify text
     * @param type $ymAccount   //亿美软通 使用账户类型【info:信息类短信 marketing:营销类短信比如：推广短信 默认为验证码类】
     * @param type ifsendSmd    //是否需要发送短信
     * 例：$smsService = $this->container->get('sms_service');
     * $smsService->sendSmsByType('8618600628803','内容','reg');            //验证码类
     * $smsService->sendSmsByType('8618600628803','内容','reg','text','info');    //信息类
     * $smsService->sendSmsByType('8618600628803','内容，退订回复TD','reg'，'text','marketing');    //营销类1
     * $smsService->sendSmsByType('8618600628803','内容，退订回复TD','reg'，'text','marketwo');     //营销类2
     * 
     */
    public function sendSmsByType($mobile, $content, $module,$type='verify',$ymAccount=NULL,$ifsendSms=true,$ifip=true)
    {
        $ip='';
        if($ifip == true){
            $ip = $this->get_real_ip();
            //查看是否是黑名单
            $ipsql = "SELECT id FROM ip_blacklist WHERE ip =:ip;";
            $ipCon = $this->getManager("api")->getConnection()->executeQuery($ipsql, array("ip"=>$ip))->fetch();
            if(!empty($ipCon)){
                return 1;
            }
        }
        $globalBase = $this->container->get('global_base');

        $random = new RandomString();
        $smsId  = $random->make(32);   //获取32位字符串ID
        //短信内容
        if($type == 'verify' ){
            $code = $random->randomNum(6);           //获得6位随机数字验证码
            $content = sprintf($content, $code);     //短信内容
            $insertContent = $code;
        }elseif($type == 'text'){
            $content = sprintf('【橙脉APP】%s', $content);
            $insertContent = $content;
        }else{
            return FALSE;
        }
        
        $fseqId = time();
        $createdTime = $this->getDateTime();
        //基本信息赋值
        $SmsMessage = array(
            'SmsId'     => $smsId, //ID
            'Mobile'    => $mobile, //手机号码
            'Type'      => $type, //类型
            'Content'   => $insertContent, //内容
            'CreatedTime'   => $createdTime, //创建时间,
            'Module'        => $module,         //验证模块,
            'Status'        => '0',             //短信发送状态
            'UseStatus'     => 1,                //短信本地使用状态 1：有效 2：无效
            'FseqId'        => $fseqId,          //短信唯一标示，获取短信发送报告时使用
            'FsubmitTime'   => '',              //第3方：发送时间
            'FreceiveTime'  => '',              //第3方：短信接收时间
            'FreportStatus' => 0,               //第3方：返回保证状态 0 发送成功  1发送失败
            'FerrorCode'    => '',              //第3方：返回发送失败状态码
            'Fmemo'         => '',               //第3方：返回报告里的备注信息
            'Ip'            => $ip
        );
        //添加数据
        $rs = $globalBase->execute($SmsMessage, new SmsMessage());
        $id = $rs->getId();
        $data = array('messageid' => $smsId);
        if ($rs && $ifsendSms) {
            //$data = array('messageid' => $smsId);
            #短信接口配置，1华兴软通，2亿美软通
            $smsType = $this->container->getParameter('SMS_ID');
            if ($smsType === 1) {
                //华兴软通
                $smsService = $this->container->get('file_hx_sms_service');
                $result = $smsService->sendSms($mobile, $content);
            } else {
                //亿美软通
                $smsService = $this->container->get('file_ym_sms_service');
                if(!empty($ymAccount)){
                    $smsService->setUseAccount($ymAccount);     //设置发送短信使用的账号配置
                }
                $result = $smsService->sendSms($mobile, $content,$fseqId);
                //$result = $smsService->getBalance();                          //查询余额
            }
            //通过成功状态返回成功信息
            if (strpos($result, 'result=0') !== FALSE || $result == 0) {
                $data = array('messageid' => $smsId);
            } else {
                $data = $result;
            }
            //记录第3方发送日志
            $upStatusSql = "UPDATE sms_message SET status =:status WHERE sms_id =:sms_id;";
            $this->getManager("api")->getConnection()->executeUpdate($upStatusSql, array(':status'=>$result,':sms_id'=>$smsId));
            //记录发送日志
            if($ifip == true){
                $this->baseLogger->info($this->container->get('request')->getClientIp() . '  /verification/sms  messageid：' . $smsId . '-----mobile：' . $mobile . '-----content：' . $content . '-----return：' . $result);
            }
        }
        //先将之前有效的验证码 设置为无效
        $updateParams = array(':usestatue'=>2,':mobile'=>$mobile,':id'=>$id);
        $updateSql    = "UPDATE sms_message SET use_status = 2 WHERE mobile = :mobile AND id <:id;";
        $this->getManager("api")->getConnection()->executeUpdate($updateSql, $updateParams);
        
        return $data;
    }
    
    /**
     * 获取客户端ip
     */
    public function get_real_ip(){
	    $ip=false;
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
	        if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
	        for ($i=0; $i < count($ips); $i++){
	            if(!eregi ('^(10│172.16│192.168).', $ips[$i])){
	                $ip=$ips[$i];
	                break;
	            }
	        }
	    }
	    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
    
    /**
     * 通过华兴软通接口发送短信
     * @param type $mobile
     * @param type $content
     */
    public function sendHxSms($mobile, $content)
    {
        //华兴软通
        $smsService = $this->container->get('file_hx_sms_service');
        $result = $smsService->sendSms($mobile, $content);
        return $result;
    }

    /**
     * 通过亿美软通接口发送短信
     * @param type $mobile
     * @param type $content
     */
    public function sendYmSms($mobile, $content)
    {
        //亿美软通
        $smsService = $this->container->get('file_ym_sms_service');
        $result = $smsService->sendSms($mobile, $content);
        return $result;
    }

    /**
     * 查询某个手机号 最新发送的一条记录
     * @param type $mobile 手机号[前加86 例：86123456789]
     */
    public function getLastRecordByMobile($mobile){
        $globalBase = $this->container->get('global_base');
        $param  = array('mobile' => $mobile);
        $list   = $globalBase->findBy('SmsMessage',$param,array('id'=>'DESC'),1);
        if(!empty($list)){
            return $list[0];
        }
        return '';
    }
}
