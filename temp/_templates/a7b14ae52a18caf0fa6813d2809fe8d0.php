<article>
	<div class="content">
		<p>Add a new resource:</p>

		<div class="temporary-alert hide">
		<?php 
		if (isset($template["alertAdd"])) { echo $template["alertAdd"]; }
		 ?>
		</div>

		<?php echo( $template["formAdd"] ); ?>
	</div>
</article>