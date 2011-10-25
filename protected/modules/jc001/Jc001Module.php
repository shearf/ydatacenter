<?php

class Jc001Module extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'jc001.models.*',
			'jc001.components.*',
		));
		//加载simple_html_dom.php
		$apiPath = Yii::import('webroot.api');
		include $apiPath.'/simple_html_dom.php';
		
		Yii::app()->setComponent('fetch', array(
			'class' => Yii::getPathOfAlias('jc001.components').'/FetchJc001',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
