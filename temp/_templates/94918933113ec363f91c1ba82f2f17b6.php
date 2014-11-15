<h1><?php echo( $template["page"]["title"] ); ?></h1>

<?php Template\Template::getModule(" nav "); ?>

<?php 
	if (isset($template["alertSignUp"])) { echo $template["alertSignUp"]; }

	echo $template["formSignUp"];
 ?>