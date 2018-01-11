<?php

/**
 * 鉴权登录错误
 */

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\StoreBundle\Entity\LoginSession;
use Oradt\StoreBundle\Entity\AccountBasicLoginRecord;
use Oradt\StoreBundle\Entity\AccountBizLoginRecord;
use Oradt\StoreBundle\Entity\AccountEmployeeLoginRecord;
use Oradt\Utils\RandomString;
use Oradt\Utils\Password;
use Oradt\Utils\Codes;
use PDO;

class OauthErrorService extends BaseService
{

    /**
     * __construct
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger, $container)
    {
        //$this->em = $entityManager;
        // $this->logger = $logger;
        //$this->container = $container;
        parent::__construct($container);
    }   
    public function checkError($data)
    {
        $accountid = $data['accountid'];
        $type      = $data['type'];
        $result    = $this->getError($data);
        $time = $this->getTimestamp();
        if ('login' == $type) {
            $totalNum = 4;
        }else{
            $totalNum = 5;
        }
        if (empty($result)) {
            //添加
            $this->addError($data);
            $res = 1;
        }else{
            //修改
            $errornum = $result['error_num'];
            $status   = $result['status'];
            //0添加errornum一次或者锁定
            if (0 == $status) {            
                if ($errornum < ($totalNum-1)) {
                    $data['status'] = 0;
                    $data['errornum'] = $errornum+1;
                    $res = 1;
                }else{
                    $data['status'] = 1;
                    $data['errornum'] = $totalNum;
                    $res = 2;
                }
                // 错误累计不能再同一秒内发生
                if ($result['last_error_time'] != $time) {
                    $this->putError($data);
                }                
            }else{
            //status = 1 判断最后当前时间是否大于错误时间
                $res = $this->checkErrorTime($data,$result);
            }            
        }
        return $res;
    }
    /**
     * 添加
     */
    public function addError($data)
    {
        $sql = "INSERT INTO `account_basic_password_error`(user_id,error_num,status,last_login_time,last_error_time,lock_time,type) VALUES (:userid, :errornum, :status, :logintime,:errortime,:locktime,:type)";
        if ('login' == $data['type']) {
            $type = 1;
        }else{
            $type = 2;
        }
            $params = array(
                ':userid'    => $data['accountid'],
                ':errornum'  => 1,
                ':status'    => 0,
                ':logintime' => $this->getTimestamp(),
                ':errortime' => $this->getTimestamp(),
                ':locktime'  => $this->getTimestamp(),
                ':type'      => $type,
                );
        $this->getConnection()->executeQuery($sql, $params);
    }
    /**
     * 修改
     */
    public function putError($data)
    {
        $errornum = $data['errornum'];
        $status   = $data['status'];
        $type     = $data['type'];
        if ('login' == $type) {
            $wt = 1;
        }else{
            $wt = 2;
        }
        $sql="UPDATE account_basic_password_error SET status=:status,error_num=:errornum,last_login_time=:logintime,last_error_time=:errortime,lock_time=:locktime WHERE user_id=:accountid AND type = :type";
        $params = array(
            ':errornum'  => $errornum,
            ':status'    => $status,
            ':logintime' => $this->getTimestamp(),
            ':errortime' => $this->getTimestamp(),
            ':locktime'  => $this->getTimestamp(),
            ':accountid' => $data['accountid'],
            ':type'      => $wt
            );
        $this->em->getConnection()->executeUpdate($sql,$params);
    }
    /**
     * 获得
     */
    public function getError($data)
    {
        $accountid = $data['accountid'];
        $type      = $data['type'];
        if ('login' == $type) {
            $wt = 1;
        }else{
            $wt = 2;
        }
        $sql = "SELECT * FROM `account_basic_password_error` WHERE user_id=:accountid AND type=:type LIMIT 1";
        $error = $this->getConnection()->executeQuery($sql, array(':accountid' => $accountid,":type"=>$wt))->fetch();
        return $error;
    }
    /**
     * 判断时间
     */
    public function checkErrorTime($data,$error)
    {
        $currentime = $this->getTimestamp();
        $errortime  = $error['last_error_time'];    
        $chatime    = $currentime - $errortime;        
        $success   = isset($data['success'])?$data['success']:0;
        //十分钟之后才可以登录
        switch ($success) {
            case 0:
                $res = $this->dealWithError2($data,$chatime,$error);
                break;
            case 1:
                $res = $this->dealWithError1($data,$chatime,$error);
                break;
            default:
                # code...
                break;
        }
        return $res;        
    }
    public function dealWithError1($data,$chatime,$error)
    {
        $status     = $error['status'];
        if ($chatime >= 600 || 0 == $status) {
            $data['status'] = 0;
            $data['errornum'] = 0;
            $this->putError($data);
            return 0;
        }else{
            return 5;
        }        
    }
    public function dealWithError2($data,$chatime,$error)
    {
        $status     = $error['status'];
        $errornum   = $error['error_num'];
        if ($chatime >= 600) {
            if (0 == $status && 0 == $errornum) {
                return 4;
            }else{
                $data['status'] = 0;
                $data['errornum'] = 1;
                $this->putError($data);
                return 1;
            }
        }else{
            return 5;
        }
    }
}
