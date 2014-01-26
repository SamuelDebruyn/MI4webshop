<article>
	<header>
		<h2><?php echo __("View order details"); ?></h2>
	</header>
	<section>
		
		<?php
		
		foreach($structuredPurchases as $pKey => $purchase){
		    $purchP = 0;
			$firstPurchL = "<details open><summary>".$purchase['date']." - <abbr title='EUR'>€</abbr> ";
			
			$lines = array();
			$lines[] = "<ul>";
			$lines[] = "<li>".__("ID").": ".$pKey;
			$lines[] = "<li>".__("User").": ".$this->Html->link($user['first_name']." ".$user['last_name'], array('controller' => 'users', 'action' => 'edit', $user['id']))."</li>";
			$lines[] = "<li>".__("Payed").": ";
			$lines[] = $this->Form->postLink($purchase['payed'].__(" - Change?"),
							array('controller' => 'purchases', 'action' => 'switch_payed', $pKey),
							array('escape' => false, 'confirm' => 'Are you sure you want to change the payed status of this order?')
						);
			$lines[] = "</li>";
			$lines[] = "<li>".__("Shipped").": ";
			$lines[] = $this->Form->postLink($purchase['shipped'].__(" - Change?"),
							array('controller' => 'purchases', 'action' => 'switch_shipped', $pKey),
							array('escape' => false, 'confirm' => 'Are you sure you want to change the shipped status of this order?')
						);
			$lines[] = "</li>";
			$lines[] = "<li><details open><summary>".__("Products")."</summary><ul>";
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
		
	</section>
</article>