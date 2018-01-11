<?php
use Oradt\CronBundle\Gearman\Work;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\Utils\BaseTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\Utils\RandomString;
use Oradt\Utils\Str2PY;
use Oradt\ServiceBundle\Services\CurlService;

use Symfony\Component\HttpFoundation\Response;

/**
 * Gearman workclass 
 * example : F execute 为工作方法，executeTest 为window下测试方法：测试代码是否执行
 * @date-add: 2017-10-18
 * @note: 下载EXCEL
 * @version 1.0.2
 */
class WechatDownExcelCardWork extends Work
{
    public $work;
    public $job;
    public $log;
    public $str;
    public $arr;
    public $res;

    public function __construct(ContainerInterface $container)
	{
		parent::__construct($container);
	}

  
    public function taskRun($data){
        $data = json_decode($data,TRUE);
        if (empty($data)) {
            return false;
        }
        return $this->_syncDownExcelCard($data);
    }

    /**
     *  名片批量导出
     * @param $data array();
     */
   public function _syncDownExcelCard($data)
    { 
        $content  = $this->strip_tags($data['content']); 
        $fromsend = $this->strip_tags($data['fromsend']); 
        $title = $this->strip_tags($data['title']);
        //$enclosure = $request->files->get('enclosure');
        $sendurl =  $this->strip_tags($data['sendurl']);
        $wechatid =  $this->strip_tags($data['wechatid']);
        $enclosureName = $this->strip_tags($data['enclosurename']);
        $batchid = $this->strip_tags($data['batchid']); 
        $messageid = $this->strip_tags($data['messageid']);
        
        $weixin_card_service = $this->container->get('wechat_service');
        
        $is_test="0";
        
        $weixin_card_service->update_send_message_log($messageid,null,2);//程序已经调起work
        
        $filename = date('YmdHis') . '.xlsx';
        $where["wechatid"]=$wechatid;
        $where["batchid"]=$batchid;
        $key=$this->down($filename,$where,$is_test);
        
       /*  //////////////////////////
        $weixin_card_service = $this->container->get('wechat_service');
        $weixin_card_count=$weixin_card_service->get_weixin_card_count_by_wechat_id($where["wechatid"],$where["batchid"]);
        
        $pageSize=10000;
        $all_num=ceil($weixin_card_count/$pageSize);
        $limit=0;
        for ($num=0;$num<$all_num;$num++){
            $filename = $wechatid."-".$num. date('YmdHis') . '.xls';
            $weixin_card_data=$weixin_card_service->get_weixin_card_by_wechat_id($where["wechatid"],$where["batchid"],$limit,$pageSize);
            $this->excel($weixin_card_data["header"],$weixin_card_data["data"],$filename);
            $limit=($num+1)*$pageSize;
        }
        ////////////////////////// */
         
        $weixin_card_service->update_send_message_log($messageid,null,3);//程序excel运行完成
        
        $aws_file_url="";
        //if($is_test==0){
            $sourceFile = "wxmail/" . $filename;
            $dirs_upload = $this->container->get('aws_service'); 
            $aws_file_url=$dirs_upload->createFile($sourceFile ,$key); 
            @unlink ($key);//删除文件 
        //}
       
        if(empty($enclosureName)) $enclosureName=$filename;
        $param =array(
            ':enclosure'=>$aws_file_url,
            ':sendname'=>$fromsend,
            ':content'=>$content,
            ':title'=>$title,
            ':createtime'=>$this->getTimestamp(),
            ':mail' => $sendurl,
            ':wechatid'=>$wechatid
        );  
        
        
        $weixin_card_service->insert_send_message($param,$enclosureName);
        $weixin_card_service->update_send_message_log($messageid,$param,0);
         
        return true; 
    }
    
    public function down($filename,$where,$is_test=0){
        ini_set ('memory_limit', '1024M');
        set_time_limit(0);
        require_once __DIR__.'/../../../../vendor/phpexcel/Classes/PHPExcel.php';
        
        /* $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array( 'memoryCacheSize' => '1024MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings); */
        
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Me")
        ->setLastModifiedBy("Me")
        ->setTitle("wechat excel card")
        ->setSubject("Document");
        
        $weixin_card_service = $this->container->get('wechat_service');
        $weixin_card_count=$weixin_card_service->get_weixin_card_count_by_wechat_id($where["wechatid"],$where["batchid"]);
 
        //if($weixin_card_count>10000){
           $pageSize=10000;
           $all_num=ceil($weixin_card_count/$pageSize); 
           $limit=0;
           for ($num=0;$num<$all_num;$num++){ 
               $weixin_card_data=$weixin_card_service->get_weixin_card_by_wechat_id($where["wechatid"],$where["batchid"],$limit,$pageSize);
               $this->makeData($objPHPExcel,$num,"sheet".$num,$weixin_card_data["header"],$weixin_card_data["data"]);
               unset($weixin_card_data);
               $limit=($num+1)*$pageSize;
           }
        //}
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if($is_test==0)
            $root_dir=$this->container->getParameter('DOC_ROOT');
        else
            $root_dir='d:/excel/';
        $objWriter->save($root_dir.$filename);
        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);
        return  $root_dir.$filename;
    }
    
    /*
     * 封装
     * @ $objPHPExcel   phpexcel 对象
     * @ $num  int       第n个工作空间
     * @ $sheet_title    工作空间sheet名称
     * @ param string   $A1_title 大标题
     * @ param array    $A2_title 每个字段名
     * @ where sting or array 查询的条件
     * @ return true or false;
     */
    protected  function makeData($objPHPExcel,$num,$sheet_title,$header,$data){
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($num); 
        //设置单元格宽
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
       
       
        $startColAscii = ord('A'); //
        $colPos = 0;
        $rowPos = 1;
 
        foreach ($header as $_v) {
            $cellName = chr($startColAscii+$colPos).$rowPos;
            $objPHPExcel->getactivesheet()->setCellValue($cellName, $_v);
            $colPos++;
        }
         
        $keys = array_keys($header);
        foreach ($data as $_stat) {
            $rowPos++;
            foreach ($keys as $_pos=>$_v) {
               $cellName = chr($startColAscii+$_pos).$rowPos;
               $_v = isset($_stat[$_v]) ? $_stat[$_v] : '';
               $objPHPExcel->getactivesheet()->setCellValue($cellName, $_v.' ');
                //$workSheet->getColumnDimension($cellName)->setAutoSize(true);
                //$workSheet->getDefaultColumnDimension($cellName)->setWidth(30);
              }
       } 
       unset($header);
       unset($data);
       //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objPHPExcel->getActiveSheet()->setTitle($sheet_title);
        return true;
    }
  
    
}