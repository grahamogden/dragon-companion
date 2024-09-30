<?php

namespace App\Http\Requests\Creator\Timeline;

use App\Models\Campaign;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineRequest extends FormRequest
{
    use TimelineRequestRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // /** @var User $user */
        // $user = $this->user();
        // return $user->can(
        //     abilities: 'create',
        //     arguments: [Timeline::class, $this->campaign]
        // );
        return true;
    }
}
