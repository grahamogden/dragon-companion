<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateParticipants extends AbstractMigration
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
        $this->table('participants')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('combat_encounter_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('character_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('initiative', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('starting_hit_points', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 9,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('current_hit_points', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 9,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('armour_class', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('temporary_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'combat_encounter_id',
                ]
            )
            ->addIndex(
                [
                    'character_id',
                ]
            )
            ->create();

        /*************************
         *************************
         *** ADD FOREIGN KEYS ***
         *************************
         *************************/

        $this->table('participants')
            ->addForeignKey(
                'combat_encounter_id',
                'combat_encounters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'character_id',
                'characters',
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
        $this->table('participants')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'character_id'
            )->save();

        $this->table('participants')->drop()->save();
    }
}
