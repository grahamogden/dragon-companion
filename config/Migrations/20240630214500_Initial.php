<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * 20240630214500_Initial
 */
class Initial extends AbstractMigration
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
        $this->table('campaigns')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('synopsis', 'string', [
                'default' => null,
                'limit' => 1000,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('campaign_permissions')
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
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            // ->addColumn('can_read', 'boolean', [
            //     'default' => true,
            //     'null' => false,
            // ])
            // ->addColumn('can_write', 'boolean', [
            //     'default' => false,
            //     'null' => false,
            // ])
            // ->addColumn('can_delete', 'boolean', [
            //     'default' => false,
            //     'null' => false,
            // ])
            // ->addColumn('can_permission', 'boolean', [
            //     'default' => false,
            //     'null' => false,
            // ])
            ->addColumn('permissions', 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit should not be used alongside other permissions, for example, there should be no 3 for inherit and read because if its inheriting then it will use the default permissions for the user\'s role.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->create();

        $this->table('roles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('role_name', 'string', [
                'default' => '',
                'length' => 255,
                'null' => false,
            ])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('role_level', 'tinyinteger', [
                'comment' => '[enum] public:10,custom:20,admin:40,owner:50. Defined the kind of role this is, as creators will have elevated permissions over admin roles and custom role types can be created and deleted by an admin/owner at any time.',
                'default' => null,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('campaign_default_permissions', 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit must not be used for this value at all because this is the value that will be inherited from and will therefore be ignored.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('species_default_permissions', 'tinyinteger', [
                'comment' => '[bitwise] deny:0,inherit:1,read:2,write:4,delete:8. For example, 6 means the role has read + write permissions but not delete. 10 Would mean read + delete but not write. 14 means that the role has read + write + delete permissions. Inherit must not be used for this value at all because this is the value that will be inherited from and will therefore be ignored.',
                'default' => 0,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->create();

        $this->table('roles_users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('species')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                ['campaign_id']
            )
            ->addIndex(
                ['user_id']
            )
            ->addIndex(
                ['name']
            )
            ->create();

        $this->table('species_permissions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('species_id', 'integer', [
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
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->addIndex(
                [
                    'species_id',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('username', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            // ->addColumn('password', 'string', [
            //     'default' => null,
            //     'limit' => 255,
            //     'null' => false,
            // ])
            ->addColumn('email', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
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
            ->addColumn('status', 'tinyinteger', [
                'comment' => '[enum] inactive:0,pending:5,active:10',
                'default' => 0,
                'limit' => 2,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('external_user_id', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex(
                ['username'],
                ['unique' => true]
            )
            ->addIndex(
                ['email'],
                ['unique' => true]
            )
            ->addIndex(
                ['external_user_id'],
                ['unique' => true]
            )
            ->create();

        /*************************
         *************************
         *** ADD FOREIGN KEYS ***
         *************************
         *************************/

        $this->table('campaigns')
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

        $this->table('campaign_permissions')
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
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('roles')
            ->addForeignKey(
                'campaign_id',
                'campaigns',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('roles_users')
            ->addForeignKey(
                'user_id',
                'users',
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

        $this->table('species')
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

        $this->table('species_permissions')
            ->addForeignKey(
                'species_id',
                'species',
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
        $this->table('campaigns')
            ->dropForeignKey('user_id')
            ->save();

        $this->table('campaign_permissions')
            ->dropForeignKey('campaign_id')
            ->dropForeignKey('role_id')
            ->save();

        $this->table('roles_users')
            ->dropForeignKey('role_id')
            ->dropForeignKey('user_id')
            ->save();

        $this->table('roles')
            ->dropForeignKey('campaign_id')
            ->save();

        $this->table('species')
            ->dropForeignKey('campaign_id')
            ->dropForeignKey('user_id')
            ->save();

        $this->table('species_permissions')
            ->dropForeignKey('role_id')
            ->dropForeignKey('species_id')
            ->save();

        $this->table('campaigns')->drop()->save();
        $this->table('campaign_permissions')->drop()->save();
        $this->table('roles')->drop()->save();
        $this->table('roles_users')->drop()->save();
        $this->table('species')->drop()->save();
        $this->table('species_permissions')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
