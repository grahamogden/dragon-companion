<?php

declare(strict_types=1);

use App\Model\Entity\Role;
use App\Model\Table\RolesTable;
use Migrations\AbstractMigration;

/**
 * 20240702142250_UpdateRolesForTimelines
 */
class UpdateRolesForTimelines extends AbstractMigration
{
    public bool $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table(RolesTable::TABLE_NAME)
            ->addColumn(Role::FIELD_TIMELINE_DEFAULT_PERMISSIONS, 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit must not be used for this value at all because this is the value that will be inherited from and will therefore be ignored.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table(RolesTable::TABLE_NAME)->removeColumn(Role::FIELD_TIMELINE_DEFAULT_PERMISSIONS)->save();
    }
}
