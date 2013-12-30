<?php
    class StaticPagesController extends AppController{
    	
		public $uses = array('Category');
		public $helpers = array('Html');
    	
		public function home(){
			$this->set('categories', $this->Category->find('all'));
		}
		
    }
?>