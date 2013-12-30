<?php
    class User extends AppModel{
    	
		public $hasMany = array('Purchase' => array(
			'className' => 'Purchase',
			'dependent' => true
		));
		
    }
?>