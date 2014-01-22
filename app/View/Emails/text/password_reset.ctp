Hi <?php echo $firstName; ?>,

It seems that you requested a new password on <?php echo $siteTitle; ?>. If this wasn't the case you can ignore this email.

Please copy the following link into your browser if you'd like to set a new password:
<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'use_reset_key', $resetCode), true); ?>

Greetings,

<?php echo $siteTitle; ?>