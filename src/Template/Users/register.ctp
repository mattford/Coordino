<h2>Register</h2>

<div class="block_label">
    <?= $this->Form->create('User'); ?>

    <?= $this->Form->input('username', array('class' => 'large_input')); ?>

    <?= $this->Form->input('email', array('class' => 'large_input')); ?>

    <?= $this->Form->input('password', array('type' => 'password', 'label' => 'Password', 'class' => 'large_input')); ?> 	

    <?= $this->Form->submit('Register'); ?>
    <?= $this->Form->end(); ?>
</div>