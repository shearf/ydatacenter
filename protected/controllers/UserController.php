<?php

class UserController extends Controller
{
	
	private $_identifity;
	
	public function init()
	{
		$this->leftMenu = array(
			array('label' => '个人信息', 'url' => array('/user/view', 'id' => Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest, ),
			array('label' => '登出', 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest, 'visible' => !Yii::app()->user->isGuest,),
			array( 'label' => '登陆','url' => array('/user/login'),'visible' => Yii::app()->user->isGuest, 'visible' => Yii::app()->user->isGuest,),
			array('label' => '注册', 'url' => array('/user/register'), 'visible' => Yii::app()->user->isGuest, 'visible' => Yii::app()->user->isGuest,),
		);
		
		//$this->breadcrumbs['用户中心'] = array('url' => array('/user/view', array('id' => Yii::app()->user->id)));
	}
	
	public function actionIndex()
	{
		if (Yii::app()->user->getId())
			$this->redirect(array('view', 'id' => Yii::app()->user->getId()));
		else 
			$this->redirect(array('login'));
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			
		);
	}
	
	public function actionRegister()
	{
		$model = new User('register');
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate())
			{
				$model->salt = $model->generateSalt();
				$model->password = $model->hashPassword($model->pass, $model->salt);
				$model->registertime = time();
				$model->status = User::USER_DISABLED;
				if($model->save()) {
					$this->_identifity = new UserIdentity($model->username, $model->pass);
					$this->_identifity->authenticate();
					Yii::app()->user->login($this->_identifity);
					$this->redirect(array('view', 'id' => Yii::app()->user->id));
				}
			}
		}
		
		$this->render('register',array('model'=>$model));
	}
	
	public function actionView($id)
	{
		$this->layout = 'column1';
		
		$model = new User;
		if(isset($id) && $id > 0)
		{
			$userinfo = $model->findByPk(intval($id));
			$this->render('view', array('userinfo' => $userinfo));
		}
		
	}
	
	public function actionLogin()
	{
		$model=new User('login');

		// if it is ajax validation request
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/
		// collect user input data
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
					
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				$this->_identifity = new UserIdentity($model->username, $model->password);
				$this->_identifity->authenticate();
				switch ($this->_identifity->errorCode)
				{
					case UserIdentity::ERROR_NONE:
						
						Yii::app()->user->login($this->_identifity);
						Yii::app()->user->setState('logintime',time());
						$this->redirect(array('/user/view', 'id' => Yii::app()->user->id));
						break;
					case UserIdentity::ERROR_PASSWORD_INVALID:
						Yii::app()->user->setFlash('result', array('type' => 'error', 'msg' => '密码错误！'));
						break;
						
					case UserIdentity::ERROR_USERNAME_INVALID:
						Yii::app()->user->setFlash('result', array('type' => 'error', 'msg' => '用户不存在！'));
						break;
				}
				$this->refresh();
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));	
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

}