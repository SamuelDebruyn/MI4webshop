<?php
    class CategoriesController extends AppController{
    	
		public function beforeFilter(){
			parent::beforeFilter();
			$this->Auth->allow('view');
		}
    	
		public function view($id = null){
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid category'));
			
			$category = $this->Category->findById($id);
			
			if(!$category)
				throw new NotFoundException(__('Invalid category'));
			
			$this->set('category', $category);
			$this->set('title_for_layout', $category['Category']['title']);
			
		}
		
		public function manage_overview(){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			$this->set('categories', $this->Category->find('all', array('order' => array('title'))));
		}
		
		public function delete($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid category'));
				
			if(!$this->request->is('post'))
				throw new MethodNotAllowedException(__('Please use a post.'));
				
			if(!$this->Category->delete($id))
				throw new NotFoundException(__('Invalid category'));
				
			$this->Session->setFlash(__('The category with id %s has been deleted.', h($id)));
			return $this->redirect(array('action' => 'manage_overview'));
		}
		
		public function edit($id = null){
			if($this->Auth->User('admin') != 1){
				$this->Session->setFlash(__("You don't have access to this part of the website. Try logging out and back in."));
				return $this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
			
			if(!$id)
				throw new NotFoundException( __( 'Invalid category'));
				
			$category = $this->Category->find('first', array('recursive' => -1, 'conditions' => array('id' => $id)));
			
			if(!$category)
				throw new NotFoundException(__('Invalid category'));
			
			$this->set('cat', $category['Category']);
				
			if (!$this->request->data) {
	        		$this->request->data = $category;
	    	}
			
			if($this->request->is(array('post', 'put'))) {
				$this->Category->id = $category['Category']['id'];
        		if($this->Category->save($this->request->data, true, array('title', 'description'))){
            		$this->Session->setFlash(__('The new details have been saved.'));
					$this->set('cat', $this->Category->data);
        		}else{
        			$this->Session->setFlash(__('Unable to update category information.'));
        		}
    		}
		}
		
    }
?>