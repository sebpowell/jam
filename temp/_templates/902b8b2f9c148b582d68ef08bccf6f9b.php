<article class="flex-1">
	<a id="logo" href="/">
		<h1>Making JAM London</h1>
	</a>

	<div class="content">
		<p>We're a London-based community for people who build products.
			Launching Spring 2015.</p>

		<div class="alert warning hide"></div>
		<div class="alert error hide"></div>
		<div class="alert success hide"></div>

		<form id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
			  class="flex">

			<input style="display: none" type="text" name="b_7f799244738e8b8558a646378_6c81011ad7"
				   tabindex="-1" value="">

			<input autofocus class="flex-8" type="email" name="EMAIL"
				   placeholder="Sign up for updates"
				   required/>

			<button class="flex-4 button primary" name="subscribe">Sign up</button>

		</form>

		<p>In the meantime, <a href="/manifesto">read our story</a>.</p>
	</div>

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
</article>