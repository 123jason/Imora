<?php

namespace Oradt\ServiceBundle\Services;

use Doctrine\ORM\EntityManager;
use Oradt\Utils\RandomString;
use Oradt\Utils\Codes;

/**
 * 文件操作
 */
class DirsService
{

    private $em;
    private $logger;
    private $container;
    /**
     * 
     * @var 起始位置
     */
    private $startIndex = 1;
    
    /**
     * @array 设置不允许上传文件格式
     */
    public $notAllowFileType = array('exe', 'php', 'lua', 'java', 'jsp', 'sh');


    /**
     * __construct
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $logger, $container)
    {
        $this->em = $entityManager;
        $this->logger = $logger;
        $this->container = $container;
    }

    /**
     * 获得头像存放系统路径
     * @param type $userid
     * @return string
     */
    public function getAvatarDir($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $avatardir = $this->container->getParameter('AVATAR_DIR');
        //if(empty($str) || count($str)<3)
        //    return $docroot . $avatardir;
        $avatardirpath = $docroot . $avatardir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $avatardirpath;
    }

    /**
     * 保存文件
     * 
     * @param UploadFile $uploadedFile
     * @param array $fileInfo 文保保存信息  array('DOC_ROOT'=>'根目录' , 'PATH'=>'保存目录' , 'filename' => '文件名')
     * 
     * @return string 返回web访问地址
     */
    public function uploadFile($uploadedFile, array $fileInfo)
    {
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        //的文件名
        if (isset($fileInfo['filename'])) {
            $filename = $fileInfo['filename'] . '.' . $fileExtension;
        } else {
            $filename = RandomString::make(10) . date('YmdHis') . '.' . $fileExtension;
        }
        //存放的实际地址
        $uploadDir = $fileInfo['DOC_ROOT'] . $fileInfo['PATH'];
        //访问的url地址
        $webPath = $fileInfo['PATH'] . $filename;
        //上传
        $uploadedFile->move($uploadDir, $filename);
        if(empty($webPath)){
            $webPath ='';
        }
        return $webPath;
    }
    
    /**
     * 获取缩略图
     * @param string $path 文件完整路径
     * @param intger $newwidth 缩略图宽
     * @param intger $newheight 缩略图高
     * @param string $fixed_orig 锁定宽高（可选参数 width（固定宽）、height（固定高）、width/height（等比例）或者空值（固定大小））
     * @return string 缩略图文件保存路径
     */
    public function getThumbPath($path, $width, $height,$fixed_orig = '')
    {
            $DOC_ROOT = $this->container->getParameter('DOC_ROOT');
            $realpath = $DOC_ROOT.$path; //文件真实路径
        //判断是否存在文件
        $content = @file_get_contents($realpath);
        if (!empty($content)) {
            if(file_exists($realpath)){
                $directory = dirname($path);
                $name = basename($path);      
                //获取文件信息
                $filetype = @exif_imagetype($realpath);
                switch($filetype){
                    case 1: $extName="gif";break;
                    case 2: $extName="jpg";break;
                    case 3: $extName="png";break;
                    case 6: $extName="bmp";break;
                    default: return false;
                }
                //ini_set('gd.jpeg_ignore_warning', 1);
                switch ($extName){
                    case 'gif':
                            $temp_img = imagecreatefromgif($realpath);
                            break;
                    case 'png':
                            $temp_img = imagecreatefrompng($realpath);
                            break;
                    case 'jpg':
                            $temp_img = imagecreatefromjpeg($realpath);
                            break;
                    case 'bmp':
                            $temp_img = imagecreatefromgif($realpath);
                            break;
                    default:
                            
                }
                $o_width = imagesx($temp_img);  //获取原图宽
                $o_height = imagesy($temp_img); //获取原图高
                $o_scale = $o_height / $o_width;    //获取原图比例

//                if( $o_width < $o_height ){
//                    if($fixed_orig == 'width'){
//                        $fixed_orig == 'height';
//                    }
//                    if($fixed_orig == 'height'){
//                        $fixed_orig == 'width';
//                    }
//                    $transWidth = $width;
//                    $width = $height;
//                    $height = $transWidth;
//                }

                if ($fixed_orig == 'width'){
                    //宽度固定
                    $height = $width * $o_scale;
                }elseif ($fixed_orig == 'height'){
                    //高度固定
                    $width = $height / $o_scale;
                }elseif ($fixed_orig == 'width/height'){
                    //最大宽或最大高
                    if ($height / $width > $o_scale){
                        $height = $width * $o_scale;
                    }else{
                        $width = $height / $o_scale;
                    }
                }else{//固定宽高

                }

                $d_scale = $height / $width;    //缩略图比例
                //根据缩略图比例剪切原图片
                if ($d_scale >= $o_scale){
                        $newheight = $o_height;
                        $newwidth = $newheight / $d_scale;
                        $x = ($o_width - $newwidth) / 2;
                        $y = 0;
                }

                if ($d_scale < $o_scale){
                        $newwidth = $o_width;
                        $newheight = $newwidth * $d_scale;
                        $x = 0;
                        $y = ($o_height - $newheight) / 2;
                }

                $cut = imagecreatetruecolor($width, $height);
                imagecopyresampled($cut, $temp_img, 0, 0, $x, $y, $width, $height, $newwidth, $newheight);
                //保存修剪后的原图
                $filename = $DOC_ROOT.$directory."/"."thumb_".$name;
                switch ($extName){
                    case 'gif':
                            imagegif($cut, $filename);
                            //$cut_img = imagecreatefromgif($filename);
                            break;
                    case 'png':
                            imagepng($cut, $filename);
                            //$cut_img = imagecreatefrompng($filename);
                            break;
                    case 'jpg':
                            imagejpeg($cut, $filename,100);
                            //$cut_img = imagecreatefromjpeg($filename);
                            break;
                    case 'bmp':
                            imagewbmp($cut, $filename);
                            //$cut_img = imagecreatefromgif($filename);
                            break;
                    default:
                        return false;
                }            
                return $directory."/"."thumb_".$name;
            }else{
                return false;
            }    
        }else{
            return false;
        }
        
    }
    
    /**
     * 获取名片文件保存路径
     * 
     * @param unknown $userId
     * @param string $vcardId
     * @return multitype:string unknown
     */
    public function getCardDir($userId,$vcardId='')
    {
        $docroot = $this->container->getParameter('DOC_ROOT');
        $dir = $this->container->getParameter('DOCUMENT_DIR'); //获取文档配置文件上传路径
        $str = substr($userId, $this->startIndex, 3);        
        $path = $dir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userId . '/';
        if(!empty($vcardId))
        {
            $path .= $vcardId . '/';
        }        
        return array('DOC_ROOT' => $docroot , 'PATH' => $path ,'filename' => $vcardId);
    }
    /**
     * 获取文件保存路径
     *
     * @param string $userId
     * @param string $filedid
     * @param string $type 
     * @return multitype:string unknown
     */
    public function getFiledDir($userId,$filedid='',$type=Codes::B)
    {
    	$docroot = $this->container->getParameter('DOC_ROOT');
    	if ($type == Codes::A) {
    		$dir = $this->container->getParameter('DOCUMENT_DIR');
    	} elseif ($type == Codes::B) {
    		$dir = $this->container->getParameter('BIZ_DOCUMENT_DIR');
    	} elseif ($type == Codes::C) {
    		$dir = $this->container->getParameter('SYS_DOCUMENT_DIR');
    	}
    	$str = substr($userId, $this->startIndex, 3);
    	$path = $dir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userId . '/';
    	if(!empty($filedid))
    	{
    		$path .= $filedid . '/';
    	}
    	return array('DOC_ROOT' => $docroot , 'PATH' => $path );
    }
    
     /*
     * 获得文档存放系统路径
     * @param type $userid
     * @return string
     */
    public function getDocument($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $type = substr($userid, 0, 1);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $documentdir = '';
        if ($type == Codes::A) {
            $documentdir = $this->container->getParameter('DOCUMENT_DIR');
        } elseif ($type == Codes::B) {
            $documentdir = $this->container->getParameter('BIZ_DOCUMENT_DIR');
        } elseif ($type == Codes::C) {
            $documentdir = $this->container->getParameter('SYS_DOCUMENT_DIR');
        }
        $documentdirpath = $docroot . $documentdir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $documentdirpath;
    }


    /**
     *  获取系统头件上传目录
     *  
     *  @return array('DOC_ROOT'=>'根目录' , 'PATH'=>'保存目录')
     */
    public function getSystemAvatarDir($curruntDir)
    {
        $docroot = $this->container->getParameter('DOC_ROOT');
        $dir = $this->container->getParameter('SYS_DOCUMENT_DIR');
        return array('DOC_ROOT' => $docroot, 'PATH' => $dir . 'avatar/' . $curruntDir . '/');
    }

    /**
     * 获得文档存放系统路径
     * @param type $userid
     * @return string
     */
    public function getDocumentDir($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $documentdir = $this->container->getParameter('DOCUMENT_DIR');
        $documentdirpath = $docroot . $documentdir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $documentdirpath;
    }

    /**
     * 获得企业账户文档路径
     * @param type $userid
     * @return string
     */
    public function getBizDocumentDir($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $documentdir = $this->container->getParameter('BIZ_DOCUMENT_DIR');
        $documentdirpath = $docroot . $documentdir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $documentdirpath;
    }

    /**
     * 获得系统文档存放路径
     * @param type $userid
     * @return string
     */
    public function getSysDocumentDir($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir = $this->container->getParameter('SYS_DOCUMENT_DIR');
        $sysdocumentdirpath = $docroot . $sysdocumentdir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $sysdocumentdirpath;
    }
    /**
     * 获得背景配置图片路径
     * @param type $userid
     * @return string
     */
    public function getConfigBackgroundDir($userid)
    {
        $str = substr($userid, $this->startIndex, 3);
        $docroot = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir = $this->container->getParameter('BACKGROUND_DIR');
        $sysdocumentdirpath = $docroot . $sysdocumentdir . $str[0] . '/' . $str[1] . '/' . $str[2] . '/' . $userid;
        return $sysdocumentdirpath;
    }

    /**
     * 通过token获得上传文件夹目录
     * @param type $token
     * @param file      $uploadedFile   文件
     * @param string    $userId         用户id
     * @param string    $tempid         表示扫描名片id 其他记录id
     * @param string $filenameFix 文件名后缀 比如：abcsdfd20151002234_a.jpg  2015-3-11 by xuejiao add
     * @return 文件存放的路径
     */
    public function getFolderPath($uploadedFile, $userId, $type = '', $tempid = '',$filenameFix='')
    {
        //文件扩展名
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $rand = new RandomString();
        //存放的文件名
        if(!empty($filenameFix)){
            $filename = $rand->make(10) . date('YmdHis') .$filenameFix .'.'.$fileExtension;
        }else{
            $filename = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        }
        //type为空默认avatar上传路径
        $docroot = $this->container->getParameter('DOC_ROOT');
        if (empty($type)) {
            $dir = $this->container->getParameter('AVATAR_DIR'); //获取头像配置文件上传路径
        } else if ($type == Codes::BIZ) {
            $dir = $this->container->getParameter('BIZ_DOCUMENT_DIR'); //获取企业文档配置文件上传路径
        } else if ($type == Codes::SYS) {
            $dir = $this->container->getParameter('SYS_DOCUMENT_DIR'); //获取系统文档配置文件上传路径
        } else if ($type == Codes::BACKGROUND) {
            $dir = $this->container->getParameter('BACKGROUND_DIR'); //获取背景配置文件目录
        } else if ($type == 'ask') {
            $dir = $this->container->getParameter('SNS_NEWS');              //sns问答资讯
        } else if ('themeSns' == $type) {
            $dir = $this->container->getParameter('SNS_NEWS');
        }else {
            $dir = $this->container->getParameter('DOCUMENT_DIR'); //获取文档配置文件上传路径
        }
        $pathName = implode(str_split(substr($userId, $this->startIndex, 3), 1), '/') . '/' . $userId;
        if (!empty($tempid)) {
            $pathName .='/' . $tempid;
        }
        //存放的实际地址
        $uploadDir = $docroot . $dir . $pathName;
        //访问的url地址
        $webPath = $dir . $pathName . '/' . $filename;
        //上传
        if ('themeSns' == $type) {
            $name = $uploadedFile->getClientOriginalName();
            // if ('orashow.wgtu' != $name) 
            //     $name = 'orashow.wgtu';
            $filename = $name;
            $uploadDir = $docroot . $dir;
            $webPath   = $dir.$filename;
        }
        $uploadedFile->move($uploadDir, $webPath);
        return $webPath;
    }
    /**
     * 上传客服头像
     * @param  file      $uploadFile  
     * @return false|true
     */
    public function uploadCustomerFile($uploadFile)
    {
        $fileExtension = $uploadFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $docroot = $this->container->getParameter('DOC_ROOT');
        $dir = $this->container->getParameter('AVATAR_DIR'); //获取头像配置文件上传路径
        $filename = 'customer' . '.' . $fileExtension;
        // $pathName = 'c/c/c';
        $pathName = '';
        //存放的实际地址
        $uploadDir = $docroot . $dir . $pathName;
        //访问的url地址
        $webPath = $dir . $pathName  . $filename;
        // print_r($uploadDir);
        // print_r($webPath);
        $uploadFile->move($uploadDir, $webPath);
        return $webPath;
    }
   /**
     * 设计师相关获得上传文件夹目录
     * @param type $token
     * @param file      $uploadedFile   文件
     * @param string    $userId         用户id
     * @param string    $tempid         表示扫描名片id 其他记录id
     * @param string $filenameFix 文件名后缀 比如：abcsdfd20151002234_a.jpg  2015-3-11 by xuejiao add
     * @return 文件存放的路径
     */
    public function getDesignFolderPath($uploadedFile, $id, $type = '',$filenameFix='')
    {
        //文件扩展名
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $rand = new RandomString();
        //存放的文件名
        if(!empty($filenameFix)){
            $filename = $rand->make(10) . date('YmdHis') .$filenameFix .'.'.$fileExtension;
        }else{
            $filename = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        }
        //type为空默认avatar上传路径
        $docroot = $this->container->getParameter('DOC_ROOT');
        if (empty($type)) {
            $dir = $this->container->getParameter('DESIGN_USER_DIR'); //获取头像配置文件上传路径
        } else if ($type == 'project') {
            $dir = $this->container->getParameter('DESIGN_PROJECT_DIR'); //获取企业文档配置文件上传路径
        } else if ($type == 'product') {
            $dir = $this->container->getParameter('DESIGN_PRODUCT_DIR'); //获取系统文档配置文件上传路径
        } else if ($type == 'works') {
            $dir = $this->container->getParameter('DESIGN_WORKS_DIR'); //获取系统文档配置文件上传路径
        }else {
            $dir = $this->container->getParameter('DESIGN_OTHER_DIR'); //获取文档配置文件上传路径
        }
        $pathName = implode(str_split(substr($id, $this->startIndex, 3), 1), '/') . '/' . $id;

        //存放的实际地址
        $uploadDir = $docroot . $dir . $pathName;
        //访问的url地址
        $webPath = $dir . $pathName . '/' . $filename;
        //上传
        $uploadedFile->move($uploadDir, $webPath);
        return $webPath;
    }
    
    /**
     * 复制文件
     * @param type $uploadedFile
     * @param type $userId
     * @param type $type
     * @return string
     */
    public function copyFile($uploadedFile,array $fileInfo)
    {
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        //的文件名
        if(isset($fileInfo['filename']))
        {
            $filename = $fileInfo['filename'] . '.' . $fileExtension; 
        }else {
            $filename = RandomString::make(10) . date('YmdHis') . '.' . $fileExtension;
        }       
        //存放的实际地址
        $uploadDir = $fileInfo['DOC_ROOT'] . $fileInfo['PATH'];
        //访问的url地址
        $webPath = $fileInfo['PATH'] . $filename;
        //上传
        //$uploadedFile->move($uploadDir, $filename);
        //复制
        $uploadedFile->copy($uploadDir . '/' . $filename);
        return $webPath;
    }
    
    /**
     * sns 活动 资源文件上传  add 2015-02-03
     * @param type $uploadedFile        上传文件
     * @param type $date                活动    [群组会话的] 的创建日期 传入的是格式为 2015-02-03 12:02:03
     * @param type $activityId          活动ID  [群组ID]
     * @param type $resourceId          资源ID  [群组消息ID]
     * @param type $type    'activity'[默认活动] 'grouptalk'[群组会话]
     * path = /data/images/sns/activity/20150203/a/b/c/abc活动id/资源id/文件名
     */
    public function uploadSnsActivityResourcePath($uploadedFile,$date,$activityId,$resourceId,$type='activity'){
        if(empty($uploadedFile) || empty($date) || empty($activityId) || empty($resourceId)){
            return FALSE;
        }
        //文件扩展名
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $rand       = new RandomString();
        //存放的文件名
        $filename   = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        //type为空默认avatar上传路径
        $docroot    = $this->container->getParameter('DOC_ROOT');               //系统图片存放根目录/data/images/
        if($type === 'grouptalk'){
            $dir        = $this->container->getParameter('SNS_GROUP_TALK_DIR'); //sns群组会话目录
        }elseif($type == 'snstrends'){
            $dir        = $this->container->getParameter('SNS_TRENDS_DIR');       //sns群组存放目录  sns/group/
        }elseif ($type == 'candidate') {
            $dir = $this->container->getParameter('SNS_CANDIDATE_DIR');       //sns群组存放目录  sns/group/
        }elseif ($type == 'ask') {
            $dir = $this->container->getParameter('SNS_NEWS');              //sns问答资讯
        }
        else{
            $dir        = $this->container->getParameter('SNS_ACTIVITY_DIR');   //sns活动存放目录  activity
        }
        $actDate    = str_replace('-', '', substr($date, 0,10));      //活动的创建日期目录 20150202
                
        $pathName   = '';         //对于活动资源来说  路径
        $pathName  .= $actDate . '/';   //活动的创建日期目录 20150202/
        $pathName  .= implode(str_split(substr($activityId, 0, 3), 1), '/') . '/' . $activityId . '/'.$resourceId;
        //存放的实际地址
        $uploadDir  = $docroot . $dir . $pathName;
        //访问的url地址数据存放路径
        $webPath    = $dir . $pathName . '/' . $filename;
        //上传
        $uploadedFile->move($uploadDir, $filename);
        return $webPath;
    }
    public function uploadrecordResourcePath($uploadedFile,$date,$recordId,$type='activity'){
        if(empty($uploadedFile) || empty($date) || empty($recordId) ){
            return FALSE;
        }
        //文件扩展名
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $rand       = new RandomString();
        //存放的文件名
        $filename   = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        //type为空默认avatar上传路径
        $docroot    = $this->container->getParameter('DOC_ROOT');               //系统图片存放根目录/data/images/
        if($type === 'records') {
            $dir = $this->container->getParameter('RECORD_DIR'); //记录目录
        }
        $actDate    = str_replace('-', '', substr($date, 0,10));      //活动的创建日期目录 20150202

        $pathName   = '';         //对于活动资源来说  路径
        $pathName  .= $actDate . '/';   //活动的创建日期目录 20150202/
        $pathName  .= implode(str_split(substr($recordId, 0, 3), 1), '/') . '/' . $recordId;
        //存放的实际地址
        $uploadDir  = $docroot . $dir . $pathName;
        //访问的url地址数据存放路径
        $webPath    = $dir . $pathName . '/' . $filename;
        //上传
        $uploadedFile->move($uploadDir, $filename);
        return $webPath;
    }
    
    /**
     * 获取活动资源文件路径
     * @param  string  $datedir       日期目录：即活动的创建日期
     * @param  string  $acitivityId   Description
     * @return string  /data/images/sns/activity/20150203/a/b/c/
     */
    public function getSnsActivityResourceDir($datedir,$acitivityId){
        $str        = substr($acitivityId, 0, 3);
        $docroot    = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir     = $this->container->getParameter('SNS_ACTIVITY_DIR');
        $sysdocumentdirpath = $docroot . $sysdocumentdir .$datedir.'/' . $str[0] . '/' . $str[1] . '/' . $str[2];
        return $sysdocumentdirpath;
    }
    /**
     * 获取群组会话资源文件路径
     * @param  string  $datedir   日期目录：即会话的创建日期
     * @param  string  $groupId   Description
     * @return string  /data/images/sns/activity/20150203/a/b/c/
     */
    public function getSnsGroupTalkFileDir($datedir,$groupId){
        $str        = substr($groupId, 0, 3);
        $docroot    = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir     = $this->container->getParameter('SNS_GROUP_TALK_DIR');
        $sysdocumentdirpath = $docroot . $sysdocumentdir .$datedir.'/' . $str[0] . '/' . $str[1] . '/' . $str[2];
        return $sysdocumentdirpath;
    }
    /**
     * 获取动态资源文件路径
     * @param  string  $datedir   日期目录：即会话的创建日期
     * @param  string  $trendsId  Description
     * @return string  /data/images/sns/activity/20150203/a/b/c/
     */
    public function getSnsTrendsFileDir($datedir,$trendsId){
        $str        = substr($trendsId, 0, 3);
        $docroot    = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir     = $this->container->getParameter('SNS_TRENDS_DIR');
        $sysdocumentdirpath = $docroot . $sysdocumentdir .$datedir.'/' . $str[0] . '/' . $str[1] . '/' . $str[2];
        return $sysdocumentdirpath;
    }
    /**
     * 上传SNS模块相关的文件
     * @param string $uploadedFile  上传文件
     * @param string $needId        需要将首3个字母 拆分为3层目录的id
     * @param string $type          [snsgroup]sns群组
     * @param string $tempid        添加一层目录
     * path = /data/images/activity/20150203/a/b/c/abc活动id/资源id/文件名
     */
    public function uploadSnsRelatedFile($uploadedFile,$needId,$type='snsgroup',$tempid=''){
        if(empty($uploadedFile) || empty($needId)){
            return FALSE;
        }
        //文件扩展名
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $flag = $this->safeCheck($fileExtension);
        if( true === $flag){
            return '';
        }
        $rand       = new RandomString();
        //存放的文件名
        $filename   = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        if(empty($type)){
            return FALSE;
        }
        $docroot    = $this->container->getParameter('DOC_ROOT');            //系统图片存放根目录/data/images/
        if($type == 'snsgroup'){
            $dir        = $this->container->getParameter('SNS_GROUP_DIR');       //sns群组存放目录  sns/group/
        }elseif($type == 'snstrends'){
            $dir        = $this->container->getParameter('SNS_TRENDS_DIR');       //sns群组存放目录  sns/group/
        }
        $pathName   = '';               // 路径
        $pathName  .= implode(str_split(substr($needId, 0, 3), 1), '/') . '/' . $needId;
        if (!empty($tempid)) {
            $pathName .='/' . $tempid;
        }
        //存放的实际地址
        $uploadDir  = $docroot . $dir . $pathName;
        //访问的url地址数据存放路径
        $webPath    = $dir . $pathName . '/' . $filename;
        //上传
        $uploadedFile->move($uploadDir, $filename);
        return $webPath;
    }
    /**
     * 获取群组logo图片
     * @param  string  $groupId       群组id 首3个字母用来拆分为3层目录
     * @return string  /data/images/sns/group/a/b/c/
     */
    public function getSnsGroupLogoDir($groupId){
        $str        = substr($groupId, 0, 3);
        $docroot    = $this->container->getParameter('DOC_ROOT');
        $sysgroupdir     = $this->container->getParameter('SNS_GROUP_DIR');
        $sysgroupdirpath = $docroot . $sysgroupdir . $str[0] . '/' . $str[1] . '/' . $str[2] .'/';
        return $sysgroupdirpath;
    }

    /**
     * @author wangxy
     * @param $datedir
     * @param $userId
     * @param $msgId
     * @return string
     */
    public function getSnsTalkFileDir($datedir,$msgId){
        $str        = substr($msgId, 0, 3);
        $docroot    = $this->container->getParameter('DOC_ROOT');
        $sysdocumentdir     = $this->container->getParameter('SNS_TALK');
        $sysdocumentdirpath = $docroot . $sysdocumentdir .$datedir.'/' . $str[0] . '/' . $str[1] . '/' . $str[2].'/'.$msgId.'/';
        return $sysdocumentdirpath;
    }
    /**
     * @author xinggm 2016-1-22
     * @param type $uploadedFile        文件base64流
     * @param type $date                活动    [问答] 的创建日期 传入的是格式为 2015-02-03 12:02:03
     * @param type $activityId          活动ID  [问答]
     * @param type $resourceId          资源ID  [资源ID]
     * @param type $type    'activity'[默认活动] 'grouptalk'[群组会话]
     * path = /data/images/sns/activity/20150203/a/b/c/abc活动id/资源id/文件名
     */
    public function uploadAskResourceBase($uploadedFile,$date,$activityId,$resourceId,$type='activity')
    {
        if(empty($uploadedFile) || empty($date) || empty($activityId) || empty($resourceId)){
            return FALSE;
        } 
        $fileExtension = $data = '';       
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $uploadedFile, $result)) {
            $fileExtension = $result[2];
            $data          = $result[1];
        }else{
            return FALSE;
        }
        if (empty($fileExtension) || empty($data)) return false;
        //文件扩展名
        $rand       = new RandomString();
        //存放的文件名
        $filename   = $rand->make(10) . date('YmdHis') . '.' . $fileExtension;
        //type为空默认avatar上传路径
        $docroot    = $this->container->getParameter('DOC_ROOT');               //系统图片存放根目录/data/images/
        if($type === 'grouptalk'){
            $dir        = $this->container->getParameter('SNS_GROUP_TALK_DIR'); //sns群组会话目录
        }elseif($type == 'snstrends'){
            $dir        = $this->container->getParameter('SNS_TRENDS_DIR');       //sns群组存放目录  sns/group/
        }elseif ($type == 'candidate') {
            $dir = $this->container->getParameter('SNS_CANDIDATE_DIR');       //sns群组存放目录  sns/group/
        }elseif ($type == 'ask') {
            $dir = $this->container->getParameter('SNS_NEWS');              //sns问答资讯
        }
        else{
            $dir        = $this->container->getParameter('SNS_ACTIVITY_DIR');   //sns活动存放目录  activity
        }
        $actDate    = str_replace('-', '', substr($date, 0,10));      //活动的创建日期目录 20150202
                
        $pathName   = '';         //对于活动资源来说  路径
        $pathName  .= $actDate . '/';   //活动的创建日期目录 20150202/
        $pathName  .= implode(str_split(substr($activityId, 0, 3), 1), '/') . '/' . $activityId . '/'.$resourceId;
        //存放的实际地址
        $uploadDir  = $docroot . $dir . $pathName;
        //访问的url地址数据存放路径
        $webPath    = $dir . $pathName . '/' . $filename;
        $uploadPath = $uploadDir.'/'.$filename;
        //上传
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir,0777,true);
        }
        $file = base64_decode(str_replace($data, '', $uploadedFile));
        $result = array();
        if (!@file_put_contents($filename, $file)) return false;
        if (is_file($filename)) {
            if(!copy($filename, $uploadPath)) {
                return false;
            }else{
                unlink($filename);
                $small = $this->getThumbPath($webPath,108,81);
                $result['path'] = $webPath;
                $result['small']= $small;
                return $result;
            }            
        }else{
            return false;
        }
    }
    
    /**
     * 文件类型排除
     * @boolean return
     */
    protected function safeCheck($extension){
        if(empty($extension)){
            return false;
        }
        if( in_array($extension, $this->notAllowFileType) ){
            return true;
        }
        return false;
    }
     /**
     * 图片旋转
     * @param $filename 文件完整路径
     * @param $degress 旋转度数
     */
    public function getRollPicture($filename,$degrees = 90){
        $root   = $this->container->getParameter('DOC_ROOT');
        //读取图片
        $data = @getimagesize($root.$filename);
        if($data==false)return false;
        //读取旧图片
        switch ($data[2]) {
            case 1:
                $src_f = imagecreatefromgif($root.$filename);break;
            case 2:
                $src_f = imagecreatefromjpeg($root.$filename);break;
            case 3:
                $src_f = imagecreatefrompng($root.$filename);break;
        }
        if($src_f=="")return false;
            $rotate = @imagerotate($src_f, $degrees,0);
        //图片后缀
        $filenameFix = strrchr($filename,'_');
        $rand = new RandomString();
        $newname = $rand->make(10).date('YmdHis').$filenameFix;
        //修改文件的路径以及后缀添加。
        $newfilename = substr_replace($filename,$newname,strrpos($filename,'/')+1);
        if(imagejpeg($rotate,$root.$newfilename,90)){
            @imagedestroy($rotate);
            return $newfilename;
        }else{
            return false;
        }
    }
    
    
    
    /**
	 * 图片缩放函数（可设置高度固定，宽度固定或者最大宽高，支持gif/jpg/png三种类型）
	 * 
	 * @param string $source_path 源图片
	 * @param int $target_width 目标宽度
	 * @param int $target_height 目标高度
	 * @param string $fixed_orig 锁定宽高（可选参数 width、height或者空值）
	 * @param string $iffiller   再缩放的宽度/高度 不够目标宽度/高度时 是否补白处理 （默认 false）
	 * @return string
	 */
	public function myImageResize($source_path, $target_width = 200, $target_height = 200, $fixed_orig = '',$iffiller=false){
		if( false === stripos( $source_path, "https://")){
            $DOC_ROOT = $this->container->getParameter('DOC_ROOT');
            $source_path = $DOC_ROOT.$source_path; //文件真实路径
        }
        //读取图片
        $source_info = @getimagesize($source_path);
        
        if($source_info==false) return false;
        
		$source_width   = $source_info[0];
		$source_height  = $source_info[1];
		$source_mime    = $source_info['mime'];
		$ratio_orig     = $source_width / $source_height;
		
		$w = $target_width;		//将要生成的宽度先赋值，以下缩放时会改变
		$h = $target_height;	//将要生成的高度先赋值，以下缩放时会改变
		
		if ($fixed_orig == 'width'){
			//宽度固定
			$target_height = $target_width / $ratio_orig;
		}elseif ($fixed_orig == 'height'){
			//高度固定
			$target_width = $target_height * $ratio_orig;
		}else{
			//最大宽或最大高
			if ($target_width / $target_height > $ratio_orig){
			  $target_width = $target_height * $ratio_orig;
			}else{
			  $target_height = $target_width / $ratio_orig;
			}
		}
		switch ($source_mime){
            case 'image/gif':
              $source_image = imagecreatefromgif($source_path);
              break;
            case 'image/jpeg':
              $source_image = imagecreatefromjpeg($source_path);
              break;
            case 'image/png':
              $source_image = imagecreatefrompng($source_path);
              break;
            default:
              return false;
              break;
		}
		$target_image = imagecreatetruecolor($target_width, $target_height);
		imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $target_width, $target_height, $source_width, $source_height);
		//header('Content-type: image/jpeg');
		$imgArr = explode('.', $source_path);
		$target_path = $imgArr[0] . '_thumb.' . $imgArr[1];
		imagejpeg($target_image, $target_path, 100);
		
		//如果生成的宽度或高度不够做补白处理
		if($iffiller == true && ($w > $target_width || $h > $target_height)){
			//创建一个新的图像
			//$NewImage=imagecreate($w,$h);
			$NewImage=imagecreatetruecolor($w,$h);
			//设置图像的背景颜色，白色
			$color = imagecolorallocate($NewImage, 255, 255, 255);
			//定义为透明色
			imagecolortransparent($NewImage,$color);
			//填充
			imagefill($NewImage, 0, 0, $color);
			// 读取图片
			$Image=imagecreatefromjpeg($target_path);
			//计算高宽的值
			$x=($w-$target_width)/2;
			$y=($h-$target_height)/2;
			//进行图片的合并操作
			imagecopy($NewImage,$Image,$x,$y,0,0,$target_width,$target_height);
			// 输出新的图片
			imagejpeg($NewImage,$target_path,100);
            //从内存中释放图像
			imagedestroy($NewImage);
		}
		return $target_path;
	}
    
    
}
