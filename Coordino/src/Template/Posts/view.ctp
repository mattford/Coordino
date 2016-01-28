<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Post Tags'), ['controller' => 'PostTags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post Tag'), ['controller' => 'PostTags', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Votes'), ['controller' => 'Votes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vote'), ['controller' => 'Votes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="posts view large-9 medium-8 columns content">
    <h3><?= h($post->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($post->title) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $post->has('user') ? $this->Html->link($post->user->id, ['controller' => 'Users', 'action' => 'view', $post->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Url Title') ?></th>
            <td><?= h($post->url_title) ?></td>
        </tr>
        <tr>
            <th><?= __('Public Key') ?></th>
            <td><?= h($post->public_key) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($post->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Related Id') ?></th>
            <td><?= $this->Number->format($post->related_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Timestamp') ?></th>
            <td><?= $this->Number->format($post->timestamp) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Edited Timestamp') ?></th>
            <td><?= $this->Number->format($post->last_edited_timestamp) ?></td>
        </tr>
        <tr>
            <th><?= __('Votes') ?></th>
            <td><?= $this->Number->format($post->votes) ?></td>
        </tr>
        <tr>
            <th><?= __('Views') ?></th>
            <td><?= $this->Number->format($post->views) ?></td>
        </tr>
        <tr>
            <th><?= __('Flags') ?></th>
            <td><?= $this->Number->format($post->flags) ?></td>
        </tr>
        <tr>
            <th><?= __('Notify') ?></th>
            <td><?= $post->notify ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="row">
        <h4><?= __('Type') ?></h4>
        <?= $this->Text->autoParagraph(h($post->type)); ?>
    </div>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($post->content)); ?>
    </div>
    <div class="row">
        <h4><?= __('Status') ?></h4>
        <?= $this->Text->autoParagraph(h($post->status)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tags') ?></h4>
        <?= $this->Text->autoParagraph(h($post->tags)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Post Tags') ?></h4>
        <?php if (!empty($post->post_tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Post Id') ?></th>
                <th><?= __('Tag Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($post->post_tags as $postTags): ?>
            <tr>
                <td><?= h($postTags->post_id) ?></td>
                <td><?= h($postTags->tag_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PostTags', 'action' => 'view', $postTags->]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'PostTags', 'action' => 'edit', $postTags->]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PostTags', 'action' => 'delete', $postTags->], ['confirm' => __('Are you sure you want to delete # {0}?', $postTags->)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Votes') ?></h4>
        <?php if (!empty($post->votes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Post Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Timestamp') ?></th>
                <th><?= __('Type') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($post->votes as $votes): ?>
            <tr>
                <td><?= h($votes->id) ?></td>
                <td><?= h($votes->post_id) ?></td>
                <td><?= h($votes->user_id) ?></td>
                <td><?= h($votes->timestamp) ?></td>
                <td><?= h($votes->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Votes', 'action' => 'view', $votes->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Votes', 'action' => 'edit', $votes->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Votes', 'action' => 'delete', $votes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $votes->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
