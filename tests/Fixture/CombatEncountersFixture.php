<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CombatEncountersFixture
 */
class CombatEncountersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'created' => '2024-03-29 12:55:16',
                'campaign_id' => 1,
            ],
        ];
        parent::init();
    }
}
