<div class="header-container">
	<header class="wrapper clearfix">
		<h1 class="title"><?php echo $this -> Html -> link($siteTitle, array('controller' => 'static pages', 'action' => 'home')); ?></h1>
		<nav>
			<ul>
				<li><?php echo $this -> Html -> link('Home', array('controller' => 'static pages', 'action' => 'home')); ?></li>
				<li class="userstatus"><?php
					echo $this -> Html -> link('Sign in / sign up', array('controller' => 'users', 'action' => 'login'));
				?></li>
			</ul>
		</nav>
	</header>
</div>	