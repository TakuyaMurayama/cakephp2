<?php
echo $this->Form->create('User');
echo $this->Form->input('mail', array('name' => 'reset'));
echo $this->Form->submit('送信');
?>
