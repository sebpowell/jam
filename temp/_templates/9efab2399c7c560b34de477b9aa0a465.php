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

		<nav>
			<ul class="container-narrow">
				<li><a href="/">JAM</a></li>
				<li class="active"><a href="#">Story</a></li>
				<li><a href="#">Speakers</a></li>
				<li><a href="#">Topics</a></li>
				<li><a href="#">Resources</a></li>
				<!--<li><a href="#">Get Involved</a></li>-->
			</ul>

			<button>Tickets</button>
		</nav>

		<?php Template\Template::getLayout(" template "); ?>

		<footer>
			<nav>
				<ul>
					<li>Story</li>
					<li>Resources</li>
					<li>Contact</li>
					<li>Privacy Policy</li>
					<li>Terms &amp; Conditions</li>
				</ul>
			</nav>
		</footer>

		<script src="/assets/js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script src="/assets/js/app.js" type="text/javascript"></script>

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