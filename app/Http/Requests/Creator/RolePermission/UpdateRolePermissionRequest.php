<?php

namespace App\Http\Requests;

use App\Http\Requests\Creator\Role\RolePermissionRequestRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRolePermissionRequest extends FormRequest
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
