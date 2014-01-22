<?php

	Router::connect('/', array('controller' => 'static pages', 'action' => 'home'));
	Router::connect('/cart', array('controller' => 'static pages', 'action' => 'cart'));
	Router::connect('/clear', array('controller' => 'static pages', 'action' => 'clearCart'));
	Router::connect('/user', array('controller' => 'users', 'action' => 'home'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/register', array('controller' => 'users', 'action' => 'register'));

	CakePlugin::routes();

	require CAKE . 'Config' . DS . 'routes.php';
