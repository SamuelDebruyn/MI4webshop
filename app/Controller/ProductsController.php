<?php
    class ProductsController extends AppController{
    	
		public function view($id = null) {
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid product'));
			
			$product = $this->Product->findById($id);
			
			if(!$product)
				throw new NotFoundException(__('Invalid product'));
			
			$this->set('product', $product);
			
		}
		
    }
?>