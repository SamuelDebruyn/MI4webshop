<?php

	Router::connect('/', array('controller' => 'static pages', 'action' => 'home'));
	Router::connect('/cart', array('controller' => 'static pages', 'action' => 'cart'));
	Router::connect('/clear', array('controller' => 'static pages', 'action' => 'clearCart'));
	Router::connect('/ERD', array('controller' => 'static pages', 'action' => 'ERD'));
	Router::connect('/', array('controller' => 'static_pages', 'action' => 'home'));
	Router::connect('/cart', array('controller' => 'static_pages', 'action' => 'cart'));
	Router::connect('/clear', array('controller' => 'static_pages', 'action' => 'clearCart'));
	Router::connect('/ERD', array('controller' => 'static_pages', 'action' => 'ERD'));
	Router::connect('/user', array('controller' => 'users', 'action' => 'home'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/register', array('controller' => 'users', 'action' => 'register'));

	CakePlugin::routes();

	require CAKE . 'Config' . DS . 'routes.php';
