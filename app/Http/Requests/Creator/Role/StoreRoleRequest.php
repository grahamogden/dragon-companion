<?php

namespace App\Http\Requests\Creator\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    use RoleRequestRulesTrait;
}
