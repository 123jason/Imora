<?php
/**
 * @author liuping Chen <chenliuping@oradt.com>
 * get name ocr_service
 */
namespace Oradt\ServiceBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Oradt\Utils\OcrutilTrait;

/**
 * ocr
 */
class OcrGearmanService extends BaseService {
    use OcrutilTrait;
    private $gearmanService;
    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
        if($this->container->hasParameter('OCRFILE')){
        	$this->ocr_excheange_dir = $this->container->getParameter('OCRFILE');
        } else {
        	throw new \Exception("paramenter.yml not config OCRFILE");
        }
        $this->gearmanService = $this->container->get('gearman_service');
        
        if($this->container->hasParameter('ocr_gearman_function')){
        	$this->ocr_function = $this->container->getParameter('ocr_gearman_function');
        }
    }
    
    private $ocr_function  = 'Ocr_function';
    private $ocr_function2 = 'Scan_function';
    /**
     * 
     * @var 分布式ocr文件交换目录
     */
    private $ocr_excheange_dir = '';
    private $filesize=0;
    private $fname=0;
    private $clientoriginalname='';
    
    /**
     * 
     *
     * @var 文件交换
     */
    private $arrayfiles = array();
    
    /**
     * 
     * 单图片OCR
     * 
     * @param multitype String or UploadedFile $pic
     * @param number $language
     * @param number $iscut  1表是只旋转 ,2表是ocr全功能裁切与透视变换，
     * @return array
     */
    public function run($pic,$language = 2) {
        $starttime1 = $this->getTimestamp1();
        static $ocrlog = array();//存ocr时间
        static $ydtime = array();//存图片移动时间
        $data = array('status' => 0);            
        //文件对象
        $fileinfo = array();
        //本地图片路径
        $picpath = '';
        //可传对象，远程图片，本地图片
        if(is_object($pic)){
            $fileinfo = pathinfo($pic->getPathname());            
            $this->clientoriginalname = $pic->getClientOriginalName();
            $this->filesize = $pic->getClientSize();
            $pic->move($this->ocr_excheange_dir);
            $picpath = $this->ocr_excheange_dir . $fileinfo['basename'];//移动到交换目录
        }else {
            //本地 or 远程http图片
            $fileinfo = pathinfo($pic);
            $this->clientoriginalname = $fileinfo['basename'];
            $picpath = $this->ocr_excheange_dir . $fileinfo['basename'];
            if( false !== stripos( $pic, 'https://' ) || false !== stripos( $pic, 'http://' )){
                static $dwtime = array();
                $starttime = $this->getTimestamp1();
                file_put_contents($this->ocr_excheange_dir . $fileinfo['basename'],file_get_contents($pic));
                
                $dwtime[] = $this->getTimestamp1() - $starttime;//图片本地化时间
                self::ssLog('dw_time', $dwtime);
            }else{
                $movef = new UploadedFile($pic,$this->clientoriginalname);
                $movef->move($this->ocr_excheange_dir);
            }
        }
        $ydtime[] = array('yd'=>$this->getTimestamp1() - $starttime1);//图片移动时间
        self::ssLog('yd_time', $ydtime);
        
        $starttime = $this->getTimestamp1();
        //这里ocr
        $gearOp = array("fname"=>$fileinfo['basename'],"iscut"=>$this->iscat,"language"=>$language);
        $ocr_data = array();
    //try{
        $ocr_data_result = $this->gearmanService->doNormal($this->ocr_function, $gearOp);
        //$ocr_data = array('serverip'=> 'aaa','status'=>0,'vcard'=>'{"front":{"name":[{"title_self_def":0,"input":"0","is_changed":"0","is_chinese":"1","title":"姓名","value":"李伟超","given_name":"伟超","surname":"李"}],"company":[{"job":[{"title":"职位","title_self_def":0,"value":"投资顾问","is_changed":"0","input":"0"}],"company_name":[{"title":"公司","title_self_def":0,"value":"中宣(天津)资产管理有限公司","is_changed":"0","input":"0"},{"title":"公司","title_self_def":0,"value":"Zhxua t CO n As Man set td..L men ong age njitia","is_changed":"0","input":"0"}],"address":[{"title":"地址","title_self_def":0,"value":"天津市和平区西康路赛顿中心c座28层","is_changed":"0","input":"0"}],"telephone":[{"title":"电话","title_self_def":0,"value":"02260820068","is_changed":"0","input":"0"}],"email":[{"title":"邮件","title_self_def":0,"value":"liweichao@zxzch.com.o@li1gichao@zxzch.com","is_changed":"0","input":"0"}],"web":[{"title":"网址","title_self_def":0,"value":"www.zxzch.cochwzzw.cmx","is_changed":"0","input":"0"},{"title":"网址","title_self_def":0,"value":"www.zxzch.com","is_changed":"0","input":"0"}]}],"mobile":[{"title":"手机","title_self_def":0,"is_changed":"0","input":"0","value":"873228"},{"title":"手机","title_self_def":0,"is_changed":"0","input":"0","value":"6017515"}],"email":[{"title":"邮件","title_self_def":0,"is_changed":"0","input":"0","value":"liweichao@zxzch.com.o@li1gichao@zxzch.com"}]}}');
        $ocr_data = json_decode($ocr_data_result,true);
        $picpath = $this->ocr_excheange_dir . $ocr_data['fname'];
    /*}catch (\Exception $ex) {
        throw $ex;
    }*/
        $ocrlog[] = array('t'=>$this->getTimestamp1() - $starttime ,'ip'=> $ocr_data['serverip']);
        self::ssLog('ocr_time', $ocrlog);
        
        //解析兼容数据
        $front = $this->fomart_result($ocr_data['vcard']);       
        
        
        $savef = new UploadedFile($picpath,$this->clientoriginalname);
        $data['upobject'] = $savef;
        $data['vcard'] = $front['vcard'];
        $data['markpoint'] = $front['markpoint'];
        $data['service_result'] = $ocr_data_result;
        $data['ocr_status'] = $ocr_data['status'];
        $data['status'] = $ocr_data['status'];     
        $data['filepath'] = $picpath;
        return $data;
    }
    


    /**
     * 
     * @var 1表是只旋转 ,2表是ocr全功能裁切与透视变换，
     *   
     */
    private $iscat = 2;
    
    /**
     * 设置是否裁切
     * @param number 1表是只旋转 ,2表是ocr全功能裁切与透视变换
     */
    public function setIsCat($cut) {
        
        if(intval($cut)>0) {
            $this->iscat = $cut;
        }
        
    }

    /**
     * 设置图片对像
     *
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $pic
     * @param String $key [a,b]
     */
    private function setPic(\Symfony\Component\HttpFoundation\File\UploadedFile $pic,$key='a') {
    	$fileinfo = pathinfo($pic->getPathname());
    	//$picpath = $this->ocr_excheange_dir . $fileinfo['basename'];//移动到交换目录
    	$pic->move($this->ocr_excheange_dir);//移动到交换目录
    	$this->arrayfiles[$key] = array(
    			'object' => $pic ,
    			'picpath' => $this->ocr_excheange_dir . $fileinfo['basename'],
    			'fileinfo' => $fileinfo
    	);
    }
    
    /**
     * 组装回显数据
     *
     * @param String $ocr_data_result
     * @param String $key
     * @return string
     */
    private function getReturnData($ocr_data_result, $key) {
        
    	$ocr_data = json_decode($ocr_data_result,true);
    
        $picpath = $this->ocr_excheange_dir . $ocr_data['fname'];
    	$savef = new UploadedFile($picpath,
    			$this->arrayfiles[$key]['object']->getClientOriginalName());
    	$front = $this->fomart_result($ocr_data['vcard']);
    	//组装回显数据
    
    	$data['upobject'] = $savef;
    	$data['vcard'] = $front['vcard'];
    	$data['markpoint'] = $front['markpoint'];
    	$data['service_result'] = $ocr_data_result;
    	$data['ocr_status'] = $ocr_data['status'];
    	$data['status'] = $ocr_data['status'];
    	$data['filepath'] = $picpath;
    	return $data;
    }
    
    /**
     * 正面反面一块执行ocr 时间加速一倍 ， 只接收UploadedFile对像参数
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $pic_a
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $pic_b
     * @param number $language
     * @return multitype:number unknown string \Symfony\Component\HttpFoundation\File\UploadedFile mixed Ambigous <string, String>
     */
    public function runMulti($pic_a,$pic_b,$language = 2) {
    	self::ssLog('r_1', $this->getTimestamp1());
    	if(null === $pic_a && null===$pic_b) {
    		return array();
    	}
    
    	// 移动A面
    	$result_a = '';
    	$result_b = '';
    
    	//设置回显处理
    	$this->gearmanService->getClient()->setCompleteCallback ( function (\GearmanTask $task, $type) use(&$result_a, &$result_b) {
    		switch ($type) {
    			case 'result_a' :
    				$result_a = $task->data();
    				break;
    			case 'result_b':
    				$result_b = $task->data();
    				break;
    		}
    	});
    	$picnum = 0;
    	//移动数据
    	self::ssLog('r_2', $this->getTimestamp1());
    	if(!empty($pic_a)) {
    		$picnum++;
    		$this->setPic($pic_a,'a');
    	}
    	if(!empty($pic_b)){
    		$this->setPic($pic_b,'b');
    		$picnum++;
    	}
    	self::ssLog('r_3', $this->getTimestamp1 () );
        
        self::ssLog ( 'picnum', $picnum );
        
        // 这里ocr
        
        if (! empty ( $pic_a )) {
            $params = array (
                    "fname" => $this->arrayfiles ['a'] ['fileinfo'] ['basename'],
                    "language" => $language,
                    'iscut' => $this->iscat 
            );
            $this->gearmanService->getClient ()->addTask ( $this->ocr_function, json_encode ( $params ), 'result_a' );
        }
        if (! empty ( $pic_b )) {
            $params = array (
                    "fname" => $this->arrayfiles ['b'] ['fileinfo'] ['basename'],
                    "language" => $language,
                    'iscut' => $this->iscat 
            );
            $this->gearmanService->getClient()->addTask($this->ocr_function,json_encode($params), 'result_b');
    	}
    
    
    	self::ssLog('r_4', $this->getTimestamp1());
    
    	$this->gearmanService->getClient()->runTasks();
    	self::ssLog('r_5', $this->getTimestamp1());
    
    	$data = array();
    	if(!empty($result_a)) {
    		$data['a'] = $this->getReturnData($result_a, 'a');
    	}
    	if(!empty($result_b)) {
    		$data['b'] = $this->getReturnData($result_b, 'b');
    	}
    
    	return $data;
    }

    /**
     * @todo  其他图片OCR处理,主要是返回OCR处理结果，以及获取图片类型，上传的图片经gearman（java）回调处理
     * @param  $pic_a   file  正面
     * @param  $pic_b   file  反面
     * @param  $language num  gearman处理语言1,2
     * @author ...
     * @version 2017-7-20
     * @return array()  
     */
    public function runOcrForOtherPic($pic_a,$pic_b,$language = 2,$userid) {
        self::ssLog('r_1', $this->getTimestamp1());
        if(null === $pic_a && null===$pic_b) {
            return array();
        }
        // 移动A面
        $result_a = '';
        $result_b = '';
    
        //设置回显处理
        $this->gearmanService->getClient()->setCompleteCallback ( function (\GearmanTask $task, $type) use(&$result_a, &$result_b) {
            switch ($type) {
                case 'result_a' :
                    $result_a = $task->data();
                    break;
                case 'result_b':
                    $result_b = $task->data();
                    break;
            }
        });
        $picnum = 0;
        //移动数据
        self::ssLog('r_2', $this->getTimestamp1());
        if(!empty($pic_a)) {
            $picnum++;
            $this->setPic($pic_a,'a');
        }
        if(!empty($pic_b)){
            $this->setPic($pic_b,'b');
            $picnum++;
        }
        self::ssLog('r_3', $this->getTimestamp1 () );
        
        self::ssLog ( 'picnum', $picnum );
        
        // 这里ocr
        
        if (! empty ( $pic_a )) {
            $params = array (
                    "fname"    => $this->arrayfiles ['a'] ['fileinfo'] ['basename'],
                    "language" => $language,
                    'iscut'    => $this->iscat,
                    'userid'   => $userid
            );
            $this->gearmanService->getClient ()->addTask ( 'Scan_function', json_encode ( $params ), 'result_a' );
        }
        if (! empty ( $pic_b )) {
            $params = array (
                    "fname"    => $this->arrayfiles ['b'] ['fileinfo'] ['basename'],
                    "language" => $language,
                    'iscut'    => $this->iscat,
                    'userid'   => $userid
            );
            $this->gearmanService->getClient()->addTask('Scan_function',json_encode($params), 'result_b');
        }
        self::ssLog('r_4', $this->getTimestamp1());
    
        $this->gearmanService->getClient()->runTasks();
        self::ssLog('r_5', $this->getTimestamp1());
    
        $data = array();
        if(!empty($result_a)) {
            $data['a'] = $this->handleOrcResult($result_a, 'a');
            self::ssLog('r_a', $result_a);
        }
        if(!empty($result_b)) {
            $data['b'] = $this->handleOrcResult($result_b, 'b');
            self::ssLog('r_b', $result_b);
        }
        $data = $this->handleData($data);
        return $data;
    }

    /**
     * @todo  处理OCR返回结果，主要是vcard
     * @param json    $result  OCR返回的结果
     * @param string  $type : a|b  区分正面或者背面
     * @version 2017-7-25 
     * @return array()  
     */ 
    private function handleOrcResult($result,$key)
    {
        $return  = array();
        // 解析OCR结果
        $res_arr = json_decode($result,true);
        if (empty($res_arr)) {
            return $return;
        }
        // OCR解析结果：0：成功 0< :失败
        $ocr_status = isset($res_arr['ocr_status'])?$res_arr['ocr_status']:1;
        $vcard      = isset($res_arr['vcard'])?$res_arr['vcard']:'';
        $savef      = '';
        $file       = '';
        $type       = 0;
        $tag        = '';
        $content    = '';
        if (!empty($vcard)) {
            $vcard    = str_replace("\r\n", " ", $vcard); //去掉\r\n 有json无法解析
            $vcardArr = json_decode($vcard,true);
            $classification = isset($vcardArr['classification'])?$vcardArr['classification']:'';
            $scan     = isset($classification['scan'])?$classification['scan']:'';
            $o_type   = isset($scan['type'])?$scan['type']:'';
            $type     = isset($o_type['tag'])?$o_type['tag']:'';
            $tag      = isset($o_type['classify_result'])?$o_type['classify_result']:'';
            $ocr_con  = isset($scan['content'])?$scan['content']:'';
            $content  = isset($ocr_con['ocr_result'])?$ocr_con['ocr_result']:'';
        }
        if (isset($res_arr['fname']) && !empty($res_arr['fname'])) {
            $picpath = $this->ocr_excheange_dir . $res_arr['fname'];
            $savef = new UploadedFile($picpath,$this->arrayfiles[$key]['object']->getClientOriginalName());   
        }
        $return = array(
            'status' => $ocr_status,
            'vcard'  => $vcard,
            'pathobj'=> $savef,
            'type'   => $type,
            'tag'    => $tag,
            'content'=> $content,
            'path'   => $picpath,
        );
        return $return;
    }

    /**
     * @todo 处理data，status统一返回，vcard统一返回json，files，type，tag
     * @return array();
     * @return type  : 取正面type，如果为空取b面
     * @return tag   : 取正面tag，如果为空取b面
     * @return status: -2：a不成功b不成功，-1：a不成功b不存在，0：a成功b成功或不存在，1：a成功b不成功，2：a不成功b成功
     * @return vcard : ab集合(json)
     * @return files : ab数组
     */
    private function handleData($data)
    {
        $result = array();
        $type = $data['a']['type'];
        $tag  = $data['a']['tag'];
        $vcard = array(
            'a' => empty($data['a']['vcard'])?"":json_decode($data['a']['vcard'],true),
        );
        $files = array(
            'a' => array(
                'obj' => $data['a']['pathobj'],
                'path'=> $data['a']['path'],
            ),
        );
        $status = 0;
        // 如果反面存在
        $status_a = $data['a']['status'];
        if (isset($data['b'])) {
            $type = empty($type)?$data['b']['type']:$type;
            if (13 == $tag && !empty($data['b']['tag'])) {
                $tag = $data['b']['tag'];
            }
            $tag  = empty($tag)?$data['b']['tag']:$tag;
            $vcard['b'] = json_decode($data['b']['vcard'],true);
            $files['b'] = array(
                'obj' => $data['b']['pathobj'],
                'path'=> $data['b']['path'],
            );
            
            $status_b = $data['b']['status'];
            // 都不成功-2
            if (0 != $status_a && 0!= $status_b) {
                $status = -2;
            } else if (0 == $status_a && 0 == $status_b) {
                $status = 0;
            } else if (0 == $status_a && 0 != $status_b ) {
                $status = 1;
            } else if (0 != $status_a && 0 == $status_b) {
                $status = 2;
            }
        }else{
            if (0 != $status_a) {
                $status = -1;
            }
        }
        $vcard  = empty($vcard)?'':json_encode($vcard,JSON_UNESCAPED_UNICODE);
        $result = array(
            'type'   => $type,
            'tag'    => $tag,
            'vcard'  => $vcard,
            'files'  => $files,
            'status' => $status 
        );
        return $result;
    }
}