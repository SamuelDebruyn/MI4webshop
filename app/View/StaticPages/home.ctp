<article>
	<header>
		<h2><?php echo __('Welcome to our webshop!'); ?></h2>
	</header>
	<section>
		<h3><?php echo __('Please pick a category from the list below'); ?></h3>
		<ul>
	<?php
	foreach ($categories as $category) {
		echo "<li>" . $this -> Html -> link($category['Category']['title'], array('controller' => 'categories', 'action' => 'view', $category['Category']['id'])) . "<span><br/>" . $category['Category']['description']."</span></li>";
	}
	?>
</ul>
	</section>
</article>
<aside>
	<p>This website uses cookies, has no terms of service and no privacy policy. This is a demo, not a real webshop.</p>
	<p>The complete source code of this project and more documentation is available at <?php echo $this->Html->link(__('my GitHub repository'), 'https://github.com/SamuelDebruyn/webshop/tree/v1.0.1'); ?>.</p>
</aside>
