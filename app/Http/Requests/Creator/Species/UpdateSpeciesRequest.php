<?php

namespace App\Http\Requests\Creator\Species;

use App\Http\Requests\Creator\Species\SpeciesRequestRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSpeciesRequest extends FormRequest
{
    use SpeciesRequestRulesTrait;
}
