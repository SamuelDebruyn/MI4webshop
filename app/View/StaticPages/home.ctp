<h2><?php echo __('Welcome to our webshop!'); ?></h2>
<p><?php echo __('Please pick a category from the list below'); ?></p>
<ul>
	<?php
		foreach($categories as $category){
			echo "<li>".$this->Html->link($category['Category']['title'], array ( 'controller' => 'categories' , 'action' => 'view' , $category['Category']['id']))."</li>".$category['Category']['description'];
		}
	?>
</ul>