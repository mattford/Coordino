<?php
    switch ($post->type): 
        case 'question':
            $class = 'question';
            break;
        case 'answer':
            $class = ($post->status === 'correct') ? 'answered' : 'answer';
            break;
    endswitch;
?>
<div id="<?= ($post->type === 'question') ? 'question' : 'a_'.$post->id; ?>" class="<?= $class; ?>">
    <div class="content_container wrapper">
        <div class="content_actions" style="float: left; width: 55px; margin-right: 10px;">
            <span class="upvote"></span>
            <?php if ($post->hasExistingVote('up')): ?>
                <?= $this->Html->image('arrow_up_orange.png', ['alt' => 'Vote Up', 'class' => 'upvote upvoted', 'data-postId' => $post->id, 'id' => 'upvote-'.$post->id]); ?>
            <?php else: ?>
                <?= $this->Html->image('arrow_up.png', ['alt' => 'Vote Up',  'class' => 'upvote', 'data-postId' => $post->id, 'id' => 'upvote-'.$post->id]); ?>
            <?php endif; ?>
            <span class="large_text quiet" style="display: block; padding: 0px; margin: 0px;">
                <strong id="votes-<?=$post->id;?>"><?= ($post->has('votes') && !empty($post->votes)) ? $post->votes : 0; ?></strong>
            </span>
            <?php if ($post->hasExistingVote('down')): ?>           
                <?= $this->Html->image('arrow_down_orange.png', ['alt' => 'Vote Down',  'class' => 'downvote downvoted', 'data-postid' => $post->id, 'id' => 'downvote-'.$post->id]);  ?>
            <?php else: ?>
                <?= $this->Html->image('arrow_down.png', ['alt' => 'Vote Down',  'class' => 'downvote', 'data-postid' => $post->id, 'id' => 'downvote-'.$post->id]);  ?>
            <?php endif; ?>

            <?php if ($post->type === 'answer' && $post->status != 'correct' && $question->status != 'closed'): ?>
                <div class="checkmark">
                    <?=$this->Html->link('', ['controller' => 'posts', 'action' => 'solved', $question->id, $post->id]); ?>
                </div>
            <?php elseif ($post->type === 'answer' && $post->status == 'correct'): ?>
                <?= $this->Html->image('checkmark_green.png'); ?>
            <?php endif; ?>
	</div>
	<div class="question_content" style="float: left; width: 600px;">
            <h2><?=$post->title;?></h2>
            <?=$post->content;?>
	</div>
    </div>

    <div class="post_actions wrapper">

	<div style="width: 100px; float: left;">
            <?=$this->Html->link(__('flag',true), ['controller' => 'posts', 'action' => 'flag', $post->id]); ?>

            <?php if (isset($currentUser) && $currentUser->hasPermission('edit', $post->id)): ?>
                    | 
                    <?= $this->Html->link(__('edit', true), ['controller'=>'posts', 'action'=> 'edit', $post->id]); ?>
            <?php endif; ?>

            <?php if (isset($currentUser) && $currentUser->hasPermission('delete', $post->id)): ?>
                   | <?= $this->Html->link(__('del',true), ['controller' => 'posts', 'action' => 'delete', $post->id]); ?>
            <?php endif; ?>
       
        </div>
        
        <?php if($post->has('modified')): ?>
            <div style="width: 275px; float: left; text-align: center;">
                    edited <strong><?= $post->modified->timeAgoInWords();?></strong>
            </div>
        <?php endif; ?>

        <?= $this->element('user_info', ['user' => $post->user, 'verb' => ($post->type === 'question' ? 'asked' : 'answered'), 'created' => $post->created]); ?>
    </div>

    <div id="tags" style="clear: left;">
        <?php if ($post->has('post_tags') && !empty($post->post_tags)): ?>
            <?php foreach($post->post_tags as $tag): ?>
                <div class="tag">
                    <?= $this->Html->link($tag->tag->name, ['controller' => 'posts', 'action' => 'tag', $tag->tag->slug]); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div style='clear:both;'></div>


<?php if ($post->has('comments') && !empty($post->comments)): ?>
    <div id="question_comments">
        <?php foreach($post->comments as $comment): ?>
             <?= $this->element('comment', ['comment' => $comment]); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <div id="comment_form" class="comment_area">
        <?= $this->Form->create('Post', ['url' => ['controller' => 'posts', 'action' => 'comment', $post->id]]); ?>
        <?= $this->Form->text('content', array('class' => 'comment_input')); ?>
        <?= $this->Form->submit("Comment"); ?>
        <?= $this->Form->end(); ?>
    </div>
    <div class="comment_actions">
        <?= $this->Html->link(__('add comment',true), '#'); ?>
    </div>

</div>