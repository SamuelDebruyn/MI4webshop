<?php
    class StaticPagesController extends AppController{
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('home');
			$this->uses[] = 'Category';
			$this->helpers[] = 'Html';
		}
    	
		public function home(){
			$this->set('categories', $this->Category->find('all'));
		}
		
    }
?>