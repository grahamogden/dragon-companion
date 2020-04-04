<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clans Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Clan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Clan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Clan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Clan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Clan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Clan findOrCreate($search, callable $callback = null, $options = [])
 */
class ClansTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('clans');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Users', [
            'foreignKey' => 'clan_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'clans_users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }

    /**
     * Before saving
     * 
     * @param Event $event
     * @param type $entity
     * @param type $options
     * @return bool
     */
    public function beforeSave(Event $event, $entity, $options): bool
    {
        if ($entity->users_string) {
            $entity->users = $this->_buildUsers($entity->users_string);
        }

        return true;
    }
    
    /**
     * Finds users records from the list provided and returns them to be added to the clan
     * 
     * @param string $usersString 
     * @return array
     */
    protected function _buildUsers(string $usersString): array
    {
        // Trim users
        $newUsers = array_map('trim', explode(',', $usersString));

        // Remove all empty users
        $newUsers = array_filter($newUsers);

        // Reduce duplicated users
        $newUsers = array_unique($newUsers);

        $out = [];
        $query = $this->Users->find()
            ->where(['Users.username IN' => $newUsers]);

        // Remove existing users from the list of new users.
        foreach ($query->extract('username') as $existing) {
            $index = array_search($existing, $newUsers);
            if ($index !== false) {
                unset($newUsers[$index]);
            }
        }

        // Add existing users.
        foreach ($query as $user) {
            $out[] = $user;
        }

        return $out;
    }
}
