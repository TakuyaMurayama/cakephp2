<?php
class PostsController extends AppController {

	public $components = array('Paginator', 'Session', 'Flash');

	public $helpers = array('Html', 'Form', 'Flash');

	public function isAuthorized($user) {
		if ($this->action === 'add') {
			return true;
		}
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = (int) $this->request->params['pass'][0];
			if ($this->Post->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function index() {
		$this->set('posts', $this->Post->find('all'));
		$username = $this->Session->read();
		$this->set('username',$username);
		$id = $this->Session->read('id');
		$this->set('userdata',$id);
		$user = $this->Auth->user();
		$this->set('user', $user);
	}


	public function view($id) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}
		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('post', $post);
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			if ($this->Post->save($this->request->data)) {
				$this->Flash->success(__('投稿されました'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('投稿できませんでした'));
		}
	}

	public function edit($id = null) {
		$email = $this->Session->read('email');
		$this->set('email', $email);
		$sampleData = $this->Session->read('id');
		$this->set('userdata',$sampleData);
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;
			$hidden = $this->request->data('Post.user_id');
			$this->Session->write('hidden', $hidden);
			$this->loadModel('User');
			$total = $this->User->find('count', array(
				'conditions'=>array(
					'id'=>$hidden,
					'email'=>$email
				)
			)
		);
			if ($total === 1) {
				$this->Post->save($this->request->data);
				$this->Flash->success(__('編集されました'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('編集できませんでした'));
			}
		}
		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->request->is(array('post', 'put'))) {
			$email = $this->Session->read('email');
			$this->set('email',$email);
			$user_id = $this->Session->read('id');
			$this->set('id', $user_id);
			$this->loadModel('User');
			$total = $this->User->find('count', array(
				'conditions'=>array(
					'id'=>$user_id,
					'email'=>$email
				)
			)
		);
			if ($total === 1) {
				if(!$this->Post->delete($id)) {
					$this->Flash->success(
						__('id: %sの投稿は削除されました', h($id))
					);
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}
}

