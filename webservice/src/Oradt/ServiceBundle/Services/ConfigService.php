<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\Utils\RandomString;
use Oradt\Utils\Errors;
use Oradt\StoreBundle\Entity\UserWebConfig;
use Oradt\StoreBundle\Entity\UserConfigSync;
use Oradt\StoreBundle\Entity\Background;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils;

class ConfigService extends BaseService {
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    /**
     * 查找一条配置数据
     * @param unknown $array
     */
    public function findWebConfigOneBy($array)
    {
        $repository = $this->em->getRepository ( 'OradtStoreBundle:UserWebConfig');
        return $repository->findOneBy ( $array );
    }
    /**
     * 查找一条同步数据
     * @param unknown $array
     */
    public function findConfigSyncOneBy($array)
    {
        $repository = $this->em->getRepository ( 'OradtStoreBundle:UserConfigSync');
        return $repository->findOneBy ( $array );
    }
    /**
     * 保存个人配置信息
     * @param SnsTrends $SnsTrends
     * @return $SnsTrends
     */
    public function saveUserWebConfig(UserWebConfig $UserWebConfig)
    {
        $this->em->persist($UserWebConfig);
        $this->em->flush();
        return $UserWebConfig;
    }
    /**
     * 配置同步更新指令
     * @param  UserWebConfig $paramArr['userId']
     * @param  UserWebConfig $paramArr['moduleId']
     * @param  UserWebConfig $paramArr['operation']
     * @param  UserWebConfig $paramArr['lastModifyTime']
     * @return UserWebConfig
     */
    public function updateConfigDataSync(array $paramArr){
        //终端数据同步数据更新
        $findSyncArray = array (
            'userId'   => $paramArr['userId'],
            'moduleId' => $paramArr['moduleId'],
            'type'     => $paramArr['type']
        );
        $configSync = $this->findConfigSyncOneBy ( $findSyncArray );
        if(empty($configSync)){
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
        }
        $configSync->setLastModified ( $paramArr['lastModifyTime'] );
        $configSync->setOperation ( $paramArr['operation'] );
        $this->em->persist ( $configSync );
        $this->em->flush ();
        return TRUE;
    }
    
}