<?php namespace SRPH\Jelai\Auth;

interface UserProviderInterface {

	/**
	 * Retrieve user by its unique identifier
	 */
	public function retrieveByUniqueIdentifier($identifier);

	/**
	 * Retrieve user by the provided credentials
	 *
	 * @param UserInterface $user User class
	 * @param array $credentials Provided input	 
	 */
	public function retrieveByCredentials(array $credentials);

	/**
	 * Retrieve user by the provided credentials
	 */
	public function validateCredentials($user, array $credentials);

}
