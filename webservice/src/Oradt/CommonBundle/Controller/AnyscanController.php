<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-10-30
 * Time: 9:27
 */

namespace Oradt\CommonBundle\Controller;

use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\WeixinOtherTag;
use Oradt\Utils\Errors;
use Predis\Protocol\Text\Handler\ErrorResponse;
use Symfony\Component\HttpFoundation\Request;

class AnyscanController extends BaseController {
    private $request;
    private $wechatServer;
    private $wechatid;
    private $anyscan_tags = "anyscan_tags_card";
    /**
     *搜索返回集
     *
     * @var type
     */
    protected $collect = array();

    public function getAction(){
        $this->accesstime = $this->getTimestamp1();
        $this->request    = $this->getRequest();
        $type             = $this->strip_tags(trim($this->request->get("act")));
        $this->wechatid   = $this->strip_tags(trim($this->request->get('wechatid')));
        if(isset($this->wechatid)){
            $this->accountId = $this->wechatid;
        }
        switch($type){
            case 'folder'://获取任意扫文件夹列表 根据类型决定返回的数据
                return $this->_getAnyscanFolder();
                break;
            case 'list'://获取任意扫所有文件列表
                return $this->_getAnyscanAllFile();
                break;
            case 'dates'://获取用户所有文件所存在的时间列表
                return $this->_getAnyscanAllDates();
                break;
            case 'customfolder'://获取自定义文件夹列表 简洁版
                return $this->_getAnyscanCustomFolder();
                break;
            case 'file'://获取文件夹的图片信息及图片墙
                return $this->_getAnyscanFileList();
                break;
            case 'search'://搜索用户名下图片信息
                return $this->_getAnyscanSearch();
                break;
            case 'keywords'://搜索历史关键字
                return $this->_getAnyscanKeywords();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    private function _getAnyscanSearch(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        $userid   = $this->strip_tags(trim(intval($this->request->get('userid'))));
        $content  = $this->strip_tags(trim($this->request->get('kwds')));   //搜索关键词
        if(empty ($userid) && empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        if(empty($content)||!isset($content)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $starttime = $this->getTimestamp1();
        if($this->wechatServer == null){
            $this->wechatServer = $this->container->get('wechat_service');
        }
        $result = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
        if(!isset($result['match_rel']) || empty($result['match_rel'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }

        $ids = $result['match_rel'];
        $picids = implode(",", array_keys(array_flip($this->i_array_column($ids, 'id'))));
        $keds   = " a.id in ({$picids})";
        $this->setParam("kwds",$content);

        $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;

        $where = $keds;
        $order ='';// ' ORDER BY a.created_time desc';
        $where = trim($where);
        $state = ' a.state=100 ';
        if(!empty($where) && isset($where)){
            $where .= " AND ";
        }
        $where .= $state;
        $sql = "SELECT %s FROM `weixin_other_pic` as a %s%s";
        $sqldata = array(
            'fields' => array('id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'userid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                'wechatid' => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'vcard' => array('mapdb' => 'a.vcard'),
                'picturea' => array('mapdb' => 'a.picturea'),
                'pictureb' => array('mapdb' => 'a.pictureb'),
                'thum' => array('mapdb' => 'a.picture_thum'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                'upway' => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'batchid' => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus' => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'deviceid' => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude' => array('mapdb' => 'a.longitude'),
                'latitude' => array('mapdb' => 'a.latitude'),
                'state' => $state,
            ),
            'default_dataparam' => array(),
            'sql' => $sql,
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,userid,wechatid,createdtime,modifytime,vcard,picturea,pictureb,thum,status,upway,batchid,buystatus,deviceid,longitude,latitude',
            );

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $sqldata['pagesize'] = 52;

        $data = $this->getData($sqldata, 'list');
        $list = $data['list'];
        $idlist = array_flip($this->i_array_column($list,'id'));

        $listArray = [];
        foreach($list as $v){
             if(isset($idlist[$v['id']])){
                $listArray[$v['id']] = $v;
            }
        }

        $list = [];
        foreach($ids as $i){
             if(isset($idlist[$i['id']])){
                $item = $listArray[$i['id']];
                $item['isfb'] = $i['isfb'];
                $list[] = $item;
            }
        }

        $data['list'] = $list;
        $data['numfound'] = count($list);
        return $this->renderJsonSuccess($data);
    }
    private function _getAnyscanSearchV2(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        $content  = $this->strip_tags(trim($this->request->get('kwds')));   //搜索关键词
        if(empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        if(empty($content)||!isset($content)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $starttime = $this->getTimestamp1();
        if($this->wechatServer == null){
            $this->wechatServer = $this->container->get('wechat_service');
        }
        $result = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
        if(!isset($result['match_rel']) || empty($result['match_rel'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }

        $ids = $result['match_rel'];
        $picids = implode(",", array_keys(array_flip($this->i_array_column($ids, 'id'))));
        $keds   = " a.id in ({$picids})";
        $this->setParam("kwds",$content);

        $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;

        $where = ' a.card_type=2 AND ' . $keds;
        $order ='';// ' ORDER BY a.created_time desc';
        $state = ' AND a.status=1 ';
        $where .= $state;
        $sql = "SELECT %s FROM `{$this->tbWeixinCard}` as a %s%s";
        $sqldata = array(
            'fields' => array('id'          => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                              'startid'     => array('mapdb' => 'a.id', 'w' => 'Range'),
                              'wechatid'    => array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid'),
                              'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                              'modifytime'  => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                              'vcard'       => array('mapdb' => 'a.vcard'),
                              'picturea'    => array('mapdb' => 'a.wechat_picture'),
                              'pictureb'    => array('mapdb' => 'a.wechat_picture_b'),
                              'thum'        => array('mapdb' => 'a.small_wechat_picture'),
                              'ocrstatus'   => array('mapdb' => 'a.ocr_status', 'w' => ' AND a.ocr_status = :ocrstatus'),
                              'upway'       => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                              'batchid'     => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                              'buystatus'   => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                              'deviceid'    => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                              'longitude'   => array('mapdb' => 'a.longitude'),
                              'latitude'    => array('mapdb' => 'a.latitude'),
                              'status'      => $state,
            ),
            'default_dataparam' => array(),
            'sql' => $sql,
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,wechatid,createdtime,modifytime,vcard,picturea,pictureb,thum,ocrstatus,upway,batchid,buystatus,deviceid,longitude,latitude',
        );

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $sqldata['pagesize'] = 52;

        $data = $this->getData($sqldata, 'list');
        $list = $data['list'];
        $idlist = array_flip($this->i_array_column($list,'id'));

        $listArray = [];
        foreach($list as $v){
            if(isset($idlist[$v['id']])){
                $listArray[$v['id']] = $v;
            }
        }

        $list = [];
        foreach($ids as $i){
            if(isset($idlist[$i['id']])){
                $item = $listArray[$i['id']];
                $item['isfb'] = $i['isfb'];
                $list[] = $item;
            }
        }

        $data['list'] = $list;
        $data['numfound'] = count($list);
        return $this->renderJsonSuccess($data);
    }

    /***
     * 关键字查询
     */
    private function _getAnyscanKeywords(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(!isset($this->wechatid) || empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $this->setParam("wechatid",$this->wechatid);
        $sqlParam = [':wechatid'=>$this->wechatid];

        $querySql = "SELECT `id`,`index_word` as keyword FROM weixin_other_search_history WHERE `wechat_id` = :wechatid AND `valid` = 0 ORDER BY tm DESC LIMIT ".$this->getPageSize();
        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)||!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $result = ['numfound'=>count($data),'list'=>$data];
        return $this->renderJsonSuccess($result);
    }

    /***
     * 图片墙以及搜索接口
     */
    private function _getAnyscanFileList(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        $userid   = $this->strip_tags(trim(intval($this->request->get('userid'))));
        $content  = $this->strip_tags(trim($this->request->get('kwds')));   //搜索关键词
        if(empty ($userid) && empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $type = $this->strip_tags(trim(strtolower($this->request->get('type'))));
        if(empty($type) || !isset($type) || !in_array($type, ['system', 'custom'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $keds = '';
        if(!empty($content)){
            $starttime = $this->getTimestamp1();
            if($this->wechatServer == null){
                $this->wechatServer = $this->container->get('wechat_service');
            }
            $result = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
            if(isset($result['match_rel']) && !empty($result['match_rel'])){
                $picids = implode(",", array_keys(array_flip($this->i_array_column($result['match_rel'], 'id'))));
                $keds   = " a.id in ({$picids})";
            }
            if(isset($result['label'])){
                $this->collect['label'] = $result['label'];
            }
            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
        }
        $where = $keds;
        //针对搜索关键 未传分类id时  需要加上分组处理
        $keds = trim($keds);
        $order ='';
        $classid = $this->strip_tags(intval(trim($this->request->get('classid',-1))));
        if((!empty($keds) && isset($keds))||($classid<0)){
            $order = " GROUP BY a.id ";
        }

        $order .= ' ORDER BY a.created_time desc';

        //分开处理数据
        if($type == 'custom'){
            $sql            = "SELECT %s FROM `weixin_other_pic` as a INNER JOIN `weixin_other_tag_info` as b ON a.`id` = b.`card_id` AND a.wechat_id=b.user_id INNER JOIN `weixin_other_tag` as t ON a.`wechat_id` = t.`wechat_id` AND b.`tag_encoding` = t.`id` %s%s";
            $classidfield   = array('mapdb' => 'b.tag_encoding', 'w' => ' AND b.tag_encoding = :classid');
            $classnamefield = array('mapdb' => 'b.tag');
            $state          = ' t.status=0 AND a.state=100 ';
            $wechatid       = array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid');
        }else{
            $sql            = "SELECT %s FROM `weixin_other_pic` as a INNER JOIN anyscan_tags as b ON a.id = b.`pic_id` INNER JOIN anyscan_cluster as c ON c.`batch_id` = b.`batch_id` AND c.`class_id` = b.`class_id` %s%s";
            $classidfield   = array('mapdb' => 'b.class_id', 'w' => ' AND b.class_id = :classid');
            $classnamefield = array('mapdb' => 'c.`class_name`');
            $state          = ' a.state=100 AND b.`batch_id`="anyscan" ';
            $wechatid       = array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid');
        }
        $where = trim($where);
        if(!empty($where) && isset($where)){
            $where .= " AND ";
        }
        $where .= $state;

        $sqldata = array(
            'fields' => array('id' => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                'startid' => array('mapdb' => 'a.id', 'w' => 'Range'),
                'userid' => array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
                'wechatid' => $wechatid,
                'classid' => $classidfield,
                'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                'modifytime' => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                'vcard' => array('mapdb' => 'a.vcard'),
                'picturea' => array('mapdb' => 'a.picturea'),
                'pictureb' => array('mapdb' => 'a.pictureb'),
                'thum' => array('mapdb' => 'a.picture_thum'),
                'status' => array('mapdb' => 'a.status', 'w' => ' AND a.status = :status'),
                'upway' => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                'classname' => $classnamefield,
                'batchid' => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                'buystatus' => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                'deviceid' => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                'longitude' => array('mapdb' => 'a.longitude'),
                'latitude' => array('mapdb' => 'a.latitude'),
                ),
            'default_dataparam' => array(),
            'sql' => $sql,
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,userid,wechatid,classid,createdtime,modifytime,vcard,picturea,pictureb,thum,status,upway,classname,batchid,buystatus,deviceid,longitude,latitude',);

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }

        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }
    private function _getAnyscanFileListV2(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        $content  = $this->strip_tags(trim($this->request->get('kwds')));   //搜索关键词
        if(empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $type = $this->strip_tags(trim(strtolower($this->request->get('type'))));
        if(empty($type) || !isset($type) || !in_array($type, ['system', 'custom'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $where = ' a.card_type=2 ';
        $keds = '';
        if(!empty($content)){
            $starttime = $this->getTimestamp1();
            if($this->wechatServer == null){
                $this->wechatServer = $this->container->get('wechat_service');
            }
            $result = $this->wechatServer->searchFromElas($content, $this->wechatid, 2);//
            if(isset($result['match_rel']) && !empty($result['match_rel'])){
                $picids = implode(",", array_keys(array_flip($this->i_array_column($result['match_rel'], 'id'))));
                $keds   = " a.id in ({$picids})";
            }
            if(isset($result['label'])){
                $this->collect['label'] = $result['label'];
            }
            $this->paramdata['get_time'] = $this->getTimestamp1() - $starttime;
        }
        if (!empty($keds)) {
            $where .= ' AND ' . $keds;
        }
        //针对搜索关键 未传分类id时  需要加上分组处理
        $keds = trim($keds);
        $order ='';
        $classid = $this->strip_tags(intval(trim($this->request->get('classid',-1))));
        if((!empty($keds) && isset($keds))||($classid<0)){
            $order = " GROUP BY a.id ";
        }
        $order .= ' ORDER BY a.created_time desc';
        //分开处理数据
        if($type == 'custom'){
            $sql            = "SELECT %s FROM `{$this->tbWeixinCard}` as a 
                                INNER JOIN `weixin_other_tag_info` as b ON a.`id` = b.`card_id` AND a.wechat_id=b.user_id 
                                INNER JOIN `weixin_other_tag` as t ON a.`wechat_id` = t.`wechat_id` AND b.`tag_encoding` = t.`id` %s%s";
            $classidfield   = array('mapdb' => 'b.tag_encoding', 'w' => ' AND b.tag_encoding = :classid');
            $classnamefield = array('mapdb' => 'b.tag');
            $state          = ' t.status=0 AND a.status=1 ';
            $wechatid       = array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid');
        }else{
            $sql            = "SELECT %s FROM `{$this->tbWeixinCard}` as a 
                                INNER JOIN `{$this->anyscan_tags}` as b ON a.uuid = b.`card_uuid` 
                                INNER JOIN anyscan_cluster as c ON c.`batch_id` = b.`batch_id` AND c.`class_id` = b.`class_id` %s%s";
            $classidfield   = array('mapdb' => 'b.class_id', 'w' => ' AND b.class_id = :classid');
            $classnamefield = array('mapdb' => 'c.`class_name`');
            $state          = ' a.status=1 AND b.`batch_id`="anyscan" ';
            $wechatid       = array('mapdb' => 'a.wechat_id', 'w' => ' AND a.wechat_id = :wechatid');
        }
        $where .= ' AND ' . $state;

        $sqldata = array(
            'fields' => array('id'          => array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
                              'startid'     => array('mapdb' => 'a.id', 'w' => 'Range'),
                              'wechatid'    => $wechatid,
                              'classid'     => $classidfield,
                              'createdtime' => array('mapdb' => 'a.created_time', 'w' => 'Range'),
                              'modifytime'  => array('mapdb' => 'a.modify_time', 'w' => 'Range'),
                              'vcard'       => array('mapdb' => 'a.vcard'),
                              'picturea'    => array('mapdb' => 'a.wechat_picture'),
                              'pictureb'    => array('mapdb' => 'a.wechat_picture_b'),
                              'thum'        => array('mapdb' => 'a.small_wechat_picture'),
                              'ocrstatus'   => array('mapdb' => 'a.ocr_status', 'w' => ' AND a.ocr_status = :ocrstatus'),
                              'upway'       => array('mapdb' => 'a.upway', 'w' => ' AND a.upway = :upway'),
                              'classname'   => $classnamefield,
                              'batchid'     => array('mapdb' => 'a.batchid', 'w' => ' AND a.batchid = :batchid'),
                              'buystatus'   => array('mapdb' => 'a.buystatus', 'w' => ' AND a.buystatus = :buystatus'),
                              'deviceid'    => array('mapdb' => 'a.device_id', 'w' => ' AND a.device_id = :deviceid'),
                              'longitude'   => array('mapdb' => 'a.longitude'),
                              'latitude'    => array('mapdb' => 'a.latitude'),
//                              'status'      => $state,
            ),
            'default_dataparam' => array(),
            'sql' => $sql,
            'where' => "" . $where,
            'order' => '' . $order,
            'provide_max_fields' => 'id,startid,wechatid,classid,createdtime,modifytime,vcard,picturea,pictureb,thum,ocrstatus,upway,classname,batchid,buystatus,deviceid,longitude,latitude',);

        $check = $this->parseSql($sqldata);
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }

        $data = $this->getData($sqldata, 'list');

        return $this->renderJsonSuccess($data);
    }

    /***
     * 获取用户自定义文件夹列表信息
     */
    private function _getAnyscanCustomFolder(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $this->setParam("wechatid", $this->wechatid);
        $sqlParam = [':wechatid' => $this->wechatid];
        $sql      = "SELECT t.id as classid,t.`tag` as classname from weixin_other_tag as t WHERE t.wechat_id= :wechatid AND t.`status`=0 ORDER BY t.created_time DESC ";
        $data     = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
        $result   = ['numfound' => count($data), 'list' => $data];

        return $this->renderJsonSuccess($result);
    }

    /***
     * 返回所有文件列表
     */
    private function _getAnyscanAllFile(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqlParam[":wechatid"] = $this->wechatid;
        $where = "WHERE a.`wechat_id` = :wechatid AND a.`state`=100";
        $userid = $this->strip_tags(intval(trim($this->request->get('userid'))));
        if(isset($userid)&&!empty($userid)){
            $sqlParam[":userid"] = $userid;
            $where .= " AND a.`user_id` = :userid ";
        }
        //创建时间条件
        $createdtime = $this->strip_tags(trim($this->request->get('createdtime')));
        if(isset($createdtime) && !empty($createdtime)){
            $timeArr = explode(',', $createdtime);
            if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
            }
            $createdtimeResult = $this->rangeKeyword($timeArr,'created_time','a');
            $where .= $createdtimeResult['where'];
            $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
        }
        //修改时间条件
        $modifytime = $this->strip_tags(trim($this->request->get('modifytime')));
        if(isset($modifytime) && !empty($modifytime)){
            $timeArr = explode(',', $modifytime);
            if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
            }
            $createdtimeResult = $this->rangeKeyword($timeArr,'modify_time','a');
            $where .= $createdtimeResult['where'];
            $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
        }
        //批次号
        $batchid = $this->strip_tags(trim($this->request->get('batchid')));
        if(isset($batchid)&&!empty($batchid)){
            $sqlParam[":batchid"] = $userid;
            $where .= " AND a.`batchid` = :batchid ";
        }
        //设备id
        $deviceid = $this->strip_tags(trim($this->request->get('deviceid')));
        if(isset($deviceid)&&!empty($deviceid)){
            $sqlParam[":deviceid"] = $deviceid;
            $where .= " AND a.`device_id` = :deviceid ";
        }
        //上传方式
        $upway = $this->strip_tags(intval(trim($this->request->get('upway'))));
        if(isset($upway)&&!empty($upway)){
            $sqlParam[":upway"] = $upway;
            $where .= " AND a.`upway` = :upway ";
        }
        //识别状态
        $status = $this->strip_tags(intval(trim($this->request->get('status',-3))));
        if(isset($userid)&&in_array($status,[-2,-1,0,1,2])){
            $sqlParam[":status"] = $userid;
            $where .= " AND a.`status` = :status ";
        }

        $requestParams = $this->request->query->all();
        foreach($requestParams as $k => $v){
            if($v !== null && $v !== ''){
                $this->setParam($k, $v);
            }
        }

        $querySql = "SELECT a.id AS `id`,a.id AS `startid`,a.user_id AS `userid`,a.wechat_id AS `wechatid`,a.created_time AS `createdtime`,a.modify_time AS `modifytime`,a.picturea AS `picturea`,a.pictureb AS `pictureb`,a.picture_thum AS `thum`,a.status AS `status`,a.upway AS `upway`,a.batchid AS `batchid`,a.buystatus AS `buystatus`,a.device_id AS `deviceid`,a.longitude AS `longitude`,a.latitude AS `latitude`,FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ) as currentdate FROM weixin_other_pic a LEFT JOIN weixin_other_pic b ON a.`wechat_id`=b.`wechat_id` AND FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' )=FROM_UNIXTIME( b.`created_time`, '%Y-%m-%d' ) and a.`created_time`<b.`created_time` ".$where." group by a.id,a.wechat_id,FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ),a.`created_time` having count(b.id)<4 ORDER BY FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ) desc,a.`created_time` desc;";
        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)&&!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $result = ['numfound'=>count($data),'list'=>$data];
        return $this->renderJsonSuccess($result);
    }
    private function _getAnyscanAllFileV2(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqlParam[":wechatid"] = $this->wechatid;
        $where = " WHERE a.`wechat_id` = :wechatid AND a.`status`=1 AND a.card_type=2 ";

        //创建时间条件
        $createdtime = $this->strip_tags(trim($this->request->get('createdtime')));
        if(isset($createdtime) && !empty($createdtime)){
            $timeArr = explode(',', $createdtime);
            if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
            }
            $createdtimeResult = $this->rangeKeyword($timeArr,'created_time','a');
            $where .= $createdtimeResult['where'];
            $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
        }
        //修改时间条件
        $modifytime = $this->strip_tags(trim($this->request->get('modifytime')));
        if(isset($modifytime) && !empty($modifytime)){
            $timeArr = explode(',', $modifytime);
            if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
            }
            $createdtimeResult = $this->rangeKeyword($timeArr,'modify_time','a');
            $where .= $createdtimeResult['where'];
            $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
        }
        //批次号
        $batchid = $this->strip_tags(trim($this->request->get('batchid')));
        if(isset($batchid)&&!empty($batchid)){
            $sqlParam[":batchid"] = $batchid;
            $where .= " AND a.`batchid` = :batchid ";
        }
        //设备id
        $deviceid = $this->strip_tags(trim($this->request->get('deviceid')));
        if(isset($deviceid)&&!empty($deviceid)){
            $sqlParam[":deviceid"] = $deviceid;
            $where .= " AND a.`device_id` = :deviceid ";
        }
        //上传方式
        $upway = $this->strip_tags(intval(trim($this->request->get('upway'))));
        if(isset($upway)&&!empty($upway)){
            $sqlParam[":upway"] = $upway;
            $where .= " AND a.`upway` = :upway ";
        }
        //识别状态
        $ocrstatus = $this->strip_tags(intval(trim($this->request->get('ocrstatus',-3))));
        if(isset($this->wechatid)&&in_array($ocrstatus,[-2,-1,0,1,2])){
            $sqlParam[":ocrstatus"] = $ocrstatus;
            $where .= " AND a.`ocr_status` = :ocrstatus ";
        }

        $requestParams = $this->request->query->all();
        foreach($requestParams as $k => $v){
            if($v !== null && $v !== ''){
                $this->setParam($k, $v);
            }
        }

        $querySql = "SELECT a.id AS `id`,a.id AS `startid`,a.wechat_id AS `wechatid`,a.created_time AS `createdtime`,a.modify_time AS `modifytime`,a.wechat_picture AS `picturea`,a.wechat_picture_b AS `pictureb`,a.small_wechat_picture AS `thum`,a.ocr_status AS `ocrstatus`,a.upway AS `upway`, a.batchid AS `batchid`,a.buystatus AS `buystatus`,a.device_id AS `deviceid`,a.longitude AS `longitude`,a.latitude AS `latitude`,FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ) as currentdate 
                      FROM {$this->tbWeixinCard} a 
                      LEFT JOIN {$this->tbWeixinCard} b ON a.`wechat_id`=b.`wechat_id` AND FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' )=FROM_UNIXTIME( b.`created_time`, '%Y-%m-%d' ) AND a.`created_time`<b.`created_time` 
                      ".$where." 
                      GROUP BY a.id,a.wechat_id,FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ),a.`created_time` 
                      HAVING COUNT(b.id)<4 
                      ORDER BY FROM_UNIXTIME( a.`created_time`, '%Y-%m-%d' ) DESC,a.`created_time` DESC;";
        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)&&!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $result = ['numfound'=>count($data),'list'=>$data];
        return $this->renderJsonSuccess($result);
    }

    /***
     * 返回文件夹内容 以及所有图片列表
     */
    private function _getAnyscanFolder(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $type = $this->strip_tags(trim(strtolower($this->request->get('type'))));
        if(empty($type) || !isset($type)){
            $type = 'all';
        }
        if(!in_array($type, ['all', 'system', 'custom'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $result = [];
        $this->setParam("wechatid", $this->wechatid);
        $sqlParam = [':wechatid' => $this->wechatid];
        if($type != 'custom'){
            $sql              = "SELECT c.`class_id` as classid,c.`class_name` as classname,p.`picturea`,p.`pictureb`,p.`picture_thum`,COUNT(t.`pic_id`) as num from anyscan_tags t INNER JOIN anyscan_cluster c ON c.class_id=t.class_id AND t.batch_id=c.batch_id INNER JOIN `weixin_other_pic` p ON p.id = t.pic_id  where c.batch_id = 'anyscan' AND p.wechat_id= :wechatid AND p.`state`=100 GROUP BY c.class_id";
            $data             = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
            $result['system'] = ['numfound' => count($data), 'list' => $data];
        }

        if($type != 'system'){
            $sql              = "SELECT t.id as classid,t.`tag` as classname,IFNULL(p.`picturea`,'') as picturea,IFNULL(p.`pictureb`,'') as pictureb,IFNULL(p.`picture_thum`,'') as picture_thum,COUNT(ti.id) as num from `weixin_other_tag` as t LEFT JOIN `weixin_other_tag_info` as ti on t.`id` = ti.`tag_encoding` AND t.`wechat_id` = ti.`user_id` LEFT JOIN `weixin_other_pic` p ON ti.`card_id` = p.`id` WHERE t.`wechat_id`= :wechatid AND t.`status`=0 GROUP BY t.`id`  ORDER BY t.created_time DESC ";
            $data             = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
            $result['custom'] = ['numfound' => count($data), 'list' => $data];
        }

        return $this->renderJsonSuccess($result);
    }
    private function _getAnyscanFolderV2(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        if(empty($this->wechatid) || !isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $type = $this->strip_tags(trim(strtolower($this->request->get('type'))));
        if(empty($type) || !isset($type)){
            $type = 'all';
        }
        if(!in_array($type, ['all', 'system', 'custom'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $result = [];
        $this->setParam("wechatid", $this->wechatid);
        $sqlParam = [':wechatid' => $this->wechatid];
        if($type != 'custom'){
            $sql              = "SELECT c.`class_id` AS classid,c.`class_name` AS classname,p.`wechat_picture` AS picturea,p.`wechat_picture` AS pictureb,p.`small_wechat_picture` AS picture_thum,COUNT(t.`pic_id`) as num 
                                  FROM `{$this->anyscan_tags}`  t 
                                  INNER JOIN anyscan_cluster c ON c.class_id=t.class_id AND t.batch_id=c.batch_id 
                                  INNER JOIN `{$this->tbWeixinCard}` p ON p.uuid = t.card_uuid  
                                  WHERE c.batch_id = 'anyscan' AND p.wechat_id= :wechatid AND p.`status`=1 AND p.card_type=2 
                                  GROUP BY c.class_id";
            $data             = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
            $result['system'] = ['numfound' => count($data), 'list' => $data];
        }

        if($type != 'system'){
            $sql              = "SELECT t.id AS classid,t.`tag` AS classname,IFNULL(p.`wechat_picture`,'') AS picturea,IFNULL(p.`wechat_picture_b`,'') AS pictureb,IFNULL(p.`small_wechat_picture`,'') AS picture_thum,COUNT(ti.id) AS num 
                                  FROM `weixin_other_tag` AS t 
                                  LEFT JOIN `weixin_other_tag_info` AS ti on t.`id` = ti.`tag_encoding` AND t.`wechat_id` = ti.`user_id` 
                                  LEFT JOIN `{$this->tbWeixinCard}` p ON ti.`card_id` = p.`id` 
                                  WHERE t.`wechat_id`= :wechatid AND t.`status`=0 AND p.card_type=2
                                  GROUP BY t.`id` 
                                  ORDER BY t.created_time DESC ";
            $data             = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
            $result['custom'] = ['numfound' => count($data), 'list' => $data];
        }

        return $this->renderJsonSuccess($result);
    }

    /***
     * 时间处理
     * @param $timeArr
     * @param $keyword
     * @param string $table
     * @return array
     */
    private function rangeKeyword($timeArr,$keyword,$table='a'){
        $qarrCount      = count($timeArr);
        $where = '';
        $sqlParam = [];
        if($qarrCount == 2){//起始和终止参数都有
            if(isset($timeArr[0]) && !empty($timeArr[0])){
                $where                     .= ' AND  '.$table.'.`'.$keyword.'` >=:'.$keyword.'0';
                $sqlParam[':'.$keyword.'0'] = $timeArr[0];
            }
            if(isset($timeArr[1]) && !empty($timeArr[1])){
                $where                      .= ' AND '.$table.'.`'.$keyword.'`  <=:'.$keyword.'1';
                $sqlParam[':'.$keyword.'1'] = $timeArr[1];
            }
        }else if($qarrCount == 1){//只传一个参数，如只需一个日期则查询该天0点到24点
            $standTime                 = date("Y-m-d", intval($timeArr[0]));
            $startTime                 = strtotime($standTime);
            $endTime                   = $startTime + 86400;
            $where                     .= ' AND '.$table.'.`'.$keyword.'`>=:'.$keyword.'0';
            $sqlParam[':'.$keyword.'0'] = $startTime;
            $where                     .= ' AND '.$table.'.`'.$keyword.'`<:'.$keyword.'1';
            $sqlParam[':'.$keyword.'1'] = $endTime;
        }else{
            //TODO...
        }
        $result = ['where'=>$where,'sqlParam'=>$sqlParam];
        return $result;
    }


    /****
     * 所有文件的时间列表
     */
    private function _getAnyscanAllDates(){
    if(empty($this->request)){
        $this->request = Request::createFromGlobals();
    }
    $where         = "where a.`state`=100 ";
    $sqlParam      = [];
    $fields        = "FROM_UNIXTIME(a.`created_time`,'%Y-%m-%d') as currentdate,COUNT(1) as num";
    if(!empty($this->wechatid) && isset($this->wechatid)){
        $where                 .= " AND a.`wechat_id`=:wechatid";
        $sqlParam[':wechatid'] = $this->wechatid;
    }

    $createdtime = $this->strip_tags(trim($this->request->get('createdtime')));
    if(isset($createdtime) && !empty($createdtime)){
        $timeArr = explode(',', $createdtime);
        if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $createdtimeResult = $this->rangeKeyword($timeArr,'created_time','a');
        $where .= $createdtimeResult['where'];
        $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
    }

    $requestParams = $this->request->query->all();
    foreach($requestParams as $k => $v){
        if($v !== null && $v !== ''){
            $this->setParam($k, $v);
        }
    }

    $group  = " GROUP BY currentdate";
    $order = " ORDER BY a.created_time desc";
    $sql    = "SELECT " . $fields . " FROM `weixin_other_pic` as a " . $where . $group .$order;
    $data   = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
    $list   = [];
    $result = ['numfound' => count($data), 'list' => $list];
    date_default_timezone_set('PRC'); //设置中国时区
    foreach($data as $v){
        $startTime = strtotime($v['currentdate']);
        $endTime   = $startTime + 86399;
        $list[]    = ['currentdate' => $v['currentdate'], 'starttime' => $startTime, 'endtime' => $endTime,'num'=>(int)$v['num']];
    }
    $result['list'] = $list;

    return $this->renderJsonSuccess($result);
}
    private function _getAnyscanAllDatesV2(){
        if(empty($this->request)){
            $this->request = Request::createFromGlobals();
        }
        $where         = "where a.`status`=1 AND a.card_type=2";
        $sqlParam      = [];
        $fields        = "FROM_UNIXTIME(a.`created_time`,'%Y-%m-%d') as currentdate,COUNT(1) as num";
        if(!empty($this->wechatid) && isset($this->wechatid)){
            $where                 .= " AND a.`wechat_id`=:wechatid";
            $sqlParam[':wechatid'] = $this->wechatid;
        }

        $createdtime = $this->strip_tags(trim($this->request->get('createdtime')));
        if(isset($createdtime) && !empty($createdtime)){
            $timeArr = explode(',', $createdtime);
            if(count($timeArr)==2&&$timeArr[0]>$timeArr[1]){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
            }
            $createdtimeResult = $this->rangeKeyword($timeArr,'created_time','a');
            $where .= $createdtimeResult['where'];
            $sqlParam = array_merge($sqlParam,$createdtimeResult['sqlParam']);
        }

        $requestParams = $this->request->query->all();
        foreach($requestParams as $k => $v){
            if($v !== null && $v !== ''){
                $this->setParam($k, $v);
            }
        }

        $group  = " GROUP BY currentdate";
        $order = " ORDER BY a.created_time desc";
        $sql    = "SELECT " . $fields . " FROM `{$this->tbWeixinCard}` as a " . $where . $group .$order;
        $data   = $this->getConnection()->executeQuery($sql, $sqlParam)->fetchAll();
        $list   = [];
        $result = ['numfound' => count($data), 'list' => $list];
        date_default_timezone_set('PRC'); //设置中国时区
        //ini_set('date.timezone','Asia/Shanghai');
        foreach($data as $v){
            $startTime = strtotime($v['currentdate']);
            $endTime   = $startTime + 86399;
            $list[]    = ['currentdate' => $v['currentdate'], 'starttime' => $startTime, 'endtime' => $endTime,'num'=>(int)$v['num']];
        }
        $result['list'] = $list;

        return $this->renderJsonSuccess($result);
    }


    public function postAction(){
        $this->accesstime = $this->getTimestamp1();
        $this->em         = $this->getManager();
        $this->baseInit();
        $this->request  = $this->getRequest();
        $type           = $this->strip_tags(trim($this->request->get("act")));
        $this->wechatid = $this->strip_tags(trim($this->request->get('wechatid')));
        if(isset($this->wechatid)){
            $this->accountId = $this->wechatid;
        }
        switch($type){
            case 'folder'://添加文件夹
                return $this->_addAnyscanFolder();
                break;
            case 'editfolder'://修改文件夹
                return $this->_editAnyscanFolder();
                break;
            case 'del'://图片信息的删除处理 支持批量删除
                return $this->_getAnyscanDelFile();
                break;
            case 'add'://图片信息的删除处理 支持批量删除
                return $this->_getAnyscanFileAddFolder();
                break;
            case 'delkwd'://搜索关键字的删除处理 支持批量删除
                return $this->_getAnyscanDelKeywords();
                break;
            default:
                return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
                break;
        }
    }

    /***
     * 添加修改任意扫分类操作
     */
    private function _addAnyscanFolder(){
        $this->request = Request::createFromGlobals();
        $this->wechatid      = $this->strip_tags(trim($this->request->get('wechatid')));
        $classname     = $this->strip_tags(trim($this->request->get('classname')));

        if(empty($this->wechatid) || !isset($this->wechatid) || empty($classname) || !isset($classname)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $sqlParam = [":wechatid" => $this->wechatid, ":classname" => $classname];

        $querySql = "SELECT * FROM `weixin_other_tag` WHERE `wechat_id`= :wechatid AND `tag`= :classname limit 1";
        $data     = $this->getConnection()->executeQuery($querySql, $sqlParam)->fetch();
        $time     = $this->getTimestamp();
        $this->getConnection()->beginTransaction();
        try{
            if(!empty($data) && isset($data)){
                $updateSql = "UPDATE `weixin_other_tag` SET `status`= 0,`modify_time`=:time WHERE id = :id";
                $this->getConnection()->executeQuery($updateSql, [':id' => $data['id'], ':time' => $time]);
                $id = $data['id'];
            }else{
                $weixinOtherTag = new WeixinOtherTag();
                $weixinOtherTag->setWechatId($this->wechatid);
                $weixinOtherTag->setCreatedTime($time);
                $weixinOtherTag->setModifyTime($time);
                $weixinOtherTag->setTag($classname);
                $weixinOtherTag->setStatus(0);
                $this->getManager()->persist($weixinOtherTag);
                $this->getManager()->flush();
                $id = $weixinOtherTag->getId();
            }
            $result = ['classid'=>$id];
            $this->getConnection()->commit();

            return $this->renderJsonSuccess($result);
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            throw $ex;
        }
    }

    /***
     * 编辑删除任意扫分类操作
     */
    private function _editAnyscanFolder(){
        $this->request = Request::createFromGlobals();
        $classid = $this->strip_tags(trim($this->request->get('classid')));
        $type    = $this->strip_tags(trim(strtolower($this->request->get('type'))));

        if(!in_array($type, ['edit', 'del'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }

        if(empty($this->wechatid) || !isset($this->wechatid) || empty($classid) || !isset($classid) || empty($type) || !isset($type)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $classid           = array_unique(json_decode($classid, true));
        $time              = $this->getTimestamp();
        $sqlParam          = [':wechatid' => $this->wechatid, ':id' => $classid[0]];
        $sqlParam[':time'] = $time;
        try{
            if($type == 'edit'){
                $classname = $this->strip_tags(trim($this->request->get('classname')));
                if(empty($classname) || !isset($classname)){
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
                }
                //判断该分类id是否存在
                $querySql = "SELECT * FROM `weixin_other_tag` WHERE `wechat_id`= :wechatid AND id = :id limit 1";
                $data     = $this->getConnection()->executeQuery($querySql, $sqlParam)->fetch();
                if(empty($data) || !isset($data)){
                    $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                }
                $sqlParam[':id'] = $data['id'];
                //判断新的文件夹是否存在
                $sqlParam[':classname'] = $classname;
                $querySql               = "SELECT * FROM `weixin_other_tag` WHERE `wechat_id`= :wechatid AND `tag` = :classname limit 1";
                $data                   = $this->getConnection()->executeQuery($querySql, $sqlParam)->fetch();
                if(!empty($data) && isset($data)){
                    $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
                }
                //执行更新操作
                $this->getConnection()->beginTransaction();
                $updateSql = "UPDATE `weixin_other_tag` SET `tag`= :classname,`modify_time`=:time WHERE id = :id";
                $this->getConnection()->executeQuery($updateSql, $sqlParam);
            }else{ //执行删除操作
                $ids      = implode(',', $classid);
                $querySql = "SELECT COUNT(*) FROM `weixin_other_tag` WHERE `wechat_id`= :wechatid AND `id` IN ( " . $ids . " ) AND `status`=0";
                $count    = $this->getConnection()->executeQuery($querySql, $sqlParam)->fetchColumn();

                if($count != count($classid)){
                    //数据条数不匹配
                    return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
                }
                $this->getConnection()->beginTransaction();
                $updateSql = "UPDATE `weixin_other_tag` SET `status`= 1,`modify_time`=:time WHERE `wechat_id`= :wechatid AND  id in ( " . $ids . " )";
                $this->getConnection()->executeQuery($updateSql, $sqlParam);
            }
            $this->getConnection()->commit();

            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollback();
            throw $ex;
        }
    }

    /***
     * 删除任意扫图片信息
     */
    private function _getAnyscanDelFile(){
        $ids = $this->strip_tags(trim($this->request->get('id')));
        if(!isset($this->wechatid) || empty($this->wechatid)||!isset($ids)||empty($ids)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $classid = $this->strip_tags(intval(trim($this->request->get('classid'))));
        $ids = implode(",", array_keys(array_flip(json_decode($ids,true))));
        $sqlParam = [':wechatid'=>$this->wechatid];
        $querySql = "SELECT id FROM `weixin_other_pic` WHERE `wechat_id`= :wechatid AND id IN ({$ids})";

        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)||!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $ids = $this->i_array_column($data,'id');
        $this->getConnection()->beginTransaction();
        try{
            if(isset($classid)&&!empty($classid)){
                $actSql = "DELETE FROM `weixin_other_tag_info` WHERE `wechat_id` = :wechatid AND `card_id` IN (".implode(',',$ids).")";
            }else{
                $actSql = "UPDATE `weixin_other_pic` SET `state` = 99 WHERE `wechat_id` = :wechatid AND `id` IN (".implode(',',$ids).")";
            }
            $this->getConnection()->executeQuery($actSql,$sqlParam);
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollBack();
            throw $ex;
        }
    }
    private function _getAnyscanDelFileV2(){
        $ids = $this->strip_tags(trim($this->request->get('id')));
        if(!isset($this->wechatid) || empty($this->wechatid)||!isset($ids)||empty($ids)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $classid = $this->strip_tags(intval(trim($this->request->get('classid'))));
        $ids = implode(",", array_keys(array_flip(json_decode($ids,true))));
        $sqlParam = [':wechatid'=>$this->wechatid];
        $querySql = "SELECT id FROM `{$this->tbWeixinCard}` WHERE `wechat_id`= :wechatid AND card_type=2 AND id IN ({$ids})";

        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)||!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $ids = $this->i_array_column($data,'id');
        $this->getConnection()->beginTransaction();
        try{
            if(isset($classid)&&!empty($classid)){
                $actSql = "DELETE FROM `weixin_other_tag_info` WHERE `wechat_id` = :wechatid AND `card_id` IN (".implode(',',$ids).")";
            }else{
                $actSql = "UPDATE `{$this->tbWeixinCard}` SET `status` = 2 WHERE `wechat_id` = :wechatid AND card_type=2 AND `id` IN (".implode(',',$ids).")";
            }
            $this->getConnection()->executeQuery($actSql,$sqlParam);
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollBack();
            throw $ex;
        }
    }

    /***
     *  搜索关键字删除或许清空
     */
    private function _getAnyscanDelKeywords(){
        $ids = $this->strip_tags(trim($this->request->get('id')));
        if(!isset($this->wechatid) || empty($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }

        $type = $this->strip_tags(trim(strtolower($this->request->get('type'))));
        if(empty($type) || !isset($type) || !in_array($type, ['all', 'custom'])){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        $where = " WHERE `wechat_id` = :wechatid ";
        $sqlParam = [':wechatid'=>$this->wechatid];
        if($type=='custom'){
            if(!isset($ids)||empty($ids)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
            }
            $ids = implode(",", array_keys(array_flip(json_decode($ids,true))));
            $querySql = "SELECT id FROM `weixin_other_search_history` WHERE `wechat_id`= :wechatid AND id IN ({$ids})";
            $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
            if(empty($data)||!isset($data)){
                return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $ids = $this->i_array_column($data,'id');
            $where .= " AND `id` IN (".implode(',',$ids).")";
        }

        $this->getConnection()->beginTransaction();
        try{
           $actSql = "UPDATE `weixin_other_search_history` SET `valid` = 1 ".$where;
            $this->getConnection()->executeQuery($actSql,$sqlParam);
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollBack();
            throw $ex;
        }
    }

    /***
     * 文件关联到自定义文件夹
     */
    private function _getAnyscanFileAddFolder(){
        $ids = $this->strip_tags(trim($this->request->get('id')));
        $classid = $this->strip_tags(intval(trim($this->request->get('classid'))));
        //判断是否为空
        if(!isset($ids)||empty($ids)||!isset($classid)||empty($classid)||empty($this->wechatid)||!isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //验证该分类是否存在
        $querySql = "SELECT `tag` FROM `weixin_other_tag` WHERE wechat_id = :wechatid AND id =:classid AND `status` = 0 LIMIT 1";
        $sqlParam = [':wechatid'=>$this->wechatid,':classid'=>$classid];
        $tag = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchColumn();
        if(empty($tag)||!isset($tag)){
            //用户分类不存在
            return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS);
        }
        //查询图片id是否属于该用户 进行id筛选
        $ids = implode(",", array_keys(array_flip(json_decode($ids,true))));
        $sqlParam = [':wechatid'=>$this->wechatid];
        $querySql = "SELECT id FROM `weixin_other_pic` WHERE `wechat_id`= :wechatid AND `state`= 100 AND id IN ({$ids})";

        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)||!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $ids = $this->i_array_column($data,'id');
        $sqlParam[':classid'] = $classid;

        //获取该类型中已绑定的 名片id
        $querySql = "SELECT card_id FROM `weixin_other_tag_info` WHERE `user_id`= :wechatid AND `tag_encoding` = :classid AND card_id IN (".implode(',',$ids).")";
        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(isset($data)&&!empty($data)){
            //针对已存在的id进行筛选
            $ids = array_diff($ids, $this->i_array_column($data,'card_id'));
        }

        if(empty($ids)){
            return $this->renderJsonSuccess();
        }
        $time = $this->getTimestamp();
        $this->getConnection()->beginTransaction();
        try{
            //拼接sql写入数据
            $insertSql = " INSERT INTO `weixin_other_tag_info` (`card_id`,`user_id`,`tag_encoding`,`tag`,`create_time`,`update_time`) VALUES ";
            foreach($ids as $v){
                $insertSql .= "({$v},'{$this->wechatid}',{$classid},'{$tag}',{$time},{$time}),";
            }
            $insertSql = substr($insertSql,0,-1);
            $this->getConnection()->executeQuery($insertSql);
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollBack();
            throw $ex;
        }

    }
    private function _getAnyscanFileAddFolderV2(){
        $ids = $this->strip_tags(trim($this->request->get('id')));
        $classid = $this->strip_tags(intval(trim($this->request->get('classid'))));
        //判断是否为空
        if(!isset($ids)||empty($ids)||!isset($classid)||empty($classid)||empty($this->wechatid)||!isset($this->wechatid)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //验证该分类是否存在
        $querySql = "SELECT `tag` FROM `weixin_other_tag` WHERE wechat_id = :wechatid AND id =:classid AND `status` = 0 LIMIT 1";
        $sqlParam = [':wechatid'=>$this->wechatid,':classid'=>$classid];
        $tag = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchColumn();
        if(empty($tag)||!isset($tag)){
            //用户分类不存在
            return $this->renderJsonFailed(Errors::$ERROR_NOTEXISTS);
        }
        //查询图片id是否属于该用户 进行id筛选
        $ids = implode(",", array_keys(array_flip(json_decode($ids,true))));
        $sqlParam = [':wechatid'=>$this->wechatid];
        $querySql = "SELECT id FROM `{$this->tbWeixinCard}` WHERE `wechat_id`= :wechatid AND card_type=2 AND `status`= 1 AND id IN ({$ids})";

        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(empty($data)||!isset($data)){
            return $this->renderJsonSuccess(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $ids = $this->i_array_column($data,'id');
        $sqlParam[':classid'] = $classid;

        //获取该类型中已绑定的 名片id
        $querySql = "SELECT card_id FROM `weixin_other_tag_info` WHERE `user_id`= :wechatid AND `tag_encoding` = :classid AND card_id IN (".implode(',',$ids).")";
        $data = $this->getConnection()->executeQuery($querySql,$sqlParam)->fetchAll();
        if(isset($data)&&!empty($data)){
            //针对已存在的id进行筛选
            $ids = array_diff($ids, $this->i_array_column($data,'card_id'));
        }

        if(empty($ids)){
            return $this->renderJsonSuccess();
        }
        $time = $this->getTimestamp();
        $this->getConnection()->beginTransaction();
        try{
            //拼接sql写入数据
            $insertSql = " INSERT INTO `weixin_other_tag_info` (`card_id`,`user_id`,`tag_encoding`,`tag`,`create_time`,`update_time`) VALUES ";
            foreach($ids as $v){
                $insertSql .= "({$v},'{$this->wechatid}',{$classid},'{$tag}',{$time},{$time}),";
            }
            $insertSql = substr($insertSql,0,-1);
            $this->getConnection()->executeQuery($insertSql);
            $this->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch(\Exception $ex){
            $this->getConnection()->rollBack();
            throw $ex;
        }

    }

//date_default_timezone_set("Etc/GMT");//这是格林威治标准时间,得到的时间和默认时区是一样的
//date_default_timezone_set("Etc/GMT+8");//这里比林威治标准时间慢8小时
//date_default_timezone_set("Etc/GMT-8");//这里比林威治标准时间快8小时
}