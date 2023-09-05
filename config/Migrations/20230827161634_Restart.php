<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Restart extends AbstractMigration
{
    public $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('alignments')
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
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->create();

        $this->table('campaign_users')
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
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('member_status', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('account_level', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

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
            ->create();

        $this->table('character_classes')
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
                'limit' => 25,
                'null' => false,
            ])
            ->create();

        $this->table('character_races')
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
                'limit' => 25,
                'null' => false,
            ])
            ->create();

        $this->table('clans')
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
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'name',
                ]
            )
            ->create();

        $this->table('clans_users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('clan_id', 'integer', [
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
            ->addColumn('member_status', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('account_level', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'clan_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('combat_actions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('external_id', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('visible', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'external_id',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('combat_encounters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 250,
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
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->create();

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
                'comment' => 'The participant that receives the action (be that damage or healing), which can never be null as something will always happen to someone.',
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('combat_action_id', 'integer', [
                'comment' => 'Foreign key to the combat_actions table and represents what action the user took for their turn - attack, heal, disengage, pass their turn, etc.',
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
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
                    'combat_action_id',
                ]
            )
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

        $this->table('conditions')
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
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->create();

        $this->table('data_sources')
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
            ->create();

        $this->table('monster_instance_types')
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
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 1000,
                'null' => true,
            ])
            ->create();

        $this->table('monsters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('data_source_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('source_location', 'string', [
                'default' => null,
                'limit' => 500,
                'null' => true,
            ])
            ->addColumn('max_hit_points', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 9,
                'scale' => 3,
                'signed' => false,
            ])
            ->addColumn('armour_class', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('dexterity_modifier', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('monster_instance_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('visibility', 'string', [
                'default' => 'PRIVATE',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('alignment_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'alignment_id',
                ]
            )
            ->addIndex(
                [
                    'data_source_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('non_playable_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('age', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('appearance', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('occupation', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('personality', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('history', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('alignment_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('notes', 'text', [
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
            ->addIndex(
                [
                    'alignment_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('participants')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('initiative', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('combat_encounter_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('monster_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('player_character_id', 'integer', [
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
            ->addColumn('starting_hit_points', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 9,
                'scale' => 3,
                'signed' => false,
            ])
            ->addColumn('current_hit_points', 'float', [
                'default' => null,
                'null' => false,
                'precision' => 9,
                'scale' => 3,
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
                    'monster_id',
                ]
            )
            ->addIndex(
                [
                    'player_character_id',
                ]
            )
            ->create();

        $this->table('player_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('age', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('max_hit_points', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('armour_class', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('dexterity_modifier', 'tinyinteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('alignment_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'alignment_id',
                ]
            )
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('puzzles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => '',
                'limit' => 250,
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
            ->addColumn('map', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('tags')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('title', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 250,
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
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'title',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('timeline_segments')
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
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
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
            ->addColumn('slug', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
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
                [
                    'campaign_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
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
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
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
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('campaign_users')
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

        $this->table('clans_users')
            ->addForeignKey(
                'clan_id',
                'clans',
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

        $this->table('combat_encounters')
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

        $this->table('combat_turns')
            ->addForeignKey(
                'combat_action_id',
                'combat_actions',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
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

        $this->table('monsters')
            ->addForeignKey(
                'alignment_id',
                'alignments',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'data_source_id',
                'data_sources',
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

        $this->table('non_playable_characters')
            ->addForeignKey(
                'alignment_id',
                'alignments',
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
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

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
                'monster_id',
                'monsters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'player_character_id',
                'player_characters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('player_characters')
            ->addForeignKey(
                'alignment_id',
                'alignments',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
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

        $this->table('puzzles')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('tags')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('timeline_segments')
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
        $this->table('campaign_users')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('clans_users')
            ->dropForeignKey(
                'clan_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('combat_encounters')
            ->dropForeignKey(
                'campaign_id'
            )->save();

        $this->table('combat_turns')
            ->dropForeignKey(
                'combat_action_id'
            )
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'source_participant_id'
            )
            ->dropForeignKey(
                'target_participant_id'
            )->save();

        $this->table('monsters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'data_source_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('non_playable_characters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('participants')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'monster_id'
            )
            ->dropForeignKey(
                'player_character_id'
            )->save();

        $this->table('player_characters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('puzzles')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('tags')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('timeline_segments')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('alignments')->drop()->save();
        $this->table('campaign_users')->drop()->save();
        $this->table('campaigns')->drop()->save();
        $this->table('character_classes')->drop()->save();
        $this->table('character_races')->drop()->save();
        $this->table('clans')->drop()->save();
        $this->table('clans_users')->drop()->save();
        $this->table('combat_actions')->drop()->save();
        $this->table('combat_encounters')->drop()->save();
        $this->table('combat_turns')->drop()->save();
        $this->table('conditions')->drop()->save();
        $this->table('data_sources')->drop()->save();
        $this->table('monster_instance_types')->drop()->save();
        $this->table('monsters')->drop()->save();
        $this->table('non_playable_characters')->drop()->save();
        $this->table('participants')->drop()->save();
        $this->table('player_characters')->drop()->save();
        $this->table('puzzles')->drop()->save();
        $this->table('tags')->drop()->save();
        $this->table('timeline_segments')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
