<?= $this->Form->create($user, ['enctype' => 'multipart/form-data']); ?>
<div>
    <h3><?= __('Profile Image'); ?></h3>
    <?php if ($user->has('image')): ?>
        <?= $this->Html->image($user->image, ['width' => 75, 'height' => 75]); ?>
    <?php else: ?>
        <?= $this->Html->image('answerAvatar.png', ['width' => 75, 'height' => 75]); ?>
    <?php endif; ?>
    <h4>Upload a new image</h4>
    <?= $this->Form->file('image'); ?>
</div>

<div class="detailed_inputs">
	<div>
		<h3>Email Address <span class="small">An email address we can contact you at.</span></h3>
		<?= $this->Form->input('email', ['label' => false]); ?>
	</div>
	<div>
		<h3>Age <span class="small">An optional age to show.</span></h3>
		<?= $this->Form->input('age', ['label' => false]); ?>
	</div>
	<div>
		<h3>Location <span class="small">Where are you located?</span></h3>
		<?= $this->Form->input('location', ['label' => false]); ?>
	</div>
	<div>
		<h3>Website <span class="small">Have a website or social profile?</span></h3>
		<?= $this->Form->input('website', ['label' => false]); ?>
	</div>
	<div>
		<h3>Summary <span class="small">Tell us a little about yourself.</span></h3>
		<?= $this->Form->textarea('info'); ?>
	</div>
	<div>
		<h3>Password Change <span class="small">Set a new password. Leave blank if you do not wish to change your password.</span></h3>
		<?= $this->Form->input('new_password', ['label' => false, 'value' => '']); ?>
	</div>
	<div class="submit">
            <?= $this->Form->submit('Update your account'); ?>
	</div>
</div>
<?= $this->Form->end(); ?>