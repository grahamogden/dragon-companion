<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpeciesPermissionsFixture
 */
class SpeciesPermissionsFixture extends TestFixture
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
                'species_id' => 1,
                'role_id' => 1,
                'permissions' => 14,
            ],
        ];
        parent::init();
    }
}
