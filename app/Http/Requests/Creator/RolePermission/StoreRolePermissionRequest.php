<?php

namespace App\Http\Requests\Creator\RolePermission;

use App\Http\Requests\Creator\RolePermission\RolePermissionRequestRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreRolePermissionRequest extends FormRequest
{
    use RolePermissionRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }
}
