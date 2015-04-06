<article class="flex-1" id="measureScroll">
	<div class="content">
		<div class="resources">
			<?php  if (isset($template["resourceDetails"])) {  ?>

				<h2><a href="<?php echo( $template["resourceDetails"]["link"] ); ?>" target="_blank"><?php echo( $template["resourceDetails"]["title"] ); ?></a></h2>

				<article style="padding-top: 0">
					<h3 class="title">
						<small><strong><?php echo( $template["resourceDetails"]["date"] ); ?></strong> by <strong><?php echo( $template["resourceDetails"]["author"] ); ?></strong></small>
					</p>
					<p><?php echo( $template["resourceDetails"]["desc"] ); ?></p>
					<div class="tags flex">
						<?php  foreach ($template["resourceDetails"]["tags"] as $tag) {  ?>
						<span class="label <?php echo( $tag ); ?>"><?php echo( $tag ); ?></span>
						<?php  }  ?>
					</div>
				</article>
			<?php  } else {  ?>

				<!--<h2>Resources</h2>-->
				<!--<p class="description">Curated tools &amp; food for thought, updated daily.</p>-->

				<?php  foreach($template["content"] as $k) {  ?>
				<a href="<?php echo( $k["link"] ); ?>" target="_blank">
				<article>
					<div class="container-narrow">
						<h3><?php echo( $k["title"] ); ?></h3>
						<small><strong><?php echo( $k["date"] ); ?></strong></small>
						<!-- <strong><?php echo( $k["author"] ); ?></strong> -->
						<p><?php echo( $k["desc"] ); ?></p>
						<div class="tags flex">
							<?php  foreach ($k["tags"] as $tag) {  ?>
							<span class="label <?php echo( $tag ); ?>"><?php echo( $tag ); ?></span>
							<?php  }  ?>
						</div>
					</div>
				</article>
				</a>
				<?php  }  ?>
			<?php  }  ?>
		</div>
	</div>
</article>
</div>