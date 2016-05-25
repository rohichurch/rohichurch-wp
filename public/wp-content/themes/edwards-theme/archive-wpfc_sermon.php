<?php
/**
 * The template for displaying Sermon Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Edwards
 * @since Edwards 1.0
 */

get_header(); ?>

		<section id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="entry-header">
					<h1 class="entry-title">
						<?php
						$sermon_settings = get_option('wpfc_options');
						$archive_title = $sermon_settings['archive_title'];
						if(empty($archive_title)):
							$archive_title = 'Sermons';
						endif; 
						?>
					<?php echo $archive_title; ?>
					</h1>
				</header><!-- .page-header -->

				<?php render_wpfc_sorting(); ?>
				
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'sermon', 'archive' );
					?>

				<?php endwhile; ?>

				<?php wpfc_pagination('', $range = 2); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

<?php get_sidebar('sermon'); ?>
<?php get_footer(); ?>