<?php $prod=$product['Product']; $cat=$product['Category']; ?>
<article>
	<header>
		<h2><?php echo $prod['title']; ?></h2>
		<details>
			<summary><?php echo $this -> Html -> link($cat['title'], array('controller' => 'categories', 'action' => 'view', $cat['id'])); ?></summary>
			<?php echo $cat['description']; ?>
		</details>
	</header>
	<section>
			<p><?php echo $prod['description']; ?></p>
			<strong><abbr title="EUR">€</abbr> <span id="totalPrice"><?php echo $prod['price']; ?></span></strong>
			<button><?php echo __("Add to cart"); ?></button>
		</section>
</article>