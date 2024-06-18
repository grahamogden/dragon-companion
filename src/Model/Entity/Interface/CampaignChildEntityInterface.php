<?php

declare(strict_types=1);

namespace App\Model\Entity\Interface;

use Cake\Datasource\EntityInterface;

interface CampaignChildEntityInterface extends EntityInterface
{
    public function getCampaignId(): int;
}
