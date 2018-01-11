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
 * @date-add: 2017-2-23 
 * @date-edi: 2017-2-28:2017-3-9
 * @note:Bizwork下可以处理多个work
 * @version 1.0.2
 */
class CardWork extends Work
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
     * 名片公司信息解析
     * @date 2017-6-13 
     * @param $jsondata : json
     * @param $type: 类型：'name' 公司名称  
     * @param $name: 公司名称
     * @return true 
     * @author xgm
     * @version 1.0.2 2017-3-9
     */
    public function taskRun($data){
        $data = json_decode($data,TRUE);
        if (empty($data)) {
            return false;
        }
        $type = isset($data['type'])?$data['type']:'name';

        switch ($type) {
            case 'name':
                return $this->_analysCustomer($data);  //解析公司详情
                break;
            default:
                return FALSE;
                break;
        }
    }
    /**
     * 处理员工导入数据
     * @param $data array();
     */
    public function _analysCustomer($data)
    {
        $name = isset($data['name'])?$data['name']:'';//公司名称
        if (empty($name)) 
            return FALSE;
        $service = $this->container->get('account_emp_service');
        $res        = $service->getCompanyCustomer($name);
        if (empty($res)) {
            return FALSE;
        }
        return $res;
    }
}