<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * 20240702142000_CreateTimelines
 */
class CreateTimelines extends AbstractMigration
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
        $this->table('timeline_permissions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('timeline_id', 'integer', [
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
            ->addIndex(
                [
                    'timeline_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->create();

        $this->table('timelines')
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
            ->addColumn('title', 'string', [
                'default' => '',
                'limit' => 2000,
                'null' => false,
            ])
            ->addColumn('body', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
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
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            // ->addColumn('slug', 'string', [
            //     'default' => '',
            //     'limit' => 250,
            //     'null' => false,
            // ])
            ->addColumn('lft', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('rght', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('level', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                ['campaign_id']
            )
            ->addIndex(
                ['user_id']
            )
            ->addIndex(
                ['parent_id']
            )
            ->addIndex(
                ['lft']
            )
            ->create();

        /*************************
         *************************
         *** ADD FOREIGN KEYS ***
         *************************
         *************************/


        $this->table('timeline_permissions')
            ->addForeignKey(
                'timeline_id',
                'timelines',
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

        $this->table('timelines')
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
        $this->table('timeline_permissions')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'timeline_id'
            )->save();

        $this->table('timelines')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('timeline_permissions')->drop()->save();
        $this->table('timelines')->drop()->save();
    }
}
