<?php
$args = array( 
	'post_type' => 'slide',
	'posts_per_page' => 10
);
$slide_query = new WP_Query($args);	

if($slide_query->have_posts()) : ?>
       
	<script type="text/javascript">
		jQuery(document).ready(function($){
			jQuery('.flexslider').flexslider({
				   pauseOnHover:true,
				   slideshow: true,
				   useCSS: false
			});
		});
	</script>
	
<div id="home-slideshow">
	
<div class="flexslider">
	<ul class="slides">			
		<?php $i = 1; while($slide_query->have_posts()) : 
         $slide_query->the_post(); ?>
			<?php
			$sl_linkurl = get_post_meta($post->ID, 'edwards_sl_linkurl', true);
			$sl_displaytitle = get_post_meta($post->ID, 'edwards_sl_displaytitle', true);
			$sl_subtitle = get_post_meta($post->ID, 'edwards_sl_subtitle', true);
			$img_attr = array(
				'alt'	=> trim(strip_tags( $post->post_title )),
				'title'	=> trim(strip_tags( $attachment->post_title ))
			);
			?>
		
		<li id="slide<?php echo $i; ?>">		
			<?php if($sl_linkurl): ?><a href="<?php echo $sl_linkurl; ?>"><?php endif; ?>
					<?php echo get_the_post_thumbnail($post->ID, 'edwards_slide', $img_attr); ?>
			<?php if($sl_linkurl): ?></a><?php endif; ?>
			<?php if (!$sl_displaytitle )  : ?>
			<div class="wrapper">
				<div class="slide-content">
					<h2><?php if($sl_linkurl): ?><a href="<?php echo $sl_linkurl; ?>"><?php endif; ?><?php the_title(); ?><?php if($sl_linkurl): ?></a><?php endif; ?></h2>
					<div class="text"><?php echo $sl_subtitle; ?></div>
				</div>					
			</div>					
			<?php endif; ?>
		</li>
		
		<?php $i++; ?>			
		
		<?php endwhile; ?>
				
	</ul>
</div>
	
</div>

<?php endif; ?>
<?php wp_reset_query();?>