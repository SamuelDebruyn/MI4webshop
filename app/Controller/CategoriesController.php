<?php
    class CategoriesController extends AppController{
    	
		public function view($id = null){
			if(!$id)
				throw new NotFoundException( __( 'Invalid post'));
		}
		
    }
?>