Hi <?php echo $user['first_name']; ?>,

The status of your order with ID <?php echo $orderID; ?> on <?php echo $siteTitle; ?> has changed to <?php echo $newStatus; ?>.
Log into your account with username <?php echo $user['username']; ?> at <?php echo $this->Html->link('our login page', array('full_base' => true, 'controller' => 'users', 'action' => 'login')); ?> to view more details.

Greetings,
<?php echo $siteTitle; ?>