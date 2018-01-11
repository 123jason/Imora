<?php

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\Codes;
class InitDataService extends BaseService
{

    private $logger;
    public function __construct(EntityManager $entityManager, $logger, ContainerInterface $container)
    {        
        $this->logger = $logger;
        parent::__construct($container);
    }

    /**
     * 个人账号初始化数据
     * @param unknown $userId
     */
    public function basicData($userId)
    {
        //$contactService = $this->container->get("account_contact_service");
        //$documentService = $this->container->get("account_document_service");
        //文档根目录
        //$directoryid = $documentService->addDirectory($userId);
        //'video','audio','picture','docts','other'
//        $documentService->addDirectory($userId,'video',$directoryid);
//        $documentService->addDirectory($userId,'audio',$directoryid);
//        $pictureId = $documentService->addDirectory($userId,'picture',$directoryid);
//        $documentService->addDirectory($userId,'card picture',$pictureId);
//        $documentService->addDirectory($userId,'other picture',$pictureId);
//        $documentService->addDirectory($userId,'logo',$directoryid);
//        $documentService->addDirectory($userId,'docts',$directoryid);
//        $documentService->addDirectory($userId,'other',$directoryid);
        //$groupId = $contactService->setDefaultContactGroup($userId);
        //VIP组
        
//        金：0，Gold
//        银：1，Silver
//        铜：2，Copper
//        家庭：3，Family
 
        //$groupId = $contactService->setDefaultContactCardGroup($userId, 'Gold', 0);
        //$groupId = $contactService->setDefaultContactCardGroup($userId, 'Silver', 1);
        //$groupId = $contactService->setDefaultContactCardGroup($userId, 'Copper', 2);
        //$groupId = $contactService->setDefaultContactCardGroup($userId, 'Family', 3);
        //我的名片
        //$groupId = $contactService->setDefaultContactCardGroup($userId, Codes::CONTACT_CARD_GROUP_MYCARDS, Codes::CONTACT_CARD_GROUP_MYCARDS_ORDER);

        //   创建三条任务 加入记录中。
/*

            $task = $this->container->get("account_relation_service");
            $params['userid']= $userId;
            $time = $this->getTimestamp();
            $params['start_time'] =$time +  86400*3;
            //$params['content']= "提示:下拉添加新任务";
            //$task->createTask($params);
            $params["content"]="提示:左滑标记任务完成或删除任务";
            $task->createTask($params);
            */
    }

    /**
     * 企业账号初始化企业分组数据
     * @param unknown $userId
     */
    public function bizData($bizId, $groupId)
    {
        $bizService = $this->container->get("account_biz_service");
        $bizService->initBizGroup($bizId, $groupId);
    }

}