<?php $this->log($categories); ?>
<article>
	<header><h2><?php echo __("Add, edit or remove categories"); ?></h2></header>
	<section>
		<?php
		
		echo "<p>".__("It's not recommended to remove a category. This will also delete all of its products. Deleting a product will also delete the orders containing these products.")."</p>";
		echo "<p>".$this->Html->link($this->Html->image('glyphicons/glyphicons_190_circle_plus.png', array('alt' => 'Add category', 'class' => 'glyphicon')).' '.__('Add category'), array('controller' => 'categories', 'action' => 'add'), array('escape' => false))."</p>";
		
		foreach($categories as $category){
			echo "<details><summary>".$category['Category']['title']."</summary><ul>";
			echo "<li>".__('ID').": ".$category['Category']['id']."</li>";
			echo "<li>".__('Description').": ".$category['Category']['description']."</li>";
			echo "<li>".__('Last modified').": ".$category['Category']['modified']."</li>";
			echo "<li>".__('Products').": ".$this->Html->link(count($category['Product']), array('action' => 'view', $category['Category']['id']))."</li>";
			echo "<li>".$this->Html->link($this->Html->image('glyphicons/glyphicons_030_pencil.png', array('alt' => 'Edit category', 'class' => 'glyphicon')).' '.__('Edit'), array('controller' => 'categories', 'action' => 'edit', $category['Category']['id']), array('escape' => false))."</li>";
			echo "<li>".$this->Form->postLink($this->Html->image('glyphicons/glyphicons_016_bin.png', array('alt' => 'Delete category', 'class' => 'glyphicon')).' '.__('Delete'), array('controller' => 'categories', 'action' => 'delete', $category['Category']['id']), array('escape' => false, 'confirm' => 'Are you sure you want to delete category '.$category['Category']['title'].', all of its products and the linked orders?'))."</li>";
			echo "</ul></details>";
		}
		
		?>
	</section>
</article>