Hi <?php echo $firstName; ?>,

This is a confirmation of your order on <?php echo $siteTitle; ?>.
Log into your account with username <?php echo $username; ?> at <?php echo $this->Html->link('our login page', array('full_base' => true, 'controller' => 'users', 'action' => 'login')); ?> to view the order status.

Please view this email in a HTML mail client to view the contents of your order.

Greetings,
<?php echo $siteTitle; ?>