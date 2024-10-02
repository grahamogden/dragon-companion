<?php

namespace App\Http\Requests\Creator\Character;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
{
    use CharacterRequestRulesTrait;
}
