<?php

// Register Post Type
add_action( 'init', 'register_cpt_wpfc_event' );

function register_cpt_wpfc_event() {

    $labels = array( 
        'name' => _x( 'Events', 'churchpack' ),
        'singular_name' => _x( 'Event', 'churchpack' ),
        'add_new' => _x( 'Add New', 'churchpack' ),
        'add_new_item' => _x( 'Add New Event', 'churchpack' ),
        'edit_item' => _x( 'Edit Event', 'churchpack' ),
        'new_item' => _x( 'New Event', 'churchpack' ),
        'view_item' => _x( 'View Event', 'churchpack' ),
        'search_items' => _x( 'Search Events', 'churchpack' ),
        'not_found' => _x( 'No events found', 'churchpack' ),
        'not_found_in_trash' => _x( 'No events found in Trash', 'churchpack' ),
        'parent_item_colon' => _x( 'Parent Event:', 'churchpack' ),
        'menu_name' => _x( 'Events', 'churchpack' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Add events in different categories to your site',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'wpfc_event_category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        'menu_icon' => plugins_url('/img/calendar.png', __FILE__),
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array('slug' => 'event'),
        'capability_type' => 'post'
    );

    register_post_type( 'wpfc_event', $args );
}

// End Register Post Type

// Register taxonomy
// add_action( 'init', 'register_taxonomy_wpfc_event_category' );

function register_taxonomy_wpfc_event_category() {

    $labels = array( 
        'name' => _x( 'Event Categories', 'churchpack' ),
        'singular_name' => _x( 'Event Category', 'churchpack' ),
        'search_items' => _x( 'Search Event Categories', 'churchpack' ),
        'popular_items' => _x( 'Popular Event Categories', 'churchpack' ),
        'all_items' => _x( 'All Event Categories', 'churchpack' ),
        'parent_item' => _x( 'Parent Event Category', 'churchpack' ),
        'parent_item_colon' => _x( 'Parent Event Category:', 'churchpack' ),
        'edit_item' => _x( 'Edit Event Category', 'churchpack' ),
        'update_item' => _x( 'Update Event Category', 'churchpack' ),
        'add_new_item' => _x( 'Add New Event Category', 'churchpack' ),
        'new_item_name' => _x( 'New Event Category Name', 'churchpack' ),
        'separate_items_with_commas' => _x( 'Separate event categories with commas', 'churchpack' ),
        'add_or_remove_items' => _x( 'Add or remove event categories', 'churchpack' ),
        'choose_from_most_used' => _x( 'Choose from the most used event categories', 'churchpack' ),
        'menu_name' => _x( 'Event Categories', 'churchpack' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'wpfc_event_category', array('wpfc_event'), $args );
}
// End Register taxonomy

// Shortcode to embed the Monthly Calendar
add_shortcode('events', 'wpfc_display_events_shortcode');
function wpfc_display_events_shortcode($atts) {
	ob_start(); ?>
<div id="church-pack" class="calselect">
	<div class="calHead">
		<h2 class="event-month"><?php echo wpfc_monthname('',''); ?></h2>	
		<div class="monthNav">
			<?php echo wpfc_prevlink('' , ''); ?>
			<span>|</span> 
			<?php echo wpfc_nextlink('' , ''); ?>
		</div>					
	</div>	
	<div class="calentries"><?php echo wpfc_get_the_calendar(date('n'),date('Y')); ?></div>
</div>
	<?php
	$buffer = ob_get_clean();
	return $buffer;
}
// End Shortcode

// Change Messages
add_filter('post_updated_messages', 'wpfc_event_updated_messages');
function wpfc_event_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['wpfc_event'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Event updated. <a href="%s">View event</a>', 'churchpack'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'churchpack'),
    3 => __('Custom field deleted.', 'churchpack'),
    4 => __('Event updated.', 'churchpack'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s', 'churchpack'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event published. <a href="%s">View event</a>', 'churchpack'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>', 'churchpack'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'churchpack'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'churchpack' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>', 'churchpack'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
// End Change Messages

// Meta Box
add_filter( 'cpmb_meta_boxes', 'wpfc_event_metaboxes' );

// Define the metabox and field configurations.
function wpfc_event_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_wpfc_';

	$meta_boxes[] = array(
		'id'         => 'event_metabox',
		'title'      => __('Event Details', 'churchpack'),
		'pages'      => array( 'wpfc_event', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Instructions', 'churchpack'),
				'desc' => __('In the right column you can upload a featured image. Make sure this image is at least 300px wide. Then fill out the information below.', 'churchpack'),
				'type' => 'title',
			),
			array(
				'name' => __('Location', 'churchpack'),
				'desc' => __('Enter the location of the event', 'churchpack'),
				'id'   => $prefix . 'thelocation',
				'type' => 'text',
			),
			array(
				'name' => __('Address', 'churchpack'),
				'desc' => __('Enter an address to automatically display a map from Google (e.g., 564 E. Juniper, Hot Springs, Arkansas 12345)', 'churchpack'),
				'id'   => $prefix . 'eventaddress',
				'type' => 'text',
			),
			array(
				'name' => __('Start Date', 'churchpack'),
				'desc' => __('Enter the date the event will start', 'churchpack'),
				'id'   => $prefix . 'datestartentry',
				'type' => 'text_date',
			),
			array(
				'name' => __('End Date', 'churchpack'),
				'desc' => __('Enter the date that the event will end. (leave open if it is a single function or does not have an end)', 'churchpack'),
				'id'   => $prefix . 'dateendentry',
				'type' => 'text_date',
			),
			array(
	            'name' => __('Starting Time', 'churchpack'),
	            'desc' => __('Enter the starting time of the event. Leave blank for an all day event.', 'churchpack'),
	            'id'   => $prefix . 'timestartentry',
	            'type' => 'select',
				'options' => array(
					array( 'name' => __('select a time', 'churchpack'), 'value' => '', ),
					array( 'name' => '06:00am', 'value' => '06:00am', ),
					array( 'name' => '06:15am', 'value' => '06:15am', ),
					array( 'name' => '06:30am', 'value' => '06:30am', ),
					array( 'name' => '06:45am', 'value' => '06:45am', ),
					array( 'name' => '07:00am', 'value' => '07:00am', ),
					array( 'name' => '07:15am', 'value' => '07:15am', ),
					array( 'name' => '07:30am', 'value' => '07:30am', ),
					array( 'name' => '07:45am', 'value' => '07:45am', ),
					array( 'name' => '08:00am', 'value' => '08:00am', ),
					array( 'name' => '08:15am', 'value' => '08:15am', ),
					array( 'name' => '08:30am', 'value' => '08:30am', ),
					array( 'name' => '08:45am', 'value' => '08:45am', ),
					array( 'name' => '09:00am', 'value' => '09:00am', ),
					array( 'name' => '09:15am', 'value' => '09:15am', ),
					array( 'name' => '09:30am', 'value' => '09:30am', ),
					array( 'name' => '09:45am', 'value' => '09:45am', ),
					array( 'name' => '10:00am', 'value' => '10:00am', ),
					array( 'name' => '10:15am', 'value' => '10:15am', ),
					array( 'name' => '10:30am', 'value' => '10:30am', ),
					array( 'name' => '10:45am', 'value' => '10:45am', ),
					array( 'name' => '11:00am', 'value' => '11:00am', ),
					array( 'name' => '11:15am', 'value' => '11:15am', ),
					array( 'name' => '11:30am', 'value' => '11:30am', ),
					array( 'name' => '11:45am', 'value' => '11:45am', ),
					array( 'name' => '12:00pm', 'value' => '12:00pm', ),
					array( 'name' => '12:15pm', 'value' => '12:15pm', ),
					array( 'name' => '12:30pm', 'value' => '12:30pm', ),
					array( 'name' => '12:45pm', 'value' => '12:45pm', ),
					array( 'name' => '01:00pm', 'value' => '01:00pm', ),
					array( 'name' => '01:15pm', 'value' => '01:15pm', ),
					array( 'name' => '01:30pm', 'value' => '01:30pm', ),
					array( 'name' => '01:45pm', 'value' => '01:45pm', ),
					array( 'name' => '01:00pm', 'value' => '01:00pm', ),
					array( 'name' => '01:15pm', 'value' => '01:15pm', ),
					array( 'name' => '01:30pm', 'value' => '01:30pm', ),
					array( 'name' => '01:45pm', 'value' => '01:45pm', ),
					array( 'name' => '02:00pm', 'value' => '02:00pm', ),
					array( 'name' => '02:15pm', 'value' => '02:15pm', ),
					array( 'name' => '02:30pm', 'value' => '02:30pm', ),
					array( 'name' => '02:45pm', 'value' => '02:45pm', ),
					array( 'name' => '03:00pm', 'value' => '03:00pm', ),
					array( 'name' => '03:15pm', 'value' => '03:15pm', ),
					array( 'name' => '03:30pm', 'value' => '03:30pm', ),
					array( 'name' => '03:45pm', 'value' => '03:45pm', ),
					array( 'name' => '04:00pm', 'value' => '04:00pm', ),
					array( 'name' => '04:15pm', 'value' => '04:15pm', ),
					array( 'name' => '04:30pm', 'value' => '04:30pm', ),
					array( 'name' => '04:45pm', 'value' => '04:45pm', ),
					array( 'name' => '05:00pm', 'value' => '05:00pm', ),
					array( 'name' => '05:15pm', 'value' => '05:15pm', ),
					array( 'name' => '05:30pm', 'value' => '05:30pm', ),
					array( 'name' => '05:45pm', 'value' => '05:45pm', ),
					array( 'name' => '06:00pm', 'value' => '06:00pm', ),
					array( 'name' => '06:15pm', 'value' => '06:15pm', ),
					array( 'name' => '06:30pm', 'value' => '06:30pm', ),
					array( 'name' => '06:45pm', 'value' => '06:45pm', ),
					array( 'name' => '07:00pm', 'value' => '07:00pm', ),
					array( 'name' => '07:15pm', 'value' => '07:15pm', ),
					array( 'name' => '07:30pm', 'value' => '07:30pm', ),
					array( 'name' => '07:45pm', 'value' => '07:45pm', ),
					array( 'name' => '08:00pm', 'value' => '08:00pm', ),
					array( 'name' => '08:15pm', 'value' => '08:15pm', ),
					array( 'name' => '08:30pm', 'value' => '08:30pm', ),
					array( 'name' => '08:45pm', 'value' => '08:45pm', ),
					array( 'name' => '09:00pm', 'value' => '09:00pm', ),
					array( 'name' => '09:15pm', 'value' => '09:15pm', ),
					array( 'name' => '09:30pm', 'value' => '09:30pm', ),
					array( 'name' => '09:45pm', 'value' => '09:45pm', ),
					array( 'name' => '10:00pm', 'value' => '10:00pm', ),
					array( 'name' => '10:15pm', 'value' => '10:15pm', ),
					array( 'name' => '10:30pm', 'value' => '10:30pm', ),
					array( 'name' => '10:45pm', 'value' => '10:45pm', ),
				),
	        ),
			array(
				'name'    => __('Recurring Event?', 'churchpack'),
				'desc'    => __('Select here if it is a simple recurring event.', 'churchpack'),
				'id'      => $prefix . 'recurring',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Never', 'churchpack'), 'value' => 'Never', ),
					array( 'name' => __('Every week same day', 'churchpack'), 'value' => 'Every week same day', ),
					array( 'name' => __('Every month same date', 'churchpack'), 'value' => 'Every month same date', ),
				),
			),
			array(
				'name'    => __('Advanced Recurring Interval', 'churchpack'),
				'desc'    => __('Additional advanced recurring events. Remember to set the simple recurring intervals to never when using this one.', 'churchpack'),
				'id'      => $prefix . 'recint',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'select interval', 'value' => 'select interval', ),
					array( 'name' => __('First', 'churchpack'), 'value' => 'First', ),
					array( 'name' => __('Second', 'churchpack'), 'value' => 'Second', ),
					array( 'name' => __('Third', 'churchpack'), 'value' => 'Third', ),
					array( 'name' => __('Fourth', 'churchpack'), 'value' => 'Fourth', ),
					array( 'name' => __('Last', 'churchpack'), 'value' => 'Last', ),
				),
			),
			array(
				'name'    => __('Advanced Recurring Weekday', 'churchpack'),
				'desc'    => __('Weekday to set with the above intervals.', 'churchpack'),
				'id'      => $prefix . 'recday',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('select day', 'churchpack'), 'value' => 'select day', ),
					array( 'name' => __('Monday', 'churchpack'), 'value' => 'Monday', ),
					array( 'name' => __('Tuesday', 'churchpack'), 'value' => 'Tuesday', ),
					array( 'name' => __('Wednesday', 'churchpack'), 'value' => 'Wednesday', ),
					array( 'name' => __('Thursday', 'churchpack'), 'value' => 'Thursday', ),
					array( 'name' => __('Friday', 'churchpack'), 'value' => 'Friday', ),
					array( 'name' => __('Saturday', 'churchpack'), 'value' => 'Saturday', ),
					array( 'name' => __('Sunday', 'churchpack'), 'value' => 'Sunday', ),
				),
			),
			array(
				'name' => __('Registration Link', 'churchpack'),
				'desc' => __('Enter a url to register for the event', 'churchpack'),
				'id'   => $prefix . 'registration',
				'type' => 'text',
			),
			
		),
	);

	return $meta_boxes;
}

add_action( 'init', 'initialize_wpfc_event_meta_boxes', 9999 );

// Initialize the metabox class.
function initialize_wpfc_event_meta_boxes() {

	if ( ! class_exists( 'cpmb_Meta_Box' ) )
		require_once 'init.php';

}
// End Meta Box

// Advanced Functions
function wpfc_prevlink($month,$year) {
	global $post;
	if ($month) {
		$month = $month - 1; 
	} else {
		$month = date('n')-1;
		$year = date('Y');
	}
	if ($month <= 0) { $month = 12; $year = $year - 1; }
	return '<a href="#" rel="' . $month . '/' . $year . '" class="wpfc_prevlink">' . __('PREV', 'church-pack') . '</a>';
}

function wpfc_nextlink($month,$year) {
	global $post;
	if ($month) {
		$month = $month + 1;
	} else {
		$month = date('n')+1;
		$year = date('Y');
	}
	if ($month >= 13) {$month = 1;$year = $year + 1;}
	return '<a href="#" rel="' . $month . '/' . $year . '" class="wpfc_nextlink">' . __('NEXT', 'church-pack') . '</a>';
}

function wpfc_monthname($month,$year) {
	global $post, $wp_locale;
	if ($month) {
		$output = date_i18n( 'F Y' , mktime(0, 0, 0, $month, 1, $year), false );
	} else {
		$output = date_i18n( 'F Y' , time(), false );
	}
	return $output;
}


function wpfc_dateDff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}


function wpfc_get_first_day($day_number, $month=false, $year=false)
  {
    $month  = ($month === false) ? strftime("%m"): $month;
    $year   = ($year === false) ? strftime("%Y"): $year;
	if ($day_number == 'Sunday') {$day_number = 0; 
  	} elseif($day_number == 'Monday') {$day_number = 1;
  	} elseif($day_number == 'Tuesday') {$day_number = 2;
  	} elseif ($day_number == 'Wednesday') {$day_number = 3;
  	} elseif ($day_number == 'Thursday') {$day_number = 4;
	} elseif ($day_number == 'Friday') {$day_number = 5;
	} elseif ($day_number == 'Saturday') {$day_number = 6; } 
    $first_day = 1 + ((7+$day_number - strftime("%w", mktime(0,0,0,$month, 1, $year)))%7);
    return mktime(0,0,0,$month, $first_day, $year);
}




function wpfc_calendar_add($cstrdate,$cctitle,$cclink,$cccontent,$cclocation,$ccids) {
	global $calentries;
	$calentries[] = array
			(					
				'strdate' => $cstrdate,
				'ctitle' => $cctitle,
				'clink' => $cclink,
				'ccontent' => $cccontent,
				'clocation' => $cclocation,
				'cids' => $ccids,
		);	
}

function wpfc_monthconvert($monthname) {
	$monthnames = '';
	if ($monthname == '1') {$monthnames = 'Jan';}
	if ($monthname == '2') {$monthnames = 'Feb';}
	if ($monthname == '3') {$monthnames = 'Mar';}
	if ($monthname == '4') {$monthnames = 'Apr';}
	if ($monthname == '5') {$monthnames = 'May';}
	if ($monthname == '6') {$monthnames = 'Jun';}
	if ($monthname == '7') {$monthnames = 'Jul';}
	if ($monthname == '8') {$monthnames = 'Aug';}
	if ($monthname == '9') {$monthnames = 'Sept';} 
	if ($monthname == '01') {$monthnames = 'Jan';}
	if ($monthname == '02') {$monthnames = 'Feb';}
	if ($monthname == '03') {$monthnames = 'Mar';}
	if ($monthname == '04') {$monthnames = 'Apr';}
	if ($monthname == '05') {$monthnames = 'May';}
	if ($monthname == '06') {$monthnames = 'Jun';}
	if ($monthname == '07') {$monthnames = 'Jul';}
	if ($monthname == '08') {$monthnames = 'Aug';}
	if ($monthname == '09') {$monthnames = 'Sept';} 
	if ($monthname == '10') {$monthnames = 'Oct';} 
	if ($monthname == '11') {$monthnames = 'Nov';} 
	if ($monthname == '12') {$monthnames = 'Dec';}
	if ($monthname == 1) {$monthnames = 'Jan';}
	if ($monthname == 2) {$monthnames = 'Feb';}
	if ($monthname == 3) {$monthnames = 'Mar';}
	if ($monthname == 4) {$monthnames = 'Apr';}
	if ($monthname == 5) {$monthnames = 'May';}
	if ($monthname == 6) {$monthnames = 'Jun';}
	if ($monthname == 7) {$monthnames = 'Jul';}
	if ($monthname == 8) {$monthnames = 'Aug';}
	if ($monthname == 9) {$monthnames = 'Sept';} 
	if ($monthname == 01) {$monthnames = 'Jan';}
	if ($monthname == 02) {$monthnames = 'Feb';}
	if ($monthname == 03) {$monthnames = 'Mar';}
	if ($monthname == 04) {$monthnames = 'Apr';}
	if ($monthname == 05) {$monthnames = 'May';}
	if ($monthname == 06) {$monthnames = 'Jun';}
	if ($monthname == 07) {$monthnames = 'Jul';}
	if ($monthname == 08) {$monthnames = 'Aug';}
	if ($monthname == 09) {$monthnames = 'Sept';} 
	if ($monthname == 10) {$monthnames = 'Oct';} 
	if ($monthname == 11) {$monthnames = 'Nov';} 
	if ($monthname == 12) {$monthnames = 'Dec';}
	return $monthnames;   
}

function wpfc_make_epoch($day, $month , $year , $time , $gmt) {
	$thismonth = wpfc_monthconvert($month);	
	$thisconvert = $day . ' ' . $thismonth . ' ' . $year . ' ' . $time . ' ' . $gmt;
	$thisdatereturn = strtotime($thisconvert);
	return $thisdatereturn;	
}

function wpfc_recinthappening ($intervalvalue, $dayvalue, $month, $year, $time, $daysinmonth){
	
	if (!$time){$time = '23:59:59';}	
	$first_day_tocalculate = wpfc_get_first_day($dayvalue, $month, $year);
		
	$specrec = wpfc_make_epoch(date('j', $first_day_tocalculate), date('m', $first_day_tocalculate), date('Y', $first_day_tocalculate), $time,'GMT');
		
	if ($intervalvalue == 'Second') {$specrec = $specrec + 604800;}
	if ($intervalvalue == 'Third') {$specrec = $specrec + 1209600;}		
	if ($intervalvalue == 'Fourth') {$specrec = $specrec + 1814400;}	
	if ($intervalvalue == 'Last') {	
		$lastmonthday = wpfc_make_epoch($daysinmonth, $month,  $year, '23:59:59' ,'GMT');
	
		if ($specrec + 2419200 <= $lastmonthday) {
			$specrec = $specrec + 2419200;
		} else {
			$specrec = $specrec + 1814400;
		}	
	}
	return $specrec;	
}


function days_in_month($month, $year) { 
	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
} 


function wpfc_get_the_events($month,$year) {
	global $calentries;
	$output = '';
	unset($calentries);
	$datediff = 0;
	$calentries = array();
	$args=array(
		'post_type'=>'wpfc_event',
		'showposts'=> 10000,
	);
	
	$my_query = new WP_Query($args);
	if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
	$postid = get_the_ID();
	$key_date_value = '';
	$key_end_value = '';
	$key_time_value = ' ';
	$key_place_value = ' ';
	$key_recurring_value = '';
	$key_recint_value = '';
	$key_recday_value = '';
	$occurance = '';
	$key_recint_value = get_post_meta($postid, '_wpfc_recint', true);
	$key_recday_value = get_post_meta($postid, '_wpfc_recday', true);
	$key_date_value = get_post_meta($postid, '_wpfc_datestartentry', true);
	$key_recurring_value = get_post_meta($postid, '_wpfc_recurring', true);
	$key_end_value = get_post_meta($postid, '_wpfc_dateendentry', true);
	$key_time_value = get_post_meta($postid, '_wpfc_timestartentry', true);
	$key_place_value = get_post_meta($postid, '_wpfc_thelocation', true);
	$key_registration_value = get_post_meta($postid, '_wpfc_registration', true);
	
	// create a valid date from data
	$dateholder = explode('/',$key_date_value);
	$endholder =  explode('/',$key_end_value);	
	
	$startepoch = '';
	// get epoch for start date	
	if ($key_time_value) {
		$startepoch = strtotime($dateholder[0] .  ' ' .  wpfc_monthconvert($dateholder[1]) . ' ' .  $dateholder[2] .  ' ' . $key_time_value . ' GMT');
		}  else {
		$startepoch = strtotime($dateholder[0] .  ' ' .  wpfc_monthconvert($dateholder[1]) . ' ' .  $dateholder[2] .  ' 00:00:01 GMT');
	}
		
	$endepoch = '';	
	if ($key_end_value && $key_time_value ) {
		$endepoch = strtotime($endholder[0] .  ' ' .  wpfc_monthconvert($endholder[1]) . ' ' .  $endholder[2] .  ' ' . $key_time_value . ' GMT');
	} elseif ($key_end_value && !$key_time_value ) {	
		$endepoch = strtotime($endholder[0] .  ' ' .  wpfc_monthconvert($endholder[1]) . ' ' .  $endholder[2] .  ' 00:00:01 GMT');
	}
	
	// get epoch for first day in month
	if ($key_time_value ) {
	$beginningepoch = wpfc_make_epoch('1', $month, $year, $key_time_value ,'GMT');
	} else {
	$beginningepoch = wpfc_make_epoch('1', $month, $year, '00:00:01','GMT');
	}
	
	
	$daysinmonth = days_in_month($month, $year);
	
	// get epoch for last day in month
	$closingepoch = wpfc_make_epoch($daysinmonth, $month, $year, '23:59:59','GMT');
	
	
	// special reccuring
	if ($key_recint_value != 'select interval' && $key_recday_value != 'select day') {	
		$firstone = wpfc_recinthappening($key_recint_value, $key_recday_value, $month, $year, $key_time_value, $daysinmonth);
		$occurance = 1;
	
		if ($startepoch > $firstone ) {
			$occurance = 0;			
		} else {		
			if ($endepoch && ($endepoch < $firstone)) {
				$occurance = 0;
			}		
		} 

	// basic reccuring
	} elseif ($key_recurring_value != 'Never') {
	
		if ($key_recurring_value == 'Every month same date') {
			$occurance = 1;
			if ($key_time_value) {
				$firstone = wpfc_make_epoch(date('j', $startepoch), $month, $year, $key_time_value,'GMT');
			} else {
				$firstone = wpfc_make_epoch(date('j', $startepoch), $month, $year, '11.59 pm','GMT');
			}
			
			if ($startepoch > $firstone) {
				$occurance = 0;			
			} else {		
				if ($endepoch && ($endepoch < $firstone)) {
					$occurance = 0;
				}		
			} 
		}
		
		if ($key_recurring_value == 'Every week same day') {
			$occurance = 2;
			$interval = 604800;
			unset($datelist);
			$datelist = array();
			$the_dayname = date('l', $startepoch);
			// epoch for first occurence in month
			$first_occurence_in_month = wpfc_get_first_day($the_dayname, $month, $year);
			
			if ($key_time_value) {
				$firstone = wpfc_make_epoch(date('j', $first_occurence_in_month), date('m', $first_occurence_in_month), date('Y', $first_occurence_in_month), $key_time_value,' GMT');
			} else {
				$firstone = wpfc_make_epoch(date('j', $first_occurence_in_month), date('m', $first_occurence_in_month), date('Y', $first_occurence_in_month), '11.59 pm',' GMT');
			}
			
			for($i = $firstone; $i < $closingepoch; $i = $i + $interval) {	
				if ($startepoch > $i ) {
					//do nothing
				} else {
					if (!$endepoch) {
						$datelist[] = $i;
					} else {
						if ($endepoch > $i) {
							$datelist[] = $i;
						}
					}
				}
			}		
		}

	// single or multiday
	} else {
		
		if (!$endepoch) {
			if ($startepoch > $beginningepoch && $startepoch < $closingepoch) {
				$occurance = 1;
				$firstone = $startepoch;
			}
		} else {
			$occurance = 2;
			unset($datelist);
			$datelist = array();
			for($i = ($beginningepoch); $i < $closingepoch; $i = $i + 86400) {
				if ($i >= $startepoch && $i <= $endepoch) {
					$datelist[] = $i;
				}
			}
		}
	} 
	
	if ($occurance == 1) {
		wpfc_calendar_add($firstone,get_the_title(),get_permalink(),get_the_excerpt(),$key_place_value, $postid );
	}
	
	if ($occurance == 2) {
		foreach ($datelist as $dateentry) {
			wpfc_calendar_add($dateentry,get_the_title(),get_permalink(),get_the_excerpt(),$key_place_value, $postid );
		}
	}
	
	endwhile;
	else : endif;
	wp_reset_query();	
}

function wpfc_subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}


function wpfc_get_the_calendar($cmonth,$cyear) {
	global $calentries;
	$calentries = array();
	$output = '';
	wpfc_get_the_events($cmonth,$cyear);

	if($calentries) {		
		$calentries = wpfc_subval_sort($calentries,'strdate'); 
		foreach ($calentries as $cal_the_entry) {
			
			$tmonth = date_i18n( 'D' , $cal_the_entry['strdate'] , false );
			$caltime = get_post_meta($cal_the_entry['cids'], '_wpfc_timestartentry', true);
			$output .= '<div class="calsingleentry"><div class="daydisplay"><span>' . $tmonth .   '</span><h1>'. date('d', $cal_the_entry['strdate']) . ' </h1></div>';
			$output .= '<div class="shortcalentry"><a href="' . $cal_the_entry['clink'] . '">' . $cal_the_entry['ctitle'] .  '</a>';
			$output .= '<span class="intdesc">';
			if ($caltime){ 
				$output .=  __('Time: ', 'church-pack') . '' . $caltime . '&nbsp;';
			}
			if ($caltime && $cal_the_entry['clocation']) {
				$output .= '|&nbsp;';
			}
			if ($cal_the_entry['clocation']){ 
				$output .= __('Location: ', 'church-pack') . '' . $cal_the_entry['clocation']  . ' ';
			}	
			$output .= '</span></div></div>';
		}	
		return $output;
	} else {
		return '<p>' . __('No events currently scheduled', 'church-pack') . '</p>';
	}
}


function wpfc_get_for_widget($num){
	global $calentries;
	$woutput = '';
	$monthset = '';
	$wmonth = date("n");
	$wyear = date("Y");
	$emptycounter = 0;
	$wcounter = 0;
	$currententry = date('U');
	$continue = 0;
	$wnum = $num - 1;
	
	while ($continue != 1) { 
		$calentries = array();
		wpfc_get_the_events($wmonth,$wyear);	
		if($calentries) {
			$calentries = wpfc_subval_sort($calentries,'strdate'); 
			foreach ($calentries as $cal_the_entry) {	
				if ($cal_the_entry['strdate'] >= $currententry && $wcounter <= $wnum) {
					$caltime = get_post_meta($cal_the_entry['cids'], '_wpfc_timestartentry', true);
					$woutput .= '<div class="calsingleentryw"><div class="daydisplayw"><span>' . date_i18n( 'M' , $cal_the_entry['strdate'] , false ) . '</span><h1>' . date_i18n( 'd' , $cal_the_entry['strdate'] , false ) . '</h1></div>';
					$woutput .= '<div class="shortcalentryw"><a href="' . $cal_the_entry['clink'] . '">' . $cal_the_entry['ctitle'] .  '</a>';
					$woutput .= '</div><div class="clear"></div></div>';				
					$wcounter = $wcounter + 1;			
				}		
			}	
		}
				
		$wmonth = $wmonth + 1;
		if ($wmonth == 13) {
			$wmonth = 1;
			$wyear = $wyear + 1;
		}
		$emptycounter++;
		$monthset = '';
		if ($wcounter >= $num || $emptycounter >= 5) {
			$continue = 1;
		}
	}
	
	if ($woutput) {
		echo $woutput;
	} else{
		echo '<p>' . __('No events currently scheduled', 'church-pack') . '</p>';
	}
}

function wpfc_caldescript($post_ID) {

	$key_date_value = '';
	$key_end_value = '';
	$key_time_value = '';
	$key_place_value = '';
	$key_recurring_value = '';
	$key_recint_value = '';
	$key_recday_value = '';
	$key_recint_value = get_post_meta($post_ID, '_wpfc_recint', true);
	$key_recday_value = get_post_meta($post_ID, '_wpfc_recday', true);
	$key_date_value = get_post_meta($post_ID, '_wpfc_datestartentry', true);
	$key_recurring_value = get_post_meta($post_ID, '_wpfc_recurring', true);
	$key_end_value = get_post_meta($post_ID, '_wpfc_dateendentry', true);
	$key_time_value = get_post_meta($post_ID, '_wpfc_timestartentry', true);
	$key_place_value = get_post_meta($post_ID, '_wpfc_thelocation', true);
	$key_registration_value = get_post_meta($post_ID, '_wpfc_registration', true);
	$key_eventaddress_value = get_post_meta($post_ID, '_wpfc_eventaddress', true);
	
	
	$dateholder = explode('/',$key_date_value);	
	
	$datestring = wpfc_make_epoch($dateholder[0], $dateholder[1] , $dateholder[2] , $key_time_value , 'GMT');
	if ($key_end_value) {
	$endholder =  explode('/',$key_end_value);
	$endstring = wpfc_make_epoch($endholder[0], $endholder[1] , $endholder[2] , $key_time_value , 'GMT');
	} else {
	$endstring = '';
	}
	$output = '';
	if ($key_registration_value) {
		$output = '<p class="calregistration"><a href="'.esc_url($key_registration_value).'" class="button calregistration">' . __('Register', 'churchpack') . '</a></p>';
	} else {
	}
	$output .= '<div class="calexplain">';
	if ($key_recurring_value == 'Never' && $key_recint_value == 'select interval' && $key_recday_value == 'select day'){
	
		if ($endstring) {
		
		$output .= '<p class="calsingle"><strong>' . __('Start Date:', 'churchpack') . ' </strong><span>' . date_i18n( 'F d, Y' , $datestring , false ) . '</span></p>';
		$output .= '<p class="calsingle"><strong>' . __('End Date:', 'churchpack') . ' </strong><span>' . date_i18n( 'F d, Y' , $endstring , false ) . '</span></p>';
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		} else {
		
		$output .=  '<p class="calsingle"><strong>' . __('Date:', 'churchpack') . ' </strong><span>' . date_i18n( 'l F d, Y' , $datestring , false ) . '</span></p>';
		
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		}
	
	}
	
	if ($key_recurring_value == 'Every week same day' && $key_recint_value == 'select interval' && $key_recday_value == 'select day'){
	
		if ($endstring) {
		$output .= '<p class="calsingle"><strong>' . __('Every ', 'churchpack') . ' '  . date_i18n( ' l ' , $datestring , false ) . '</strong></p>';
		$output .= '<p class="calsingle"><strong>' . __('Until:', 'churchpack') . ' </strong><span>' . date_i18n( 'F d, Y' , $endstring , false ) . '</span></p>';
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		} else {
		
		$output .= '<p class="calsingle"><strong>' . __('Every', 'churchpack') . ' '  . date_i18n( ' l ' , $datestring , false ) . '</strong></p>';
		
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		}
	
	}
	
if ($key_recurring_value == 'Every month same date' && $key_recint_value == 'select interval' && $key_recday_value == 'select day'){
	
		if ($endstring) {
		$output .= '<p class="calsingle"><strong>' . __('Every ', 'churchpack') . ' '  . date_i18n( 'jS' , $datestring , false ) .  __(' of the month', 'churchpack') . ' </strong></p>';
		$output .= '<p class="calsingle"><strong>' . __('Until:', 'churchpack') . ' </strong><span>' . date_i18n( 'F d, Y' , $endstring , false ) . '</span></p>';
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		} else {
		
		$output .= '<p class="calsingle"><strong>' . __('Every ', 'churchpack') . ' '  . date_i18n( 'jS' , $datestring , false ) . ' ' .  __(' of the month', 'churchpack') . ' </strong></p>';
		
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span> '. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span> '. $key_place_value .'</span></p>';
		}
		
		}
	
	}
	
	if ($key_recurring_value == 'Never' && $key_recint_value != 'select interval' && $key_recday_value != 'select day'){
	
		if ($endstring) {
		$output .= '<p class="calsingle"><strong>' . __('Every ', 'churchpack') . ' ' . $key_recint_value . ' ' . $key_recday_value . __(' of the month', 'churchpack') . ' </strong></p>';
		$output .= '<p class="calsingle"><strong>' . __('Until:', 'churchpack') . ' </strong><span>' . date_i18n( 'F d, Y' , $endstring , false ) . '</span></p>';
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span>'. $key_time_value .'</span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span>'. $key_place_value .'</span></p>';
		}
		
		} else {
		
		$output .= '<p class="calsingle"><strong>' . __('Every ', 'churchpack') . $key_recint_value . ' ' . $key_recday_value . ' ' . __('of the month', 'churchpack') . ' </strong></p>';
		
		if ($key_time_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Time:', 'churchpack') . ' </strong><span> '. $key_time_value .' </span></p>';
		}
		
		if ($key_place_value) {	
			$output .= '<p class="calsingle"><strong>' . __('Place:', 'churchpack') . ' </strong><span> '. $key_place_value .' </span></p>';
		}
		
		}
	
	}
	
	$output .= '</div>';
	if ( $key_eventaddress_value ) : 
			$output .= '<br/>';
			$output .= do_shortcode('[cp-map address=" ' . $key_eventaddress_value . ' "]'); 
	endif;

	echo $output;

}

// End Advanced Functions

// Load JS
add_action('wp_ajax_churchpack_get_ajaxdata', 'churchpack_ajax_callback');
add_action('wp_ajax_nopriv_churchpack_get_ajaxdata', 'churchpack_ajax_callback');


function churchpack_ajax_callback() {
global $wpdb;

	if(isset($_POST['type'])){
	$action_identifier = $_POST['type'];
	}
	if(isset($_POST['name'])){
	$signup_name = $_POST['name'];
	}
	if(isset($_POST['location'])){
	$location = $_POST['location'];
	}
	if(isset($_POST['mstring'])){
	$mstring = $_POST['mstring'];
	}
	if(isset($_POST['senddata'])){
		$thedata = $_POST['senddata'];
	}
	
	$output = '';
	
	if($action_identifier == 'get_cal'){
		$monthdata = explode('/', $thedata);
		$month = $monthdata[0];
		$year = $monthdata[1];
		$content .= '<div class="calHead">';
		$content .= '<h2 class="event-month">' . wpfc_monthname($month,$year) . '</h2>';
		$content .= '<div class="monthNav">';
		$content .= wpfc_prevlink($month , $year);
		$content .= '<span> | </span>';
		$content .= wpfc_nextlink($month , $year);
		$content .= '</div>';
		$content .= '</div><div class="calentries">';
		$content .= wpfc_get_the_calendar($month,$year) . '</div>';	
		$output = $content; 

	}
	
	echo $output;
	exit;

}
// End Load JS

// Load Event Data to Post Content and Excerpt
add_filter('the_content', 'addEventsContent');
add_filter('the_excerpt', 'addEventsExcerpt');
	
function addEventsContent($content)	{
	  global $post;
	 
	  if ($post->ID)
	  {
	    $p_type= get_post_type($post->ID);
	    if ($p_type == 'wpfc_event')
	    {
	      $content .= get_wpfc_event();
	    }
	  }
	 
	  return $content;
}
	
function addEventsExcerpt($content)	{
	global $post;
	 
	if ($post->ID) {
	    $p_type= get_post_type($post->ID);
	    if ($p_type == 'wpfc_event')  {
	      $content .= get_wpfc_event_excerpt();
	    }
	}
	 
	return $content;
}

function get_wpfc_event($content = '') {
	global $post;
	ob_start(); ?>
	<div class="event-data">
		<?php wpfc_caldescript(get_the_ID())?>
	</div>
	<?php
	$buffer = ob_get_clean();
	return $buffer;
}
	
function get_wpfc_event_excerpt() {
	global $post;
	ob_start(); ?>
	<div class="event-data">
		<?php wpfc_caldescript(get_the_ID())?>
	</div>
	<?php
	$buffer = ob_get_clean();
	return $buffer;
}

/*
 * Events Widget
 */
 
class wpfc_event_Widget extends WP_Widget {

    function wpfc_event_Widget() {
		$widget_ops = array('classname' => 'upcoming_events', 'description' => __( 'Add a list of upcoming events to your site.', 'churchpack') );
		parent::__construct('upcoming-events', __('Upcoming Events', 'churchpack'), $widget_ops);
		$this->alt_option_name = 'widget_upcoming_events';
    }

    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $calnum  = $instance['calnum'];
            echo $before_widget;
                if ( $title )
                echo $before_title . $title . $after_title; ?>
						<div id="churchpack-event-widget">						
						<?php if ($calnum) { ?>
						<?php wpfc_get_for_widget($calnum); ?>	
						<?php } else { ?>	
						<?php wpfc_get_for_widget(4); ?>	
						
						<?php } ?>										
						</div>
						
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['calnum'] = strip_tags($new_instance['calnum']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        $calnum = esc_attr($instance['calnum']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'churchpack'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('calnum'); ?>"><?php _e('Number of entries to show:', 'churchpack'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('calnum'); ?>" name="<?php echo $this->get_field_name('calnum'); ?>" type="text" value="<?php echo
		esc_attr($calnum); ?>" /></p>
        <?php 
    }

} // class wpfc_events_Widget
add_action('widgets_init', create_function('', 'return register_widget("wpfc_event_Widget");'));

// End Events Widget
?>