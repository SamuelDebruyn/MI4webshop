<?php
    class Category extends AppModel{
    	
		public $hasMany = array('Product' => array(
			'className' => 'Product',
			'conditions' => array('Product.stock >' => 0),
			'dependent' => true
		));
		
		public $recursive = 1;
		
    }
?>