<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TimelinePermissionsFixture
 */
class TimelinePermissionsFixture extends TestFixture
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
                'timeline_id' => 1,
                'role_id' => 1,
                'permissions' => 14,
            ],
        ];
        parent::init();
    }
}
