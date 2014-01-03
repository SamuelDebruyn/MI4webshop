<?php
    class ProductsController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('view');
			$this->helpers[] = 'Form';
		}
    	
		public function view($id = null) {
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid product'));
			
			$product = $this->Product->findById($id);
			
			if(!$product)
				throw new NotFoundException(__('Invalid product'));
			
			$this->set('product', $product);
			
			$this->set('title_for_layout', $product['Product']['title']);
			
			if ($this->request->is(array('post', 'put'))){
				$check = false;
				if(isset($this->request->data['Product']['quantity']))
					if(!empty($this->request->data['Product']['quantity']))
						if(is_numeric($this->request->data['Product']['quantity']))
							if($this->request->data['Product']['quantity'] > 0)
								$check = true;
				if(!$check){
					$this->Session->setFlash(__('The entered quantity was invalid.'));
					return false;
				}
				$qty = $this->request->data['Product']['quantity'];
				if($qty > $product['Product']['stock'])
					$qty = $product['Product']['stock'];
				$cart = $this->Session->read('shoppingCart');
				for($i = 0; $i < $qty; $i++){
					$cart[] = $product;
				}
				$this->Session->write('shoppingCart', $cart);
				$this->log($qty);
				unset($this->request->data);
				$this->Session->setFlash($qty.__(' items were succesfully added to your shopping cart.'));
			}
		}
		
    }
?>