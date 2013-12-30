<?php
    class CategoriesController extends AppController{
    	
		public function view($id = null){
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid category'));
			
			$category = $this->Category->findById($id);
			
			if(!$category)
				throw new NotFoundException(__('Invalid category'));
			
			$this->set('category', $category);
			
		}
		
    }
?>