<?php
    
    App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
    
    class User extends AppModel{
    	
		public function beforeSave(array $options = array()){
			parent::beforeSave($options);
			if(!empty($this->data['User']['password'])){
				$passwordHasher = new SimplePasswordHasher();
				$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        	}
        	return true;
    	}
		
		public $recursive = 2;
    	
		public $validate = array(
			'username' => array(
        		'Only letters and numbers in your username please.' => array(
        			'rule' => 'alphaNumeric',
        			'required' => true,
        			'allowEmpty' => false
				),
        		'Your username has to be between 3 and 20 characters long.' => array(
        			'rule' => array('between', 3, 20)
				),
				'This username is already taken.' => array(
					'rule' => 'isUnique'
				)
    		),
        	'email' => array(
				'Please enter a valid email address.' => array(
					'rule' => array('email', true),
					'required' => true,
					'allowEmpty' => false
				),
				'This email address is already in use.' => array(
					'rule' => 'isUnique'
				)
			),
        	'password' => array(
				'Please enter a password consisting of at least 6 characters.' => array(
					'rule' => array('minLength', 6),
					'required' => true,
					'allowEmpty' => false
				)
			),
			'first_name' => array(
				'Please enter a valid first name.' => array(
					'rule' => 'alphaNumeric',
					'required' => true,
					'allowEmpty' => false
				),
				'Please enter a first name between 1 and 100 characters.' => array(
					'rule' => array('maxLength', 100)
				),
				'There is already an account registered with this name.' => array(
					'rule' => array('checkUnique', array('first_name', 'last_name'), false)
				)
			),
			'last_name' => array(
				'Please enter a valid last name.' => array(
					'rule' => 'alphaNumeric',
					'required' => true,
					'allowEmpty' => false
				),
				'Please enter a last name between 1 and 100 characters.' => array(
					'rule' => array('maxLength', 100)
				)
			),
			'address' => array(
				'Please enter a valid address (alphanumeric characters only).' => array(
					'rule' => 'notEmpty',
					'required' => true
				)
			)
		);
    	
		public $hasMany = array('Purchase' => array(
			'className' => 'Purchase',
			'dependent' => true
		));
		
    }
?>