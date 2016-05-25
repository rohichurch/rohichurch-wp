<?php
/**
 * @package Edwards
 * @since Edwards 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
		<div id="archive_sermon_image">
			<?php render_sermon_image('edwards_mini'); ?>
		</div>
		<h1 class="sermon-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				<span class="sermon-date-meta"><?php wpfc_sermon_date('m/d/y', '', ''); echo the_terms( $post->ID, 'wpfc_service_type',  ' (', ' ', ')'); ?><span>
		</h1>

		<div class="sermon-summary">
		<?php
		edwards_sermon_buttons();
		wpfc_sermon_meta('bible_passage', '<span class="bible_passage">Bible Text: ', '</span> | ');
		echo the_terms( $post->ID, 'wpfc_preacher',  '<span class="preacher_name">Speaker: ', ' ', '</span>');
		echo the_terms( $post->ID, 'wpfc_sermon_series', '<span class="sermon_series">Series: ', ' ', '</span>' ); 
		?>
		</div>

</article><!-- #post-<?php the_ID(); ?> -->