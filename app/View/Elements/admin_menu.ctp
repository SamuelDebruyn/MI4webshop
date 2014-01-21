<aside class="adminmenu">
	<h3><?php echo __('Administrator menu'); ?></h3>
	<ul>
		<li><?php echo $this -> Html -> link('Manage users', array('controller' => 'users', 'action' => 'manage_overview')); ?></li>
	</ul>
</aside>