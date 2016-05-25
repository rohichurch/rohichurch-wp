<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Edwards
 * @since Edwards 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Edwards 1.0
 */
function edwards_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'edwards_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Edwards 1.0
 */
function edwards_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'edwards_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Edwards 1.0
 */
function edwards_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'edwards_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Edwards 1.0
 */
function edwards_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'edwards' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'edwards_wp_title', 10, 2 );

/*
 * Get custom thumb size from a url and create a new thumbnail
 *
 * $height -> height of new image
 * $width -> width of new image
 * $src -> url of image you want to get thumb from
 */
function edwards_get_thumb($width, $height, $src){
	$size = getimagesize($src);
	if($width >= $size[0] || $height >= $size[1]){
		  echo $src;
	} else {
		if(strpos($src, '.jpg')){
			$new_src = explode('.jpg', $src);
			$new_src = $new_src[0].'-'.$width.'x'.$height.'.jpg';
				echo $new_src;
		} elseif(strpos($src, '.jpeg')) {
			$new_src = explode('.jpeg', $src);
			$new_src = $new_src[0].'-'.$width.'x'.$height.'.jpeg';
				echo $new_src;
		} elseif(strpos($src, '.gif')) {
			$new_src = explode('.gif', $src);
			$new_src = $new_src[0].'-'.$width.'x'.$height.'.gif';
				echo $new_src;
		} elseif(strpos($src, '.png')) {
			$new_src = explode('.png', $src);
			$new_src = $new_src[0].'-'.$width.'x'.$height.'.png';
				echo $new_src;
		}
	}
}

?>