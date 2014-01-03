<?php
	
	$this -> Minify -> css(array('normalize.min', 'main'), null, array('inline' => false));
	$this-> Minify -> script(array(
		'main',
		'vendor/modernizr-2.6.2-respond-1.1.0.min'
	), array('inline' => false));
	
	echo $this->Html->docType("html5");
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>
		<?php echo $this -> Html -> charset(); ?>
		<title><?php echo $siteTitle.": ".$title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width">
		<?php
			echo $this -> fetch('meta');
			echo $this -> fetch('css');
			echo $this -> Minify -> script('vendor/jquery-1.10.2.min');
		?>
	</head>
	<body>
		<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <?php echo $this -> element('customer_header'); ?>
        
        <div class="main-container">
            <div class="main wrapper clearfix">

                <?php
                	echo $this -> Session -> flash();
					echo $this -> fetch('content');
				?>

            </div> <!-- #main -->
        </div> <!-- #main-container -->
        
		<div class="footer-container">
            <footer class="wrapper">
                <h3>&copy; <?php echo $siteTitle . " " . date("Y"); ?></h3>
            </footer>
        </div>
		<script>
			var _gaq = [['_setAccount', 'UA-46771571-1'], ['_trackPageview']]; ( function(d, t) {
					var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
					g.src = '//www.google-analytics.com/ga.js';
					s.parentNode.insertBefore(g, s)
				}(document, 'script'));
		</script>
		<?php echo $this -> fetch('script'); ?>
	</body>
</html>
