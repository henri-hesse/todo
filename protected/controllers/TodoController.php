<?php

class TodoController extends CController {
	/**
	 * Displays the index page
	 */
	public function actionIndex() {
		// Change default page title
		$this->pageTitle = 'Todos';

		$cs = Yii::app()->clientscript;
		// Register todo CSS file
		$cs->registerCssFile(Yii::app()->baseUrl.'/css/todo.css');
		// Register todo controller & resources JS files
		$cs->registerScriptFile(Yii::app()->baseUrl.'/js/todoController.js');

		// Render
		$this->render('index');
	}

	public function actionQuery() {
		$todoList = Todo::model()->findAll();

		echo CJSON::encode($todoList);
		Yii::app()->end();
	}

	public function actionSave() {
		if( Yii::app()->request->isAjaxRequest ) {
			
		}
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
}