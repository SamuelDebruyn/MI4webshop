<?php
    class ProductsController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('view');
		}
    	
		public function view($id = null) {
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid product'));
			
			$product = $this->Product->findById($id);
			
			if(!$product)
				throw new NotFoundException(__('Invalid product'));
			
			$this->set('product', $product);
			$this->set('title_for_layout', $product['Product']['title']);
		}
		
    }
?>