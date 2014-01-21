<?php
	$this->Minify->script('vendor/stupidtable.min', array('inline' => false));
?>
<article>
	<header>
		<h2><?php echo __("Edit or delete users"); ?></h2>
		<p><?php echo __("Note that deleting a user will also delete the user's purchase history. Click on a column to sort it."); ?></p>
	</header>
	<section>
		<table class="admintable">
			<thead>
				<th data-sort="int"><?php echo __('ID'); ?></th>
				<th data-sort="string-ins"><?php echo __('Username'); ?></th>
				<th data-sort="string-ins"><?php echo __('First name'); ?></th>
				<th data-sort="string-ins"><?php echo __('Last name'); ?></th>
				<th data-sort="string-ins"><?php echo __('Email'); ?></th>
				<th data-sort="string-ins"><?php echo __('Address'); ?></th>
				<th data-sort="string-ins"><?php echo __('Is admin'); ?></th>
				<th data-sort="string-ins"><?php echo __('Last modified'); ?></th>
				<th><?php echo __('Actions'); ?></th>
			</thead>
			<tbody>
				<?php
					foreach($users as $user){
						$u = $user['User'];
						$adm = $u['admin'] == 1 ? __('yes') : __('no');
						echo "<tr>";
						echo "<td>".$u['id']."</td>";
						echo "<td>".$u['username']."</td>";
						echo "<td>".$u['first_name']."</td>";
						echo "<td>".$u['last_name']."</td>";
						echo "<td>".$u['email']."</td>";
						echo "<td>".$u['address']."</td>";
						echo "<td>".$adm."</td>";
						echo "<td>".$u['modified']."</td>";
						echo "<td>".$this->Form->postLink($this->Html->image('glyphicons/glyphicons_007_user_remove.png', array('alt' => 'Delete user', 'class' => 'glyphicon')), array('controller' => 'users', 'action' => 'delete', $u['id']), array('escape' => false, 'confirm' => 'Are you sure you want to remove '.$u['first_name'].'?'))."</td>";
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