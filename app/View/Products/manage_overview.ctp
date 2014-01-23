<?php
	$this->Minify->script('vendor/stupidtable.min', array('inline' => false));
?>
<article>
	<header>
		<h2><?php echo __("Add, edit or delete products"); ?></h2>
		<p><?php echo __("Note that deleting a product will also delete it from past orders. It is recommended to change the stock to 0 instead. Click on a column to sort it."); ?></p>
	</header>
	<section>
		<table class="admintable">
			<thead>
				<th data-sort="int"><?php echo __('ID'); ?></th>
				<th data-sort="string-ins"><?php echo __('Title'); ?></th>
				<th data-sort="string-ins"><?php echo __('Category'); ?></th>
				<th data-sort="float"><?php echo __('Price in ').'<abbr title="EUR">€</abbr>'; ?></th>
				<th data-sort="int"><?php echo __('Stock'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</thead>
			<tbody>
				<?php
					foreach($products as $product){
						$p = $product['Product'];
						$c = $product['Category'];
						$this->log($p);
						$this->log($c);
						echo "<tr>";
						echo "<td>".$p['id']."</td>";
						echo "<td>".$p['title']."</td>";
						echo "<td>".$c['title']."</td>";
						echo "<td>".number_format($p['price'], 2, ".", "")."</td>";
						echo "<td>".$p['stock']."</td>";
						echo "<td>";
						echo "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</section>
</article>
<script>
	$(document).ready(function(){
		$('.admintable').stupidtable();
		$('.admintable').stupidtable().bind('aftertablesort', function (event, data) {
          // data.column - the index of the column sorted after a click
          // data.direction - the sorting direction (either asc or desc)

          var th = $(this).find("th");
          th.find(".arrow").remove();
          var arrow = data.direction === "asc" ? "&uarr;" : "&darr;";
          th.eq(data.column).append('<span class="arrow">' + arrow +'</span>');
        });
	});
</script>