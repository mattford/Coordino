<p>
	<?php __("You are currently an anonymous user. Login below to sign into your account"); ?>.
</p>
<p>
	Want to get an account? 
	<?=$this->Html->link('Register', ['controller' => 'users', 'action' => 'register']); ?>	
</p>
<div id="login_panel" class="block_label">
<?php
    $this->Flash->render('auth');
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('username', array('class' => 'large_input'));
    echo $this->Form->input('password', array('class' => 'large_input'));
    echo $this->Form->submit('Login');
    echo $this->Form->end();
?>
</div>
<p>
	Forget your password?  Click <?= $this->Html->link('here', ['controller'=>'Users', 'action'=>'requestPasswordReset']); ?>.
</p>