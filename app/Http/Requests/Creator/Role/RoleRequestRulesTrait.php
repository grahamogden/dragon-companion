<?php

declare(strict_types=1);

namespace App\Http\Requests\Creator\Role;

use App\Models\Role;
use Illuminate\Contracts\Validation\ValidationRule;

trait RoleRequestRulesTrait
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Role::FIELD_NAME => 'required|string|max:250',
        ];
    }
}
