<?php

namespace App\Http\Requests\Creator\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    use RoleRequestRulesTrait;
}
