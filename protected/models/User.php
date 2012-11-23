<?php

class User extends CActiveRecord {
	/**
	 * The followings are the available columns in table 'User':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
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
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>128),
			array('password', 'length', 'min'=>5),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'Id',
			'username' => 'Username',
			'password' => 'Password',
		);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password) {
		return $this->hashPassword($password)===$this->password;
	}
	
	public function hashPassword($password) {
		return md5($password);
	}
	
	/**
	 * See parent::afterFind()
	 * 
	 * @return Boolean
	 */
	public function afterFind() {
		// Encode username for security reasons.
		$this->username = CHtml::encode($this->username);
		
		return parent::afterFind();
	}
	
	/**
	 * See parent::afterSave()
	 * 
	 * @return Boolean
	 */
	public function afterSave() {
		// Encode username for security reasons.
		$this->username = CHtml::encode($this->username);
		
		return parent::afterSave();
	}
	
	/**
	 * See parent::beforeSave()
	 * 
	 * @return Boolean
	 */
	public function beforeSave() {
		// Hash password before saving
		$this->password = $this->hashPassword($this->password);
		// Decode username
		$this->username = CHtml::decode($this->username);
		
		return parent::beforeSave();
	}
}