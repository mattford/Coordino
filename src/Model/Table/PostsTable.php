<?php
namespace Coordino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Coordino\Model\Entity\Post;

/**
 * Posts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentPosts
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $PostTags
 * @property \Cake\ORM\Association\HasMany $VotesHistory
 * @property \Cake\ORM\Association\HasMany $Answers
 * @property \Cake\ORM\Association\HasMany $Comments
 */
class PostsTable extends Table 
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

        $this->table('posts');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('ParentPosts', [
            'className' => 'Posts',
            'foreignKey' => 'parent_post_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PostTags', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('VotesHistory', [
            'className' => 'Votes',
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('Answers', [
            'className' => 'Posts',
            'foreignKey' => 'parent_post_id',
            'conditions' => [
                'type' => 'answer'
            ]
        ]);
        $this->hasMany('Comments', [
            'className' => 'Posts',
            'foreignKey' => 'parent_post_id',
            'conditions' => [
                'type' => 'comment'
            ]
        ]);
        
        $this->addBehavior('Timestamp');
        $this->addBehavior('Sluggable', ['slug' => 'url_title']);
        $this->addBehavior('Muffin/Footprint.Footprint', [
            'events' => [
                'Model.beforeSave' => [
                    'user_id' => 'new'
                ]
            ],
            'propertiesMap' => [
                'user_id' => '_footprint.id'
            ]
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', function($context) {
                return ($context['data']['type'] === 'question');
            })
            ->notEmpty('title', 'This field cannot be empty', function($context) {
                return ($context['data']['type'] === 'question');
            });

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->add('created', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('modified', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('votes', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('views', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('flags', 'valid', ['rule' => 'numeric']);

        $validator
            ->add('notify', 'valid', ['rule' => 'boolean']);

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
        $rules->add($rules->existsIn(['parent_post_id'], 'ParentPosts'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
    
    public function loadExistingVotes($userId) 
    {
        $this->hasMany('ExistingVotes', [
            'className' => 'Votes',
            'conditions' => [
                'user_id' => $userId
            ]
        ]);
    }
    
}
