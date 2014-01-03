<article>
	<header>
		<h2><?php echo __("Shopping cart"); ?></h2>
	</header>
	<section>
		<?php
			if((count($cartContent) < 1)){
				echo "<p>".__("Your shopping cart is empty.")."</p>";
			}else{
				$totalPrice = 0;
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
									" ".$this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon')), array('controller' => 'static pages', 'action' => 'removeProductFromCart', $prodID), array('escape' => false)).
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
							$this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon')), array('controller' => 'static pages', 'action' => 'removeCategoryFromCart', $catID), array('escape' => false)).
							"</summary><ul>";
					
					foreach($lines as $line)
						echo $line;
					
					$totalPrice += $catPrice;
				}
				echo __("<h4>Total price: <abbr title='EUR'>€</abbr> ").number_format($totalPrice, 2, ".", " ")."</h4>";
				echo $this -> Html -> link($this->Html->image('glyphicons/glyphicons_208_cart_out.png', array('alt' => 'Out of cart', 'class' => 'glyphicon'))."Remove all items from shopping cart", array('controller' => 'static pages', 'action' => 'clearCart'), array('escape' => false));
			}					
		?>				
	</section>
</article>