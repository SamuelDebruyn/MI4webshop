<header>
	<h1>Password reset</h1>
</header>
<article>
	<header><p>Hi <?php echo $firstName; ?>,</p></header>
	<section>
		<p>It seems that you requested a new password on <?php echo $siteTitle; ?>. If this wasn't the case you can ignore this email.</p>
		<p>
			Please click on the following link if you'd like to set a new password:<br/>
			<?php echo $this->Html->link('reset your password', array('full_base' => true, 'controller' => 'users', 'action' => 'use_reset_key', $resetCode)); ?>
		</p>
	</section>
</article>
<footer>
	<p>
		Greetings,<br/>
		<?php echo $siteTitle; ?>
	</p>
</footer>