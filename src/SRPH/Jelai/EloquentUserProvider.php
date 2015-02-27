<?php namespace SRPH\Jelai\Auth;

class EloquentUserProvider implements UserProviderInterface {

	/**
	 * hasher implementation
	 *
	 * @var Core\hasher\HashingInterface;
	 */
	protected $hasher;

	/**
	 * Eloquent model
	 *
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;

	/** 
	 * @param Core\Auth\HashingInterface $hasher
	 * @param {object} $model
	 */
	public function __construct($hasher, $model)
	{
		$this->hasher = $hasher;
		$this->model = $model;
	}

	/**
	 * Retrieve user by its unique identifier
	 *
	 * @param Eloquent\Model
	 */
	public function retrieveByUniqueIdentifier($identifier)
	{
		return $this->createModel()->newQuery()->find($identifier);
	}

	/**
	 * Retrieve user by the provided credentials
	 *
	 * @param Eloquent\Model
	 */
	public function retrieveByCredentials(array $credentials)
	{
		$model = $this->createModel()->newQuery();

		foreach($credentials as $key => $value)
		{
			if ( strpos($key, 'password') === false ) $model->where($key, $value);
		}

		return $model->first();
	}

	/**
	 * Retrieve user by the provided credentials
	 *
	 * @param UserInterface $user User class
	 * @param array $credentials Provided input
	 */
	public function validateCredentials($user, array $credentials)
	{
		$password = $credentials['password'];

		return $this->hasher->check($password, $user->getAuthPassword());
	}

	/**
	 * Create a new instance of the Eloquent model
	 *
	 * @return Eloquent\Model
	 */
	protected function createModel()
	{
		$class = '\\' . ltrim($this->model, '\\');

		return new $class;
	}
	
}
