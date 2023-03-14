<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
    {

    public $autoId = false;

    public function up()
        {

        $this->table('alignments')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 3,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('member_status', 'integer', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('account_level', 'integer', [
                'default' => '0',
                'limit' => 2,
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
                'limit' => 11,
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
                'limit' => 11,
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

        $this->table('character_classes_player_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('character_class_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('player_character_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'character_class_id',
                ]
            )
            ->addIndex(
                [
                    'player_character_id',
                ]
            )
            ->create();

        $this->table('character_races')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
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

        $this->table('character_races_player_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('character_race_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('player_character_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'character_race_id',
                ]
            )
            ->addIndex(
                [
                    'player_character_id',
                ]
            )
            ->create();

        $this->table('clans')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
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
                'limit' => 11,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('clan_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('member_status', 'integer', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
            ])
            ->addColumn('account_level', 'integer', [
                'default' => '0',
                'limit' => 2,
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
                'limit' => 3,
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
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('visible', 'integer', [
                'default' => '0',
                'limit' => 1,
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
                'limit' => 11,
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
                'limit' => 11,
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
                'limit' => 11,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('combat_encounter_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('round_number', 'integer', [
                'comment' => 'The current round number that this turn is in',
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('turn_order', 'integer', [
                'comment' => 'The incrementing number that represents when this precise turn occurred in combat',
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('source_participant_id', 'integer', [
                'comment' => 'The participant that initiates the action. This can be null as damage may be taken due to environmental conditions but the environment is not a participant.',
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('target_participant_id', 'integer', [
                'comment' => 'The participant that receives the action (be that damage or healing), which can never be null as something will always happen to someone.',
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('combat_action_id', 'integer', [
                'comment' => 'Foreign key to the combat_actions table and represents what action the user took for their turn - attack, heal, disengage, pass their turn, etc.',
                'default' => null,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('roll_total', 'integer', [
                'comment' => 'The total roll of the user\'s dice to initiate the action. For example, the total of rolling 4d10 + 5 = 29',
                'default' => null,
                'limit' => 4,
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
                'limit' => 3,
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
                'limit' => 11,
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

        $this->table('conditions_participants')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('condition_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('participant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'condition_id',
                ]
            )
            ->addIndex(
                [
                    'participant_id',
                ]
            )
            ->create();

        $this->table('data_sources')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 3,
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
                'limit' => 11,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
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
                'limit' => 3,
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
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('dexterity_modifier', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('monster_instance_type_id', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('visibility', 'string', [
                'default' => 'PRIVATE',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('alignment_id', 'integer', [
                'default' => null,
                'limit' => 3,
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
                'limit' => 11,
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
                'limit' => 6,
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
                'limit' => 3,
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
                'limit' => 11,
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

        $this->table('non_playable_characters_timeline_segments')
            ->addColumn('non_playable_character_id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['non_playable_character_id'])
            ->addColumn('timeline_segment_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->create();

        $this->table('participants')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('player_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => 11,
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
                'limit' => 7,
                'null' => false,
            ])
            ->addColumn('max_hit_points', 'integer', [
                'default' => null,
                'limit' => 6,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('armour_class', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('dexterity_modifier', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('alignment_id', 'integer', [
                'default' => null,
                'limit' => 3,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('tags')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
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
                'limit' => 11,
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

        $this->table('tags_timeline_segments')
            ->addColumn('tag_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('timeline_segment_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['tag_id', 'timeline_segment_id'])
            ->addIndex(
                [
                    'tag_id',
                ]
            )
            ->addIndex(
                [
                    'timeline_segment_id',
                ]
            )
            ->create();

        $this->table('timeline_segments')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('parent_id', 'integer', [
                'default' => null,
                'limit' => 11,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('lft', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('rght', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('level', 'integer', [
                'default' => null,
                'limit' => 11,
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
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('player_character_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('participant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'player_character_id',
                ]
            )
            ->addIndex(
                [
                    'participant_id',
                ]
            )
            ->create();

        $this->table('campaign_users')
            ->addForeignKey(
                'campaign_id',
                'campaigns',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('character_classes_player_characters')
            ->addForeignKey(
                'character_class_id',
                'character_classes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'player_character_id',
                'player_characters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('character_races_player_characters')
            ->addForeignKey(
                'character_race_id',
                'character_races',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'player_character_id',
                'player_characters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'combat_encounter_id',
                'combat_encounters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'source_participant_id',
                'participants',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'target_participant_id',
                'participants',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('conditions_participants')
            ->addForeignKey(
                'condition_id',
                'conditions',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'participant_id',
                'participants',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'data_source_id',
                'data_sources',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'monster_id',
                'monsters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'player_character_id',
                'player_characters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'campaign_id',
                'campaigns',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
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
                    'delete' => 'RESTRICT'
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
                    'delete' => 'RESTRICT'
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
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
        {
        $this->table('campaign_users')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('character_classes_player_characters')
            ->dropForeignKey(
                'character_class_id'
            )
            ->dropForeignKey(
                'player_character_id'
            );

        $this->table('character_races_player_characters')
            ->dropForeignKey(
                'character_race_id'
            )
            ->dropForeignKey(
                'player_character_id'
            );

        $this->table('clans_users')
            ->dropForeignKey(
                'clan_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('combat_encounters')
            ->dropForeignKey(
                'campaign_id'
            );

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
            );

        $this->table('conditions_participants')
            ->dropForeignKey(
                'condition_id'
            )
            ->dropForeignKey(
                'participant_id'
            );

        $this->table('monsters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'data_source_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('non_playable_characters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('participants')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'monster_id'
            )
            ->dropForeignKey(
                'player_character_id'
            );

        $this->table('player_characters')
            ->dropForeignKey(
                'alignment_id'
            )
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->table('puzzles')
            ->dropForeignKey(
                'user_id'
            );

        $this->table('tags')
            ->dropForeignKey(
                'user_id'
            );

        $this->table('timeline_segments')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            );

        $this->dropTable('alignments');
        $this->dropTable('campaign_users');
        $this->dropTable('campaigns');
        $this->dropTable('character_classes');
        $this->dropTable('character_classes_player_characters');
        $this->dropTable('character_races');
        $this->dropTable('character_races_player_characters');
        $this->dropTable('clans');
        $this->dropTable('clans_users');
        $this->dropTable('combat_actions');
        $this->dropTable('combat_encounters');
        $this->dropTable('combat_turns');
        $this->dropTable('conditions');
        $this->dropTable('conditions_participants');
        $this->dropTable('data_sources');
        $this->dropTable('monster_instance_types');
        $this->dropTable('monsters');
        $this->dropTable('non_playable_characters');
        $this->dropTable('participants');
        $this->dropTable('permissions');
        $this->dropTable('player_characters');
        $this->dropTable('puzzles');
        $this->dropTable('roles');
        $this->dropTable('tags');
        $this->dropTable('timeline_segments');
        $this->dropTable('users');
    }
}
