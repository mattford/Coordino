<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bug'), ['action' => 'edit', $bug->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bug'), ['action' => 'delete', $bug->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bug->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Bugs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bug'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bugs view large-9 medium-8 columns content">
    <h3><?= h($bug->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($bug->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Submitted') ?></th>
            <td><?= h($bug->submitted) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($bug->content)); ?>
    </div>
    <div class="row">
        <h4><?= __('Status') ?></h4>
        <?= $this->Text->autoParagraph(h($bug->status)); ?>
    </div>
</div>
