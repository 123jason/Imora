<?php
namespace Oradt\ServiceBundle\Services;
use Oradt\StoreBundle\Entity\AccountEmployeeLoginRecord;
use Oradt\StoreBundle\Entity\AuthorityPermission;
use Oradt\StoreBundle\Entity\AuthorityAction;
use Oradt\StoreBundle\Entity\AccountEmployee;
use Oradt\StoreBundle\Entity\AuthorityRole;
use Oradt\StoreBundle\Entity\SysCardTemplate;

class OrangeAdminService extends BaseService
{
    
    public $em = null;
    
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }
    
    //更新卡类型时同步更新会员卡搜索条件
    public function asyUpdateTempSearching($cardTypeId){
    	//获取卡类型的策略
    	$sql = "SELECT searchingkwd FROM `orange_card_type` WHERE `id`=:id";
    	$cardData = $this->getConnection()->fetchAll($sql,array(':id'=>$cardTypeId));
    	$strategy = !empty($cardData[0]['searchingkwd'])?json_decode($cardData[0]['searchingkwd'],true):'';
    	 
    	$sql = "SELECT id,searchedkwd,card_type FROM `orange_membership_card` WHERE `card_type`=:card_type";
    	$tplList = $this->getConnection()->fetchAll($sql,array(':card_type'=>$cardTypeId));
    	
    	$strategyOther = $strategyReplace = array();
    	if($strategy){
    		//去掉行为规则，只保留动态要替换的和固定的数据
    		foreach ($strategy as $value) {
    			//新增卡类型与标签类型全选的关系,替换分类
    			if('tag' == $value['froms']){
    				if($cardTypeId == $value['cardtypeid'] && count($value['w']) == 0){//要替换的
    					$strategyReplace[$value['tagtypeid']] = $value;
    				}else if(count($value['w']) > 0){//静态数据
    					foreach ($value['w'] as $stable){
    						$strategyOther[] = array('value'=>$stable['name'],'type'=>$value['type'],'sort'=>$stable['sort']);
    					}
    	
    				}
    			}
    		}
    	}
    	
    	if(!$tplList){
    		return true;
    	}else{
    		foreach ($tplList as $tpl){
    			$tplData = array(); //存储模板卡中被搜索的条件
    			$searchedkwd = $tpl['searchedkwd']?json_decode($tpl['searchedkwd'], true):array();
    			if($searchedkwd){
    				foreach ($searchedkwd as $k=>$v){
    					if($v['type'] == 'cardtype'){
    						unset($searchedkwd[$k]);
    						continue;
    					}
    					$tplData[$v['tagtypeid']][] = $v;
    				}
    			}else{
    				$tplData = array(); //被搜索条件为空的模板
    			}    	
    			$this->asyUpdateTempSearchingOne($strategy,$tpl['id'],$tplData,$strategyOther,$strategyReplace); //更新模板中的数据
    			$this->updateNonUserTag($tpl['id']);
    		}
    	}    	
    }
    
    //更新卡类型时没有会员卡模板时异步更新orange_nonuser_tag搜索条件
    public function asyUpdateNoTempSearching($cardTypeId){
    	//获取卡类型的策略
//    	$sql = "SELECT searchingkwd FROM `orange_card_type` WHERE `id`=:id";
//    	$cardData = $this->getConnection()->fetchAll($sql,array(':id'=>$cardTypeId));
        
        $searchingkwd = $this->getCardTypeSearchingkwdSort($cardTypeId);
        
    	$strategy = !empty($searchingkwd) ? $searchingkwd : '';
       
        $time = $this->getTimestamp();
        if($cardTypeId == 9){
            $sql = "SELECT cardid as id ,searchingkwd FROM `orange_nonuser_tag` WHERE `module`=:module ";
            $fcList = $this->getConnection()->fetchAll($sql,array(':module'=>$cardTypeId));
            if(!empty($fcList)){
                foreach ($fcList as $val){
                    $flight = array();
                    $strategyn = json_decode($strategy,true);
                    $strategyold = $this->getFlightSearchingkwd($val['id']);
                    if(!empty($strategyold)){
                        $flight[0]['value'] = $strategyold['FlightCompany'];
                        $flight[0]['type'] = '发卡单位';
                    }
                    if(!empty($strategyn) && !empty($flight) ){
                        $strategyn = array_merge($flight,$strategyn);
                    }
                    $strategyn = json_encode($strategyn);

                    $sql = "UPDATE `orange_nonuser_tag` SET searchingkwd=:searchingkwd, tag_modify_time=:tag_modify_time WHERE `tempid` = 0 and `cardid` = {$val['id']}";
                    $res = $this->getConnection()->executeUpdate($sql,array(':searchingkwd'=>$strategyn,':tag_modify_time'=>$time));
                }
            }else{
                $res = 0;
            }
            return $res;
        } else {
            $sql = "SELECT id FROM `orange_func_card` WHERE `module`=:module and `temp_id` = 0";
            $fcList = $this->getConnection()->fetchAll($sql,array(':module'=>$cardTypeId));
        }
        if(!empty($fcList)){
            $cardidins = $this->i_array_column($fcList,'id');
            $cardidins = implode(',', $cardidins);
            
            $sql = "UPDATE `orange_nonuser_tag` SET searchingkwd=:searchingkwd, tag_modify_time=:tag_modify_time WHERE `tempid` = 0 and `cardid` in ({$cardidins})";
            $res = $this->getConnection()->executeUpdate($sql,array(':searchingkwd'=>$strategy,':tag_modify_time'=>$time));
        } else {
            $res = 0;
        }
        return $res;
    }
    /**
    * 获取行程卡航班搜索关键字
    */
    public function getFlightSearchingkwd($id){
        $sql = "SELECT f.FlightCompany FROM  orange_flight_custom_user as fcu left join orange_flight as f on fcu.fid = f.id WHERE fcu.id=:id";
        $res = $this->getConnection()->executeQuery($sql,array(":id"=>$id))->fetch();
        return $res;
    }
    
    /**
     * 异步更新模板中搜索条件
     * @param unknown $id
     */
    public function asyUpdateTempSearchingOne($strategy,$tplId,$tplData,$strategyOther,$strategyReplace){
    	//从模板searchedkwd中找出动态的数据
    	$tplDataNew = array();
    	if($strategyReplace){
    		foreach ($strategyReplace as $replace){
    			if(!isset($tplData[$replace['tagtypeid']])){
   					 continue;
    			}
    			$searchedMayUsed = $tplData[$replace['tagtypeid']];
    			foreach ($searchedMayUsed as $used){
    				$tplDataNew[]  = array('value'=>$used['value'],'type'=>$used['type'],'sort'=>$replace['sort']);
    			}
    		}
    	}
    	
    	//关于城市的替换为 *
    	$tplDataSearching = array();
    		$tmpVal = array_merge($strategyOther, $tplDataNew);
    		if($tmpVal){
    			$tmpVal = $this->_arrSort($tmpVal);
    			$setCity = false;
    			foreach ($tmpVal as $k=>$v){
    				if($v['type'] == '城市' && $setCity===false){
    					$tplDataSearching[$k] = array('value'=>'*','type'=>$v['type']);
    					$setCity = true;
    				}else{
    					$tplDataSearching[$k] = $v;
    				}    				
    			}
    		}else{
    			$tplDataSearching = $tmpVal;
    		}
    	$obj = '';
    	$time = $this->getTimestamp();
    	if($tplDataSearching){//把组装好的搜索条件更新到模板中搜索条件字段
    		$tplDataSearching = $this->_delArrProp($tplDataSearching);
    		if(!empty($tplDataSearching)){
    			$obj = json_encode($tplDataSearching);
    		}
    	}    
    	$sql = "UPDATE `orange_membership_card` SET searchingkwd=:searchingkwd,tag_modify_time=:time WHERE `id`=:id";
    	$this->getConnection()->executeUpdate($sql,array(':id'=>$tplId,':searchingkwd'=>$obj,'time'=>$time));
    }
    //删除数组中的属性
    private function _delArrProp($tplDataSearching){
    	if($tplDataSearching){
    		foreach ($tplDataSearching as $k=>$v){
    			$tplDataSearching[$k] = array('value'=>$v['value'],'type'=>$v['type']);
    		}
    	}
    	return $tplDataSearching;
    }
    
    //对二维数组进行排序
    private function _arrSort($oneLayer){
    	$myselfSort = array(); //自定义排序数组
    	foreach($oneLayer as $k=>$layer){
    		$myselfSort[] = $layer['sort'];
     	}
    	array_multisort($myselfSort,SORT_ASC,SORT_NUMERIC,$oneLayer);
    	return  $oneLayer;
    }
    
    /**
     * 更新功能卡搜索条件和被搜索条件
     * @param unknown $tempId
     */
    public function updateNonUserTag($tempId){
    	if(!$tempId){
    		return false;
    	}
    	$sql = "SELECT id,searchedkwd,searchingkwd FROM `orange_membership_card` WHERE `id`=:id";
    	$tplList = $this->getConnection()->fetchAll($sql,array(':id'=>$tempId));
    	
    	$tempsql = "SELECT id FROM  orange_nonuser_tag  WHERE tempid=:tempid LIMIT 0,1";
    	$result = $this->getConnection()->executeQuery($tempsql,array(":tempid"=>$tempId))->fetch();
    	if(!empty($result)) {
    		$tplData = isset($tplList)?$tplList[0]:'';
    		$searchedkwd = $tplData?$tplData['searchedkwd']:'';
    		$searchingkwd = $tplData?$tplData['searchingkwd']:'';
    		$searchedkwd==null && $searchedkwd = '';
    		$searchingkwd==null && $searchingkwd = '';
    		$time = $this->getTimestamp();
    		$param = array(':tempid'=>$tempId,':searchedkwd'=>$searchedkwd,':searchingkwd'=>$searchingkwd,':time'=>$time);
    		$sql = "UPDATE orange_nonuser_tag SET searchedkwd=:searchedkwd,searchingkwd=:searchingkwd,tag_modify_time=:time WHERE tempid=:tempid";
    		$this->getConnection()->executeUpdate($sql,$param);
    	}
    }
    
    /**
     * 删除卡类型中使用到的标签类型或标签
     */
    public function delCardTypeTagProp($idType,$id){
    	if($idType == 'tag'){
    		$sql = "DELETE FROM `orange_card_strategy_relation` WHERE  fromid =:id AND froms='tag'";
    	}else if($idType == 'tagtype'){
    		$sql = "DELETE FROM `orange_card_tag_type` WHERE tag_type_id=:id ";
    	}else{
    		return false;
    	}
    	$param = array(':id'=>$id);
    	$this->getConnection()->executeUpdate($sql,$param);
    	return true;
    }
    
    /**
     * 根据卡类型获取搜索条件(处理后的二维数组)
     * param $cardTypeId 卡类型id
     */
    public function getCardTypeSearchingkwdSort($cardTypeId){
    	if(!$cardTypeId){
    		return '';
    	}
    	//获取卡类型的策略
    	$sql = "SELECT searchingkwd FROM `orange_card_type` WHERE `id`=:id";
    	$cardData = $this->getConnection()->fetchAll($sql,array(':id'=>$cardTypeId));
    	$strategy = !empty($cardData[0]['searchingkwd'])?json_decode($cardData[0]['searchingkwd'],true):'';
    	 
    	$strategyOther = array();
    	if($strategy){
    		//去掉行为规则，只保留动态要替换的和固定的数据
    		foreach ($strategy as $value) {
    			//新增卡类型与标签类型全选的关系,替换分类
    			if('tag' == $value['froms']){
    				if($cardTypeId == $value['cardtypeid'] && count($value['w']) == 0){//要替换的
    				}else if(count($value['w']) > 0){//静态数据
    					foreach ($value['w'] as $stable){
    						$strategyOther[] = array('value'=>$stable['name'],'type'=>$value['type'],'sort'=>$stable['sort']);
    					}
    
    				}
    			}
    		}
    	}
    	 
    	if($strategyOther){
    		$strategyOther = $this->_arrSort($strategyOther);
    		$setCity = false;
    		foreach ($strategyOther as $k=>$v){
    			if($v['type'] == '城市' && $setCity===false){
    				$tplDataSearching[$k] = array('value'=>'*','type'=>$v['type']);
    				$setCity = true;
    			}else{
    				$tplDataSearching[$k] = $v;
    			}
    		}
    	}else{
    		$tplDataSearching = $strategyOther;
    	}
    	 
    	$tplDataSearching = $this->_delArrProp($tplDataSearching);
    	$obj = '';
    	if(!empty($tplDataSearching)){
    		$obj = json_encode($tplDataSearching);
    	}
    	return $obj;
    }
    
    
    /**
     * 根据卡类型id和发卡单位id获取模板id
     * @param unknown $cardTypeId
     * @param unknown $unitsId
     */
    public function getCardUnitsIndex($cardTypeId,$unitsId){
    	$sql = "SELECT max(card_type_units_number) maxNum FROM `orange_membership_card` WHERE `card_type`=:card_type AND card_units=:card_units";
    	$cardData = $this->getConnection()->fetchAll($sql,array(':card_type'=>$cardTypeId,':card_units'=>$unitsId));
    	$maxNum = 1;
    	if(!$cardData){
    		//$this->setCardUnitsIndex($cardTypeId,$unitsId,$maxNum);
    	}else{
    		$maxNum = $cardData[0]['maxNum']+1;
    		//$this->setCardUnitsIndex($cardTypeId,$unitsId,$maxNum);
    	}
    	$tempNum = str_pad($cardTypeId,2,'0',STR_PAD_LEFT).str_pad($unitsId,4,'0',STR_PAD_LEFT).str_pad($maxNum,4,'0',STR_PAD_LEFT);
    	return array('maxNum'=>$maxNum,'tempNum'=>$tempNum);
    }
    
    /**
     *  根据卡类型id和发卡单位id更新模板序号
     * @param unknown $currIndex
     */
    public function setCardUnitsIndex($cardTypeId,$unitsId,$maxNum){
    	$sql = "UPDATE `orange_membership_card` SET card_type_units_number=:card_type_units_number WHERE `card_type`=:card_type AND card_units=:card_units"; 
    	return $this->getConnection()->executeUpdate($sql, array(':card_type'=>$cardTypeId,':card_units'=>$unitsId,':card_type_units_number'=>$maxNum)); 
    }
    
    /**
     * 
     */
    public function updateCardtempids($id,$tempid)
    {
        $sql = "SELECT card_type,card_name FROM orange_non_temp_card WHERE id = :id ";
        $res = $this->getConnection()->executeQuery($sql,array(":id"=>$id))->fetch();
        if (empty($res)) {
            return false;
        }
        $type = isset($res['card_type'])?$res['card_type']:'';
        $name = isset($res['card_name'])?$res['card_name']:'';
        if (empty($type) || empty($name) ) {
            return false;
        }
        $sql2 = "SELECT id,module,user_id as userid FROM  orange_func_card WHERE module=:type AND card_name =:name AND temp_id = 0";
        $res2 = $this->getConnection()->fetchAll($sql2,array(':type'=>$type,':name'=>$name));
        if (empty($res2)) {
            return false;
        }
        
        return $res2;
    }

    /**
     * 发送功能卡kafka消息
     * @param array $kdata 消息内容 
     * @return boolean
     * @note : funcCardWork 使用
     */
    public function kafkaFuncCard( $kdata = array() ){
        return true;
        $ifkafka = true; //不开启kafka，设为true表示开启
        $kafkaFuncCard = "";
        if($ifkafka){
            $kafkaService = $this->container->get('kafka_service');
            if($this->container->hasParameter('kafka_funccard')){
                $kafkaFuncCard = $this->container->getParameter('kafka_funccard');
            }
        }
        
        if(true === $ifkafka && !empty($kdata) && !empty($kafkaFuncCard) && $kafkaService->isActive()) {
            $cardData = json_encode($kdata);
            $kafkaService->sendKafkaMessage( $kafkaFuncCard, $cardData );    
            $kafkaService->disConnect();
        }
        return true;
    }

    /**
     * 保存角色信息
     * @param AuthorityRole $role
     * @return AuthorityRole
     */
    /* public function saveRole(AuthorityRole $role)
    {
       // exit('aaa');
        $this->em->persist($role);
        $this->em->flush();
        return $role;
    } */
    /**
     * 根据ID获取角色
     * @param number $id
     * @return AuthorityRole
     */
    /* public function getRoleById($id)
    {
        return $this->em->getRepository('OradtStoreBundle:AuthorityRole')
                ->findOneBy(array('roleId'=>$id));
    } */
    
    /**
     * 查找角色
     * @param unknown $array
     * @return 
     */
    /* public function findRole($array)
    {
        //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:AuthorityRole');
        
        $list = $repository->findBy($array);
        
        return $list;
    } */
    
    /**
     * 删除角色
     * @param number $id
     * @return boolean
     */
   /*  public function deleteRole($id)
    {
        $role = $this->getRoleById($id);
        if (!empty($role)) {
            $this->em->remove($role);
            $this->em->flush();
            return true;
        }
        return false;
    } */
    
    /**
     * 写入管理员账户信息
     * @param AccountEmployee $employee
     * @return AccountEmployee
     */
   /*  public function saveEmployee(AccountEmployee $employee)
    {
      
        $this->em->persist($employee);
        $this->em->flush();        
        return $employee;
    } */
    
   
    
    /**
     * 删除管理员账号
     * @param number $id
     * @return boolean true 删除成功 false 删除失败
     */
   /*  public function deleteEmployee($id)
    {
        $employee = $this->getEmployeeById($id);         
        if (!empty($employee)) {
            $this->em->remove($employee);
            $this->em->flush();
            return true;
        }        
        return false;
    } */
    
    /**
     * 根据ID获取管理员账号信息
     * @param string $id
     * @return AccountEmployee|NULL
     */
    /* public function getEmployeeById($id)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
            ->findOneBy(array('emplId'=>$id));
        return $employee;
    }
    
    public function findEmployee($array)
    {
        //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:AccountEmployee');
        
        $list = $repository->findBy($array);
        
        return $list;
    } */
    
    
    /**
     * 管理员登陆
     * @param string $account
     * @param string $passwd
     * @param number $type 0|1 0为邮箱，1为手机号
     * @return array|False  False表示登陆失败
     */
   /*  public function adminLogin($account,$passwd,$ip,$type=0){
        $repository = $this->em->getRepository('OradtStoreBundle:AccountEmployee');
        
        $findArray = array();
        
        if ($type==0) {
            $findArray['email'] = $account;
        }
        else{
            $findArray['mobile'] = $account;
        }
        
        $findArray['password'] = $passwd;
        
        $admin = $repository->findOneBy($findArray);
        if(empty($admin))
            return False;
        
        $data = array(
                'adminid' => $admin->getId(),
                'email'   => $admin->getEmail(),
                'realname' => $admin->getRealName(),
       //         'lastname'  => $admin->getLastName(),
                'mobile'    => $admin->getMobile(),
                'roleid'          => $admin->getRoleId()
        );
        //更新最后登陆信息
        $emplId = $admin->getEmplId();
        $this->addAdminLoginLog($emplId, $ip);
        
        return $data;
    }
     */
    
    /**
     * 添加授权
     * @param number $actionId
     * @param number $roleId
     * @return number
     */
  /*   public function addPermission($actionId,$roleId)
    {
        $authorPermission = new AuthorityPermission();
        $authorPermission->setActionId($actionId);
        $authorPermission->setRoleId($roleId);
        $this->em->persist($authorPermission);
        $this->em->flush();
        return $authorPermission->getId();
    }
     */
    /**
     * 
     * @param string $name
     * @param number $module_id
     * @return number
     */
    /* public function addAction($name,$moduleId)
    {
        
        $authorAction = new AuthorityAction();
        $authorAction->setName($name);
        $authorAction->setModuleId($moduleId);
        $this->em->persist($authorAction);
        $this->em->flush();
        return $authorAction->getId();
    } */
    
    /**
     * 管理员登陆日志
     * @param string $emplId
     * @param string $lastLoginIp
     * @return void
     */
   /*  public function addAdminLoginLog($emplId,$lastLoginIp)
    {
       
        $emplyeeLoginLog =$this->em->getRepository('OradtStoreBundle:AccountEmployeeLoginRecord')
            ->findOneBy(array('emplId' => $emplId));
        //如果第一次登陆，需要再实例化一次
        if(empty($emplyeeLoginLog)) {
            $emplyeeLoginLog = new AccountEmployeeLoginRecord();
            $emplyeeLoginLog->setEmplId($emplId);                    
        }
        //更新登陆IP 时间
        $loginDate=new  \DateTime(strtotime(time()));        
        $emplyeeLoginLog->setLastLoginIp($lastLoginIp);
        $emplyeeLoginLog->setLastLoginTime($loginDate);       
        $this->em->persist($emplyeeLoginLog);        
        $this->em->flush();
    }
 */
    /**
     * 检查公司是否添加过管理员
     * @param string $emplId 公司ID
     * @return boolean
     */
   /*  public function checkEmplidExists($emplId)
    {
        $employee = $this->em->getRepository('OradtStoreBundle:AccountEmployee')
            ->findOneBy(array('emplId'=>$emplId));
        if(empty($employee))
            return false;
        
        return true;
    } */
    

    /**
     * 保存系统名片模版
     * @param SysCardTemplate $template
     * @return SysCardTemplate
     */
    /* public function saveSysCardTemplate(SysCardTemplate $template)
    {
        $this->em->persist($template);
        $this->em->flush();
        return $template;
    }
    
    public function findSysCardTemplate($findArray)
    {   //查询多条数据
        $repository = $this->em->getRepository('OradtStoreBundle:SysCardTemplate');        
        $list = $repository->findBy($findArray);        
        return $list;
    }

    public function intNewDelOld($id,$filed,$value)
    {        
        $record = $this->em->getRepository('OradtStoreBundle:AccountBasicMoveRecord')
            ->findOneBy(array('id'=>$id));
        if (empty($record)) {
            return true;
        }
        $sql = "INSERT INTO `account_basic_move_record_redu` (user_id,latitude,longitude,country,province,city,mapstate,status,created_time,push_time,md5city) values (:user_id,:latitude,:longitude,:country,:province,:city,:mapstate,:status,:created_time,:push_time,:md5city);";
        $param = array(':user_id'=>$record->getUserId(),':latitude'=>$record->getLatitude(),':longitude'=>$record->getLongitude(),':country'=>$record->getCountry(),':province'=>$record->getProvince(),':city'=>$record->getCity(),':mapstate'=>$record->getMapstate(),':status'=>$record->getStatus(),':created_time'=>$record->getCreatedTime(),':push_time'=>$record->getPushTime(),':md5city'=>$record->getMd5city());
        $this->em->getConnection()->executeQuery($sql,$param);
        $sq2 = "UPDATE `account_basic_move_record_redu` SET ".$filed."=".$value." WHERE id=".$id;
        $this->em->getConnection()->executeQuery($sq2);
        $sql1 = "DELETE FROM `account_basic_move_record` WHERE id=".$id;
        $this->em->getConnection()->executeQuery($sql1);
    }
    public function checkSid($sid)
    {
        $lastSql = "SELECT id FROM scanner WHERE scannerid =:scannerid AND status != 4;";
        $lastRecord = $this->em->getConnection()->executeQuery($lastSql, array(":scannerid"=>$sid))->fetch();
        if(!empty($lastRecord)){
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    } */
}
