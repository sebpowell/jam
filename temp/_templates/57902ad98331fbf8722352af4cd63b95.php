<div class="content">
	<?php  foreach($template["content"] as $k) {  ?>
	<article class="flex column">
		<p><?php echo( $k["title"] ); ?></p>
		<small><?php echo( $k["desc"] ); ?></small>
		<div class="tags flex">
			<?php  foreach ($k["tags"] as $tag) {  ?>
			<span class="label <?php echo( $tag ); ?>"><?php echo( $tag ); ?></span>
			<?php  }  ?>
		</div>
		<a href="<?php echo( $k[" link"] ); ?>">View associated URL</a>
	</article>
	<?php  }  ?>
</div>