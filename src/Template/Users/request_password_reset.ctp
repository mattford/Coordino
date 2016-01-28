<p>Enter the email address you used to register, if it is linked to an account, 
you will receive a password reset link shortly.</p>
<div class="block_label">
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('email', ['class' => 'large_input']);
    echo $this->Form->submit("Request reset");
    echo $this->Form->end();
?>
</div>
