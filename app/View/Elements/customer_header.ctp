<div class="header-container">
	<header class="wrapper clearfix">
		<h1 class="title"><?php echo $this -> Html -> link($siteTitle, array('controller' => 'static_pages', 'action' => 'home')); ?></h1>
		<nav>
			<ul>
				<li><?php echo $this -> Html -> link('Home', array('controller' => 'static_pages', 'action' => 'home')); ?></li>
				<li><?php echo $this -> Html -> link('Shopping cart', array('controller' => 'static_pages', 'action' => 'cart')); ?></li>
				<?php
					if(!$loggedIn){
						echo "<li>".$this -> Html -> link('Sign in', array('controller' => 'users', 'action' => 'login'))."</li>";
					}else{
						echo "<li>".$this -> Html -> link('Your profile', array('controller' => 'users', 'action' => 'home'))."</li>";
						echo "<li>".$this -> Html -> link('Sign out', array('controller' => 'users', 'action' => 'logout'))."</li>";
					}					
				?>
			</ul>
		</nav>
	</header>
</div>	