<header>
	<h1>Registration</h1>
</header>
<article>
	<header><p>Hi <?php echo $firstName; ?>,</p></header>
	<section>
		<p>Welcome to <?php echo $siteTitle; ?>! This is a confirmation of your registration on our website. If you didn't register on our website you can ignore this email.</p>
		<p>You can now log in with your username <?php echo $username; ?> at <?php echo $this->Html->link('our login page', array('full_base' => true, 'controller' => 'users', 'action' => 'login')); ?> .</p>
	</section>
</article>
<footer>
	<p>
		Greetings,<br/>
		<?php echo $siteTitle; ?>
	</p>
</footer>