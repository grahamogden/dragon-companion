<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

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

        $this->table('campaigns_roles')
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

        $this->table('characters')
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

        $this->table('characters_roles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('character_id', 'integer', [
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
            ->addIndex(
                [
                    'character_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->create();

        $this->table('characters_species')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('character_id', 'integer', [
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
            ->addIndex(
                [
                    'character_id',
                ]
            )
            ->addIndex(
                [
                    'species_id',
                ]
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
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('combat_encounters_roles')
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
            ->addColumn('role_id', 'integer', [
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
                    'role_id',
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
                    'character_id',
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
            ->addIndex(
                [
                    'campaign_id',
                ]
            )
            ->create();

        $this->table('roles_species')
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

        $this->table('roles_tags')
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
            ->addColumn('tag_id', 'integer', [
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
                    'tag_id',
                ]
            )
            ->create();

        $this->table('roles_timelines')
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
            ->addColumn('timeline_id', 'integer', [
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
                    'timeline_id',
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
            ->addColumn('species_name', 'string', [
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
                ['species_name']
            )
            ->addIndex(
                ['campaign_id']
            )
            ->addIndex(
                ['user_id']
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
            ->addColumn('campaign_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('tag_name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            // ->addColumn('slug', 'string', [
            //     'default' => null,
            //     'limit' => 250,
            //     'null' => false,
            // ])
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
                ['tag_name']
            )
            ->addIndex(
                ['campaign_id']
            )
            ->addIndex(
                ['user_id']
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
                'default' => null,
                'limit' => null,
                'null' => false,
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

        $this->table('campaigns_roles')
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

        $this->table('combat_encounters_roles')
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
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

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

        $this->table('characters')
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

        $this->table('characters_roles')
            ->addForeignKey(
                'character_id',
                'characters',
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

        $this->table('characters_species')
            ->addForeignKey(
                'character_id',
                'characters',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'species_id',
                'species',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('roles_species')
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

        $this->table('roles_tags')
            ->addForeignKey(
                'tag_id',
                'tags',
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

        $this->table('roles_timelines')
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

        $this->table('tags')
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
        $this->table('campaigns')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('campaigns_roles')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'role_id'
            )->save();

        $this->table('combat_encounters')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('combat_encounters_roles')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'role_id'
            )->save();

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

        $this->table('participants')
            ->dropForeignKey(
                'combat_encounter_id'
            )
            ->dropForeignKey(
                'character_id'
            )->save();

        $this->table('characters')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('characters_roles')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'character_id'
            )->save();

        $this->table('characters_species')
            ->dropForeignKey(
                'species_id'
            )
            ->dropForeignKey(
                'character_id'
            )->save();

        $this->table('roles_species')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'species_id'
            )->save();

        $this->table('roles_tags')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'tag_id'
            )->save();

        $this->table('roles_timelines')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'timeline_id'
            )->save();

        $this->table('roles_users')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('species')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('tags')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('timelines')
            ->dropForeignKey(
                'campaign_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('campaigns')->drop()->save();
        $this->table('campaigns_roles')->drop()->save();
        $this->table('characters')->drop()->save();
        $this->table('characters_roles')->drop()->save();
        $this->table('characters_species')->drop()->save();
        $this->table('combat_encounters')->drop()->save();
        $this->table('combat_encounters_roles')->drop()->save();
        $this->table('combat_turns')->drop()->save();
        $this->table('participants')->drop()->save();
        $this->table('roles')->drop()->save();
        $this->table('roles_species')->drop()->save();
        $this->table('roles_tags')->drop()->save();
        $this->table('roles_timelines')->drop()->save();
        $this->table('roles_users')->drop()->save();
        $this->table('species')->drop()->save();
        $this->table('tags')->drop()->save();
        $this->table('timelines')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
