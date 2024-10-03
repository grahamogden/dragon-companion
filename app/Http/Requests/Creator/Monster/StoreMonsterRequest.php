<?php

namespace App\Http\Requests\Creator\Monster;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonsterRequest extends FormRequest
{
    use MonsterRequestRulesTrait;
}
