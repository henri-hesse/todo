<?php

class Todo extends CActiveRecord {
	/**
	 * The followings are the available columns in table 'Todo':
	 * @var integer $id
	 * @var integer $userId
	 * @var string $text
	 * @var boolean $done
	 */
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'Todo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, done', 'required'),
			array('text', 'length', 'max'=>128),
			array('done', 'in', 'range'=>array(0,1)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'Id',
			'userId' => 'User id',
			'text' => 'Todo content',
			'done' => 'Done',
		);
	}
	
	/**
	 * Restrict all find queries to deal with only the logged in user.
	 * 
	 * @return Array
	 */
	public function defaultScope()
	{
		return array(
			'condition'=>"userId='".Yii::app()->user->id."'",
		);
	}
	
	/**
	 * See parent::afterFind()
	 * 
	 * @return Boolean
	 */
	public function afterFind() {
		// Cast done to boolean so AngularJS likes it better.
		$this->done = (bool)$this->done;
		// Encode todo text content to HTML entities for security reasons.
		$this->text = CHtml::encode($this->text);
		
		return parent::afterFind();
	}
	
	/**
	 * See parent::afterSave()
	 * 
	 * @return Boolean
	 */
	public function afterSave() {
		// Cast done to boolean so AngularJS likes it better.
		$this->done = (bool)$this->done;
		// Encode todo text content to HTML entities for security reasons.
		$this->text = CHtml::encode($this->text);
		
		return parent::afterSave();
	}
	
	/**
	 * See parent::beforeValidate()
	 * 
	 * @return Boolean
	 */
	public function beforeValidate() {
		// Cast done back to integer
		$this->done = (int)$this->done;
		
		return parent::beforeValidate();
	}
	
	/**
	 * See parent::beforeSave()
	 * 
	 * @return Boolean
	 */
	public function beforeSave() {
		// Decode HTML entites back to normal string
		$this->text = CHtml::decode($this->text);
		
		return parent::beforeSave();
	}
}