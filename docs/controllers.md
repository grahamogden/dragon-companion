# [Controllers](https://laravel.com/docs/11.x/controllers)

## Writing Controllers

### Basic Controllers

Create a controller with:

```
php artisan make:controller UserController
```

Define the route like:

```
use App\Http\Controllers\UserController;

Route::get('/user/{id}', [UserController::class, 'show']);
```

### Single Action Controllers

Create a single action controller with:

```
php artisan make:controller ProvisionServer --invokable
```

Should be created with only an `__invoke` method. Create the route like:

```
use App\Http\Controllers\ProvisionServer;

Route::post('/server', ProvisionServer::class);
```

## Controller Middleware

Can be added in routes like:

```
Route::get('/profile', [UserController::class, 'show'])->middleware('auth');
```

Can be added in the controller like:

```
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('log', only: ['index']),
            new Middleware('subscribed', except: ['store']),
        ];
    }

    // ...
}
```

## Resource Controllers

Create resource controllers to match Eloquent models.

Use `--model` to create with type-hint for the model

Use `--requests` option to generate [form request classes](https://laravel.com/docs/11.x/validation#form-request-validation)

Use `--api` to create controllers without `create` or `edit`.

```
php artisan make:controller PhotoController --resource

// or

php artisan make:controller PhotoController --model=Photo --resource

// or

php artisan make:controller PhotoController --model=Photo --resource --requests

// or

php artisan make:controller PhotoController --api
```

Add the route with:

```
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class);

// Or

Route::resources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
]);
```

### Actions Handled by Resource Controllers

| Verb      | URI                    | Action  | Route Name     |
| --------- | ---------------------- | ------- | -------------- |
| GET       | `/photos`              | index   | photos.index   |
| GET       | `/photos/create`       | create  | photos.create  |
| POST      | `/photos`              | store   | photos.store   |
| GET       | `/photos/{photo}`      | show    | photos.show    |
| GET       | `/photos/{photo}/edit` | edit    | photos.edit    |
| PUT/PATCH | `/photos/{photo}`      | update  | photos.update  |
| DELETE    | `/photos/{photo}`      | destroy | photos.destroy |

### Customising Missing Model Behaviour

Will throw 404 by default, override with:

```
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

Route::resource('photos', PhotoController::class)
        ->missing(function (Request $request) {
            return Redirect::route('photos.index');
        });
```

### Soft Deleted Models

Use soft deleted models with:

```
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class)->withTrashed();

// or

Route::resource('photos', PhotoController::class)->withTrashed(['show']);
```

## Partial Resource Routes

```
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
]);

Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
]);
```

### API Resource Routes

Create route without HTML template routes, `create` or `edit`, using `apiResource`:

```
use App\Http\Controllers\PhotoController;

Route::apiResource('photos', PhotoController::class);

// or

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;

Route::apiResources([
    'photos' => PhotoController::class,
    'posts' => PostController::class,
]);
```

## Nested Resources

Use the `"dot"` notation in the route to nest resources.

```
use App\Http\Controllers\PhotoCommentController;

Route::resource('photos.comments', PhotoCommentController::class);

// Route = "/photos/{photo}/comments/{comment}"
```

### Shallow Nesting

```
use App\Http\Controllers\CommentController;

Route::resource('photos.comments', CommentController::class)->shallow();
```

Will create routes like:
| Verb | URI | Action | Route Name |
| --------- | --------------------------------- | ------- | ---------------------- |
| GET | `/photos/{photo}/comments` | index | photos.comments.index |
| GET | `/photos/{photo}/comments/create` | create | photos.comments.create |
| POST | `/photos/{photo}/comments` | store | photos.comments.store |
| GET | `/comments/{comment}` | show | comments.show |
| GET | `/comments/{comment}/edit` | edit | comments.edit |
| PUT/PATCH | `/comments/{comment}` | update | comments.update |
| DELETE | `/comments/{comment}` | destroy | comments.destroy |

## Naming Resource Routes

Use the `names()` method:

```
use App\Http\Controllers\PhotoController;

Route::resource('photos', PhotoController::class)->names([
    'create' => 'photos.build'
]);
```

## Naming Resource Routes Parameters

By default it uses the "singularised" version of the resource name. Override using the `parameters()` method:

```
use App\Http\Controllers\AdminUserController;

Route::resource('users', AdminUserController::class)->parameters([
    'users' => 'admin_user'
]);

// Will generate = /users/{admin_user}
```

## Scoping Resource Routes

Automatically scopes nested bindings so the child will belong to the parent. Use the `scoped()` method to define names:

```
use App\Http\Controllers\PhotoCommentController;

Route::resource('photos.comments', PhotoCommentController::class)->scoped([
    'comment' => 'slug',
]);

// Will register = /photos/{photo}/comments/{comment:slug}
```

## Supplementing Resource Controllers

If you need extra routes for a resource controller, use the `resource()` method (careful of the order):

```
use App\Http\Controller\PhotoController;

Route::get('/photos/popular', [PhotoController::class, 'popular']);
Route::resource('photos', PhotoController::class);
```

## Singleton Resource Controllers

For resources that can only have a single instance, such as a user's profile or an image's thumbnail, the are called "singleton resources". Register like:

```
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::singleton('profile', ProfileController::class);
```

Will register the following routes:
| Verb | URI | Action | Route Name |
| - | - | - | - |
| GET | `/profile` | show | profile.show |
| GET | `/profile/edit` | edit | profile.edit |
| PUT/PATCH | `/profile` | update | profile.update |

May also be nested within a standard resource:

```
Route::singleton('photos.thumbnail', ThumbnailController::class);
```

Will register all standard resource routes, but include:
| Verb | URI | Action | Route Name |
| - | - | - | - |
| GET | `/photos/{photo}/thumbnail` | show | photos.thumbnail.show |
| GET | `/photos/{photo}/thumbnail/edit` | edit | photos.thumbnail.edit |
| PUT/PATCH | `/photos/{photo}/thumbnail` | update | photos.thumbnail.update |

### Creatable Singleton Resources

Use `creatable()` method or `destroyable()` method to register creation and storage routes for singletons:

```
Route::singleton('photos.thumbnail', ThumbnailController::class)->creatable();

// or

Route::singleton(...)->destroyable();
```

| Verb      | URI                                | Action                           | Route Name              |
| --------- | ---------------------------------- | -------------------------------- | ----------------------- |
| GET       | `/photos/{photo}/thumbnail/create` | create                           | photos.thumbnail.create |
| POST      | `/photos/{photo}/thumbnail`        | store                            | photos.thumbnail.store  |
| GET       | `/photos/{photo}/thumbnail`        | show                             | photos.thumbnail.show   |
| GET       | `/photos/{photo}/thumbnail/edit`   | edit                             | photos.thumbnail.edit   |
| PUT/PATCH | `/photos/{photo}/thumbnail`        | update                           | photos.thumbnail.update |
| DELETE    | `/photos/{photo}/thumbnail`        | destroy photos.thumbnail.destroy |

### API Singleton Resources

Can be registered with the `apiSingleton()` method

```
Route::apiSingleton('profile', ProfileController::class);

// or

Route::apiSingleton('photos.thumbnail', ProfileController::class)->creatable();
```
