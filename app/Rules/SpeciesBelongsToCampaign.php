<?php

namespace App\Rules;

use App\Models\Species;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class SpeciesBelongsToCampaign implements DataAwareRule, ValidationRule
{
    protected $data = [];

    public function __construct(private readonly int $campaignId) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $species = Species::findOrFail(id: $value);
        if ($species->campaign_id !== $this->campaignId) {
            $fail('The species selected is not in this campaign');
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
