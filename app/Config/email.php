<?php
class EmailConfig {

	public $default = array(
		'viewVars' => array('siteTitle' => 'SamShack'),
		'from' => array('webshop.s@muel.be' => 'SamShack'),
		'sender' => 'webshop.s@muel.be',
		'returnPath' => 'webshop.s@muel.be',
		'emailFormat' => 'both',
		'charset' => 'utf-8',
		'headerCharset' => 'utf-8',
		'transport' => 'Mail'
	);

}
