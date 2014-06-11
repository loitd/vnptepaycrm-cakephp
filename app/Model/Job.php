<?php 

App::uses('AppModel', 'Model');

class Job extends AppModel{
	public $name 	= 'Job'; // set the model name

	// public $uses 	= array('Job', 'User');

	public $belongsTo = array(
		'Partner'	=> array(
			'className'		=> 'Partner', //the class name of the model being associated to the current model
			'type'			=> 'LEFT', 
			'foreignKey'	=> 'partner_id', //the name of the foreign key found in the current model (Job.partner_id)
			'fields'		=> array('partner_code', 'dieukientt', 'emailKD', 'mobileKD'), // this will pull the username with the ID of partner's saleman from User table. So handful
		),
		'Saleman'		=> array(
			'className'		=> 'User',
			'foreignKey'	=> 'saleman_id', //User.id
			'fields'		=> array('username'),
		),
		'Tinhcuoc'		=> array(
			'className'		=> 'User',
			'foreignKey'	=> 'tinhcuoc_id', //User.id
			'fields'		=> array('username'),
		),
		'Ketoan'		=> array(
			'className'		=> 'User',
			'foreignKey'	=> 'ketoan_id', //User.id
			'fields'		=> array('username'),
		),
		'Alert'		=> array(
			'className'		=> 'Alert',
			'foreignKey'	=> 'alert_id', //User.id
			'fields'		=> array(),
		),
		'AlertOTP'		=> array(
			'className'		=> 'Alert',
			'foreignKey'	=> 'otp_alert_id', //User.id
			'fields'		=> array(),
		),
	);

	public $validate = array(
		'partner_id'	=> array(
			'required'	=> array(
				'rule'		=> array('notEmpty'),
				'message'	=> 'This field is required',
			),
		),

		'status'	=> array(
			'required'	=> array(
				'rule'		=> array('notEmpty'),
				'message'	=> 'This field is required',
			),
		),


	);

	


	////////////////////////////////////////////////////////////////////
}