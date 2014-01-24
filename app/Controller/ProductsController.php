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
				$this->request->data['Product']['quantity'] = 1;
				$this->Session->setFlash($qty.__(' item(s) were succesfully added to your shopping cart.'));
				return true;
			}
			$this->request->data['Product']['quantity'] = 1;
		}

		public function manage_overview(){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			$products = $this->Product->find('all');
			
			$this->set('products', $products);
		}
		
		public function add(){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			$categories = $this->Product->Category->find('list');
			$this->set('categories', $categories);
						
			if($this->request->is(array('post', 'put'))){
				$this->Product->create();
				if($this->Product->save($this->request->data, true, array('title', 'description', 'stock', 'price', 'category_id'))){
					$this->Session->setFlash(__('The product %s was succesfully added.', h($this->request->data['Product']['title'])));
					return $this->redirect(array('action' => 'manage_overview')); 
				}else{
					return $this->Session->setFlash(__('Unable to add a new product. Try again later.'));
				}
			}
		}
		
		public function delete($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}

			if(!$id)
				throw new NotFoundException( __( 'Invalid product'));
				
			if(!$this->request->is('post'))
				throw new MethodNotAllowedException(__('Please use a post.'));
				
			if(!$this->Product->delete($id))
				throw new NotFoundException(__('Invalid product'));
				
			$this->Session->setFlash(__('The product with id %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'manage_overview'));
			
		}
		
		public function edit($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			$categories = $this->Product->Category->find('list');
			$this->set('categories', $categories);
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid product'));
				
			$product = $this->Product->findById($id);
			
			if(!$product)
				throw new NotFoundException(__('Invalid product'));
				
			if (!$this->request->data) {
	        		$this->request->data = $product;
	    	}
			
			if($this->request->is(array('post', 'put'))) {
				$this->Product->id = $product['Product']['id'];
        		if($this->Product->save($this->request->data, true, array('title', 'description', 'stock', 'price', 'category_id'))){
            		$this->Session->setFlash(__('The new details have been saved.'));
        		}else{
        			$this->Session->setFlash(__('Unable to update product information.'));
        		}
    		}
		}
		
    }
?>