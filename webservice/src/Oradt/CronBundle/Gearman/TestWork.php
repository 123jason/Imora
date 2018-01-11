<?php
use Oradt\CronBundle\Core\Cron;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Oradt\CronBundle\Gearman\Work;
/**
 * Gearman workclass 
 * example : F execute 为工作方法，executeTest 为window下测试方法：测试代码是否执行
 * @date 2017-2-23 
 * @vertion 1.0.1
 */
class TestWork extends Work
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
	
	

	public function taskRun($data)
	{
	    echo __FILE__;
		///var_dump($this->getConnection());
		var_dump(json_decode($data));
        return true;
	}
}
/*
 * 
 * $sql = "SELECT id FROM account_biz_import_emp WHERE status = 1 LIMIT 300";
        $res = $this->getConnection()->executeQuery($sql)->fetchAll();
        if ($res) {
        	foreach ($res as $val) {
        		$sql_up = "UPDATE account_biz_import_emp SET status = 2 WHERE id = ".$val['id'];
        		$this->getConnection()->executeQuery($sql_up);
        	}
        }
        echo "hello php !";
        
        *$sql = "SELECT id FROM account_biz_import_emp WHERE status = 1 LIMIT 300";
        $res = $this->getConnection()->executeQuery($sql)->fetchAll();
        if ($res) {
        	foreach ($res as $val) {
        		$sql_up = "UPDATE account_biz_import_emp SET status = 2 WHERE id = ".$val['id'];
        		$this->getConnection()->executeQuery($sql_up);
        	}
        }
        */