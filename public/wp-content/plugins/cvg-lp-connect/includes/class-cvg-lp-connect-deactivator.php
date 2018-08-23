<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://cvoutreach.com
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/includes
 */
class cvg_lp_connect_deactivator 
{
	/**
	 * Run when plugin is deactivated
	 */
	public static function deactivate() 
	{
		wp_clear_scheduled_hook('cvg_twicedaily_event_hook');
		
		// remove these options
		delete_option('_cvg_lp_connect_log');
	}
}
