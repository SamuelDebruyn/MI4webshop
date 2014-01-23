<article>
	<header>
		<h2><?php echo __("Add new user"); ?></h2>
	</header>
	<section>
		<fieldset>
			<legend><?php echo __("Profile information"); ?></legend>
			<?php echo $this->Form->create(); ?>
		<?php
			echo $this->Form->input("username", array('label' => 'Username: '));
			echo $this->Form->input("first_name", array('label' => 'First name: '));
			echo $this->Form->input("last_name", array('label' => 'Last name: '));
			echo $this->Form->input("email", array('label' => 'Email address: '));
			echo $this->Form->input("password", array('label' => 'Password: '));
			echo $this->Form->input("admin", array('label' => ' is an administrator?'));
			echo $this->Form->input("address", array('label' => 'Address: '));
			echo $this->Form->end('Save changes');
		?>
		</fieldset>
	</section>
</article>