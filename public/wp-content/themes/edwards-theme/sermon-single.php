<?php
/**
 * @package Edwards
 * @since Edwards 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="wpfc_sermon_meta">
			<p>	
				<?php 
					wpfc_sermon_date(get_option('date_format'), '<span class="edwards_sermon_date">', '</span> '); echo the_terms( $post->ID, 'wpfc_service_type',  ' <span class="edwards_service_type">(', ' ', ')</span>');
			?></p><p><?php

					wpfc_sermon_meta('bible_passage', '<span class="bible_passage">Bible Text: ', '</span> | ');
					echo the_terms( $post->ID, 'wpfc_preacher',  '<span class="preacher_name">', ' ', '</span>');
					echo the_terms( $post->ID, 'wpfc_sermon_series', '<p><span class="sermon_series">Series: ', ' ', '</span></p>' ); 
				?>
			</p>
		</div>
		
		<?php edwards_sermon_media(); ?>
		<?php wpfc_sermon_description(); ?>
		<?php edwards_footer_series(); ?>
		<?php edwards_footer_preacher(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php echo the_terms( $post->ID, 'wpfc_sermon_topics', '<span class="sermon_topics"><i class="icon-tags"></i> ', ', ', '</span><span class="sep"> | </span>' ); ?>	
		<?php echo the_terms( $post->ID, 'wpfc_bible_book', '<span class="sermon_bible_book"><i class="icon-book"></i> ', ', ', '</span><span class="sep"> | </span>' ); ?>	
		
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><i class="icon-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'edwards' ), __( '1 Comment', 'edwards' ), __( '% Comments', 'edwards' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'edwards' ), '<span class="sep"> | </span><span class="edit-link"><i class="icon-edit"></i> ', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->