<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    public const FIELD_CREATED = 'created_at';
    public const FIELD_UPDATED = 'updated_at';
}
