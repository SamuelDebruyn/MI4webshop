<?php
    class PurchasesController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->uses[] = 'PurchasedProduct';
			$this->uses[] = 'Product';
		}
    	
		public function fromCart(){
			$this->set('title_for_layout', 'place order');
			$cart = $this->Session->read('shoppingCart');
			if(count($cart) < 1){
				$this->Session->setFlash("The shopping cart is still empty.");
				return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			}
			
			$this->Purchase->create(array(
				'user_id' => $this->Auth->User('id')
			));
			
			if($this->Purchase->save($this->Purchase->data, false, array('user_id'))){
				$cart = $this->Session->read('shoppingCart');
				foreach($cart as $product){
					$this->PurchasedProduct->create(array('purchase_id' => $this->Purchase->id, 'product_id' => $product['Product']['id']));
					$this->PurchasedProduct->save($this->PurchasedProduct->data, false, array('purchase_id', 'product_id'));
					$currentStock = $this->Product->field('stock', array('Product.id' => $product['Product']['id']));
					$this->Product->id = $product['Product']['id'];
					$this->Product->set('stock', $currentStock - 1);
					$this->Product->save($this->Product->data, false, array('stock'));
				}
				$this->Session->write('shoppingCart', array());
				$this->Session->setFlash('Your order has succesfully been submitted. You will receive an order confirmation via email.');
				return $this->redirect(array('controller' => 'users', 'action' => 'home', 2));
			}
			
			$this->Session->setFlash("Your order could not be processed. Please try again later.");
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
		}

		public function doOrderAgain($id = null){
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid purchase'));
			
			$purchase = $this->Purchase->findById($id);
			
			if(!$purchase)
				throw new NotFoundException(__('Invalid purchase'));
			
			$cart = $this->Session->read('shoppingCart');
			
			foreach($purchase['PurchasedProduct'] as $product){
				$pdDB = $this->Product->findById($product['product_id']);
				if(!$pdDB)
					throw new NotFoundException(__('Invalid purchase'));
				$cart[] = $pdDB;
			}
			
			$this->Session->write('shoppingCart', $cart);
			$this->Session->setFlash("The ordered products were once again added to your shopping cart.");
			
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			
		}
		
    }
?>