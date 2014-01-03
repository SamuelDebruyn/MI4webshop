<?php
    class StaticPagesController extends AppController{
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow();
			$this->uses[] = 'Category';
		}
    	
		public function home(){
			$this->set('categories', $this->Category->find('all'));
			$this->set('title_for_layout', 'home');
		}
		
		public function cart(){
			$this->set('title_for_layout', 'shopping cart');
		}
		
    }
?>