<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use App\Model\Entity\User;
use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => '',
                'email' => env('TEST_EMAIL', ''),
                'created' => '2024-03-29 12:54:52',
                'modified' => '2024-03-29 12:54:52',
                'status' => User::STATUS_ACTIVE,
                'external_user_id' => 'test-user-id-1',
            ],
        ];
        parent::init();
    }
}
