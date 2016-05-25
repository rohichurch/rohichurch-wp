<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Edwards
 * @since Edwards 1.0
 */

$prefix = 'wpfc_';
$meta_boxes = array(

    // POST TYPE POST
    array(
        'id' => 'post_meta1',
        'title' => __('Video Link', wpfc_theme_name()),
        'pages' => array('post', 'gallery'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(

            array(
                'name' => __('Video Link', wpfc_theme_name()),
                'desc' => '',
                'id' => $prefix . 'video_link',
                'type' => 'text',
                'std' => ''
            )

        )
    ),

    array(
        'id' => 'post_meta2',
        'title' => __('Slider Fields', wpfc_theme_name()),
        'pages' => array('post', 'gallery'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',    
        'fields' => array(

            array(
                'label' => 'Slider Images',
                'name' => 'Slider Images',
                'desc'  => 'Add images for the gallery slideshow',
                'id'    => $prefix.'repeatable_test',
                'type'  => 'imageupload'
            )

        )
    ),
    
    array(
        'id' => 'post_meta3',
        'title' => __('Audio Link', wpfc_theme_name()),
        'pages' => array('post'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(

            array(
                'name' => __('Audio Link', wpfc_theme_name()),
                'desc' => '',
                'id' => $prefix . 'audio_link',
                'type' => 'text',
                'std' => ''
            )

        )
    ),
    
    array(
        'id' => 'post_meta4',
        'title' => __('Quote Text', wpfc_theme_name()),
        'pages' => array('post'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(

            array(
                'name' => __('Quote Text', wpfc_theme_name()),
                'desc' => '',
                'id' => $prefix . 'quote',
                'type' => 'text',
                'std' => ''
            ),

            array(
                'name' => __('Quote Author', wpfc_theme_name()),
                'desc' => '',
                'id' => $prefix . 'quote_author',
                'type' => 'text',
                'std' => ''
            )

        )
    ),
    
    array(
        'id' => 'post_meta5',
        'title' => __('Link', wpfc_theme_name()),
        'pages' => array('post'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(

            array(
                'name' => __('Link Url', wpfc_theme_name()),
                'desc' => '',
                'id' => $prefix . 'link_url',
                'type' => 'text',
                'std' => ''
            )

        )
    ),
    
    array(
        'id' => 'post_meta11',
        'title' => __('Page Description', wpfc_theme_name()),
        'pages' => array('page'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
		
			array(
                'name' => __('Description', wpfc_theme_name()),
                'desc' => 'This text appears just below the post or page title.',
                'id' => $prefix . 'page_description',
                'type' => 'text',
                'std' => ''
            ),
			
        )
    ),



);




foreach ($meta_boxes as $meta_box) {
    $my_box = new wpfc_theme_meta_box($meta_box);
}


class wpfc_theme_meta_box {

    protected $_meta_box;

    // create meta box based on given data
    function __construct($meta_box) {
        $this->_meta_box = $meta_box;
        add_action('admin_menu', array(&$this, 'add'));

        add_action('save_post', array(&$this, 'save'));
    }

    /// Add meta box for multiple post types
    function add() {
        foreach ($this->_meta_box['pages'] as $page) {
            add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
        }
    }





    // Callback function to show fields in meta box
    function show() {
        global $post;

        // Use nonce for verification
        echo '<input type="hidden" name="wpfc_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

        echo '<table class="form-table">';

        foreach ($this->_meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<tr>',
                    '<th style="width:25%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                    '<td>';
            switch ($field['type']) {

                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
                        '<br />', $field['desc'];
                    break;

                case 'textarea':

                    wp_editor( $meta ? $meta : $field['std'], $field['id'], $settings = array('media_buttons' => false, 'textarea_rows' => '5'  ) );

                    break;

                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;

                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;
                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;

                case 'imageupload':
					?>
					<script type='text/javascript'>

							jQuery(document).ready(function($) {
									/*var _custom_media = true,
										_orig_send_attachment = wp.media.editor.send.attachment,
										 file_frame;
										
									jQuery('.wpfc_theme_upload_button').live('click', function( event ){
										var send_attachment_bkp = wp.media.editor.send.attachment;
										var button = $(this);
										var id = button.attr('id').replace('_button', '');
										_custom_media = true;
										event.preventDefault();
										
										// If the media frame already exists, reopen it.
										if ( file_frame ) {
											file_frame.open();
											return;
										}

										// Create the media frame.
										file_frame = wp.media.frames.file_frame = wp.media({
										title: 'Select a Gallery Slideshow Image',
										button: {
											text: 'Use This Image',
										},
										multiple: false // Set to true to allow multiple files to be selected
									});

									// When an image is selected, run a callback.
									file_frame.on( 'select', function() {

									// We set multiple to false so only get one image from the uploader
									attachment = file_frame.state().get('selection').first().toJSON();

										wp.media.editor.send.attachment = function(props, attachment){
											if ( _custom_media ) {
												jQuery("#"+id).val(attachment.url);
											} else {
												return _orig_send_attachment.apply( this, [props, attachment] );
											};
										}
										wp.media.editor.open(button);
											return false;
									});
									jQuery('.add_media').on('click', function(){
										_custom_media = false;
									});
									});
									file_frame.open();
									*/
									// Old stuff 
									// Uploading files
									var file_frame;							 

									jQuery('.wpfc_theme_upload_button').live('click', function( event ){
										event.preventDefault();
										
										// If the media frame already exists, reopen it.
										if ( file_frame ) {
											file_frame.open();
											return;
										}

										// Create the media frame.
										file_frame = wp.media.frames.file_frame = wp.media({
										title: jQuery( this ).data( 'uploader_title' ),
										button: {
											text: jQuery( this ).data( 'uploader_button_text' ),
										},
										multiple: false // Set to true to allow multiple files to be selected
									});

									// When an image is selected, run a callback.
									file_frame.on( 'select', function() {

									// We set multiple to false so only get one image from the uploader
									attachment = file_frame.state().get('selection').first().toJSON();

									// Do something with attachment.id and/or attachment.url here
									});							 

									// Finally, open the modal
									file_frame.open();

									});
							});
						</script>
						<?php 
						//old
						echo '<input type="text"  class="upload-url"  name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:90%" />
                        <input id="wpfc_theme_upload_button" class="wpfc_theme_upload_button button" type="button" name="upload_button" value="Upload" />
						<p class="wpfc_theme_metabox_description">' . $field['desc'] . '</p>';
                    break;


                // repeatable
                case 'repeatable':
                    echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
                    $i = 0;
                    if ($meta) {
                        foreach($meta as $row) {  if($i==0) {$display = 'style="display:none"';} else { $display='';} 
                            echo '<li><span class="sort hndle"><img  src="'.get_template_directory_uri().'/images/drag_arrow.png" /></span>
                                        <input type="text"  class="upload-url"  name="'.$field['id'].'['.$i.']" id="'.$field['id'].'"  id="'.$field['id'].'" value="'.$row.'" size="30" style="width:87%" />
                                        <input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload" />
                                        <a class="repeatable-remove button check'.$i.'" rel="'.$i.'" style="display:none;" href="#">-</a></li>';
                            $i++;
                        }
                    } else {                     
                        echo '<li><span class="sort hndle"><img  src="'.get_template_directory_uri().'/images/drag_arrow.png" /></span>
                                        <input type="text"  class="upload-url"  name="'.$field['id'].'['.$i.']" id="'.$field['id'].'"  id="'.$field['id'].'" size="30" style="width:87%" />
                                        <input id="st_upload_button" class="st_upload_button" type="button" name="upload_button" value="Upload" />
                                        <a class="repeatable-remove button check'.$i.'" rel="'.$i.'" style="display:none;" href="#">-</a></li>';
                    }
                    echo '</ul>
                        <span class="description">'.$field['desc'].'</span>';
                    echo '<a class="repeatable-add button" href="#">+</a> Click to add another meta box';
                break;



                case 'colorpicker':
                    echo '
                        <input id="' . $field['id'] . '" name="' . $field['id'] . '" type="text"  class="color" value="', $meta ? $meta : $field['std'], '" size="30"/>
                            <input type="button" value="Reset" style="margin-left:15px" name="button'.$field['id'].'" id="button_'.$field['id'].'"/>',
                        '<br />', $field['desc'];?>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#button_<?php echo $field['id']?>').live('click', function(){
                                    jQuery('#<?php echo $field['id']?>').val('<?php echo $field['std']?>');
                                })
                            })
                        </script>
                    <?php break;

                    case 'datepicker':
                    echo '
                        <input id="' . $field['id'] . '" name="' . $field['id'] . '" type="text"  class="admin-datepicker" value="', $meta ? $meta : $field['std'], '" size="30"/>',
                        '<br />', $field['desc']; ?>
                    <?php break;
                
            }
            echo     '<td>',
                '</tr>';
        }

        echo '</table>';
    }

    // Save data from meta box
    function save($post_id) {
        // verify nonce
        if (!wp_verify_nonce(@$_POST['wpfc_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($this->_meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            @$new = $_POST[$field['id']];

            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
}
?>