<?php
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\StoreBundle\Entity\YpBizCategoryMap;
use PDO;
class YpsService extends BaseService {
    
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    
    /**
     * getting resource http url from dbpath
     * @param string $resurl
     * @return string
     */
    public function getResourceUrl($dbpath) {
        if (empty ( $dbpath ))
            return "";
        return $this->container->getParameter("HOST_URL") . '/yps/bizproduct/resource/download' . '?path=' .substr($dbpath, 10);
    }

    /**
     * getting biz resource file save path
     *
     * @param string $userId
     * @param string $directoryId
     * @return array()
     */
    public function getYpsResourcePath($userId,$directoryId='')
    {
        $docroot = $this->container->getParameter('DOC_ROOT');
        $dir = $this->container->getParameter('YPS_RES_DIR'); //获取文档配置文件上传路径
        $str = substr($userId, 1, 3);
        $path = $dir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userId . '/';
        if(!empty($directoryId))
        {
            $path .= $directoryId . '/';
        }
        return array('DOC_ROOT' => $docroot , 'PATH' => $path );
    }
    
    public function findBizInfo($bizId)
    {
        return $this->em->getRepository("OradtStoreBundle:YpBiz")->findOneBy( array("bizId" => $bizId ) );
    }
    
    public function findBizBranchInfo($params = array())
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizBranchOffice")->findOneBy( $params );
    }
    
    public function findProductById( $productid )
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizProduct")->findOneBy( array("productId" => $productid)  );
    }
    
    public function findResourceById( $resourceid )
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizProductResource")->findOneBy( array("resId" => $resourceid)  );
    }

    public function findBizCategory( $params = array() )
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizCategory")->findBy( $params );
    }

    public function hasBizCategoryId( $categoryid )
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizCategory")->findOneBy( array('categoryId' => $categoryid) );
    }

    public function findProductCategory( $params = array() )
    {
        return $this->em->getRepository("OradtStoreBundle:YpProductCategory")->findBy( $params );
    }

    public function hasProductCategoryId( $categoryid )
    {
        return $this->em->getRepository("OradtStoreBundle:YpProductCategory")->findOneBy( array('categoryId' => $categoryid) );
    }
    
    public function findBizCategoryByOne($bizId,$categoryId)
    {
        return $this->em->getRepository("OradtStoreBundle:YpBizCategoryMap")->findOneBy(
                array( 'bizId'=> $bizId ,'categoryId' => $categoryId));
        
    }
    public function addBizCategory($bizId,$category , $type='category1')
    {
        if(empty($category))
            return false;
        $categoryArray = array_unique(explode(',', $category));
        if(empty($categoryArray) || count($categoryArray)<1)
            return false;
        
        $this->getConnection()->executeUpdate("DELETE FROM yp_biz_category_map WHERE biz_id=:id AND `type`=:type",
                array(':id' => $bizId ,':type' => $type));
        
        foreach ($categoryArray as $item) {
            $map = new YpBizCategoryMap();
            $map->setBizId($bizId);
            $map->setCategoryId(intval($item));
            $map->setType($type);
            $this->em->persist($map);
            $this->em->flush();
            
        }
        
        return true;
    }
    
    /**
     * update biz total num
     * @param string $categoryId
     * @param string add or delete
     */
    public function updateBizTotal($categoryId , $type='add') {
        $sql ="update yp_biz_category SET totalbiz=totalbiz+1 WHERE category_id=:id";
        if($type==='delete') 
            $sql ="update yp_biz_category SET totalbiz=totalbiz-1 WHERE category_id=:id";
        $this->getConnection()->executeQuery($sql,
                array(':id' => $categoryId));
    }
    
    public function updateBizDetail($bizId,$country,$region) {
        $bizDetail = $this->em->getRepository("OradtStoreBundle:AccountBizDetail")->findOneBy
        ( array('bizId' => $bizId) );
        if(empty($bizDetail)) {
            return false;
        }
        if(!empty($region)) {
            $bizDetail->setRegion($region);
        }
        if(!empty($country)) {
            $bizDetail->setCountryid($country);
        }
        $this->em->persist($bizDetail);
        $this->em->flush();
        return true;
    }
    
    /*
     * delete biz account yps data
     */
    public function deleteBizYps($bizid)
    {
        
        return true;
    }
}