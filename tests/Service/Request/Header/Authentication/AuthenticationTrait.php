<?php

declare(strict_types=1);

namespace App\Test\Service\Request\Header\Authentication;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait AuthenticationTrait
{
  public string $bearerToken;

  public function setUpBearerToken()
  {
    $key = file_get_contents(CONFIG_KEYS . 'firebase/jwt.private.test.pem');

    $this->bearerToken = JWT::encode(
      payload: json_decode('{
                "iss": "iss",
                "aud": "dragon-companion",
                "auth_time": 1721431208,
                "user_id": "test-user-id-1",
                "sub": "test-user-id-1",
                "iat": 1723157662,
                "exp": 1823161262,
                "email": "' . env('TEST_EMAIL', '') . '",
                "email_verified": false,
                "firebase": {
                  "identities": {
                    "email": [
                      "' . env('TEST_EMAIL', '') . '"
                    ]
                  },
                  "sign_in_provider": "password"
                }
              }', true),
      key: $key,
      alg: 'RS256',
      keyId: env('TEST_AUTH_KID', ''),
    );
  }
}
