<?php
class TemplatesController extends AppController{

	// authorization overwritten
	public function isAuthorized($user){
		if(isset($user['role'])) return true;
	}

	public function index(){
		$this->paginate = array(
            'limit' => 6,
            'order' => array('Template.id' => 'asc' )
        );
        $templates = $this->paginate('Template');
        $this->set(compact('templates')); // = $this->set('partners', $partners);
	}

	/*
		Edit a record
	*/
	public function edit($id=null){

		/*This action first ensures that the user has tried to access an existing record. 
		If they haven’t passed in an $id parameter, or the post does not exist, 
		we throw a NotFoundException for the CakePHP ErrorHandler to take care of.*/

		if (!$id) {
	        throw new NotFoundException(__('Invalid template'));
	    }

	    $discount = $this->Template->findById($id);
	    if (!$discount) {
	        throw new NotFoundException(__('Invalid template'));
	    }

	    /* Next the action checks whether the request is either a POST or a PUT request. 
		If it is, then we use the POST data to update our Post record, or kick back and show the user validation errors. */

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Template->id = $id;
	        if ($this->Template->save($this->request->data)) {
	            $this->Session->setFlash(__('Your template has been updated.'));
	            // return $this->redirect(array('action' => 'index'));
	        } else {
	        	$this->Session->setFlash(__('Unable to update this template.'));
	        }
	    }

	    // If there is no data set to $this->request->data, we simply set it to the previously retrieved partner.
	    if (!$this->request->data) {
	        $this->request->data = $discount;
	    }
	}

	/*
		Delete partners
	*/
	public function delete($id){
		if($this->request->is('get')){
			throw new MethodNotAllowedException();
		} 

		// do delete
		if($this->Template->delete($id)){
			$this->Session->setFlash(__('Template %s has been deleted.', h($id)));
			return $this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Unable to delete Template %s.', h($id)));
		}
	}

	/*
		Add record
	*/
	public function add(){
		if($this->request->is('post')){
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			$this->Template->create();
			if($this->Template->save($this->request->data)){
				// if the information is successfully saved
				$this->Session->setFlash(__('Congratulation, the template has been created.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Sorry, the template can not be created.'));
			}
		}
	}















////////////////////////////////
}