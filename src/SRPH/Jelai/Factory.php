<?php namespace SRPH\Jelai\Auth;

use SRPH\Jelai\Session\SessionInterface;

class Factory {

	/**
	 * @var User data
	 */
	protected $user = null;

	/**
	 * @var Core\Auth\UserProvider
	 */
	protected $provider;

	/**
	 * @var Core\Session\SessionInterface
	 */
	protected $session;

	/**
	 * Authentication key in the Session Bag
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * @param Core\Auth\UserProviderInterface $provider Provider to use
	 * @param Core\Session\SessionInterface $session Session implementation
	 * @param {string} Key of authentication on the session collection
	 */
	public function __construct(UserProviderInterface $provider, SessionInterface $session, $key)
	{
		$this->provider = $provider;
		$this->session = $session;
		$this->key = $key;
	}

	/**
	 * Attempt to authenticate a user based on the provided credentials
	 *
	 * @param array $credentials
	 * @
	 */
	public function attempt(array $credentials, $login = true)
	{
		$user = $this->provider->retrieveByCredentials($credentials);

		if ( $this->hasValidCredentials($user, $credentials) )
		{
			$this->login($user);

			return true;
		}

		return false;
	}

	/**
	 * Checks if the user has valid credentials
	 *
	 * @param $user Our `user` model
	 * @param array $credentials Provided user input
	 */
	protected function hasValidCredentials($user, array $credentials)
	{
		return !is_null($user) && $this->provider->validateCredentials($user, $credentials);
	}

	/**
	 * Login the provided user credentials
	 *
	 * @param Core\Auth\UserInterface $user User to be authenticated
	 * @return void
	 */
	public function login(UserInterface $user)
	{
		$this->session->set($this->key, $user->getAuthIdentifier());
		$this->user = $user;
	}

	/**
	 * Logs out the authenticated user
	 *
	 * @return void
	 */
	public function logout()
	{
		// We delete the set session key and cached user that
		// no unexpected behavior occurs.
		$this->session->forget($this->key);
		$this->user = null;
	}

	/**
	 * Checks if a user is authenticated.
	 *
	 * @return boolean
	 */
	public function check()
	{
		return !is_null($this->user());
	}

	/**
	 * Checks if a user is guest.
	 * Simply calls `$this->check()` and falsifies its value
	 *
	 * @see $this->check()
	 * @return boolean
	 */
	public function guest()
	{
		return !$this->check();
	}

	/**
	 * Retrieves the user data.
	 *
	 * @return mixed(object|null)
	 */
	public function user()
	{
		// First, we check if our $user property is null (this indicates that
		// we have not yet fetched the user). If so, we retrieve the user if session
		// does not exist; otherwise, return null. And then, cache it to our
		// $user property so following calls won't execute any further queries.
		if ( is_null($this->user) )
		{
			// Simply return null if session does not exist
			if ( !$this->session->has($this->key) ) return null;

			$key = $this->session->get($this->key);
			return $this->user = $this->provider->retrieveByUniqueIdentifier($key);;
		}

		return $this->user;
	}

}
