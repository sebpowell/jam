<article>
	<div class="content">
		<h2 class="text-center padding-top-double">Add a new resource:</h2>

		<div class="temporary-alert hide">
		<?php 
		if (isset($template["alertAdd"])) { echo $template["alertAdd"]; }
		 ?>
		</div>

		<?php echo( $template["formAdd"] ); ?>
	</div>
</article>