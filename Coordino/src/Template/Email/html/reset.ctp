<p>Hi <?= $user->username ;?>,</p>

<p>Someone requested a password reset for your account.</p>
<p>If this was not you, please ignore this message, the following link will expire after 24 hours.</p>


<p>Please click <?= $this->Html->link('here', ['controller'=>'users', 'action'=>'resetPassword', $user->id, $user->reset_key, '_full' => true]); ?> to reset your password.</p>

<p>As always, thank you for using our site!</p>