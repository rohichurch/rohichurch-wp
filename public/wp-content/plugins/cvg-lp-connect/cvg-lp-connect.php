<?php
/**
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://cvoutreach.com
 * @package           cvg_lp_connect
 *
 * @wordpress-plugin
 * Plugin Name:       CV Outreach Landing Page Creator
 * Plugin URI:        http://cvoutreach.com/
 * Description:       This plugin quickly sets up landing pages to work with CV Outreach's Adwords program
 * Version:           1.4.0
 * Author:            CV Outreach
 * Author URI:        http://cvoutreach.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) 
{
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cvg_lp_connect-activator.php
 */
function activate_cvg_lp_connect() 
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cvg-lp-connect-activator.php';
    cvg_lp_connect_activator::activate();
}

function activate_cvg_lp_connect_msg() 
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cvg-lp-connect-activator.php';
    cvg_lp_connect_activator::activate_msg();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cvg_lp_connect-deactivator.php
 */
function deactivate_cvg_lp_connect() 
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cvg-lp-connect-deactivator.php';
    cvg_lp_connect_deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cvg_lp_connect' );
register_deactivation_hook( __FILE__, 'deactivate_cvg_lp_connect' );
add_action('admin_notices', 'activate_cvg_lp_connect_msg');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cvg-lp-connect.php';

/**
 * Begins execution of the plugin.
 *
 */
function run_cvg_lp_connect() 
{
    $plugin = new cvg_lp_connect();
    $plugin->run();
}

run_cvg_lp_connect();
