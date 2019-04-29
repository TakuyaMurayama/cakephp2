<?php
echo $this->Form->create('User', array('type' => 'file', 'enctype' => 'multipart/form-data'));
echo $this->Form->image('image', array('type' => 'file', 'multiple', 'label' => '画像'));
echo $this->Form->submit('アップロード', array('name' => 'submit'));
echo $this->Form->submit('現在の画像を削除', array('name' => 'delete'));
?>
