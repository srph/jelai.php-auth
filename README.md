# jelai.php-auth

jelai.php Authentication abstraction.

## What is jelai.php?

Please see this [gist](https://gist.github.com/srph/2e2d51d46dadfdbc38e3).

## Usage

First and foremost, our authentication depends on a ```UserProvider``` implementation and ```Session``` implementation instantiate the [```Auth\Factory```](#factory) class.

\* Check the class's (```Auth\Factory```) [API](#factory).

```php
require __DIR__ . '/path/to/src/SRPH/Jelai/Auth/Factory.php';
require __DIR__ . '/path/to/src/SRPH/Jelai/Auth/EloquentUserProvider.php'; // This package provides a built-in `UserProvider` for `Eloquent`
require __DIR__ . '/path/to/src/SRPH/Jelai/Session/Factory.php';

// `EloquentUserProvider` depends on a `Hashing` and `Model` (`Eloquent`) implementation.
$hasher = new SRPH\Jelai\Hashing\MD5Hasher;

$provider = new SRPH\Jelai\Auth\EloquentUserProvider($hasher, 'User');
$session = new SRPH\Jelai\Session\NativeSession;
$auth = new SRPH\Jelai\Auth\Factory($provider, $session, '<YOUR_KEY>');
```

## API

### ```Factory```

Our auth implementation.

#### ```__constructor```

##### Parameters

- *```SRPH\Jelai\Auth\UserProviderInterface```* ```$provider``` - Provider implementation
- *```SRPH\Jelai\Session\SessionInterface```* ```$session``` - Session implementation
- *```string```* ```$key``` - Authentication key name

#### ```attempt``` (*```array```* ```$credentials```, *```boolean```* ```$login```:```true```)

Attempts to login a user with the given credentials. Returns true if login was successful, otherwise false.

\* Setting ```$login``` to false will only *attempt*, but not actually login the user with the given credentials. This is beneficial for validating user credentials.

`returns`: `boolean`

#### ```logout``` (*```void```*)

Logs out the provided user.

`returns`: `void`

#### ```check``` (*```void```*)

Checks if a user is authenticated.

`returns`: `boolean`.

#### ```guest``` (*```void```*)

Checks if a user is a guest.

`returns`: `boolean`

#### ```user``` (*```void```*)

Gets the user credentials.

`returns`: `mixed` - (`null`|`object`|`array`). If no user is authenticated, a `null` will be `return`ed.

### ```EloquentUserProvider```

**Parameters**:

- *```SRPH\Jelai\Hashing\HashingInterface```* ```$hasher``` - Hasher implementation
- *```string```* ```$model```- Model name

## Acknowledgement

**jelai.php-auth** © 2015+, Kier Borromeo (srph). **jelai.php** is released under the [MIT](mit-license.org) license.

> [srph.github.io](http://srph.github.io) &nbsp;&middot;&nbsp;
> GitHub [@srph](https://github.com/srph) &nbsp;&middot;&nbsp;
> Twitter [@_srph](https://twitter.com/_srph)
