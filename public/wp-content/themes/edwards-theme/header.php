<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Edwards
 * @since Edwards 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php $heading_font = of_get_option('edwards_heading_font'); ?>
<?php $body_font = of_get_option('edwards_body_font'); ?>
<?php $home_message_font = of_get_option('edwards_home_message_font'); ?>
<?php if ($heading_font != "") : ?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($heading_font)); ?>:regular,italic,bold,bolditalic" />
<?php endif; ?>

<?php if ($body_font != "" && $body_font != $heading_font) : ?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($body_font)); ?>:regular,italic,bold,bolditalic" />
<?php endif; ?>

<?php if ($home_message_font != "") : ?>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo(urlencode($home_message_font)); ?>:regular,italic,bold,bolditalic" />
<?php endif; ?>
	
<?php if (of_get_option('edwards_favicon') ) : ?>
	<link rel="shortcut icon" href="<?php echo of_get_option('edwards_favicon'); ?>" />
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div id="topline">
		<?php
			$edwards_fb = of_get_option( 'social_fb' );
			$edwards_twitter = of_get_option( 'social_twitter' );
			$edwards_gplus = of_get_option( 'social_gplus' );
			$edwards_phone = of_get_option( 'edwards_phone' );
			$edwards_street = of_get_option( 'edwards_street' );
			$edwards_address = of_get_option( 'edwards_address' );
		?>
			<div class="wrapper">
				<ul class="top-contact">
					<?php if ( $edwards_street ) : 
						$address_url = preg_replace( '![^a-z0-9]+!i', '+', $edwards_street. ' ' .$edwards_address );?>
					<li class="church-address">
						<i class="icon-map-marker"></i> <a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" title="<?php esc_attr_e( 'Directions', 'edwards' ); ?>"><?php echo $edwards_street. ', ' .$edwards_address; ?></a>
					</li>
					<?php endif; ?>
					<?php if ( $edwards_phone ) : ?>
					<li class="church-phone">
						<i class="icon-mobile-phone"></i> <a href="tel:<?php echo $edwards_phone; ?>"><?php echo $edwards_phone; ?></a>
					</li>
					<?php endif; ?>
				</ul>
				<div id="top-social">
					<ul class="top-social">
						<?php if ( $edwards_fb ) : ?>
							<li><a class="facebook" href="<?php echo esc_url( $edwards_fb ); ?>" title="<?php esc_attr_e( 'Facebook', 'edwards' ); ?>"><i class="icon-facebook"></i><span><?php _e( 'Facebook', 'edwards' ); ?></span></a></li>
						<?php endif; ?>

						<?php if ( $edwards_twitter ) : ?>
							<li><a class="twitter" href="<?php echo esc_url( $edwards_twitter ); ?>" title="<?php esc_attr_e( 'Twitter', 'edwards' ); ?>"><i class="icon-twitter"></i><span><?php _e( 'Twitter', 'edwards' ); ?></span></a></li>
						<?php endif; ?>

						<?php if ( $edwards_gplus ) : ?>
							<li><a class="gplus" href="<?php echo esc_url( $edwards_gplus ); ?>" title="<?php esc_attr_e( 'Google+', 'edwards' ); ?>"><i class="icon-google-plus"></i><span><?php _e( 'Google+', 'edwards' ); ?></span></a></li>
						<?php endif; ?>
					</ul>
				</div><!-- #top-social -->
			</div><!-- .wrapper -->
		</div><!-- #topline -->
		<div class="wrapper">
			<hgroup>
			<?php $edwards_logo = of_get_option('logo'); ?>
			<?php if($edwards_logo) : ?>				
				<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $edwards_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
			<?php else : ?>				
				<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>	
			</hgroup>

			<nav role="navigation" class="site-navigation main-navigation <?php if($edwards_logo) : echo 'logo'; else : endif;?>">
				<h1 class="assistive-text"><?php _e( 'Menu', 'edwards' ); ?></h1>
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'edwards' ); ?>"><?php _e( 'Skip to content', 'edwards' ); ?></a></div>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->
		</div><!-- .wrapper -->
	</header><!-- #masthead .site-header -->
	
	<?php if(is_front_page()): //Insert home page slideshow
		if(of_get_option('edwards_slideshow_enabled')) get_template_part( 'part-slideshow');
	endif; ?>
	
	<div id="main" class="site-main">
		<div class="wrapper">