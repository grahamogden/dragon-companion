<?php

declare(strict_types=1);

namespace App\Services\TablePermissionsHelper;

use App\Error\Api\UnauthorizedError;
use App\Model\Entity\Role;
use App\Model\Enum\RolePermission;
use App\Model\Table\RolesTable;
use Authorization\Identity;
use Cake\ORM\Query\SelectQuery;

class TablePermissionsHelper
{
    public function getUserRoleForCampaignOrThrowUnauthorizedError(Identity $identity, int $campaignId): Role
    {
        foreach ($identity->getRoles() as $role) {
            if ($role->campaign_id === $campaignId) {
                return $role;
            }
        }

        throw new UnauthorizedError();
    }

    /**
     * Will append leftJoinWith() to the given $permissionEntityName table and adds a
     * permission check in the WHERE clause so that the permissions of a "find all" can
     * be checked inside the database rather than checking each individual record in PHP
     *
     * @param SelectQuery $query
     * @param string $permissionEntityName
     * @param Role $role
     * @return SelectQuery
     */
    public function addReadPermissionsChecksToQuery(SelectQuery $query, string $permissionEntityName, Role $role): SelectQuery
    {
        return $query
            ->leftJoinWith($permissionEntityName, function ($q) use ($permissionEntityName, $role) {
                return $q->where(["{$permissionEntityName}.role_id" => $role->id]);
            })
            ->leftJoin(
                [Role::ENTITY_NAME => RolesTable::TABLE_NAME],
                [Role::ENTITY_NAME . '.' . Role::FIELD_ID => $role->id],
                []
            )
            ->andWhere([
                'OR' => [
                    "{$permissionEntityName}.permissions & " . RolePermission::Read->value . ' = ' . RolePermission::Read->value,
                    Role::ENTITY_NAME . '.' . Role::FIELD_TIMELINE_DEFAULT_PERMISSIONS . ' & ' . RolePermission::Read->value . ' = ' . RolePermission::Read->value
                ]
            ]);
    }
}
