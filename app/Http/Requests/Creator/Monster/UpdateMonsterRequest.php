<?php

namespace App\Http\Requests\Creator\Monster;

use App\Http\Requests\Creator\Monster\MonsterRequestRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMonsterRequest extends FormRequest
{
    use MonsterRequestRulesTrait;
}
