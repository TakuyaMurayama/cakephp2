<div class="users form">
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo '新規会員登録'; ?></legend>
		<?php echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		?>
	</fieldset>
	<?php  echo $this->Form->end(__('Submit')); ?>
</div>
