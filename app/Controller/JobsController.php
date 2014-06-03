<?php
class JobsController extends AppController{

	// authorization overwritten
	public function isAuthorized($user){

		if (in_array($this->action, array('add'))) {
			if(isset($user['role']) && $user['role'] !== "kinhdoanh") return false;
		}

		if(isset($user['role'])) return true;
	}

	public function index(){
		//get curent status
		$urole 		= $this->Session->read('Auth.User.role');
		$ustatus 	= ($urole == "khaithac") ? 0 : ($urole == "kinhdoanh" ? 1 : ($urole == "ketoan" ? 2 : 99));

		// if users pressed search button
		if($this->request->is('get') && isset($this->request->query['from_date'])){
			App::uses('CakeTime', 'Utility'); // using time helper for query
			$this->loadModel('Partner');

			// get & convert date
			$fromdate 	= $this->request->query['from_date'];
			$fromdate 	= $fromdate['year'] . "-" . $fromdate['month'] . "-" . $fromdate['day'];

			$todate 	= $this->request->query['to_date'];
			$todate 	= $todate['year'] . "-" . $todate['month'] . "-" . $todate['day'];

			// get the partner_id list from partner code search
			$pcode 		= $this->request->query['partner_code'];
			$pidlist	= $this->Partner->find('list', array(	'conditions'=> array('Partner.partner_code LIKE'=>'%' . $pcode . '%'),
																'fields'=> array('id'),
															)
											);

			// var_dump($pidlist);
			// change the conditions based on user role
			if($urole == "kinhdoanh"){
				$conditions = array(	CakeTime::daysAsSql($fromdate, $todate, 'Job.created'),
										'Job.partner_id'=>$pidlist,
									);
			} else {
				$conditions = array(	'Job.status'=>$ustatus, 
										CakeTime::daysAsSql($fromdate, $todate, 'Job.created'),
										'Job.partner_id'=>$pidlist,
									);
			}

			// paginate the data, fix the conditions to make it filter what users search
			$this->paginate = array(
				'conditions'	=> $conditions,
				'joins'			=> array(), // no need to join because we have the belongsto relationship
	            'limit' 		=> 20,
	            'order' 		=> array('Job.partner_code' => 'asc' ),
	        );

		} else {
			// load normal page with all jobs of this saleman and all status
			if($urole == "kinhdoanh"){
				$conditions = array();
			} else {
				$conditions = array('Job.status'=>$ustatus);
			}

			// paginate the data
			$this->paginate = array(
				'conditions'	=> $conditions,
				'joins'			=> array(), // no need to join because we have the belongsto relationship
	            'limit' 		=> 20,
	            'order' 		=> array('Job.partner_code' => 'asc' ),
	        );

		} //end check get method
		
        // now get the paginated data and pass to the view
        $jobs = $this->paginate('Job');
        $this->set(compact('jobs')); // = $this->set('partners', $partners);

	}

	public function edit($id=null){
		// var_dump($this->request->data);

		/*This action first ensures that the user has tried to access an existing record. 
		If they haven’t passed in an $id parameter, or the post does not exist, 
		we throw a NotFoundException for the CakePHP ErrorHandler to take care of.*/

		if (!$id) {
	        throw new NotFoundException(__('Invalid job'));
	    }

	    $job = $this->Job->findById($id);
	    if (!$job) {
	        throw new NotFoundException(__('Invalid job'));
	    }

	    $jobstt = $job['Job']['status'];
	    $this->set(compact('jobstt'));

	    /* Next the action checks whether the request is either a POST or a PUT request. 
		If it is, then we use the POST data to update our Post record, or kick back and show the user validation errors. */

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Job->id = $id;
	        if ($this->Job->save($this->request->data)) {

	        	// update tinhcuoc & ketoan users
	        	$urole = $this->Session->read('Auth.User.role');
	        	$cstatus = (int) $this->Job->field('status', array('id'=>$id));
	        	$newstatus = $this->Session->read('Auth.User.id');
	        	
	        	if($urole == 'khaithac' && $cstatus ==0)
				{
					if($this->Job->saveField('tinhcuoc_id', $newstatus)){

					} else {
						$this->Session->setFlash(__('Unable to update khaithac user.'));
					}
				} elseif ($urole == 'ketoan' && $cstatus ==2) {
					if($this->Job->saveField('ketoan_id', $newstatus)){

					} else {
						$this->Session->setFlash(__('Unable to update ketoan user.'));
					}
				}


	            $this->Session->setFlash(__('Your job has been updated.'));
	            return $this->redirect(array('action' => 'edit', $id));
	        } else {
	        	$this->Session->setFlash(__('Unable to update this job.'));
	        }
	    }

	    // If there is no data set to $this->request->data, we simply set it to the previously retrieved partner.
	    if (!$this->request->data) {
	        $this->request->data = $job;
	    }
	}

	/*
		Forward job for the next
	*/
	public function forward($id=null)
	{
		//get current status
		$cstatus = (int) $this->Job->field('status', array('id'=>$id));
		$newstatus = $cstatus + 1; 
		$urole = $this->Session->read('Auth.User.role');

		$this->Job->id = $id;
        if (!$this->Job->exists()) {
            $this->Session->setFlash(__('Invalid Job provided'));
            $this->redirect(array('action'=>'index'));
        }

        // check permissions
		if(($urole == 'kinhdoanh' && $cstatus ==1) || ($urole == 'khaithac' && $cstatus ==0) || ($urole == 'ketoan' && $cstatus ==2) )
		{
			// save all the fields
			// do enable
			if($this->Job->saveField('status', $newstatus)){
				$this->Session->setFlash(__('Job has been forwarded.'));
				return $this->redirect(array('action'=>'edit', $id));
			} else {
				$this->Session->setFlash(__('Unable to forward job.'));
			}
		} else {
			// you dont have enough permissions
			$this->Session->setFlash(__('You don\'t have enough permissions or the job has ended.'));
			return $this->redirect(array('action'=>'edit', $id));
		}
		
	}

	/*
		Make payment
	*/
	public function add($id=null)
	{
		$uid = $this->Session->read('Auth.User.id');
		// load templates
		$this->loadModel('Partner');
		$partnerdds = $this->Partner->find('list', array(	'fields'=>array('Partner.partner_code'),
															'conditions' => array('Partner.status =' => '1', 'Partner.saleman_id =' => $uid),
														));
		// var_dump($templatedds);
		$this->set(compact('partnerdds'));

		if($this->request->is('post')){
			$this->Job->create();
			if($this->Job->save($this->request->data)){
				// if the information is successfully saved
				$this->Session->setFlash(__('Congratulation, the job has been created.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Sorry, the job can not be created.'));
			}
		}
	}








	//////////////////////
}