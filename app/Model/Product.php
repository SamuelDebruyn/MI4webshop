<?php
	class Product extends AppModel{
		
		public $belongsTo = array('Category' => array('className' => 'Category'));
		public $hasMany = array('PurchasedProduct' => array(
			'className' => 'PurchasedProduct',
			'dependent' => true
		));
		
		public $recursive = 0;
		public $order = 'Product.title';
		public $displayField = 'title';
		
		public $validate = array(
			'title' => array(
				'Please enter a title between 1 and 256 characters.' => array(
					'rule' => array('maxLength', 255),
        			'required' => true,
        			'allowEmpty' => false
				)
			),
			'price' => array(
				'Please enter your price in the form 00.00' => array(
        			'rule' => array('decimal', 2),
        			'required' => true,
        			'allowEmpty' => false
				)
			),
			'stock' => array(
				'Please enter a valid stock amount.' => array(
        			'rule' => array('naturalNumber', true),
        			'required' => true,
        			'allowEmpty' => false
				)
			),
			'category_id' => array(
				'Please pick a valid category.' => array(
        			'rule' => array('naturalNumber', true),
        			'required' => true,
        			'allowEmpty' => false
				)
			)
		);
	}
?>