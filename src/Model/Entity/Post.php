<?php
namespace Coordino\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity.
 *
 * @property int $id
 * @property string $type
 * @property int $related_id
 * @property \Coordino\Model\Entity\Related $related
 * @property string $title
 * @property string $content
 * @property string $status
 * @property int $timestamp
 * @property int $last_edited_timestamp
 * @property int $user_id
 * @property \Coordino\Model\Entity\User $user
 * @property \Coordino\Model\Entity\Vote[] VotesHistory
 * @property int $votes
 * @property string $url_title
 * @property string $public_key
 * @property int $views
 * @property string $tags
 * @property int $flags
 * @property bool $notify
 * @property \Coordino\Model\Entity\PostTag[] $post_tags
 */
class Post extends Entity
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
    
    protected function _setContent($text)
    {
        return \Parsedown::instance()->text($text);
    }
   
    public function hasExistingVote($type)
    {
        if ($this->has('existing_votes') && !empty($this->existing_votes)) {
            foreach ($this->existing_votes as $vote) {
                if ($vote->type === $type) {
                    return true;
                }
            }
        }
        return false;
    }
}
