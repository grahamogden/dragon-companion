<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CampaignUsersFixture
 */
class CampaignUsersFixture extends TestFixture
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
                'campaign_id' => 1,
                'user_id' => 1,
                'member_status' => 1,
                'account_level' => 1,
            ],
        ];
        parent::init();
    }
}
