<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<title><?php global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'ari' ), max( $paged, $page ) );
	?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" href="/assets/v20140904.2/css/main.css" media="all">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans:regular,bold|Droid+Serif:regular,italic,bold,bolditalic&subset=latin" media="all">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.0/css/font-awesome.min.css">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrap" class="clearfix">
	<div id="sidebar-primary">

	<div class="logo">
	<?php if (get_option('ari_logo-image') ) : ?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo (get_option('ari_logo-image')) ? get_option('ari_logo-image') : get_template_directory_uri() . '/images/logo.png' ?>" alt="<?php bloginfo('name'); ?>" /></a>

	<?php else : ?>

	<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1><p><?php bloginfo( 'description' ); ?></p>
	<?php endif; ?>
	</div><!--end Logo-->

	<?php get_sidebar('primary'); ?>

	</div>
	<!--end Sidebar One-->
