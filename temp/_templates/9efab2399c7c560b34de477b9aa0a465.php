<!DOCTYPE html>
<html lang="<?php echo( $template["app"]["lang"] ); ?>">
	<head>

		<meta charset="<?php echo( $template["app"]["encoding"] ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<meta name="description" content="<?php echo( $template["app"]["description"] ); ?>">
		<meta name="keywords" content="<?php echo( $template["app"]["keywords"] ); ?>">

		<title><?php echo( $template["page"]["title"] ); ?> / <?php echo( $template["app"]["siteName"] ); ?></title>

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

		<?php Template\Template::getLayout(" template "); ?>

		<?php Template\Template::getModule(" footer "); ?>

		<?php echo( DEBUG ? Utilities\Debug::getStats() : "" ); ?>

		<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="/assets/js/app.js" type="text/javascript"></script>

		<?php echo( (isset($template["page"]["scripts"]) && is_array($template["page"]["scripts"])) ? Template\jsCompile::compile($template["page"]["scripts"]) : "" ); ?>

	</body>
</html>