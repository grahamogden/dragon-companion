<?php

namespace App\Http\Requests\Creator\Campaign;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    use CampaignRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Campaign::class);
    }
}
