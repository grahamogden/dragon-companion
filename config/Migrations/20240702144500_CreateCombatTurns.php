<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateCombatTurns extends AbstractMigration
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
        $this->table('combat_turns')
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
            ->addColumn('round_number', 'integer', [
                'comment' => 'The current round number that this turn is in',
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('turn_order', 'integer', [
                'comment' => 'The incrementing number that represents when this precise turn occurred in combat',
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('source_participant_id', 'integer', [
                'comment' => 'The participant that initiates the action. This can be null as damage may be taken due to environmental conditions but the environment is not a participant.',
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('target_participant_id', 'integer', [
                'comment' => 'The participant that receives the action (be that damage or healing), which is unlikely to be null as something will typically always happen to someone.',
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('combat_turn_action', 'tinyinteger', [
                'comment' => '[enum] pass:0,attack:1,heal:2 - Enum that represents what action the user took for their turn - attack, heal, disengage, pass their turn, etc.',
                'default' => 0,
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('roll_total', 'integer', [
                'comment' => 'The total roll of the user\'s dice to initiate the action. For example, the total of rolling 4d10 + 5 = 29',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('net_action_total', 'float', [
                'comment' => 'The total amount of damage/healing/etc that the target received. Could be null as the target may not take any damage or healing during their turn (potentially could be 0)',
                'default' => null,
                'null' => true,
                'precision' => 9,
                'scale' => 3,
            ])
            ->addColumn('movement', 'integer', [
                'comment' => 'The distance that the source participant moved during their turn.',
                'default' => '0',
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
                    'source_participant_id',
                ]
            )
            ->addIndex(
                [
                    'target_participant_id',
                ]
            )
            ->create();

        /*************************
         *************************
         *** ADD FOREIGN KEYS ***
         *************************
         *************************/

        $this->table('combat_turns')
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
                'source_participant_id',
                'participants',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'target_participant_id',
                'participants',
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
        $this->table('combat_turns')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'source_participant_id'
            )
            ->dropForeignKey(
                'target_participant_id'
            )->save();

        $this->table('combat_turns')->drop()->save();
    }
}
