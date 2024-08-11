<?php

declare(strict_types=1);

namespace App\Test\Service\Request\Header;

use App\Test\Service\Request\Header\Authentication\AuthenticationTrait;

trait HeaderTrait
{
    use AuthenticationTrait;

    public function setUpRequestHeaders()
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $this->bearerToken",
            ],
        ]);
    }
}
