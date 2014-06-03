<?php
class PartnersController extends AppController{

	public $paginate 	= array('limit'=>25, 'condition'=>array('status'=>'1'), 'order'=>array('Partner.partner_code'=>'asc'));

	// authorization overwritten
	public function isAuthorized($user){
		// var_dump($this->action);

		// allow index action to all sale users
		if (in_array($this->action, array('index'))) {
			if (isset($user['role'])) return true;
		}

		if (in_array($this->action, array('add'))) {
			if (isset($user['role']) && in_array($user['role'], array("kinhdoanh"))) return true;
		}

		if(in_array($this->action, array('edit'))){
			$partnerID = (int) $this->request->params['pass'][0];
			if ($this->Partner->isThisSale($partnerID, $user['id']) 
				|| in_array($user['username'], array("hant")) 
				|| in_array($user['role'], array("khaithac", "ketoan"))) {
            	return true;
        	}
		}
		
		// only allow edit and delete his partner. He must be a saleman
		if(in_array($this->action, array('edit', 'delete', 'enable', 'disable'))){
			$partnerID = (int) $this->request->params['pass'][0];
			if ($this->Partner->isThisSale($partnerID, $user['id']) && in_array($user['role'], array("kinhdoanh")) ) {
            	return true;
        	}
		}

		// inherit from parent
		return parent::isAuthorized($user);
		// return false;
	}

	/*
		Kinhdoanh will see his partners
		hant will see all partners
		khaithac & ketoan will see all partners
	*/
	public function index(){
		// get current loged in user
		$urole 		= $this->Session->read('Auth.User.role');
		$uname 		= $this->Session->read('Auth.User.username');

		// change the conditions based on user role
		if($urole == "kinhdoanh" && $uname != "hant"){
			$conditions = array('saleman_id'=>$this->Auth->user('id'));
		} else {
			$conditions = array();
		}

		// paginate the data
		$this->paginate = array(
			'conditions'	=> $conditions,
			'joins'			=> array(), // no need to join because we have the belongsto relationship
            'limit' 		=> 6,
            'order' 		=> array('Partner.partner_code' => 'asc' ),
        );

        // now get the paginated data and pass to the view
        $partners = $this->paginate('Partner');
        $this->set(compact('partners')); // = $this->set('partners', $partners);

	}

	public function add(){
		// load templates
		$this->loadModel('Template');
		$templatedds = $this->Template->find('list', array('fields'=>array('Template.template_name')));
		// var_dump($templatedds);
		$this->set(compact('templatedds'));

		// load users
		// $this->loadModel('User');
		// $userdds = $this->User->find('list', array('fields'=>array('User.username'), 'conditions'=>array('User.role'=>'kinhdoanh')));
		// var_dump($templatedds);
		// $this->set(compact('userdds'));

		//

		if($this->request->is('post')){
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			$this->Partner->create();
			if($this->Partner->save($this->request->data)){
				// if the information is successfully saved
				$this->Session->setFlash(__('Congratulation, the partner has been created.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Sorry, the partner can not be created.'));
			}
		}
	}


	/*
		Kinhdoanh will edit his partners
		hant will edit all partners
		khaithac & ketoan will only view all partners but will unable to edit & save
	*/
	public function edit($id=null){
		$this->loadModel('Template');
		$templatedds = $this->Template->find('list', array('fields'=>array('Template.template_name')));
		// var_dump($templatedds);
		$this->set(compact('templatedds'));

		// load users
		$this->loadModel('User');
		$userdds = $this->User->find('list', array('fields'=>array('User.username'), 'conditions'=>array('User.role'=>'kinhdoanh')));
		// var_dump($templatedds);
		$this->set(compact('userdds'));

		/*This action first ensures that the user has tried to access an existing record. 
		If they haven’t passed in an $id parameter, or the post does not exist, 
		we throw a NotFoundException for the CakePHP ErrorHandler to take care of.*/

		if (!$id) {
	        throw new NotFoundException(__('Invalid partner'));
	    }

	    $partner = $this->Partner->findById($id);
	    if (!$partner) {
	        throw new NotFoundException(__('Invalid partner'));
	    }

	    /* Next the action checks whether the request is either a POST or a PUT request. 
		If it is, then we use the POST data to update our Post record, or kick back and show the user validation errors. */
		// get current loged in user
		$urole 		= $this->Session->read('Auth.User.role');

	    if ($this->request->is(array('post', 'put')) && !in_array($urole, array("khaithac", "ketoan")) ) {
	        $this->Partner->id = $id;
	        if ($this->Partner->save($this->request->data)) {
	            $this->Session->setFlash(__('Your partner has been updated.'));
	            // return $this->redirect(array('action' => 'index'));
	        } else {
	        	$this->Session->setFlash(__('Unable to update this partner.'));
	        }
	    }

	    // If there is no data set to $this->request->data, we simply set it to the previously retrieved partner.
	    if (!$this->request->data) {
	        $this->request->data = $partner;
	    }
	}

	/*
		Delete partners
	*/
	public function delete($id){
		if($this->request->is('get')){
			throw new MethodNotAllowedException();
		} 

		// get the partner name
		$partner_code = $this->Partner->field('partner_code', array('id'=>$id));

		// do delete
		if($this->Partner->delete($id)){
			$this->Session->setFlash(__('Partner %s has been deleted.', h($partner_code)));
			return $this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Unable to delete Partner %s.', h($partner_code)));
		}
	}

	/*
		enable partners
	*/
	public function enable($id){
		$this->Partner->id = $id;
        if (!$this->Partner->exists()) {
            $this->Session->setFlash('Invalid Partner id provided');
            $this->redirect(array('action'=>'index'));
        }
		// do enable
		if($this->Partner->saveField('status', 1)){
			$this->Session->setFlash(__('Partner %s has been enabled.', h($partner_code)));
			return $this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Unable to enable Partner %s.', h($partner_code)));
		}
	}

	public function disable($id){
		$this->Partner->id = $id;
        if (!$this->Partner->exists()) {
            $this->Session->setFlash('Invalid Partner id provided');
            $this->redirect(array('action'=>'index'));
        }
		// do enable
		if($this->Partner->saveField('status', 0)){
			$this->Session->setFlash(__('Partner %s has been disabled.', h($partner_code)));
			return $this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Unable to disable Partner %s.', h($partner_code)));
		}
	}




//////////////////////
}