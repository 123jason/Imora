<?php
/**
 * @todo 微信相关处理方法类
 * @var  get name wechat_service
 * @author xinggm 
 */
namespace Oradt\ServiceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\SaveFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Oradt\Utils\RandomString;

/**
 * ocr
 */
class WechatService extends BaseService
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     *
     * @todo 根据
     * @param $param string
     *            [userid] 根据userid获取
     * @param $param string
     *            [wechatid] 根据wechatid获取
     * @param $param string
     *            [unionid] 根据wechatid获取
     * @param $flag int
     *            1 userid,2wechatid
     * @return boolean
     */
    public function getWeChatInfoById($param, $flag = 1)
    {
        $res = array();
        if (empty($param))
            return $res;
        $where = $this->getWheres($flag);
        $where = $where . " '{$param}' LIMIT 1 ";
        $sql = "SELECT id as userid,wechat_id as wechatid,union_id as unionid,user_id as accountid FROM `weixin_user` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetch();
        return $res;
    }

    /**
     *
     * @todo 根据
     * @param $param string
     *            [userid] 根据userid获取
     * @param $param string
     *            [wechatid] 根据wechatid获取
     * @param $param string
     *            [unionid] 根据wechatid获取
     * @param $flag int
     *            1wechatid(微信openid), 2橙子userid,3微信唯一id, 4微信用户id 默认微信openid
     * @version 0.0.1 2017-10-11
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return boolean
     */
    public function getWeChatUserInfoById($param, $flag = 1)
    {
        $res = array();
        if (empty($param))
            return $res;
        $where = $this->getWheres($flag);
        $where = $where . " '{$param}' LIMIT 1 ";
        $sql = "SELECT id as userid,wechat_id as wechatid,union_id as unionid,user_id as accountid,biz_id as bizid,avatar_path as avatar,scanner_info as scannerinfo FROM `weixin_user` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetch();
        return $res;
    }

    /**
     *
     * @todo 根据id查询微信用户的名片信息
     * @param
     *            $id
     * @param bool $field            
     * @version 0.0.1 2017-10-11
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return array
     *
     */
    public function getWechatUserCardById($id, $field = true)
    {
        $res = array();
        if (empty($id) || intval($id) < 0) {
            return $res;
        }
        $where = "WHERE id = " . $id . " LIMIT 1 ";
        if ($field === true) {
            $field = "*";
        }
        $sql = "SELECT " . $field . " FROM `weixin_card` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetch();
        return $res;
    }

    /**
     *
     * @todo 根据id查询微信用户的名片list信息
     * @param $ids array            
     * @param $wechatId string            
     * @param bool $field            
     * @version 0.0.1 2017-10-11
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return array
     *
     */
    public function getWechatUserCardListByIds($ids, $wechatId, $field = true)
    {
        $res = array();
        if (empty($ids) || count($ids) < 1 || empty($wechatId) || strlen($wechatId) < 1) {
            return $res;
        }
        $ids = implode(",", $ids);
        $where = "WHERE wechat_id = '" . $wechatId . "' AND id in ( " . $ids . ")";
        if ($field === true) {
            $field = "*";
        }
        $sql = "SELECT " . $field . " FROM `weixin_card` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetchAll();
        return $res;
    }

    /**
     * *
     * @TODO 查询与分享记录
     * 
     * @param
     *            $cardId
     * @version 0.0.1 2017-10-11
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return array
     */
    public function getWechatCareShareByCardId($cardId)
    {
        $res = array();
        if (empty($cardId) || intval($cardId) < 1) {
            return $res;
        }
        $where = "WHERE  card_id = " . $cardId . " LIMIT 1 ";
        $sql = "SELECT * FROM `weixin_card_share` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetch();
        return $res;
    }

    /**
     * *
     * @TODO 查询与分享list记录
     * 
     * @param $cardIds array            
     * @param $wechatId string            
     * @version 0.0.1 2017-10-11
     * @author ZhigangQiu <[<qiuzhigang@oradt.com>]>
     * @return array
     */
    public function getWechatCareShareColumnByCardIds($cardIds, $column)
    {
        $res = array();
        if (empty($cardIds) || count($cardIds) < 1 || empty($column) || count($column) < 1) {
            return $res;
        }
        $cardIds = implode(",", $cardIds);
        $columns = '';
        foreach ($column as $v) {
            $columns .= "`" . $v . "` ";
        }
        $count = count($column);
        $where = "WHERE  card_id in ( " . $cardIds . ")";
        $sql = "SELECT " . $columns . " FROM `weixin_card_share` " . $where;
        $res = $this->getConnection()
            ->executeQuery($sql)
            ->fetchAll();
        if ($count == 1 && ! empty($res) && count($res) > 0) {
            $res = $this->i_array_column($res, $column[0]);
        }
        return $res;
    }

    /**
     *
     * @param $flag int
     *            1、微信id
     * @param $flag int
     *            2、橙子userid
     * @param $flag int
     *            3、微信唯一id
     * @param $flag int
     *            4、微信用户id
     */
    protected function getWheres($flag)
    {
        $where = '';
        switch ($flag) {
            case 1:
                $where = ' WHERE wechat_id = ';
                break;
            case 2:
                $where = ' WHERE user_id =  ';
                break;
            case 3:
                $where = ' WHERE union_id = ';
                break;
            case 4:
                $where = ' WHERE id =  ';
                break;
            default:
                $where = ' WHERE wechat_id = ';
                break;
        }
        return $where;
    }

    /**
     *
     * @todo 删除微信
     */
    public function bingWechat($unionid, $wechatid, $wechatinfo)
    {
        $time = time();
        $sql_wechat = "DELETE FROM weixin_user where wechat_id = '{$wechatid}' ";
        $this->getConnection()->executeUpdate($sql_wechat);
        $wheres = '';
        if (! empty($wechatinfo)) {
            $wheres = ",wechat_info = '{$wechatinfo}' ";
        }
        $sql_union = "UPDATE weixin_user SET modified_time = {$time} ,wechat_id = '{$wechatid}' " . $wheres . " WHERE union_id = '{$unionid}' LIMIT 1;";
        $this->getConnection()->executeUpdate($sql_union);
        return true;
    }

    /**
     *
     * @todo 更新unionid
     */
    public function updateUnionidByWechatid($unionid, $wechatid, $wechatinfo)
    {
        $time = time();
        if (empty($unionid)) {
            $this->updateWechatIfoByWechatid($wechatid, $wechatinfo);
            return true;
        }
        $wheres = '';
        if (! empty($wechatinfo)) {
            $wheres = ",wechat_info = '{$wechatinfo}' ";
        }
        $sql_union = "UPDATE weixin_user SET modified_time = {$time},union_id = '{$unionid}' " . $wheres . " WHERE wechat_id = '{$wechatid}' ";
        ;
        $this->getConnection()->executeUpdate($sql_union);
        return true;
    }

    /**
     * union为空，只更新微信信息
     */
    public function updateWechatIfoByWechatid($wechatid, $wechatinfo)
    {
        $time = time();
        if (empty($wechatinfo)) {
            return true;
        }
        $sql_union = "UPDATE weixin_user SET modified_time = {$time},wechat_info = '{$wechatinfo}' WHERE wechat_id = '{$wechatid}' ";
        $this->getConnection()->executeUpdate($sql_union);
        return true;
    }

    /**
     * 更新微信信息
     */
    public function updateWechatInfoByUnionid($unionid, $wechatinfo)
    {
        $time = time();
        if (empty($wechatinfo)) {
            return false;
        }
        $sql_union = "UPDATE weixin_user SET modified_time = {$time}, wechat_info = '{$wechatinfo}' WHERE union_id = '{$unionid}' ;";
        $this->getConnection()->executeUpdate($sql_union);
        return true;
    }

    public function updateBizByWechatid($bizid, $wechatid)
    {
        $time = time();
        if (empty($wechatid)) {
            return false;
        }
        $updSql = "UPDATE `weixin_user` SET biz_id=:bizId WHERE wechat_id=:wechatid LIMIT 1";
        $this->getConnection()->executeUpdate($updSql, array(
            ":bizId" => $bizid,
            ":wechatid" => $wechatid
        )); 
        return true;
    }

    /**
     * 获取ealsticsearch搜索文件的处理结果
     * 
     * @todo 条件搜索
     * @param $kwds string
     *            搜索内容
     * @param $wechatid string
     *            微信ID
     * @param $flag int
     *            1：名片2：任意扫
     */
    public function searchFromElas($kwds, $wechatid, $flag = 1)
    {
        $post_string = array(
            'search_word' => $kwds,
            'wechat_id' => $wechatid
        );
        $result = '';
        if (1 == $flag) {
            $url = '/CloudSearch/wechat/search'; // '/WeixinCard/sideresearch';//普通名片搜索
        } else 
            if (2 == $flag) {
                $url = '/CloudSearch/anyscan/search'; // '/ElasticSearch2.3.4/search';//任意扫搜索
            } else {
                $url = '/CloudSearch/anyscan/autoComplement'; // '/ElasticSearch2.3.4/complement';//任意扫自动补全
            }
        if ($this->container->hasParameter('fullsearch')) {
            $api_url = $this->container->getParameter('fullsearch') . $url;
        } else {
            return $res;
        }
        // $api_url = $this->container->getParameter('fullsearch')."/CloudSearch/wechat/search";
        // /CloudSearch/wechat/search /WeixinCard/sideresearch
        $post_string = json_encode($post_string);
        $params['text'] = $post_string;
        $curl = new CurlService();
        $result = $curl->exec($api_url, $params, 'post');
        self::ssLog('getcardids', $result);
        $result = json_decode($result, true);
        return $result;
    }

    /**
     *
     * @todo elas搜索结果插入临时表
     * @param [array] $arr
     *            插入数据
     * @return [Boolean] [description]
     */
    public function insertIntoElasTemp($arr)
    {
        if (empty($arr)) {
            return false;
        }
        $values = '';
        foreach ($arr as $val) {
            $values .= "('{$val['elasid']}',{$val['id']},'{$val['isfb']}'),";
        }
        $values = trim($values, ',');
        // 组合sql
        $sql = "INSERT INTO weixin_other_elas (elasid,cardid,isfb) VALUES {$values} ;";
        $this->getConnection()->executeUpdate($sql);
        return true;
    }

    /**
     *
     * @todo 清空任意扫elas临时表数据
     * @return [boolea]
     */
    public function deleteElasTemp()
    {
        $sql = "DELETE FROM weixin_other_elas WHERE id <> 0 ;";
        $this->getConnection()->executeUpdate($sql);
        return true;
    }

    /**
     * @ 微信名片
     */
    public function get_weixin_card_by_wechat_id($wechat_id,$batchid,$limit=0,$pageSize=1000)
    {
        ini_set ('memory_limit', '1024M');
    
        $where = " wechat_id=:wechat_id and vcard!=''";
        $parm[':wechat_id']=$wechat_id;
        if(!empty($batchid)){
            $where .= " and batchid=:batchid";
            $parm[":batchid"]=$batchid;
        }
        $sql = "SELECT  card_name,vcard,created_time FROM `weixin_card` where " . $where."  limit $limit,$pageSize";
        $data = $this->getConnection()
        ->executeQuery($sql, $parm)
        ->fetchAll();
        $res["header"] = array(
            "FN" => "姓名",
            "ENG" => "英文名",
            "JOB" => "职位",
            "CELL" => "电话",
            "TEL" => "手机",
            "ORG" => "公司",
            "DEPT" => "部门",
            "ADR" => "地址",
            "URL" => "网址",
            "EMAIL" => "邮箱",
            "created_time" => "时间",
        );
        $list=array();
        if($data){
            foreach ($data as $key=>&$value){
                $vcard_arr=json_decode($value["vcard"],true);
                if(empty($vcard_arr["front"]))continue;
                $list[$key] = $this->_getVcardSingleData($vcard_arr["front"]);
                $list[$key]["created_time"]=date("Y-m-d H:i",$value["created_time"]);
            }
        }else{
            $_list[0] = array(
                "FN" => "无数据",
                "ENG" => "",
                "JOB" => "",
                "CELL" => "",
                "TEL" => "",
                "ORG" => "",
                "DEPT" => "",
                "ADR" => "",
                "URL" => "",
                "EMAIL" => "",
                "created_time" => "",
            );
            $list=$_list;
        }
        $res["data"]=$list;
        unset($list);
        unset($data);
        return $res;
    }
   
    public function get_weixin_card_by_wechat_id1($wechat_id,$batchid,$limit=0,$pageSize=1000)
    { 
        ini_set ('memory_limit', '1024M');
        
        $where = " wechat_id=:wechat_id and vcard!=''";
        $parm[':wechat_id']=$wechat_id;
        if(!empty($batchid)){
            $where .= " and batchid=:batchid";
            $parm[":batchid"]=$batchid;
        }  
        $sql = "SELECT  vcard,created_time FROM `weixin_card` where " . $where."  limit $limit,$pageSize";
        $data = $this->getConnection()
            ->executeQuery($sql, $parm)
            ->fetchAll();  
        $res["header"] = array(
            "FN" => "姓名",
            "ENG" => "英文名",
            "JOB" => "职位",
            "CELL" => "电话",
            "TEL" => "手机",
            "ORG" => "公司",
            "DEPT" => "部门",
            "ADR" => "地址",
            "URL" => "网址",
            "EMAIL" => "邮箱",
            "created_time" => "时间",
        ); 
        $list=array();
        if($data){
            foreach ($data as $key=>&$value){ 
                $vcard_arr=json_decode($value["vcard"],true);
                if(empty($vcard_arr["front"]))continue;
                $list[$key] = $this->_getVcardSingleData($vcard_arr["front"]);  
                $list[$key]["created_time"]=date("Y-m-d H:i",$value["created_time"]);  
            }  
        }else{
            $_list[0] = array(
                "FN" => "无数据",
                "ENG" => "",
                "JOB" => "",
                "CELL" => "",
                "TEL" => "",
                "ORG" => "",
                "DEPT" => "",
                "ADR" => "",
                "URL" => "",
                "EMAIL" => "",
                "created_time" => "",
            );
            $list=$_list;
        }
        $res["data"]=$list; 
        unset($list);
        return $res;
    } 
    
    public function get_weixin_card_count_by_wechat_id($wechat_id,$batchid){
        $where = " wechat_id=:wechat_id and vcard!=''";
        $parm[':wechat_id']=$wechat_id;
        if(!empty($batchid)){
            $where .= " and batchid=:batchid";
            $parm[":batchid"]=$batchid;
        }
        $sql_count = "SELECT  count(1) as card_count FROM `weixin_card` where " . $where;
        $data = $this->getConnection()->executeQuery($sql_count, $parm)->fetch();
        return $data["card_count"];
    }
    
    public function _getVcardSingleData($oneSideData)
    {
        $rst = array();
        $ENG = $DEPT = $FN = $ORG = $ADR = $CELL = $TEL = $URL=$JOB = $TITLE = $EMAIL = "";
        $FN = $this->_getVcardValue($oneSideData,'name');  
        $ENG = $this->_getVcardValue($oneSideData,'name', true);  
        $TEL = $this->_getVcardValue($oneSideData,'mobile'); 
    
        if(!empty($oneSideData['company'])){
            foreach ($oneSideData['company'] as $company){
                $ORG = $this->_getVcardValue($company,'company_name'); //
                $ADR = $this->_getVcardValue($company,'address'); //
                $CELL = $this->_getVcardValue($company,'telephone'); //
                $URL = $this->_getVcardValue($company,'web'); //
                $JOB = $this->_getVcardValue($company,'job'); //
                $EMAIL = $this->_getVcardValue($company,'email'); //
                $DEPT = $this->_getVcardValue($company,'department'); //
            }
        }
        $rst = array('FN' => $FN,
            'ENG' => $ENG,
            'ORG' => $ORG,
            'ADR' => $ADR,
            'CELL' => $CELL,
            'TEL' => $TEL,
            'URL' => $URL,
            'JOB' => $JOB,
            'EMAIL' => $EMAIL,
            'DEPT' => $DEPT
        ); 
        return $rst;
    }
    public function _getVcardValue($dataSet,$jsonName, $englishname = false)
    {
        $rst = array();
        if(isset($dataSet[$jsonName])){
            foreach ($dataSet[$jsonName] as $dataElement){
                if ($jsonName == 'name') { //  
                    if ($englishname) {
                        if ($dataElement['is_chinese'] == '0') {  
                            $rst[] = $dataElement['value'];
                        }
                    } else {
                        if ($dataElement['is_chinese'] == '1') {  
                            $rst[] = $dataElement['value'];
                        }
                    }
                } else {
                    $rst[] = $dataElement['value'];
                }
            }
        }
        return implode(',', $rst) ;
    }
     
    /**
     * @ 添加发送邮件日志
     */
    public function insert_send_message_log($param){ 
        
        try { 
            // $this->sendMail($sendurl,$title,$content,$file,$fromsend,$filename);
            $param[":sendtype"]="asyn";
            $param[":status"]=1;
            $insertsql = "INSERT INTO send_message_log (enclosure,sendname,content,title,create_time,mail,wechat_id,batchid,send_type,status) VALUES(:enclosure,:sendname,:content,:title,:createtime,:mail,:wechatid,:batchid,:sendtype,:status)";
            $this->getConnection()->executeQuery($insertsql, $param);  
            return  true;
        } catch (\Exception $ex) {
            //$em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * 更新微信信息
     */
    public function update_send_message_log($message_id,$param,$status=0)
    {
        $time = time();
        if($status==0)  
            $sql_update = "UPDATE send_message_log SET enclosure='{$param[":enclosure"]}',status ={$status},send_time = '{$time}' WHERE  id={$message_id};";
        elseif ($status==2)
            $sql_update = "UPDATE send_message_log SET status ={$status} WHERE  id={$message_id};";
        elseif ($status==3)
            $sql_update = "UPDATE send_message_log SET excel_time = '{$time}',status ={$status} WHERE  id={$message_id};";
        $this->getConnection()->executeUpdate($sql_update);
        return true;
    }
 
    /**
     * @ 添加发送邮件 
     */
    public function insert_send_message($param,$filename){
    
        try {
            // $this->sendMail($sendurl,$title,$content,$file,$fromsend,$filename);
            $param[":sendtype"]="asyn"; 
            $this->setManager('api');
            $mailtb = 'INSERT INTO message_promotion (type,mobile,email,title,content,created_time,files,fromname)
                 VALUE (:type,:mobile,:mail,:title,:content,:createtime,:files,:fromname)';
            $param_insert =array(
                ':type'=>2,
                ':mobile'=>'',
                ':mail' => $param[":mail"],
                ':title' => $param[":title"],
                ':content' => $param[":content"],
                ':createtime'=>$this->getTimestamp(),
                ':files'=> json_encode(array( array('url' =>$param[":enclosure"]  , 'name' =>$filename,"sendtype"=>"asyn")) , JSON_UNESCAPED_UNICODE),
                ':fromname' => $param[":sendname"],
                ':sendtype'=>"asyn"
            );
    
            $this->getConnection()->executeQuery($mailtb, $param_insert);
            $this->setManager();
             
            return  true;
        } catch (\Exception $ex) {
            //$em->getConnection()->rollback();
            throw $ex;
        }
    }
    
}
