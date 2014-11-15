<?php 
$act = (isset($template["page"]["act"]) ? $template["page"]["act"] : 0);
 ?>

<ul>
	<li<?php echo( $act == 1 ? ' class="active"' : '' ); ?>><a href="<?php echo Template\Url::href( array("") ); ?>">Welcome</a></li>
	<li<?php echo( $act == 2 ? ' class="active"' : '' ); ?>><a href="<?php echo Template\Url::href( array("user", "sign-up") ); ?>">Sign up</a></li>
	<li<?php echo( $act == 3 ? ' class="active"' : '' ); ?>><a href="<?php echo Template\Url::href( array("user", "sign-in") ); ?>">Sign in</a></li>
</ul>