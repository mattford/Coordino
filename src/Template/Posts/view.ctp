<?php
	echo $this->Html->css('wmd.css');
	echo $this->Html->script('wmd/showdown.js');
	echo $this->Html->script('wmd/wmd.js');
	echo $this->Html->script('jquery/jquery.js');
        echo $this->Html->script('question.js');
?>
<script> //<![CDATA[    
  // When the page is ready
  $(document).ready(function(){
    $(".comment_area").hide();
    
    $(".comment_actions a").click(function(event){
      $(this).parents("div").prev(".comment_area").toggle();
	  $(this).toggle();
      
      // Stop the link click from doing its normal thing
      event.preventDefault();
    });

  });
//]]></script>

<?= $this->element('post', ['post' => $post, 'question' => $post]); ?>

<div id="answers">
    <h2>
        <?= __n('answer','answers',count($post->answers));?>
    </h2>
    <hr/>
    <?php if ($post->has('answers')): ?>
        <?php foreach($post->answers as $answer): ?>
            <?= $this->element('post', ['post' => $answer, 'question' => $post]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="user_answer">

	<h3><?php __('your answer'); ?></h3>
	<?=$this->Form->create('Post', ['url' => ['controller'=>'posts', 'action' => 'answer', $post->id]]); ?>

	<div id="wmd-button-bar" class="wmd-panel"></div>
	<?= $this->Form->textarea('content', ['id' => 'wmd-input', 'class' => 'wmd-panel']); ?>

	<div id="wmd-preview" class="wmd-panel"></div>
	
	<br/>
        <?= $this->Form->submit(__d('verb','Answer',true)); ?>
	<?= $this->Form->end(); ?>
</div>
