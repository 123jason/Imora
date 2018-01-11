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
/**
 * Gearman workclass 
 * example : F execute 为工作方法，executeTest 为window下测试方法：测试代码是否执行
 * @date-add: 2017-10-18
 * @note:Bizwork下可以处理多个work
 * @version 1.0.2
 */
class CardSyncWork extends Work
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

    /**
     * 名片批量同步
     * @date 2017-10-18
     * @param $jsondata : json
     * @param $batchid: 微信名片表批次号
     * @param $name: 公司名称
     * @return true 
     * @author xgm
     * @version 1.0.2
     */
    public function taskRun($data){
        $data = json_decode($data,TRUE);
        if (empty($data)) {
            return false;
        }
        return $this->_syncWxCardToBiz($data);
    }

    /**
     * 微信名片导入到企业名片表
     * @param $data array();
     */
    public function _syncWxCardToBiz($data)
    {
        $batchid = $this->strip_tags($data['batchid']);
        $bizid   = $this->strip_tags($data['bizid']);
        $userid  = intval($data['userid']);
        if (empty($batchid) || empty($bizid) || !$userid) {
            return false;
        }
        $param = array('batchid'=>$batchid, 'bizid'=>$bizid, 'userid'=>$userid);
        //$wxBizService = $this->container->get('wx_biz_service');
        $wxBizService = $this->container->get('common_service');
        $result = $wxBizService->syncBatchCardFromWxToBiz($param);
        return TRUE;
    }
}