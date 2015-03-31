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

		<!--<link href="https://fonts.googleapis.com/css?family=Anonymous+Pro:700,400" rel="stylesheet" type="text/css">-->
		<link href="//fonts.googleapis.com/css?family=Source+Code+Pro:300,500,700" rel="stylesheet" type="text/css">
		<script src="//use.typekit.net/gwv4cfc.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>

		<link rel="stylesheet" href="/assets/css/litchi.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" href="/screen-icon.png">

	</head>

	<body class="preload page-<?php echo( $template["page"]["url"]["template"] ); ?> <?php echo( $template["app"]["lang"] ); ?>">

		<noscript>
			<div id="warning">
				To be able to experience <?php echo( $template["app"]["siteName"] ); ?> with all its features, you need a browser that supports JavaScript, and it <strong>needs to be enabled.</strong>
			</div>
		</noscript>

		<!--<div class="alert flex center-horizontally center-vertically info">This is an info message</div>-->
		<!--<div class="alert flex center-horizontally center-vertically warning">This is a warning message</div>-->
		<!--<div class="alert flex center-horizontally center-vertically error">This is an error message</div>-->
		<!--<div class="alert flex center-horizontally center-vertically success">This is a success message</div>-->

		<div class="modal is-hidden">
			<div class="modal-content">
				<div class="close-modal">&times;</div>
				<article id="loadModalContent"></article>
			</div>
		</div>

		<nav id="top-nav">
			<div class="container-fluid">
				<a class="logo" href="/"></a>
				<ul>
					<li id="navItemStory"><a data-scroll href="#sectionStory">Story</a></li>
					<li id="navItemSpeakers"><a data-scroll href="#sectionSpeakers">Speakers</a></li>
					<li id="navItemTopics"><a data-scroll href="#sectionTopics">Topics</a></li>
					<li><a href="/resources">Resources</a></li>
					<!--<li><a href="#">Get Involved</a></li>-->
				</ul>

				<button class="turquoise" id="bookTickets">Book tickets</button>
			</div>
		</nav>

		<?php Template\Template::getLayout(" template "); ?>

		<footer>
			<div class="container-narrow">
				<nav>
					<ul class="unstyled">
						<li><a class="toggle-our-story">Story</a></li>
						<li><a href="<?php echo Template\Url::href( array("resources") ); ?>">Resources</a></li>
						<li><a href="<?php echo Template\Url::href( array("contact") ); ?>">Contact</a></li>
						<li><a href="<?php echo Template\Url::href( array("code-of-conduct") ); ?>">Code of Conduct</a></li>
<!-- 						<li><a href="<?php echo Template\Url::href( array("privacy-policy") ); ?>">Privacy Policy</a></li> -->
<!-- 						<li><a href="<?php echo Template\Url::href( array("terms-and-conditions") ); ?>">Terms &amp; Conditions</a></li> -->
					</ul>
				</nav>
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

	</body>
</html>