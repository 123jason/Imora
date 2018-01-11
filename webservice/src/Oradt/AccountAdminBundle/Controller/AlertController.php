<?php
namespace Oradt\AccountAdminBundle\Controller;
use Oradt\Utils\Codes;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\OperationAlert;

class AlertController extends BaseController
{
	public function postAction($act)
	{
		$this->accesstime = $this->getTimestamp1();

		//检查token
		$this->checkAccount();
		if ($this->accountType !== self::ACCOUNT_ADMIN)
		{
			return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
		}

		switch ($act) {
			case 'new':
				return $this->_new();
			case 'edit':
				return $this->_edit();
			case 'delete':
				return $this->_delete();
			default:
				return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
		}
	}

	public function getAction()
	{

		$this->accesstime = $this->getTimestamp1();

		//检查token
		$this->checkAccount();
		if ($this->accountType !== self::ACCOUNT_ADMIN)
		{
			return $this->renderJsonFailed(Errors::$ERROR_INVALID_ACCESS);
		}

		$where = ' a.is_delete = 0';
		$sqldata = array(
			'fields' => array(
				'id' 			=> array('mapdb' => 'a.id', 'w' => ' AND a.id = :id'),
				'alertid'		=> array('mapdb' => 'a.alert_id', 'w' => ' AND a.alert_id = :alertid'),
				'type'			=> array('mapdb' => 'a.type', 'w' => ' AND a.type = :type'),
				'isnotify'		=> array('mapdb' => 'a.isnotify', 'w' => ' AND a.isnotify = :isnotify'),
				'title'			=> array('mapdb' => 'a.title', 'w' => ' AND a.title LIKE :title'),
				'content' 		=> array('mapdb' => 'a.content', 'w' => ' AND a.content LIKE :content'),
				'alertdate'		=> array('mapdb' => 'a.alert_date', 'w' => ' AND a.alert_date = :alertdate'),
				'userid'		=> array('mapdb' => 'a.user_id', 'w' => ' AND a.user_id = :userid'),
				'createdtime'	=> array('mapdb' => 'a.created_time', 'w' => 'Range'),
				'modifytime' 	=> array('mapdb' => 'a.modify_time', 'w' => 'Range'),
				'isdelete' 		=> array('mapdb' => 'a.is_delete', 'w' => ' AND a.is_delete = :isdelete'),
			),
			'sql'	=> 'SELECT %s FROM `operation_alert` AS a %s%s',
			'where'	=> $where,
			'order' => ' ORDER BY a.id DESC',
			'default_dataparam' => array(),
			'provide_max_fields' => 'alertid,type,isnotify,title,content,alertdate,userid,createdtime,modifytime',
		);
		$check = $this->parseSql($sqldata);
		if (true !== $check) {
			return $this->renderJsonFailed($check);
		}
		$data = $this->getData($sqldata, 'list');
		return $this->renderJsonSuccess($data);
	}

	private function _new()
	{
		$request = $this->getRequest();
		// 获取参数	
		// 类型 1:短信 2:内部消息
		$type 		= $this->strip_tags($request->get('type'));			
		// 标题，type为1时有效
		// $title		= $this->strip_tags($request->get('title'));
		// 是否通知，type为2时有效，0:不通知 1:通知
		$isnotify   = $this->strip_tags($request->get('isnotify'));		
		// 正文
		$content	= $this->strip_tags($request->get('content'));
		// 日期，1:当日提醒 2:到期前7日提醒 3:到期前1个月提醒 4:到期前3个月提醒
		$alert_date = $this->strip_tags($request->get('alertdate'));

		$create_time = $this->getTimestamp();
		$randString = new RandomString();
		$alert_id = $randString->make(32);
		$user_id = $this->accountId;

		// 必要条件
		if (empty($type) || empty($alert_date) || empty($content)) 
		{
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
		}
		$type = intval($type);
		if (!in_array($type, array(1, 2))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"type($type)");
		}
		$alert_date = intval($alert_date);
		if (!in_array($alert_date, array(1, 2, 3, 4))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"alertdate($alert_date)");
		}

		if ($type === 2 && !in_array($isnotify, array(0, 1))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"isnotify($isnotify)");
		}

		$em = $this->getDoctrine()->getManager();
		try {
			$alert = $em->getRepository('OradtStoreBundle:OperationAlert')
						->findOneBy(array('type' => $type, 'alertDate' => $alert_date, 'isDelete' => 0));
		} catch (\Exception $ex) {
			throw $ex;
		}

		// 已经存在，直接返回
		if (!empty($alert)) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
		}
		$alert = new OperationAlert();
		$alert->setAlertId($alert_id);
		$alert->setType($type);
		$alert->setIsnotify(intval($isnotify));
		$alert->setContent($content);
		$alert->setAlertDate($alert_date);
		$alert->setUserId($user_id);
		$alert->setModifyTime($create_time);
		$alert->setCreatedTime($create_time);
		$alert->setIsDelete(0);

		$em->getConnection()->beginTransaction();
		try {
			$em->persist($alert);
			$em->flush();
			$em->getConnection()->commit();
			return $this->renderJsonSuccess();
		} catch (\Exception $ex) {
			$em->getConnection()->rollback();
			throw $ex;
		}
	}

	private function _edit()
	{
		$request = $this->getRequest();
		// 获取参数	
		$alert_id  	= $this->strip_tags($request->get('alertid'));
		// 类型 1:短信 2:内部消息
		$type 		= $this->strip_tags($request->get('type'));			
		// 标题，type为1时有效
		// $title		= $this->strip_tags($request->get('title'));
		// 是否通知，type为2时有效，0:不通知 1:通知
		$isnotify   = $this->strip_tags($request->get('isnotify'));		
		// 正文
		$content	= $this->strip_tags($request->get('content'));
		// 日期，1:当日提醒 2:到期前7日提醒 3:到期前1个月提醒 4:到期前3个月提醒
		$alert_date = $this->strip_tags($request->get('alertdate'));

		$modify_time = $this->getTimestamp();

		// 必要条件
		if (empty($alert_id) || empty($type) || empty($alert_date) || empty($content)) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
		}

		$type = intval($type);
		if (!in_array($type, array(1, 2))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"type($type)");
		}
		$alert_date = intval($alert_date);
		if (!in_array($alert_date, array(1, 2, 3, 4))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"alertdate($alert_date)");
		}

		if ($type === 2 && !in_array($isnotify, array(0, 1))) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_FORMAT_DYNAMIC,
				"isnotify($isnotify)");
		}

		$em = $this->getDoctrine()->getManager();
		try {
			$alert = $em->getRepository('OradtStoreBundle:OperationAlert')
						->findOneBy(array('type' => $type, 'alertDate' => $alert_date, 'isDelete' => 0));
		} catch (\Exception $ex) {
			throw $ex;
		}

		// 已经存在，直接返回
		if (!empty($alert) && $alert->getAlertId() != $alert_id) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_DATA_EXISTS);
		} else {
			return $this->_editAlert($alert_id, $type, $isnotify, $content, $alert_date);
		}
	}

	private function _editAlert($alert_id, $type, $isnotify, $content, $alert_date)
	{
		$modify_time = $this->getTimestamp();
		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->beginTransaction();
		try {
			$alert = $em->getRepository('OradtStoreBundle:OperationAlert')
						->findOneBy(array('alertId' => $alert_id));
			if (empty($alert)) {
				return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
			}

			$alert->setType($type);
			$alert->setIsnotify(intval($isnotify));
			$alert->setContent($content);
			$alert->setAlertDate($alert_date);
			$alert->setModifyTime($modify_time);
			$alert->setIsDelete(0);

			$em->persist($alert);
			$em->flush();
			$em->getConnection()->commit();
			return $this->renderJsonSuccess();
		} catch (\Exception $ex) {
			$em->getConnection()->rollback();
			throw $ex;
		}
	}

	private function _delete()
	{
		$request = $this->getRequest();
		// 获取参数	
		$alert_id = $this->strip_tags($request->get('alertid'));

		// 必要参数
		if (empty($alert_id)) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
		}

		$create_time = $this->getTimestamp();
		$user_id = $this->accountId;

		$alertids = explode(',', $alert_id);
		$em = $this->getDoctrine()->getManager();
		$em->getConnection()->beginTransaction();
		try {
			foreach ($alertids as $alertid) {

				$alert = $em->getRepository('OradtStoreBundle:OperationAlert')
							->findOneBy(array('alertId' => $alertid));
				if (empty($alert)) {
					return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_DATA);
				}

				$alert->setUserId($user_id);
				$alert->setModifyTime($create_time);
				$alert->setIsDelete(1);

				$em->flush();
			}
			$em->getConnection()->commit();
			return $this->renderJsonSuccess();
		} catch (\Exception $ex) {
			$em->getConnection()->rollback();
			throw $ex;
		}
	}

}

