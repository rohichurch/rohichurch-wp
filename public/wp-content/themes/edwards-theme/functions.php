<?php
/**
 * Edwards functions and definitions
 *
 * @package Edwards
 * @since Edwards 1.0
 */
 
/**
 * Set theme name to avoid unecessary duplication.
 *
 * @since Edwards 1.0
 */ 
function wpfc_theme_name(){
	return 'edwards';
}
define( 'wpfc_theme_name', 'edwards' );
update_option('wpfc_theme_name', wpfc_theme_name);

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Edwards 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 665; /* pixels */

if ( ! function_exists( 'edwards_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Edwards 1.0
 */
function edwards_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );
	
	/**
	 * Building meta boxes
	 */
	require(  get_template_directory() . '/inc/meta-boxes.php');

	/**
	 * Add new post types (slide, home feature)
	 */
	require(  get_template_directory() . '/inc/post-types.php');

	/**
	 * Add widget areas and custom widgets
	 */
	require(  get_template_directory() . '/inc/widgets.php');
	
	/**
	 * Add automatic theme updates
	 */
	require(  get_template_directory() . '/inc/updater.php');
	
	/* 
	 * Loads the Options Panel
	 *
	 * If you're loading from a child theme use stylesheet_directory
	 * instead of template_directory
	 */
	 
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options-framework/' );
		require_once dirname( __FILE__ ) . '/inc/options-framework/options-framework.php';
	}
	// Loads the options file for the theme customizer
	require_once dirname( __FILE__ ) . '/options.php';

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Edwards, use a find and replace
	 * to change 'edwards' to the name of your theme in all the template files
	 */
	load_theme_textdomain( wpfc_theme_name(), get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails; full width slider images should be 1920px by 500px
	 */
	add_theme_support( 'post-thumbnails' );
		add_image_size( 'content-width', 659, 345 , true );
		add_image_size( 'featured-content-width', 659, 0 , true );
		add_image_size( 'edwards_slide', 1600, 550 , true );
		add_image_size( 'edwards_feature', 400, 300 , true );
		add_image_size( 'edwards_mini', 100, 100, true );
		
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', wpfc_theme_name() ),
	) );

	/**
	 * Add support for the Aside Post Formats; will be enabled when WordPress 3.6 is released
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery' ) );
}
endif; // edwards_setup
add_action( 'after_setup_theme', 'edwards_setup' );

/**
 * Enqueue scripts and styles
 */
function edwards_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_register_style('jplayer', get_template_directory_uri().'/js/jplayer/skin/blue.monday/jplayer.blue.monday.css');
    wp_enqueue_style('jplayer');
	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script('jplayer', get_template_directory_uri().'/js/jplayer/js/jquery.jplayer.min.js' );
	wp_enqueue_script('edwards', get_template_directory_uri().'/js/edwards.js' );
	wp_enqueue_script('flexslider', get_template_directory_uri().'/js/flexslider/jquery.flexslider.js' );
	wp_register_style('flexslider', get_template_directory_uri().'/js/flexslider/flexslider.css');
    wp_enqueue_style('flexslider');
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/inc/font/font-awesome.css', false, '2.0', 'all' );
	wp_register_script('edwards_googlemap',  get_template_directory_uri() . '/js/googlemap.js', array('jquery'), '', true);
	wp_register_script('edwards_googlemap_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array('jquery'), '', true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'edwards_scripts' );


function edwards_admin_scripts($hook) {
		if ($hook == 'post.php' || $hook == 'post-new.php') {
			wp_register_script('adminscript', get_template_directory_uri() . '/js/adminscript.js', 'jquery');
			wp_enqueue_script('adminscript');
			wp_register_script('repeatable', get_template_directory_uri() . '/js/repeatable.js', 'thickbox');
			//wp_enqueue_script('repeatable');	
		}
}
add_action('admin_enqueue_scripts','edwards_admin_scripts',10,1);

/**
 * Add custom styles
 */
function edwards_theme_head() { ?>

<style type="text/css" media="screen">

<?php $heading_font = of_get_option('edwards_heading_font'); ?>
<?php $body_font = of_get_option('edwards_body_font'); ?>
<?php $home_message_font = of_get_option('edwards_home_message_font'); ?>
<?php if ($heading_font) : ?>
	h1, h2, h3, h4, h5, h6 { font-family: '<?php echo $heading_font; ?>', "Helvetica Neue", Helvetica, Arial, sans-serif; }
<?php endif; ?>

<?php if ($body_font) : ?>
	body, button, input, select, textarea { font-family: '<?php echo $body_font; ?>', Georgia, "Helvetica Neue", Helvetica, Arial, sans-serif; }
<?php endif; ?>

<?php if ($home_message_font) : ?>
	#home-message p { font-family: '<?php echo $home_message_font; ?>', Georgia, "Helvetica Neue", Helvetica, Arial, sans-serif; }
<?php endif; ?>

<?php $edwards_color_scheme = of_get_option('edwards_color_scheme'); ?>
<?php if($edwards_color_scheme) : ?>
	#masthead {background-color: <?php echo $edwards_color_scheme; ?>!important;}
	.pagination a:hover, .pagination .current {background: <?php echo $edwards_color_scheme; ?>!important;}
<?php endif; ?>

<?php if(of_get_option('edwards_color_link')) : ?>a, a:visited {color: <?php echo(of_get_option('edwards_color_link')); ?>;}<?php endif; ?>

<?php if(of_get_option('edwards_color_link_hover')) : ?>a:hover, a:focus {color: <?php echo(of_get_option('edwards_color_link_hover')); ?>;}<?php endif; ?>

<?php if ( is_archive() ): ?> html {height: 101%;} <?php endif; ?>
<?php echo(of_get_option('edwards_custom_css')); ?>
</style>

<?php echo "\n".of_get_option('edwards_analytics')."\n"; ?>

<?php }
add_action('wp_head','edwards_theme_head');

/**
 * Audio Player
 */
function edwards_jplayer($postid, $audio_link) {  ?>
	<script type="text/javascript">

		  jQuery(document).ready(function(){

			  if(jQuery().jPlayer) {
				  jQuery("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
					  ready: function () {
						  jQuery(this).jPlayer("setMedia", {

							  mp3: "<?php echo $audio_link; ?>",
							  end: ""
						  });
					  },
					  swfPath: "<?php echo get_template_directory_uri(); ?>/js/jplayer",
					  cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
					  supplied: "mp3, all",
					  swfPath: "<?php echo get_template_directory_uri()?>/js/jplayer/js"
				  });

			  }
		  });
	</script>
	<div class="blog-player">
		<div id="jquery_jplayer_<?php echo $postid;?>" class="jp-jplayer"></div>
		<div id="jp_container_<?php echo $postid;?>" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface" id="jp_interface_<?php echo $postid; ?>">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div><!--/jp-gui jp-interface-->
			</div><!--/jp-type-single-->
		</div><!--/jp-audio-->
	</div><!--/blog-player-->
<?php
}

/**
 * Video Player and Get Video Image
 */

function edwards_video_player($url) {

		if(!empty($url)){
		$key_str1='youtube';
		$key_str2='vimeo';

		$pos_youtube = strpos($url, $key_str1);
		$pos_vimeo = strpos($url, $key_str2);
			if (!empty($pos_youtube)) {
			$url = str_replace('watch?v=','',$url);
			$url = explode('&',$url);
			$url = $url[0];
			$url = str_replace('http://www.youtube.com/','',$url);
		?>
			<div class="holder">
                <iframe src="http://www.youtube.com/embed/<?php echo $url;?>?rel=0" frameborder="0" allowfullscreen></iframe>
			</div>
		<?php  }
		if (!empty($pos_vimeo)) {
			$url = explode('.com/',$url);
		?>

		<div class="holder">
            <iframe src="http://player.vimeo.com/video/<?php echo $url[1];?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<?php  }
		if (empty($pos_vimeo) && empty($pos_youtube)) {
		  echo "Video only allows Vimeo and YouTube!";
		}

   }
}
   
function edwards_get_video_image($url, $post_ID) {

	if(!empty($url)){
	$key_str1='youtube';
	$key_str2='vimeo';

	$pos_youtube = strpos($url, $key_str1);
	$pos_vimeo = strpos($url, $key_str2);
		if (!empty($pos_youtube)) {
			$url = str_replace('watch?v=','',$url);
			$url = explode('&',$url);
			$url = $url[0];
			$url = str_replace('http://www.youtube.com/','',$url);
				?><img src="http://img.youtube.com/vi/<?php echo $url;?>/0.jpg" title="<?php echo get_the_title($post_ID)?>" alt="<?php echo get_the_title($post_ID)?>" /><?php  
		}
		
		if (!empty($pos_vimeo)) {
			$url = explode('.com/',$url);
			$data = @file_get_contents("http://vimeo.com/api/v2/video/".$url[1].".json");
				if($data) {
					$data = file_get_contents("http://vimeo.com/api/v2/video/".$url[1].".json");
				} else {
					curl_setopt($ch=curl_init(), CURLOPT_URL, "http://vimeo.com/api/v2/video/".$url[1].".json");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$response = curl_exec($ch);
					curl_close($ch);
					$data = $response;
				}
					$data = json_decode($data); 
					?><img src="<?php echo $data[0]->thumbnail_medium;?>" title="<?php echo get_the_title($post_ID)?>" alt="<?php echo get_the_title($post_ID)?>" /><?php 
		}
		if (empty($pos_vimeo) && empty($pos_youtube)) {
			echo "Video only allows Vimeo and YouTube!";
		}
	}
}

/**
 * Gallery slideshow - retrieves all attached images and renders them in a slider
 */
function edwards_gallery_slideshow($postid) {
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
			'post_parent' => $postid
		) );

		if ( $attachments ) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					jQuery('.flexslider').flexslider({
						   pauseOnHover:true,
						   slideshow: true,
						   useCSS: false
					});
				});
			</script>
			<div class="blog-gallery">
				<div class="flexslider">
					<ul class="slides">
						<?php 
							foreach ( $attachments as $attachment ) {
								$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
								$slideimg = wp_get_attachment_link( $attachment->ID, 'content-width', true );
								echo '<li class="' . $class . ' data-design-thumbnail">' . $slideimg . '</li>';
							}
						?>
					</ul>
				</div><!--/flexslider-->
			</div><!--/blog-gallery-->	
		<?php
		}
}		

/**
 * Custom read more text
 */
function edwards_excerpt_more($more) {
       global $post;
	return '... <a href="'. get_permalink($post->ID) . '" class="read-more">' . _x( 'Read More &rsaquo;', 'edwards' ). '</a></p>';
}
add_filter('excerpt_more', 'edwards_excerpt_more');

/**
 * Edwards custom sermon media files
 */
// return meta
function edwards_get_meta( $args ) {
	global $post;
	$data = get_post_meta($post->ID, $args, 'true');
	if ($data != '')
		return $data;
	return null;
}

// display audio/video
function edwards_sermon_media() {
	//Enque scripts
	wp_enqueue_script('jquery-ui-tabs');
	global $post;?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery( '.media-tabs' ).tabs();
		});
	</script>
	
	<div class="media-tabs clearfix">
		<ul class="sermon-buttons control ui-tabs-nav clearfix">
			<?php 
			if ( edwards_get_meta('sermon_video') && edwards_get_meta('sermon_audio') ) {
				echo '<li class="watch"><a href="#watch"><i class="icon-film"></i><span> '.__('Watch', 'edwards' ).'</span></a></li>';
			}
			if ( edwards_get_meta('sermon_video') && edwards_get_meta('sermon_audio') )  {
				echo '<li class="listen"><a href="#listen"><i class="icon-volume-up"></i><span> '.__('Listen', 'edwards' ).'</span></a></li>';
			}
			?>
		</ul>
		<?php 
		if ( edwards_get_meta('sermon_video') ) {			
			echo '<div id="watch" class="tab-content holder clearfix">';
				echo do_shortcode( edwards_get_meta('sermon_video')); 
			echo '</div>';
		}
		if ( edwards_get_meta('sermon_audio') ) {
			echo '<div id="listen" class="tab-content clearfix">';
				edwards_jplayer( $post->ID, edwards_get_meta('sermon_audio') );
			echo '</div>';
		} ?>
	</div>
	<div class="sermon-footer-files clearfix">
		<ul class="sermon-buttons files">
			<?php
			if ( edwards_get_meta('sermon_notes') ) { 
				echo '<li class="notes"><a href="' . edwards_get_meta('sermon_notes') . '" class="sermon-button"><i class="icon-file-alt"></i><span> Download Notes</span></a></li>';
			} 
			if ( edwards_get_meta('sermon_audio') ) { 
				echo '<li class="download"><a href="' . edwards_get_meta('sermon_audio') . '" class="sermon-button"><i class="icon-download"></i><span> Download MP3</span></a></li>';
			}
			?>
		</ul>
	</div> <?php
}

/**
 * Custom buttons for sermon media (displayed on archive pages)
 */
function edwards_sermon_buttons() {
	global $post; ?>
<ul class="sermon-buttons">
	<?php
	if ( edwards_get_meta('sermon_video') ) { ?>
		<li class="watch"><a href="<?php the_permalink(); ?>#watch"><i class="icon-film"></i><span> Watch</span></a></li>
	<?php }
	if ( edwards_get_meta('sermon_audio') ) { ?>
		<li class="listen"><a href="<?php the_permalink(); ?>#listen" class="sermon-button"><i class="icon-volume-up"></i><span> Listen</span></a></li>
	<?php }
	if ( edwards_get_meta('sermon_notes') ) { 
		echo '<li class="notes"><a href="' . edwards_get_meta('sermon_notes') . '" class="sermon-button"><i class="icon-file-alt"></i><span> Notes</span></a></li>';
	}
	?>
</ul>
<?php
}

/**
 * Display series info on an individual sermon
 */
function edwards_footer_series() {
	global $post;
	$terms = get_the_terms( $post->ID , 'wpfc_sermon_series' );
	if($terms) {
		foreach( $terms as $term ) {
			if ($term->description) {
				echo '<div class="single_sermon_info_box series clearfix">';
				echo '<div class="sermon-footer-description clearfix">';
				echo '<h3 class="single-preacher-name"><a href="' .get_term_link($term->slug, 'wpfc_sermon_series') .'">'.$term->name.'</a></h3>';
				/* Image */
				print apply_filters( 'sermon-images-list-the-terms', '', array(
					'attr' => array(
						'class' => 'alignleft',
						),
					'image_size'   => 'thumbnail',
					'taxonomy'     => 'wpfc_sermon_series',
					'after' => '</div>',
					'after_image' => '', 
					'before' => '<div class="sermon-footer-image">', 
					'before_image' => ''
				) );
				/* Description */
				echo $term->description.'</div>';
				echo '</div>';
			}
		}
	}
}

/**
 * Display preacher info on an individual sermon
 */
function edwards_footer_preacher() {
	global $post;
	$terms = get_the_terms( $post->ID , 'wpfc_preacher' );
	if($terms) {
		foreach( $terms as $term ) {
			if ($term->description) {
				echo '<div class="single_sermon_info_box preacher clearfix">';
				echo '<div class="sermon-footer-description clearfix">';
				echo '<h3 class="single-preacher-name"><a href="' .get_term_link($term->slug, 'wpfc_preacher') .'">'.$term->name.'</a></h3>';
				/* Image */
				print apply_filters( 'sermon-images-list-the-terms', '', array(
					'attr' => array(
						'class' => 'alignleft',
						),
					'image_size'   => 'thumbnail',
					'taxonomy'     => 'wpfc_preacher',
					'after' => '</div>',
					'after_image' => '', 
					'before' => '<div class="sermon-footer-image">', 
					'before_image' => ''
				) );
				/* Description */
				echo $term->description.'</div>';
				echo '</div>';
			}
		}
	}
}

/**
 * Display info on any sermon taxonomy (for archive pages)
 */
function edwards_display_sermon_tax( $atts = array () ) {
	extract( shortcode_atts( array(
		'tax' => 'wpfc_sermon_series', // options: wpfc_sermon_series, wpfc_preacher, wpfc_sermon_topics, wpfc_service_type, wpfc_bible_book
		'order' => 'ASC', // options: DESC
		'orderby' => 'name', // options: id, count, name, slug, term_group, none
		'size' => 'thumbnail' // options: any size registered with add_image_size
	), $atts ) );
		
		$terms = apply_filters( 'sermon-images-get-terms', '', array('taxonomy' => $tax, 'order' => $order, 'orderby' => 'name', 'having_images' => false ) );
		$count = count($terms);
		if ( ! empty( $terms ) ) { 
			$list = '<div id="sermon_tax_list">'; foreach( (array) $terms as $term ) { 
				$list .= '<div class="individual-tax-loop clearfix">';
				$list .= '<h3 class="individual-tax-title"><a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '">' . $term->name . '</a></h3>';
				$list .= '<a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '">' . wp_get_attachment_image( $term->image_id, $size ) . '</a>';
				$list .= $term->description.'</div>';
			} 
			$list .= '</div>'; 
		}
	return $list;
}

/*
 * Google Map for Contact Page Template
 */
function edwards_contact_map() {

	$edwards_street = of_get_option( 'edwards_street' );
	$edwards_address = of_get_option( 'edwards_address' );
	$address_url = preg_replace( '![^a-z0-9]+!i', '+', $edwards_street. ' ' .$edwards_address );
	$title = esc_attr( get_bloginfo( 'name', 'display' ) );

	// load scripts
	wp_enqueue_script('edwards_googlemap');
	wp_enqueue_script('edwards_googlemap_api');
	
	
	$output = '<div id="map_canvas_'.rand(1, 100).'" class="edwards-googlemap clearfix" style="height:340px;width:100%">';
		$output .= '<input class="title" type="hidden" value="'.$title.'" />';
		$output .= '<input class="location" type="hidden" value="'.$address_url.'" />';
		$output .= '<input class="zoom" type="hidden" value="13" />';
		$output .= '<div class="map_canvas"></div>';
	$output .= '</div>';
	
	echo $output;
}
/*
 * Use shortcodes in widget areas
 */
add_filter('widget_text', 'do_shortcode');
?>