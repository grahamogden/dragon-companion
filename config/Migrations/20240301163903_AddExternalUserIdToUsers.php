<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddExternalUserIdToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        // $this->table('access_tokens', ['id' => false, 'primary_key' => ['id']])
        //     ->addColumn('id', 'integer', [
        //         'autoIncrement' => true,
        //         'default' => null,
        //         'limit' => null,
        //         'null' => false,
        //         'signed' => false,
        //     ])
        //     ->addPrimaryKey(['id'])
        //     ->addColumn('access_token', 'string', [
        //         'default' => null,
        //         'limit' => 255,
        //         'null' => false,
        //     ])
        //     ->addColumn('user_id', 'integer', [
        //         'default' => null,
        //         'limit' => 11,
        //         'null' => false,
        //     ])
        //     ->addColumn('created', 'datetime', [
        //         'default' => null,
        //         'null' => false,
        //     ])
        //     ->addColumn('expires', 'datetime', [
        //         'default' => null,
        //         'null' => false,
        //     ])
        //     ->create();

        $this->table('users')
            ->addColumn('external_user_id', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex('external_user_id', ['unique' => true])
            ->update();
    }
}
