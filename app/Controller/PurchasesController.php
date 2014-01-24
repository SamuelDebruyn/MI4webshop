<?php
    class PurchasesController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->uses[] = 'PurchasedProduct';
			$this->uses[] = 'Product';
			$this->uses[] = 'User';
			App::uses('CakeEmail', 'Network/Email');
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
					$currentStock = $this->Product->field('stock', array('Product.id' => $product['Product']['id']));
					if($currentStock > 0){
						$this->Product->id = $product['Product']['id'];
						$this->Product->set('stock', $currentStock - 1);
						$this->Product->save($this->Product->data, false, array('stock'));
						$this->PurchasedProduct->create(array('purchase_id' => $this->Purchase->id, 'product_id' => $product['Product']['id']));
						$this->PurchasedProduct->save($this->PurchasedProduct->data, false, array('purchase_id', 'product_id'));
						$this->Session->setFlash('Your order has succesfully been submitted. You will receive an order confirmation via email.');
					}else{
						$this->Session->setFlash('Not every product in your shopping cart was in stock. You will receive an order confirmation with more details via email.');
					}
				}
				$this->Session->write('shoppingCart', array());
				
				$purchase = $this->Purchase->findById($this->Purchase->id);
								
				$structure = array();
				$catsWithTitles = array();
				$productsWithTitles = array();
				$productsWithPrices = array();
				
				$structure[$purchase['Purchase']['id']] = array();
				$structure[$purchase['Purchase']['id']]['date'] = $purchase['Purchase']['modified'];
				$structure[$purchase['Purchase']['id']]['payed'] = "no";
				if($purchase['Purchase']['payed'])
					$structure[$purchase['Purchase']['id']]['payed'] = "yes";
				$structure[$purchase['Purchase']['id']]['shipped'] = "no";
				if($purchase['Purchase']['shipped'])
					$structure[$purchase['Purchase']['id']]['shipped'] = "yes";
				$structure[$purchase['Purchase']['id']]['categories'] = array();
				
				foreach($purchase['PurchasedProduct'] as $purchasedProduct){
					$product = $this->Product->findById($purchasedProduct['product_id']);
					
					if(!isset($catsWithTitles[$product['Category']['id']]))
						$catsWithTitles[$product['Category']['id']] = $product['Category']['title'];
					
					if(!isset($productsWithTitles[$product['Product']['id']]))
						$productsWithTitles[$product['Product']['id']] = $product['Product']['title'];
					
					if(!isset($productsWithPrices[$product['Product']['id']]))
						$productsWithPrices[$product['Product']['id']] = $product['Product']['price'];
					
					if(!isset($structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']]))
						$structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']] = array();
					if(!isset($structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']][$product['Product']['id']])){
						$structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']][$product['Product']['id']] = array();
						$structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']][$product['Product']['id']]['quantity'] = 0;
					}
					
					$structure[$purchase['Purchase']['id']]['categories'][$product['Category']['id']][$product['Product']['id']]['quantity']++;
					
					}
				
				$email = new CakeEmail('default');
				$email->template('order_confirmation');
				$email->to($this->Auth->User('email'));
				$email->viewVars(array(
					'structuredPurchases' => $structure,
					'categoryTitles' => $catsWithTitles,
					'productTitles' => $productsWithTitles,
					'productPrices' => $productsWithPrices,
					'username' => $this->Auth->User('username'),
					'firstName' => $this->Auth->User('first_name')
				));
				$email->subject('Order confirmation');
				$email->send();				
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
			
			$this->Session->setFlash("The ordered products were once again added to your shopping cart.");
			
			foreach($purchase['PurchasedProduct'] as $product){
				$pdDB = $this->Product->findById($product['product_id']);
				if(!$pdDB)
					throw new NotFoundException(__('Invalid purchase'));
				if($pdDB['Product']['stock'] > 0){
					$cart[] = $pdDB;
				}else{
					$this->Session->setFlash('Not all of the previously ordered products were in stock. Please review your order before placing it.');
				}
			}
			
			$this->Session->write('shoppingCart', $cart);
			
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			
		}
		
		public function manage_overview(){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			$purchases = $this->Purchase->find('all', array('recursive' => 0));
			$this->set('purchases', $purchases);
		}
		
		public function delete($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
		
		public function switch_shipped($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
		
		public function switch_payed($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
		
		public function view($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
    }
?>