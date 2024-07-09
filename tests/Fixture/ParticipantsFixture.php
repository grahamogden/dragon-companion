<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipantsFixture
 */
class ParticipantsFixture extends TestFixture
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
                'character_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'initiative' => 1,
                'starting_hit_points' => 1,
                'current_hit_points' => 1,
                'armour_class' => 1,
                'temporary_id' => 1,
            ],
        ];
        parent::init();
    }
}
