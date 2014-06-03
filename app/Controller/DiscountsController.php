<?php
class DiscountsController extends AppController{

	// authorization overwritten
	public function isAuthorized($user){
		if(isset($user['role'])) return true;
	}

	public function index(){
		$this->paginate = array(
            'limit' => 6,
            'order' => array('Discount.id' => 'asc' )
        );
        $discounts = $this->paginate('Discount');
        $this->set(compact('discounts')); // = $this->set('partners', $partners);
	}

	/*
		Edit a record
	*/
	public function edit($id=null){

		/*This action first ensures that the user has tried to access an existing record. 
		If they haven’t passed in an $id parameter, or the post does not exist, 
		we throw a NotFoundException for the CakePHP ErrorHandler to take care of.*/

		if (!$id) {
	        throw new NotFoundException(__('Invalid discount'));
	    }

	    $discount = $this->Discount->findById($id);
	    if (!$discount) {
	        throw new NotFoundException(__('Invalid discount'));
	    }

	    /* Next the action checks whether the request is either a POST or a PUT request. 
		If it is, then we use the POST data to update our Post record, or kick back and show the user validation errors. */

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Discount->id = $id;
	        if ($this->Discount->save($this->request->data)) {
	            $this->Session->setFlash(__('Your discount has been updated.'));
	            // return $this->redirect(array('action' => 'index'));
	        } else {
	        	$this->Session->setFlash(__('Unable to update this discount.'));
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
		if($this->Discount->delete($id)){
			$this->Session->setFlash(__('Discount %s has been deleted.', h($id)));
			return $this->redirect(array('action'=>'index'));
		} else {
			$this->Session->setFlash(__('Unable to delete Discount %s.', h($id)));
		}
	}

	/*
		Add record
	*/
	public function add(){
		if($this->request->is('post')){
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			$this->Discount->create();
			if($this->Discount->save($this->request->data)){
				// if the information is successfully saved
				$this->Session->setFlash(__('Congratulation, the discount has been created.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Sorry, the discount can not be created.'));
			}
		}
	}















////////////////////////////////
}