<?php

declare(strict_types=1);

namespace App\Model\Entity\Interface;

use Cake\Datasource\EntityInterface;

interface EntityInterfaceWithUserIdInterface extends EntityInterface
{
    public function getUserId(): int;
}
