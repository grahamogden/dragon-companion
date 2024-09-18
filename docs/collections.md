# [Collections](https://laravel.com/docs/11.x/collections)

Collections are immutable and each method called in a chain returns a new Collection. Example:

```
$collection = collect(['taylor', 'abigail', null])->map(function (?string $name) {
    return strtoupper($name);
})->reject(function (string $name) {
    return empty($name);
});
```

## Creating Collections

Use the `collect()` helper method:

```
$collection = collect([1, 2, 3]);
```

## [Available Methods](https://laravel.com/docs/11.x/collections#available-methods)

# Lazy Collections

Utilise PHP generators to work with very large datasets whilst keeping memory low.

```
use App\Models\LogEntry;
use Illuminate\Support\LazyCollection;

LazyCollection::make(function () {
    $handle = fopen('log.txt', 'r');

    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
})->chunk(4)->map(function (array $lines) {
    return LogEntry::fromLines($lines);
})->each(function (LogEntry $logEntry) {
    // Process the log entry...
});
```

When using Eloquent models, you'd typically get all 10,000 records and loaded into memory at once:

```
use App\Models\User;

$users = User::all()->filter(function (User $user) {
    return $user->id > 500;
});
```

Instead, you can use the `cursor()` moethod to return a `LazyCollection` so that it only runs a single query against the database but also keeps only 1 Eloquent model in memory at a time:

```
use App\Models\User;

$users = User::cursor()->filter(function (User $user) {
    return $user->id > 500;
});

foreach ($users as $user) {
    echo $user->id;
}
```
