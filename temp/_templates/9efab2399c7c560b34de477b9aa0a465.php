<!DOCTYPE html>
<html lang="<?php echo( $template["app"]["lang"] ); ?>">
	<head>

		<meta charset="<?php echo( $template["app"]["encoding"] ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta name="description" content="<?php echo( $template["app"]["description"] ); ?>">

		<title><?php echo( $template["app"]["siteName"] ); ?> / <?php echo( $template["page"]["title"] ); ?></title>

		<link href="https://fonts.googleapis.com/css?family=Anonymous+Pro:700,400" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="/assets/css/screen.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon-precomposed" href="/screen-icon.png">

	</head>

	<body class="preload page-<?php echo( $template["page"]["url"]["template"] ); ?> <?php echo( $template["app"]["lang"] ); ?>">

		<noscript>
			<div id="warning">
				To be able to experience <?php echo( $template["app"]["siteName"] ); ?> with all its features, you need a browser that supports JavaScript, and it <strong>needs to be enabled.</strong>
			</div>
		</noscript>

		<div class="flex column container">
			<nav class="flex center-vertically">
				<a class="flex-1" href="/manifesto">Manifesto</a>
				<a class="flex-1" href="mailto:mathildeleo@gmail.com">Get involved</a>
			</nav>

			<?php Template\Template::getLayout(" template "); ?>

			<nav class="flex center-vertically">
				<a class="flex-1" href="https://twitter.com/jamlon2015">Twitter</a>
				<a class="flex-1" href="mailto:mathildeleo@gmail.com">Contact</a>
			</nav>
		</div>

		<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
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