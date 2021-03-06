# Permissions

This package implements a basic permission system, based off the Laravel version implemented in 5.1.11.

## Setup

-	Add the `Bozboz\Permissions\PermissionServiceProvider` class to your app/config.php file.
-	Optionally add the `Bozboz\Permissions\Facades\Gate` facade to your aliases array in app/config.php.
-	Publish and run the migrations using `php artisan migrate:publish bozboz/permissions && php artisan migrate`

## Usage

First, define some rules in app/permissions.php. These are typically actions that users can do in your app.

```php
$permissions->define('manage_page', 'Bozboz\Permissions\Rules\Rule');
$permissions->define('delete_pages', 'Bozboz\Permissions\Rules\GlobalRule');
```

There are 2 rule classes by default: Rule and GlobalRule. The former is for when you have a rule that relies on a context value, typically a model ID. A global rule is one that doesn't require any additional data to make sense.

Whenever you want to check a user has permission to do an action, you ask the Gate:

```php
if (Gate::allows('delete_pages')) {
	$instance->delete();
}
```

Alternatively, if you haven't registered the facade, you can inject the Checker object through the constructor or retrieve via the IoC container:

```php
if (app('permission.checker')->allows('delete_pages')) {
	$instance->delete();
}
```

Note, by default, the currently authenticated user will be used to check permissions on. To authorize a specific user, pass it in:

```php
if (Gate::forUser($user)->allows('delete_pages')) {
	$instance->delete();
}
```

You can also flip the check, and determine if the current user is *disallowed* from doing a task:

```php
if (Gate::forUser($user)->disallows('delete_pages')) {
	App::abort(403);
}

$instance->delete();
```

The authenticated user instance must implement `Bozboz\Permissions\UserInterface`. User implementations that implement this interface must define a `getPermissions` method. Implementations can retrieve permissions however they wish.

### The rule stack

The rule stack allows permissions of varying degrees of access to be stacked together, allowing the authenticated user to match any of the defined permissions. This is useful for defining "global" permissions, and stack on more specific rules, e.g.

```php
if (RuleStack::with('view_pages')->then('view_anything')->isAllowed()) {
	// User is able to view pages and/or view anything
}
```

The stack will check the left-most rule first, then further rules defined using the `then` method; stopping execution when an allowed rule is found. If no rule is allowed, the method will return false.

Alternatively, a RuleStack instance can be instantiated and rules added to it using the `add` method:

```php
$stack = new RuleStack;
$stack->add('edit_anything');
$stack->add('edit_page', 5);
return $stack->isAllowed();
```

Here, the stack will check the last added rule first, and work its way up.
