<?php
namespace Oradt\WeixinBizBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\RandomString;
use Oradt\StoreBundle\Entity\WeixinBusinessNote;
use Oradt\StoreBundle\Entity\WeixinBusinessNoteCard;
/**
 *
 * @var 商务会谈
 * @version 0.0.1
 * @author ZG
 */
class BusinessNoteController extends BaseController
{

    public function postAction($act)
    {
        switch ($act) {
            case 'add':
                return $this->_add(); // 添加
                break;
            case 'edit':
                return $this->_edit(); // 修改
                break;
           case 'del':
                return $this->_delete(); // 删除
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    private function _add()
    {
        $this->checkAccountV2();
        $request = $this->getRequest();
        $note_type = $this->strip_tags($request->get('notetype')); //
        $cardid = $this->strip_tags($request->get('cardid')); //
        $note = $this->strip_tags($request->get('note', '')); //
        $picture    =$request->files->get('picture');//缩略图  
        $address = $this->strip_tags($request->get('address')); //
        $addid = $this->accountId;
        $bizId = $this->bizId;
        
        if (empty($cardid)||empty($note)||empty($address)||empty($note_type)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
 
        $em = $this->getDoctrine()->getManager(); // 添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();  
          
            $wxBusindess = new WeixinBusinessNote();
             
              // 添加信息
            if(is_array($picture)){
                $dirs_upload = $this->container->get('dirs_service');
                foreach ($picture as $_picture){
                    $uuid = RandomString::make(32);
                    $uparr = $dirs_upload->getCardDir($bizId,$uuid);
                    $uparr['filename'] = 'p_' . RandomString::make(10).date('YmdHis');
                    $picture_url[] = $dirs_upload->uploadFile($_picture,$uparr);
                }
                $picture_url_str=implode(',', $picture_url);
                $wxBusindess->setPicture($picture_url_str);
            }
            $wxBusindess->setCardId($cardid);
            $wxBusindess->setNoteType($note_type);
            $wxBusindess->setBizId($bizId);
            $wxBusindess->setNote($note);
            $wxBusindess->setAddress($address);
            $wxBusindess->setAddId($addid); 
            $wxBusindess->setCreateTime($createTime);
            $wxBusindess->setIsDel(0);  
            $em->persist($wxBusindess);  
            $em->flush();
            
            $noteId  = $em->getConnection()->lastInsertId();
             
            //记录中的名片
       
            $cardid_arr = explode(',', $cardid);
            foreach ($cardid_arr as $_cardid){
                $wxBusindesscard = new WeixinBusinessNoteCard();
                $wxBusindesscard->setCardId($_cardid);
                $wxBusindesscard->setNoteId($noteId);
                $em->persist($wxBusindesscard);
                $em->flush();
            }
            

            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
        
        
       
    }

    private function _edit()
    {  
        $this->checkAccountV2();
        $request = $this->getRequest();
        $id = $this->strip_tags($request->get('id')); 
        
        $note_type = $this->strip_tags($request->get('notetype')); //
        $cardid = $this->strip_tags($request->get('cardid')); //
        $note = $this->strip_tags($request->get('note', '')); //
        $picture    =$request->files->get('picture');//图
        $address = $this->strip_tags($request->get('address')); //
        $addid = $this->accountId;
        $bizId = $this->bizId;
      
        if (empty($id)||(empty($note)&&empty($address))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
     
        $em = $this->getDoctrine()->getManager(); // 添加事物
        $em->getConnection()->beginTransaction();
        try {
            
            $wxBusindess = $this->getDoctrine()
                ->getRepository('OradtStoreBundle:WeixinBusinessNote')
                ->findOneBy(array(
                'id' => $id
            )); 
            $modifyTime = $this->getTimestamp();
            if(!empty($note_type))
                $wxBusindess->setNoteType($note_type);
            if(!empty($note))
                $wxBusindess->setNote($note);
            if(!empty($address)) 
                $wxBusindess->setAddress($address);
            if(!empty($cardid))
                $wxBusindess->setCardId($cardid);
            $wxBusindess->setModifyTime($modifyTime);
            $em->persist($wxBusindess);
            $em->flush();
            
            
            //记录中的名片  
            $deleteCardSql = "DELETE FROM  weixin_business_note_card WHERE note_id=:noteid"; 
            $em->getConnection()->executeQuery($deleteCardSql, array(':noteid' => $id));
    
            $cardid_arr = explode(',', $cardid); 
            foreach ($cardid_arr as $_cardid){
                $wxBusindesscard = new WeixinBusinessNoteCard();
                $wxBusindesscard->setCardId($_cardid);
                $wxBusindesscard->setNoteId($id);
                $em->persist($wxBusindesscard);
                $em->flush();
            } 
            
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    private function _delete()
    { 
        $this->checkAccountV2();
        $request = $this->getRequest();
        $id = $this->strip_tags($request->get('id')); 
        $addid = $this->accountId;
        $bizId = $this->bizId;
    
        if (empty($id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
    
        $em = $this->getDoctrine()->getManager(); // 添加事物
        $em->getConnection()->beginTransaction();
        try {
            
            $ids = explode(',', $id);
            if (count($ids)==1){ 
                $wxBusindess = $this->getDoctrine()
                ->getRepository('OradtStoreBundle:WeixinBusinessNote')
                ->findOneBy(array(
                    'id' => $id,
                    'isDel'=>0
                ));
                if (empty($wxBusindess)) {
                    $fail[] = $id; 
                }else{
                    $wxBusindess->setIsDel(1); 
                    $em->persist($wxBusindess);
                    $em->flush();
                    $succ[] = $id;
                }
                
                $deleteCardSql = "DELETE FROM  weixin_business_note_card WHERE note_id=:noteid";
                $em->getConnection()->executeQuery($deleteCardSql, array(':noteid' => $id));
                
                $returnArr = array( 'fail'=>$fail,'succ'=>$succ);
            }else{
                // 添加员工登录信息
                foreach ($ids as $eid) {
                    if (empty($eid))
                        continue ;
                    $wxBusindess = $this->getDoctrine()
                        ->getRepository('OradtStoreBundle:WeixinBusinessNote')
                        ->findOneBy(array(
                            'id' => $eid,
                            'isDel'=>0
                        ));
                    if (empty($wxBusindess)) {
                        $fail[] = $eid;
                        continue ;
                    }  
                    $wxBusindess->setIsDel(1);
                    $em->persist($wxBusindess);
                    $em->flush();
                    $succ[] = $eid;
                    
                    $deleteCardSql = "DELETE FROM  weixin_business_note_card WHERE note_id=:noteid";
                    $em->getConnection()->executeQuery($deleteCardSql, array(':noteid' => $eid));
                } 
                $returnArr = array( 'fail'=>$fail,'succ'=>$succ);          //返回数组
            }
    
            $em->getConnection()->commit();
            return $this->renderJsonSuccess($returnArr);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * get
     */
    public function getAction($act)
    {
        switch ($act) {
            case 'getbusinessnotlist':
                return $this->_getBusinessNoteList();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /**
     *
     * @todo 获取 列表信息
     */
    private function _getBusinessNoteList()
    {
        $this->checkAccountV2();
        $bizId=$this->bizId;
        $request = $this->getRequest();
        $card_id = $this->strip_tags($request->get('card_id'));
        
        $where=" a.biz_id='{$bizId}'";//只展示本公司的商谈记录
        
        if(empty($card_id)){
            $sql="SELECT %s FROM `weixin_business_note` as a  
                      left join `wx_biz_employee` as b on a.add_id=b.id 
                      left join `weixin_business_note_type` as c on a.note_type=c.id 
                        %s%s";
        }else{
            $sql="SELECT %s FROM `weixin_business_note` as a
                      left join `weixin_business_note_card` as d on d.note_id=a.id  
                      left join `wx_biz_employee` as b on a.add_id=b.id
                      left join `weixin_business_note_type` as c on a.note_type=c.id
                        %s%s";
            $where.=" and d.card_id=".$card_id;
        }
 
        
        $sqldata = array(
            'fields' => array(
                'id' => array(
                    'mapdb' => 'a.id',
                    'w' => ' AND a.id = :id'
                ), 
                'cardid' => array(
                    'mapdb' => 'a.card_id' 
                ), 
                'note' => array(
                    'mapdb' => 'a.note'
                ),
                'notetype' => array(
                    'mapdb' => 'a.note_type',
                    'w' => ' AND a.note_type = :notetype'
                ),
                'address' => array(
                    'mapdb' => 'a.address'
                ),
                'begintime' => array(
                    'mapdb' => 'a.begin_time',
                    'w' => 'Range'
                ),
                'endtime' => array(
                    'mapdb' => 'a.end_time',
                    'w' => 'Range'
                ),
                'createtime' => array(
                    'mapdb' => 'a.create_time',
                    'w' => 'Range'
                ),
                'addid' => array(
                    'mapdb' => 'a.add_id',
                    'w' => ' AND a.add_id = :addid'
                ),
                'superiorid' => array(
                    'mapdb' => 'b.superior',
                    'w' => ' AND b.superior = :superiorid'
                ),
                'deparmtmentid' => array(
                    'mapdb' => 'b.superior',
                    'w' => ' AND b.deparmtment = :deparmtmentid'
                ),
                'createtime' => array(
                    'mapdb' => 'a.create_time',
                    'w' => 'Range'
                )
            )
            ,
            'default_dataparam' => array(),
            'sql' => $sql,
            'where' => $where,
            'order' => '',
            'provide_max_fields' => 'id,cardid,note,notetype,address,addid,superiorid,deparmtmentid,createtime'
        );
  
        $check = $this->parseSql($sqldata);
  
        if (true !== $check) {
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata);
        
        $weixin_card_service = $this->container->get('wechat_service');
        $em = $this->getDoctrine()->getManager();
      
        $list=$data["data"]; 
        foreach ($list as $key=>$value){ 
            $_sql = "SELECT id,vcard FROM `wx_biz_card` where id in(".$value['cardid'].") ";  
            $res = $em->getConnection()->executeQuery($_sql); 
            $card_name=array();
            foreach ($res as $v){
                $vcard_arr=json_decode($v["vcard"],true);
                if(!empty($vcard_arr["front"]))
                     $card_info= $weixin_card_service->_getVcardSingleData($vcard_arr["front"]); 
                if(!empty($card_info["FN"]))
                    $card_name[]=$card_info["FN"];
                elseif(!empty($card_info["ENG"]))
                    $card_name[]=$card_info["ENG"];
                else{
                    $card_info= $weixin_card_service->_getVcardSingleData($vcard_arr["back"]);
                    if(!empty($card_info["FN"]))
                        $card_name[]=$card_info["FN"];
                    elseif(!empty($card_info["ENG"]))
                        $card_name[]=$card_info["ENG"];
                }
            } 
            $data["data"][$key]["card_name"]=implode(',', $card_name);
             
        } 
        
        return $this->renderJsonSuccess($data);
    }
}