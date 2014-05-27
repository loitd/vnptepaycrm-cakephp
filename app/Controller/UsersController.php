<?php
class UsersController extends AppController{

	// authorization overwritten
	public function isAuthorized($user){
		if(isset($user['role']) && $user['role'] === "hethong") return true;
	}

	public $paginate = array('limit'=>25, 'condition'=>array('status'=>'1'), 'order'=>array('User.username'=>'asc'));

	/*
		I overwrited beforeFilter function in appcontroller
	*/
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login');
	}

	public function index(){
		$this->paginate = array(
            'limit' => 6,
            'order' => array('User.username' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users')); // = $this->set('partners', $partners);
	}

	/*to log in a user*/
	public function login(){
		// if already logged-in then redirect to index
		if($this->Session->check('Auth.User')){
			$this->redirect(array('action'=>'index'));
		}

		// if we got a post information, try to authenticate
		if($this->request->is('post')){
			// do login
			if($this->Auth->login()){
				// login successful
				$this->Session->setFlash(__('Welcome, ' . $this->Auth->user('username')));
				$this->redirect($this->Auth->redirectUrl());
			} else {
				// login fail
				$this->Session->setFlash(__('Invalid username and password'));
			}
		}
	}

	/*to add new user*/
	public function add(){
		// if we got a post information, do add else do nothing
		if($this->request->is('post')){
			$this->User->create();
			if($this->User->save($this->request->data)){
				// if the information is successfully saved
				$this->Session->setFlash(__('Congratulation, the user has been created.'));
				$this->redirect(array('controller'=>'jobs', 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('Sorry, the user can not be created.'));
			}
		}
	}

	/*to logout*/
	public function logout(){
		$this->redirect($this->Auth->logout());
	}

	/*edit a user*/
	public function edit($id=null){
		
		if (!$id) {
			$this->Session->setFlash('Please provide a user id');
			$this->redirect(array('action'=>'index'));
		}

		$user = $this->User->findById($id);
		if (!$user) {
			$this->Session->setFlash('Invalid User ID Provided');
			$this->redirect(array('action'=>'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) { // must included put resquest here
			$this->User->id = $id;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been updated'));
				$this->redirect(array('action' => 'edit', $id));
			}else{
				$this->Session->setFlash(__('Unable to update your user.'));
			}
		}

		if (!$this->request->data) {
			$this->request->data = $user;
		}
	}

	/*Delete a user*/
	public function delete($id=null){
		if(!$id){
			$this->Session->setFlash('Please provide a user id');
			$this->redirect(array('action'=>'index'));
		}
		
	}




// end the class
}