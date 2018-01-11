<?php
namespace Oradt\ServiceBundle\Services;

use PDO;
use Oradt\StoreBundle\Entity\CommonSync;

class CommonSyncService extends BaseService {
    /**
     * 添加卡包操作记录
     * @param string $userId
     * @param string $uuid
     * @param string $operation
     * @param string $module
     */
    public function CommonSyncAdd($userId,$moduleid,$module,$operation){
        $param = array('moduleid'=>$moduleid,'userId'=>$userId);
        $sync = $this->em->getRepository("OradtStoreBundle:CommonSync")->findOneBy( $param);

        if(empty($sync)){
            $sync = new CommonSync();
            $sync->setModuleid($moduleid);
            $sync->setUserId($userId);
            $sync->setModule($module);
        }
        $sync->setOperation($operation);
        $sync->setModifedtime( $this->getDateTime() );
        $this->em->persist($sync);
        $this->em->flush();

        return $sync;
    }
}