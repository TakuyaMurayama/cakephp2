<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $helpers = array(
		"Form",
	);
	
	public $components = array('Paginator', 'Session');
	
	public $uses = ['User'];

	public function beforeFilter() {
		parent::beforeFilter();
		$username = $this->User->find('all');
		$this->Session->write('username',$username);
		$this->Auth->allow('add','login', 'user_info');
		$this->set('auth', $this->Auth);
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$data = $this->Auth->user('id');
				$this->Session->write('id', $data);
				$email = $this->Auth->user('email');
				$this->Session->write('email', $email);
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Flash->error(__('メールアドレスかパスワードが間違ってます'));
			}
		}
	}

	public function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
		$this->set('users', $this->User->find('all'));
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function user_info($id) {
		$user_info = $this->User->findById($id);
		$this->set('user_info', $user_info);
		$pic = $this->User->findById($id);
		$this->set('pic', $pic);
		$email = $this->Session->read('email');
		$this->set('email', $email);
		$this->set('id', $id);
		$total = $this->User->find('count', array(
			'conditions' => array(
				'id' => $id,
				'email' => $email
			),
		)
	);
		$this->set('total', $total);
	}

	public function user_pic($id = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			$email = $this->Session->read('email');
			$this->User->id = $id;
			$tmp =  $this->request->data['User']['img']['tmp_name'];
			$total = $this->User->find('count', array(
				'conditions' => array(
					'id' => $id,
					'email' => $email
				)
			)
		);
			if ($total === 1) {
				if(isset($this->request->data['delete'])) {
					$image = array(
						'User' => array(
							'img' => null,
						)
					);
					if ($this->User->save($image)) {
						$this->Session->setFlash(__('画像が削除されました'));
						$this->redirect(array('controller' => 'posts', 'action' => 'index'));
					}
				} elseif (is_uploaded_file($tmp)) {
					$file_name = $this->request->data['User']['img']['name'];
					$new = uniqid();
					rename($file_name, $new);
					$file =  WWW_ROOT . 'img' . DS . $new;
					if (move_uploaded_file($tmp, $file)) {
						$image = array(
							'User' => array(
								'img' => $new,
							)
						);
						if ($this->User->save($image)) {
							$this->Session->setFlash(__('画像が保存されました'));
							$this->redirect(array('controller' => 'posts', 'action' => 'index'));
						} else {
							$this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
						}
					}
				} else {
					echo "正しくアップロードされていません";
				}
			} else {
				echo "ログインが不正の可能性があります";
			}
			if (!$this->request->data) {
				$this->request->data = $post;
			}
		}
	}

	public function user_info_edit($id = null) {
		$email = $this->Session->read('email');
		debug($email);
		if (!$id) {
			throw new NotFoundException(__('不正なID'));
		}

		$post = $this->User->findById($id);
		if (!$post) {
			throw new NotFoundException(__('不正な投稿'));
		}
		$total = $this->User->find('count', array(
			'conditions' => array(
				'id' => $id,
				'email' => $email
			)
		)
	);
		if ($total === 1) {
			if ($this->request->is(array('post', 'put'))) {
				$this->User->id = $id;
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('コメントがアップデートされました'));
					return $this->redirect(array('controller' => 'Posts', 'action' => 'index'));
				}
				$this->Flash->error(__('コメントをアップデートできませんでした'));
			}
		} else {
			echo "不正なアクセスです";
		}
		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('不正なユーザーです'));
		}
		$this->set('user', $this->User->findById($id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('会員登録されました'));
				$this->redirect($this->Auth->redirect());
			}
			$this->Flash->error(
				__('会員登録できませんでした')
			);
		}
	}
}
