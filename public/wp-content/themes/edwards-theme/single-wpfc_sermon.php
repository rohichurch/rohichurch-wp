<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Edwards
 * @since Edwards 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); 
					/* 
					 * If you want to overload this in a child theme then include a file
					 * called sermon-single.php and that will be used instead.
					 */
					get_template_part( 'sermon', 'single' ); ?>

				<?php edwards_content_nav( 'nav-below' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar('sermon'); ?>
<?php get_footer(); ?>