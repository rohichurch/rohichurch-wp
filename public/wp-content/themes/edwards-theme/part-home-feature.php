<?php $featured_count = intval(of_get_option('edwards_features_count')); ?>
<?php if($featured_count) : ?>
<div id="home-features" class="clearfix">			
<?php
	$args = array( 
		'post_type' => 'feature',
		'ignore_sticky_posts' => 1,  		
		'posts_per_page' => $featured_count
	);
	$home_feature_query = new WP_Query($args);	

	if($home_feature_query->have_posts()) : ?>
	<ul class="grid clearfix">
	<?php while ($home_feature_query->have_posts()) : $home_feature_query->the_post();
		$url = get_post_meta($post->ID, 'edwards_feature_linkurl', true);	?>			    
		<li <?php post_class('thirds'); ?>>	
			<?php if($url): ?><a href="<?php echo $url; ?>"><?php endif; ?><?php the_post_thumbnail("edwards_feature", array('class' => 'thumb', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?><?php if($url): ?></a><?php endif; ?>			
			<h2><?php if($url): ?><a href="<?php echo $url; ?>"><?php endif; ?><?php the_title(); ?><?php if($url): ?></a><?php endif; ?></h2>			
		</li>
	<?php endwhile; ?>
	</ul>
	<?php endif; ?>
	<?php wp_reset_query();	?>
	
</div>
<?php endif; ?>