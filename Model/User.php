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
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'A password is required'
			)
		),
		'email' => array(
			'required' => array(
				'rule' => 'isUnique',
				'message' => 'すでに使われているアドレス'
			)
		),
		'image' => array(
			'upload-file' => array(
				'rule' => array( 'uploadError'),
				'message' => array( 'Error uploading file')
			),
			'extension' => array(
				'rule' => array( 'extension', array(
					'jpg', 'jpeg', 'png', 'gif')
				),
				'message' => array( 'file extension error')
			),
			'mimetype' => array(
				'rule' => array( 'mimeType', array(
					'image/jpeg', 'image/png', 'image/gif')
				),
				'message' => array( 'MIME type error')
			),
			'size' => array(
				'maxFileSize' => array(
					'rule' => array( 'fileSize', '<=', '10MB'),
					'message' => array( 'file size error')
				),
				'minFileSize' => array(
					'rule' => array( 'fileSize', '>',  0),
					'message' => array( 'file size error')
				),
			),
		),
	);
}

