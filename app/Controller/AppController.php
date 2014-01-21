<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
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
    	'Auth' => array(
        	'loginAction' => array(
            	'controller' => 'users',
            	'action' => 'login'
        	),
        	'authError' => "You don't have authorization to view this page. Please sign in first.",
        	'authenticate' => array(
            	'Form' => array(
                	'passwordHasher' => array(
                    	'className' => 'Simple'
                	)
            	)
        	)
        ),
        'DebugKit.Toolbar',
    	'Session'
	);
	
	public $helpers = array('Session', 'Html', 'Minify.Minify');
	
	public $uses = array();
	
	public function beforeFilter(){
		$this->set('siteTitle', 'SamShack');
		
		$sAdmin = false;
		if($this->Auth->User('admin') == 1)
			$sAdmin = true;
		$this->set('showAdmin', $sAdmin);
		
		$this->set('loggedIn', $this->Auth->loggedIn());
		if($this->Auth->loggedIn())
			$this->set('loggedInUser', $this->Auth->User());
		
		if(!$this->Session->check('shoppingCart'))
			$this->Session->write('shoppingCart', array());
	}
	
}
