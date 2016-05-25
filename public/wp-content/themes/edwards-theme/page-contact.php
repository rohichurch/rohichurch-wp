<?php
/**
 * Template Name: Contact
 */
get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $prefix = 'wpfc_';
				$page_description = get_post_meta($post->ID, $prefix.'page_description', true);
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php if(!empty($page_description)) { ?>
							<div class="page-description">
								<?php echo $page_description; ?>
							</div><!-- .page-description -->
						<?php } ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php edwards_contact_map(); ?>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'edwards' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'edwards' ), '<span class="edit-link"> <i class="icon-edit"></i> ', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
		<div id="secondary" class="widget-area" role="complementary">

				<aside id="contact-info" class="widget edwards-address clearfix">
					<h1 class="widget-title"><?php echo _e('Connect With Us','edwards'); ?></h1>
					<?php
						$edwards_fb = of_get_option( 'social_fb' );
						$edwards_twitter = of_get_option( 'social_twitter' );
						$edwards_gplus = of_get_option( 'social_gplus' );
						$edwards_email = of_get_option( 'social_email' );
						$edwards_phone = of_get_option( 'edwards_phone' );
						$edwards_street = of_get_option( 'edwards_street' );
						$edwards_address = of_get_option( 'edwards_address' );
						?>							

						<?php if ( $edwards_address ) : 
							$address_url = preg_replace( '![^a-z0-9]+!i', '+', $edwards_street. ' ' .$edwards_address );?>
							<p><i class="icon-map-marker"></i> <a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" title="<?php esc_attr_e( 'Directions', 'edwards' ); ?>"><?php echo $edwards_street. '<span class="city-state">' .$edwards_address. '</span>'; ?> </a></p>
						<?php endif; ?>

						<?php if ( $edwards_phone ) : ?>
							<p><i class="icon-phone"></i> <a href="tel:<?php echo $edwards_phone; ?>"><?php echo $edwards_phone; ?></a></p>
						<?php endif; ?>

						<?php if ( $edwards_email ) : ?>
							<p><i class="icon-envelope"></i> <a href="mailto:<?php echo antispambot( $edwards_email ); ?>"><?php echo $edwards_email; ?></a></p>
						<?php endif; ?>
						
						<div id="contact-social">
							<ul class="contact-social">
								<?php if ( $edwards_fb ) : ?>
									<li class="facebook"><a href="<?php echo esc_url( $edwards_fb ); ?>" title="<?php esc_attr_e( 'Facebook', 'edwards' ); ?>"><i class="icon-facebook"></i><span><?php _e( 'Facebook', 'edwards' ); ?></span></a></li>
								<?php endif; ?>

								<?php if ( $edwards_twitter ) : ?>
									<li class="twitter" ><a href="<?php echo esc_url( $edwards_twitter ); ?>" title="<?php esc_attr_e( 'Twitter', 'edwards' ); ?>"><i class="icon-twitter"></i><span><?php _e( 'Twitter', 'edwards' ); ?></span></a></li>
								<?php endif; ?>

								<?php if ( $edwards_gplus ) : ?>
									<li class="gplus"><a href="<?php echo esc_url( $edwards_gplus ); ?>" title="<?php esc_attr_e( 'Google+', 'edwards' ); ?>"><i class="icon-google-plus"></i><span><?php _e( 'Google+', 'edwards' ); ?></span></a></li>
								<?php endif; ?>
							</ul>
						</div><!-- #contact-social -->
				</aside>

		</div><!-- #secondary .widget-area -->

<?php get_footer(); ?>