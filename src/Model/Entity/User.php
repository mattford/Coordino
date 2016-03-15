<?php
namespace Coordino\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $username
 * @property string $url_title
 * @property string $email
 * @property string $password
 * @property int $joined
 * @property int $reputation
 * @property string $website
 * @property string $location
 * @property int $age
 * @property string $info
 * @property string $permission
 * @property string $ip
 * @property int $answer_count
 * @property int $comment_count
 * @property int $question_count
 * @property string $image
 * @property string $reset_key
 * @property int $joined
 * @property \Coordino\Model\Entity\Badge[] $badges
 * @property \Coordino\Model\Entity\Comment[] $comments
 * @property \Coordino\Model\Entity\History[] $histories
 * @property \Coordino\Model\Entity\Post[] $posts
 * @property \Coordino\Model\Entity\PostsRev[] $posts_revs
 * @property \Coordino\Model\Entity\Vote[] $votes
 */
class User extends Entity
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
    
    /**
     * Fields to hide in array format
     * 
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
    
    /**
     * Hash the password before saving
     */
    protected function _setPassword($password) 
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }       
    }
    
    public function hasPermission($permission, $postId) 
    {
        return true;
    }
}
