<?php
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
class BizTagsController  extends BaseController{
    public function postAction(){
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN) {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId = $this->accountId;
        $request = $this->getRequest();
        $tags = trim($request->get("tags"));
        $time = $this->getTimestamp();
        if(empty($tags)){
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $sql="SELECT * FROM account_biz_tags WHERE tags=:tags";
        $tagsarr = $this->getConnection()->executeQuery($sql,array('tags'=>$tags))->fetch();
        if(!empty($tagsarr)){
            if($tagsarr['operation'] == 'add'){
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_DATA_EXISTS );
            }else{
                $sqlupdate="UPDATE account_biz_tags SET operation='add' WHERE id=:id";
                $this->getConnection()->executeQuery($sqlupdate,array('id'=>$tagsarr['id']));
            }
        }else{
            $sqlinsert="INSERT INTO account_biz_tags (tags,user_id,create_time,operation) VALUES ('".$tags."','".$userId."',".$time.",'add')";
            $this->getConnection()->executeQuery($sqlinsert);
        }
        return $this->renderJsonSuccess();
    }

    public function getAction(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        if ($this->accountType !== self::ACCOUNT_ADMIN) {
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id' => array('mapdb' => 'id', 'w' => ' AND id = :id'),
                'tags' => array('mapdb' => 'tags', 'w' => ' AND tags LIKE :tags'),
                'createtime' => array('mapdb' => 'create_time', 'w' => 'Range'),
                'userid' => array('mapdb' => 'user_id', 'w' => ' AND user_id LIKE :userid'),
                'operation' => array('mapdb' => 'operation', 'w' => " AND operation = :operation"),
            ),
            'sql' => 'SELECT  %s FROM `account_biz_tags`  %s%s',
            'where' => '',
            'order' => ' ORDER BY id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,tags,createtime,userid,operation',
        );
        $check = $this->parseSql($sqldata);
        if (true !== $check) {
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata, 'list' ,'callable_data_tags');
        return $this->renderJsonSuccess($data);

    }
    public function callable_data_tags($item){
        if (isset ( $item ['userid'] ) && ! empty ( $item ['userid'] )) {
            $sql="SELECT real_name FROM account_basic_detail WHERE user_id=:userid";
            $tagsarr = $this->getConnection()->executeQuery($sql,array('userid'=>$item['userid']))->fetch();
            $item['realname'] = $tagsarr['real_name'];
        }
        return $item;
    }

    public function  deleteAction(){
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN) {
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId = $this->accountId;
        $request = $this->getRequest();
        $id = trim($request->get("id"));
        if(empty($id)){
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $sql="SELECT * FROM account_biz_tags WHERE id=:id";
        $tagsarr = $this->getConnection()->executeQuery($sql,array('id'=>$id))->fetch();
        if(empty($tagsarr)){
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_DATA );
        }
        $updatesql="UPDATE account_biz_tags SET operation='delete' WHERE id=:id";
        $this->getConnection()->executeQuery($updatesql,array('id'=>$id));
        return $this->renderJsonSuccess();
    }
    
    
}

