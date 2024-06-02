<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CharactersSpecies Model
 *
 * @property \App\Model\Table\CharactersTable&\Cake\ORM\Association\BelongsTo $Characters
 * @property \App\Model\Table\SpeciesTable&\Cake\ORM\Association\BelongsTo $Species
 *
 * @method \App\Model\Entity\CharactersSpecies newEmptyEntity()
 * @method \App\Model\Entity\CharactersSpecies newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CharactersSpecies> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CharactersSpecies get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CharactersSpecies findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CharactersSpecies patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CharactersSpecies> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CharactersSpecies|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CharactersSpecies saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersSpecies>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersSpecies>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersSpecies>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersSpecies> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersSpecies>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersSpecies>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CharactersSpecies>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CharactersSpecies> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CharactersSpeciesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('characters_species');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Characters', [
            'foreignKey' => 'character_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Species', [
            'foreignKey' => 'species_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('character_id')
            ->notEmptyString('character_id');

        $validator
            ->nonNegativeInteger('species_id')
            ->notEmptyString('species_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['character_id'], 'Characters'), ['errorField' => 'character_id']);
        $rules->add($rules->existsIn(['species_id'], 'Species'), ['errorField' => 'species_id']);

        return $rules;
    }
}
