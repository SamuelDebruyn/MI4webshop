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
			
			$cart = $this->Session->read('shoppingCart');
			$cartContent = array();
			$catsWithTitles = array();
			$productsWithTitles = array();
			$productsWithPrices = array();
			
			foreach($cart as $product){
				
				if(!isset($catsWithTitles[$product['Category']['id']]))
					$catsWithTitles[$product['Category']['id']] = $product['Category']['title'];
				
				if(!isset($productsWithTitles[$product['Product']['id']]))
					$productsWithTitles[$product['Product']['id']] = $product['Product']['title'];
				
				if(!isset($productsWithPrices[$product['Product']['id']]))
					$productsWithPrices[$product['Product']['id']] = $product['Product']['price'];
				
				
				if(!isset($cartContent[$product['Category']['id']]))
					$cartContent[$product['Category']['id']] = array();
				if(!isset($cartContent[$product['Category']['id']][$product['Product']['id']])){
					$cartContent[$product['Category']['id']][$product['Product']['id']] = array();
					$cartContent[$product['Category']['id']][$product['Product']['id']]['quantity'] = 0;
				}
				
				$cartContent[$product['Category']['id']][$product['Product']['id']]['quantity']++;
															
			}
			
			$this->set('cartContent', $cartContent);
			$this->set('categoryTitles', $catsWithTitles);
			$this->set('productTitles', $productsWithTitles);
			$this->set('productPrices', $productsWithPrices);
		}

		public function clearCart(){
			$this->Session->write('shoppingCart', array());
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
		}
		
		public function removeCategoryFromCart($catID){
			
			if(!is_numeric($catID)){
				$this->Session->setFlash("Unable to remove this category from your cart.");
				return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			}			
				
			$cart = $this->Session->read('shoppingCart');
			
			$indexesToDelete = array();
			
			foreach($cart as $index => $product){
				if($product['Category']['id'] == $catID)
					$indexesToDelete[] = $index;
			}

			foreach($indexesToDelete as $index){
				unset($cart[$index]);
			}
			
			$this->Session->write('shoppingCart', $cart);
			$this->Session->setFlash("Succesfully removed from shopping cart.");
			
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
		}
		
		public function removeProductFromCart($prodID){
			if(!is_numeric($prodID)){
				$this->Session->setFlash("Unable to remove this product from your cart.");
				return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			}
				
			$cart = $this->Session->read('shoppingCart');
			
			$indexesToDelete = array();
			
			foreach($cart as $index => $product){
				if($product['Product']['id'] == $catID)
					$indexesToDelete[] = $index;
			}
			
			foreach($indexesToDelete as $index){
				unset($cart[$index]);
			}
			
			$this->Session->setFlash("Succesfully removed from shopping cart.");
			return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
		}
		
    }
?>