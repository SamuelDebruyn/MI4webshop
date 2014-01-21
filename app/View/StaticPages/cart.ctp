<article>
	<header>
		<h2><?php echo __("Shopping cart"); ?></h2>
	</header>
	<section>
		<?php
			$totalPrice = 0;
			if((count($cartContent) < 1)){
				echo "<p>".__("Your shopping cart is empty.")."</p>";
			}else{
				foreach($cartContent as $catID => $catContent){
					$lines = array();
					$catPrice = 0;
					
					foreach($catContent as $prodID => $prodContent){
						
						$lines[] =  "<li>".
									$prodContent['quantity'].
									" x ".
									$this -> Html -> link($productTitles[$prodID], array('controller' => 'products', 'action' => 'view', $prodID)).
									": <abbr title='EUR'>€</abbr> ".
									number_format($productPrices[$prodID]*$prodContent['quantity'], 2, ".", " ").
									" ".
									$this -> Html -> link($this->Html->image('glyphicons/glyphicons_433_minus.png', array('alt' => 'Diminish quantity', 'class' => 'glyphicon')), array('controller' => 'static pages', 'action' => 'lowerProductQuantity', $prodID), array('escape' => false)).
									$this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon')), array('controller' => 'static pages', 'action' => 'removeProductFromCart', $prodID), array('escape' => false), "Are you sure you want to delete this item from your shopping cart?").
									"</li>";
						
						$catPrice += $productPrices[$prodID]*$prodContent['quantity'];
					}
					
					$lines[] = "</ul></details>";
					
					echo 	"<details open='true'>
							<summary>".
							$this -> Html -> link($categoryTitles[$catID], array('controller' => 'categories', 'action' => 'view', $catID)).
							" (<abbr title='EUR'>€</abbr> ".
							number_format($catPrice, 2, ".", " ").
							") - ".
							$this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon')), array('controller' => 'static pages', 'action' => 'removeCategoryFromCart', $catID), array('escape' => false), "Are you sure you want to delete all the items in this category from your shopping cart?").
							"</summary><ul>";
					
					foreach($lines as $line)
						echo $line;
					
					$totalPrice += $catPrice;
				}
			}					
		?>				
	</section>
</article>
<aside>
	<h3><?php echo __("Total price: ")."<abbr title='EUR'>€</abbr> ".number_format($totalPrice, 2, ".", " "); ?></h3>
	<?php
		echo $this -> Html -> link($this->Html->image('glyphicons/glyphicons_350_shopping_bag.png', array('alt' => 'Order', 'class' => 'glyphicon-white'))."Place order", array('controller' => 'purchases', 'action' => 'fromCart'), array('escape' => false))."&emsp;";
		echo $this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon-white'))."Empty shopping cart", array('controller' => 'static pages', 'action' => 'clearCart'), array('escape' => false), "Are you sure you want to empty your shopping cart?");
	?>
</aside>