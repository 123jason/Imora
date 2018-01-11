<?php
namespace Oradt\AccountAdminBundle\Controller;

use Oradt\Utils\Codes;
use Oradt\Utils\Errors;
use Oradt\Utils\RandomString;
use Oradt\OauthBundle\Controller\BaseController;
use Oradt\StoreBundle\Entity\OperationActivity;
use Oradt\StoreBundle\Entity\OperationActivityQaNews;

class ActivityController extends BaseController
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
			default:
				return $this->renderJsonFailed(Errors::$HTTP_STATUS_CODE_404);
		}
	}

	private function _new()
	{
		$request 	 = $this->getRequest();

		// 获取参数
		$type 		 = $this->strip_tags($request->get('type'));		// 类型
		$isnotify	 = $this->strip_tags($request->get('isnotify')); 	// 是否通知
		$region		 = $this->strip_tags($request->get('region')); 		// 地区(,)
		$industry	 = $this->strip_tags($request->get('industry'));	// 行业(,)
		$func 		 = $this->strip_tags($request->get('func'));		// 职能(,)
		$onlinetime  = $this->strip_tags($request->get('onlinetime')); 	// 上线时间
		$offlinetime = $this->strip_tags($request->get('offlinetime')); // 下线时间 
		$image		 = $request->files->get('image');					// 标题图片

		$type = intval($type);
		if (!in_array($type, array(1, 2))) {
			$type = 1;
		}
		$isnotify = intval($isnotify);
		if (!in_array($isnotify, array(1, 2))) {
			$isnotify = 1;
		}

		if ($type === 1) { 												// 活动
			$title 	 = $this->strip_tags($request->get('title'));		// 活动标题
			$content = $this->strip_tags($request->get('content'));		// 活动内容
			if (empty($title) || empty($content)) {
				return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
			}
		} else {														// 资讯
			$showId  = $this->strip_tags($request->get('showid'));		// 资讯id(,)
			if (empty($showId)) {
				return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
			}
		}

		// 必要条件
		if (empty($onlinetime) || empty($offlinetime)) {
			return $this->renderJsonFailed(Errors::$ERROR_PARAMETER_NOT_ENOUGH);
		}

 
		$userId		 = $this->accountId;
		$createTime  = $this->getTimestamp();
		$activity_id = new  RandomString().make(32);

		// 构造OperationActivity实体对象
		$oa = new OperationActivity();
		$oa->setActivityId($activity_id);
		$oa->setType($type);
		$oa->setIsnotify($isnotify);
		$oa->setRegion($region);
		$oa->setIndustry($industry);
		$oa->setFunc($func);
		

		return $this->renderJsonSuccess();
	}

	private function _edit()
	{
		return $this->renderJsonSuccess();
	}
}