<?php

declare(strict_types=1);

use App\Model\Entity\Role;
use App\Model\Table\RolesTable;
use Migrations\AbstractMigration;

/**
 * 20240804133600_CreateItems
 */
class CreateItems extends AbstractMigration
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
        $this->table('item_permissions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('item_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('permissions', 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit should not be used alongside other permissions, for example, there should be no 3 for inherit and read because if its inheriting then it will use the default permissions for the user\'s role.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(['item_id'])
            ->addIndex(['role_id'])
            ->create();

        $this->table('items')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 2000,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(['campaign_id'])
            ->addIndex(['user_id'])
            ->create();

        $this->table(RolesTable::TABLE_NAME)
            ->addColumn(Role::FIELD_ITEM_DEFAULT_PERMISSIONS, 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit must not be used for this value at all because this is the value that will be inherited from and will therefore be ignored.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->update();

        /*************************
         *************************
         *** ADD FOREIGN KEYS ***
         *************************
         *************************/


        $this->table('item_permissions')
            ->addForeignKey(
                'item_id',
                'items',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('items')
            ->addForeignKey(
                'campaign_id',
                'campaigns',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
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
        $this->table('item_permissions')
            ->dropForeignKey('role_id')
            ->dropForeignKey('item_id')
            ->save();

        $this->table('items')
            ->dropForeignKey('campaign_id')
            ->dropForeignKey('user_id')
            ->save();

        $this->table(RolesTable::TABLE_NAME)
            ->removeColumn(Role::FIELD_ITEM_DEFAULT_PERMISSIONS)
            ->save();
        $this->table('item_permissions')
            ->drop()
            ->save();
        $this->table('items')
            ->drop()
            ->save();
    }
}
