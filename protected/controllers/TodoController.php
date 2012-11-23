<?php

class TodoController extends CController {
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Displays the index page
	 */
	public function actionIndex() {
		// Register todo CSS file
		$cs = Yii::app()->clientscript;
		$cs->registerCssFile(Yii::app()->baseUrl.'/css/todo.css');
		
		// Register angularJS framework with resource module
		$cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js');
		$cs->registerScriptFile('http://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular-resource.min.js');
		
		// Register todo controller & service JS files
		$cs->registerScriptFile(Yii::app()->baseUrl.'/js/todoService.js');
		$cs->registerScriptFile(Yii::app()->baseUrl.'/js/todo.js');

		// Render
		$this->render('index');
	}

	/**
	 * Finds all user's todos. See js/todoService.js
	 * 
	 * @throws CHttpException
	 */
	public function actionQuery() {
		if( Yii::app()->request->isAjaxRequest===false )
			throw new CHttpException(500, 'Invalid request');
				
		$todoList = Todo::model()->findAll();

		echo CJSON::encode($todoList);
		Yii::app()->end();
	}

	/**
	 * Saves a single todo. See js/todoService.js
	 * 
	 * @throws CHttpException
	 */
	public function actionSave() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isPostRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		// AngularJS's raw post data needs to be decoded.
		$attributes = CJSON::decode(file_get_contents("php://input"));
		
		// Find an already existing todo if id is set. Create a new one otherwise.
		if( isset($attributes['id'])===true )
			$todo = Todo::model()->findByPk($attributes['id']);
		else
			$todo = new Todo();
		
		if( ($todo instanceof Todo)===false )
			throw new CHttpException(500, 'Invalid request');
		
		// Populate todo with new data
		$todo->attributes = $attributes;
		// User is the currently logged in user.
		$todo->userId = Yii::app()->user->id;
		
		if( $todo->save()===false )
			throw new CHttpException(500, 'Invalid request');
		
		echo CJSON::encode($todo);
		Yii::app()->end();
	}
	
	/**
	 * Saves many todos. See js/todoService.js
	 * 
	 * @throws CHttpException
	 */
	public function actionSaveAll() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isPostRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		// AngularJS's raw post data needs to be decoded.
		$attributesList = CJSON::decode(file_get_contents("php://input"));
		// Index flat attributes list so that every attribute set is indexed by it's id.
		$indexedAttributesList = $this->getIndexedAttributesList($attributesList);
		
		$todoList = Todo::model()->findAllByPk( array_keys($indexedAttributesList) );
		
		if( is_array($todoList)===false || count($todoList)<1 )
			throw new CHttpException(500, 'Invalid request');
		
		// Saves all todos individually. Should be done in a single query for better
		// performance.
		foreach( $todoList as $todo ) {
			// We do not support todo creation in this action.
			if( isset($indexedAttributesList[$todo->id]['id'])===false )
				throw new CHttpException(500, 'Invalid request');			
			
			// Populate todo with new data
			$todo->attributes = $indexedAttributesList[$todo->id];
			// User is the currently logged in user.
			$todo->userId = Yii::app()->user->id;
			
			if( $todo->save()===false )
				throw new CHttpException(500, 'Invalid request');			
		}

		echo CJSON::encode($todoList);
		Yii::app()->end();
	}
	
	/**
	 * Deleted many todos. See js/todoService.js
	 * 
	 * @throws CHttpException
	 */
	public function actionDeleteAll() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isDeleteRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		// AngularJS's raw post data needs to be decoded.
		$attributesList = CJSON::decode(file_get_contents("php://input"));
		// Index flat attributes list so that every attribute set is indexed by it's id.
		$indexedAttributesList = $this->getIndexedAttributesList($attributesList);
		
		// Do the actual removing.
		$params = array(':userId'=>Yii::app()->user->id);
		$numRowsRemoved = Todo::model()->deleteByPk(array_keys($indexedAttributesList), 'userId=:userId', $params);
		if( $numRowsRemoved<1 )
			throw new CHttpException(500, 'Invalid request');
		
		Yii::app()->end();
	}
	
	/**
	 * // Index flat attributes list so that every attribute set is indexed by it's id.
	 * 
	 * @param Array $attributesList
	 * @return Array Indexed attribute set list.
	 * @throws CHttpException
	 */
	private function getIndexedAttributesList($attributesList) {
		$indexedAttributesList = array();
		foreach( $attributesList as $attributes )
			// Add attributes to the indexed list.
			$indexedAttributesList[ (int)$attributes['id'] ] = $attributes;
		
		return $indexedAttributesList;
	}
}