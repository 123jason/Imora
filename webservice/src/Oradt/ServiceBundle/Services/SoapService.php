<?php
namespace Oradt\ServiceBundle\Services;

use Oradt\Utils\RandomString;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\Utils\Password;
use Oradt\StoreBundle\Entity\SmsMessage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * IM接口操作service
 */
class SoapService  extends BaseService {

    private $SoapClient;
    public function __construct(ContainerInterface $container) {
        /*
        parent::__construct($container);
        ini_set("soap.wsdl_cache_enabled", "0");
        $this->wsdlUrl  = dirname(__DIR__) .'/Resources/ConfWebServiceInterface.wsdl';
        $this->location = $this->container->getParameter('IM_WEBSERVICE_URL');//'http://123.57.12.84:5555';
        $this->connectTimeOut = 2;    //连接超时 单位秒
        require_once dirname(__FILE__) . '/File/Sms/ClientSoap.php';
        */
    }
    /**
     * 添加用户
     * @param string $accountid Oradt用户ID 或企业账户ID
     * @param string $account   注册账号
     * @param string $passwd    密码 需要md5 加密 注：要经过MD5加密后传进来
     * @param string $type      类型  是basic 还是 biz账户
     */
    public function addImUser($accountid,$account,$passwd,$type=Codes::BASIC){
        return true;
        //return true;
        $param  = "<user><account>".$accountid."</account><password>".$passwd."</password></user>";
        $res    = $this->SoapClient->AddUser($param);

        if($res){
            //修改对应账户的IMID
            $imId          = (int)$res;
            //$accountBaseic = $this->container->get('account_basic_service');
            //$accountBaseic->setImid($accountid,$imId);
            switch ($type){
                case Codes::BIZ:
                    $this->setBizImid($accountid, $imId);
                    break;
                case Codes::BASIC:
                    $this->setImid($accountid, $imId);
                    break;
            }
            return TRUE;
        }else{
            $this->baseLogger->info('  SoapService  id：' . $accountid . '-----account：' . $account . '-----type：' . $type.'---'.$res);
            return FALSE;
        }
    }
    /**
     * 更改 Oradt biz 的Imid
     * @param string $userId    云端账户ID
     * @param int    $imId      im账户ID
     */
    public function setBizImid($bizId,$imId) {
        return true;
        $params = array(':bizid' => $bizId);
        $sql    = 'SELECT imid FROM account_biz_detail WHERE biz_id=:bizid LIMIT 1';
        $bizInfo = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        if(empty($bizInfo))
            return false;
        if(isset($bizInfo['imid']) && empty($bizInfo['imid'])) {
            $params[':imid'] = $imId;
            $sql = "UPDATE account_biz_detail SET imid=:imid WHERE biz_id=:bizid";
            $this->em->getConnection()->executeUpdate($sql,$params);
        }
        return true;
    }
    /**
     * 更改 Oradt account 的Imid
     * @param string $userId    云端账户ID
     * @param int    $imId      im账户ID
     */
    public function setImid($userId,$imId) {
        return true;
        $params = array(':userid' => $userId);
        $sql    = 'SELECT imid FROM account_basic_detail WHERE user_id=:userid LIMIT 1';
        $userInfo = $this->em->getConnection()->executeQuery($sql,$params)->fetch();
        if(empty($userInfo))
            return false;
        if(isset($userInfo['imid']) && empty($userInfo['imid'])) {
            $params[':imid'] = $imId;
            $sql = "UPDATE account_basic_detail SET imid=:imid WHERE user_id=:userid";
            $this->em->getConnection()->executeUpdate($sql,$params);
            $sql = "UPDATE account_friend SET imid=:imid WHERE fuser_id=:userid";
            $this->em->getConnection()->executeUpdate($sql,$params);
        }
        return true;
    }
    /**
     * 修改 IM 用户密码
     * @param string $userid 账户ID
     * @param string $pwd 新密码
     */
    public function UpdateUserPwd($accountid,$passwd){
        return true;
        $param  = "<user><password>".$passwd."</password></user>";

        try{
            //echo __FILE__ . $passwd .'___' . $accountid;
            $res    = $this->SoapClient->UpdateUserPwd($accountid,$passwd);
            if($res){
                return true;
            }else{
                return false;
            }
        }  catch (\Exception $e){
            //return false;
            return $e->getMessage();
        }
    }
    /*
     *@param string $accountid1 当前账户ID
     * @param string $accountid2 黑名单ID
     * */
    public function DelBlackList($accountid1 , $accountid2){
        return true;
        try{
            $res    = $this->SoapClient->DelBlackList($accountid1,$accountid2);
            return true;
        }  catch (\Exception $e){
            //return false;
            return $e->getMessage();
        }
    }
}