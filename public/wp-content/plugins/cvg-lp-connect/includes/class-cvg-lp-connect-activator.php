<?php

/**
 * Fired during plugin activation
 *
 * @link       http://cvoutreach.com
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/includes
 */
class cvg_lp_connect_activator 
{
    /**
     * Run when plugin is activated
     */
    public static function activate() 
    {
        if (!wp_next_scheduled('cvg_twicedaily_event_hook')) 
        {
            wp_schedule_event(time(), 'twicedaily', 'cvg_twicedaily_event_hook');
        }
     
        set_transient( 'fx-admin-notice-cvg-lp-connect', true, 5 );
    }
    
    /**
     * Message displayed when plugin was activated
     */
    public static function activate_msg() 
    {
        if(get_transient( 'fx-admin-notice-cvg-lp-connect' ))
        {
            echo '
                <div class="updated notice is-dismissible">
                    <p>
                        '.__( 'The CV Outreach Landing Page Creator has been activated. ', 'cvg-lp-connect').'
                        <a href="admin.php?page=cvg-lp-connect">'.__( 'Click here ', 'cvg-lp-connect').'</a> '.__( 'to begin setup.', 'cvg-lp-connect').'
                    </p>
                </div>
            ';
            
            delete_transient( 'fx-admin-notice-cvg-lp-connect' );
        }
    }
}
