<h3>名前</h3>
<h1><?php echo $user_info['User']['username']; ?></h1>
<h3>メールアドレス</h3>
<h1><?php echo $user_info['User']['email']; ?></h1>
<h3>コメント</h3>
<?php if ($user_info['User']['comment'] === null || empty($user_info['User']['comment'])){
echo "コメントが登録されていません";
} else {
echo $user_info['User']['comment'];
}
?>
<h3>画像</h3>
<?php
if ($pic['User']['img'] === null) {
echo "画像が登録されていません";
} else {
echo $this->Html->image($pic['User']['img'], array('width'=>'300', 'height'=>'300'));
}
?>
<!--編集 -->
<?php if ($total === 1) {
echo'<br>' . $this->Html->link('コメントを編集', array('action' => 'user_info_edit', $user_info['User']['id'])) . '<br>';
echo $this->Html->link('画像を編集', array('action' => 'user_pic', $user_info['User']['id']));
}
