<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlayerCharactersFixture
 */
class PlayerCharactersFixture extends TestFixture
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
                'user_id' => 1,
                'campaign_id' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'age' => 1,
                'max_hit_points' => 1,
                'armour_class' => 1,
                'dexterity_modifier' => 1,
                'alignment_id' => 1,
            ],
        ];
        parent::init();
    }
}
