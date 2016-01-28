<?php
namespace Coordino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Coordino\Model\Entity\PostsRev;

/**
 * PostsRevs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Versions
 * @property \Cake\ORM\Association\BelongsTo $Relateds
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class PostsRevsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('posts_revs');
        $this->displayField('title');
        $this->primaryKey('version_id');

        $this->belongsTo('Versions', [
            'foreignKey' => 'version_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Relateds', [
            'foreignKey' => 'related_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('version_created', 'valid', ['rule' => 'datetime'])
            ->requirePresence('version_created', 'create')
            ->notEmpty('version_created');

        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->add('timestamp', 'valid', ['rule' => 'numeric'])
            ->requirePresence('timestamp', 'create')
            ->notEmpty('timestamp');

        $validator
            ->add('last_edited_timestamp', 'valid', ['rule' => 'numeric'])
            ->requirePresence('last_edited_timestamp', 'create')
            ->notEmpty('last_edited_timestamp');

        $validator
            ->add('votes', 'valid', ['rule' => 'numeric'])
            ->requirePresence('votes', 'create')
            ->notEmpty('votes');

        $validator
            ->requirePresence('url_title', 'create')
            ->notEmpty('url_title');

        $validator
            ->requirePresence('public_key', 'create')
            ->notEmpty('public_key');

        $validator
            ->add('views', 'valid', ['rule' => 'numeric'])
            ->requirePresence('views', 'create')
            ->notEmpty('views');

        $validator
            ->requirePresence('tags', 'create')
            ->notEmpty('tags');

        $validator
            ->add('flags', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('flags');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['version_id'], 'Versions'));
        $rules->add($rules->existsIn(['related_id'], 'Relateds'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
