<?php
/**
 * @package Edwards
 * @since Edwards 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title">
			<?php if ( !is_single() ) : // No Link on Single View ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			<?php else : ?>
				<?php the_title(); ?>
			<?php endif; ?>
		</h1>

		<div class="entry-meta">
			<?php wpfc_sermon_date('l, F j, Y', '<span class="sermon_date"><i class="icon-calendar"></i> ', '</span> '); wpfc_sermon_meta('service_type', ' <span class="service_type">(', ')</span> '); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php edwards_sermon_buttons(); ?>
		<p>
			<?php
			wpfc_sermon_meta('bible_passage', '<span class="bible_passage">Bible Text: ', '</span> | ');
			echo the_terms( $post->ID, 'wpfc_preacher',  '<span class="preacher_name">Speaker: ', ' ', '</span>');
			echo the_terms( $post->ID, 'wpfc_sermon_series', '<span class="sermon_series">Series: ', ' ', '</span>' ); 
			?>
		</p>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php edwards_sermon_buttons(); ?>
		<?php edwards_sermon_media(); ?>
		<p><?php
				wpfc_sermon_meta('bible_passage', '<span class="bible_passage">Bible Text: ', '</span> | ');
				echo the_terms( $post->ID, 'wpfc_preacher',  '<span class="preacher_name">Speaker: ', ', ', '</span>');
				echo the_terms( $post->ID, 'wpfc_sermon_series', '<span class="sermon_series">Series: ', ', ', '</span>' ); 
			?>
		</p>
		<?php wpfc_sermon_description(); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php if ( is_single() ) : // No footer meta unless on single view ?>
	<footer class="entry-meta">
		<?php if ( 'wpfc_sermon' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php echo the_terms( $post->ID, 'wpfc_sermon_topics', '<span class="sermon_topics"><i class="icon-tags"></i> ', ', ', '</span>' ); ?>	
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><i class="icon-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'edwards' ), __( '1 Comment', 'edwards' ), __( '% Comments', 'edwards' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'edwards' ), '<span class="sep"> | </span><span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->