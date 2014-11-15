<?php 
global $app;
 ?>

<header></header>

<p class="headline">
	<strong>Ooops :-( The page you requested could not be found.</strong>
	<a href="<?php echo Template\Url::href( array($app["welcomePage"]) ); ?>">Go to homepage</a>
</p>