<?php

namespace App\Http\Requests\Creator\Timeline;

use App\Models\Timeline;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimelineRequest extends FormRequest
{
    use TimelineRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     // return $this->user()->can('update', Timeline::class);
    //     return true;
    // }
}
