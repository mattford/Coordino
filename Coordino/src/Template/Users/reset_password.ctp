<p>Please enter a new password below</p>
<div class="block_label">
<?= $this->Form->create('User'); ?>
<?= $this->Form->input('password'); ?>
<?= $this->Form->submit('Reset password'); ?>
<?= $this->Form->end(); ?>

</div>