<article>
	<header>
		<h2><?php echo __('Welcome to our webshop!'); ?></h2>
	</header>
	<section>
		<h3><?php echo __('Please pick a category from the list below'); ?></h3>
		<ul>
	<?php
	foreach ($categories as $category) {
		echo "<li>" . $this -> Html -> link($category['Category']['title'], array('controller' => 'categories', 'action' => 'view', $category['Category']['id'])) . "</li>" . $category['Category']['description'];
	}
	?>
</ul>
	</section>
</article>