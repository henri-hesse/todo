<?php

class TodoController extends CController {
	/**
	 * Displays the index page
	 */
	public function actionIndex() {		
		// Change default page title
		$this->pageTitle = 'Todos';
		
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

	public function actionQuery() {
		if( Yii::app()->request->isAjaxRequest===false )
			throw new CHttpException(500, 'Invalid request');
				
		$todoList = Todo::model()->findAll();

		echo CJSON::encode($todoList);
		Yii::app()->end();
	}

	public function actionSave() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isPostRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		$attributes = CJSON::decode(file_get_contents("php://input"));
		
		if( isset($attributes['id'])===true )
			$todo = Todo::model()->findByPk($attributes['id']);
		else
			$todo = new Todo();
		
		if( ($todo instanceof Todo)===false )
			throw new CHttpException(500, 'Invalid request');
		
		$todo->attributes = $attributes;
		
		if( $todo->save()===false )
			throw new CHttpException(500, 'Invalid request');
		
		echo CJSON::encode($todo);
		Yii::app()->end();
	}
	
	public function actionSaveAll() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isPostRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		$attributesList = CJSON::decode(file_get_contents("php://input"));
		$indexedAttributesList = $this->getIndexedAttributesList($attributesList);
		
		$todoList = Todo::model()->findAllByPk( array_keys($indexedAttributesList) );
		
		if( is_array($todoList)===false || count($todoList)<1 )
			throw new CHttpException(500, 'Invalid request');
		
		foreach( $todoList as $todo ) {
			$todo->attributes = $indexedAttributesList[$todo->id];
			
			if( $todo->save()===false )
				throw new CHttpException(500, 'Invalid request');			
		}

		echo CJSON::encode($todoList);
		Yii::app()->end();
	}
		
	public function actionDeleteAll() {
		$request = Yii::app()->request;
		
		if( $request->isAjaxRequest===false || $request->isDeleteRequest===false )
			throw new CHttpException(500, 'Invalid request');
		
		$attributesList = CJSON::decode(file_get_contents("php://input"));
		$indexedAttributesList = $this->getIndexedAttributesList($attributesList);
		
		$numRowsRemoved = Todo::model()->deleteByPk( array_keys($indexedAttributesList) );
		if( $numRowsRemoved<1 )
			throw new CHttpException(500, 'Invalid request');
		
		Yii::app()->end();
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
	
	private function getIndexedAttributesList($attributesList) {
		$indexedAttributesList = array();
		foreach( $attributesList as $attributes ) {
			// We do not support todo creation in this action.
			if( isset($attributes['id'])===false )
				throw new CHttpException(500, 'Invalid request');
			
			// Add attributes to the indexed list.
			$indexedAttributesList[ (int)$attributes['id'] ] = $attributes;
		}
		
		return $indexedAttributesList;
	}
}