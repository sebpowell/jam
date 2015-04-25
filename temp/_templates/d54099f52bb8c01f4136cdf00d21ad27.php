<div class="page-content">
	<div class="container-narrow typography ">
		<div class="masthead">
			<h1>Manifesto</h1>
		</div>

		<section class="no-padding">
			<p>Building products is hard. When the three of us started working
				together at <a href="http://www.adbrain.com" target="_blank">Adbrain</a> a year ago, we struggled. We’d
				worked on products before, but nothing quite like this (ad tech
				products are complicated). How do you decide what to build? How do
				designers, engineers and product managers seamlessly work together?
				What tools are best for the job at hand? How does a good product
				become great?</p>

			<p>We often wondered how other companies went about building products
				from scratch. We realised what we really needed was a place where we
				could learn from others that have been there and done it. Somewhere
				where we could discover and understand how all the parts fit
				together.</p>

			<p>So we decided to start JAM. This is the community we wish we’d had
				all along, a place where people, across all disciplines can discuss
				their successes and failures, experiments, tools and techniques, and
				anything else that gets great products built.</p>

			<p>We hope you’ll join us.</p>
		</section>
		<section class="team">
			<?php  foreach($template["theTeam"] as $k => $v) {  ?>
			<div class="flex-row">
				<div class="columns-4">
					<img src="/assets/images/team/<?php echo( $v["photo"] ); ?>">
				</div>
				<div class="columns-8">
					<h5><?php echo( $v["name"] ); ?></h5>

					<p><?php echo( $v["desc"] ); ?></p>
					<a target="_blank" href="http://uk.linkedin.com/in/<?php echo( $v["linkedin"] ); ?>">LinkedIn</a>
					<a target="_blank" href="https://twitter.com/<?php echo( $v["twitter"] ); ?>">Twitter</a>
				</div>
			</div>
			<?php  }  ?>
		</section>
	</div>
</div>