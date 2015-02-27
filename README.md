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

```php
<?php

// Assume our user has a `username` of 'yolo' and `password` of '123'
$auth->attempt(['username' => 'yolo', 'password' => '12'); // false
$auth->check(); // false

$auth->attempt(['username' => 'yolo', 'password' => '123'); // true
$auth->check(); // true
```

#### ```logout``` (*```void```*)

Logs out the provided user.

`returns`: `void`

```php
<?php

$auth->logout();
```

#### ```check``` (*```void```*)

Checks if a user is authenticated. Complimentary of [```guest```](#guest).

`returns`: `boolean`.

```php
<?php

// Assume authenticated
$auth->check(); // true

// Assume guest
$auth->check(); // false
$auth->guest() // true
```

#### ```guest``` (*```void```*)

Checks if a user is a guest. Complimentary of [```check```](#check).

`returns`: `boolean`

```php
<?php

// Assume authenticated
$auth->guest(); // false

// Assume guest
$auth->guest(); // true
$auth->check(); // false
```

#### ```user``` (*```void```*)

Gets the user credentials.

`returns`: `mixed` - (`null`|`object`|`array`). If no user is authenticated, a `null` will be `return`ed. Type of return will depend on the fetcher

```php
<?php

// Assume authenticated
$auth->user(); // ['username' = > ..., ..]

// Assume guest
$auth->user(); // null
```

### ```EloquentUserProvider```

**Parameters**:

- *```SRPH\Jelai\Hashing\HashingInterface```* ```$hasher``` - Hasher implementation
- *```string```* ```$model```- Model name

## Important Note

**.. Ugh.. I give up documenting PHP stuff by myself.**. Implementation is already done, however documentation is not even half complete.

## Acknowledgement

**jelai.php-auth** © 2015+, Kier Borromeo (srph). **jelai.php** is released under the [MIT](mit-license.org) license.

> [srph.github.io](http://srph.github.io) &nbsp;&middot;&nbsp;
> GitHub [@srph](https://github.com/srph) &nbsp;&middot;&nbsp;
> Twitter [@_srph](https://twitter.com/_srph)
