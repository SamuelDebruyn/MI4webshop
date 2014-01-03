<?php $cat=$category['Category']; $prods=$category['Product']; ?>
<article>
	<header>
		<h2><?php echo $cat['title']; ?></h2>
		<p><?php echo $cat['description']; ?></p>
	</header>
	<section>
		<header>
			<h3><?php echo __("Products in this category"); ?>:</h3>
		</header>		
		<?php
			if(count($prods) == 0){
				echo "<p>".__("There are no available products in this category at the moment.")."</p>";
			}else{
				?>
				<table style="width: 100%">
					<tbody>
						<?php
							foreach($prods as $prod){
								echo "<tr><td>".$this -> Html -> link($prod['title'], array('controller' => 'products', 'action' => 'view', $prod['id']))."</td><td><abbr title='EUR'>€</abbr> ".number_format($prod['price'], 2, ".", " ")."</td></tr>";
							}
						?>
					</tbody>
				</table>
				<?php
			}
		?>
	</section>
</article>