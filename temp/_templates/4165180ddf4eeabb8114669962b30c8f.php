<article class="flex-1">
	<div class="content">
		<div class="resources">
			<?php  if (isset($template["resourceDetails"])) {  ?>
				<h2><a href="<?php echo( $template["resourceDetails"]["link"] ); ?>" target="_blank"><?php echo( $template["resourceDetails"]["title"] ); ?></a></h2>

				<article style="padding-top: 0">
					<p class="title">
						<small><strong><?php echo( $template["resourceDetails"]["date"] ); ?></strong> by <strong><?php echo( $template["resourceDetails"]["author"] ); ?></strong></small>
					</p>
					<p class="description"><?php echo( $template["resourceDetails"]["desc"] ); ?></p>
					<div class="tags flex">
						<?php  foreach ($template["resourceDetails"]["tags"] as $tag) {  ?>
						<span class="label <?php echo( $tag ); ?>"><?php echo( $tag ); ?></span>
						<?php  }  ?>
					</div>
				</article>
			<?php  } else {  ?>
				<h2>Resources</h2>
				<p class="description">Curated tools &amp; food for thought, updated daily.</p>

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
			<?php  }  ?>
		</div>
	</div>
</article>