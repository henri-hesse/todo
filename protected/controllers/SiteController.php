<?php

class SiteController extends CController {
	/**
	 * Executed on every request.
	 */
	public function init() {
		parent::init();
				
		// Register site CSS file
		$cs = Yii::app()->clientscript;
		$cs->registerCssFile(Yii::app()->baseUrl.'/css/site.css');
	}
	
	/**
	 * Redirects guests to the login page and logged in users to the "todos" page.
	 */
	public function actionIndex() {
		if( Yii::app()->user->isGuest===true )
			$this->actionLogin();
		else
			$this->redirect(array('todo/index'));
	}
	
	/**
	 * Handles both login and register forms.
	 */
	public function actionLogin() {
		// If user is already logged in, go to "todos" page
		if( Yii::app()->user->isGuest===false )
			$this->redirect(array('todo/index'));
		
		$loginModel = new LoginForm();
		$registerModel = new RegisterForm();
		
		// Check if login data is present & login if so
		if( isset($_POST['LoginForm'])===true ) {
			// Populate login model with post data.
			$loginModel->attributes = $_POST['LoginForm'];
			
			// validate user input and redirect to the todo page
			if( $loginModel->validate()===true && $this->login($_POST['LoginForm'])===true )
				$this->redirect(array('todo/index'));
		}
		
		// Check if register data is present & register a new user if so.
		if( isset($_POST['RegisterForm'])===true ) {
			// Populate register model with post data.
			$registerModel->attributes = $_POST['RegisterForm'];
			
			// Validate the model & create a new user if the validation was ok.
			if( $registerModel->validate()===true ) {
				$user = new User();
				// User can be populated with the register form's post data since the
				// attribute names match together.
				$user->attributes = $_POST['RegisterForm'];
				
				// Save the user & login. Then redirect to the "todos" page.
				if( $user->save()===true && $this->login($_POST['RegisterForm'])===true )
					$this->redirect(array('todo/index'));
			}
		}
		
		// Render the login page.
		$this->render('login', array(
			'loginModel'=>$loginModel,
			'registerModel'=>$registerModel,
		));
	}
	
	/**
	 * Logs out the current user and redirect to login page.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('site/login'));
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		$error=Yii::app()->errorHandler->error;
		
		if($error) {
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * Logs in the user using the given username and password.
	 * @param $attributes Array key-value array of username and password.
	 * @return boolean whether login is successful.
	 */
	private function login($attributes) {
		// Check that username & password keys are set.
		if( isset($attributes['username'])===false || isset($attributes['password'])===false )
			throw new CHttpException(500, 'Invalid request');
		
		// Create identity
		$identity = new UserIdentity($attributes['username'], $attributes['password']);
		$identity->authenticate();
		
		// Login if no errors.
		if( $identity->errorCode===UserIdentity::ERROR_NONE ) {
			// Login for 30 days
			Yii::app()->user->login($identity, 3600*24*30);
			return true;
		}
		else
			return false;
	}
}