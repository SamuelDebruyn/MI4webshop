<?php
    class Category extends AppModel{
    	
		public $hasMany = array('Product' => array(
			'className' => 'Product',
			'conditions' => array('Product.stock >' => 0),
			'dependent' => true
		));
		
		public $recursive = 1;
		
		public $validate = array(
			'title' => array(
				'Please enter a valid title.' => array(
					'rule' => 'alphaNumeric',
					'required' => true,
					'allowEmpty' => false
				),
				'Please enter a title between 1 and 255 characters.' => array(
					'rule' => array('maxLength', 255)
				)
			)
		);
		
    }
?>