<?php
/**
 * @author liuping Chen <chenliuping@oradt.com>
 * get name ocr_service
 */
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\SaveFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Oradt\Utils\RandomString;

/**
 * ocr
 */
class OcrService extends BaseService {
    
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }
    
    private $cmd_path = '';
    private $pathname = '';
    private $clientoriginalname = '';
    private $clientmimetype = '';
    private $clientsize = 0;
    private $filename = '';
    private $fpath = '';
    
    public function run($pic,$picb = '',$language = 2) {
        $data = array('status' => 0);
        if($this->container->hasParameter('OCR_PATH')){
           $this->cmd_path = $this->container->getParameter('OCR_PATH');
        } else {
           return $data;
        }
        $starttime = $this->getTimestamp1();
        //可传对象，远程图片，本地图片
        if(is_object($pic)){
            $this->pathname = $pic->getPathname();
            $this->clientoriginalname = $pic->getClientOriginalName();
            $this->clientmimetype = $pic->getClientMimeType();
            $this->clientsize = $pic->getClientSize();
            $this->filename = $pic->getFileName();
            $this->fpath = $pic->getPathname();
        }else {
            //if(preg_match("/^(http:\/\/|https:\/\/).*$/",$pic)){
            $rand       = new RandomString();
            $this->filename = $rand->make(10).date('YmdHis');
            $source = @file_get_contents($pic);
            if(!$source){
                return $data;
            }
            $this->fpath = $this->cmd_path . 'src/a_'.$this->filename.'.jpg';
            file_put_contents($this->fpath,$source);
            $pic1 = pathinfo($this->fpath);
            $pic2 = getimagesize($this->fpath);
            $pic = $pic1 + $pic2 ;
            $this->pathname = $pic['dirname'];
            $this->clientoriginalname = $pic['basename'];
            $this->clientmimetype = $pic['mime'];
            $this->clientsize = filesize($this->fpath);

        } 
        

        
        self::ssLog('ocr_pic_time', $this->getTimestamp1() - $starttime);//图片本地化时间
        $data['tempf'] = array();
        $data['tempf'][] = $this->fpath;
        $starttime1 = $this->getTimestamp1();
        $vcard = exec($this->cmd_path.'NameCard '.$this->fpath.' '.$language,$log,$status);
        $paramdata = self::getLog();
        if(!empty($paramdata['pic_null'])){
            if($paramdata['pic_null'] > 1){
                self::ssLog('ocr_analysis_time_2', $this->getTimestamp1() - $starttime1);//ocr解析时间2
            } else {
                self::ssLog('ocr_analysis_time', $this->getTimestamp1() - $starttime1);//ocr解析时间1
            }
        }
        //$vcard = $this->is_json($vcard) ? $vcard : json_encode($vcard);
        //版本兼容
        $vcard = $this->is_json($vcard) ? $vcard : '';
        $vcardinfo = json_decode($vcard,true);
        if(!empty($vcardinfo['vcard'])){
            $vcard = json_encode($vcardinfo['vcard']);
            $markpoint = json_encode($vcardinfo['markpoint']);
        }else{
            $markpoint = '';
        }
        
       
        $data['ocr_status'] = $status;
        $data['vcard'] = $vcard;
        
        //对象和别的生成名字是不一样的
        if(is_object($pic)){
            $data['filepath'] = $this->cmd_path . 'output/'.$this->filename.'.jpg';
        } else {
            $data['filepath'] = $this->cmd_path . 'output/a_'.$this->filename.'.jpg';
        }
        //如果ocr没有生成图片也是一种失败
        if(!file_exists($data['filepath'])) {
            $data['status'] = 10000;
            $data['filepath'] = $this->fpath;
        }
        
        $data['tempf'][] = $data['filepath']; 
        $savef = new UploadedFile($data['filepath'] ,$this->clientoriginalname ,$this->clientmimetype ,$this->clientsize);
        $data['upobject'] = $savef;
        
        //ocr失败
        if($status){
            $data['status'] = $status;
            return $data;
        }
        
        return $data;
    }
    /**
     * 判断数据是合法的json数据: (PHP版本大于5.3)
     * @param type $string
     * @return type
     */
    public function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    
}
