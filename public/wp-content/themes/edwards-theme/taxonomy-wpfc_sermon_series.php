<?php
/**
 * The template for displaying Sermon Series pages.
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
					<h1 class="entry-title"><?php
						printf( __( 'Sermons Series: %s', 'edwards' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>
				</header><!-- .page-header -->
				<div id="wpfc_sermon_tax_description" class="clearfix">
				<?php
					/* Image */
					print apply_filters( 'sermon-images-queried-term-image', '', array( 'attr' => array( 'class' => 'alignleft post-thumb' ), 'after' => '</div>', 'before' => '<div id="wpfc_sermon_image">', 'image_size' => 'content-width', ) );
					/* Description */
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="sermon-tax-description">' . $category_description . '</div>';
				?>
				</div>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'sermon', 'archive' );	?>

				<?php endwhile; ?>

				<?php wpfc_pagination('', $range = 2); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

<?php get_sidebar('sermon'); ?>
<?php get_footer(); ?>