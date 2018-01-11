<?php
namespace Oradt\AccountAdminBundle\Controller;

use Oradt\StoreBundle\Entity\AccountBasicRecommend;
use Oradt\StoreBundle\Entity\SysUserPromotion;
use Oradt\Utils\Errors;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Oradt\Utils\RandomString;
use Oradt\Utils\Codes;
use Oradt\StoreBundle\Entity\AccountTheme;
use Oradt\StoreBundle\Entity\OradtRedeemCode;
use Oradt\StoreBundle\Entity\OradtRedeemCodeGroup;
use Oradt\StoreBundle\Entity\AccountBasicCategory;
use Oradt\StoreBundle\Entity\SnsQaComment;
use Oradt\StoreBundle\Entity\OperationActivity;
use Oradt\StoreBundle\Entity\OperationActivityQaNews;
use Oradt\StoreBundle\Entity\OradtAgreement;
use Oradt\StoreBundle\Entity\OradtRechargeAppPrice;
use Oradt\StoreBundle\Entity\SysVersion;
use Oradt\StoreBundle\Entity\SysUnionpay;
use Oradt\StoreBundle\Entity\OrangePaybank;
class ApiStoreController extends BaseController{

    public function postAction($act){
        switch ($act) {
            case 'adminlog':
                return $this->adminlog();
                break;
            case 'theme':
                return $this->_postTheme();
                break;
            case 'deltheme':
                return $this->_delTheme();
                break;
            case 'catepopular':
                return $this->_catePopular();
                break;
            case 'uuidpopular':
                return $this->_UuidPopular();
                break;
            case 'ignorepopular':
                return $this->_ignorePolular();
                break;
            case 'redeemcode':
                return $this->_createRedeemCode();      //生成兑换码
                break;
            case 'redeemcodedit':
                return $this->_Redeemcodedit();         //追加兑换码
                break;
            case 'redeemcodeoper':
                return $this->_RedeemcodeOperation();   //兑换码操作（作废）
                break;
            case 'addcategory':
                return $this->_addCategory();
                break;
            case 'editcategory':
                return $this->_editCategory();
                break;
           /* case 'addreferrer':
                return $this->_addreferrer();           //人脉小助手
                break;*/
            case 'userpromotion':
                return $this->_userpromotion();         //用户推广
                break;
            case 'editpromotion':
                return $this->_editPromotion();         //修改用户推广
                break;
            /*case 'editcertification':
                return $this->_editcertification();     //修改认证
                break;*/
            case 'setbetascomment':
                return $this->_setBetasComment();       //修改认证
                break;
            case 'operation':
                return $this->_addOperation();          //添加活动
                break;
            case 'editoper':
                return $this->_editOperation();         //修改删除活动
                break;
            case 'invitecodecard':
                return $this->_invitecodecard();        //邀请码获取首页名片
                break;
            case 'agreement':           
                return $this->_addHtmlContent();          //添加静态页面内容管理
                break;
            case 'editagreement':           
                return $this->_editHtmlContent();         //编辑静态页面内容管理
                break;
            case 'delagreement':           
                return $this->_delHtmlContent();          //删除静态页面内容管理
                break;
            case 'appprice':           
                return $this->_addAppPrice();          //添加APP免费体验/会员权益价格
                break;
            case 'editappprice':           
                return $this->_editAppPrice();          //添加APP免费体验/会员权益价格
                break;
            case 'version':           
                return $this->_addAppVersion();          //新增app版本控制
                break;
            case 'editversion':           
                return $this->_editAppVersion();          //新增app版本控制
                break;
            case 'unionpay':           
                return $this->_addAppUnionpay();          //新增/编辑 银联app下载地址管理
                break;
            case 'orapaybank':           
                return $this->_addOrapayBank();          //新增orapay 银行
                break;
            case 'delorapaybank':           
                return $this->_delOrapayBank();          //删除orapay 银行
                break;
            case 'editorapaybank':           
                return $this->_editOrapayBank();          //编辑orapay 银行
                break;
            default:
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                break;
        }
    }
    /**
     * 编辑orapay 银行
     */
    public function _editOrapayBank(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $id     = $this->strip_tags($request->get('id'));             //id
        $name           = $this->strip_tags($request->get('name'));                 //银行名称
        $debitcard      = (int)$this->strip_tags($request->get('debitcard',1));     //借记卡 1:否 2:是
        $debitcardcity  = $this->strip_tags($request->get('debitcardcity',''));     //借记卡支持城市
        $creditcard     = (int)$this->strip_tags($request->get('creditcard',1));    //信用卡 1:否 2:是
        $creditcardcity = $this->strip_tags($request->get('creditcardcity',''));    //信用卡支持城市
        $logo           = $this->strip_tags($request->get('logo'));                 //银行logo地址
        $sorting        = (int)$this->strip_tags($request->get('sorting',0));       //排序
        $customer      = $this->strip_tags($request->get('customer'));              //客服
        //必要条件
        if (empty($id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(!empty($debitcard) && !in_array($debitcard, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter debitcard values");
        }
        if(!empty($creditcard) && !in_array($creditcard, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter creditcard values");
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp();
            //查询版本是否存在 未删除的
            $oraPayCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                              ->findOneBy(array('id'=>$id));
            if(empty($oraPayCon)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $oldName = $oraPayCon->getName();
            $oldSort = $oraPayCon->getSorting();
            //如果名称不为空，则与老的不一致 则需要查询名称是否存在
            if(!empty($name) && $name !=$oldName){
                $panBankName  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                              ->findOneBy(array('name'=>$name));
                if(!empty($panBankName)){
                    return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'paramter name values');
                }
                $oraPayCon->setName($name);
            }
            //如果排序不为空 ，则查询排序的值是否已经存在 已存在则报错
            if(!empty($sorting) && $sorting != $oldSort){
                $panBankSort  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                                  ->findOneBy(array('sorting'=>$sorting));
                if(!empty($panBankSort)){
                    return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'paramter sorting values');
                }
                $oraPayCon->setSorting($sorting); 
            }
            if(!empty($debitcard))      $oraPayCon->setDebitCard($debitcard);
            if(!empty($debitcardcity))  $oraPayCon->setDebitCardCity($debitcardcity);
            if(!empty($creditcard))     $oraPayCon->setCreditCard($creditcard);
            if(!empty($creditcardcity)) $oraPayCon->setCreditCardCity($creditcardcity);
            if(!empty($logo))           $oraPayCon->setLogo($logo);
            if (!empty($customer)) 
                $oraPayCon->setCustomer($customer);
            $em->persist($oraPayCon);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    
    
    /**
     * 删除orapay 银行
     */
    public function _delOrapayBank(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $id    = $this->strip_tags($request->get('id'));            //编号ID
        if (empty ( $id )) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();                               //添加事物
        try{
            //查询id是否存在
            $orapayCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                                      ->findOneBy(array('id'=>$id));
            if(empty($orapayCon)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            //删除静态页面内容
            $sql = "delete from `orange_paybank` where id =:id";
            $this->getConnection()->executeQuery($sql,array(':id'=>$id));
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $e) {
            $em->getConnection()->rollback();
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
    }

    /**
     * 新增orapay 银行
     */
    public function _addOrapayBank(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $name           = $this->strip_tags($request->get('name'));                 //银行名称
        $debitcard      = (int)$this->strip_tags($request->get('debitcard',1));     //借记卡 1:否 2:是
        $debitcardcity  = $this->strip_tags($request->get('debitcardcity',''));     //借记卡支持城市
        $creditcard     = (int)$this->strip_tags($request->get('creditcard',1));    //信用卡 1:否 2:是
        $creditcardcity = $this->strip_tags($request->get('creditcardcity',''));    //信用卡支持城市
        $logo           = $this->strip_tags($request->get('logo'));                 //银行logo地址
        $sorting        = (int)$this->strip_tags($request->get('sorting',0));       //排序
        $customer       = $this->strip_tags($request->get('customer'));             //客服
        //必要条件
        if (empty($name) || empty($logo)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询$name 是否存在
        $panBankCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                              ->findOneBy(array('name'=>$name));
        if(!empty($panBankCon)){
            return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'paramter name');
        }
        if(!empty($debitcard) && !in_array($debitcard, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter debitcard values");
        }
        if(!empty($creditcard) && !in_array($creditcard, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter creditcard values");
        }
        //如果排序不为空 ，则查询排序的值是否已经存在 已存在则报错
        if(!empty($sorting)){
            $panBankSort  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OrangePaybank')
                              ->findOneBy(array('sorting'=>$sorting));
            if(!empty($panBankSort)){
                return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'paramter sorting values');
            }
        }
        $adminId = $this->accountId;
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $oraPayBank = new OrangePaybank();
            $oraPayBank->setAdminId($adminId);
            $oraPayBank->setName($name);
            $oraPayBank->setDebitCard($debitcard);
            $oraPayBank->setDebitCardCity($debitcardcity);
            $oraPayBank->setCreditCard($creditcard);
            $oraPayBank->setCreditCardCity($creditcardcity);
            $oraPayBank->setLogo($logo);
            $oraPayBank->setSorting($sorting);   
            $oraPayBank->setCreatedTime($createTime);
            $oraPayBank->setCustomer($customer);
            $em->persist($oraPayBank);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 新增/编辑 银联app下载地址管理
     */
    public function _addAppUnionpay(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $paynum  = $this->strip_tags($request->get('unionpaynum',''));             //id
        $ios     = $this->strip_tags($request->get('ios',''));        //app版本
        $android = $this->strip_tags($request->get('android',''));          //类型 android ios 
        if (empty($paynum) &&  empty($ios) && empty($android)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $paynum = !empty($paynum) ? $paynum :'';
        $ios    = !empty($ios) ? $ios :'';
        $android = !empty($android) ? $android :'';
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $unionCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:SysUnionpay')
                              ->findAll();
            if(!empty($unionCon)){
                $sysUnionPay = $unionCon[0];
                if(!empty($paynum)) $sysUnionPay->setUnionpayNum($paynum);
                if(!empty($ios)) $sysUnionPay->setIosUnionpay($ios);
                if(!empty($android)) $sysUnionPay->setAndroidUnionpay($android);
            }else{
                $sysUnionPay = new SysUnionpay();
                $createTime = $this->getTimestamp();
                $sysUnionPay->setCreateTime($createTime);
                $sysUnionPay->setUnionpayNum($paynum);
                $sysUnionPay->setIosUnionpay($ios);
                $sysUnionPay->setAndroidUnionpay($android);
            }
            $em->persist($sysUnionPay);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 编辑app 版本控制信息
     */
    public function _editAppVersion(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $id     = $this->strip_tags($request->get('id'));                   //id
        $version     = $this->strip_tags($request->get('version'));         //app版本
        $devicetype  = $this->strip_tags($request->get('devicetype'));      //类型 android ios 
        $url         = $this->strip_tags($request->get('url'));             //android 下载地址
        $isios       = (int)$this->strip_tags($request->get('isios',1));    //是否开启IOS审核限制
        $unionpaynum   = $this->strip_tags($request->get('unionpaynum',''));//银联SDK限制版本号
        $isupdate      = (int)$this->strip_tags($request->get('isupdate',2));//是否强制更新 1：是 2：否（默认）
        $updateprompt  = $this->strip_tags($request->get('updateprompt'));  //版本更新提示语
        $upbutton      = $this->strip_tags($request->get('upbutton'));      //更新按钮提示
        $noupbutton    = $this->strip_tags($request->get('noupbutton'));    //暂不更新按钮提示
        $updatetime    = (int)$this->strip_tags($request->get('updatetime'));    //生效时间
        $updatelog     = $this->strip_tags($request->get('updatelog'));     //更新内容
        $isdelete      = (int)$this->strip_tags($request->get('isdelete')); //是否删除 1删除
        
        //必要条件
        if (empty($id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(!empty($isios) && !in_array($isios, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter isios values");
        }
        if(!empty($isupdate) && !in_array($isupdate, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter isupdate values");
        }
        //如果不为空 则转换为小写
        if(!empty($devicetype)){
            $devicetype = strtolower($devicetype);
            if (!in_array($devicetype,array('ios','android'))) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter devicetype values");
            }
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp();
            //查询版本是否存在 未删除的
            $versionCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:SysVersion')
                              ->findOneBy(array('isdelete'=>0,'id'=>$id));
            if(empty($versionCon)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            if(!empty($version))    $versionCon->setVersion($version);
            if(!empty($devicetype)) $versionCon->setDeviceType($devicetype);
            if(!empty($url))    $versionCon->setVersionUrl($url);
            if(!empty($isios))  $versionCon->setIsIos($isios);
            if(!empty($unionpaynum)) $versionCon->setUnionpayNum($unionpaynum);
            if(!empty($isupdate))    $versionCon->setIsUpdate($isupdate);
            if(!empty($updateprompt)) $versionCon->setUpdatePrompt($updateprompt);
            if(!empty($upbutton))     $versionCon->setUpbutton($upbutton);   
            if(!empty($noupbutton)) $versionCon->setNoupbutton($noupbutton);
            if(!empty($updatetime)) $versionCon->setUpdateTime($updatetime);
            if(!empty($updatelog))  $versionCon->setUpdateLog($updatelog);
            if(!empty($isdelete) && $isdelete ==1){
                $versionCon->setIsdelete($isdelete);
            }            
            $em->persist($versionCon);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 新增app 版本控制信息
     */
    public function _addAppVersion(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $version     = $this->strip_tags($request->get('version'));        //app版本
        $devicetype  = $this->strip_tags($request->get('devicetype'));          //类型 android ios 
        $url         = $this->strip_tags($request->get('url'));           //android 下载地址
        $isios       = (int)$this->strip_tags($request->get('isios',1));   //是否开启IOS审核限制
        $unionpaynum   = $this->strip_tags($request->get('unionpaynum',''));  //银联SDK限制版本号
        $isupdate      = (int)$this->strip_tags($request->get('isupdate',2));      //是否强制更新 1：是 2：否（默认）
        $updateprompt  = $this->strip_tags($request->get('updateprompt'));  //版本更新提示语
        $upbutton      = $this->strip_tags($request->get('upbutton'));      //更新按钮提示
        $noupbutton    = $this->strip_tags($request->get('noupbutton'));    //暂不更新按钮提示
        $updatetime    = (int)$this->strip_tags($request->get('updatetime'));    //生效时间
        $updatelog     = $this->strip_tags($request->get('updatelog'));     //更新内容
        //如果不为空 则转换为小写
        if(!empty($devicetype))  $devicetype = strtolower($devicetype);
        //必要条件
        if (empty($version) || !in_array($devicetype,array('ios','android'))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if(!empty($isios) && !in_array($isios, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter isios values");
        }
        if(!empty($isupdate) && !in_array($isupdate, array(1,2))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter isupdate values");
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $sysVersion = new SysVersion();
            $sysVersion->setVersion($version);
            $sysVersion->setDeviceType($devicetype);
            $sysVersion->setVersionUrl($url);
            $sysVersion->setIsIos($isios);
            $sysVersion->setUnionpayNum($unionpaynum);
            $sysVersion->setIsUpdate($isupdate);
            $sysVersion->setUpdatePrompt($updateprompt);
            $sysVersion->setUpbutton($upbutton);   
            $sysVersion->setNoupbutton($noupbutton);
            $sysVersion->setUpdateTime($updatetime);
            $sysVersion->setUpdateLog($updatelog);
            $sysVersion->setIsdelete(0);
            $sysVersion->setCreateTime($createTime);
            $em->persist($sysVersion);
            $em->flush();
            $em->getConnection()->commit();
            //更新缓存
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 编辑APP会员权益价格
     */
    public function _editAppPrice(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $id     = (int)$this->strip_tags($request->get('id'));        //编号
        $title  = $this->strip_tags($request->get('title'));     //标题
        $equitytime = (int)$this->strip_tags($request->get('equitytime'));           //权益时间（月）（type=1以天为单位）
        $equitycapacity = (int)$this->strip_tags($request->get('equitycapacity'));   //权益容量（张）
        $info       = $this->strip_tags($request->get('info'));     //权益说明
        $appid      = $this->strip_tags($request->get('appid'));    //对应的苹果系统 id 
        $price      = $this->strip_tags($request->get('price'));    //价格
        $status     = (int)$this->strip_tags($request->get('status'));    //状态 2删除
        //必要条件
        if (empty($id) || (!empty($status) && $status!=2)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $modifyTime = $this->getTimestamp();
            //查询会员权限是否存在
            $priceCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtRechargeAppPrice')
                              ->findOneBy(array('type'=>2,'id'=>$id));
            if(empty($priceCon)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            if(!empty($title))      $priceCon->setTitle($title);
            if(!empty($equitytime)) $priceCon->setEquityTime($equitytime);
            if(!empty($equitycapacity)) $priceCon->setEquityCapacity($equitycapacity);
            if(!empty($price)) $priceCon->setPrice($price);
            if(!empty($appid)) $priceCon->setAppid($appid);
            if(!empty($info)) $priceCon->setInfo($info);
            if(!empty($status)) $priceCon->setStatus($status);    //1：正常
            $priceCon->setModifiedTime($modifyTime);
            $em->persist($priceCon);
            $em->flush();
            //如果是删除，则根据编号 查看是否已经在订单中存在 如存在则更改状态即可，若不存在则删除数据
            if(!empty($status)){
                //查看订单中是否有这条规则的订单如果没有则直接删除
                $orderSql   = "SELECT id FROM basic_order WHERE goods_id=:id";
                $orderArray = $this->getConnection()->executequery($orderSql,array(':id'=> $id))->fetchAll();
                if(empty($orderArray)){
                    $deMapSql = "delete from `oradt_recharge_app_price` where id =:id";
                    $this->getConnection()->executeQuery($deMapSql,array(':id'=>$id));
                }
            }
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 添加1橙子伴侣免费体验/2会员权益价格/3橙子伴侣容量限制/4橙子赠送时长
     * 1/3/4 为1条记录 此接口支持添加编辑
     */
    public function _addAppPrice(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        //类型 1：橙子伴侣免费体验 2：会员权益 3：橙子伴侣容量限制 4：橙子赠送时长
        $type   = (int)$this->strip_tags($request->get('type'));      
        $title  = $this->strip_tags($request->get('title',''));     //标题
        //权益时间（月）（type=1或type=4以天为单位）
        $equitytime = (int)$this->strip_tags($request->get('equitytime'));           
        $equitycapacity = (int)$this->strip_tags($request->get('equitycapacity',0));   //权益容量（张）type=3
        $info       = $this->strip_tags($request->get('info',''));     //权益说明
        $appid      = $this->strip_tags($request->get('appid',''));    //对应的苹果系统 id 
        $price      = $this->strip_tags($request->get('price'));    //价格
        if(empty($price)) $price = 0.00;
        //必要条件
        if (empty($type) || !in_array($type,array(1,2,3,4))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        if($type == 2 && (empty($equitytime) || empty($title) || empty($info) || empty($appid) || empty($price))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $isNew  = true;     //是否是新增数据 针对type = 1使用
            $createTime = $this->getTimestamp();
            $appPrice = new OradtRechargeAppPrice();
            if($type != 2){
                //查询橙子伴侣免费体验/橙子伴侣容量限制/橙子赠送时长/是否存在
                $HtmlCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtRechargeAppPrice')
                                  ->findOneBy(array('type'=>$type));
                if(!empty($HtmlCon)){
                    $appPrice = $HtmlCon;
                    $isNew  = false;
                }
            }
            if($isNew){
                $appPrice->setCreatedTime($createTime);
            }
            $appPrice->setType($type);
            $appPrice->setTitle($title);
            $appPrice->setEquityTime($equitytime);
            $appPrice->setEquityCapacity($equitycapacity);
            $appPrice->setPrice($price);
            $appPrice->setAppid($appid);
            $appPrice->setInfo($info);
            $appPrice->setStatus(1);    //1：正常
            $appPrice->setModifiedTime($createTime);
            $em->persist($appPrice);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 静态页面内容管理-添加
     */
    public function _addHtmlContent(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $key        = $this->strip_tags($request->get('key'));          //key
        $content    = $request->get('content');      //内容
        //必要条件
        if (empty($key) || empty($content)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询key是否存在
        $HtmlCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtAgreement')
                                  ->findOneBy(array('name'=>$key));
        if(!empty($HtmlCon)){
             return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'key');
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            //保存
            $agreement = new OradtAgreement();
            $agreement->setAdminId($adminId);
            $agreement->setName($key);
            $agreement->setContent($content);
            $agreement->setModifyTime($createTime);
            $agreement->setCreatedTime($createTime);
            $em->persist($agreement);
            $em->flush();
            $Id    = $agreement->getId();
            $em->getConnection()->commit();
            $data = array( 'id' => $Id);
            return $this->renderJsonSuccess($data);
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    
    /**
     * 静态页面内容管理-编辑
     */
    public function _editHtmlContent(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $id         = $this->strip_tags($request->get('id'));           //id
        $key        = $this->strip_tags($request->get('key'));          //key
        $content    = $request->get('content');      //内容
        //必要条件
        if (empty($id) || empty($key) || empty($content)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        //查询id是否存在
        $agreementCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtAgreement')
                                  ->findOneBy(array('id'=>$id));
        if(empty($agreementCon)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $oldkey = $agreementCon->getName();
        if($oldkey != $key){
            //查询key是否存在
            $HtmlConkey  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtAgreement')
                                      ->findOneBy(array('name'=>$key));
            if(!empty($HtmlConkey)){
                 return $this->renderJsonFailed(Errors::$ERROR_SUB_EXISTS,'key');
            }
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $agreementCon->setAdminId($adminId);
            $agreementCon->setName($key);
            $agreementCon->setContent($content);
            $agreementCon->setModifyTime($createTime);
            $em->persist($agreementCon);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 静态页面内容管理-删除
     */
    public function _delHtmlContent(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $id    = $this->strip_tags($request->get('id'));            //编号ID
        if (empty ( $id )) {
            return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
        }
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();                               //添加事物
        try{
            //查询id是否存在
            $agreementCon  = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OradtAgreement')
                                      ->findOneBy(array('id'=>$id));
            if(empty($agreementCon)){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            //删除静态页面内容
            $sql = "delete from `oradt_agreement` where id =:id";
            $this->getConnection()->executeQuery($sql,array(':id'=>$id));
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $e) {
            $em->getConnection()->rollback();
            return $this->renderJsonFailed(Errors::$ERROR_UNKNOWN);
        }
    }
    /*
     *
     * 邀请码获取首页名片
     * */
    private function _invitecodecard()
    {
        $request = $this->getRequest();
        $invitecode = $this->strip_tags($request->get('invitecode'));
        $vcardid = $this->strip_tags($request->get('vcardid'));
        if (empty($invitecode)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $invitsql="SELECT * FROM account_basic WHERE id=:id";
        $invit = $this->getConnection()->executequery($invitsql, array(':id'=>$invitecode))->fetch();
        if(empty($invit)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT);
        }
        if(!empty($vcardid)){
            $vcardsql="SELECT user_id FROM contact_card WHERE uuid=:uuid";
            $resvcard = $this->getConnection()->executequery($vcardsql, array(':uuid'=>$vcardid))->fetchColumn();
            if($resvcard == $invit['user_id']){
                $selfvcardsql="select b.user_id as userid,b.uuid as cardid,picture,temp_id,vcard,pic_path_a,pic_path_b,b.handle_state as handlestate,b.card_type as cardtype
from account_basic as a LEFT JOIN contact_card as b ON a.user_id=b.user_id LEFT JOIN contact_card_extend as c ON b.uuid=c.uuid WHERE  b.uuid=:uuid AND b.status='active' AND a.id=:id";
                $selfres = $this->getConnection()->executequery($selfvcardsql, array(':id'=>$invitecode,':uuid'=>$vcardid))->fetch();
                if(empty($selfres['cardid'])){
                    $data = $this->_getSelfvcard($invitecode);
                }else{
                    $data =array(
                        "userid"=>$selfres['userid'],
                        "cardid"=>$selfres['cardid'],
                        "picture"=>$this->getCommondUrl($selfres['picture']),
                        "tempid"=>$selfres['temp_id'],
                        "vcard"=>$selfres['vcard'],
                        "handlestate"=>$selfres['handlestate'],
                        "cardtype"=>$selfres['cardtype'],
                        "type"=>1,
                        "picpatha"=>$this->getCommondUrl($selfres['pic_path_a']),
                        "picpathb"=>$this->getCommondUrl($selfres['pic_path_b'])
                    );
                }

            }else{
                $selfvcardsql="select b.user_id as userid,b.uuid as cardid,picture,temp_id,vcard,pic_path_a,pic_path_b,b.handle_state as handlestate,b.card_type as cardtype
from  contact_card as b LEFT JOIN contact_card_extend as c ON b.uuid=c.uuid WHERE  b.uuid=:uuid AND b.status='active'";
                $selfres = $this->getConnection()->executequery($selfvcardsql, array(':uuid'=>$vcardid))->fetch();
                if(!empty($selfres['cardid'])){
                    $data =array(
                        "userid"=>$selfres['userid'],
                        "cardid"=>$selfres['cardid'],
                        "picture"=>$this->getCommondUrl($selfres['picture']),
                        "tempid"=>$selfres['temp_id'],
                        "vcard"=>$selfres['vcard'],
                        "handlestate"=>$selfres['handlestate'],
                        "cardtype"=>$selfres['cardtype'],
                        "type"=>1,
                        "picpatha"=>$this->getCommondUrl($selfres['pic_path_a']),
                        "picpathb"=>$this->getCommondUrl($selfres['pic_path_b'])
                    );
                }else{
                    $data=array();
                }
            }
        }else{
           $data = $this->_getSelfvcard($invitecode);
        }
        return $this->renderJsonSuccess($data);
    }

    private function _getSelfvcard($id){
        $sql="select b.user_id as userid,b.uuid as cardid,picture,temp_id,vcard,pic_path_a,pic_path_b,b.handle_state as handlestate,b.card_type as cardtype
from account_basic as a LEFT JOIN contact_card as b ON a.user_id=b.user_id LEFT JOIN contact_card_extend as c ON b.uuid=c.uuid where a.id=:id AND b.nindex=1 AND b.status='active' AND b.self='true'";
        $res = $this->getConnection()->executequery($sql, array(':id'=>$id))->fetch();
        if(empty($res)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $data =array(
            "userid"=>$res['userid'],
            "cardid"=>$res['cardid'],
            "picture"=>$this->getCommondUrl($res['picture']),
            "tempid"=>$res['temp_id'],
            "vcard"=>$res['vcard'],
            "handlestate"=>$res['handlestate'],
            "cardtype"=>$res['cardtype'],
            "type"=>2,
            "picpatha"=>$this->getCommondUrl($res['pic_path_a']),
            "picpathb"=>$this->getCommondUrl($res['pic_path_b'])
        );
        return $data;
    }
        /*
       * betas评论
       * */
    private function _setBetasComment()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if ($this->accountType !== self::ACCOUNT_ADMIN) {
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $adminId = $this->accountId;
        $userid = $this->strip_tags($request->get('userid'));         //认证id
        $showid = $this->strip_tags($request->get('showid'));
        $content = $this->strip_tags($request->get('content'));
        if (empty($userid) || empty($showid) || empty($content)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
       $users = explode(',',$userid);
        $sql="SELECT * FROM sns_qa_news WHERE show_id=:id limit 1";
        $res = $this->getConnection()->executequery($sql, array('id'=>$showid))->fetch();
        if(empty($res) || !in_array($res['state'],array(3,6))){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $topId='';
        $parentid='';
        $filterService = $this->container->get("filter_service");
        $content=$filterService->keywordReplace($content);
        $showService = $this->container->get('sns_show_service');
        $toname = $showService->getToname('ask',$res['user_id']);
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            foreach ($users as $val) {
                $random = new RandomString();
                $commentId  = $random->make(32);
                $qaComment = new SnsQaComment();
                $qaComment->setShowId($showid);
                $qaComment->setParentId($parentid);
                $qaComment->setCommentId($commentId);
                $qaComment->setContent($content);
                $qaComment->setFromUid($val);
                $qaComment->setToUid($res['user_id']);
                $qaComment->setState('unread');
                $qaComment->setClickCount(0);
                $qaComment->setStatus(1);
                $qaComment->setTitle($res['title']);
                $qaComment->setCreatedTime($this->getTimestamp());
                $qaComment->setToname($toname);
                $qaComment->setCommentNum(0);
                $qaComment->setTopId($topId);
                $em->persist($qaComment);
                $em->flush();
            }
            //更新资讯评论数量
            $updatesql="UPDATE sns_qa_news SET comment_count=".($res['comment_count']+count($users))."  WHERE show_id=:id";
            $this->getConnection()->executequery($updatesql, array('id'=>$showid));
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        }catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /*
   * 修改认证
   * */
    private function _editcertification()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if ($this->accountType !== self::ACCOUNT_ADMIN) {
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $adminId = $this->accountId;
        $id = $this->strip_tags($request->get('id'));         //认证id
        $status = $this->strip_tags($request->get('status'));
        $remark = $this->strip_tags($request->get('remark'));
        if(empty($id) || ($status=='' && empty($status)) ){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $lastmodify = $this->getTimestamp();
        $sql="SELECT * FROM contact_card_certifcation WHERE id=:id";
        $res = $this->getConnection()->executequery($sql, array('id'=>$id))->fetch();
        if(empty($res)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $cardsql="SELECT * FROM contact_card WHERE uuid=:uuid limit 1";
        $rescard = $this->getConnection()->executequery($cardsql, array(':uuid'=>$res['card_id']))->fetch();
        if(empty($rescard)){
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $updatesql="UPDATE contact_card SET certifcation=:status,last_modified=:lastmodify WHERE uuid=:uuid";
        $this->getConnection()->executequery($updatesql, array('status'=>$status,'lastmodify'=>$lastmodify,'uuid'=>$res['card_id']));
        $updatesql="UPDATE contact_card_certifcation SET last_modify=:lastmodify WHERE id=:id";
        $this->getConnection()->executequery($updatesql, array(':id'=>$id,':lastmodify'=>$lastmodify));
        if($status == 1){
            $updatestatus="UPDATE contact_card  set certifcation=1 WHERE exch_id=:uuid";
            $this->getConnection()->executequery($updatestatus, array('uuid'=>$res['card_id']));
            $this->pushMessage(260,$res['user_id'],array('uuid'=>$res['card_id']),'','恭喜您已完成名片认证');
        }
        if($status == -1){
            $updatestatus="UPDATE contact_card  set certifcation=-1 WHERE exch_id=:uuid";
            $this->getConnection()->executequery($updatestatus, array('uuid'=>$res['card_id']));
            $this->pushMessage(261,$res['user_id'],array('uuid'=>$res['card_id'],'remark'=>$remark),'','您的名片认证信息出现错误!');
        }
        return $this->renderJsonSuccess();
    }
    /*
     * 用户推广
     * @param push_status 2017-5-8（新增：需求）
     * */
    private function _userpromotion(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $isalluser  = $this->strip_tags($request->get('isalluser'));         //1注册用户2持有名片3注册用户+持有名片
        $type       = $this->strip_tags($request->get('type'));              //推送方式2邮件3短信
        $title      = $this->strip_tags($request->get('title'));             //标题
        $pushtime   = $this->strip_tags($request->get('pushtime'));          //推送时间
        $region     = $this->strip_tags($request->get('region'));            //地区
        $industry   = $this->strip_tags($request->get('industry'));          //行业
        $func       = $this->strip_tags($request->get('func'));              //职能
        $isntice    = $this->strip_tags($request->get('isntice'));           //是否通知 : 1 通知 2不通知
        $content    = $request->get('content');                              // 推送内容
        // $status     = $this->strip_tags($request->get('status'));
        $url        = $this->strip_tags($request->get('url'));               //h5地址
        $starttime  = $request->get('starttime');                            //开始时间默认为0
        $endtime    = $request->get('endtime');                              //结束时间默认为0
        $isloop     = $this->strip_tags($request->get('isloop'));            //是否循环1、循环2、不循环
        $jsonData   = '';
        //必要条件
        if (empty($pushtime) || empty($content) || empty($isalluser) || empty($type) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $isalluser = intval($isalluser);
        if (!in_array($isalluser, array(1,2,3))) {
            $isalluser = 1;
        }
        $type = intval($type);
        if (!in_array($type, array(2,3))) {
            $type = 2;
        }
        $isntice = intval($isntice);
        if (empty($isntice) && !in_array($isntice, array(1,2))) {
            $isntice = 1;
        }
        $isloop = intval($isloop);
        if (empty($isloop) && !in_array($isloop, array(1,2))) {
            $isloop = 2;//默认不循环         
        }
        if (1 == $isloop) {
            $status = 1;
        }else{
            $status = 3;//默认为3：发布后需在列表点击推送：将status改为1
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime  = $this->getTimestamp();
            $sysuserpromotion = new SysUserPromotion();
            $random      = new RandomString();
            $proId       = $random->make(32);
            if (!empty($url)) {
                $url = str_replace('$', $proId,$url);
            }
            $sysuserpromotion->setProId($proId);
            $sysuserpromotion->setIsalluser($isalluser);
            $sysuserpromotion->setPushTime($pushtime);
            $sysuserpromotion->setNextPushTime($pushtime);
            $sysuserpromotion->setRegion($region);
            $sysuserpromotion->setIndustry($industry);
            $sysuserpromotion->setFunc($func);
            $sysuserpromotion->setContent($content);
            $sysuserpromotion->setCreatedTime($createTime);
            $sysuserpromotion->setAdminId($adminId);
            $sysuserpromotion->setStatus($status);
            $sysuserpromotion->setIsntice($isntice);
            $sysuserpromotion->setType($type);
            $sysuserpromotion->setTitle($title);
            $sysuserpromotion->setUrl($url);
            $sysuserpromotion->setIsloop($isloop);
            $sysuserpromotion->setIsget(1);
            $sysuserpromotion->setStartTime(intval($starttime));
            $sysuserpromotion->setEndTime(intval($endtime));
            $sysuserpromotion->setPushCount(0);
            $sysuserpromotion->setPushStatus(1);  //推送状态默认为1
            // 保存json推送内容
            //1、去除[[....]]图片格式
            $preg    = '/\[\[.*?\]\]/i';
            $content = preg_replace($preg, '', $content);
            $content = str_replace('"', "'", $content);
            // type = 2时候，为邮件 不需要去除图片及其他html标签 
            $content = $this->strip_tags($content);
            $content = addslashes($content);
            $content = html_entity_decode($content);
            // 去除html标签              
            $jsonArr = array(
                'messagetype'=>2311,
                'params'=>array(
                    'id'   =>$proId,
                    'title'=>$title,
                    'content'=>$content,
                    'createdtime'=>$createTime,
                    'image'=>'',
                    'type' =>'user',
                    'url'  => $url, 
                    'isnotify' => $isntice,
                ),
            );
            $jsonData = json_encode($jsonArr,JSON_UNESCAPED_UNICODE);
            $sysuserpromotion->setJsonData($jsonData);

            if (1 == $isntice) {
                
            }else{
                $sysuserpromotion->setJsonData($jsonData);
            }
            $em->persist($sysuserpromotion);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * 修改用户推广
     */
    public function _editPromotion()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $id         = $this->strip_tags($request->get('id'));         //id
        $proid      = $this->strip_tags($request->get('proid'));      //proid
        $isalluser  = $this->strip_tags($request->get('isalluser'));  //通知注册用户或全用户
        $type       = $this->strip_tags($request->get('type'));       //推送方式
        $title      = $this->strip_tags($request->get('title'));      //标题
        $pushtime   = $this->strip_tags($request->get('pushtime'));   //推送时间
        $region     = $request->get('region');                        //地区
        $industry   = $request->get('industry');                      //行业
        $func       = $request->get('func');                          //职能
        $isntice    = $request->get('isntice');                       //是否通知 : 1 通知 2不通知
        $content    = $request->get('content');                       //推送内容
        $status     = $this->strip_tags($request->get('status'));     //修改状态
        $url        = $this->strip_tags($request->get('url'));        //地址      
        $starttime  = $request->get('starttime');                     //开始时间
        $endtime    = $request->get('endtime');                       //结束时间
        $isloop     = $this->strip_tags($request->get('isloop'));     //是否循环
        $pushstatus = $this->strip_tags($request->get('pushstatus')); //推送状态
        //必要条件
        if (empty($id)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }        
        if (!empty($isalluser) && !in_array($isalluser, array(1,2,3))) {
            $isalluser = 1;
        }
        if (!empty($type) && !in_array($type, array(2,3))) {
            $type = 2;
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                if (empty($id)) {
                    continue;
                }
                $sysuserpromotion =  $this->getDoctrine()->getRepository ( 'OradtStoreBundle:SysUserPromotion')->findOneBy(array('id'=>$id));
                if (empty($sysuserpromotion)) {
                    return $this->renderJsonFailed(Errors::$DESIGN_ERROR_NO_DATA,$id);
                }
                if (!empty($isalluser)) {
                    $sysuserpromotion->setIsalluser($isalluser);
                }
                if (!empty($pushtime)) {
                    $sysuserpromotion->setPushTime($pushtime);
                    // 同时更新下一次推送时间
                    $sysuserpromotion->setNextPushTime($pushtime);
                }
                if (isset($region)) {
                    $sysuserpromotion->setRegion($region);
                }
                if (isset($industry)) {
                    $sysuserpromotion->setIndustry($industry);
                }
                if (isset($func)) {
                    $sysuserpromotion->setFunc($func);
                }
                if (!empty($content)) {
                    $sysuserpromotion->setContent($content);
                }            
                if (!empty($status)) {
                    $sysuserpromotion->setStatus($status);
                }
                if (!empty($pushstatus) && 1 == $pushstatus && 2 == $sysuserpromotion->getPushStatus() ) {
                    $old_push_time = $sysuserpromotion->getPushTime();
                    $nextTime = time();
                    if ($nextTime <= $old_push_time) {
                        $nextTime = $old_push_time;
                    }                    
                    // 重新设置推送时间
                    $sysuserpromotion->setNextPushTime($nextTime);
                    $sysuserpromotion->setPushStatus($pushstatus);
                }
                if (isset($isntice) && in_array($isntice, array(1,2))) {
                    $sysuserpromotion->setIsntice(intval($isntice)); 
                }
                if (!empty($type)) {
                    $sysuserpromotion->setType($type);
                }
                if (!empty($title)) {
                    $sysuserpromotion->setTitle($title);
                }
                if (!empty($url)) {
                    $url = str_replace('$', $id,$url);
                    $sysuserpromotion->setUrl($url);
                }
                if (isset($starttime)) {
                    $sysuserpromotion->setStartTime(intval($starttime));
                }
                if (isset($endtime)) {
                    $sysuserpromotion->setEndTime(intval($endtime));
                }
                if (!empty($isloop) ) {
                    $sysuserpromotion->setIsloop($isloop);
                    if (2 == $isloop && 1 == $sysuserpromotion->getIsloop() ) {
                        $nextTime = time();
                        // 重新设置推送时间
                        $sysuserpromotion->setNextPushTime($nextTime);
                    }
                }
                if ( !empty($title) || !empty($url) || !empty($content) ) {
                    $proid = $sysuserpromotion->getProId();
                    if (empty($title)) {
                        $title   = $sysuserpromotion->getTitle();
                    }
                    if (empty($content)) {
                        $content = $sysuserpromotion->getContent();
                    }
                    if (empty($url)) {
                        $url     = $sysuserpromotion->getUrl();
                    }
                    //去除[[....]]图片格式
                    $preg    = '/\[\[.*?\]\]/i';
                    $content = preg_replace($preg, '', $content);
                    $content = str_replace('"', "'", $content);
                    // 去除html标签
                    $content = $this->strip_tags($content);
                    $content = addslashes($content);
                    $content = html_entity_decode($content); 
                    $isntice = isset($isntice)?$isntice:$sysuserpromotion->getIsntice();
                    $jsonArr = array(
                        'messagetype'=>2311,
                        'params'=>array(
                            'id'   =>$proid,
                            'title'=>$title,
                            'content'=>$content,
                            'createdtime'=>$this->getTimestamp(),
                            'image'=>'',
                            'type' =>'user',
                            'url'  => $url, 
                            'isnotify' => $isntice,
                        ),
                    );
                    $data = json_encode($jsonArr,JSON_UNESCAPED_UNICODE);
                    $sysuserpromotion->setJsonData($data);
                }     
                //保存设置信息
                $em->persist($sysuserpromotion);
                $em->flush();
            }                
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        } 
    }
    /*
     * 新增推荐o
     * */
    private function _addreferrer(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $userid        = $this->strip_tags($request->get('userid'));                 //被推荐人id数组
        $cardid    = $this->strip_tags($request->get('cardid'));              //推荐人id数组
        $title    = $this->strip_tags($request->get('title'));              //推荐人id数组
        //必要条件
        if (empty($userid) || empty($cardid) || empty($title)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $userarr = explode(",",$userid);
        $cardarr = explode(",",$cardid);
        $usernum = count($userarr);
        $cardnum = count($cardarr);
        $val1 ='';
        $val2 ='';

        $createtime=$this->getDateTime();
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try{
            $Recommend  = new AccountBasicRecommend();
            $Recommend->setTitle($title);
            $Recommend->setRecommendNumber($usernum);
            $Recommend->setRecommendedNumber($cardnum);
            $Recommend->setRecommendTime($createtime);
            $Recommend->setIsPush(0);
            $em->persist($Recommend);
            $em->flush();
            //获取推荐id
            $recommendId    = $Recommend->getId();
            foreach($userarr as $uval){
                $val1 .= "('".$uval."',".$recommendId.",1),";
            }
            foreach($cardarr as $cval){
                $val2 .= "('".$cval."',".$recommendId.",2),";
            }
            $sql1 = "INSERT INTO `account_basic_recommend_detail` (user_id,recommend_id,type) VALUES".trim($val1,",");

            $sql2 = "INSERT INTO `account_basic_recommend_detail` (card_id,recommend_id,type) VALUES".trim($val2,",");
            $this->getConnection()->executeUpdate($sql1);
            $this->getConnection()->executeUpdate($sql2);            
            $em->getConnection()->commit();
            $gearmanService = $this->container->get ('gearman_service');
            $gearOp = array("id"=>$recommendId,"type"=>"referrer");
            $gearmanService->push_job("ContactCard", $gearOp);
            return $this->renderJsonSuccess();
        }catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }

    }
    /**
     * 编辑追加
     */
    private function _Redeemcodedit(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $groupId    = $this->strip_tags($request->get('groupid'));             //兑换码组id
        $addnum     = $this->strip_tags($request->get('addnum'));              //追加数量
        //必要条件
        if (empty($groupId) || empty($addnum)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            //查询兑换码组是否存在
            $cGroup  = $this->getDoctrine()->getRepository ('OradtStoreBundle:OradtRedeemCodeGroup')
                    ->findOneBy(array('id'=>$groupId));
            if (empty($cGroup)) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            //如果该组兑换码 正在生成中，则不允许追加
            $status = $cGroup->getStatus();
            if($status == '1'){
                return $this->renderJsonFailed(Errors::$ERROR_PARAMTER_ERROR,"paramter group status values");
            }
            $cGroup->setAddNum($addnum);
            $cGroup->setCreateNum(0);
            $cGroup->setStatus(0);  //兑换码未生成
            $em->persist($cGroup);
            $em->flush();
            $em->getConnection()->commit();
            //生成追加的兑换码异步操作，目前未启用gearman 任务
            $gearmanService = $this->container->get ( 'gearman_service');
            $gearOp = array(
                "type"       => "generateRedeem",
                "id"         => $groupId
            );
            $gearmanService->push_job("Common", $gearOp);
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 兑换码 操作 （作废处理）
     */
    private function _RedeemcodeOperation(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $redeemcode = $this->strip_tags($request->get('redeemcode'));          //兑换码
        //必要条件
        if (empty($redeemcode)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            //查询兑换码组是否存在
            $code  = $this->getDoctrine()->getRepository ('OradtStoreBundle:OradtRedeemCode')
                    ->findOneBy(array('redeemCode'=>$redeemcode));
            if (empty($code)) {
                return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
            }
            $groupId    = $code->getGroupId();
            $status     = $code->getStatus();
            $useAccountId = $code->getUseAccountId();
            //如果是已兑换的 则需要收回
            if($status == 2){
                //获取兑换码组能兑换的 容量和时间分别是多少
                $sql    = "SELECT exchange_length,exchange_stock FROM oradt_redeem_code_group
                    WHERE id =:id";
                $codeGroup  = $this->getConnection()->executeQuery($sql, array(':id'=>$groupId))->fetch();
                $length = $codeGroup['exchange_length'];    //兑换码能对应的长度
                $stock  = $codeGroup['exchange_stock'];     //兑换码能对应的容量
                //获取账户原有时长 或 容量
                $lastSql    = "SELECT b.mobile,d.real_name,d.created_time,d.expiry_date,d.card_capacity FROM account_basic AS b
                    LEFT JOIN account_basic_detail AS d ON b.user_id = d.user_id
                    WHERE b.user_id =:userid;";
                $basicArr   = $this->getConnection()->executeQuery($lastSql, array(":userid"=>$useAccountId))->fetch();
                if(empty($basicArr)){
                    return $this->renderJsonFailed( Errors::$ERROR_ACCOUNT_NOEXISTS );
                }
                $expiry_date    = $basicArr['expiry_date'];         //当前到期时间
                $card_capacity  = $basicArr['card_capacity'];       //当前名片容量
                //收回已兑换的容量或时间
                if(!empty($length)){
                    $expiry_date = $expiry_date - 3600*24*$length;   //减去已兑换的会员天数
                }
                if(!empty($stock)){
                    $card_capacity = $card_capacity - $stock;       //减掉已兑换的名片容量
                }
                //更新会员表信息
                $upParam    = array(
                    ':card_capacity'=>$card_capacity,
                    ':expiry_date'  =>$expiry_date,
                    ':user_id'      =>$useAccountId
                );
                $upBasicSql = "UPDATE account_basic_detail SET card_capacity=:card_capacity,expiry_date=:expiry_date WHERE user_id =:user_id";
                $this->getConnection()->executeUpdate($upBasicSql,$upParam);
            }
            $code->setStatus(4);  //兑换码作废
            $em->persist($code);
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

        /**
     * 生成兑换码
     */
    private function _createRedeemCode(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $adminId    = $this->accountId;
        $num        = $this->strip_tags($request->get('num'));                 //兑换码数量
        $length     = $this->strip_tags($request->get('length'));              //兑换时长
        $stock      = $this->strip_tags($request->get('stock'));              //兑换存量
        $startime   = $this->strip_tags($request->get('startime'));              //有效期（开始时间）
        $endtime    = $this->strip_tags($request->get('endtime'));              //有效期（结束时间）
        //必要条件
        if (empty($num) || empty($startime)  || empty($endtime) || (empty($length) && empty($stock))) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();
        try {
            $createTime = $this->getTimestamp();
            $randNum    = str_pad(rand(1, 9999),4,'0',STR_PAD_LEFT); 
            $name       =  date("YmdHis", $createTime).$randNum;
            
            $codeGroup  = new OradtRedeemCodeGroup();
            $codeGroup->setName($name);
            $codeGroup->setNum($num);
            $codeGroup->setExchangeLength(intval($length));
            $codeGroup->setExchangeStock(intval($stock));
            $codeGroup->setLeaveNum($num);
            $codeGroup->setAdminId($adminId);
            $codeGroup->setStartTime($startime);
            $codeGroup->setEndTime($endtime);
            $codeGroup->setAddNum($num);   //要生成数量（可追加生成完毕后该字段为空）
            $codeGroup->setCreateNum(0);   //要生成数量中 ，已生成的数量统计 （生成完毕后 改为0）
            $codeGroup->setStatus(0);   //未生成
            $codeGroup->setCreatedTime($createTime);
            $em->persist($codeGroup);
            $em->flush();
            //保存生成兑换码的id
            $groupId    = $codeGroup->getId();     
//            for($i=1;$i<=$num;$i++){
//                $redeemcode  = date("y",time());   
//                $redeemcode .= $this->getTimestamp();
//                $redeemcode .= str_pad($i,4,'0',STR_PAD_LEFT); 
//                $insertsql  = "INSERT INTO oradt_redeem_code (group_id,redeem_code,start_time,end_time,created_time) VALUES
//                 (:group_id,:redeem_code,:start_time,:end_time,:created_time)";
//                $params = array(
//                        ':group_id'     => $groupId, 
//                        ':redeem_code'  => $redeemcode, 
//                        ':start_time'   => $startime, 
//                        ':end_time'     => $endtime, 
//                        ':created_time' => $this->getTimestamp()
//                );
//                $this->getConnection()->executeUpdate($insertsql,$params);
//            }
            $em->getConnection()->commit();
            //异步处理写入方式目前未启用
            $gearmanService = $this->container->get ( 'gearman_service');
            $gearOp = array(
                "type"       => "generateRedeem",
                "id"         => $groupId
            );
            $gearmanService->push_job("Common", $gearOp);
            return $this->renderJsonSuccess(array('groupid'=>$groupId));
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 主题添加
     * @param version
     * @param url
     * @param size
     * @param name
     * @param content
     * @param author
     * @param creattime
     * @param image
     * @return 0
     * @author xinggm
     * @date 2016-1-7
     */
    private function _postTheme()
    {
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $request    = $this->getRequest();
        $name       = $this->strip_tags($request->get('name'));
        $content    = $this->strip_tags($request->get('content'));
        $url        = $request->files->get('url');
        $version    = $this->strip_tags($request->get('version'));
        $size       = $this->strip_tags($request->get('size'));
        $unit       = $this->strip_tags($request->get('unit'));
        $author     = $this->strip_tags($request->get('author'));
        $type       = intval($this->strip_tags($request->get('type')));
        if (empty($type) || 0 == $type) $type = 1; 
        $accountId  = $this->accountId;
        if (empty($name) || empty($content) || empty($version) || empty($url) || empty($size) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();         
        try {
            /**
             * 添加位置
             */
            $random     = new RandomString();
            $themeId     = $random->make(32);
            $createTime = $this->getTimestamp();
            $accountTheme = new AccountTheme();
            $accountTheme->setName($name);
            $accountTheme->setContent($content);
            $accountTheme->setType($type);
            $url_path = '';
            if (3 == $type) {
                $url_path = $this->container->get('aws_service')->getFolderPath($url, $themeId, $type = 'themeSns');
            }else{
                $url_path = $this->container->get('aws_service')->getFolderPath($url, $themeId, $type = 'theme');                
            }
            if (empty($url_path)) return $this->renderJsonFailed();
            $accountTheme->setUrl($url_path);
            $accountTheme->setVersion($version);
            $accountTheme->setSize($size);
            $accountTheme->setUnit($unit);
            $accountTheme->setAuthor($author);
            $accountTheme->setAccountId($accountId);
            $accountTheme->setCreateTime($createTime);            
            $em->persist($accountTheme);//保存位置
            $em->flush();// 刷新
            $em->getConnection()->commit();// 中断执行
            $id = $accountTheme->getId();
            return $this->renderJsonSuccess(array('id'=>$id));
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    /**
     * 删除主题
     * @param id | ids
     * @return 0
     * @author xinggm
     * @date 2016-1-7
     * 
     */
    private function _delTheme()
    {
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $request    = $this->getRequest();
        $id         = $this->strip_tags($request->get('id'));
        $ids        = explode(',', $id);
        $author     = $this->accountId;
        if (empty($id)) return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();         
        try {
            foreach ($ids as $id) {
                if (empty($id)) continue;
                $sql    = array('id'=>$id);
                $result = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:AccountTheme')->findOneBy($sql);
                if( empty($result)) return $this->renderJsonFailed ( Errors::$ERROR_PARAMETER_NOT_DATA );
                $url = $result->getUrl();
                if (!empty($url)) {
                    $docroot        = $this->container->getParameter('DOC_ROOT');
                    $urlPath     = $docroot . $url;
                    if (is_file($urlPath) && file_exists($urlPath)) {
                        unlink($urlPath);
                    }
                }
                $em->remove($result);//
                $em->flush();// 刷新
            }
            $em->getConnection()->commit();// 中断执行
            return $this->renderJsonSuccess();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * 处理基数少的uuid
     */
    private function popularToUser($uuids){
        $showService = $this->container->get('sns_show_service');
		$success = $suc = $fail =  array();
		foreach ($uuids as $uuid) {
			$em = $this->getDoctrine()->getManager();
			//try{
			$communicate = $em->getRepository ( 'OradtStoreBundle:AccountCommunicate' )->findOneBy ( array ('id' => $uuid ) );
            // $accountdetail =  $em->getRepository ( 'OradtStoreBundle:AccountBasicDetail' )->findOneBy ( array ('userId' => $popularcard->getUserId() ) );
	    	if (empty($communicate)) {
                return $this->renderJsonFailed(Errors::$DESIGN_ERROR_NO_DATA);
            }
            if($communicate->getPopularType() != 1){
	    		continue;
	    	}
	    	$mcode = $communicate->getMcode();
	    	$mobile = $communicate->getMobile();
			//}catch (\Exception $ex) {echo $ex;}
            $content = $this->container->getParameter('SMS_POPULAR_CODE');
	    	// $content = Codes::SMS_POPULAR_CODE;
	        //发送短信操作
	        $smsService = $this->container->get('sms_service');
	        //发送短信
	        $data = $smsService->sendSmsByType($mcode.$mobile,$content, 'popular',Codes::SMS_TYPE_TEXT,Codes::USE_YMSMS_MARKETING_ACCOUNT);
	        //通过成功状态返回成功信息
            if (is_array($data)) {
		        $em->getConnection()->beginTransaction();
		        try {
		        	$communicate->setPopularType(2);
		        	$communicate->setPopularTime(time());
			        $em->persist($communicate);
			        $em->flush();
			        $em->getConnection()->commit();
		         } catch (\Exception $ex) {
		            $em->getConnection()->rollback();
		            throw $ex;
		        }
		        array_push($suc,$uuid);
	        }else{
                array_push($fail,$uuid);
            }
		}
        $success = array(
            'suc' =>count($suc),
            'fail'=>count($fail),
            );
		return $success;
    }/**
     * 根据行业推送，基数比较大
     * froeach 
     * $em->getRepository ( 'OradtStoreBundle:AccountCommunicate' )->findOneBy ( array ('id' => $uuid ) );
     * 浪费时间||突然地跳出 已200为一标准，拆分成数组在发送
     */
    private function popularToUserByCate($data){
        $showService = $this->container->get('sns_show_service');
        $content = $this->container->getParameter('SMS_POPULAR_CODE');
        // $content = Codes::SMS_POPULAR_CODE;
        //发送短信操作
        $smsService = $this->container->get('sms_service');
        $success = $suc = $fail =  array();        
        $newData = array_chunk($data,200);
        //第一层分解:每组最多200数据
        foreach ($newData as $key => $value) {
            // 第二层分解:给每个短信发送信息
            $newSuc = array();
            foreach ($value as $k => $val) {
                $uuid   = $val['id'];
                $mcode  = $val['mcode'];
                $mobile = $val['mobile'];
                /** 给手机发短信*/
                $dataInfo = $smsService->sendSmsByType($mcode.$mobile,$content, 'popular',Codes::SMS_TYPE_TEXT,Codes::USE_YMSMS_MARKETING_ACCOUNT);
                //发送成功|失败
                if (is_array($dataInfo)) {
                    $newSuc[] = $uuid;
                    $suc[]    = $uuid;
                }else{
                    $fail[] = $uuid;
                }
            }
            /* 更改数据 */   
            if (!empty($newSuc)) {
                $inCond = implode(',', $newSuc);
                $showService->updatePopularByInuuid($inCond,time());
            }
        }
        // foreach ($uuids as $uuid) {
        //     $em = $this->getDoctrine()->getManager();
        //     //try{
        //     $communicate = $em->getRepository ( 'OradtStoreBundle:AccountCommunicate' )->findOneBy ( array ('id' => $uuid ) );
        //     // $accountdetail =  $em->getRepository ( 'OradtStoreBundle:AccountBasicDetail' )->findOneBy ( array ('userId' => $popularcard->getUserId() ) );
        //     if (empty($communicate)) {
        //         return $this->renderJsonFailed(Errors::$DESIGN_ERROR_NO_DATA);
        //     }
        //     if($communicate->getPopularType() != 1){
        //         continue;
        //     }
        //     $mcode = $communicate->getMcode();
        //     $mobile = $communicate->getMobile();
        //     //}catch (\Exception $ex) {echo $ex;}
            
        //     //发送短信
        //     $data = $smsService->sendSmsByType($mcode.$mobile,$content, 'popular',Codes::SMS_TYPE_TEXT,Codes::USE_YMSMS_MARKETING_ACCOUNT);
        //     //通过成功状态返回成功信息
        //     if (is_array($data)) {
        //         $em->getConnection()->beginTransaction();
        //         try {
        //             $communicate->setPopularType(2);
        //             $communicate->setPopularTime(time());
        //             $em->persist($communicate);
        //             $em->flush();
        //             $em->getConnection()->commit();
        //          } catch (\Exception $ex) {
        //             $em->getConnection()->rollback();
        //             throw $ex;
        //         }
        //         array_push($suc,$uuid);
        //     }else{
        //         array_push($fail,$uuid);
        //     }
        // }
        $success = array(
            'suc' =>count($suc),
            'fail'=>count($fail),
            );
        return $success;
    }
    public function _catePopular(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId     = $this->accountId;
		$category = $this->strip_tags($request->get('categoryid'));
		if(empty($category)){
			return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH ) ; 
		}
		$cates    = explode(',', $category);
        $showService  = $this->container->get('sns_show_service');
    	$ids = $result = $res = array();
        $result['suc'] = $result['fail'] = array();
        foreach ($cates as $cate){
	    	$pusers   = $showService->getPopularUser($cate);
	    	if(is_array($pusers) && !empty($pusers)){
	    		foreach ($pusers as $puser) {
	    			$ids[$cate][] = $puser;
	    		}
	    	}else{
                $res[$cate] = $pusers;
            }
        }
        /**
         * 根据行业分组
         */
    	if(!empty($ids)){
            foreach ($ids as $k => $id) {
                $ret = $this->popularToUserByCate($id);
                if (0 == $ret['suc'] && 0 != $ret['fail'] ) {
                    $result['fail'][$k] = $ret;
                }else{
                    $result['suc'][$k] = $ret;
                }
            }
    	}
        foreach ($res as $key => $value) {
            $result['fail'][$key]['suc'] = 0;
            $result['fail'][$key]['fail'] = 0;
            $result['fail'][$key]['empty'] = 1;
        }
        return $this->renderJsonSuccess(array('result'=>$result));    	
    }
    public function _UuidPopular(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId     = $this->accountId;
		$uuid = $this->strip_tags($request->get('uuid'));
		if(empty($uuid)){
			return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH ) ; 
		}
		$ids    = explode(',', $uuid);
                                                    	
		$ret = $this->popularToUser($ids);
        if (0 == $ret['suc']) {
            return $this->renderJsonFailed(Errors::$ERROR_SEND_MESSAGE_FAILE);
        }else{
            return $this->renderJsonSuccess();
        }
    }
    /**
     * 删除推广信息
     */
    public function _ignorePolular(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userId     = $this->accountId;
		$uuid = $this->strip_tags($request->get('uuid'));
		$flag = intval($request->get('flag'));
		if(empty($uuid)){
			return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH ) ; 
		}
		if(empty($flag) || !isset($flag)){
			$flag = 3;
		}else{
			$flag = 1;
		}
		$succ = array();
		$fail = array();
		$ids    = explode(',', $uuid);
		$em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        try {
			foreach ($ids as $uid) {
				$communicate = $em->getRepository ( 'OradtStoreBundle:AccountCommunicate' )->findOneBy ( array ('id' => $uid ) );
				if(!empty($communicate)){
				    $communicate->setPopularType($flag);
			        $em->persist($communicate);
			        $em->flush();
			        array_push($succ,$uid);
				}else{
					array_push($fail,$uid);
				}
			}
			$em->getConnection()->commit();
        } catch (\Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
        return $this->renderJsonSuccess();
    }
    /**
     * 添加行业
     */
    public function _addCategory()
    {
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $request    = $this->getRequest();
        $name       = $this->strip_tags($request->get('name'));
        $categoryid = $this->strip_tags($request->get('categoryid'));
        $parentid   = $this->strip_tags($request->get('parentid'));
        $sorting    = $this->strip_tags($request->get('sorting'));
        $key        = $this->strip_tags($request->get('key'));
        $type       = $this->strip_tags($request->get('type'));
        $accountId  = $this->accountId;
        if (empty($name)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        /**
         * 检测名称
         */
        $checkName =$this->getDoctrine()->getManager()->getRepository ( 'OradtStoreBundle:AccountBasicCategory' )->findOneBy(array ('name' =>$name,'categoryId' =>$categoryid));
        if (!empty($checkName)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_UNI_NAME);
        }
        /**
         * 检测categoryid
         */
        if (!empty($categoryid)) {
            if (!empty($categoryid)) {
                $checkCate = $this->getDoctrine()->getManager()->getRepository ( 'OradtStoreBundle:AccountBasicCategory' )->findOneBy(array ('categoryId' =>$categoryid));
                if (!empty($checkCate)) {
                    return $this->renderJsonFailed(Errors::$TOPIC_ERROR_CATEGORY_EXISTS);
                }
            }
        }
        $status = empty($status)?1:$status;
        if (!in_array($status, array(1,2))) {
            $status = 1;
        }     
        $type = empty($type)?1:$type;
        if (!in_array($type,array(1,2))) {
            $type = 1;
        }
        if (0 == $parentid || !isset($parentid) || empty($parentid)) {
            $parentid = '0';
        }
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();       
        try {
            /**
             * 添加位置
             */
            $createTime = $this->getTimestamp();
            $category = new AccountBasicCategory();
            $category->setName($name);
            $category->setOriName($name);
            $category->setCategoryId($categoryid);
            $category->setParentId($parentid);
            $category->setCreateTime($createTime);
            $category->setModifyTime(0);
            $category->setSorting(intval($sorting));
            $category->setKeyword($key);
            $category->setAdminId($accountId);
            $category->setStatus(1);
            $category->setType($type);
            $em->persist($category);//保存位置
            $em->flush();// 刷新
            $em->getConnection()->commit();// 中断执行
            $id = $category->getId();
            return $this->renderJsonSuccess(array('id'=>$id));
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    /**
     * 修改行业
     */
    public function _editCategory(){
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $request    = $this->getRequest();
        $cid        = $this->strip_tags($request->get('id'));
        $categoryid = $this->strip_tags($request->get('categoryid'));
        $name       = $this->strip_tags($request->get('name'));
        $parentid   = $this->strip_tags($request->get('parentid'));
        $key        = $this->strip_tags($request->get('key'));
        $sorting    = $this->strip_tags($request->get('sorting'));
        $status     = (int)$this->strip_tags($request->get('status'));
        // $type       = (int)$this->strip_tags($request->get('type'));
        if ( isset($status) && !in_array($status, array(1,2,3))) {
            $status = 1;
        }
        // if (isset($type) && !in_array($type, array(1,2))) {
        //     $type = 1;
        // }
        $accountId  = $this->accountId;
        if (empty($cid)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $category = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:AccountBasicCategory')->findOneBy(array('id'=>$cid));
        if (empty($category)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
        }
        $oldStatus = $category->getStatus();
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();   
        try {
            /**
             * 添加位置
             */
            $createTime = $this->getTimestamp();
            if (!empty($name))                 
                $category->setName($name);
            if (!empty($categoryid)) 
                $category->setCategoryId($categoryid);
            if (isset($parentid)) 
                $category->setParentId($parentid);
            if (!empty($key)) 
                $category->setKeyword($key);
            if (!empty($sorting)) 
                $category->setSorting(intval($sorting));
            // if (!empty($type)) 
            //     $category->setType(intval($type));
            $category->setModifyTime($createTime);
            if ($status != $oldStatus) {
                $category->setStatus($status);
            }            
            $em->persist($category);//保存位置
            $em->flush();// 刷新
            $em->getConnection()->commit();// 中断执行
            // $id = $category->getId();
            return $this->renderJsonSuccess();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }                            
    }
    /**
     * 添加活动
     */
    public function _addOperation()
    {
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $accountId  = $this->accountId;
        $request    = $this->getRequest();
        $type       = $this->strip_tags($request->get('type'));             //活动类型1
        $isnotify   = $this->strip_tags($request->get('isnotify'));         //是否通知
        $region     = $this->strip_tags($request->get('region'));           //地区
        $industry   = $this->strip_tags($request->get('industry'));         //行业
        $func       = $this->strip_tags($request->get('func'));             //活动类型1
        $title      = $this->strip_tags($request->get('title'));            //标题
        $image      = $request->files->get('image');                        //图片
        $content    = $request->get('content');                             //内容
        $starttime  = $request->get('starttime');                           //开始时间
        $endtime    = $request->get('endtime');                             //结束时间
        $status     = $this->strip_tags($request->get('status'));           //发布状态
        $url        = $this->strip_tags($request->get('url'));              //H5url
        $pushtime   = $request->get('pushtime');                            //推送时间

        $isback     = $this->strip_tags($request->get('isback'));           //是否撤回
        $isloop     = $this->strip_tags($request->get('isloop'));           //是否循环
        $weburl     = $this->strip_tags($request->get('weburl'));           //weburl网址
        $admin      = $this->strip_tags($request->get('admin'));            //admin 添加人
        $groups     = $this->strip_tags($request->get('groups'));            //分组 添加人

        $jsonData   = '';
        if (empty($title) ) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $isnotify = empty($isnotify)?1:intval($isnotify);
        if (!in_array($isnotify, array(1,2))) {
            $isnotify = 1;
        }
        if (empty($isloop) || !in_array($isloop, array(1,2))) {
            $isloop   =  1;
        }
        if (empty($groups) || !in_array($groups, array(0,1,2))) {
            $groups    = 0;
        }
        $random     = new RandomString();
        $activityId = $random->make(32);
        if (!empty($image)) {
            $image = $this->container->get('aws_service')->getFolderPath($image, $activityId);
        }else{
            $image = '';
        }     
        $em = $this->getDoctrine()->getManager(); //添加事物
        $em->getConnection()->beginTransaction();        
        try {
            $createTime = $this->getTimestamp();
            $operation = new OperationActivity();
            $operation->setActivityId($activityId);//
            $operation->setType(1);
            $operation->setIsnotify($isnotify);
            $operation->setPushStatus(1);
            $operation->setRegion($region);
            $operation->setIndustry($industry);
            $operation->setFunc($func);
            $operation->setImage($image);
            $operation->setTitle($title);
            $operation->setContent($content);
            $operation->setStartTime($starttime);
            $operation->setEndTime($endtime);
            $operation->setUserId($accountId);
            $operation->setCreatedTime($createTime);
            $operation->setModifyTime(0);
            $operation->setStatus(3); //保存未推送状态
            $operation->setClickCount(0);
            $operation->setShareCount(0);
            $operation->setShareUserCount(0);
            $operation->setPushCount(0);
            $operation->setIsloop($isloop);
            $operation->setIsback(1);
            $operation->setIsget(1);
            $operation->setPushTime($pushtime);
            $operation->setNextPushTime($pushtime);
            $operation->setWeburl($weburl);
            if (!empty($isnotify)) {
                if (!empty($url)) {
                    $url = str_replace('$', $activityId,$url);
                }
                // 如果是活动就获取内容里的第一张名片
                $json_image = $image;                
                //去除[[....]]图片格式             
                if (!empty($content)) {
                    $preg    = '/\[\[.*?\]\]/i';
                    $content = preg_replace($preg, '', $content);
                    // 去除html标签
                    $content = $this->strip_tags($content);
                    $content = addslashes($content);    
                }
                $jsonArr = array(
                    'messagetype'=>231,
                    'params'=>array(
                        'id'     =>$activityId,
                        'title'  =>$title,
                        'content'=>$content,
                        'createdtime'=>$createTime,
                        'image'  =>$json_image,
                        'type'   =>'active',
                        'url'    => $url,
                        'isnotify' => $isnotify,
                    ),
                );
                $jsonData = json_encode($jsonArr,JSON_UNESCAPED_UNICODE);
            }
            $operation->setUrl($url);
            $operation->setAdmin($admin);
            $operation->setGroups($groups);
            $operation->setJsonData($jsonData);
            $em->persist($operation);
            $em->flush();
            $em->getConnection()->commit();
            $id = $operation->getId();
            return $this->renderJsonSuccess(array('id'=>$id));
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
     /**
     * 修改活动或者删除或者点击分享
     */
    public function _editOperation()
    {
        $this->checkAccount();
        $request    = $this->getRequest();
        if (self::ACCOUNT_ADMIN == $this->accountType) {
            return $this->adminEditOperation($request);
        }else if (self::ACCOUNT_BASIC == $this->accountType) {
            return $this->clickShareOperation($request);
        }else{
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }        
    }
    // 后台修改
    protected function adminEditOperation($request)
    {        
        $accountId  = $this->accountId;
        $operationId= $this->strip_tags($request->get('activityid'));       //活动ID
        $type       = $this->strip_tags($request->get('type'));             //活动类型1
        $isnotify   = $this->strip_tags($request->get('isnotify'));         //是否通知
        $region     = $request->get('region');                              //地区
        $industry   = $request->get('industry');                            //行业
        $func       = $request->get('func');                                //活动类型1
        $title      = $this->strip_tags($request->get('title'));            //标题
        $image      = $request->files->get('image');                        //图片
        $content    = $request->get('content');                             //内容
        $starttime  = $request->get('starttime');                           //开始时间
        $endtime    = $request->get('endtime');                             //结束时间
        $status     = $this->strip_tags($request->get('status'));           //状态1正常2删除
        $url        = $this->strip_tags($request->get('url'));              //h5地址
        $isback     = $this->strip_tags($request->get('isback'));           //是否撤回
        $isloop     = $this->strip_tags($request->get('isloop'));           //是否循环
        $pushtime   = $this->strip_tags($request->get('pushtime'));         //推送时间
        $weburl     = $request->get('weburl');                              //网址
        $admin      = $request->get('admin');                               //运营人员
        $groups     = $request->get('groups');                               //分组
        if (empty($operationId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }        
        // if (!empty($type) && !in_array($type, array(1,2))) {
        //     $type = 1;
        // }
        // if (!empty($isnotify) && !in_array($isnotify, array(1,2))) {
        //     $isnotify = 1;
        // }
        // if (!empty($status) && !in_array($status, array(1,2))) {
        //     $state = 1;
        // }
        if (!empty($image)) {
            $image = $this->container->get('aws_service')->getFolderPath($image, $operationId);
        }
        $showService = $this->container->get('sns_show_service');
        $em = $this->getDoctrine()->getManager(); //添加click事物
        $em->getConnection()->beginTransaction();        
        try {
            $opids = explode(',', $operationId);
            $createTime = $this->getTimestamp();
            foreach ($opids as $oid) {
                if (empty($oid)) {
                    continue;
                }
                $operation = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OperationActivity')->findOneBy(array('activityId'=>$oid));
                if (empty($operation)) {
                    return $this->renderJsonFailed(Errors::$DESIGN_ERROR_NO_DATA);
                }  
                if (!empty($isnotify) && $isnotify != $operation->getIsnotify()) {
                    $operation->setIsnotify($isnotify);
                }
                if (isset($region) && $region != $operation->getRegion()) {
                    $operation->setRegion($region);
                    $this->_initOperationCount($operation,$showService);
                }
                if (isset($industry) && $industry != $operation->getIndustry()) {
                    $operation->setIndustry($industry);
                    $this->_initOperationCount($operation,$showService);
                }
                if (isset($func) && $func != $operation->getFunc()) {
                    $operation->setFunc($func);
                    $this->_initOperationCount($operation,$showService);
                }
                if (!empty($image)) {
                    $operation->setImage($image);
                }
                if (!empty($title) && $func != $operation->getTitle()) {
                    $operation->setTitle($title);
                }
                if (!empty($content) && $content != $operation->getContent()) {
                    $operation->setContent($content);
                }
                if (isset($starttime) && $starttime != $operation->getStartTime()) {
                    $operation->setStartTime(intval($starttime));
                    $this->_initOperationCount($operation,$showService);
                }
                if (isset($endtime) && $endtime != $operation->getEndTime()) {
                    $operation->setEndTime(intval($endtime));
                    $this->_initOperationCount($operation,$showService);
                }
                if (!empty($status) && $status != $operation->getstatus()) {
                    $operation->setStatus($status);
                    //  = 1 如果重新发布
                    if (1 == $status) {
                        // $operation->setPushStatus(1);
                        $push_time = $operation->getPushTime();
                        if ($createTime >= $push_time) {
                            $push_time = $createTime;
                        }
                        $operation->setNextPushTime($push_time);
                        $operation->setIsget(1);
                    }
                }
                if (!empty($isloop) && $isloop != $operation->getIsloop()) {
                    $operation->setIsloop($isloop);
                }
                if (!empty($pushtime) ) {
                    $operation->setPushTime($pushtime);
                    $operation->setNextPushTime($pushtime);
                }
                if (!empty($isback) && $isback != $operation->getIsback()) {
                    $operation->setIsback($isback);
                    if (2 == $isback) {
                        /**
                         * 撤回 需要状态修改为保存未推送
                         * 需要改为未推送
                         */
                        $operation->setStatus(3);
                        // $operation->setPushStatus(1);
                        $push_time = $operation->getPushTime();
                        if ($createTime >= $push_time) {
                            $push_time = $createTime;
                        }
                        $operation->setNextPushTime($push_time);
                        $operation->setIsget(1);
                    }
                }
                if (!empty($url)) {
                    $url = str_replace('$', $activityId,$url);
                    $operation->setUrl($url);
                }
                $oldIsnotify = $operation->getIsnotify();
                $oldImage    = $operation->getImage();
                $isnotify    = empty($isnotify)?$oldIsnotify:$isnotify;
                $image       = empty($image)?$oldImage:$image; 
                if ( !empty($isnotify) && ( !empty($title) || !empty($content) )) {
                    $json_image = $image;
                    $json_image = $image;             
                    //去除[[....]]图片格式             
                    if (!empty($content)) {
                        $preg    = '/\[\[.*?\]\]/i';
                        $content = preg_replace($preg, '', $content);
                        // 去除html标签
                        $content = $this->strip_tags($content);
                        $content = addslashes($content);
                    }
                    $jsonArr = array(
                        'messagetype'=>231,
                        'params'=>array(
                            'id'       =>$oid,
                            'title'    =>$title,
                            'content'  =>$content,
                            'createdtime'=>$createTime,
                            'image'    =>$json_image,
                            'type'     =>'active',
                            'url'      => $url,
                            'isnotify' => $isnotify,
                        ),
                    );
                    $jsonData = json_encode($jsonArr,JSON_UNESCAPED_UNICODE);
                    $operation->setJsonData($jsonData);
                }
                if (isset($weburl) && $weburl != $operation->getWeburl()) {
                    $operation->setWeburl($weburl);
                }
                if (isset($admin) && $admin != $operation->getAdmin()) {
                    $operation->setAdmin($admin);
                }
                if (isset($groups) && $groups != $operation->getGroups()) {
                    $operation->setGroups($groups);
                }
                $em->persist($operation);
                $em->flush();
            }     
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }

    public function _initOperationCount($obj,$service)
    {
        $obj->setClickCount(0);
        $obj->setShareCount(0);
        $obj->setShareCount(0);
        $obj->setShareUserCount(0);
        $obj->setPushCount(0);
        /**
         * 清除用户分享记录log
         */
        $activityid = $obj->getActivityId();
        $service->delUserShare($activityid);
        return true;
    }
    /**
     * 个人分享或者分享
     */
    protected function clickShareOperation($request)
    {
        $accountId   = $this->accountId;
        $operationId = $this->strip_tags($request->get('activityid'));
        $clickType   = $this->strip_tags($request->get('clicktype'));
        if (empty($operationId)) {
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        }
        $operObj = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:OperationActivity')->findOneBy(array('activityId'=>$operationId));
        if (empty($operObj)) {
            return $this->renderJsonFailed(Errors::$DESIGN_ERROR_NO_DATA);
        }
        if (empty($clickType)) {
            $clickType = 'click';
        }
        if (!in_array($clickType, array('click','share'))) {
            $clickType = 'click';
        }
        $em = $this->getDoctrine()->getManager(); //添加click事物
        $em->getConnection()->beginTransaction();  
        try {
            if ('click' == $clickType) {
                $operObj->setClickCount($operObj->getClickCount()+1);
            }else{
                $time = $this->getTimestamp();
                $operObj->setShareCount($operObj->getShareCount()+1);
                $showService = $this->container->get('sns_show_service');
                $res = $showService->checkUserShare(array('userId'=>$accountId,'activityId'=>$operationId),$time);
                if ($res) {
                    $operObj->setShareUserCount($operObj->getShareUserCount()+1);
                }
            }
            $em->flush();
            $em->getConnection()->commit();
            return $this->renderJsonSuccess();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            throw $ex;
        }
    }
    public function getAction($act){
        switch ($act) {
            case 'adminlog':
                return $this->getadminlog();
                break;
            case 'theme':
                return $this->_gettheme();
                break;
            case 'popularcard':                                
                return $this->_getPopularCard();
                break;
            case 'popularcardnews':
                return $this->_getPopularCardNew();
                break;
            case 'popularcategory':                                
                return $this->_getPopularCategory();
                break;
            case 'popularhttp':
                return $this->_getPopularHttp();
                break;
            case 'customerfriend':
                return $this->_getCustomerFriends();
                break;
            case 'getcustomer':
                return $this->_getCustomer();
                break;
            case 'getcategory':
                return $this->_getCategory();
                break;
            case 'getredeemcode':
                return $this->_getRedeemCode();         //获取兑换码组列表
                break;
            case 'redeemcodeuselist':
                return $this->_RedeemCodeUseList();     //获取兑换码使用消费列表
                break;
            case 'rechargerules':
                return $this->_getRechargeRules();     //获取会员充值、名片扩充规则
                break;
            case 'getpromotion':
                return $this->_getpromotion();     //获取用户推广
                break;
            case 'getbetasuser':
                return $this->_getBetasUser();     //获取用户推广
                break;
            case 'operation':
                return $this->_getOperation();     //获取活动
                break;
            case 'getcity':
                return $this->_getCity();     //获取城市
                break;
            case 'getprovince':
                return $this->_getProvince();     //获取省
                break;
            case 'agreement':           
                return $this->_getHtmlContent();          //获取静态页面内容管理列表
                break;
            case 'appprice':           
                return $this->_getAppPrice();          //获取静态页面内容管理列表
                break;
            case 'getgivelist':           
                return $this->_getOrangeGiveList();          //获取橙子赠送时长列表
                break;
            case 'version':           
                return $this->_getAppVersionList();          //获取静态页面内容管理列表
                break;
            case 'unionpay':           
                return $this->_getAppUnionpayList();        //获取银联app下载地址管理
                break;
            case 'orapaybank':           
                return $this->_getOraPayBankList();         //获取orapaybank列表
                break;
            default:
                return $this->renderJsonFailed( Errors::$ERROR_PARAMETER_NOT_ENOUGH );
                break;
        }
    }
    /**
     * 获取orapaybank银行列表
     */
    public function _getOraPayBankList(){
//        $this->checkAccount();
//        if($this->accountType != self::ACCOUNT_ADMIN){
//            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
//        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'a.id' ,  'w'=>' AND a.id=:id'),
                'name'          => array('mapdb' =>'a.name'),
                'debitcard'     => array('mapdb' =>'a.debit_card'),
                'debitcardcity' => array('mapdb' =>'a.debit_card_city'),
                'creditcard'    => array('mapdb' =>'a.credit_card'),
                'creditcardcity'=> array('mapdb' =>'a.credit_card_city'),
                'logo'      => array('mapdb' =>'a.logo'),
                'sorting'   => array('mapdb' =>'a.sorting' , 'w'=>' AND a.sorting=:sorting'),
                'createdtime'   => array('mapdb' =>'a.created_time','w'=>'Range'),
                'customer'      => array('mapdb' =>'a.customer'),
            ),
            'sql'   => "SELECT %s FROM orange_paybank as a %s%s",
            'where' => '',
            'order' => ' ORDER BY a.sorting DESC,a.id ASC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,name,debitcard,debitcardcity,creditcard,creditcardcity,logo,sorting,createdtime,customer',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 获取银联app下载地址管理
     */
    public function _getAppUnionpayList(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'a.id'),
                'unionpaynum'   => array('mapdb' =>'a.unionpay_num'),
                'ios'           => array('mapdb' =>'a.ios_unionpay'),
                'android'       => array('mapdb' =>'a.android_unionpay'),
                'createtime'    => array('mapdb' =>'a.create_time')
            ),
            'sql'   => "SELECT %s FROM sys_unionpay as a %s%s",
            'where' => '',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,unionpaynum,ios,android,createtime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    public function _getAppVersionList(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'a.id' ,  'w'=>' AND a.id=:id'),
                'version'       => array('mapdb' =>'a.version' ,  'w'=>' AND a.version like :version'),
                'devicetype'    => array('mapdb' =>'a.device_type' ,  'w'=>' AND a.device_type=:devicetype'),
                'url'           => array('mapdb' =>'a.version_url'),
                'isios'         => array('mapdb' =>'a.is_ios'),
                'unionpaynum'   => array('mapdb' =>'a.unionpay_num'),
                'isupdate'      => array('mapdb' =>'a.is_update'),
                'updateprompt'  => array('mapdb' =>'a.update_prompt'),
                'upbutton'      => array('mapdb' =>'a.upbutton'),
                'noupbutton'    => array('mapdb' =>'a.noupbutton'),
                'updatetime'    => array('mapdb' =>'a.update_time' ,'w'=>'Range'),
                'updatelog'     => array('mapdb' =>'a.update_log')
            ),
            'sql'   => "SELECT %s FROM sys_version as a %s%s",
            'where' => 'a.isdelete != 1',
            'order' => ' ORDER BY a.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,version,devicetype,url,isios,unionpaynum,isupdate,updateprompt,upbutton,noupbutton,updatetime,updatelog',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 获取橙子赠送时长列表
     */
    public function _getOrangeGiveList(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'a.id' ,  'w'=>' AND a.id=:id'),
                'accountid'     => array('mapdb' =>'a.user_id' ,  'w'=>' AND a.user_id=:accountid'),
                'mobile'        => array('mapdb' =>'b.mobile' ,  'w'=>' AND b.mobile=:mobile'),
                'orauuid'       => array('mapdb' =>'o.orauuid' ,  'w'=>' AND o.orauuid=:orauuid'),
                'phoneuuid'     => array('mapdb' =>'o.phoneuuid' ,  'w'=>' AND o.phoneuuid=:phoneuuid'),
                'module'        => array('mapdb' =>'o.module' ,  'w'=>' AND o.module=:module'),
                'bingtime'      => array('mapdb' =>'o.created_time' ,'w'=>'Range'),
                'giveday'       => array('mapdb' =>'a.note')
            ),
            'sql'   => "SELECT %s FROM account_basic_member_log as a
                        LEFT JOIN account_basic as b ON a.user_id = b.user_id
                        LEFT JOIN account_basic_bingorange as o ON a.bing_id = o.id %s%s",
            'where' => 'a.type = 3',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,accountid,mobile,orauuid,phoneuuid,module,bingtime,giveday',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /**
     * 获取APP价格列表
     */
    public function _getAppPrice(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'o.id' ,  'w'=>' AND o.id=:id'),
                'type'       => array('mapdb' =>'o.type' ,  'w'=>' AND o.type=:type'),
                'title'       => array('mapdb' =>'o.title' ,  'w'=>' AND o.title=:title'),
                'equitytime'   => array('mapdb' =>'o.equity_time'),
                'equitycapacity'      => array('mapdb' =>'o.equity_capacity'),
                'price'      => array('mapdb' =>'o.price'),
                'appid'      => array('mapdb' =>'o.appid'),
                'info'      => array('mapdb' =>'o.info'),
                'createdtime'   => array('mapdb' =>'o.created_time' ,'w'=>'Range'),
                'modifytime'    => array('mapdb' =>'o.modified_time' ,'w'=>'Range')
            ),
            'sql'   => "SELECT %s FROM oradt_recharge_app_price as o %s%s",
            'where' => 'o.status =1',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,type,title,equitytime,equitycapacity,price,appid,info,createdtime,modifytime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /** 
     * 获取静态页面内容管理列表
     */
    public function _getHtmlContent(){
//        $this->checkAccount();
//        if($this->accountType != self::ACCOUNT_ADMIN){
//            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
//        }
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'o.id' ,  'w'=>' AND o.id=:id'),
                'key'       => array('mapdb' =>'o.name' ,  'w'=>' AND o.name=:key'),
                'content'   => array('mapdb' =>'o.content',),
                'name'      => array('mapdb' =>'e.real_name',),
                'createdtime'   => array('mapdb' =>'o.created_time' ,'w'=>'Range'),
                'modifytime'    => array('mapdb' =>'o.modify_time' ,'w'=>'Range')
            ),
            'sql'   => "SELECT %s FROM oradt_agreement as o LEFT JOIN account_employee as e on o.admin_id = e.empl_id %s%s",
            'where' => '',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,key,content,name,createdtime,modifytime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /** 
     * 获取省
     */
    private function _getProvince()
    {
        $sqldata = array(
            'fields' => array(
                'provincecode'       => array('mapdb' =>'p.province_code' ,  'w'=>' AND p.province_code IN (%s)'),
                'province'       => array('mapdb' =>'p.province' ,  'w'=>' AND p.province=:province'),
            ),
            'sql'   => "SELECT  %s FROM (SELECT * FROM `province_city_code` GROUP BY province_code) as p %s%s",
            'where' => '',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'provincecode,province',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /*
    * 获取城市
    * */
    private function _getCity()
    {
        $sqldata = array(
            'fields' => array(
                'countrycode'        => array('mapdb' =>'country_code' ,  'w'=>' AND country_code=:countrycode'),
                'country'       => array('mapdb' =>'country' ,  'w'=>' AND country=country'),
                'provincecode'       => array('mapdb' =>'province_code' ,  'w'=>' AND province_code IN (%s)'),
                'province'       => array('mapdb' =>'province' ,  'w'=>' AND province=:province'),
                'prefecturecode'       => array('mapdb' =>'prefecture_code' ,  'w'=>' AND prefecture_code IN (%s)'),
                'city'       => array('mapdb' =>'city' ,  'w'=>' AND city=:city'),
                'capital'       => array('mapdb' =>'capital' ,  'w'=>' AND capital=:capital'),
            ),
            'sql'   => "SELECT  %s FROM `province_city_code` %s%s",
            'where' => '',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'countrycode,country,provincecode,province,prefecturecode,city,capital',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /*
     * getbeates
     * */
    private function _getBetasUser(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'userid'        => array('mapdb' =>'a.user_id' ,  'w'=>' AND a.user_id=:userid '),
                'realname'       => array('mapdb' =>'a.real_name' ,  'w'=>' AND a.real_name=:realname '),
                'mobile'       => array('mapdb' =>'b.mobile' ,  'w'=>' AND b.mobile = :mobile '),
                'commentnum'   => array('mapdb' =>'c.commentnum'),

            ),
            'sql'   => "SELECT  %s FROM `account_basic_detail`  as a
                        LEFT JOIN account_basic as b on a.user_id = b.user_id
                        LEFT JOIN (
                            SELECT d.user_id,count(e.id) as commentnum FROM account_basic_detail as d 
                            LEFT JOIN sns_qa_comment as e ON d.user_id = e.from_uid  WHERE d.reg_type = 3 GROUP BY d.user_id
                        ) as c ON a.user_id = c.user_id
                        %s%s",
            'where' => ' a.reg_type=3',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'userid,realname,mobile,commentnum',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list' , 'callable_data_betas');
        return $this->renderJsonSuccess($data);
    }

    protected function callable_data_betas($item)
    {
        if (isset($item ['userid']) && !empty ($item ['userid'])) {
            $sql="SELECT count(id) as num FROM sns_qa_comment WHERE from_uid=:userid";
            $commentnum = $this->getConnection()->executeQuery($sql,array("userid"=>$item['userid']))->fetchColumn();
            $item['commentnum']=$commentnum;
        }
        return $item;
    }

    /*
     * 获取用户推广
     * */

    private function _getpromotion(){
        // $this->checkAccount();
        // if($this->accountType != self::ACCOUNT_ADMIN){
        //     return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        // }
        $sqldata = array(
            'fields' => array(
                'id'         => array('mapdb' =>'a.id','w'=>' AND a.id IN (%s) '),
                'proid'      => array('mapdb' =>'a.pro_id','w'=>' AND a.pro_id IN (%s) '),
                'isalluser'  => array('mapdb' =>'a.isalluser','w'=>' AND a.isalluser = :isalluser'),
                'type'       => array('mapdb' =>'a.type','w'=>' AND a.type = :type'),
                'title'      => array('mapdb' =>'a.title'),
                'content'    => array('mapdb' =>'a.content' ,  'w'=>' AND a.content like :content'),
                'status'     => array('mapdb' =>'a.status','w'=>' AND a.status in (%s)'),
                'pushtime'   => array('mapdb' =>'a.push_time' , 'w'=>'Range'),
                'adminid'    => array('mapdb' =>'a.admin_id'),
                'region'     => array('mapdb' =>'a.region'),
                'industry'   => array('mapdb' =>'a.industry'),
                'func'       => array('mapdb' =>'a.func'),
                'url'        => array('mapdb' =>'a.url'),
                'jsondata'   => array('mapdb' =>'a.json_data'),
                'name'       => array('mapdb' =>'b.real_name','w'=>' AND b.real_name = :name'),
                'isntice'    => array('mapdb' =>'a.isntice','w'=>' AND a.isntice = :isntice'),
                'isloop'     => array('mapdb' =>'a.isloop','w'=>' AND a.isloop = :isloop'),
                'starttime'  => array('mapdb' =>'a.start_time','w'=>' AND a.start_time = :starttime'),
                'endtime'    => array('mapdb' =>'a.end_time','w'=>' AND a.end_time = :endtime'),
                'pushcount'  => array('mapdb' =>'a.push_count'),
                'pushstatus' => array('mapdb' =>'a.push_status','w'=>' AND a.push_status = :pushstatus '),
            ),
            'sql'   => "SELECT  %s FROM `sys_user_promotion` as a 
                        LEFT JOIN account_employee as b on a.admin_id = b.empl_id
                        %s%s",
            'where' => '',
            'order' => ' ORDER BY id ASC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,proid,isalluser,type,title,content,status,pushtime,adminid,region,industry,func,name,isntice,url,jsondata,isloop,starttime,endtime,pushcount,pushstatus',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list' , 'callable_data_promotion');
        return $this->renderJsonSuccess($data);
    }
    protected function callable_data_promotion($item)
    {
        // if (isset($item ['adminid']) && !empty ($item ['adminid'])) {
        //    $sql="SELECT real_name FROM account_employee WHERE empl_id=:adminid";
        //    $name = $this->getConnection()->executeQuery($sql,array("adminid"=>$item['adminid']))->fetchColumn();
        //    $item['name']=$name;
        // }    
        return $item;
    }

    /**
     * 获取会员扩充、名片容量规则
     */
    private function _getRechargeRules(){
        $this->checkAccount();
        if($this->accountType != self::ACCOUNT_BASIC){
            return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        }
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'a.id'),          
                'num'       => array('mapdb' =>'a.equity_time'),
                'price'     => array('mapdb' =>'a.price'),
                'appid'     => array('mapdb' =>'a.appid'),
                'title'     => array('mapdb' =>'a.title'),
                'info'     => array('mapdb' =>'a.info'),
            ),
            'sql'   => "SELECT  %s FROM `oradt_recharge_app_price` AS a %s%s",
            'where' => ' type = 2 AND status =1',  //读取会员权益 且正常显示的
            'order' => ' ORDER BY a.id ASC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,num,price,appid,title,info',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','rules_data');
        return $this->renderJsonSuccess($data);
    }
    public function rules_data($item){
        $item['type'] = 1;  //默认type =1 为了和上一版本oradt_recharge_rules表 对应返回该值
        return $item;
    }

    /**
     * 获取兑换码使用消费列表
     */
    private function _RedeemCodeUseList(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType == self::ACCOUNT_BIZ){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        if($this->accountType == self::ACCOUNT_BASIC){
            $where  = " g.account_id = '{$this->accountId}'";
        }else{
            //是否获取全部 1 获取全部兑换码  默认 只返回 已发送出去的兑换码
            $isall  = (int)$this->strip_tags($request->get('isall'));   
            if(!empty($isall) && $isall == '1'){
                $where  = "";
            }else{
                $where  = " g.use_account_id != ''";
            }
        }
        $sqldata = array(
            'fields' => array(
                'id'            => array('mapdb' =>'g.id'),
                'groupid'       => array('mapdb' =>'g.group_id', 'w'=>' AND g.group_id = :groupid'),
                'redeemcode'    => array('mapdb' =>'g.redeem_code', 'w'=>' AND g.redeem_code = :redeemcode'),
                'accountid'     => array('mapdb' =>'g.account_id', 'w'=>' AND g.account_id = :accountid'),
                'mobile'        => array('mapdb' =>'a.mobile', 'w'=>' AND a.mobile = :mobile'),
                'name'          => array('mapdb' =>'d.real_name','w'=>' AND d.real_name LIKE :name'),
                'status'        => array('mapdb' =>'g.status','w'=>' AND g.status = :status'),
                'releasetime'   => array('mapdb' =>'g.release_time','w'=>'Range'),
                'usetime'       => array('mapdb' =>'g.use_time','w'=>'Range'),
                'startime'      => array('mapdb' =>'g.start_time'),
                'endtime'       => array('mapdb' =>'g.end_time'),
                'length'        => array('mapdb' =>'c.exchange_length'),
                'stock'         => array('mapdb' =>'c.exchange_stock'),
                'usemobile'     => array('mapdb' =>'g.use_account','w'=>' AND g.use_account = :usemobile'),
                'usename'       => array('mapdb' =>'g.use_name','w'=>' AND g.use_name = :usename'),
            ),
            'sql'   => 'SELECT %s FROM oradt_redeem_code as g
                        LEFT JOIN oradt_redeem_code_group as c ON g.group_id = c.id
                        LEFT JOIN account_basic as a ON g.account_id = a.user_id
                        LEFT JOIN account_basic_detail as d ON g.account_id = d.user_id %s%s',
            'where' => ''.$where,
            'order' => ' ORDER BY g.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,groupid,redeemcode,accountid,mobile,name,status,releasetime,usetime,startime,endtime,length,stock,usemobile,usename',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }
    
    /**
     * 获取兑换码组列表
     */
    private function _getRedeemCode(){
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        
        $sqldata = array(
            'fields' => array(
                'id'        => array('mapdb' =>'g.id', 'w'=>' AND g.id = :id'),
                'name'      => array('mapdb' =>'g.name', 'w'=>' AND g.name = :name'),
                'length'    => array('mapdb' =>'g.exchange_length', 'w'=>' AND g.exchange_length !=0'),
                'stock'     => array('mapdb' =>'g.exchange_stock', 'w'=>' AND g.exchange_stock !=0'),
                'adminname' => array('mapdb' =>'e.real_name', 'w'=>' AND e.real_name =:adminname'),
                'createdtime' => array('mapdb' =>'g.created_time','w'=>'Range'),
                'num'       => array('mapdb' =>'g.num'),
                'leavenum'  => array('mapdb' =>'g.leave_num'),
                'startime'  => array('mapdb' =>'g.start_time','w'=>'Range'),
                'endtime'   => array('mapdb' =>'g.end_time','w'=>'Range'),
                'status'    => array('mapdb' =>'g.status'),
                'addnum'    => array('mapdb' =>'g.add_num'),
                'createnum'    => array('mapdb' =>'g.create_num'),
            ),
            'sql'   => 'SELECT %s FROM oradt_redeem_code_group as g
                        LEFT JOIN account_employee as e ON g.admin_id = e.empl_id %s%s',
            'where' => '',
            'order' => ' ORDER BY g.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,name,length,stock,adminname,createdtime,num,leavenum,startime,endtime,status,addnum,createnum',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list');
        return $this->renderJsonSuccess($data);
    }

    /**
     * 获得主题列表
     * @param 
     * @return array()
     * @author xinggm
     * @date 2016-1-7
     */

    private function _gettheme()
    {
        $this->checkAccount();
        if($this->accountType == self::ACCOUNT_BIZ)  return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
        $userId  = $this->accountId;
        $sqldata = array(
            'fields' => array(
                'id'         => array('mapdb' =>'a.id',  'w'=>' AND a.id = :id'),
                'userid'     => array('mapdb' =>'a.author',  'w'=>' AND a.author = :userid'),                
                'name'       => array('mapdb' =>'a.name',  'w'=>' AND a.name LIKE :name'),
                'author'     => array('mapdb' =>'a.author',  'w'=>' AND a.author LIKE :author'),
                'content'    => array('mapdb' =>'a.content',  'w'=>' AND a.content LIKE :content'),
                'version'    => array('mapdb' =>'a.version','w'=>' AND a.version = :version'),
                'url'        => array('mapdb' =>'a.url','w'=>' AND a.url = :url'),
                'size'       => array('mapdb' =>'a.size', 'w'=>"Range"),
                'unit'       => array('mapdb' =>'a.unit'),
                'type'       => array('mapdb' =>'a.type',  'w'=>' AND a.type = :type'),
                'createtime' => array('mapdb' =>'a.create_time','w'=>'Range'),
                'realname'   => array('mapdb' =>'b.real_name',  'w'=>' AND b.real_name LIKE :realname'),
            ),
            'sql'   => "SELECT  %s FROM `account_theme` AS a  LEFT JOIN `account_employee` as b on a.account_id = b.empl_id  %s%s",
            'where' => '',
            'order' => ' ORDER BY a.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,userid,name,content,version,size,url,createtime,unit,realname,author,type',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_url');
        return $this->renderJsonSuccess($data);
    }

    protected function callable_url($item)
    {
        if (isset($item ['url']) && ! empty ( $item ['url'] )) {
            $docroot        = $this->container->getParameter('DOC_ROOT');            
            if( false !== stripos( $item['url'], 'https://' ) ){
                $oldResPath   = $item['url'];
                $extension    = strrpos($oldResPath,'.');
                $fileExten    = substr($oldResPath, $extension);   
                $rand       = new RandomString();             
                $filename     = $rand->make(10) . date('YmdHis') . $fileExten;                
                $content      = file_get_contents($oldResPath);
                if (!@file_put_contents($filename, $content)) $item['md5'] = '';
                if (is_file($filename)) {
                    $item['md5'] = md5_file($filename);
                    unlink($filename);
                }else{
                    $item['md5'] = '';
                }
            }else{
                $oldResPath   = $docroot . $item['url'];
                $item ['url'] = $this->container->getParameter('HOST_URL').'/resources0/'.$item ['url'];
                if (is_file($oldResPath) && file_exists($oldResPath)) {
                    $item['md5'] = md5_file($oldResPath);
                }else{
                    $item['md5'] = '';
                }
            }                
        }
        return $item;
    }
    /*
     * @getadminlog   获取后台管理操作日志。
     * **/
    public function getadminlog(){
        $this->checkAccount();
        if($this->accountType !== self::ACCOUNT_ADMIN)  return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);

        $sqldata = array
        (
            'fields' => array(
                'userName'=>array('mapdb'=>'real_name','w'=>' AND real_name like :userName'),
                'id'=>array('mapdb'=>'id','w'=>' AND id = :id'),
                'time'=>array('mapdb'=>'time','w'=>'Range'),
                'modelName'=>array('mapdb'=>'model_name','w'=>' AND model_name IN (%s)'),
                'type'=>array('mapdb'=>'type', 'w'=>' AND type like :type'),
                'status'=>array('mapdb'=>'status', 'w'=>' AND status like :status'),
                'userId'=>array('mapdb'=>'user_id'),
                'content'=>array('mapdb'=>'content'),
                'wrtype'=>array('mapdb'=>'wrtype','w'=>' AND wrtype like :wrtype'),
                'loginIp'=>array('mapdb'=>'login_ip','w'=>' AND login_ip like :loginIp'),
            ),
            'sql' =>'SELECT %s FROM `admin_action_log` %s%s',
            'where' => '',
            'order' => ' ORDER BY id DESC',
            'default_dataparam' => array(),
            'provide_max_fields'=>'id,userName,time,modelName,userId,loginIp,type,status,content,wrtype'
        );

        $check = $this->parseSql ( $sqldata );

        if (true !== $check)
        {
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list' );
        return $this->renderJsonSuccess($data);

    }

    /*
     * @adminlog  后台操作的 add  del
     * *
     * */
    public  function adminlog(){
        $request = $this->getRequest();
        $this->checkAccount();
        $action = $this->strip_tags($request->get('action'));
        if(empty($action))  return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        if($this->accountType !== self::ACCOUNT_ADMIN )
        return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);

        if("add" == $action){
                return $this->addadminlog($request);
        }else if("delete" == $action){
                 return $this->deladminlog($request);
        }else{
            return $this->renderJsonFailed(Errors:: $HTTP_STATUS_CODE_404);
        }
    }

    /*
     *  @addadminlog  添加后台管理记录
     * */
    public function addadminlog($re){
            $userId = $this->strip_tags($re->get('userId'));
            $userName = $this->strip_tags(($re->get('userName')));
            $modelName = $this->strip_tags(($re->get('modelName'))); //模块名字
            $type = $this->strip_tags(($re->get('type')));//文件操作类型
            $loginIp = $this->strip_tags(($re->get('loginIp')));
            $content = $this->strip_tags(($re->get('content'))); //操作记录
            $wrtype = $this->strip_tags(($re->get('wrtype')));//读写类型
            $status = intval($re->get('status'));


            if(empty($userId) || empty($userName) ||empty($modelName) ||empty($type) ||empty($loginIp))
           // return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
             return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);

            if((empty($content) && !empty($wrtype)) || (!empty($content) && empty($wrtype)))
            return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);

            $time = $this->getTimestamp();
            $sql = "insert into `admin_action_log` (user_id,real_name,model_name,type,time,login_ip,status,content,wrtype) values ";
            $sql .="(:userId,:userName,:modelName,:type,:time,:loginIp,:status,:content,:wrtype)";
            $this->getConnection()->executeQuery($sql,array(':userId'=>$userId,':userName'=>$userName,':modelName'=>$modelName,':type'=>$type,':time'=>$time,':loginIp'=>$loginIp,':status'=>$status,':content'=>$content,':wrtype'=>$wrtype));
            $insertId = $this->getConnection()->lastInsertId();
            if($insertId >0){
                return $this->renderJsonSuccess($insertId);
            }else{
                return $this->renderJsonFailed(Errors::$OAUTH_ERROR_UNKNOWN);
            }
    }

    /*
     * @deladminlog 删除后台管理日志
     * */
    public function deladminlog($re){
        $id =trim($re->get("id"),',');
        if(empty($id))  return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
        if(strpos($id,',')){
            $arrId =explode(',',$id);
            foreach($arrId as $id){
                $id = intval($id);
                $sql = "delete from `admin_action_log` where id =:id";
                $this->getConnection()->executeQuery($sql,array(':id'=>$id));
            }
            return $this->renderJsonSuccess();
        }else{
            $id = intval($id);
            $sql = "delete from `admin_action_log` where id =:id";
            $this->getConnection()->executeQuery($sql,array(':id'=>$id));
            return $this->renderJsonSuccess();
        }
    }
    /**
     * 获得资讯采集
     */
    private function _getPopularCardOld()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType == self::ACCOUNT_BIZ){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' =>'a.id' ,'w'=>' AND a.id = :id'),
                'userid'      => array('mapdb' =>'a.user_id' ,'w'=>' AND a.user_id = :userid'),
                'uuid'        => array('mapdb' =>'a.uuid' ,'w'=>' AND a.uuid = :uuid'),
                'mobile'      => array('mapdb' =>'a.mobile' ,'w'=>' AND a.mobile = :mobile'),
                'populartime' => array('mapdb' =>'a.popular_time' ,'w'=>'Range'),
                'realname'    => array('mapdb' =>'b.real_name' ,'w'=>' AND b.real_name LIKE :realname'),
                'popularflag'    => array('mapdb' =>'b.popular_flag' ,'w'=>' AND b.popular_flag IN (%s)'),
                'picture'     	  => array('mapdb' =>'c.picture' ),
                'respath'     	  => array('mapdb' =>'d.res_path' ),
                'smallpath'         => array('mapdb' =>'e.small_path')
            ),
            'sql'   => 'SELECT %s FROM `popular_card` AS a 
						LEFT JOIN account_basic_detail as b ON a.user_id = b.user_id
           				LEFT JOIN contact_card as c ON a.uuid = c.uuid
						LEFT JOIN contact_card_extend as d ON a.uuid = d.uuid
						LEFT JOIN contact_card_extend_detail as e ON a.uuid = e.uuid
                		    %s%s',
            'where' => '',
            'order' => ' ORDER BY a.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,userid,uuid,mobile,populartime,realname,popularflag,picture,respath,smallpath',
        );
		$popularflag = $request->get('popularflag');
		//$categoryid = $request->get('categoryid');
		if($popularflag == null){
			$sqldata['sql'] = 'SELECT %s FROM `popular_card` AS a 
						LEFT JOIN account_basic_detail as b ON a.user_id = b.user_id
           				LEFT JOIN contact_card as c ON a.uuid = c.uuid
						LEFT JOIN contact_card_extend as d ON a.uuid = d.uuid
						LEFT JOIN contact_card_extend_detail as e ON a.uuid = e.uuid
						LEFT JOIN scan_card_vcardinfo_category as f ON a.uuid = f.card_id
                		    %s%s';
            $sqldata['provide_max_fields'] = 'id,userid,uuid,mobile,populartime,realname,popularflag,picture,respath,smallpath,categoryid';
            $sqldata['fields']['categoryid'] = array('mapdb' =>'f.category_id','w'=>' AND f.category_id = :categoryid');
		}
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        //try{
        $data = $this->getData ( $sqldata, 'list');
        //}catch(\Exception $ex){echo $ex;}
        return $this->renderJsonSuccess($data);
    }

    /**
     * 获得推广列表
     * @date 2016-3-24
     Some trables in here.Like:mobile repeat / time out and so on.
     */
    private function _getPopularCard()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        if($this->accountType == self::ACCOUNT_BIZ){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        } 
        $categoryid  = $this->strip_tags($request->get('categoryid'));
        if (isset($categoryid) && !empty($categoryid)) {
            $sql = 'SELECT %s FROM 
                        (SELECT ac.id,ac.fuser_id,ac.user_id,ac.mobile,ac.popular_time,ac.name,ac.popular_type,ac.card_id from 
                        ( SELECT min(id) as id FROM`account_communicate` group by mobile) as aa 
                        inner JOIN account_communicate 
                        as ac  on aa.id = ac.id) AS a
                        -- (SELECT ac.id,ac.fuser_id,ac.user_id,ac.mobile,ac.popular_time,ac.name,ac.popular_type,ac.card_id from `account_communicate` as ac group by mobile order by id desc) AS a 
                        LEFT JOIN contact_card as c ON a.card_id = c.uuid
                        LEFT JOIN contact_card_extend as d ON a.card_id = d.uuid
                        LEFT JOIN contact_card_extend_detail as e ON a.card_id = e.uuid
                        LEFT JOIN scan_card_vcardinfo_category as f ON a.card_id = f.card_id 
                            %s%s';
        }else{
            $sql = 'SELECT %s FROM 
                        (SELECT ac.id,ac.fuser_id,ac.user_id,ac.mobile,ac.popular_time,ac.name,ac.popular_type,ac.card_id from 
                        ( SELECT min(id) as id FROM`account_communicate` group by mobile) as aa 
                        inner JOIN account_communicate 
                        as ac  on aa.id = ac.id) AS a 
                        -- (SELECT ac.id,ac.fuser_id,ac.user_id,ac.mobile,ac.popular_time,ac.name,ac.popular_type,ac.card_id from `account_communicate` as ac group by mobile order by id desc) AS a 
                        LEFT JOIN contact_card as c ON a.card_id = c.uuid
                        LEFT JOIN contact_card_extend as d ON a.card_id = d.uuid
                        LEFT JOIN contact_card_extend_detail as e ON a.card_id = e.uuid
                            %s%s';
        }
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' =>'a.id' ,'w'=>' AND a.id = :id'),
                'userid'      => array('mapdb' =>'a.user_id' ,'w'=>' AND a.user_id = :userid'),
                'uuid'        => array('mapdb' =>'a.card_id' ,'w'=>' AND a.uuid = :uuid'),
                'mobile'      => array('mapdb' =>'a.mobile' ,'w'=>' AND a.mobile = :mobile'),
                'populartime' => array('mapdb' =>'a.popular_time' ,'w'=>'Range'),
                'realname'    => array('mapdb' =>'a.name' ,'w'=>' AND a.name LIKE :realname'),
                'popularflag' => array('mapdb' =>'a.popular_type' ,'w'=>' AND popular_type IN (%s)'),
                'cardid'      => array('mapdb' =>'a.card_id' ),
                'picture'     => array('mapdb' =>'c.picture' ),
                'respath'     => array('mapdb' =>'d.res_path' ),
                'smallpath'   => array('mapdb' =>'e.small_path'),
                
            ),
            'sql'   => $sql,
            'where' => ' LENGTH(a.fuser_id) < 10 AND LENGTH(a.card_id) > 10 AND a.popular_type IN (1,2)',
            'order' => ' ORDER BY a.id DESC',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,userid,uuid,mobile,populartime,realname,popularflag,picture,respath,smallpath,cardid',
        );
        if ('13003' == $categoryid) {
            $sqldata['fields']['categoryid'] = array('mapdb' =>"CASE WHEN LENGTH(f.category_id)>0 THEN f.category_id ELSE '' END",'w'=>' AND f.category_id = :categoryid');
            $sqldata['provide_max_fields']   = $sqldata['provide_max_fields'].',categoryid';
            $sqldata['where'] = $sqldata['where']." AND a.popular_type = '1' AND f.category_id IS NULL OR f.category_id = '13003' ";
        }else{
            if (!empty($categoryid) && isset($categoryid)) {
                $sqldata['fields']['categoryid'] = array('mapdb' =>'f.category_id','w'=>' AND f.category_id = :categoryid');
                $sqldata['provide_max_fields']   = $sqldata['provide_max_fields'].',categoryid';
            }            
        }        
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }

        //try{
        $data = $this->getData ( $sqldata, 'list' ,'callable_data');
        //}catch(\Exception $ex){echo $ex;}
        return $this->renderJsonSuccess($data);
    }
    /**
     * 需要返回推广接口
     */
    public function _getPopularHttp()
    {
        $http = $this->container->getParameter('SMS_POPULAR_CODE');
        $data = array(
            'http'=>$http,
            );
        return $this->renderJsonSuccess($data);
    }
    /**
     * 处理回显参数信息
     */
    protected function callable_data($item){
        if (isset($item ['respath']) && ! empty ( $item ['respath'] )) {
            $item ['respath'] = $this->getCommondUrl($item ['respath']);
        }
        if (isset($item ['smallpath']) && ! empty ( $item ['smallpath'] )) {
            $item ['smallpath'] = $this->getCommondUrl($item ['smallpath']);
        }
        if (isset($item ['picture']) && ! empty ( $item ['picture'] )) {
            $item ['picture'] = $this->getCommondUrl($item ['picture']);
        }
        if (isset($item ['avatarpath']) && ! empty ( $item ['avatarpath'] )) {
            $item ['avatarpath'] = $this->getCommondUrl($item ['avatarpath']);
        }
        return $item;
    }
    /**
     * 获得资讯采集
     */
    private function _getPopularCategory()
    {
        $this->checkAccount();          //通过accessToken获取用户的信息
        $request = $this->getRequest();
        // if($this->accountType == self::ACCOUNT_BIZ){
        //     return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        // }
        $sqldata = array(
            'fields' => array(
                'id'         => array('mapdb' =>'a.id' ,'w'=>' AND a.id = :id'),
                'categoryid'         => array('mapdb' =>'a.category_id','w'=>' AND a.category_id = :categoryid'),
                'parentid'         => array('mapdb' =>'a.parent_id','w'=>' AND a.parent_id = :parentid'),
                'name'         => array('mapdb' =>'a.name','w'=>' AND a.name = :name'),
                'code'         => array('mapdb' =>'a.code')
            ),
            'sql'   => 'SELECT %s FROM `hr_job_category` as a %s%s',
            'where' => ' AND LENGTH(a.parent_id) > 1 ',
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,categoryid,parentid,name,code',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        //try{
        $data = $this->getData ( $sqldata, 'list');
        //}catch(\Exception $ex){echo $ex;}
        return $this->renderJsonSuccess($data);
    }
    /**
     * @param  $userid string 后台id
     * @param  
     * @return $data array()
     */
    public function _getCustomerFriends()
    {
        $this->checkAccount();
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userid = $this->accountId;
        $imid   = intval($request->get('imid'));
        $where = '';
        if (!empty($imid)) {
            $imidInfo = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:AccountBasicDetail')->findOneBy(array('imid'=>$imid));
            $fuserid  = $imid;
            if (!empty($imidInfo)) {
                $fuserid = $imidInfo->getUserId();                
            }
            $where   = " AND a.fuser_id = '".$fuserid."' ";
        }
        /**
          判断是否有绑定的客服虚拟账户
         */
        $customer = $this->getDoctrine()->getManager()->getRepository ( 'OradtStoreBundle:AccountBasicCustomer' )->findOneBy ( array ('adminId' => $userid ) );
        if (!empty($customer)) {
            $customerid = $customer->getUserId();
            $sqldata = array(
                'fields' => array(
                    'id'         => array('mapdb' =>'a.id','w'=>' AND a.id = :id'),
                    'userid'     => array('mapdb' =>'a.user_id','w'=>' AND a.user_id = :userid'),
                    'fuserid'    => array('mapdb' =>'a.fuser_id','w'=>' AND a.fuser_id = :fuserid'),
                    'mobile'     => array('mapdb' =>'a.fmobile','w'=>' AND a.fmobile = :mobile'),
                    'name'       => array('mapdb' =>'a.fusername','w'=>'AND a.fusername=:name'),
                    // 'avatarpath' => array('mapdb' =>'b.avatar_path'),
                    // 'imid'       => array('mapdb' =>'b.imid','w'=>' AND b.imid = :imid'),
                ),
                'sql'   => 'SELECT %s FROM `account_friend` as a %s%s',
                'where' => " AND a.user_id = '$customerid' ".$where,
                'order' => '',
                'default_dataparam' => array(),
                'provide_max_fields' => 'id,userid,fuserid,mobile,name',
            );
            $check = $this->parseSql ( $sqldata );
            if (true !== $check){
                return $this->renderJsonFailed ( $check );
            }

            $data = $this->getData ( $sqldata, 'list','callable_data');
            if (0!= $data['numfound'] && empty($imid)) {
                foreach ($data['list'] as $key => &$value) {
                    $userInfo = $this->getDoctrine()->getRepository ( 'OradtStoreBundle:AccountBasicDetail')->findOneBy(array('userId'=>$value['fuserid']));
                    if (!empty($userInfo)) {
                        if (empty($value['name'])) {
                            $value['name'] = $userInfo->getRealName();
                        }
                        $value['avatarpath'] = $this->getCommondUrl($userInfo->getAvatarPath());
                        $value['imid']       = $userInfo->getImid();
                    }else{
                        $value['avatarpath'] = '';
                        $value['imid']       = '';
                    }                    
                }
            }
            if (!empty($imid) && !empty($imidInfo) && 0!=$data['numfound']) {
                if (empty($data['list'][0]['name'])) {
                    $data['list'][0]['name'] = $imidInfo->getRealName();
                }
                $data['list'][0]['avatarpath']=$this->getCommondUrl($imidInfo->getAvatarPath());
                $data['list'][0]['imid']      = $imid;
            }
            return $this->renderJsonSuccess($data);
        }else{
            return $this->renderJsonFailed("No binding customer service");
        }
    }
    /**
     * @param 
     * @return $data array() 绑定的虚拟账号
     */
    public function _getCustomer()
    {
        $this->checkAccount();
        $request = $this->getRequest();
        if($this->accountType !== self::ACCOUNT_ADMIN){
            return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        }
        $userid = $this->accountId;
        $sqldata = array(
            'fields' => array(
                'userid'     => array('mapdb' =>'a.user_id','w'=>' AND a.user_id = :userid'),
                'mobile'     => array('mapdb' =>'b.mobile','w'=>' AND b.mobile = :mobile'),
                'name'       => array('mapdb' =>'a.real_name'),
                'avatarpath' => array('mapdb' =>'a.avatar_path'),
                'imid'       => array('mapdb' =>'a.imid'),
                'passwd'     => array('mapdb' =>'b.password'),
                'bintime'    => array('mapdb' =>'c.bintime')
            ),
            'sql'   => 'SELECT %s FROM account_basic_customer as c
                        LEFT JOIN account_basic as b  on c.user_id = b.user_id
                        LEFT JOIN account_basic_detail as a on c.user_id = a.user_id
                         %s%s',
            'where' => " AND c.admin_id = '$userid' ",
            'order' => '',
            'default_dataparam' => array(),
            'provide_max_fields' => 'userid,mobile,name,avatarpath,imid,passwd,bintime',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_data');
        return $this->renderJsonSuccess($data);
    }

    /**
     * 个人|资讯获得行业信息
     */
    public function _getCategory()
    {
        $request = $this->getRequest();
        $resType = $request->get('restype');
        if (1 == $resType) {
            return $this->_getAdminCategory();
        }else{
            $this->checkAccount();
            switch ($this->accountType) {
                case self::ACCOUNT_BASIC:
                    return $this->_getBasicCategory();
                    break;
                default:
                    return $this->_getAdminCategory();
                    break;
            }
        }            
    }
    public function _getBasicCategory()
    {
        $sql  = "SELECT category_id as categoryid,parent_id as parentid,name FROM account_basic_category where status = 1 AND type = 1";
        $res  = $this->getConnection()->executeQuery($sql)->fetchAll();
        $pArr = $cArr = array();
        $num  = 0;
        if (!empty($res)) {
            foreach ($res as $val) {
                if ('0' == $val['parentid']) {
                    $pArr[] = $val;
                }else{
                    $cArr[] = $val;
                }
            }
            foreach ($pArr as $k => $v) {
                $child = array();                
                foreach ($cArr as $key => $value) {    
                    if ($value['parentid'] == $v['categoryid']) {
                        $child[] = $value;
                    }
                }
                if (!empty($child)) {
                    $pArr[$k]['child'] = array_splice($child, 0,20);
                }
            }
            $num = count($pArr);
        }
        return $this->renderJsonSuccess(array('numfound'=>$num,'list'=>$pArr));
    }   
    public function _getAdminCategory()
    {
        $status = $this->strip_tags($this->getRequest()->get('status'));
        if (3 == $status) {
            $where = '';
        }else{
            $where = " a.status <> 3 ";
        }
        $sqldata = array(
            'fields' => array(
                'id'         => array('mapdb' =>'a.id','w'=>' AND a.id IN (%s) '),
                'categoryid' => array('mapdb' =>'a.category_id','w'=>' AND a.category_id IN (%s) '),
                'parentid'   => array('mapdb' =>'a.parent_id','w'=>' AND a.parent_id = :parentid'),
                'name'       => array('mapdb' =>'a.name','w'=>' AND a.name LIKE :name'),
                'createtime' => array('mapdb' =>'a.create_time','w'=>'Range'),
                'modifytime' => array('mapdb' =>'a.modify_time','w'=>'Range'),
                'status'     => array('mapdb' =>'a.status','w'=>' AND a.status = :status'),
                'sorting'    => array('mapdb' =>'a.sorting'),
                'type'       => array('mapdb' =>'a.type' ,'w'=>' AND a.type = :type'),
                'key'        => array('mapdb' =>'a.keyword','w'=>' AND a.keyword LIKE :key')
            ),
            'sql'   => 'SELECT %s FROM account_basic_category as a
                         %s%s',
            'where' => $where,
            'order' => " ORDER BY createtime desc ",
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,categoryid,parentid,name,createtime,modifytime,status,sorting,key,type',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_data');
        return $this->renderJsonSuccess($data);
    }
    /**
     * 获取活动
     */
    public function _getOperation()
    {
        // $this->checkAccount();
        // $request = $this->getRequest();
        // if($this->accountType == self::ACCOUNT_BIZ){
        //     return $this->renderJsonFailed( Errors::$ERROR_INVALID_ACCESS );
        // }
        $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' =>'a.id','w'=>' AND a.id = :id'),
                'activityid' => array('mapdb' =>'a.activity_id','w'=>' AND a.activity_id = :activityid'),
                // 'type'        => array('mapdb' =>'a.type','w'=>' AND a.type = :type'),
                'isnotify'    => array('mapdb' =>'a.isnotify','w'=>' AND a.isnotify = :isnotify'),
                'pushstatus'  => array('mapdb' =>'a.push_status','w'=>' AND a.push_status = :pushstatus'),
                'region'      => array('mapdb' =>'a.region'),
                'industry'    => array('mapdb' =>'a.industry'),
                'func'        => array('mapdb' =>'a.func'),
                'image'       => array('mapdb' =>'a.image'),
                'title'       => array('mapdb' =>'a.title','w'=>' AND a.title LIKE :title'),
                'content'     => array('mapdb' =>'a.content','w'=>' AND a.content LIKE :content'),
                'userid'      => array('mapdb' =>'a.user_id','w'=>' AND a.user_id = :userid'),
                'status'      => array('mapdb' =>'a.status','w'=>' AND a.status IN (%s) '),
                'clickcount'  => array('mapdb' =>'a.click_count','w'=>' AND a.click_count = :clickcount'),
                'sharecount'  => array('mapdb' =>'a.share_count','w'=>' AND a.share_count = :sharecount'),
                'usercount'   => array('mapdb' =>'a.share_user_count','w'=>' AND a.share_user_count = :usercount'),
                'pushcount'   => array('mapdb' =>'a.push_count','w'=>' AND a.push_count = :pushcount'),
                'createtime'  => array('mapdb' =>'a.created_time','w'=>'Range'),
                'modifytime'  => array('mapdb' =>'a.modify_time','w'=>'Range'),
                'starttime'   => array('mapdb' =>'a.start_time','w'=>'Range'),
                'endtime'     => array('mapdb' =>'a.end_time','w'=>'Range'),
                'name'        => array('mapdb' =>'b.real_name','w'=>' AND b.real_name = :name '),//管理员名称
                'url'         => array('mapdb' =>'a.url'),
                'jsondata'    => array('mapdb' =>'a.json_data'),
                'isloop'      => array('mapdb' =>'a.isloop','w'=>' AND a.isloop = :isloop'),
                'isback'      => array('mapdb' =>'a.isback','w'=>' AND a.isback = :isback'),
                'pushtime'    => array('mapdb' =>'a.push_time','w'=>'Range'),
                'weburl'      => array('mapdb' =>'a.weburl'),
                'admin'       => array('mapdb' =>'a.admin','w'=>' AND a.admin = :admin'),
                'groups'      => array('mapdb' =>'a.groups','w'=>' AND a.groups = :groups'),
            ),
            'sql'   => 'SELECT %s FROM operation_activity as a
                        LEFT JOIN account_employee as b on a.user_id = b.empl_id
                         %s%s',
            'where' => "",
            'order' => " ORDER BY a.created_time desc ",
            'default_dataparam' => array(),
            'provide_max_fields' => 'id,activityid,isnotify,pushstatus,region,industry,func,image,title,content,userid,status,clickcount,sharecount,usercount,pushcount,createtime,modifytime,starttime,endtime,name,url,jsondata,isback,isloop,pushtime,weburl,admin,groups',
        );
        $check = $this->parseSql ( $sqldata );
        if (true !== $check){
            return $this->renderJsonFailed ( $check );
        }
        $data = $this->getData ( $sqldata, 'list','callable_data');
        return $this->renderJsonSuccess($data);
    }
}

