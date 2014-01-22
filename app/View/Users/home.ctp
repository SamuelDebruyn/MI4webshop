<?php
	
	$this->Minify->script('vendor/jquery.responsiveTabs.min', array('inline' => false));
	
	$user = $userData['User'];
	$purchases = $userData['Purchase'];
?>
<article>
	<header>
		<h2><?php echo __("Hi, ").$user['first_name']; ?></h2>
	</header>
	<section>
		<div class="tabsContainer">
			<ul>
				<li><a href="#tab-1" id="t1"><?php echo $this->Html->image('glyphicons/glyphicons_003_user.png', array('alt' => 'User', 'class' => 'glyphicon-white')).__("Profile info"); ?></a></li>
				<li><a href="#tab-2" id="t2"><?php echo $this->Html->image('glyphicons/glyphicons_029_notes_2.png', array('alt' => 'Orders', 'class' => 'glyphicon-white')).__("Past orders"); ?></a></li>
			</ul>
			<div id="tab-1">
				<fieldset>
					<legend><?php echo __("Edit your profile information"); ?></legend>
					<?php echo $this->Form->create(); ?>
				<?php
					echo $this->Form->input("first_name", array('label' => 'First name: '));
					echo $this->Form->input("last_name", array('label' => 'Last name: '));
					echo $this->Form->input("email", array('label' => 'Email address: '));
					echo $this->Form->input("password", array('label' => 'Password: '));
					echo $this->Form->input("address", array('label' => 'Address: '));
					echo $this->Form->end('Save changes');
				?>
				</fieldset>
			</div>
			<div id="tab-2">
				<?php
					if(count($purchases) < 1){
						echo "<p>".__("You haven't made any purchases yet.")."</p>";
					}else{
						foreach($structuredPurchases as $pKey => $purchase){
							$this->log($purchase);
							$purchP = 0;
							$firstPurchL = "<details><summary>".$purchase['date']." - <abbr title='EUR'>€</abbr> ";
							
							$lines = array();
							$lines[] = "<ul><li>Payed: ".$purchase['payed']."</li><li>Shipped: ".$purchase['shipped']."</li><li><details><summary>Products</summary><ul>";
							foreach($purchase['categories'] as $cKey => $category){
								$firstCatL = "<details><summary>".$this -> Html -> link($categoryTitles[$cKey], array('controller' => 'categories', 'action' => 'view', $cKey))." - <abbr title='EUR'>€</abbr> ";
								$catP = 0;
								$sublines = array();
								foreach($category as $prodKey => $product){
									$sublines[] = "<li>";
									$sublines[] = $product['quantity']." x ";
									$sublines[] = $this -> Html -> link($productTitles[$prodKey], array('controller' => 'products', 'action' => 'view', $prodKey));
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
							
							$firstPurchL .= number_format($purchP, 2, ".", " ")." - ".$this->Html->link($this->Html->image('glyphicons/glyphicons_209_cart_in.png', array('alt' => 'In cart', 'class' => 'glyphicon'))."Order same products again", array('controller' => 'purchases', 'action' => 'doOrderAgain', $pKey), array('escape' => false))."</summary>";
							$lines[] = "</details>";
							
							echo $firstPurchL;
							foreach($lines as $line)
								echo $line;
						}
					}
				?>
			</div>
		</div>
	</section>
</article>
<script>
	$(document).ready(function(){
		$('.tabsContainer').responsiveTabs({
			collapsible: true,
			startCollapsed: true,
			rotate: false,
			animation: 'slide'
		});
		$('#t<?php echo $tab; ?>').trigger('click');
	});
</script>
