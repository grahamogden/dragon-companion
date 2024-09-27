<?php

namespace App\Http\Requests\Creator\Item;

use App\Http\Requests\Creator\Item\ItemRequestRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    use ItemRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->item);
    }
}
