<div class="user_info wrapper">
    <div style="float: left;">
        <div class="thumb_with_border">
        <?php if ($user->has('image') && !empty($user->image)): ?>
             <?= $this->Html->image($user->image, ['height' => 25, 'width' => 25, 'url' => ['controller'=>'users', 'action'=>'view', $user->username]]); ?>
        <?php else: ?>
            <?= $this->Html->image('answerAvatar.png', ['height' => 25, 'width' => 25, 'url' => ['controller'=>'users', 'action'=>'view', $user->username]]); ?>
        <?php endif; ?>
         </div>

    </div>
    <div style="float: left; line-height: .9;">
        <div>
            <?= $this->Html->link($post->user->username,['controller'=>'users', 'action'=>'view', $post->user->username]); ?> 
            <span style="font-size: 8pt;">&#8226;</span>
            <h4 style="display: inline;" class="user-<?=$user->id;?>-rep"><?= $user->reputation; ?></h4>
        </div> 
        <span class="quiet"><?=$verb;?> <?=$created->timeAgoInWords();?></span>
    </div>
    <div style="clear: both;"></div>
</div>