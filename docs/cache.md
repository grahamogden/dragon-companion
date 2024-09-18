# [Cache](https://laravel.com/docs/11.x/cache)

## Cache Usage

# Obtaining a Cache Instance

Use the `Cache` facade. You can access a cache store using the `store()` method.

```
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Show a list of all users of the application.
     */
    public function index(): array
    {
        $value = Cache::get('key');

        // or

        $value = Cache::store('file')->get('foo');

        return [
            // ...
        ];
    }
}
```

## Retrieving Items

Use the facade's `get()` method, which will return `null` by default if the item isn't found. Pass second argument to specify the default value/closure:

```
$value = Cache::get('key');

$value = Cache::get('key', 'default');

$value = Cache::get('key', function () {
    return DB::table(/* ... */)->get();
});
```

### Exists

```
if (Cache::has('key')) {
    // ...
}
```

### Retrieve and Store

Retrieve and item from the cache or, if it doesn't exist, retrieve them from the database and store them using `remember()` or `rememberForever()`:

```
$value = Cache::remember('users', $seconds, function () {
    return DB::table('users')->get();
});

// or

$value = Cache::rememberForever('users', function () {
    return DB::table('users')->get();
});
```

### Retrieve and Delete

```
$value = Cache::pull('key');

$value = Cache::pull('key', 'default');
```

## Storing Items

Store using `put()`. Without a time, it will be stored indefinitely.

```
Cache::put('key', 'value', $seconds = 10);

// or

Cache::put('key', 'value');

// or

Cache::put('key', 'value', now()->addMinutes(10));

// or

Cache::forever('key', 'value');
```

### Store if Not Present

Use the `add()` method:

```
Cache::add('key', 'value', $seconds);
```

## Removing Items

Use the `forget()` method:

```
Cache::forget('key');
```
