<?php
/**
 * Template Name: Home
 */

get_header(); ?>

		<?php 
			$homeMessage = of_get_option('edwards_home_message');
			if($homeMessage) : ?>		
				<div id="home-message" class="clearfix">
					<p><?php echo $homeMessage; ?></p>
				</div>
			<?php endif; 
			get_template_part( 'part-home-feature');
		?>

		<div id="primary" class="content-area">
			<div id="content" class="full" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>