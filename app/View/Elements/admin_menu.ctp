<aside class="adminmenu">
	<h3><?php echo __('Administrator menu'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link('Manage users', array('controller' => 'users', 'action' => 'manage_overview')); ?></li>
		<li><?php echo $this -> Html -> link('Manage categories', array('controller' => 'categories', 'action' => 'manage_overview')); ?></li>
		<li><?php echo $this -> Html -> link('Manage products', array('controller' => 'products', 'action' => 'manage_overview')); ?></li>
		<li><?php echo $this -> Html -> link('Manage orders', array('controller' => 'purchases', 'action' => 'manage_overview')); ?></li>
	</ul>
</aside>