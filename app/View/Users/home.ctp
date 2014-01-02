<?php
	
	$this->Html->script('vendor/jquery.responsiveTabs.min', array('inline' => false));
	
	$user = $userData['User']
?>
<article>
	<header>
		<h2><?php echo __("Hi, ").$user['first_name']; ?></h2>
	</header>
	<section>
		<div class="tabsContainer">
			<ul>
				<li><a href="#tab-1"><?php echo __("Profile info"); ?></a></li>
				<li><a href="#tab-2"><?php echo __("Past orders"); ?></a></li>
			</ul>
			<div id="tab-1">
				<?php echo pr($userData['User']); ?>
			</div>
			<div id="tab-2">
				<?php echo pr($userData['Purchase']); ?>
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
	});
</script>
