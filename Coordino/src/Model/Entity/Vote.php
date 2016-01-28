<?php
namespace Coordino\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vote Entity.
 *
 * @property int $id
 * @property int $post_id
 * @property \Coordino\Model\Entity\Post $post
 * @property int $user_id
 * @property \Coordino\Model\Entity\User $user
 * @property int $timestamp
 * @property string $type
 */
class Vote extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
