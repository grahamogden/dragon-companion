<?php

namespace App\Http\Requests\Creator\Item;

use App\Http\Requests\Creator\Item\ItemRequestRulesTrait;
use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    use ItemRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Item::class);
    }
}
