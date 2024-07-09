<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpeciesFixture
 */
class SpeciesFixture extends TestFixture
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
                'species_name' => 'Lorem ipsum dolor sit amet',
                'campaign_id' => 1,
                'user_id' => 1,
            ],
        ];
        parent::init();
    }
}
