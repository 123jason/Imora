<?php

namespace Oradt\OauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\BaseTrait;
use Oradt\Utils\SaveFile;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\Tables;
use PDO;

/**
 * The related base class
 *
 * @var Interface
 */
class BaseController extends Controller
{
    use BaseTrait;
    const ACCOUNT_BASIC = 'basic';
    const ACCOUNT_ADMIN = 'admin';
    const ACCOUNT_BIZ = 'biz';

    /**
     * @var hr module
     */
    const MODULE_HR = 'hr';

    /**
     * @var yps module
     */
    const MODULE_YPS = 'yps';
    
    /**
     * 用户ID
     * @var type 
     */
    protected $accountId = '';
    protected $accountNo = '';
    /**
     * 账号类型
     * @var type 
     */
    protected $accountType = '';
    
    /**
     * 用户姓名
     * @var type 
     */
    protected $accountRealName = '';
    /**
     * 企业员工id
     * @var type 
     */
    protected $accountEmpId = '';
    protected $bizId = '';
    protected $roleId = '';
    protected $name = '';
    protected $mobile = '';
    protected $department = '';
    protected $wechatId = '';

    /**
     * 设置返回参数
     * @var type 
     */
    protected $params = array();

    protected $accesstime = 0;
    public $paramdata = array();//加入想要的记入日志参数

    public function checkLogin(){
        $accesstoken = $this->getRequest()->headers->get('accesstoken');
        if (empty($accesstoken)) {
            return false;
        }
        return $accesstoken;
    }
   
    
    /**
     * @var 检查token
     */
    public function checkAccount()
    {
        //设置日志记录开始时间
        $this->accesstime = $this->getTimestamp1();
        $this->baseInit();
        $request = $this->getRequest();
        $accesstoken = $request->headers->get('accesstoken');
        //if($request->getMethod()=='PUT' || $request->getMethod()=='DELETE'){
        //    $this->parse_raw_http_request($request);
        //    $r_obj = print_r($request->request, true);
        //}
        //开发环境打印请求参数
        if($this->container->getParameterBag()->get("kernel.environment")=="dev") {
            $this->baseLoger->info($request->getClientIp() . ':'.microtime().'  ' . $request->getPathInfo() . ' ' . $request->getMethod() . ' ' . ' accesstoken:' . $accesstoken . '-----request:' . print_r($_REQUEST, true));
        }
        if (empty($accesstoken)) {            
            if(!defined('INTERNALPROCESS')) {
                $data = $this->getFailed(Errors::$OAUTH_ERROR_MISS_ACCESSTOKEN);
                $this->outputJson($data);
            }else {
                return $this->renderJsonFailed(Errors::$OAUTH_ERROR_MISS_ACCESSTOKEN);
            }
        }
        $oauthService = $this->container->get('oauthService');
        $loginSession = $oauthService->getUserInfo($accesstoken);        
        // 判断biz
        $this->ifEmptySession($loginSession,$accesstoken);

        $this->accountId = $loginSession->getAccountId();
        $this->accountType = $loginSession->getAccountType();
        $this->accountRealName = $loginSession->getRealName();  
        $this->accountEmpId     = "";       //默认员工id为空
        $this->login_device_type = ''; 
        if($this->accountType == self::ACCOUNT_BIZ){
            $this->checkBiz($loginSession);
        }elseif ($this->accountType == self::ACCOUNT_BASIC) {
            $this->checkBaisc($oauthService,$loginSession,$accesstoken,$request);
                        
        }
        //$this->accessLog();
        return $loginSession;
    }
    public function checkAccountV2()
    {
        //设置日志记录开始时间
        $this->accesstime = $this->getTimestamp1();
        $this->baseInit();
        $request = $this->getRequest();
        $accesstoken = $request->headers->get('accesstoken');
        //if($request->getMethod()=='PUT' || $request->getMethod()=='DELETE'){
        //    $this->parse_raw_http_request($request);
        //    $r_obj = print_r($request->request, true);
        //}
        //开发环境打印请求参数
        if($this->container->getParameterBag()->get("kernel.environment")=="dev") {
            $this->baseLoger->info($request->getClientIp() . ':'.microtime().'  ' . $request->getPathInfo() . ' ' . $request->getMethod() . ' ' . ' accesstoken:' . $accesstoken . '-----request:' . print_r($_REQUEST, true));
        }
        if (empty($accesstoken)) {
            if(!defined('INTERNALPROCESS')) {
                $data = $this->getFailed(Errors::$OAUTH_ERROR_MISS_ACCESSTOKEN);
                $this->outputJson($data);
            }else {
                return $this->renderJsonFailed(Errors::$OAUTH_ERROR_MISS_ACCESSTOKEN);
            }
        }
        $oauthService = $this->container->get('oauthService');
        $loginSession = $oauthService->getUserInfoV2($accesstoken);

        if (empty($loginSession)) {
            if(!defined('INTERNALPROCESS')) {
                $data = $this->getFailed(Errors::$OAUTH_ERROR_INVALID_USER);
                $this->outputJson($data);
            }else {
                $data =  $this->getFailed(Errors::$OAUTH_ERROR_INVALID_USER);
                $this->outputJson($data);
            }
        }
        
        $this->accountNo=$loginSession->getAccountId();
        $this->accountType = $loginSession->getAccountType();
        $this->accountRealName = $loginSession->getRealName();
        
        $commonSql  ="SELECT account_no,username,mobile,wechat_id,union_id FROM `user_common` WHERE account_no =:account_no LIMIT 1";
        $userCommonInfo = $this->getConnection()->executeQuery($commonSql,array(":account_no"=>$this->accountNo))->fetch();
        if($userCommonInfo){
            $this->wechatId   = $userCommonInfo['wechat_id'];
        }

        $bizSql  = "SELECT id,biz_id,role_id,mobile,name,department,open_id FROM `" . Tables::TBWXBIZEMPLOYEE . "` WHERE account_no=:account_no LIMIT 1";
        $bizInfo = $this->getConnection()->executeQuery($bizSql,array(":account_no"=>$this->accountNo))->fetch();
        if($bizInfo){
            $this->bizId      = $bizInfo["biz_id"];
            $this->roleId     = $bizInfo["role_id"];
            $this->name       = $bizInfo["name"];
            $this->mobile     = $bizInfo["mobile"];
            $this->department = $bizInfo['department'];
            
            $this->accountId  = $bizInfo['id']; 
        }
       
        //$this->accessLog();
        return $loginSession;
    }

    /**
     * @todo 权限检验
     * @param wechatid 微信id
     */
    public function checkWxAccount(){
        $request = $this->getRequest();
        $wechatid = $request->get('wechatid');
        if(empty($wechatid)){
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            $this->outputJson($data);
        }
        //检验 wechatid 是否存在
        $sql      = "SELECT COUNT(*) FROM " . Tables::TBWEIXINUSER . " AS a WHERE a.wechat_id = :wechatid;";
        $numfound = intval($this->getConnection()->executeQuery($sql, [':wechatid' => $wechatid])->fetchColumn());
        if(0 == $numfound){
            $data = $this->getFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            $this->outputJson($data);
        }

        return true;
    }

    /**
     * 
     */
    public function ifEmptySession($loginSession,$accesstoken)
    {
        if (empty($loginSession)) {
            if( "Biz" === substr( $accesstoken, 0, strpos($accesstoken, "_") ) ){//企业账户 查询login_session_history表
                $sql = "SELECT 1 FROM `login_session_history` WHERE session_id=:token LIMIT 1";
                $flag = $this->getConnection()->executeQuery($sql, array(':token' => $accesstoken))->fetchColumn();
                if( $flag > 0 ){
                    if(!defined('INTERNALPROCESS')) {
                        $data = $this->getFailed(Errors::$OAUTH_ERROR_EXPIRATION);
                        $this->outputJson($data);
                    }else {
                        $data =  $this->getFailed(Errors::$OAUTH_ERROR_EXPIRATION);
                        $this->outputJson($data);
                    }
                }
            }
            if(!defined('INTERNALPROCESS')) {
                $data = $this->getFailed(Errors::$OAUTH_ERROR_INVALID_USER);
                $this->outputJson($data);
            }else {
                $data =  $this->getFailed(Errors::$OAUTH_ERROR_INVALID_USER);
                $this->outputJson($data);
            }
        }
        return true;
    }
    /**
     * 
     */
    public function checkBiz($loginSession)
    {
        $oauthService = $this->container->get('oauthService');
        $res = $oauthService->checkBiz($loginSession,$this->accountId);
        switch ($res) {
            case 1:
                $data = $this->getFailed(Errors::$OAUTH_ERROR_INVALID_USER);
                $this->outputJson($data);
                break;
            case 2:
                $data =  $this->getFailed(Errors::$ACCOUNT_BIZ_EMP_ENABLE);
                $this->outputJson($data);
                break;
            default:
                return true;
                break;
        }
        return true;        
    }

    /**
     * 检验橙子设备是否有效
     */
    public function checkBaisc($oauthService,$loginSession,$accesstoken,$request)
    {
        $deviceId  = $loginSession->getDeviceId();  //设备id
        //丢失验证 ifmissing 1：已丢失 2：已处理，0正常  
        $ifmissing = $loginSession->getIfmissing();
        // 判断该账户的设备Id是否绑定
        $res = $this->checkDevice($deviceId,$ifmissing,$request);
        if ($res) {
            $data = $this->getFailed(Errors::$OAUTH_ERROR_ORANGE_DEVICE_LOST_BING);
            $this->outputJson($data);
        }
        if(!empty($ifmissing) && in_array($ifmissing, array(1,2,3,4))){  
        //1：已丢失 2：已处理 3:清除数据4：已清除5：已解绑
           if(in_array($ifmissing, array(3,4))){  //如果用清楚数据的token 调接口的话 默认给app发已清楚完毕的消息
               //更改该账户在login_session 中device_type 为Orange 的 ifmissing 为 4  已清除数据
               if (3 == $ifmissing) {
                   $oauthService->missingAction($accesstoken,$this->accountId,4,$deviceId);
               }                   
               $data = $this->getFailed(Errors::$OAUTH_ERROR_ORANGE_DEVICE_CLEAR_DATA);
           }
           // else if (5 == $ifmissing) {
           //      // 已经解除绑定
           //      $data = $this->getFailed(Errors::$OAUTH_ERROR_ORANGE_DEVICE_LOST_BING);
           // }
           else{                    
                if($ifmissing == 1){  //处理失败，app端清空本地数据
                    //更改该账户在login_session 中device_type 为Orange 的 ifmissing 为 2 拉取过数据
                    $oauthService->missingAction($accesstoken,$this->accountId,2,$deviceId);
                }
                $data = $this->getFailed(Errors::$OAUTH_ERROR_ORANGE_DEVICE_MISSING);
           }
        }
        if (isset($data))
            $this->outputJson($data);
        return true;
    }
    /**
     * 检验橙子token是否解绑
     */
    public function checkDevice($deviceId,$ifmissing,$request)
    {        
        if (empty($deviceId)) 
            return false;
        $isnew        = $request->get('accnew');
        $old_deviceid = $request->get('accdeviceid');
        $sql = "SELECT b.id,b.status,b.ifmissing,b.iserror FROM (SELECT max(id) as id FROM account_basic_bingorange WHERE user_id = :userid AND orauuid = :orauuid  GROUP BY orauuid) as c inner join account_basic_bingorange as b on c.id = b.id ";
        $bingObj = $this->getConnection()->executeQuery($sql, array(":userid" => $this->accountId,":orauuid"=>$deviceId))->fetch();
        if (!empty($bingObj)) {
            if (1 == $isnew && $old_deviceid == $deviceId) {
                $id  = isset($bingObj['id'])?$bingObj['id']:0;
                if (!empty($id)) {
                    $sql = "UPDATE  `account_basic_bingorange` set iserror = 1 WHERE id=:id LIMIT 1";
                    $this->getConnection()->executeQuery($sql, array(':id' => $id));    
                }                    
            }else{
                $status = isset($bingObj['status'])?$bingObj['status']:0;
                // $ifmissing = isset($bingObj['ifmissing'])?$bingObj['ifmissing']:0;
                $iserror = isset($bingObj['iserror'])?$bingObj['iserror']:0;
                if (2 == $status && !in_array($ifmissing, array(3,4)) && 2 == $iserror) {
                    return true;
                }
            }
        }
        return false;
    }
    /**
     * @var 记录开始时间
     */
    protected function accessLog() {
        //return;
        if(defined('INTERNALPROCESS') ||
        !$this->container->hasParameter('API_LOG_ON-OFF') || 
        !$this->container->getParameter('API_LOG_ON-OFF') ) {
            return true;
        }
        
        if(!empty($this->accountId) && in_array($this->accountId, array('baidu_xn_cron'))) return true;
        //todo test & mutil api call please verification  request = (master | sub)  the child process to skip
        
        $accesstoken = $this->checkLogin();
        if($accesstoken != false){
            $this->paramdata['accesstoken'] = $accesstoken;
        }
        //self::ssLog("ClientIp_v1", $this->container->get('request')->getClientIp());
        //self::ssLog("DeviceType", !isset($this->login_device_type) ? "" : $this->login_device_type );//记录当前请求设备类型

        $accountId = empty($this->accountId) ? $this->getRequest()->getPathInfo() : $this->accountId;
        
        $request_data = 'put' === strtolower($this->getRequest()->getMethod()) ? $this->getRequest()->request->all() : $_REQUEST;
        
        //处理掉密码等
        if(isset($request_data['passwd']))
        {
            $request_data['passwd'] = '****';
        }
        $parameter = json_encode(array_merge_recursive( array_merge_recursive($request_data,self::getLog()) , $this->paramdata) );
        $cip = $this->getRequest()->server->get("REMOTE_ADDR");
        if(empty($cip)) {
            $cip = $this->container->get('request')->getClientIp();
        }
        if($this->getRequest()->server->has("REQUEST_TIME_FLOAT")) {
            $this->accesstime = $this->getRequest()->server->get("REQUEST_TIME_FLOAT") * 1000;
        }
        $params = array(
                ':userId' => $accountId,
                ':name' => $this->getRequest()->getPathInfo(),
                ':method' => strtolower($this->getRequest()->getMethod()),
                ':times' => $this->accesstime,
                ':call_times' => $this->getTimestamp1(),
                ':parameter'  => $parameter,
                ':ip' => $this->getRequest()->server->get("SERVER_ADDR"),
                ':cip' => $cip,
                ':version' => $this->container->getParameter('api_version')
        );
        if(!$this->container->hasParameter('kafka_bs_log')) {
            $sql = "INSERT INTO api_statistic (user_id, api_name, method, date_time, call_times, parameter,ip,cip,version)
                VALUES (:userId, :name, :method, :times, :call_times, :parameter,:ip,:cip,:version)";
            $this->getManager('default')->getConnection()->executeQuery($sql,$params);
        }else{
            $this->sendKafka($this->container->getParameter('kafka_bs_log'), $params);
        }
    }
    
    /**
     * 设置参数
     * @param unknown $varName
     * @param unknown $varValuea
     */
    protected function setParam($varName, $varValue)
    {
        if (!empty($varValue)) {
            $this->params[$varName] = $varValue;
        }
    }

    /**
     * 设置数组参数
     * @param type $parameters
     * @return 绑定的参数值
     */
    protected function setParams($parameters)
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                if (isset($value)) {
                    $this->params[$key] = $value;
                }
            }
        }
    }

    /**
     * 获取参数
     * @param string $varName
     * @return \Oradt\OauthBundle\Controller\type|NULL
     */
    public function getParam($varName='')
    {
        if(empty($varName))
            return $this->params;
        if(!empty($varName) && isset($this->params[$varName]))
            return $this->params[$varName];
        return null;            
    }
    /**
     * 设置失败返回信息
     * @param unknown $error
     * @return unknown
     */
    protected function getFailed($error)
    {
        $array = array();
        $array['head']['status'] = Errors::$FAILED;
        $array['head']['error'] = $error;
        if (!empty($this->params)) {
            $array['head']['params'] = $this->params;
        }
        return $array;
    }

    /**
     * 返回错误json信息
     * @param type $data
     */
    public function renderJsonFailed($data,$error='')
    {
        if(!empty($error)){
            $data['description'] = sprintf($data['description'],$error);
        }
        $data = $this->getFailed($data);        
        return $this->renderJson($data);
    }

    /**
     * 返回错误json信息
     * @param type $data
     */
    public function renderJsonSuccess($data = NULL)
    {
        $data = $this->getSuccess($data);
        return $this->renderJson($data);
    }

    /**
     * 设置成功返回参数
     * @param type $body
     * @return array
     */
    protected function getSuccess($body = NULL)
    {
        $array = array();
        $array['head']['status'] = Errors::$SUCCESS_OK;
        if (!empty($this->params)) {
            $array ['head'] ['params'] = $this->params;
        }
        if (NULL !== $body)
            $array ['body'] = $body;

        return $array;
    }

    /**
     * 转换传递的变量， 用PUT存储
     * 
     * @param string $varName            
     * @param string $varValue            
     */
    private function setVar(&$put_data, $varName, $varValue)
    {
        // 取消未尾回车
        $varValue = trim($varValue, "\r\n");
        if (!isset($put_data ['request'] [$varName]))
            $put_data ['request'] [$varName] = $varValue;
        else {
            if (is_array($put_data['request'][$varName])) {
                $put_data['request'][$varName][] = $varValue;
            } else {
                $put_data['request'][$varName] = array($put_data['request'][$varName]);
                $put_data['request'][$varName][] = $varValue;
            }
        }
    }

    /**
     * 将传递的文件转换存储方式
     * @param string $fileName
     * @param string $tmpFileName
     */
    private function setFileVar(&$put_data, $varName, $varValue)
    {
        if (!isset($put_data['files'][$varName])) {
            $put_data['files'][$varName] = $varValue;
        } else {
            if (is_array($put_data['files'][$varName])) {
                $put_data['files'][$varName][] = $varValue;
            } else {
                $put_data['files'][$varName] = array($put_data['files'][$varName]);
                $put_data['files'][$varName][] = $varValue;
            }
        }
    }

    /**
     * 解析put上传文件
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    protected function parse_raw_http_request(\Symfony\Component\HttpFoundation\Request &$request)
    {
        if(php_sapi_name()==='cli' || !isset($_SERVER['CONTENT_TYPE']))
            return ;
        
        // application/x-www-form-urlencoded 报头 symfony 中能正常取值，无须处理
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/x-www-form-urlencoded') {
            return;
        }
        //普通text/plain 文本报头
        if (strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === false) {
            $input = file_get_contents('php://input');
            $data = null;
            parse_str($input, $data);
            if (!empty($data)) {
                $request->request = new ParameterBag($data);
            }
            return;
        }
        //取出form-data报头
        $contentType = explode(';', $_SERVER['CONTENT_TYPE'], 2);
        $formEnctype = strtolower(trim($contentType[0]));
        $boundaryStart = '';
        if ('multipart/form-data' == $formEnctype) {
            $boundaryStart = '--' . substr(trim($contentType[1]), strlen('boundary='));
            $boundaryEnd = $boundaryStart . '--';
        }
        $put_data = array();
        //取put 数据开始
        // only then the request has PUT file, then go into this block
        if ('PUT' == strtoupper($_SERVER['REQUEST_METHOD']) && $boundaryStart) {
            /* PUT data comes in on the stdin stream */
            // echo file_get_contents("php://input");
            //file_put_contents("G:/my.gitconfig.txt", $content);
            $putdata = fopen("php://input", "r");
            // the folder to store the temporary file
            $tmpDir = sys_get_temp_dir();
            //$tmpDir = "G:/";
            $varValue = '';
            $varName = '';
            $tmpFileName = '';
            $fileName = '';
            $fp = $previousLine = null;
            while (!feof($putdata)) { // check if pointer is at the end of file
                $line = fgets($putdata); // get the first line
                //echo $line;
                if (trim($line) == $boundaryStart) { //  it is going into a boundary block
                    if ($fp) { // it's already opening the file, and going into boundary again
                        // the previous line was store. write it into file
                        if (isset($previousLine)) {
                            fwrite($fp, trim(trim($previousLine, "\n"), "\r")); // we need to remove \n and \r in the last line
                        }
                        // store the processed file
                        //setPutFile ($varName, array('name'=>$fileName,'filepath'=>$tmpFileName));
                        //$put_data['files'][$varName] = new SaveFile($tmpFileName,$fileName);
                        $this->setFileVar($put_data, $varName, new SaveFile($tmpFileName, $fileName));
                        fclose($fp);
                    } else if ('' !== $varName) { // this doundary is not of File data
                        //setPutVar ($varName, $varValue); // store variable
                        //$put_data['request'][$varName] = $varValue;
                        $this->setVar($put_data, $varName, $varValue);
                    }
                    // while goes into boundary, initialize the variables
                    $varValue = '';
                    $fileName = '';
                    $tmpFileName = '';
                    $fp = null;
                    $previousLine = null;
                    // find out the fileName/variableName. and the name is placed in Disposition line
                    while (true && !feof($putdata)) {
                        $line = fgets($putdata);
                        if (0 !== stripos($line, 'Content-Disposition:')) {
                            continue;
                        }
                        $lineInfo = explode(';', $line);
                        //print_r($lineInfo);
                        $varName = substr(trim($lineInfo[1]), strlen('name="'), -1);
                        $fileName = isset($lineInfo[2]) ? substr(trim($lineInfo[2]), strlen('filename="'), -1) : null;

                        break;
                    }

                    // if fileName has been found, it means this boundary has file data
                    if ($fileName != '') {
                        $tmpFileName = tempnam($tmpDir, 'PUT');
                        $fp = fopen($tmpFileName, "w");
                    }
                    // find out the space line. after this line, it's the file/variable contents
                    while (!feof($putdata) && trim(fgets($putdata)) !== '') {
                        continue;
                    }
                } else if (trim($line) == $boundaryEnd) { // it's coming to the end of Request
                    if (empty($fileName)) { // set the PUT variable
                        //setPutVar ($varName, $varValue);
                        //$put_data['request'][$varName] = $varValue;
                        $this->setVar($put_data, $varName, $varValue);
                    } else if ($fp) { // process the file data
                        if (isset($previousLine)) { // we need to remove the \n and \r in the last line
                            fwrite($fp, trim(trim($previousLine, "\n"), "\r"));
                        }
                        //setPutFile ($varName, array('name'=>$fileName,'filepath'=>$tmpFileName));
                        //$put_data['files'][$varName] = new SaveFile($tmpFileName,$fileName);
                        $this->setFileVar($put_data, $varName, new SaveFile($tmpFileName, $fileName));
                        fclose($fp);
                    }
                    break;
                } else if ($fileName == '') { // this boundary is storing variable value
                    $varValue .= $line;
                } else if ($fp) { // this boundary is storing the file data
                    if (isset($previousLine)) {
                        fwrite($fp, $previousLine);
                    }

                    // cache the current line. due to we need to remove the \r and \n in the last line
                    // and only when the next line is boundaryStart or boundaryEnd, then we know the line is the last.
                    $previousLine = $line;
                } else {
                    //error_log("!!! Processing PUT occurs a problem!\r\n", 3, 'G:/log1.log');
                }
            }

            /* Close the streams */
            fclose($putdata);
        }
        //取put结束
        //取参数后将结果组装在symfony
        if (isset($put_data['request'])) {
            $request->request = new ParameterBag($put_data['request']);
        }
        if (isset($put_data['files'])) {
            $request->files = new ParameterBag($put_data['files']);
        }

        unset($put_data);
    }

    /**
     * Render JSON
     *
     * @param mixed   $data
     * @param integer $status
     * @param array   $headers
     *
     * @return Response with json encoded data
     */
    protected function renderJson($data, $status = 200, $headers = array())
    {
        // fake content-type so browser does not show the download popup when this
        // response is rendered through an iframe (used by the jquery.form.js plugin)
        //  => don't know yet if it is the best solution
        if ($this->get('request')->get('_xml_http_request') && strpos($this->get('request')->headers->get('Content-Type'), 'multipart/form-data') === 0) {
            $headers['Content-Type'] = 'text/plain';
        } else {
            $headers['Content-Type'] = 'application/json';
        }
        if(is_array($data) && isset($data['head']['error']['errorcode'])) {
            self::ssLog("Response", $data);
            if(in_array($data['head']['error']['errorcode'], array(500,404,405,403)))
                $status = $data['head']['error']['errorcode'];
        }
        $this->accessLog();//记录日志
        return new Response(json_encode($data), $status, $headers);
    }

    /**
     * @param $array
     * @param int $num
     * @param bool $jsonHeader
     * 输出标准json
     *
     * @access	public
     *
     * @return   string
     *
     */
    public  function outputJson($array, $num = true, $jsonHeader = true)
    {
        
        if(is_array($array) && isset($array['head']['error']['errorcode'])) {
            self::ssLog("Response", $array);
        }
        
        $this->accessLog();
        if(php_sapi_name() !=='cli') {
            header("Expires: Mon, 26 Jul 1970 01:00:00 GMT");
            $jsonHeader && header('Content-type: application/json;charset=utf-8');
            header("Pramga: no-cache");
            header("Cache-Control: no-cache");
            
        }
        /*$array['method'] = php_sapi_name();*/        
        if ($num) {
            exit(json_encode((array) ($array), JSON_NUMERIC_CHECK));
        } else {
            exit(json_encode((array) ($array)));
        }
    }

	
    /**
     * 获取页大小
     * 
     * @return int 分页条数
     */
    public function getPageSize()
    {
        if ($this->getRequest()->get("rows")) {
            $row = intval($this->getRequest()->get("rows"));
            $row = $row>0 ? $row :Codes::LIMIT ;
        } else {
            $row = Codes::LIMIT;
        }
        $this->setParam('rows', $row);
        return $row;
    }

    /**
     * 比较传入字段和提供字段，返回两个里面都有的字段
     * 
     * @param string $fields 传入要显示的字段 该参数空的话，返回所有字段
     * @param string $provideFields 提供显示的所有字段
     * @return string 
     */
    public function getResultFields($fields, $provideFields)
    {
        if (empty($fields)) {
            return $provideFields;
        } else {
            $fields = trim($fields, ',');
            $fields = empty($fields) ? $provideFields : $fields;
        }
        //比较两个数组，取出两个里面都有的字段       
        $fieldsArr = array_intersect(explode(',', $fields), explode(',', $provideFields));
        return empty($fieldsArr) ? $provideFields : implode(',', $fieldsArr);
    }

    /**
     * 排序参数检测
     * 
     * @param string $order 排序字段
     * @param string $provideFields 提供回显或可查询的所有字段
     * @return false|order  返回false错误 ，order  验证解析后排序字段，可安全使用
     */
    public function checkOrderParam($order, $provideFields)
    {
        $fieldarr = explode(',', $provideFields);
        $arr = array_filter(explode(';', $order));
        foreach ($arr as $item) {
            if (strpos($item, ',') === false)
                return false;
            list($field, $ascdesc) = explode(',', $item);
            if (!in_array($ascdesc, array('desc', 'asc')) || !in_array($field, $fieldarr)) {
                return false;
            }
        }
        return str_replace(array(',', ';'), array(' ', ','), $order);
    }


    /**
     * 打印错误日志
     */
    public function logger($sql = null, $accountId = null, $accountType = null)
    {
        $logger = $this->container->get('special_logger');
        $request = $this->getRequest();
        $logger->warn($request->getClientIp());
        $logger->warn($request->getPathInfo() . ' ' . $request->getMethod());
        if (!empty($accountId)) {
            $logger->warn('accountId:' . $accountId . '-----accountType:' . $accountType);
        }
        $logger->warn(print_r($_REQUEST, true));
        $logger->warn($sql);
    }
    
    /**
     * 加载初始化sql 配置
     * @param $fileName 默认为控制器名称
     * @return multitype:array string
     */
    public function loadSqlConfig($fileName=''){
        // get_  Oradt\DocumentBundle\Controller\DocumentController
        $className = get_class($this);
        list($nameSpace,$className) = explode("Bundle\\Controller\\", substr($className, 6) );
        if(empty($fileName))
        {
            $fileName = substr($className, 0,-10);
        }        
        $file =  dirname( dirname( __DIR__ ) ) . '/StoreBundle/Resources/Sql/' .$nameSpace .'/'.$fileName.'.xml';
        if(!file_exists($file)){
            exit($file . "\t not found");
        }
        if($this->container->getParameterBag()->get("kernel.environment")=="dev" && $this->getRequest()->get("getxml")=="true"){
            echo $file;
            echo file_get_contents($file);exit();
        }
        //$xml = simplexml_load_file($file);
        $xmlData = file_get_contents($file);
        $xml = simplexml_load_string($xmlData);
        
        $data = array();
        $data['fields'] = (array) $xml->fields;
        $array = array();
        foreach ($data['fields'] as $k=>$v)
            $array[$k] = (array) $v;
        $data['fields'] = $array;
        unset($array);
        $data['default_dataparam'] = (array) $xml->default_dataparam;
        $data['sql'] = (string) $xml->sql;
        $data['where'] = (string) $xml->where;
        $data['order'] = (string) $xml->order;
        $data['provide_max_fields'] = (string) $xml->provide_max_fields;
        //追加的回显字段 不受前端fields参数影响
        $data['append_fields'] = '';
        if(isset($xml->append_fields)){
            $data['append_fields'] = (string) $xml->append_fields;
        }
        $data['limit'] = 0;
        if(isset($xml->limit)){
            $data['limit'] = intval($xml->limit);
        }
        //print_r($data);exit();
        return $data;
    }

    /**
     * 组合查询条件 返回字段，参数数据
     *
     * @param array $sqldata
     * @param string $userId
     * @return boolean
     */
    public function parseSql(& $sqldata,$userId=null)
    {
        /*
        * 表达式	含义
            EQ	等于（=）      _eq=_null
            NEQ	不等于（<>）_neqclient=_null
            GT	大于（>）
            EGT	大于等于（>=）
            LT	小于（<）
            ELT	小于等于（<=）
            LIKE	模糊查询
            [NOT] BETWEEN	（不在）区间查询 
            [NOT] IN	（不在）IN 查询
            EXP	表达式查询，支持SQL语法
        */
        //兼容php配置
        if(!isset($sqldata['limit']))
            $sqldata['limit'] = 0;
        if(!isset($sqldata['append_fields']))
            $sqldata['append_fields'] = '';
        $sqldata['pagesize'] = $this->getPageSize ();
        $start = intval ( $this->getRequest ()->get ( 'start' ) );
        $sqldata['start'] = $start>=0 ? $start : 0 ;
        $sort = $this->getRequest()->get("sort");
        $fields = $this->getRequest()->get("fields");
        $this->setParam('sort', $sort);
        $this->setParam('fields', $fields);
        //所有提供显示的字段
     
        $provideFieldsArray = array_flip( explode(',', (string)$sqldata['provide_max_fields']) );

        $allFieldsArray = array();
        $where = $sqldata['where'];
        $sqlParam = array();
        $provideFieldArrs = '';
        //print_r($this->getRequest()->query);
        //var_dump($this->getRequest()->query->get("aa"));
        //var_dump($this->getRequest()->query->get("contactid"));
        //print_r($sqldata['fields']); print_r($provideFieldsArray); exit();
        //处理查询where 查询参数 开始
        // 现支持  = LIKE IN Range 4种语法
        foreach ($sqldata['fields'] as $k=>$v)
        {
            //处理回显及排序需要用到的数据
            if(isset($provideFieldsArray[ $k ]))
                $provideFieldsArray[ $k ] = (isset($v['mapdb'])) ? $v['mapdb'] : $k;
            if(isset($v['mapdb']) && !empty($v['mapdb'])){
                $allFieldsArray[ $k ] = $v['mapdb'];
            }else{
                $allFieldsArray[ $k ] = $k;
            }
            //是否初始化过获取传入字段的值
            $var = $this->getParam($k);
            if($var===NULL){
                $var = $this->getRequest()->get($k);
                if($var!==NULL && $var!=='')
                {
                    $this->setParam($k, $var);
                }
            }
            if(!isset($v['w']) || "0"===(string)$v['w'] || $var===NULL || $var===''){
                continue;
            }
            if( isset($v['isPk']) && !isset($sqldata['pkField']) ){
                $sqldata['pkField'] = $k;
            }
            if( isset($v['isPk']) && !isset($sqldata['pkValue']) ){
                $sqldata['pkValue'] = $var;
            }
            $pdo_type = (isset($v['type']) && $v['type']=='string') ? PDO::PARAM_STR : PDO::PARAM_INT;
            if((isset($v['type']) && $v['type']=='int')) {
                $var = intval($var);
            }
            //处理不等于
            if (stripos($v['w'], '!= :')!==false || stripos($v['w'], '<> :')!==false) {
                $where .= ' AND ' . $v['mapdb'] . '!=:' . $k;
                $sqlParam[':' . $k] = array($v['neq'], $pdo_type);
            }

            //处理IN语法
            if( stripos( $v['w'] , 'IN (%s)') !== false ){
                $qarr = array_unique(explode(',', $var));
                
                //只有一个键，则按=号形式查询
                if(count($qarr)==1){
                    $v['w'] = str_replace(' IN (%s)','=:'.$k,$v['w']);
                    $where.= $v['w'];
                    $sqlParam[':'.$k] = array ($qarr[0],$pdo_type);
                    continue;
                }else{
                    $inArr = array();
                    for($i=0;$i<count($qarr);$i++){
                        if(empty($qarr[$i])){
                            continue;
                        }
                        $key = ":where_in_" . $k .'_' . $i;
                        $inArr[] = $key;
                        $sqlParam[$key] = array ($qarr[$i],$pdo_type);
                    }
                    if(!empty($inArr)){
                        $where.= sprintf( $v['w'] , implode(',', $inArr) );
                    }
                    //如果用IN，取消索引查询并不缓存
                    if( isset($v['isPk']) && isset($sqldata['pkField']) )
                    {
                        unset($sqldata['pkField'],$sqldata['pkValue']);
                    }
                    continue;
                }
            }
            //处理LIKE
            if( stripos( $v['w'] , ' LIKE :') > 0 && 
                stripos( $v['w'] , '%') === false ){
                $likeType = isset($v['type']) ? 1 : 0;
                $orType = isset($v['or']) ? 1 : 0;
                switch ($likeType) {
                    case 1://开头
                        switch ($orType) {
                            case 1://LIKE查询需要将条件字符串拆分为单个进行LIKE查询，如 1，2，3拆分为 LIKE ',1,%' OR LIKE ',2,%' OR LIKE ',3,%'
                                $orLikeCont = '';
                                $varArr = explode(",", $var);//$var='1,2,3' $varArr = array(1,2,3)
                                foreach ($varArr as $item) {
                                    $orLikeCont .= $v['mapdb'] . ' LIKE ,' . $item . ',% OR ';
                                }
                                $orLikeCont = ltrim($orLikeCont, $v['mapdb'] . ' LIKE');
                                $orLikeCont = rtrim($orLikeCont, 'OR ');
                                $var = $orLikeCont;
                                break;
                            default://普通查询
                                $var .= '%';
                                break;
                        }
                        break;
                    default://模糊
                        switch ($orType) {
                            case 1://LIKE查询需要将条件字符串拆分为单个进行LIKE查询，如 1，2，3拆分为 LIKE '%,1,%' OR LIKE '%,2,%' OR LIKE '%,3,%'
                                $orLikeCont = '';
                                $varArr = explode(",", $var);//$var='1,2,3' $varArr = array(1,2,3)
                                foreach ($varArr as $item) {
                                    $orLikeCont .= $v['mapdb'] . ' LIKE %,' . $item . ',% OR ';
                                }
                                $orLikeCont = ltrim($orLikeCont, $v['mapdb'] . ' LIKE');
                                $orLikeCont = rtrim($orLikeCont, 'OR ');
                                $var = $orLikeCont;
                                break;
                            default://普通查询
                                $var = '%' . $var . '%';
                                break;
                        }
                        break;
                }
            }
            //处理Range
            if( $v['w']=='Range' && isset($v['mapdb'])){
                $qarr = explode(',', $var);
                $qarrCount = count($qarr);
                if ($qarrCount == 2) {//起始和终止参数都有
                    if(isset($qarr[0]) && !empty($qarr[0])){
                        $where.= ' AND ' . $v['mapdb'] . '>=:' . $k . '__range0';
                        $sqlParam[':' . $k . '__range0'] = array ($qarr[0],$pdo_type);
                    }
                    if(isset($qarr[1]) && !empty($qarr[1])){
                        $where.= ' AND ' . $v['mapdb'] . '<:' . $k . '__range1';
                        $sqlParam[':' . $k . '__range1'] = array ($qarr[1],$pdo_type);
                    }
                } else if ($qarrCount == 1) {//只传一个参数，如只需一个日期则查询该天0点到24点
                    $standTime = date("Y-m-d", $qarr[0]);
                    $startTime = strtotime($standTime);
                    $endTime = $startTime + 86400;
                    $where.= ' AND ' . $v['mapdb'] . '>=:' . $k . '__range0';
                    $sqlParam[':' . $k . '__range0'] = array ($startTime,$pdo_type);
                    $where.= ' AND ' . $v['mapdb'] . '<:' . $k . '__range1';
                    $sqlParam[':' . $k . '__range1'] = array ($endTime,$pdo_type);
                } else {
                    //TODO...
                }
                continue;
            }
            //补齐WHERE
            $where.= $v['w'];
            //绑定参数
            if( stripos( $v['w'] , ':'.$k) !== false ) {
                $sqlParam[':'.$k] = array ($var,$pdo_type);
            }
        }
        //处理查询where 查询参数 结束
        //默认参数
        if(array_key_exists('userId', $sqldata['default_dataparam']))
        {
            if(empty($userId))
                $userId = $this->accountId;
     
            $sqlParam[':userId'] = array ($userId,PDO::PARAM_STR);
        }
        //拼接where
        $where= empty($where) ? "" : " WHERE " . trim((substr(trim($where),0,3)==='AND' ? substr(trim($where),3) : trim($where)));

        //处理回显字段 开始
        //GET传入需要的字段
        $fields_arr = array_unique(explode(',', $fields) );
        //print_r($fields_arr);
        unset($fields);
        //比较回显字段  array_intersect 比较值
        $result_fields = array_intersect($fields_arr, array_keys( $provideFieldsArray ) ) ;        
        if(empty($result_fields))
        {
            $result_fields = array_keys($provideFieldsArray);
        }
        $sqldata['resultfield'] = $result_fields;//$this->getSqlResultFields($result_fields, $sqldata['fields']);
        //处理回显字段 结束
        //处理排序
        if(!empty($sqldata['order'])) {
            $sqldata['order'] = ' '. trim($sqldata['order']);
        }
        $sort = $this->parseOrder($sort, $allFieldsArray);
        $sqldata['order'] = empty($sort) ? $sqldata['order'] : $sort;
        $sqldata['where'] = $where;
        $sqldata['data'] = $sqlParam;
        $sqldata['sql'] = (string)$sqldata['sql'];
        return true;
    }
    /**
     * 拼接sql 返回字段
     * @param array $resultFields 返回字段
     * @param array $provideFields 字段映射
     * @return string
     */
    private function getSqlResultFields($resultFields,$provideFields){
        $fileds = '';
        foreach ($resultFields as $v)
        {
            $fileds.= (!isset($provideFields[$v]['mapdb']) || $provideFields[$v]['mapdb']===$v) ? '`'.$v . '`,' : $provideFields[$v]['mapdb'] .' AS `'. $v .'`,';
        }
        return rtrim($fileds,',');
    }
    /**
     * 排序 处理验证
     * @param string $sort
     * @param array $allFieldsArray
     * @return Ambigous <NULL, string>|NULL
     */
    protected function parseOrder($sort,$allFieldsArray)
    {
        if(empty($sort))
        {
            return null;
        }
        
        $sort = str_replace(array(' '), array( ','), $sort);
        $arr = array_filter(explode(';', $sort));
        $sort = '';
        foreach($arr as $item)
        {
            $var = explode(',', $item);            
            //验证字段 stru
            if( empty($var) || !array_key_exists($var[0],$allFieldsArray) )
            {
                continue;
            }
            //print_r( $var );
            $descAsc = (isset($var[1]) && strtoupper($var[1])=='ASC') ? 'ASC' : 'DESC';
            //拼接
            $sort.= $allFieldsArray[ $var[0] ] .' ' . $descAsc . ',';
        }
        $sort = rtrim($sort,',');
        $sort = empty($sort) ? null : ' ORDER BY ' . $sort;        
        return $sort;
    }
    
    /**
     * 获取数据
     * @param array $sqldata
     * @param string $connection
     * @param string $iscount  只返回数量
     * @param int    $ifcount [<是否返回数量，1是>]
     * @return multitype:number |multitype:number unknown
     */
    public function getData(&$sqldata,$dataColumnName='data', $callable = 'callable_data',$iscount=false) {
        $numfound = 0;
        $pageSize = $sqldata['pagesize'];
        $start = $sqldata['start'];
        $connection = $this->getConnection();
        $ifcount  = intval( $this->getRequest()->get('ifcount') );
        
        if(!in_array($ifcount, array(0,1,2))) {
            $ifcount = 0;
        }
        //是否有缓存策略
        $isCache = false;
        if(isset($sqldata['pkField'])){
            $redis = $this->container->get("predis_service");
            if($redis->isActive()){
                $isCache = true;
                $cacheKey = $this->getCacheKey($sqldata['pkValue'],$sqldata['pkField']);
            }
        }
        if(0 === $ifcount || 1 === $ifcount) {
            //获取多条数据
            if($sqldata['limit']!=1 && !$isCache)
            {
                // 获取总条数SQL                
                //无记录或只有count数据时返回
                if( true==$iscount || 1 === $ifcount)
                {
                    if(empty($sqldata['where']) && isset($sqldata['sql_count']) && !empty($sqldata['sql_count'])){
                        $sth = $connection->prepare ( $sqldata['sql_count'] );
                    }else{
                        $sqlcount = sprintf((string)$sqldata['sql'],'COUNT(*)',$sqldata['where'],'');            
                        $sth = $connection->prepare ( $sqlcount );
                        $this->pdoBindValue($sth, $sqldata['data']);
                    }
                    $sth->execute ();
                    $numfound = intval($sth->fetchColumn());
                    return array( 'numfound' => $numfound);
                }            
            }
        }
        //注键查询或强制只查一条
        if($isCache || $sqldata['limit']===1) {
            $pageSize = 1;
            $start = 0;
        }
        $data = array();
        $returnc = function($data,$obj,$limit=0,$count=0) use($callable,&$numfound,$start,$dataColumnName){
                //回调函数处理数据
                if(!empty($data) && !empty($callable) && in_array($callable, get_class_methods($obj)))
                {
                    $data = array_map(array($obj,$callable), $data );
                }
                if( $limit===1 ) {
                    if(!empty($data))
                        return $data[0];//print_r($data);
                    else 
                        return array();
                }
                if (0 != $count) {
                    $numfound = $count;
                }
                return array( 'numfound' => $numfound ,'start' => $start,$dataColumnName => $data);
        };
        //检查缓存数据
        if($isCache){
            if($redis->exists($cacheKey)){
                $data[0] = $redis->hGetAll($cacheKey);
                $data[0] = $this->walkData($data[0],$sqldata['resultfield']);
                $numfound = 1;
                return $returnc($data,$this,$sqldata['limit']);
            }
        }
        $sqldata['sql'] .=  ' LIMIT :start, :pagesize';

        $sqldata['data'] [':start'] = array (
                $start,
                PDO::PARAM_INT
        );
        $sqldata['data'] [':pagesize'] = array (
                $pageSize,
                PDO::PARAM_INT
        );
        //返回字段

        $result_fields = $this->getSqlResultFields($sqldata['resultfield'], $sqldata['fields']).$sqldata['append_fields'];

        //无缓存主键查询，缓存所有字段
        if($isCache){
            $result_fields = $this->getSqlResultFields(explode(',',$sqldata['provide_max_fields']), $sqldata['fields']).$sqldata['append_fields'];
        }
        $sql = sprintf($sqldata['sql'],' SQL_CALC_FOUND_ROWS '.$result_fields,$sqldata['where'],$sqldata['order']);

        $sth = $connection->prepare ( $sql );
        $this->pdoBindValue($sth, $sqldata['data']);
        $sth->execute ();        
        $data =  $sth->fetchAll () ;
        $sql_1 = " SELECT found_rows() AS rowcount ;";
        $sth_1 = $connection->prepare ( $sql_1 );
        $sth_1->execute ();        
        $count =  $sth_1->fetchColumn();
        if($isCache || $sqldata['limit']===1 || 2 === $ifcount) {
            $numfound = $count;
        }
        if($isCache && $data){            
            //写缓存
            $redis->hMset($cacheKey,$data[0]);
            $data[0] = $this->walkData($data[0],$sqldata['resultfield']);
        }
        return $returnc($data,$this,$sqldata['limit'],$count);
        //print_r($sqldata);
        /*
         if($sqldata['limit']!==1)
         {*/
            /*
        }else{
            $data = $sth->fetch ();
            //回调函数处理数据
            if(!empty($data) && !empty($callable) && in_array($callable, get_class_methods($this)))
            {
                array_walk( $data ,array($this,$callable) );
            }
            if($data === false)
                return array();
            return $data ;
        }
        */
    }
    
    /**
     * 用于读取缓存中的数据 取$data数据，用 $filterArray 过滤
     * @param array $data
     * @param arrat $filterArray
     * @return array
     *      */
    private function walkData($data,$filterArray){
       $result = array();
       foreach ($data as $k=>$v){
           if(!in_array($k, $filterArray))
               continue;
           $result[$k] = $v;
       }
       return $result;
    }

	/**
	*  check login user snsAccount 
	*  $userid userid(basic)
	**/
    public function checkSnsAccount($userId)
    {
        return true;//\/sns/account接口取消
        $result = $this->getManager()->getRepository('OradtStoreBundle:SnsAccount')
            ->findOneBy(array('accountId' => $userId));
        if(!empty($result) && $result->getStatus()==='active'){
            return true;
        }
        return false ;
    }

    /**
     * @param $userId
     * @return string|Response
     */
    public function checkBasicHrType($userId)
    {
        $globalBase = $this->container->get('global_base');
        $userType = ''; //recruiter,manager,candidate

        $recruiter = $globalBase->findOneBy(Codes::HR_RECRUITER, array('userId' => $userId));
        if (!$recruiter) {
            $candidate = $globalBase->findOneBy(Codes::HR_CANDIDATE, array('userId' => $userId));
            if ($candidate) {
                $userType = 'candidate';
            } else {
                return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
            }
        } else {
            $bizdepId = $recruiter->getDepId();
            $bizdep = $globalBase->findOneBy(Codes::HR_DEPARTMENT, array('depId' => $bizdepId));
            if ($bizdep) {
                if ($bizdep->getManagerId() !== $recruiter->getRecruiterId()) {
                    $userType = 'recruiter';
                } else {
                    $userType = 'manager';
                }
            }
        }
        return $userType;
    }
    /**
     * 组装图片返回地址
     */
    protected function getResurl($resurl){
        if (!empty($resurl)) {
            if( false !== stripos( $resurl, 'https://' ) ){
                return $resurl;
            }
            return $this->container->getParameter("HOST_URL") .'/download?path=' .$resurl;
        }
        return "";
    }
    /*
     * 执行SQL返回数组
     *
     * */
    protected function query($sql){
        $em = $this->getDoctrine()->getManager();
        $pdo = $em->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    
    /**
     * 国家移动区域码
     */
    protected function getMobileAreaCode(){
        $codeArr = array('86');
        return $codeArr;
    }

    /*
     * 获取名片设备来源
     * */
    public function getSourceType(){
        $deviceType = $this->login_device_type;
        if(!empty($deviceType)){
            if($deviceType == "ios" || $deviceType == "android"){
                $deviceType = "app";
            }
        }else{
            $deviceType = "app";
        }
        return $deviceType;
    }
}
