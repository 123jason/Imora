<?php
/**
 * Base trait 实现BaseController & BaseService 复用方法
 * @author huangxm
 *
 */
namespace Oradt\Utils;
use Doctrine\ORM\EntityManager;
use PDOStatement;
use Oradt\Utils\RedisTrait;

trait BaseTrait {
    /**
     * 
     * @var 登陆 token 设备类形
     */
    protected $login_device_type = '';

    /**
     * 
     * @var 日志记录器
     */
    public static $paramdata_v1 = array();//加入想要的记入日志参数
    protected $em = null;
    protected $baseLoger;
    use RedisTrait;
    public function baseInit(){
        $this->baseLoger = $this->container->get('special_logger');
    }

    /**
     * 
     * 记录请求日志
     * 
     * @param String $k
     * @param  mixed $v
     */
    public static function ssLog($k,$v) {
        BaseTrait::$paramdata_v1[$k] = $v;
    }
    
    public static function getLog() {
        return BaseTrait::$paramdata_v1;
    }
    
    public $pushVcardId = array();
    /*
     * 名片kafka消息
     */
    public function kafkaContactCard(){
        $ifkafka = true; //不开启kafka，设为true表示开启
        $kafkaContactCard = "";
        if($ifkafka){
            $kafkaService = $this->container->get('kafka_service');
            if($this->container->hasParameter('kafka_contactcard')){
                $kafkaContactCard = $this->container->getParameter('kafka_contactcard');
            }
        }
        $kdata = $this->pushVcardId;
        if(true === $ifkafka && !empty($kdata) && !empty($kafkaContactCard) && $kafkaService->isActive()) {
            foreach( $kdata as $kkdata){
                $cardData = json_encode($kkdata);
                $kafkaService->sendKafkaMessage( $kafkaContactCard, $cardData );
            
            }
            $kafkaService->disConnect();
        }
        return true;
    }
    private static $kafkaService;
    
    public function getKafkaService() {
        static $kafkaService;
        if($kafkaService===null) {
            $kafkaService = $this->container->get('kafka_service');
        }
        return $kafkaService;
    }
    
    public function sendKafka($topic,$data) {
        $kafkaService = $this->getKafkaService();
        if(true===$kafkaService->isActive()) {
            if(is_array($data) ) {
                $data = json_encode($data);
            } 
            $kafkaService->sendKafkaMessage( $topic, $data );
        }
    }
    public function errorLogger(\Exception $ex,$message=''){
        if(!empty($ex)) {
            $errorstr = sprintf('file: %s , line: %s , errormessage: %s , Trace: %s ,(msg:%s)' , $ex->getFile(),
                $ex->getLine() , $ex->getMessage() , $ex->getTraceAsString() , $message);
        }
        if(empty($this->baseLoger))
            $this->baseInit();
        $this->baseLoger->err( $errorstr );
    }
    
    public function sendMail($email,$title,$body,$atturl = '',$sendername = '橙鑫数据' ,$filename = '') {
        require_once dirname(__FILE__) . '/PHPMailer/PHPMailerAutoload.php';
        $mail = new \PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->container->getParameter('mailer_host');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->container->getParameter('mailer_user');                 // SMTP username
        $mail->Password = $this->container->getParameter('mailer_password');                           // SMTP password
        //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 25;                                    // TCP port to connect to
        $mail->SMTPAutoTLS = false;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->setFrom($this->container->getParameter('mailer_user'), $sendername);
        $mail->addAddress($email, '');     // Add a recipient
        if(!empty($atturl)){
            $mail->AddAttachment($atturl,$filename);
        }
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $title;
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            //return false;
            throw new \Exception($mail->ErrorInfo);
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return true;
            //echo 'Message has been sent';
        }
        /*$message = \Swift_Message::newInstance()
        ->setSubject($title)
        ->setFrom($this->container->getParameter("mailer_user"))
        ->setTo($email)
        ->setBody($body);
        $this->get('mailer')->send($message);*/
    }

    /**
     * 拼接企业账号文件下载地址
     * @param string $path
     * @return string
     */
    public function getCommondUrl($path){
        if (!empty($path)) {
            if( false !== stripos( $path, 'https://' ) || false !== stripos( $path, 'http://' )){
                //返回事例//oradtdev.s3.cn-north-1.amazonaws.com.cn/
                return $path;
            }
            return $this->container->getParameter('HOST_URL') . '/download?path=' . $path;
        }
        return "";
    }
    
    /**
     * 获取实体连接
     * @return EntityManager
     */
    public function getManager($name='default'){
        //默认库连接
        return $this->container->get('doctrine')->getManager($name);
    }
    
    /**
     * 切换数据库
     * @param string $name
     */
    public function setManager($name='default'){
        //echo $name;
        if(empty($name) || is_string($name)){
            $this->em = $this->getManager($name);
        }else {
            $this->em = $name;
        }
    }
    /**
     * 获取当前数据库连接
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection(){
        if(empty($this->em))
            $this->em = $this->getManager();
        return $this->em->getConnection();
    }
  
    /**
     * 批量绑定查询参数
     *
     * @param PDOStatement $sth
     * @param array $values 格式  array( ':pagesize'=>array (1,PDO::PARAM_INT) )
     */
    public function pdoBindValue(&$sth, $values)
    {
        if (empty($values))
            return;
        foreach ($values as $k => $v) {
            $sth->bindValue($k, $v [0], $v [1]);
        }
    }
    
    /**
     * geting file save root directory
     */
    public function getDocRoot()
    {
        return $this->container->getParameter('DOC_ROOT');
    }
    
    /**
     * 执行SQL
     * @param string $sql
     * @param string $param
     * @param string fetch| fetchCloumn
     * @return array
     */
    public function querySql($sql,$param=array(),$type='fetch')
    {
        $sth = $this->getConnection()->prepare ( $sql );
        $this->pdoBindValue($sth, $param);
        $sth->execute ();
        return $sth->$type ();
    }
    
    /**
     * 删除文件
     * @param string $path
     * @return boolean
     */
    protected function removeFile($path,$rootDir = null) {
        if(empty($path))
            return false;
        $path = empty($rootDir) ? $this->getDocRoot() .$path : $rootDir . $path;
        if(!file_exists($path))
            return false;
        unlink($path);
        return true;
    }
    
    public function removeDirectory($dir) {
        if(strpos(php_uname('s'),'Linux')!==false) {
            $command = "rm -Rf ".$dir;
            system($command);
        }
    }
    
    /**
     * strip html tag
     * @param string $string
     * @param string $allow
     * @return string
     */
    protected function strip_tags($string,$allow=null) {
        return strip_tags($string,$allow);
    }
    /**
     * 返回系统时间戳
     * @return \Time
     */
    public function getTimestamp()
    {
        //时区参考 http://php.net/manual/zh/timezones.php
        return time();
    }
    
    /**
     * 返回系统时间
     * @return \DateTime
     */
    public function getDateTime($default='now')
    {
        //时区参考 http://php.net/manual/zh/timezones.php
        return new \DateTime($default, new \DateTimeZone('UTC'));
    }
    
    /**
     * 返回精度到毫秒的时间戳
     * @return number
     */
    public function getTimestamp1() {
        return round ( microtime(true)*1000);
    }
    
    /*
     * 发送下行消息
     * */
    public function pushMessage($type,$toUid , $data = array() , $fromUid='' , $title = '') {
        // if(!empty($data['content'])){
            // $data['content'] = $this->container->get('function_service')->cutstr_dis($data['content'],2000,'');
        // }
        $content = json_encode( array('messagetype' => $type , 'params' => $data) , JSON_UNESCAPED_UNICODE );
        $query = "INSERT INTO message_queue (type,to_uid,content,created_time,from_uid,title) 
                VALUES(:type,:to_uid,:content,:created_time,:from_uid,:title)";
        $params = array(':type' => $type , ':to_uid' => $toUid, ':content' => $content,
                ':created_time' =>  $this->getTimestamp1() , ':from_uid' => $fromUid
                ,':title' => empty($title) ? "" : $this->container->get('function_service')->cutstr_dis($title,60,'')
        );
        $this->getConnection()->executeUpdate($query , $params);
    }

    /*
     * 发送下行消息
     * $owrdate 内部使用 ，下发时 移除
     */
    public function pushMessageNew($type,$toUid , $data = array() , $fromUid='' , $title = '',$owrdate=array()) {
        if(!empty($owrdate)){
            $content = json_encode( array('messagetype' => $type , 'params' => $data,'params1'=>$owrdate) , JSON_UNESCAPED_UNICODE );
        }else{
            $content = json_encode( array('messagetype' => $type , 'params' => $data) , JSON_UNESCAPED_UNICODE );
        }
        $query = "INSERT INTO message_queue (type,to_uid,content,created_time,from_uid,title) 
                VALUES(:type,:to_uid,:content,:created_time,:from_uid,:title)";
        $params = array(':type' => $type , ':to_uid' => $toUid, ':content' => $content,
                ':created_time' =>  $this->getTimestamp1() , ':from_uid' => $fromUid
                ,':title' => empty($title) ? "" : $this->container->get('function_service')->cutstr_dis($title,60,'')
        );
        $this->getConnection()->executeUpdate($query , $params);
        $id = $this->getConnection()->lastInsertId();  //返回写入id
        return $id;
    }
    
    /**
     * empty 
     * @param mixed $var
     * @return boolean
     */
    public function is_empty($var) {
        if($var===null || $var===false || $var==="")
            return true;
        return false;
    }

    /**
     * 公共同步接口方法( 使用 /common/apistore/sync POST方法 获取同步信息 )
     * @param string $userId 用户ID
     * @param array $paramArr 参数数据
     * array(
     *      "module" => "func-1", //必填, 模块(以m-开头的模块为系统同步记录)
     *      "moduleid" => 12312, //必填，int， 当前模块中记录ID
     *      "operation" => "add", //必填， 操作类型 （'add','modify','delete'）
     *      "modifytime" => 1481251666   //选填， 操作时间， 时间戳 $this->getTimestamp()
     * )
     */
    public function commonSync( $userId = "" , $paramArr = array() ){
        if( empty( $userId ) || empty($paramArr)){
            return false;
        }
        if( !isset($paramArr['module']) || !isset($paramArr['moduleid']) || !isset($paramArr['operation'])){
            return false;
        }
        if( isset($paramArr['modifytime']) ){
            $currentTime = intval($paramArr['modifytime']);
        }else{
            $currentTime = $this->getTimestamp();
        }
        //查询条件
        $params = array(
            ":userId" => $userId,
            ":module" => $paramArr['module'],
            ":moduleid" => $paramArr['moduleid'],
            ":operation" => $paramArr['operation'],
            ":currentTime" => $currentTime
        );
        if( false !== strpos($params[":module"], "m-")){
            $querySql = "SELECT id FROM common_system_sync_v2 WHERE module_id=:moduleid AND module=:module LIMIT 1";
            $syncId = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
            //存在数据，更改
            if( $syncId > 0 ){
                $query = "UPDATE common_system_sync_v2 SET modify_time=:currentTime,operation=:operation WHERE id=".$syncId;
            }else{
                $query = "INSERT INTO common_system_sync_v2 (user_id,module,module_id,operation,modify_time)
                        VALUES(:userId,:module,:moduleid,:operation,:currentTime)";
            }
            $this->getConnection()->executeUpdate($query , $params);
        }else{
            $querySql = "SELECT id FROM common_sync_v2 WHERE user_id=:userId AND module_id=:moduleid AND module=:module LIMIT 1";
            $syncId = $this->getConnection()->executeQuery($querySql, $params)->fetchColumn();
            //存在数据，更改
            if( $syncId > 0 ){
                $query = "UPDATE common_sync_v2 SET modify_time=:currentTime,operation=:operation WHERE id=".$syncId;
            }else{
                $query = "INSERT INTO common_sync_v2 (user_id,module,module_id,operation,modify_time)
                        VALUES(:userId,:module,:moduleid,:operation,:currentTime)";
            }
            $this->getConnection()->executeUpdate($query , $params);
        }
        return true;
    }
    
    /**
     * 修改密码同步到IM成功/失败记录
     * @param string $userId 用户id
     * @param string $sync   1:成功  2:失败
     */
    public function insertAccountImSync($userId,$sync){
        $data   = array (
            'userid' => $userId,   //用户id
            'sync'   => $sync      //同步到IM 成功或失败
        );
        $contents=json_encode($data);
        
        $status = 0;  //待处理
        if($sync == '1'){  //成功
            $status = 1;  //已处理
        }
        $time  = $this->getTimestamp();
        $query = "INSERT INTO account_im_sync (type,content,status,created_time)
                VALUES(:type,:content,:status,:created_time)";
        $params = array(
            ':type'     => 114, 
            ':content'  => $contents,
            ':status'   => $status,
            ':created_time' => $time
        );
        $this->getConnection()->executeUpdate($query , $params);
        return true;
    }
    /**
     * array_column 兼容低版本
     * @param type $input
     * @param type $columnKey
     * @param type $indexKey
     * @return type
     */
    public function i_array_column($input, $columnKey, $indexKey=null){
        if(!function_exists('array_column')){ 
            $columnKeyIsNumber  = (is_numeric($columnKey))?true:false; 
            $indexKeyIsNull            = (is_null($indexKey))?true :false; 
            $indexKeyIsNumber     = (is_numeric($indexKey))?true:false; 
            $result                         = array(); 
            foreach((array)$input as $key=>$row){ 
                if($columnKeyIsNumber){ 
                    $tmp= array_slice($row, $columnKey, 1); 
                    $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null; 
                }else{ 
                    $tmp= isset($row[$columnKey])?$row[$columnKey]:null; 
                } 
                if(!$indexKeyIsNull){ 
                    if($indexKeyIsNumber){ 
                      $key = array_slice($row, $indexKey, 1); 
                      $key = (is_array($key) && !empty($key))?current($key):null; 
                      $key = is_null($key)?0:$key; 
                    }else{ 
                      $key = isset($row[$indexKey])?$row[$indexKey]:0; 
                    } 
                } 
                $result[$key] = $tmp; 
            } 
            return $result; 
        }else{
            return array_column($input, $columnKey, $indexKey);
        }
    }
}