<section id="masthead" class="flex center-vertically">
	<div class="container-narrow">
		<h1>Sharing the stories behind great products.<br/>
			1 day. 9 speakers. Great coffee.</h1>

		<h2>London, Saturday 3rd of October 2015. 10am - 6pm.</h2>

		<div class="flex center-vertically">
			<button class="no-margin brand large">Book Tickets</button>
			<small class="margin-left-base"><strong>20</strong> Early Bird Tickets left...
			</small>
		</div>
	</div>
</section>

<section id="sectionStory">
	<div class="container-narrow">
		<h2>Why Jam?</h2>

		<p>We stared JAM to create a place where people, across all disciplines can discuss their
			successes and failures, experiments, tools and techniques, and anything else that gets
			great products built.</p>

		<button class="large" id="ourStory">Our story</button>
	</div>
</section>

<section id="sectionSpeakers" class="text-center">
	<div class="container-narrow">
		<h2>Straight from the horses’ mouth.<br/>
			9 speakers share how they’ve done it.</h2>
	</div>

	<div class="container-fluid">
		<ul class="flex-grid-3">
			<?php  foreach ($template["authors"] as $k => $v) {  ?>
			<li class="flex-item">
				<img src="/assets/images/speakers/graham-paterson.jpg" alt="<?php echo( $k ); ?>'s Avatar"/>
				<strong><?php echo( $k ); ?></strong>

				<small><?php echo( $v["position"] ); ?><br/><?php echo( $v["company"] ); ?>
				</small>
			</li>
			<?php  }  ?>
		</ul>
	</div>
</section>

<section id="sectionTopics">
	<div class="container-narrow">
		<h2 class="text-center no-margin">20 Minute Talks. Lots of Topics.</h2>

		<?php  foreach ($template["schedule"] as $k) {  ?>
		<article>
			<p><?php echo( $k["time"] ); ?></p>
			<h4><?php echo( $k["title"] ); ?></h4>

			<?php  $author = $template["authors"][$k["author"]];  ?>

			<div class="bio">
				<img src="/assets/images/team/mathilde-leo.png" alt="<?php echo( $k[" author"] ); ?>'s
				Avatar"/>
				<aside>
					<strong><?php echo( $k["author"] ); ?></strong>
					<small><?php echo( $author["position"] ); ?>, <?php echo( $author["company"] ); ?></small>
				</aside>
			</div>
		</article>
		<?php  }  ?>
	</div>
</section>

<section id="sectionVenue" class="text-center">
	<div class="container-narrow">
		<h2>Hosted in the iconic Oval Space, Bethnal Green.<br/>
			Food & Drink Provided.</h2>
		<button class="brand large">Book now!</button>
	</div>
</section>