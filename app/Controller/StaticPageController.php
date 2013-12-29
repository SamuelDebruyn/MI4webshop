<?php
    class StaticPageController extends AppController{
    	
		var $uses = array('Category');
    	
		public function home(){
			$this->set('categories', $this->Category->find('all'));
		}
		
    }
?>