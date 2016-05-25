<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Edwards
 * @since Edwards 1.0
 */
$prefix = 'wpfc_';
$page_description = get_post_meta($post->ID, $prefix.'page_description', true);
?>

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
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'edwards' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'edwards' ), '<span class="edit-link"> <i class="icon-edit"></i> ', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
