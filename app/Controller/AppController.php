<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		// 'DebugKit.Toolbar',
		// 'Acl',
		'Session',
		'Auth' => array(
			'loginAction'		=> array('controller' => 'users', 'action'=>'login'),
            'loginRedirect'     => array('controller' => 'jobs', 'action' => 'index'), // redirect to home page after logged in
            'logoutRedirect'    => array('controller' => 'users', 'action' => 'login'), // redirect to login page after logout
            'loginError'        => 'Invalid username and password.',
            'authError'         => 'You don\'t have enough permissions.',
            'authenticate'      => array(
                //the authenticate will use Form auth with scope to check user status
                //fields The fields to use to identify a user by. 
                'Form'=>array('userModel'=>'User', 'scope'=>array('User.status'=>1)), 
            ),
            'authorize'         => array('Controller'), // this is simple authorize method
        ),
	);

	// defines helpers
	public $helpers = array('Html', 'Form', 'Session', 'Paginator', 'Time');

    public function beforeFilter(){
        //only allow login controller only
        $this->Auth->allow('login', 'logout');
    }

    //now verify, give the role and RBAC
    public function isAuthorized($user){
        // return true;
        return false;
    }
}
