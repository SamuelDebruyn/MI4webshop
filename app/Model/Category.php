<?php
    class Category extends AppModel{
    	
		public $hasMany = array('Product' => array(
			'className' => 'Product',
			'conditions' => array('Product.stock >' => 0),
			'order' => 'Product.title',
			'dependent' => true
		));
		
		public $recursive = 1;
		public $order = 'Category.title';
		public $displayField = 'title';
		
		public $validate = array(
			'title' => array(
				'Please enter a title between 1 and 256 characters.' => array(
					'rule' => array('maxLength', 255),
					'required' => true,
					'allowEmpty' => false
				)
			)
		);
		
    }
?>