<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'A username is required'
			)
		),
		'password' => array(
			'rule' => 'notBlank',
			'message' => 'A password is required'
		),
		'pass' => array(
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'notBlank',
				'allowEmpty' => false,
			)
		),
		'email' => array(
			'required' => array(
				'rule' => 'isUnique',
				'message' => 'すでに使われているアドレス'
			)
		),
		'image'=>array(
			'rule1' => array(
				'rule' => array('extension',array('jpg','jpeg','gif','png')),
				'message' => '画像ではありません。',
				'allowEmpty' => true,
			),
			'rule2' => array(
				'rule' => array('fileSize', '<=', '500000'),
				'message' => '画像サイズは500KB以下でお願いします',
			)
		),
		'reset' => array(
				'rule1' => array(
					'rule' => 'email',
				),
			),
		);
}
