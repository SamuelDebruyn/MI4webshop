<?php
    class UsersController extends AppController{
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow(array('login', 'register', 'logout'));
			$this->helpers[] = 'Form';
			$this->uses[] = 'Product';
		}
    	
		public function login(){
			$this->set('title_for_layout', 'Sign in');
			if ($this->request->is('post')){
				if ($this->Auth->login()){
					return $this->redirect($this->Auth->redirectUrl());
        		}
				$this->Session->setFlash(__('Invalid username or password, please try again'));
			}
		}
		
		public function register(){
			$this->set('title_for_layout', 'Sign up');
			if ($this->request->is(array('post', 'put'))) {
				$this->User->create();
				if($this->User->save($this->request->data, true, array('first_name', 'last_name', 'email', 'address', 'password', 'username'))){
					$id = $this->User->id;
					$this->request->data['User'] = array_merge(
						$this->request->data['User'],
						array('id' => $id)
					);
		        $this->Auth->login($this->request->data['User']);
		        return $this->redirect(array('controller' => 'users', 'action' => 'home'));
		    	}
			}
		}
		
		public function logout(){
			return $this->redirect($this->Auth->logout());
		}
		
		public function home($tab = 1){
			$this->set('title_for_layout', 'Your profile');
			$user = $this->User->findById($this->Auth->User('id'));
			$this->set('userData', $user);
			if(!($tab == 1 || $tab == 2))
				$tab = 1;
			$this->set('tab', $tab);
			
			if($this->request->is(array('post', 'put'))) {
				$this->User->id = $user['User']['id'];
        		if($this->User->save($this->request->data, true, array('first_name', 'last_name', 'email', 'address'))){
            		$this->Session->setFlash(__('Your details have been updated.'));
            		return $this->redirect(array('action' => 'home'));
        		}else{
        			$this->Session->setFlash(__('Unable to update your profile information.'));
        		}
    		}

    		if (!$this->request->data) {
        		$this->request->data = $user;
    		}
			
			$structure = array();
			$catsWithTitles = array();
			$productsWithTitles = array();
			$productsWithPrices = array();
			
			foreach($user['Purchase'] as $purchase){
				$structure[$purchase['id']] = array();;
				$structure[$purchase['id']]['date'] = $purchase['modified'];
				$structure[$purchase['id']]['payed'] = "no";
				if($purchase['payed'])
					$structure[$purchase['id']]['payed'] = "yes";
				$structure[$purchase['id']]['shipped'] = "no";
				if($purchase['shipped'])
					$structure[$purchase['id']]['shipped'] = "yes";
				$structure[$purchase['id']]['categories'] = array();
				
				foreach($purchase['PurchasedProduct'] as $pid){
					$product = $this->Product->findById($pid);
					
					if(!isset($catsWithTitles[$product['Category']['id']]))
						$catsWithTitles[$product['Category']['id']] = $product['Category']['title'];
					
					if(!isset($productsWithTitles[$product['Product']['id']]))
						$productsWithTitles[$product['Product']['id']] = $product['Product']['title'];
					
					if(!isset($productsWithPrices[$product['Product']['id']]))
						$productsWithPrices[$product['Product']['id']] = $product['Product']['price'];
					
					if(!isset($structure[$purchase['id']]['categories'][$product['Category']['id']]))
						$structure[$purchase['id']]['categories'][$product['Category']['id']] = array();
					if(!isset($structure[$purchase['id']]['categories'][$product['Category']['id']][$product['Product']['id']])){
						$structure[$purchase['id']]['categories'][$product['Category']['id']][$product['Product']['id']] = array();
						$structure[$purchase['id']]['categories'][$product['Category']['id']][$product['Product']['id']]['quantity'] = 0;
					}
					
					$structure[$purchase['id']]['categories'][$product['Category']['id']][$product['Product']['id']]['quantity']++;
					
					}
			}
			
			$this->set('structuredPurchases',$structure);
			$this->set('categoryTitles', $catsWithTitles);
			$this->set('productTitles', $productsWithTitles);
			$this->set('productPrices', $productsWithPrices);
			
		}
		
    }
?>