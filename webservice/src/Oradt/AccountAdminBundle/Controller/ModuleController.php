<?php

namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Errors;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\AuthorityModule;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModuleController extends BaseController
{
    /**
     * test 获取模块
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function findAction() {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
        $id = intval ( $request->get ( "id" ) );
        
        if (0 == $id) {
            $sql = 'SELECT p.id,p.name FROM OradtStoreBundle:AuthorityModule p order by p.id desc';
            $query = $this->getDoctrine ()->getManager ()->createQuery ( $sql );
        } else {
            /*
             * 带条件查询 WHERE p.id = :id // setParameter('id', 13)->setFirstResult(5*2)->setMaxResults(2);//分页 生成出来 LIMIT 2 OFFSET 10
             */
            $sql = 'SELECT p.id,p.name FROM OradtStoreBundle:AuthorityModule p WHERE p.id = :id order by p.id desc';
            $query = $this->getDoctrine ()->getManager ()->createQuery ( $sql )->setParameter ( 'id', $id );
        }
        
        $result = $query->getResult ();
        
        return $this->renderJsonSuccess($result);
    }

    
    /**
     * 添加模块
     */
    public function addAction()
    {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
       
        $moduleName = $request->get("name");
        if( empty($moduleName) ){
        
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $em = $this->getDoctrine()->getManager();
       
        $authorityModule = new AuthorityModule();
        $authorityModule->setName($moduleName);
       
        $em->persist($authorityModule);
        $em->flush();
       
       //组织返回
        $moduleid = $authorityModule->getId();
        $data = array('modid'=>$moduleid);
        return $this->renderJsonSuccess($data);
        
    }
    
       
    /**
     * 更新模块
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
        $id = $request->get("id");  //$request->get 支持 获取 put delete get post 提交过来的数据
        $moduleName = $request->get("name");
        if( empty($moduleName) || empty($id) ){
        
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager();        
        $moduleInfo = $em->getRepository('OradtStoreBundle:AuthorityModule')
                ->findOneBy(array('id' =>$id));
        
        if (!empty($moduleInfo)) {
            $moduleInfo->setName($moduleName);
            $em->persist($moduleInfo);
            $em->flush();
        }
        
        return $this->renderJsonSuccess();
    }
    
    
    /**
     * 删除模块
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        //检查token
        $this->checkAccount();
        $id = $request->get("id");
        if( empty($id) ){
        
            return $this->renderJsonSuccess( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $em = $this->getDoctrine()->getManager();
        $moduleInfo = $em->getRepository('OradtStoreBundle:AuthorityModule')
                ->findOneBy(array('id' =>$id));
        
        
        if (!empty($moduleInfo)) {
            $em->remove($moduleInfo);
            $em->flush();
            $this->renderJsonSuccess();
        }
        return $this->renderJsonSuccess( Errors::$ERROR_PARAMETER_NOT_DATA );
    }
}

