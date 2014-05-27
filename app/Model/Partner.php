<?php 

App::uses('AppModel', 'Model');

class Partner extends AppModel{
	public $name 	= 'Partner'; // set the model name
	// defines relationship
	public $belongsTo = array(
		'User'	=> array(
			'className'		=> 'User',
			'foreignKey'	=> 'saleman_id',
			'fields'		=> array('username'), // this will pull the username with the ID of partner's saleman from User table. So handful
		),

		'Template'	=> array(
			'className'		=> 'Template',
			//'foreignKey'	=> 'saleman_id',
			'fields'		=> array('template_name'), // this will pull the username with the ID of partner's saleman from User table. So handful
		),
	);

	public $validate = array(
		'partner_code'	=> array(
			'required'	=> array(
				'rule'		=> array('notEmpty'),
				'message'	=> 'This field is required',
			),
		),

		'saleman_id'	=> array(
			'required'	=> array(
				'rule'		=> array('notEmpty'),
				'message'	=> 'This field is required',
			),
		),


	);

	// supported function
	public function isThisSale($partner, $user){
		// echo "saleman_id=" . $user . "? id=" . $partner;
		// get the saleman_id from Partner where id = partnerID and saleman_id = userID
		$x = $this->field('saleman_id', array('saleman_id' => $user, 'id' => $partner));
		// var_dump($x !== false);
		return $x !== false;
	}



	///////////////////
}