<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Widgets'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="widgets form large-9 medium-8 columns content">
    <?= $this->Form->create($widget) ?>
    <fieldset>
        <legend><?= __('Add Widget') ?></legend>
        <?php
            echo $this->Form->input('page');
            echo $this->Form->input('location');
            echo $this->Form->input('title');
            echo $this->Form->input('content');
            echo $this->Form->input('global');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
