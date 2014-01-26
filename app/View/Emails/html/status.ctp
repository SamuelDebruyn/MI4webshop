<header>
	<h1>Order status</h1>
</header>
<article>
	<header><p>Hi <?php echo $user['first_name']; ?>,</p></header>
	<section>
		<p>The status of your order with ID <?php echo $orderID ?> on <?php echo $siteTitle; ?> has changed to <strong><?php echo $newStatus; ?></strong>.</p>
		<p>Log into your account with username <?php echo $user['username']; ?> at <?php echo $this->Html->link('our login page', array('full_base' => true, 'controller' => 'users', 'action' => 'login')); ?> to view more details.</p>
	</section>
</article>
<footer>
	<p>
		Greetings,<br/>
		<?php echo $siteTitle; ?>
	</p>
</footer>