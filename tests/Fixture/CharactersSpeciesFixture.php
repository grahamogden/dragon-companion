<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CharactersSpeciesFixture
 */
class CharactersSpeciesFixture extends TestFixture
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
                'character_id' => 1,
                'species_id' => 1,
            ],
        ];
        parent::init();
    }
}
