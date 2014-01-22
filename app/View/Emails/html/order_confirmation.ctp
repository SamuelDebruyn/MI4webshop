<header>
	<h1>Order confirmation</h1>
</header>
<article>
	<header><p>Hi <?php echo $firstName; ?>,</p></header>
	<section>
		<p>This is a confirmation of your order on <?php echo $siteTitle; ?>.</p>
		<p>Log into your account with username <?php echo $username; ?> at <?php echo $this->Html->link('our login page', array('full_base' => true, 'controller' => 'users', 'action' => 'login')); ?> to view the order status.</p>
	
	
		<?php
		foreach($structuredPurchases as $pKey => $purchase){
		    $purchP = 0;
			$firstPurchL = "<details open><summary>".$purchase['date']." - <abbr title='EUR'>€</abbr> ";
			
			$lines = array();
			$lines[] = "<ul><li>Payed: ".$purchase['payed']."</li><li>Shipped: ".$purchase['shipped']."</li><li><details open><summary>Products</summary><ul>";
			foreach($purchase['categories'] as $cKey => $category){
				$firstCatL = "<details open><summary>".$this -> Html -> link($categoryTitles[$cKey], array('controller' => 'categories', 'action' => 'view', $cKey, 'full_base' => true))." - <abbr title='EUR'>€</abbr> ";
				$catP = 0;
				$sublines = array();
				foreach($category as $prodKey => $product){
					$sublines[] = "<li>";
					$sublines[] = $product['quantity']." x ";
					$sublines[] = $this -> Html -> link($productTitles[$prodKey], array('controller' => 'products', 'action' => 'view', $prodKey, 'full_base' => true));
					$sublines[] = ": <abbr title='EUR'>€</abbr> ";
					$sublines[] = number_format($productPrices[$prodKey]*$product['quantity'], 2, ".", " ");
					$sublines[] = "</li>";
					$catP += $productPrices[$prodKey]*$product['quantity'];
				}
				$sublines[] = "</ul></details>";
				$firstCatL .= number_format($catP, 2, ".", " ");
				$firstCatL .= "</summary><ul>";
				$lines[] = $firstCatL;
				foreach($sublines as $subline){
					$lines[] = $subline;
				}
				$purchP += $catP;
			}
			$lines[] = "</ul></details></li>";
			$lines[] = "</ul>";
			
			$firstPurchL .= number_format($purchP, 2, ".", " ")."</summary>";
			$lines[] = "</details>";
			
			echo $firstPurchL;
			foreach($lines as $line)
				echo $line;
		}
		?>
		<p>Please deposit <abbr title='EUR'>€</abbr> <?php echo number_format($purchP, 2, ".", " "); ?> on bank account 000-12345678-90 as soon as possible.</p>

	</section>
</article>
<footer>
	<p>
		Greetings,<br/>
		<?php echo $siteTitle; ?>
	</p>
</footer>