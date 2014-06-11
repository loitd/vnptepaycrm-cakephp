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
		//var_dump(KHAITHAC);
		//get curent status
		$urole 		= $this->Session->read('Auth.User.role');
		$ustatus 	= ($urole == "khaithac") ? 4 : ($urole == "kinhdoanh" ? 5 : ($urole == "ketoan" ? 6 : 99));

		// if users pressed search button
		if($this->request->is('get') && isset($this->request->query['from_date'])){
			App::uses('CakeTime', 'Utility'); // using time helper for query
			$this->loadModel('Partner');

			// get & convert date
			$fromdate 	= $this->request->query['from_date'];
			$fromdate 	= $fromdate['year'] . "-" . $fromdate['month'] . "-" . $fromdate['day'];

			$todate 	= $this->request->query['to_date'];
			$todate 	= $todate['year'] . "-" . $todate['month'] . "-" . $todate['day'];

			$priority 	= $this->request->query['priority'];

			// get the partner_id list from partner code search
			$pcode 		= $this->request->query['partner_code'];
			$pidlist	= $this->Partner->find('list', array(	'conditions'=> array('Partner.partner_code LIKE'=>'%' . $pcode . '%'),
																'fields'=> array('id'),
															)
											);

			// var_dump($priority);
			switch ($priority) {
				case '0': // all = dont check
					$priority_cond = array();
					break;
				case '1':
					$priority_cond = array('Job.type'=>'1'); //dot xuat
					break;
				case '2':
					$priority_cond = array('Job.type'=>'0'); //dinh ky
					break;
				case '3':
					$priority_cond = array('Partner.dieukientt <'=>30);
					break;
				default:
					$priority_cond = array();
					break;
			}

			// change the conditions based on user role

			if($urole == KHAITHACROLE){
				//if user is khaithac
				$conditions = array(	'Job.status <='=>KHT_GUIBANCUNG, 
										CakeTime::daysAsSql($fromdate, $todate, 'Job.created'),
										'Job.partner_id'=>$pidlist,
									);
				$conditions = array_merge($conditions, $priority_cond);
			} elseif($urole == KINHDOANHROLE){
				// if user is kinhdoanh then display all the job of the user
				$conditions = array(	
										CakeTime::daysAsSql($fromdate, $todate, 'Job.created'),
										'Job.partner_id'=>$pidlist,
									);
				$conditions = array_merge($conditions, $priority_cond);
			} else {
				// else display the job only when it is on the current department
				$conditions = array(	
										'Job.status'=>$ustatus, 
										CakeTime::daysAsSql($fromdate, $todate, 'Job.created'),
										'Job.partner_id'=>$pidlist,
									);
				$conditions = array_merge($conditions, $priority_cond);
			}

			// paginate the data, fix the conditions to make it filter what users search
			$this->paginate = array(
				'conditions'	=> $conditions,
				'joins'			=> array(), // no need to join because we have the belongsto relationship
	            'limit' 		=> 20,
	            'order' 		=> array('Job.modified' => 'desc' ),
	        );

		} else {
			// load normal page with all jobs of this saleman and all status.
			// no search button pressed
			if($urole == KINHDOANHROLE){
				$conditions = array(
										'Job.status <'=>DAKETTHUC, // all job but not DAKETTHUC
									);
			} elseif($urole == KETOANROLE) {
				$conditions = array(
										'Job.status'=>$ustatus,
									);
			} elseif($urole == KHAITHACROLE) {
				$conditions = array(
										'Job.status <='=>KHT_GUIBANCUNG, //from 0-4
									);
			}

			// paginate the data
			$this->paginate = array(
				'conditions'	=> $conditions,
				'joins'			=> array(), // no need to join because we have the belongsto relationship
	            'limit' 		=> 20,
	            'order' 		=> array('Job.modified' => 'asc' ),
	        );

		} //end check get method
		
        // now get the paginated data and pass to the view
        $jobs = $this->paginate('Job');
        $this->set(compact('jobs')); // = $this->set('partners', $partners);

	}

	public function edit($id=null){
		// var_dump($this->request->data);
		$this->loadModel('Alert');

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

	    //echo $job['Partner']['emailKD'];
	    // set update criterias
	    $this->Job->id = $id; // set job where id = $id

	    /* whatever it is, create an alert record and fill the ID into the alert_id */
	    if(!isset($job['Job']['alert_id']) || $job['Job']['alert_id'] == 0 ){
	    	$newalert['Alert']['status'] = 99;
	    	$newalert['Alert']['email_to'] 	= $job['Partner']['emailKD'];
	    	$newalert['Alert']['email_cc']	= EMAILCC;
	    	$newalert['Alert']['email_bcc'] = EMAILBCC;

	    	$this->Alert->create();
	    	if( $this->Alert->save($newalert) ){
	    		$alert_id = $this->Alert->id;
	    	} else {
	    		die('Unable to create new alert');
	    	}
	    	
	    	//echo "NEW ALERT RECORD IS CREATED WITH ID: " . $alert_id;
	    	
	    	/* now insert it into job record */
	    	//$this->Job->read(null,1);
	    	if($this->Job->saveField('alert_id', $alert_id)) {
	    		$this->redirect(array('action' => 'edit', $id)); //redirect to refresh
	    	} else {
	    		die('Unable to update the alert_id');
	    	}

	    }
	    

	    $jobstt = $job['Job']['status'];
	    $this->set(compact('jobstt'));

	    /* Next the action checks whether the request is either a POST or a PUT request. 
		If it is, then we use the POST data to update our Post record, or kick back and show the user validation errors. */

	    if ( $this->request->is(array('post', 'put')) && isset($_POST['savebtn']) ) { //for savebtn only

	    	$email_attach = $this->request->data['Job']['email_attach'];
	    	
	        // set update criterias
	        //$this->Job->id = $id; // set job where id = $id
	        $this->Alert->id = $job['Job']['alert_id']; // set job where id = $id

	        // check if users update the attached files. This procedure will exe only when user update this field.
	    	if(isset($email_attach['name']) && $email_attach['name'] != '' ){
	    		//this happens when users update attached files
	    		$filename = "C:/wamp/www/vnptepaycrm-cakephp/app/webroot/files/" . $email_attach['name'];
		    	//var_dump($filename);
		    	
		    	/*copy upload file*/
		    	if( move_uploaded_file($email_attach['tmp_name'], $filename) ){
		    		//upload ok then manually update alert table
		    		$this->Alert->saveField('email_attach', $filename);
		    		//die('we can do');	
		    	} else {
		    		die('Unable to upload attach file');
		    	}
		    	//die();	
	    	}

	        // now do update both tables
	        if ($this->Job->save($this->request->data) && $this->Alert->save($this->request->data)) {

	        	// update tinhcuoc & ketoan users
	        	$urole = $this->Session->read('Auth.User.role');
	        	$cstatus = (int) $this->Job->field('status', array('id'=>$id));
	        	$newstatus = $this->Session->read('Auth.User.id');
	        	
	        	if($urole == 'khaithac' && $cstatus ==0)
				{
					if($this->Job->saveField('tinhcuoc_id', $newstatus) ){

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

	    /* Only apply to user when they press Send mail button.
	    Save creds and send emails*/
	    if( $this->request->is(array('post', 'put')) && isset($_POST['sendbtn']) ){
	    	$email_attach = $this->request->data['Job']['email_attach'];
	    	
	        // set update criterias
	        $this->Job->id = $id; // set job where id = $id
	        $this->Alert->id = $job['Job']['alert_id']; // set job where id = $id

	        // check if users update the attached files. This procedure will exe only when user update this field.
	    	if(isset($email_attach['name']) && $email_attach['name'] != '' ){
	    		//this happens when users update attached files
	    		$filename = "C:/wamp/www/vnptepaycrm-cakephp/app/webroot/files/" . $email_attach['name'];
		    	//var_dump($filename);
		    	
		    	/*copy upload file*/
		    	if( move_uploaded_file($email_attach['tmp_name'], $filename) ){
		    		//upload ok then manually update alert table
		    		$this->Alert->saveField('email_attach', $filename);
		    		//die('we can do');	
		    	} else {
		    		die('Unable to upload attach file');
		    	}
		    	//die();	
	    	}

	        // now do update both tables
	        if ($this->Job->save($this->request->data) && $this->Alert->save($this->request->data)) {

	        	// update tinhcuoc & ketoan users
	        	$urole = $this->Session->read('Auth.User.role');
	        	$cstatus = (int) $this->Job->field('status', array('id'=>$id));
	        	$newstatus = $this->Session->read('Auth.User.id');
	        	
	        	if($urole == 'khaithac' && $cstatus ==0)
				{
					if($this->Job->saveField('tinhcuoc_id', $newstatus) ){

					} else {
						$this->Session->setFlash(__('Unable to update khaithac user.'));
					}
				
				} elseif ($urole == 'ketoan' && $cstatus ==2) {
					if($this->Job->saveField('ketoan_id', $newstatus)){

					} else {
						$this->Session->setFlash(__('Unable to update ketoan user.'));
					}
				}

				//manually update status of alert records
				$this->Alert->saveField('status', 0);


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
		$this->loadModel('Alert');
		$this->loadModel('Partner');
		//get current status
		$cstatus = (int) $this->Job->field('status', array('id'=>$id));
		$urole = $this->Session->read('Auth.User.role');

		$this->Job->id = $id;
        if (!$this->Job->exists()) {
            $this->Session->setFlash(__('Invalid Job provided'));
            $this->redirect(array('action'=>'index'));
        }

        // check permissions
		if( ($urole == KINHDOANHROLE && $cstatus ==KINHDOANH_PROCESS) || 
			($urole == KHAITHACROLE && $cstatus <=KHT_GUIBANCUNG) || 
			($urole == KETOANROLE && $cstatus ==KETOAN_PROCESS) )
		{
			// save all the fields
			$newstatus = $cstatus + 1; //forward job to another dept
			// do enable
			if($this->Job->saveField('status', $newstatus)){

				//send otp when kinhdoanh forward viec cho ketoan
				if($cstatus == KINHDOANH_PROCESS && $newstatus == KETOAN_PROCESS){

					//get the related partner
					$partner_id = $this->Job->field('partner_id', array('id'=>$id));
					$this->Partner->id = $partner_id;

					//var_dump( $this->Partner->field('mobileKD') );die();

					//create the otp_alert_id & update
					$newalert['Alert']['status'] 		= 0;
			    	$newalert['Alert']['sms_to'] 		= $this->Partner->field('mobileKD');
			    	$newalert['Alert']['sms_content']	= sprintf( SMS_CONTENT, $this->Job->field('otp') );
			    	

			    	$this->Alert->create();
			    	if( $this->Alert->save($newalert) ){
			    		$otp_alert_id = $this->Alert->id;
			    	} else {
			    		die('Unable to create new OTP alert');
			    	}

			    	//update opt alert id into job table
					if($this->Job->saveField('otp_alert_id', $otp_alert_id)) {

					} else {
						die('Unable to save OTP');
					}
				}

				
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