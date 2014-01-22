<?php
    class UsersController extends AppController{
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow(array('login', 'register', 'password_reset', 'use_reset_key'));
			$this->helpers[] = 'Form';
			$this->uses[] = 'Product';
			App::uses('CakeEmail', 'Network/Email');
			$this->components[] = 'Security';
		}
		
		public function password_reset(){
			$this->set('title_for_layout', 'Reset your password');
			if($this->Auth->loggedIn())
				return $this->redirect(array('controller' => 'users', 'action' => 'home'));
			
			if($this->request->is('post')){
				$user = $this->User->find('first', array(
					'conditions' => array('username' => $this->request->data['User']['username'])
				));
				if(!$user)
					return $this->Session->setFlash(__('We could not find a user with this username.'));
				
				$u = $user['User'];
				
				$resetCode = Security::hash(mt_rand(),'md5',true);
				
				$this->User->id = $u['id'];
				$this->User->set('reset_key', $resetCode);
				
        		if($this->User->save($this->User->data, true, array('reset_key'))){
        			
            		$email = new CakeEmail('default');
					$email->template('password_reset');
					$email->to($u['email']);
					$email->viewVars(array(
						'firstName' => $u['first_name'],
						'resetCode' => $resetCode
					));
					$email->subject('Password reset');
					
					if($email->send()){
						$this->Session->setFlash(__('Please open the link in the email we\'ve sent you to reset your password.'));
						return $this->redirect(array('controller' => 'static pages', 'action' => 'home')); 
					}
        		}else{
        			$this->Session->setFlash(__('We could not reset your password.'));
        		}
			}
		}

		public function use_reset_key($key = null){
			if($key){
				$user = $this->User->find('first', array(
					'conditions' => array('reset_key' => $key)
				));
				if($user){
					if ($this->Auth->login($user['User'])){
						$this->User->id = $user['User']['id'];
						$this->User->set('reset_key', null);
						$this->User->save($this->User->data, true, array('reset_key'));
						$this->Session->setFlash(__('You are now logged in. Please change your password in your profile info.'));
						return $this->redirect(array('controller' => 'users', 'action' => 'home'));
					}
				}
			}
			$this->Session->setFlash(__('This password reset link is no longer valid.'));
			return $this->redirect(array('controller' => 'users', 'action' => 'login')); 
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
				
				$email = new CakeEmail('default');
				$email->template('registration');
				$user = $this->request->data['User'];
				$email->to($user['email']);
				$email->viewVars(array(
					'firstName' => $user['first_name'],
					'username' => $user['username']
				));
				$email->subject('Your registration');
				if($email->send()){
					$this->Session->setFlash(__('You are now registered and logged in. We\'ve sent you a confirmation email.'));
				}
		        return $this->redirect(array('controller' => 'users', 'action' => 'home'));
		    	}else{
		    		return $this->Session->setFlash(__('We experienced a problem during your registration. Please try again later.'));
		    	}
			}
		}
		
		public function logout(){
			return $this->redirect($this->Auth->logout());
		}
		
		public function manage_overview(){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			$this->set('users', $this->User->find('all', array(
				'recursive' => -1
			)));
		}
		
		public function password_reset_by_admin($id = 0){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			if($this->request->is('post')){
				$user = $this->User->findById($id);
				if($user){
					
					$u = $user['User'];
					
					$resetCode = Security::hash(mt_rand(),'md5',true);
					
					$this->User->id = $u['id'];
					$this->User->set('reset_key', $resetCode);
					
	        		if($this->User->save($this->User->data, true, array('reset_key'))){
	        			
	            		$email = new CakeEmail('default');
						$email->template('password_reset');
						$email->to($u['email']);
						$email->viewVars(array(
							'firstName' => $u['first_name'],
							'resetCode' => $resetCode
						));
						$email->subject('Password reset');
						
						if($email->send()){
							$this->Session->setFlash(__('Password reset link sent to ').$u['email'].".");
							return $this->redirect(array('action' => 'manage_overview')); 
						}
	        		}
					
				}
			}
			$this->Session->setFlash(__('There was an error sending a password reset link to ').$u['email'].".");
			return $this->redirect(array('action' => 'manage_overview')); 
		}
		
		public function edit($uID = 0){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			$user = $this->User->findById($uID);
			if(!$user){
				$this->Session->setFlash(__('The user with id %s could not be found.', h($uID)));
		        return $this->redirect(array('action' => 'manage_overview'));
			}else{
				$this->set('reqU', $user['User']);
			}
		}
		
		public function delete($id) {
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		    if ($this->request->is('get')) {
		        throw new MethodNotAllowedException();
		    }
		    if ($this->User->delete($id)) {
		        $this->Session->setFlash(
		            __('The user with id %s has been deleted.', h($id))
		        );
		        return $this->redirect(array('action' => 'manage_overview'));
		    }
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
        		if($this->User->save($this->request->data, true, array('first_name', 'last_name', 'email', 'password', 'address'))){
            		$this->Session->setFlash(__('Your details have been updated.'));
        		}else{
        			$this->Session->setFlash(__('Unable to update your profile information.'));
        		}
    		}

    		if (!$this->request->data) {
    			$user['User']['password'] = "";
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