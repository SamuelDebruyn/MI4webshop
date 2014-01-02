<?php
    class CategoriesController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('view');
		}
    	
		public function view($id = null){
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid category'));
			
			$category = $this->Category->findById($id);
			
			if(!$category)
				throw new NotFoundException(__('Invalid category'));
			
			$this->set('category', $category);
			$this->set('title_for_layout', $category['Category']['title']);
			
		}
		
    }
?>