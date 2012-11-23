<?php

class RegisterForm extends CFormModel {
	public $username;
	public $password;
	public $passwordRepeat;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// All fields are required.
			array('username, password, passwordRepeat', 'required'),
			// All properties should be max 128 chars long.
			array('username, password, passwordRepeat', 'length', 'max'=>128),
			// Username needs to be unique.
			array('username', 'checkUnique'),
			// Password should be at least 5 chars long.
			array('password, passwordRepeat', 'length', 'min'=>5),
			// Password and password repeat should match
			array('password', 'compare', 'compareAttribute'=>'passwordRepeat')
		);
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'Username',
			'password'=>'Password',
			'passwordRepeat'=>'Password, again',
		);
	}
	
	/**
	 * Checks that the username does not exists in the db already
	 * This is the 'checkUnique' validator as declared in rules().
	 */
	public function checkUnique($attribute,$params) {
		$params = array(':username' => strtolower($this->username));
		if( User::model()->exists('LOWER(username)=:username', $params)===true )
			$this->addError('username', 'Username already exists in the system. Choose another one.');
	}
}
