<?php
echo $this->Html->css('wmd.css');
echo $this->Html->script('wmd/showdown.js');
echo $this->Html->script('wmd/wmd.js');

echo $this->Html->script('jquery/jquery.js');
echo $this->Html->script('jquery/jquery.bgiframe.min.js');
echo $this->Html->script('jquery/jquery.ajaxQueue.js');
echo $this->Html->script('jquery/thickbox-compressed.js');
echo $this->Html->script('jquery/jquery.autocomplete.js');
echo $this->Html->script('/tags/suggest');

echo $this->Html->css('thickbox.css');
echo $this->Html->css('jquery.autocomplete.css');

echo $this->Form->create('Widget');
echo $this->Form->hidden('location');
?>
<div class="detailed_inputs">
    <div>
        <h3>Title <span class="small">The large text that appears on the top of a widget.</span></h3>
        <?= $this->Form->input('title'); ?>
    </div>
    <div>
        <h3>Content <span class="small">What would you like to say?.</span></h3>
        <div id="wmd-button-bar" class="wmd-panel"></div>
        <?= $this->Form->textarea('content', ['id' => 'wmd-input', 'class' => 'wmd-panel']); ?><br />
        <?= $this->Form->checkbox('global', ['style' => 'width: 15px;']); ?> Show this Widget on all pages
    </div>
    <div id="wmd-preview" class="wmd-panel"></div>
    <div class="submit">
        <?= $this->Form->submit('Update this widget');
    </div>
</div>
<?= $this->Form->end();