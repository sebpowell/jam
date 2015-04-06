<!DOCTYPE html>
<html lang="<?php echo( $template["app"]["lang"] ); ?>">
	<head>
		<meta charset="<?php echo( $template["app"]["encoding"] ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta name="description" content="<?php echo( $template["app"]["description"] ); ?>">
		<meta property="og:title" content="<?php  echo isset($template["omTitle"]) ? $template["omTitle"] : "JAM London"  ?>">
		<meta property="og:description" content="<?php  echo isset($template["omDescription"]) ? $template["omDescription"] : $template["app"]["description"]  ?>">
		<meta property="og:url" content="<?php  echo isset($template["omUrl"]) ? $template["omUrl"] : "http://www.jam2015.london"  ?>">
		<meta property="og:image" content="<?php  echo $template["omImage"] ? $template["omImage"] : "http://www.jam2015.london/assets/images/logo/logo-social.png"  ?>">

		<title><?php echo( $template["app"]["siteName"] ); ?> / <?php echo( $template["page"]["title"] ); ?></title>

		<link href="//fonts.googleapis.com/css?family=Source+Code+Pro:300,500,700" rel="stylesheet" type="text/css">
		<script src="//use.typekit.net/gwv4cfc.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>

		<link rel="stylesheet" href="/assets/css/litchi.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" href="/screen-icon.png">
	</head>

	<body class="preload page-<?php echo( $template["page"]["url"]["template"] ); ?> <?php echo( $template["app"]["lang"] ); ?>">
		<div id="wrapper">
		<noscript>
			<div id="warning">
				To be able to experience <?php echo( $template["app"]["siteName"] ); ?> with all its features, you need a browser that supports JavaScript, and it <strong>needs to be enabled.</strong>
			</div>
		</noscript>

		<div class="alert flex center-horizontally center-vertically info">This is an info message</div>
		<div class="alert flex center-horizontally center-vertically warning">This is a warning message</div>
		<div class="alert flex center-horizontally center-vertically error">This is an error message</div>
		<div class="alert flex center-horizontally center-vertically success">This is a success message</div>

		<div class="modal-backdrop"></div>
		<div class="modal is-hidden">
			<div class="modal-content">
				<div class="close-modal">&times;</div>
				<article id="loadModalContent"></article>
			</div>
		</div>

		<!-- Navigation !-->
		<ul class="navigation-toggle">
			<li></li>
		</ul>
		
		<header id="top-nav">
			<div class="container-fluid">
				<a class="logo" href="/"></a>
				<a href="https://www.eventbrite.com/e/jam-london-2015-tickets-16351563968" class="button" id="bookTickets" target="_blank">Book Tickets</a>
			</div>
		</header>

		<nav class="nav-links">
		 	<li><a href="/">Home</a></li>
			<li><a href="about">Story</a></li>
			<li><a href="/resources">Resources</a></li>
			<!-- <li><a href="/get-involved">Get Involved</a></li> -->
			<a href="https://www.eventbrite.com/e/jam-london-2015-tickets-16351563968" class="button white block" target="_blank">Book Tickets</a>
		</nav>
		<!-- / Navigation !-->

		<div class="promotion">
			<div class="container-wide">
				<p>Tell the world about JAM, and get £5 off your ticket</p>
				<button class="">Share</button>
			</div>
		</div>

		<?php Template\Template::getLayout(" template "); ?>

		<footer>
			<div class="container-wide">
				<ul class="site-links">
					<li><a href="about">Story</a></li>
					<li><a href="<?php echo Template\Url::href( array("resources") ); ?>">Resources</a></li>
					<li><a href="mailto:hello@jam2015.london">Contact</a></li>
					<!-- <li><a href="get-involved">Get Involved</a></li> -->
					<li><a href="<?php echo Template\Url::href( array("code-of-conduct") ); ?>">Code of Conduct</a></li>
				</ul>
				<ul class="social-links">
					<li><a href="https://www.facebook.com/makingjam" class="facebook" target="_blank"></a></li>
					<li><a href="https://twitter.com/JamLondon2015" class="twitter" target="_blank"></a></li>
				</ul>
				<div class="copyright">
					<h6>Made In London</h6>
					<small>JAM is a company registered in England & Wales, company number 789798.</small>
				</div>
			</div>
		</footer>

		<script src="/assets/js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script src="/assets/js/smooth-scroll.min.js" type="text/javascript"></script>
		<script src="/assets/js/litchi.js" type="text/javascript"></script>

		<?php echo( (isset($template["page"]["scripts"]) && is_array($template["page"]["scripts"])) ? Template\jsCompile::compile($template["page"]["scripts"]) : "" ); ?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-56807522-1', 'auto');
			ga('send', 'pageview');
		</script>
		</div>
	</body>
</html>