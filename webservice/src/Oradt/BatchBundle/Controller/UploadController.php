<?php 
/* 
 * 文件上传
 * @date 2015-8-4
 */
namespace Oradt\BatchBundle\Controller;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\Errors;
use Oradt\Utils\Codes;
use Oradt\StoreBundle\Entity\Upload;
use Oradt\Utils\RandomString;

class UploadController extends BaseController
{
    /*上传无账号限制，需登录*/
    /**
     * @param $type int 1:亚马逊2普通
     */
    public function postAction()
    {   
        $request  = $this ->getRequest();
        $wechatid = $this->strip_tags($request->get('wechatid')); 
        
        $file = $request ->files ->get("resource");
        $type = $request->get('type');
        if (empty($type) || !in_array($type, array(1,2))) {
            $type = 1;
        }
        if (!is_object($file)) 
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
       
        $root = $this->container->getParameter('DOC_ROOT');
        $y    = date("Y", time());
        $md   = date("md", time());
        $fileInfo = array(
            "DOC_ROOT"  => $root,
            "PATH"      => $this ->container ->getParameter("UPLOAD_DIR") . $y . "/" . $md . "/"
            );
        $dirService  = $this ->container ->get("dirs_service");
        $webPath =  $dirService ->uploadFile($file, $fileInfo);
        $thumpath=  $dirService ->getThumbPath($webPath,320,210,0);//相同大小，会失真
        $url  = $this ->getResurl($webPath);
        $thum = $this ->getResurl($thumpath);
        /*生成数据库参数aaaaa*/
        $upload_id = RandomString::make(36);
        $path      = $webPath;
        $em  = $this->getDoctrine()->getManager();
        $data = array("path"=> $url,'uploadid'=>$upload_id,'thum'=>$thum);
        $upload = new Upload();
        $upload ->setUploadId($upload_id);
        $upload ->setUploadTime($this ->getDateTime());
        $upload ->setPath($webPath);
        $upload ->setType($this ->accountType);
        $upload ->setUserId($wechatid);
        $upload ->setThumPath($thumpath);
        $em ->persist($upload);
        $em ->flush();
        return $this ->renderJsonSuccess($data);
    }


    public function getAction()
    {
        $request  = $this ->getRequest();
        $uploadid = $this->strip_tags($request->get('uploadid'));
        $wechatid = $this->strip_tags($request->get('wechatid'));
        $where = '';
        if (!empty($wechatid)) 
            $where = " user_id='{$wechatid}' ";        
        $sqldata = array(
            "fields"  => array(
                    "uploadid" =>array("mapdb" => "upload_id", "w" => " AND upload_id = :uploadid "),
                    "datetime" =>array("mapdb" => "upload_time", "w" => "Range"),
                    "path"     =>array("mapdb" => "path"),
                    ),
            "default_dataparam"=>array(),
            "sql"     => "SELECT %s FROM `upload`%s%s",
            'where'   => "".$where,
            "order"   => " ORDER BY upload_time DESC",
            "provide_max_fields" => "datetime,path"
        );
        $check = $this->parseSql($sqldata);
        if(true !== $check)
        {
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata,'list','callable_avatar');
        return $this->renderJsonSuccess($data);
    }
    protected function callable_avatar($item)
    {
        if (isset($item ['path']) && ! empty ( $item ['path'] )) {
            $item ['path'] = $this->getCommondUrl( $item ['path'] );
        }
        return $item;
    }
}
