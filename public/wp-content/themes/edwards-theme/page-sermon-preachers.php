<?php
/**
 * Template Name: List Preachers
 */

get_header(); 
$prefix = 'wpfc_';
$page_description = get_post_meta($post->ID, $prefix.'page_description', true);
?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php if(!empty($page_description)) { ?>
							<div class="page-description">
								<?php echo $page_description; ?>
							</div><!-- .page-description -->
						<?php } ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php echo edwards_display_sermon_tax( array( 'tax' => 'wpfc_preacher', 'size' => 'thumbnail') ); ?>
					</div><!-- .entry-content -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'edwards' ), '<span class="edit-link"> <i class="icon-edit"></i> ', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post-<?php the_ID(); ?> -->

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar('sermon'); ?>
<?php get_footer(); ?>