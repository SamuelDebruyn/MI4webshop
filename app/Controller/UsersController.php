<?php
    class UsersController extends AppController{
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow();
			$this->helpers[] = 'Html';
			$this->helpers[] = 'Form';
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
		}
		
		public function logout(){
			return $this->redirect($this->Auth->logout());
		}
		
    }
?>