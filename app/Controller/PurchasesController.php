<?php
    class PurchasesController extends AppController{
    	
		public function fromCart(){
			$this->set('title_for_layout', 'place order');
			$cart = $this->Session->read('shoppingCart');
			if(count($cart) < 1){
				$this->Session->setFlash("The shopping cart is still empty.");
				return $this->redirect(array('controller' => 'static pages', 'action' => 'cart'));
			}
			
			$this->Purchase->create(array(
				'user' => $this->Auth->User()
			));
			
			$this->log($this->Purchase);
			
			$this->Purchase->save($this->Purchase->data, array(
				'fieldList' => array('user')
			));
			
			
		}
		
    }
?>