<?php

class Todo extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Todo':
	 * @var integer $id
	 * @var string $text
	 * @var boolean $done
	 */
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Todo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, done', 'required'),
			array('text', 'length', 'max'=>128),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'text' => 'Todo content',
			'done' => 'Done',
		);
	}
}