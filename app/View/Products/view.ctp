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
		<strong><abbr title="EUR">€</abbr> <span id="totalPrice"><?php echo number_format($prod['price'], 2, ".", " "); ?></span></strong>
		</section>
</article>
<aside>
	<h3>
		<?php
			echo $this->Html->image('glyphicons/glyphicons_209_cart_in.png', array('alt' => 'In cart', 'class' => 'glyphicon-white')).
			__("Buy");
		?>
	</h3>
	<p><?php echo __("In stock: ").$prod['stock']; ?></p>
	<?php
		echo $this->Form->create();
		echo $this->Form->input("quantity", array('label' => "Quantity: "));
		echo $this->Form->end('Add to cart');
	?>
</aside>