<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Post Tags'), ['controller' => 'PostTags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post Tag'), ['controller' => 'PostTags', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="posts form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('Add Post') ?></legend>
        <?php
            echo $this->Form->input('type');
            echo $this->Form->input('related_id');
            echo $this->Form->input('title');
            echo $this->Form->input('content');
            echo $this->Form->input('status');
            echo $this->Form->input('timestamp');
            echo $this->Form->input('last_edited_timestamp');
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('votes');
            echo $this->Form->input('url_title');
            echo $this->Form->input('public_key');
            echo $this->Form->input('views');
            echo $this->Form->input('tags');
            echo $this->Form->input('flags');
            echo $this->Form->input('notify');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
