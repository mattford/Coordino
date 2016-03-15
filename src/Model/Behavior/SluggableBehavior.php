<?php
namespace Coordino\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\Datasource\EntityInterface;
use Cake\Utility\Inflector;

class SluggableBehavior extends Behavior
{
    protected $_defaultConfig = [
        'field' => 'title',
        'slug' => 'slug',
        'replacement' => '-',
        'when' => 'new'
    ];    


    public function slug(Entity $entity)
    {
        $config = $this->config();
        $value = $entity->get($config['field']);
        $entity->set($config['slug'], Inflector::slug($value, $config['replacement']));
    }

    public function beforeSave(Event $event, EntityInterface $entity)
    {
        $config = $this->config();
        $new = $entity->isNew();
        
        if (
            $config['when'] === 'always' || 
            ($config['when'] === 'new' && $new) ||
            ($config['when'] === 'existing' && !$new)
        ) {
            $this->slug($entity);
        }
        
    }

}

