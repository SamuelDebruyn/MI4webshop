<article>
	<header>
		<h2><?php echo __("Shopping cart"); ?></h2>
	</header>
	<section>
		<?php
			if((count($cartContent) < 1)){
				echo "<p>".__("Your shopping cart is empty.")."</p>";
			}else{
				foreach($cartContent as $catID => $catContent){
					$lines = array();
					$catPrice = 0;
					
					foreach($catContent as $prodID => $prodContent){
						$lines[] =  "<li>".$prodContent['quantity']." x ".$this -> Html -> link($productTitles[$prodID], array('controller' => 'products', 'action' => 'view', $prodID)).": <abbr title='EUR'>€</abbr> ".number_format($productPrices[$prodID]*$prodContent['quantity'], 2, ".", " ")."</li>";
						$catPrice += $productPrices[$prodID]*$prodContent['quantity'];
					}
					
					$lines[] = "</ul></details>";
					
					echo 	"<details open='true'>
							<summary>".
							$this -> Html -> link($categoryTitles[$catID], array('controller' => 'categories', 'action' => 'view', $catID)).
							" (<abbr title='EUR'>€</abbr> ".
							number_format($catPrice, 2, ".", " ").
							") - ".
							$this -> Html -> link("Remove from cart", array('controller' => 'static pages', 'action' => 'removeCategoryFromCart', $catID)).
							"</summary><ul>";
					
					foreach($lines as $line)
						echo $line;
				}
				echo $this -> Html -> link("Remove all items from shopping cart", array('controller' => 'static pages', 'action' => 'clearCart'));
			}					
		?>				
	</section>
</article>