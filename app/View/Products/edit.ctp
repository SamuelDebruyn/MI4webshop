<article>
	<header>
		<h2><?php echo __("Edit product"); ?></h2>
	</header>
	<section>
		<fieldset>
			<legend><?php echo __("Product information"); ?></legend>
			<?php echo $this->Form->create(); ?>
		<?php
			echo $this->Form->input("title", array('label' => 'Title: '));
			echo $this->Form->input("description", array('label' => 'Description: '));
			echo $this->Form->input("price", array('label' => 'Price: <abbr title="EUR">€</abbr>'));
			echo $this->Form->input("stock", array('label' => 'Stock: '));
			echo $this->Form->input("category_id", array('label' => 'Category: '));
			echo $this->Form->end('Save changes');
		?>
		</fieldset>
	</section>
</article>