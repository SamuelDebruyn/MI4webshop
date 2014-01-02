<article>
	<header>
		<h1><?php echo __("Sign up"); ?></h1>
	</header>
	<section>
		<?php
			echo $this->Form->create();
			?>
			<fieldset>
				<legend><?php echo __("Sign up for a new account"); ?></legend>
				<p><?php echo __("All fields are required."); ?></p>
				<?php
					echo $this->Form->input("username", array('label' => 'Username: '));
					echo $this->Form->input("password", array('label' => 'Password: '));
					echo $this->Form->input("first_name", array('label' => 'First name: '));
					echo $this->Form->input("last_name", array('label' => 'Last name: '));
					echo $this->Form->input("email", array('label' => 'Email address: '));
					echo $this->Form->input("address", array('label' => 'Address: '));
				?>
			</fieldset>
			<?php
			echo $this->Form->end('Sign up');
		?>
	</section>
</article>