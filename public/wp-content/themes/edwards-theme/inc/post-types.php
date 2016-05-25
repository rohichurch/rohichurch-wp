<?php
/*
 * Add Slide Post Type
 */
 
// Register Post Type
add_action('init', 'edwards_slide_register');

function edwards_slide_register() {
	$labels = array(
		'name' => _x( 'Slides', 'edwards' ),
		'singular_name' => _x( 'Slide', 'edwards' ),
		'add_new' => _x( 'Add New', 'Slides', 'edwards' ),
		'add_new_item' => _x( 'Add New Slide', 'edwards' ),
		'edit_item' => _x( 'Edit Slide', 'edwards' ),
		'new_item' => _x( 'New Slide', 'edwards' ),
		'view_item' => _x( 'View Slide', 'edwards' ),
		'search_items' => _x( 'Search Slides', 'edwards' ),
		'not_found' =>  _x( 'No Slides found', 'edwards' ),
		'not_found_in_trash' => _x( 'No Slides found in Trash', 'edwards' ),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		'menu_position' => 10,
		'menu_icon' => get_template_directory_uri(). '/images/slides-icon-20x20.png',
		'supports' => array( 'title', 'thumbnail', 'revisions' )
	);

	register_post_type( 'slide' , $args );
	
	flush_rewrite_rules(false);
	
}
// End Register Post Type

// Submenu
add_action('admin_menu', 'edwards_slide_submenu');

function edwards_slide_submenu() {
	
	// Add to end of admin_menu action function
	global $submenu;
	$submenu['edit.php?post_type=slide'][5][0] = __('All Slides', 'edwards');
	$post_type_object = get_post_type_object('slide');
	$post_type_object->labels->name = __( 'Slides', 'edwards');

}
// End Submenu

// Create Slide Options Box
add_action("admin_init", "edwards_slide_admin_init");

function edwards_slide_admin_init(){
    add_meta_box("sl_meta", "Slide Options", "edwards_slide_meta_options", "slide", "normal", "core");
}

// Custom Field Keys
function edwards_slide_meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$sl_linkurl = $custom["edwards_sl_linkurl"][0];
	$sl_displaytitle = $custom["edwards_sl_displaytitle"][0];
	$sl_subtitle = $custom["edwards_sl_subtitle"][0];
	$sl_notes = $custom["edwards_sl_notes"][0];
// End Custom Field Keys

// Start HTML
?>
<style>
#slideAdmin h4 {
	font-size:18px;
	font-weight:normal;
    margin: .75em 0pt;
}
#slideAdmin input {
	font-size: 18px;
}
#slideAdmin hr {
	margin:25px 0px; 
	border: 1px solid #f0f0f0; 
	}
#slideAdmin span {
	padding-left: 3px;
	line-height: 18px!important;
	font-size: 0.95em;
	color:#a0a0a0;
}
</style>
<div id="slideAdmin">
	<h4><?php _e('Featured Image', 'edwards'); ?></h4>
		<a title="Set Featured Image" href="media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=480" id="set-post-thumbnail" class="thickbox button rbutton"><?php _e('Set Featured Image', 'edwards'); ?></a>
		<br /><br />
		<span><?php _e('To ensure the best image quality possible, please use a JPG image that is 1500 x 320 pixels', 'edwards'); ?></span>
	    
	<hr />
	
	<h4><?php _e('Hide Title?', 'edwards'); ?></h4>
		
		<fieldset>
			<legend class="screen-reader-text"><span>Check this box to hide the Title on your slide</span></legend>
			<label for="edwards_sl_displaytitle">
			

				<input name="edwards_sl_displaytitle" type="checkbox" id="edwards_sl_displaytitle" value="true" <?php if ($sl_displaytitle == true)  { ?>checked="checked"<?php } ?>
                                 /> Check this box to hide the title on your slide
								
			</label>
		</fieldset>
	    
	<hr />
	
	<h4><?php _e('Subtitle', 'edwards'); ?></h4>
		<input type="text" name="edwards_sl_subtitle" size="70" autocomplete="on" placeholder="brief descriptive text" value="<?php echo $sl_subtitle; ?>"><br />
		<span><?php _e('Thsi will display just below the Title on your slide', 'edwards'); ?></span>
		
	<hr />
	
	<h4><?php _e('Slide Link', 'edwards'); ?></h4>
		<input type="text" name="edwards_sl_linkurl" size="70" autocomplete="on" placeholder="http://www.domain.com/some-page-with-more-info/" value="<?php echo htmlspecialchars($sl_linkurl); ?>"><br />
		<span><?php _e('Where users are taken when the slide image is clicked', 'edwards'); ?></span>
		
	<hr />
	
	<h4><?php _e('Admin Notes', 'edwards'); ?></h4>
		<textarea type="text" name="edwards_sl_notes" cols="60" rows="8"><?php echo htmlspecialchars($sl_notes); ?></textarea><br /> 
		<span class="label_note"><?php _e('Not Published', 'edwards'); ?></span></label>
</div>
	
<?php
// End HTML
}

// Save Custom Field Values
add_action('save_post', 'save_edwards_slide_meta');

function save_edwards_slide_meta(){

	global $post_id;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	  return $post_id;
    }

    if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
	  return $post_id;
    }

    if( preg_match('/\edit\.php/', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
	  return $post_id;
    }
	if(isset($_POST['post_type']) && ($_POST['post_type'] == "slide")):
	
		$sl_displaytitle = $_POST['edwards_sl_displaytitle'];
		update_post_meta($post_id, 'edwards_sl_displaytitle', $sl_displaytitle);
		
		$sl_subtitle = $_POST['edwards_sl_subtitle'];
		update_post_meta($post_id, 'edwards_sl_subtitle', $sl_subtitle);
		
		$sl_linkurl = $_POST['edwards_sl_linkurl'];
		update_post_meta($post_id, 'edwards_sl_linkurl', $sl_linkurl);
		
		$sl_notes = $_POST['edwards_sl_notes'];
		update_post_meta($post_id, 'edwards_sl_notes', $sl_notes);
	
	endif;	
}
// End Custom Field Values
// End Slide Options Box

// Custom Columns
function edwards_slide_register_columns($columns){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'sl_image' => 'Featured Image'
		);
		return $columns;
}
add_filter('manage_edit-slide_columns', 'edwards_slide_register_columns');

function edwards_slide_display_columns($column){
		global $post;
		$custom = get_post_custom();
		switch ($column)
		{
			case 'sl_image':
				echo get_the_post_thumbnail($post->ID, array(70,70));
				break;
		}
}
add_action('manage_posts_custom_column', 'edwards_slide_display_columns');

// End Custom Columns

/*
 * Add Home Features
 */
 
// Register Post Type
add_action('init', 'edwards_feature_register');

function edwards_feature_register() {
	$labels = array(
		'name' => _x( 'Home Feature', 'edwards' ),
		'singular_name' => _x( 'Home Feature', 'edwards' ),
		'add_new' => _x( 'Add New', 'Slides', 'edwards' ),
		'add_new_item' => _x( 'Add New Home Feature', 'edwards' ),
		'edit_item' => _x( 'Edit Home Feature', 'edwards' ),
		'new_item' => _x( 'New Home Feature', 'edwards' ),
		'view_item' => _x( 'View Home Feature', 'edwards' ),
		'search_items' => _x( 'Search Home Features', 'edwards' ),
		'not_found' =>  _x( 'No Home Features found', 'edwards' ),
		'not_found_in_trash' => _x( 'No Home Features found in Trash', 'edwards' ),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		//'menu_icon' => get_template_directory_uri(). '/images/slides-icon-20x20.png',
		'supports' => array( 'title', 'thumbnail', 'revisions' )
	);

	register_post_type( 'feature' , $args );
	
	flush_rewrite_rules(false);
	
}
// End Register Post Type

// Create Slide Options Box
add_action("admin_init", "edwards_feature_admin_init");

function edwards_feature_admin_init(){
    add_meta_box("featire_meta", "Feature Options", "edwards_feature_meta_options", "feature", "normal", "core");
}

// Custom Field Keys
function edwards_feature_meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$feature_linkurl = $custom["edwards_feature_linkurl"][0];
// End Custom Field Keys

// Start HTML
?>
<style>
#slideAdmin h4 {
	font-size:18px;
	font-weight:normal;
    margin: .75em 0pt;
}
#slideAdmin input {
	font-size: 18px;
}
#slideAdmin hr {
	margin:25px 0px; 
	border: 1px solid #f0f0f0; 
	}
#slideAdmin span {
	padding-left: 3px;
	line-height: 18px!important;
	font-size: 0.95em;
	color:#a0a0a0;
}
</style>
<div id="slideAdmin">
	<h4><?php _e('Featured Image', 'edwards'); ?></h4>
		<a title="Set Featured Image" href="media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=485" id="set-post-thumbnail" class="thickbox button rbutton"><?php _e('Set Featured Image', 'edwards'); ?></a>
		<br /><br />
		<span><?php _e('To ensure the best image quality possible, please use a JPG image that is at least 400 x 300 pixels', 'edwards'); ?></span>
	    
	<hr />
	
	<h4><?php _e('Image Link', 'edwards'); ?></h4>
		<input type="text" name="edwards_feature_linkurl" size="70" autocomplete="on" placeholder="http://www.domain.com/some-page-with-more-info/" value="<?php echo htmlspecialchars($feature_linkurl); ?>"><br />
		<span><?php _e('Where users are taken when the image  or title is clicked', 'edwards'); ?></span>
		
</div>
	
<?php
// End HTML
}

// Save Custom Field Values
add_action('save_post', 'save_edwards_feature_meta');

function save_edwards_feature_meta(){

	global $post_id;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	  return $post_id;
    }

    if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
	  return $post_id;
    }

    if( preg_match('/\edit\.php/', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
	  return $post_id;
    }
	if(isset($_POST['post_type']) && ($_POST['post_type'] == "feature")):
	
		$feature_linkurl = $_POST['edwards_feature_linkurl'];
		update_post_meta($post_id, 'edwards_feature_linkurl', $feature_linkurl);
	
	endif;	
}
// End Custom Field Values
// End Slide Options Box

// Custom Columns
function edwards_feature_register_columns($columns){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'image' => 'Featured Image',
			'url' => 'Link'
		);
		return $columns;
}
add_filter('manage_edit-feature_columns', 'edwards_feature_register_columns');

function edwards_feature_display_columns($column){
		global $post;
		$custom = get_post_custom();
		switch ($column)
		{
			case 'image':
				echo get_the_post_thumbnail($post->ID, array(70,70));
				break;
			case 'url':
				echo get_post_meta($post->ID, 'edwards_feature_linkurl', true);
				break;

		}
}
add_action('manage_posts_custom_column', 'edwards_feature_display_columns');

// End Custom Columns

?>