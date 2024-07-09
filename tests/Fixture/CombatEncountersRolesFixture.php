<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CombatEncountersRolesFixture
 */
class CombatEncountersRolesFixture extends TestFixture
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
                'combat_encounter_id' => 1,
                'role_id' => 1,
            ],
        ];
        parent::init();
    }
}
