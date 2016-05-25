<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Edwards
 * @since Edwards 1.0
 */
?>
<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-sermon' ) ) : ?>

		<aside id="text" class="widget widget_text">
			<h1 class="widget-title"><?php _e( 'Sermon Sidebar', 'edwards' ); ?></h1>
			<div class="textwidget">Change this by adding a widget to the sermon sidebar. You can also add a blank text widget to make the sidebar empty.</div>
		
		</aside>

	<?php endif; // end sermon widget area ?>	
</div><!-- #secondary .widget-area -->
