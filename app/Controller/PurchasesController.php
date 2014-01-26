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
						$this->Session->setFlash(__('Your order has succesfully been submitted. You will receive an order confirmation via email. Your order ID is %s.', h($this->Purchase->id)));
					}else{
						$this->Session->setFlash(__('Not every product in your shopping cart was in stock. You will receive an order confirmation with more details via email. Your order ID is %s.', h($this->Purchase->id)));
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
			
			$this->set('title_for_layout', 'manage orders');
			
			$purchases = $this->Purchase->find('all', array('recursive' => 0));
			$this->set('purchases', $purchases);
		}
		
		public function delete($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid order'));
				
			if(!$this->request->is(array('post', 'delete')))
				throw new MethodNotAllowedException(__('Please use a post or a delete request.'));
				
			if(!$this->Purchase->delete($id))
				throw new NotFoundException(__('Invalid order'));
				
			$this->Session->setFlash(__('The order with id %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'manage_overview'));
		}
		
		public function switch_shipped($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid order'));
				
			if(!$this->request->is('post'))
				throw new MethodNotAllowedException(__('Please use a post request.'));
				
			$purchase = $this->Purchase->findById($id);
			
			if(!$purchase)
				throw new NotFoundException( __( 'Invalid order'));
			
			$shipped = false;
			$shippedText = "not shipped yet";
			if(!$purchase['Purchase']['shipped']){
				$shipped = true;
				$shippedText = "shipped";
			}
			
			$this->Purchase->id = $id;
			
			$this->Purchase->set('shipped', $shipped);
			
			$this->Session->setFlash(__('The order with id %s could not be marked as '.$shippedText.'. Please try again later.', h($id)));
			
			if($this->Purchase->save($this->Purchase->data, false, array('shipped'))){
				
				$email = new CakeEmail('default');
				$email->template('status');
				$email->to($purchase['User']['email']);
				$email->viewVars(array(
					'newStatus' => $shippedText,
					'orderID' => $id,
					'user' => $purchase['User']
				));
				$email->subject('Order status');
				
				if($email->send())
					$this->Session->setFlash(__('The order with id %s has been marked as '.$shippedText.'.', h($id)));
			}		
			
			return $this->redirect($this->referer());
		}
		
		public function switch_payed($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid order'));
				
			if(!$this->request->is('post'))
				throw new MethodNotAllowedException(__('Please use a post request.'));
				
			$purchase = $this->Purchase->findById($id);
			
			if(!$purchase)
				throw new NotFoundException( __( 'Invalid order'));
			
			$payed = false;
			$payedText = "not payed yet";
			if(!$purchase['Purchase']['payed']){
				$payed = true;
				$payedText = "payed";
			}
			
			$this->Purchase->id = $id;
			
			$this->Purchase->set('payed', $payed);
			
			$this->Session->setFlash(__('The order with id %s could not be marked as '.$payedText.'. Please try again later.', h($id)));
			
			if($this->Purchase->save($this->Purchase->data, false, array('payed'))){
				
				$email = new CakeEmail('default');
				$email->template('status');
				$email->to($purchase['User']['email']);
				$email->viewVars(array(
					'newStatus' => $payedText,
					'orderID' => $id,
					'user' => $purchase['User']
				));
				$email->subject('Order status');
				
				if($email->send())
					$this->Session->setFlash(__('The order with id %s has been marked as '.$payedText.'.', h($id)));
			}		
			
			return $this->redirect($this->referer());
		}
		
		public function view($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid order'));
			
			$purchase = $this->Purchase->find('first', array('recursive' => 1, 'conditions' => array('Purchase.id' => $id)));
			
			if(!$purchase)
				throw new NotFoundException( __( 'Invalid order'));
				
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
			
			$this->set('user', $purchase['User']);
			$this->set('structuredPurchases', $structure);
			$this->set('categoryTitles', $catsWithTitles);
			$this->set('productTitles', $productsWithTitles);
			$this->set('productPrices', $productsWithPrices);
		}
    }
?>