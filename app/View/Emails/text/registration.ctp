Hi <?php echo $firstName; ?>,

Welcome to <?php echo $siteTitle; ?>! This is a confirmation of your registration on our website.
If you didn't register on our website you can ignore this email.

You can now log in with your username <?php echo $username; ?> at <?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login'), true); ?> .

Greetings,

<?php echo $siteTitle; ?>