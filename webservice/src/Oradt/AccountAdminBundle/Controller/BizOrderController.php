<?php  
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Errors;
use Oradt\Utils\Password;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PDO;
use Oradt\Utils\Codes; 

/**
* 企业 订单
* 2017-10-25
*/
class BizOrderController extends BaseController{

	/**
	 * POST
	 */
	public function postAction($act)
	{
		switch ($act) {  
			default:
				return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
				break;
		}
	}

	/**
	 * get
	 */
	public function getAction($act)
	{
	    switch ($act) {
	        case 'getorderlist':
	            return $this->_getOrderList();
	            break; 
	        default:
	            return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
	            break;
	    }
	}
	
	/**
	 * @todo 获取订单列表信息
	 */
	private function _getOrderList()
	{
	    $this->checkAccount();
	
	     $sqldata = array(
            'fields' => array(
                'id'          => array('mapdb' => 'a.id' , 'w' => ' AND a.id = :id'),
                'ordersn'     => array('mapdb' => 'a.order_sn'),
                'bizid'     => array('mapdb' => 'a.biz_id'),
                'ordertype'     => array('mapdb' => 'a.order_type', 'w' => ' AND a.order_type = :ordertype'),
                'ordersource'    => array('mapdb' => 'a.order_source', 'w' => ' AND a.order_source = :ordersource'),
                'paystatus'        => array('mapdb' => 'a.pay_status', 'w' => ' AND a.pay_status = :paystatus'),
                'num'     => array('mapdb' => 'a.num'),
                'price'    => array('mapdb' => 'a.price'),
                'totalamount' => array('mapdb' => 'a.total_amount'),
                'payamount' => array('mapdb' => 'a.pay_amount'),
                'discountamount' => array('mapdb' => 'a.discount_amount'),
                'discountsource' => array('mapdb' => 'a.discount_source'),
                'termtime'     => array('mapdb' => 'a.term_time', 'w' => 'Range'),
                'createtime' => array('mapdb' => 'a.create_time' , 'w' => 'Range'),
                'platform'  => array('mapdb' => 'a.platform' , 'w' => ' AND a.platform = :platform'),
                'tradeno'  => array('mapdb' => 'a.trade_no' , 'w' => ' AND a.trade_no = :tradeno'),
                'paytime'  => array('mapdb' => 'a.pay_time' , 'w' => ' Range'),
                'metadata'  => array('mapdb' => 'a.metadata'),
                
            ),
            'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `wx_biz_order` as a %s%s",
            'where' => "",
            'order' => '',
            'provide_max_fields' => 'id,ordersn,bizid,ordertype,ordersource,paystatus,num,price,totalamount,payamount,discountamount,discountsource,termtime,create_time,platform,tradeno,paytime,metadata',
        ); 
        $check = $this->parseSql($sqldata); 
        if(true !== $check){
            return $this->renderJsonFailed($check);
        }
        $data = $this->getData($sqldata);
        return $this->renderJsonSuccess ( $data );
	}
 

 
}

?>