<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
		parent::beforeFilter();
		$username = $this->User->find('all');
		$this->Session->write('username',$username);
		$this->Auth->allow('add','login');
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

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
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
