# [Migrations](https://laravel.com/docs/11.x/migrations)

## Generating Migrations

Use the `make:migration` Artisan command:

```
php artisan make:migration create_flights_table
```

## Running Migrations

```
php artisan migrate

php artisan migrate:status

// Dry run
php artisan migrate --pretend
```

## Rolling Back Migrations

```
php artisan migrate:rollback

php artisan migrate:rollback --step=5

// Dry run
php artisan migrate:rollback --pretend
```

### Rollback and Migrate Again

To go back several steps and then migrate them again, use the `step` option:

```
php artisan migrate:refresh --step=5
```

## Tables

### Creating Tables

Use the `Schema::create()` facade method to create a table:

```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->timestamps();
});
```

### Determine Table/Column Existence

```
if (Schema::hasTable('users')) {
    // The "users" table exists...
}

if (Schema::hasColumn('users', 'email')) {
    // The "users" table exists and has an "email" column...
}

if (Schema::hasIndex('users', ['email'], 'unique')) {
    // The "users" table exists and has a unique index on the "email" column...
}
```

### Updating Tables

Use the `Schema::table()` facade method to update an existing table:

```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('users', function (Blueprint $table) {
    $table->integer('votes');
});
```

#### Renaming Tables

Use the `Schema::rename()` facade method:

```
use Illuminate\Support\Facades\Schema;

Schema::rename($from, $to);
```

Note: when renaming a table, make sure to check any foreign key constraints have an explicit name in the migration files instead of letting Laravel assign a convention based name, otherwise the foreign key constraint name will refer to the old name.

### Drop Tables

Use the `Schema::drop()` or `Schema::dropIfExists()` facade methods:

```
Schema::drop('users');

Schema::dropIfExists('users');
```

## Columns

### Creating Columns

Use the `Schema::table()` facade method to update a table and give it the Blueprint for the columns in the closure:

```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('users', function (Blueprint $table) {
    $table->integer('votes');
});
```

#### [Available Column Types](https://laravel.com/docs/11.x/migrations#available-column-types)

|               |                    |                       |
| ------------- | ------------------ | --------------------- |
| bigIncrements | ipAddress          | timeTz                |
| bigInteger    | json               | time                  |
| binary        | jsonb              | timestampTz           |
| boolean       | longText           | timestamp             |
| char          | macAddress         | timestampsTz          |
| dateTimeTz    | mediumIncrements   | timestamps            |
| dateTime      | mediumInteger      | tinyIncrements        |
| date          | mediumText         | tinyInteger           |
| decimal       | morphs             | tinyText              |
| double        | nullableMorphs     | unsignedBigInteger    |
| enum          | nullableTimestamps | unsignedInteger       |
| float         | nullableUlidMorphs | unsignedMediumInteger |
| foreignId     | nullableUuidMorphs | unsignedSmallInteger  |
| foreignIdFor  | rememberToken      | unsignedTinyInteger   |
| foreignUlid   | set                | ulidMorphs            |
| foreignUuid   | smallIncrements    | uuidMorphs            |
| geography     | smallInteger       | ulid                  |
| geometry      | softDeletesTz      | uuid                  |
| id            | softDeletes        | year                  |
| increments    | string             |                       |
| integer       | text               |                       |

#### Column Modifiers

| Modifier                          | Description                                                                                |
| --------------------------------- | ------------------------------------------------------------------------------------------ |
| ->after('column')                 | Place the column "after" another column (MariaDB / MySQL).                                 |
| ->autoIncrement()                 | Set INTEGER columns as auto-incrementing (primary key).                                    |
| ->charset('utf8mb4')              | Specify a character set for the column (MariaDB / MySQL).                                  |
| ->collation('utf8mb4_unicode_ci') | Specify a collation for the column.                                                        |
| ->comment('my comment')           | Add a comment to a column (MariaDB / MySQL / PostgreSQL).                                  |
| ->default($value)                 | Specify a "default" value for the column.                                                  |
| ->first()                         | Place the column "first" in the table (MariaDB / MySQL).                                   |
| ->from($integer)                  | Set the starting value of an auto-incrementing field (MariaDB / MySQL / PostgreSQL).       |
| ->invisible()                     | Make the column "invisible" to SELECT \* queries (MariaDB / MySQL).                        |
| ->nullable($value = true)         | Allow NULL values to be inserted into the column.                                          |
| ->storedAs($expression)           | Create a stored generated column (MariaDB / MySQL / PostgreSQL / SQLite).                  |
| ->unsigned()                      | Set INTEGER columns as UNSIGNED (MariaDB / MySQL).                                         |
| ->useCurrent()                    | Set TIMESTAMP columns to use CURRENT_TIMESTAMP as default value.                           |
| ->useCurrentOnUpdate()            | Set TIMESTAMP columns to use CURRENT_TIMESTAMP when a record is updated (MariaDB / MySQL). |
| ->virtualAs($expression)          | Create a virtual generated column (MariaDB / MySQL / SQLite).                              |
| ->generatedAs($expression)        | Create an identity column with specified sequence options (PostgreSQL).                    |
| ->always()                        | Defines the precedence of sequence values over input for an identity column (PostgreSQL).  |

###### Column Order

Use the `after()` method to create a column after an existing column:

```
$table->after('password', function (Blueprint $table) {
    $table->string('address_line1');
    $table->string('address_line2');
    $table->string('city');
});
```

### Modifying Columns

Use the `change()` method to modify an existing column (note: any modifiers not specified will be dropped, so you must include all of the existing ones you want to keep):

```
Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->change();
});
```

### Renaming Columns

```
Schema::table('users', function (Blueprint $table) {
    $table->renameColumn('from', 'to');
});
```

### Dropping Columns

```
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('votes');
});

// or

Schema::table('users', function (Blueprint $table) {
    $table->dropColumn(['votes', 'avatar', 'location']);
});
```

## Indexes

### Creating Indexes

| Command                                        | Description                                                    |
| ---------------------------------------------- | -------------------------------------------------------------- |
| $table->primary('id');                         | Adds a primary key.                                            |
| $table->primary(['id', 'parent_id']);          | Adds composite keys.                                           |
| $table->unique('email');                       | Adds a unique index.                                           |
| $table->index('state');                        | Adds an index.                                                 |
| $table->fullText('body');                      | Adds a full text index (MariaDB / MySQL / PostgreSQL).         |
| $table->fullText('body')->language('english'); | Adds a full text index of the specified language (PostgreSQL). |
| $table->spatialIndex('location');              | Adds a spatial index (except SQLite).                          |

### Renaming Indexes

```
$table->renameIndex('from', 'to')
```

### Dropping Indexes

| Command                                                | Description                                                |
| ------------------------------------------------------ | ---------------------------------------------------------- |
| $table->dropPrimary('users_id_primary');               | Drop a primary key from the "users" table.                 |
| $table->dropUnique('users_email_unique');              | Drop a unique index from the "users" table.                |
| $table->dropIndex('geo_state_index');                  | Drop a basic index from the "geo" table.                   |
| $table->dropFullText('posts_body_fulltext');           | Drop a full text index from the "posts" table.             |
| $table->dropSpatialIndex('geo_location_spatialindex'); | Drop a spatial index from the "geo" table (except SQLite). |

## Foreign Keys

### Creating Foreign Keys

Column modifiers must be called before any constraint methods.

```
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('posts', function (Blueprint $table) {
    $table->unsignedBigInteger('user_id');

    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
});
```

| Method                      | Description                                       |
| --------------------------- | ------------------------------------------------- |
| $table->cascadeOnUpdate();  | Updates should cascade.                           |
| $table->restrictOnUpdate(); | Updates should be restricted.                     |
| $table->noActionOnUpdate(); | No action on updates.                             |
| $table->cascadeOnDelete();  | Deletes should cascade.                           |
| $table->restrictOnDelete(); | Deletes should be restricted.                     |
| $table->nullOnDelete();     | Deletes should set the foreign key value to null. |

### Dropping Foreign Keys

Use either the `dropForeign()` method to delete the named constraint or `dropForeign()` with an array to leverage Laravel's constraint naming conventions:

```
$table->dropForeign('posts_user_id_foreign');

// Is the same as

$table->dropForeign(['user_id']);
```
