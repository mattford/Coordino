<?php
	echo $this->Html->css('wmd.css');
	echo $this->Html->script('wmd/showdown.js');
	echo $this->Html->script('wmd/wmd.js');
	
	echo $this->Html->script('jquery/jquery.js');
	echo $this->Html->script('jquery/jquery.bgiframe.min.js');
	echo $this->Html->script('jquery/jquery.ajaxQueue.js');
	echo $this->Html->script('jquery/thickbox-compressed.js');
	echo $this->Html->script('jquery/jquery.autocomplete.js');
	
	echo $this->Html->css('thickbox.css');
	echo $this->Html->css('jquery.autocomplete.css');
?>

<script>
$(document).ready(function(){
    $("#resultsContainer").show("blind");

    $.get('/tags/index.json', function(data) {
         var tags = JSON.parse(data);
        $("#tag_input").autocomplete(tags, {
            minChars: 0,
            multiple: true,
            width: 350,
            matchContains: true,
            autoFill: false,
            formatItem: function(row, i, max) {
                    return row.name + " (<strong>" + row.count + "</strong>)";
            },
            formatMatch: function(row, i, max) {
                    return row.name + " " + row.count;
            },
            formatResult: function(row) {
                    return row.name;
            }
        });
    })

    $("#PostTitle").blur(function(){
        if($("#PostTitle").val().length >= 10) {
            $("#title_status").toggle();
            getResults();
        } else {
            $("#title_status").show();
        }
    });

    function getResults()
    {	
        $.get("/mini_search",{query: $("#PostTitle").val(), type: "results"}, function(data){
            $("#resultsContainer").html(data);
            $("#resultsContainer").show("blind");
        });
    }	

    $("#PostTitle").keyup(function(event){
        if($("#PostTitle").val().length < 10) {
            $("#title_status").html('<span class="red"><?= __('Titles must be at least 10 characters long.',true) ?></span>');
        } else {
            $("#title_status").html('<?= __('What is your question about?',true) ?>');
        }
    });

});
</script>
<h2><?= __('Ask a question',true) ?></h2>

<?=$this->Form->create('Post');?>
<?=$this->Form->label(__('Title',true));?><br/>

<?=$this->Form->text('title', ['class' => 'wmd-panel big_input', 'id'=>'PostTitle']);?><br/>
<span id="title_status" class="quiet">
    <?= __('What is your question about?',true) ?>
</span>
<div id="resultsContainer"></div>

<div id="wmd-button-bar" class="wmd-panel"></div>
<?= $this->Form->textarea('content', [
	'id' => 'wmd-input', 'class' => 'wmd-panel'
    ]);
 ?>

<div id="wmd-preview" class="wmd-panel"></div>

<?= $this->Form->label(__('Tags',true)); ?><br/>
<?= $this->Form->text('tags', array('id' => 'tag_input', 'class' => 'wmd-panel big_input')); ?><br/>
<span id="tag_status" class="quiet">
    <?= __('Combine multiple words into single-words.',true) ?>
</span>

<br><br>

<?=$this->Form->checkbox('notify', array('checked' => true));?>
<span style="margin-left: 5px;">
    <?= __('Notify me when my question is answered.',true) ?>
</span>
<?= $this->Form->submit( __('Ask a question',true)); ?>
<?= $this->Form->end(); ?>

