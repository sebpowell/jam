<article class="flex-1">
<div class="content">
<div class="resources">
		<h2>Resources</h2>
		<p class="description">We post tools, articles and resources we use and think you'll find useful too.</p>

		<?php  foreach($template["content"] as $k) {  ?>
		<article>
			<p class="title">
				<a href="<?php echo( $k["link"] ); ?>" target="_blank"><?php echo( $k["title"] ); ?></a>
				<small><strong><?php echo( $k["date"] ); ?></strong> by <strong><?php echo( $k["author"] ); ?></strong></small>
			</p>
			<p class="description"><?php echo( $k["desc"] ); ?></p>
			<div class="tags flex">
				<?php  foreach ($k["tags"] as $tag) {  ?>
				<span class="label <?php echo( $tag ); ?>"><?php echo( $tag ); ?></span>
				<?php  }  ?>
			</div>
		</article>
		<?php  }  ?>

	</div>
	</div>
</article>