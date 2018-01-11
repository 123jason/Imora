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
* 企业 名片
* 2017-10-25
*/
class BizCardController extends BaseController{

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
	        case 'getcardlist':
	            return $this->_getCardList();
	            break; 
	        default:
	            return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
	            break;
	    }
	}
	
	/**
	 * @todo 获取订单列表信息
	 */
	private function _getCardList()
	{
	    $this->checkAccount();
	
	      $sqldata = array(
            'fields' => array(
                'vcardid'       => array('mapdb' => 'bc.id' , 'w' => ' AND bc.id = :vcardid'),
                'bizid'         => array('mapdb' => 'bc.biz_id' , 'w' => ' AND bc.biz_id = :bizid'),
                'accountid'     => array('mapdb' => 'bc.user_id' , 'w' => ' AND bc.user_id = :accountid'),
                'accountname'   => array('mapdb' => 'em.name', 'w' => ' AND em.name LIKE :accountname'),
                'section'       => array('mapdb' => 'section' , 'w' => ' AND section = :section'),
                'vcard'         => array('mapdb' => 'bc.vcard' ),
                'remark'        => array('mapdb' => 'bc.remark' , 'w' => ' AND (bc.remark LIKE :remark)', 'or' => 1),
                'createdtime'   => array('mapdb' => 'bc.create_time' , 'w' => 'Range'),
                'modifiedtime'  => array('mapdb' => 'bc.modified_time' , 'w' => 'Range'),
                'status'        => array('mapdb' => 'bc.status', 'w' => ' AND bc.status = :status' ),
                'markpoint'     => array('mapdb' => 'bc.mark_point' ),
                'picture'       => array('mapdb' => 'bc.picture' ),
                'picpatha'      => array('mapdb' => 'bc.pic_path_a' ),
                'picpathb'      => array('mapdb' => 'bc.pic_path_b' ),
                'cardfrom'      => array('mapdb' => 'bc.card_from' ),
                'cardtype'      => array('mapdb' => 'bc.card_type' ),
                'vcardtxt'      => array('mapdb' => 'bc.vcardtxt' , 'w' => ' AND bc.vcardtxt LIKE :vcardtxt' ),
            ),
           'default_dataparam' => array(),
            'sql'   => "SELECT %s FROM `wx_biz_card` as bc %s%s",
            'order' => ' ORDER BY bc.modified_time DESC',
            'provide_max_fields' => 'vcardid,bizid,accountid,accountname,vcard,remark,modifiedtime,createdtime,status,markpoint,picture,picpatha,picpathb,cardfrom,cardtype,vcardtxt,section',
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