<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package    cvg-lp-connect
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
{
    exit;
}

// delete all the options with plugin
$all_options = wp_load_alloptions();

foreach($all_options as $k => $v) 
{
    if (strpos($k, '_cvg_lp_connect_') !== false)
    {
        delete_option($k);
    }
}
