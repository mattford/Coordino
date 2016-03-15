<div class="comment" id="comment_<?=$comment->id;?>">
    <?= $comment->content; ?> &ndash; 

    <?=$this->Html->link($comment->user->username, ['controller' => 'users', 'action' => 'view', $comment->user->username]); ?>

    <span class="quiet">
        <?=$comment->created->timeAgoInWords(); ?>
    </span>
</div>