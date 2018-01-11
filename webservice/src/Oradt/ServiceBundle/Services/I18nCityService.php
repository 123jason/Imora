<?php
/**
 * hr_service
 * @author wangxy
 * 2015-03-11
 */
namespace Oradt\ServiceBundle\Services;
use Oradt\StoreBundle\Entity\I18nCity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Exception\Exception;

class I18nCityService extends BaseService
{

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function findCityCodeAll()
    {
        $conn = $this->container->get('database_connection');
        $sql = "SELECT city.syscode FROM OradtStoreBundle:I18nCity city";

        try {
            // 组织查询参数结束
            $query = $this->em->createQuery($sql);
            $data = $query->getResult();
            return $data;

        } catch (\Exception $ex) {
            $this->logger('sql:' . $sql);
            return $this->renderJsonFailed(Errors::$ERROR_QUERY_EXCEPTION);
        }
    }
    
    /**
     * 获取一天早中晚
     */
    public function  getDay(){
        $hours    = date("H",time());
        $nowhours = (int)$hours;
        $day      = "";
        if($nowhours >=6  && $nowhours<10 )  $day = 0;       //早上
        if($nowhours >=10 && $nowhours<14 )  $day = 1;      //中午
        if($nowhours >=14 && $nowhours<18 )  $day = 2;      //下午
        if($nowhours >=18 && $nowhours<21 )  $day = 3;      //傍晚
        if($nowhours >=21 && $nowhours<23 )  $day = 4;      //夜里
        if($nowhours >=0  && $nowhours<6 )   $day = 4;      //夜里
        return $day;
    }
    
    /**
     * 获取当前季节
     */
    public function getNowSeason(){
        $date   = date("n",time());
        $season = "";
        if(in_array($date, array(3,4,5)))    $season = 0;      //春
        if(in_array($date, array(6,7,8)))    $season = 1;      //夏
        if(in_array($date, array(9,10,11)))  $season = 2;      //秋
        if(in_array($date, array(12,1,2)))   $season = 3;      //冬
        return $season;
    }
    
    /**
     * 根据天气的编码 转化为 0-5的编码
     * $code 请看天气预报编码表
     * 0：风 1：雨 2：雪 3:雾  4：云 5;晴 6;霾
     */
    public function getCodeBh($code){
        $nowCode = 5;   
        if(in_array($code, array(53,54,55,56))){
            $nowCode = 6;       //霾
        }
        if(in_array($code, array(0))){
            $nowCode = 5;       //晴
        }
        if(in_array($code, array(1,2))){
            $nowCode = 4;       //云
        }
        if(in_array($code, array(18,32,57,58))){
            $nowCode = 3;       //雾
        }
        if(in_array($code, array(13,14,15,16,17,26,27,28,33,49))){
            $nowCode = 2;       //雪
        }
        if(in_array($code, array(3,4,5,6,7,8,9,10,11,12,19,21,22,23,24,25))){
            $nowCode = 1;       //雨
        }
        if(in_array($code, array(20,29,30,31))){
            $nowCode = 0;       //风
        }
        return $nowCode;
    }
    
}
