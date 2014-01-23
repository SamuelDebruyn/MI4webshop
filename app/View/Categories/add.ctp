<article>
	<header>
		<h2><?php echo __("Add a new category"); ?></h2>
	</header>
	<section>
		<fieldset>
			<legend><?php echo __("Category information"); ?></legend>
			<?php echo $this->Form->create(); ?>
		<?php
			echo $this->Form->input("title", array('label' => 'Title: '));
			echo $this->Form->input("description", array('label' => 'Description: '));
			echo $this->Form->end('Save changes');
		?>
		</fieldset>
	</section>
</article>