<?php

namespace App\Http\Resources;

trait EntityOptionResourceTrait
{
    protected function transformToOption(string|int $text, string|int|bool $value): array
    {
        return [
            'text' => $text,
            'value' => $value,
        ];
    }
}
