<div class="users form">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend>
			<?php echo 'メールアドレスとパスワードをお願い致します'; ?>
		</legend>
		<?php echo $this->Form->input('email');
		echo $this->Form->input('password');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Login')); ?>
</div>
