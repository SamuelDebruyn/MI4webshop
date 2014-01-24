<?php
	$this->Minify->script('vendor/stupidtable.min', array('inline' => false));
	$this->log($purchases);
?>
<article>
	<header>
		<h2><?php echo __("Manage orders"); ?></h2>
		<p><?php echo __("Click on a column to sort it.") ?></p>
	</header>
	<section>
		<table class="admintable">
			<thead>
				<th data-sort="int"><?php echo __('ID'); ?></th>
				<th data-sort="string-ins"><?php echo __('Time modified'); ?></th>
				<th data-sort="string-ins"><?php echo __('User'); ?></th>
				<th data-sort="string-ins"><?php echo __('Payed'); ?></th>
				<th data-sort="string-ins"><?php echo __('Shipped'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</thead>
			<tbody>
				<?php
					foreach($purchases as $purchase){
						$p = $purchase['Purchase'];
						$u = $purchase['User'];
						
						$payed = "no";
						$shipped = "no";
						
						if($p['payed'])
							$payed = "yes";
						
						if($p['shipped'])
							$shipped = "yes";
						
						echo "<tr>";
						echo "<td>".$p['id']."</td>";
						echo "<td>".$p['modified']."</td>";
						echo "<td>".$u['username']."</td>";
						echo "<td>".$payed."</td>";
						echo "<td>".$shipped."</td>";
						echo "<td>";
						echo $this->Html->link($this->Html->image(
							'glyphicons/glyphicons_051_eye_open.png',
							array('alt' => 'View purchase', 'class' => 'glyphicon')),
							array('controller' => 'purchases', 'action' => 'view', $p['id']),
							array('escape' => false)
						);
						echo $this->Html->link($this->Html->image(
							'glyphicons/glyphicons_058_truck.png',
							array('alt' => 'Ship purchase', 'class' => 'glyphicon')),
							array('controller' => 'purchases', 'action' => 'switch_shipped', $p['id']),
							array('escape' => false)
						);
						echo $this->Html->link($this->Html->image(
							'glyphicons/glyphicons_226_euro.png',
							array('alt' => 'Pay purchase', 'class' => 'glyphicon')),
							array('controller' => 'purchases', 'action' => 'switch_payed', $p['id']),
							array('escape' => false)
						);
						echo $this->Form->postLink(
							$this->Html->image(
								'glyphicons/glyphicons_016_bin.png',
								array('alt' => 'Delete purchase', 'class' => 'glyphicon')
							),
							array('controller' => 'purchases', 'action' => 'delete', $p['id']),
							array('escape' => false, 'confirm' => 'Are you sure you want to remove this order?')
						);
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