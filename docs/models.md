# [Eloquent/Models](https://laravel.com/docs/11.x/eloquent)

## Generating Model Classes

Use the `make:model` Artisan command and use `-migration` or `-m` to generate the database migration at the same time:

```
php artisan make:model Flight

// or

php artisan make:model Flight --migration
```

Use options to generate multiple classes at once:

```
# Generate a model and a FlightFactory class...
php artisan make:model Flight --factory
php artisan make:model Flight -f

# Generate a model and a FlightSeeder class...
php artisan make:model Flight --seed
php artisan make:model Flight -s

# Generate a model and a FlightController class...
php artisan make:model Flight --controller
php artisan make:model Flight -c

# Generate a model, FlightController resource class, and form request classes...
php artisan make:model Flight --controller --resource --requests
php artisan make:model Flight -crR

# Generate a model and a FlightPolicy class...
php artisan make:model Flight --policy

# Generate a model and a migration, factory, seeder, and controller...
php artisan make:model Flight -mfsc

# Shortcut to generate a model, migration, factory, seeder, policy, controller, and form requests...
php artisan make:model Flight --all
php artisan make:model Flight -a

# Generate a pivot model...
php artisan make:model Member --pivot
php artisan make:model Member -p
```

## Retriving Models

Use the `all()` method to retrieve all of the records from the model's associated database table:

```
use App\Models\Flight;

foreach (Flight::all() as $flight) {
    echo $flight->name;
}
```

Use the `get()` method to retrieve the results from a built up query:

```
$flights = Flight::where('active', 1)
               ->orderBy('name')
               ->take(10)
               ->get();
```

### Refreshing Models

Use the `fresh()` method to create a new model with the latest DB changes:

```
$flight = Flight::where('number', 'FR 900')->first();

$freshFlight = $flight->fresh();
```

Use the `refresh()` method to update the current model with the latest DB changes:

```
$flight = Flight::where('number', 'FR 900')->first();

$flight->number = 'FR 456';

$flight->refresh();

$flight->number; // "FR 900"
```

### Advanced Subqueries

Use the `select()` and `addSelect()` methods to include extra tables in the results:

```
use App\Models\Destination;
use App\Models\Flight;

return Destination::addSelect(['last_flight' => Flight::select('name')
    ->whereColumn('destination_id', 'destinations.id')
    ->orderByDesc('arrived_at')
    ->limit(1)
])->get();
```

## Retrieving Single Models / Aggregates

Use `first()`, `find()` or `firstWhere()` methods to retrieve a single model:

```
use App\Models\Flight;

// Retrieve a model by its primary key...
$flight = Flight::find(1);

// Retrieve the first model matching the query constraints...
$flight = Flight::where('active', 1)->first();

// Alternative to retrieving the first model matching the query constraints...
$flight = Flight::firstWhere('active', 1);
```

Use `findOrFail()` or `firstOrFail()` methods to throw a `ModelNotFoundException` if no results are found:

```
$flight = Flight::findOrFail(1);

$flight = Flight::where('legs', '>', 3)->firstOrFail();
```

### Retrieve or Create

```
use App\Models\Flight;

// Retrieve flight by name or create it if it doesn't exist...
$flight = Flight::firstOrCreate([
    'name' => 'London to Paris'
]);

// Retrieve flight by name or create it with the name, delayed, and arrival_time attributes...
$flight = Flight::firstOrCreate(
    ['name' => 'London to Paris'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);

// Retrieve flight by name or instantiate a new Flight instance...
$flight = Flight::firstOrNew([
    'name' => 'London to Paris'
]);

// Retrieve flight by name or instantiate with the name, delayed, and arrival_time attributes...
$flight = Flight::firstOrNew(
    ['name' => 'Tokyo to Sydney'],
    ['delayed' => 1, 'arrival_time' => '11:30']
);
```

### Retriving Soft Deleted Models

Use the `withTrashed()` method on a query:

```
use App\Models\Flight;

$flights = Flight::withTrashed()
                ->where('account_id', 1)
                ->get();
```

Or only get the soft deleted models with `onlyTrashed()`:

```
$flights = Flight::onlyTrashed()
                ->where('airline_id', 1)
                ->get();
```

## Inserting Models

Use the `save()` method after creating a new Eloquent model:

```
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Store a new flight in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $flight = new Flight;

        $flight->name = $request->name;

        $flight->save();

        return redirect('/flights');
    }
}
```

## Updating Models

Use the `save()` method again:

```
use App\Models\Flight;

$flight = Flight::find(1);

$flight->name = 'Paris to London';

$flight->save();
```

## Deleting Models

Use the `delete()` or `destroy()` methods:

```
use App\Models\Flight;

$flight = Flight::find(1);

$flight->delete();

// Or

Flight::destroy(1);

Flight::destroy(1, 2, 3);

Flight::destroy([1, 2, 3]);

Flight::destroy(collect([1, 2, 3]));
```

### Soft Deleting

Add the `Illuminate\Database\Eloquent\SoftDeletes` trait to set a `deleted_at` attribute to the model:

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use SoftDeletes;
}
```

Add the column to the database in a migration by using the `softDeletes()` method:

```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('flights', function (Blueprint $table) {
    $table->softDeletes();
});

Schema::table('flights', function (Blueprint $table) {
    $table->dropSoftDeletes();
});
```

#### Restoring Soft Deleted Models

Use the `restore()` method:

```
$flight->restore();
```

### Permanently Deleting Models

Use the `forceDelete()` method:

```
$flight->forceDelete();
```

### Pruning Models

Use the `Illuminate\Database\Eloquent\Prunable` or `Illuminate\Database\Eloquent\MassPrunable` traits to periodically prune models that are no longer needed. A `pruning()` method can be defined and will be called before the model is deleted and can be used to delete additional resources associated with the model. Mass pruning will not retrieve the models before deleting and, therefore, not trigger the `prune()` method, nor the `deleting` or `deleted` model events to be dispatched.

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Flight extends Model
{
    use Prunable;

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth());
    }

    /**
    * Prepare the model for pruning.
    */
    protected function pruning(): void
    {
        // ...
    }
}
```

Use the `model:prune` Artisan command to set up a schedule for when to run the prune.

```
use Illuminate\Support\Facades\Schedule;

Schedule::command('model:prune')->daily();
```
