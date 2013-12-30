<?php
	class Product extends AppModel{
		
		public $belongsTo = array('Category' => array('className' => 'Category'));
		public $hasMany = array('PurchasedProduct' => array(
			'className' => 'PurchasedProduct',
			'dependent' => false
		));
		
	}
?>