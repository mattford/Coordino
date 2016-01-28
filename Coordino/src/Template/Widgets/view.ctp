<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Widget'), ['action' => 'edit', $widget->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Widget'), ['action' => 'delete', $widget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $widget->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Widgets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Widget'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="widgets view large-9 medium-8 columns content">
    <h3><?= h($widget->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Page') ?></th>
            <td><?= h($widget->page) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($widget->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($widget->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($widget->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Global') ?></th>
            <td><?= $this->Number->format($widget->global) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($widget->content)); ?>
    </div>
</div>
