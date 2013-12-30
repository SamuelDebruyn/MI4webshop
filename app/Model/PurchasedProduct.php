<?php
    class PurchasedProduct extends AppModel{
    	
		public $belongsTo = array(
			'Product' => array('className' => 'Product'),
			'Purchase' => array('className' => 'Purchase'),
		);
		
    }
?>