<?php 

App::uses('AppModel', 'Model');

class User extends AppModel{
    // define ralationships
    public $hasMany         = array(
        'Partner'  => array(
            'className'     => 'Partner',
            'condition'     => array('Partner.saleman_id'=>'User.id'),
            'foreignKey'    => 'saleman_id',
            'dependent'     => false
        ),
    );
    // other settings
    public $avatarUploadDir = 'img/avatars';
    public $name            = 'User';

    // define validate
	public $validate = array(
		'username'    => array(
            'required'  => array(
                'rule' 		=> array('notEmpty'),
                'message' 	=> 'A username is required'
            ), 
            'checklen'  => array(
                'rule'      => array('between', 4, 15),
                'message'   => 'Username must be 5 to 15 characters'
            ),
            'unique'    => array(
                'rule'      => array('isUniqueUsername'),
                'message'   => 'This username is already used'
            ),
            'goodchar'  => array(
                'rule'      => array('alphaNumericDashUnderscore'),
                'message'   => 'Username can only be characters, numbers and dashboard'
            ),
        ), //end username validate

        'password' => array(
            'required' => array(
                'rule' 		=> array('notEmpty'),
                'message' 	=> 'A password is required',
            )
        ), // end password validate

        'password_confirm'  => array(
            'isequal'   => array(
                'rule'      => array('equaltofield', 'password'),
                'message'   => '2 password is not match'
            ),
        ), // end password confirm validate
        'role' => array(
            'valid' => array(
                'rule' 			=> array('inList', array('hethong', 'kinhdoanh', 'khaithac', 'ketoan')),
                'message' 		=> 'Please enter a valid role',
                'allowEmpty' 	=> false,
            )
        ), // end role validate

        'password_update'   => array(
            'minlen'    => array(
                'rule'      => array('minLength', '6'),
                'message'   => 'Password must have a minimum 6 characters.',
                'allowEmpty'=> true,
                'required'  => false,
            ),
        ), // end password update validate

        'password_confirm_update' => array(
            'isequal'       => array(
                'rule'      => array('equaltofield', 'password_update'),
                'message'   => '2 password is not match'
            ),
        ),
	);

    /*
        We need this function to check if username is unique
        @param $chk
        @return boolean = true -> ok to use, = false -> already in DB
    */
    public function isUniqueUsername($chk){
        return true;
    }
    
    /*
        We need this function to check if username is good char
        @param $chk
        @return boolean = true -> ok to use, = false -> already in DB
    */
    public function alphaNumericDashUnderscore($chk){
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($chk);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
    
    /*
        We need this function to check if username is good char
        @param $chk
        @return boolean = true -> ok to use, = false -> already in DB
    */
    public function equaltofield($chk, $otherfield){
        //get name of field 
        $fname = ''; 
        foreach ($chk as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    }

    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
     public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
         
        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
     
        // fallback to our parent
        return parent::beforeSave($options);
    }














}