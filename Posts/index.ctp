<h1>掲示板</h1>
<p>
<?php
if (!isset($user)) {
echo $this->Html->link('ログイン', array('controller' => 'users', 'action' => 'login'));
}
?>
</p>
<p><?php echo $this->Html->link('新規投稿', array('action' => 'add'));?></p>
<p>
<?php
if (!isset($user)) {
echo $this->Html->link('新規会員登録', array('controller' => 'users', 'action' => 'add'));
}
?>
</p>
<table>
	<tr>
		<th>id</th>
		<th>username</th>
		<th>Title</th>
		<th>Actions</th>
		<th>Created</th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td>
			<?php
			echo $post['Post']['id'];
			?>
		</td>
		<td>
			<?php
			echo $post['User']['username'];
			?>
		</td>
		<td>
			<?php
			echo $this->Html->link(
			$post['Post']['title'],
			array('action' => 'view', $post['Post']['id'])
			);
			?>
		</td>
		<td>
			<?php
			if (isset($userdata) && ($userdata === $post['Post']['user_id'])){
			echo $this->Form->postLink(
			'削除',
			array('action' => 'delete', $post['Post']['id']),
			array('confirm' => '削除しますか?')
			);
			echo $this->Html->link(
			'編集', array('action' => 'edit', $post['Post']['id'])
			);}
			?>
		</td>
		<td>
			<?php echo $post['Post']['created']; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php
	if (isset($user)) {
	echo $this->Html->link('ログアウト', array('controller' => 'users', 'action' => 'logout'));
	}else {
	return false;
	}
	?>
</table>
