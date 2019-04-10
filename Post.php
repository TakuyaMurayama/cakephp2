<?php
class Post extends AppModel{
	public $belongsTo = array(
		'User' => array(
			'classname' => 'User',
			'foreignkey' => 'user_id'
		)
	);
	public $validate = array(
		'title' => array(
			'rule' => 'notBlank'
		),
		'body' => array(
			'rule' => 'notBlank'
		)
	);
	public function isOwnedBy($post, $user) {
		    return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}
}
