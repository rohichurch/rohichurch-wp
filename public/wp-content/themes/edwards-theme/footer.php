<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Edwards
 * @since Edwards 1.0
 */
?>
		</div><!-- #main .wrapper -->
	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrapper">
			<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
				<ul class="footer-widgets grid clearfix">
					<?php dynamic_sidebar( 'footer-sidebar' ); ?>
				</ul><!-- .footer-widgets -->
			<?php endif; ?>
			<div class="site-info clearfix">
				<?php do_action( 'edwards_credits' ); ?>					
				<?php $footer_left = of_get_option('edwards_footer_left'); ?>
				<?php $footer_right = of_get_option('edwards_footer_right'); ?>
				<div class="left"><?php if($footer_left){echo($footer_left);} else{ ?>&copy; <?php echo date('Y');?> <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a> All Rights Reserved.<?php }; ?></div>
				<div class="right"><?php if($footer_right){echo($footer_right);} else{ ?>Theme by <a href="http://www.wpforchurch.com/" rel="designer">WP for Church</a><?php }; ?></div>
			</div><!-- .site-info -->
		</div><!-- .wrapper -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>