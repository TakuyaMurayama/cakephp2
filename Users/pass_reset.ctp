<?php
echo $this->Form->create('User');
echo $this->Form->input('pass');
echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$id));
echo $this->Form->submit('パスワード更新');
?>
