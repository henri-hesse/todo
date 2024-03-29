<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$params = array(':username' => strtolower($this->username));
		$user = User::model()->find('LOWER(username)=:username', $params);
		
		// No user with the specified username.
		if( $user===null )
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		
		// Wrong password.
		else if( $user->validatePassword($this->password)===false )
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		
		// Success.
		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
		
		return ( $this->errorCode==self::ERROR_NONE );
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->_id;
	}
}