<article>
	<header>
		<h1><?php echo __("Reset your password"); ?></h1>
	</header>
	<section>
		<fieldset>
			<legend><?php echo __("Reset password"); ?></legend>
			<?php
				echo $this->Form->create();
				echo "<p>".__("Please enter your username. We will email you a link which you can use to reset your password.")."</p>";
				echo $this->Form->input("username", array('label' => 'Username: '));
				echo $this->Form->end('Request new password');
			?>
		</fieldset>
	</section>
</article>