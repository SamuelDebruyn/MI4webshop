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
				<li><a href="#tab-1"><?php echo $this->Html->image('glyphicons/glyphicons_003_user.png', array('alt' => 'User', 'class' => 'glyphicon-white')).__("Profile info"); ?></a></li>
				<li><a href="#tab-2"><?php echo $this->Html->image('glyphicons/glyphicons_029_notes_2.png', array('alt' => 'Orders', 'class' => 'glyphicon-white')).__("Past orders"); ?></a></li>
			</ul>
			<div id="tab-1">
				<fieldset>
					<legend><?php echo __("Edit your profile information"); ?></legend>
					<?php echo $this->Form->create(); ?>
				<?php
					echo $this->Form->input("first_name", array('label' => 'First name: '));
					echo $this->Form->input("last_name", array('label' => 'Last name: '));
					echo $this->Form->input("email", array('label' => 'Email address: '));
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
			startCollapsed: false,
			rotate: false,
			animation: 'slide'
		});
	});
</script>
