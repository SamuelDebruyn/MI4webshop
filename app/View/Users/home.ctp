<?php $user = $userData['User'] ?>
<article>
	<header>
		<h2><?php echo __("Hi, ").$user['first_name']; ?></h2>
	</header>
	<section>
	</section>
</article>
<?php echo pr($userData); ?>
