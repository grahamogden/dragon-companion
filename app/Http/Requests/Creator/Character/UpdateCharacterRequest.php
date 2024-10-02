<?php

namespace App\Http\Requests\Creator\Character;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterRequest extends FormRequest
{
    use CharacterRequestRulesTrait;
}
