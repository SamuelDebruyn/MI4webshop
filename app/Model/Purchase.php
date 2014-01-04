<?php
	class Purchase extends AppModel{
		
		public $belongsTo = array('User' => array('className' => 'User'));
		public $hasMany = array('PurchasedProduct' => array(
			'className' => 'PurchasedProduct',
			'dependent' => false
		));
		
		public $recursive = 2;
		public $order = "Purchase.modified DESC";
		
	}
?>