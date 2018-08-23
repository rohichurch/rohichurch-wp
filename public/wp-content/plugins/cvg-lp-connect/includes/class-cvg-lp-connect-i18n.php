<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://cvoutreach.com
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/includes
 */

class cvg_lp_connect_i18n 
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 */
	public function load_plugin_textdomain() 
	{
		load_plugin_textdomain(
			'cvg-lp-connect',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
