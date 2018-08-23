<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/admin
 */
class cvg_lp_connect_admin 
{
    private $plugin_id;
    private $version;
    
    /**
     * set default configuration 
     *
     */
    private static $lp_options = array(
        '_cvg_lp_connect_site_id' => ''
        ,'_cvg_lp_connect_endpoint_name' => ''
        ,'_cvg_lp_connect_tmpl' => 4
        ,'_cvg_lp_connect_site_name' => ''
        ,'_cvg_lp_connect_ga' => ''
        ,'_cvg_lp_connect_ga_body' => ''
        ,'_cvg_lp_connect_page_id' => 0
        ,'_cvg_lp_connect_logo' => ''
        ,'_cvg_lp_connect_site_link' => ''
        
        ,'_cvg_lp_connect_site_pages' => array()
        ,'_cvg_lp_connect_lat' => null
        ,'_cvg_lp_connect_lng' => null
        ,'_cvg_lp_connect_address' => null
        ,'_cvg_lp_connect_locality' => null
        ,'_cvg_lp_connect_region' => null
        ,'_cvg_lp_connect_postal_code' => null
        ,'_cvg_lp_connect_country' => null
        
        ,'_cvg_lp_connect_tmpl_1' => array(
            'hbg_image' => array('t' => 'img', 'v' => '', 'img_lib' => 'tmpl1/header' )
            ,'hol_color' => array('t' => 'color', 'v' => '#000', 'trans' => 'hol_trans')
            ,'hol_trans' => array('t' => 'trans', 'v' => '2')
            ,'htxt_color' => array('t' => 'color', 'v' => '#fff')
            ,'bg_color' => array('t' => 'color', 'v' => '#fff')
            ,'bg_image' => array('t' => 'img', 'v' => '')
            ,'txt_color' => array('t' => 'color', 'v' => '#333')
            ,'btntxt_color' => array('t' => 'color', 'v' => '#fff')
            ,'btnbg_color' => array('t' => 'color', 'v' => '#62acec')
            ,'hl_color' => array('t' => 'color', 'v' => '#62acec')
            ,'ftxt_color' => array('t' => 'color', 'v' => '#999')
            ,'fbg_color' => array('t' => 'color', 'v' => '#eee')
        )
        ,'_cvg_lp_connect_tmpl_2' => array(
            'hbg_image' => array('t' => 'img', 'v' => '', 'img_lib' => 'tmpl2/header')
            ,'hol_color' => array('t' => 'color', 'v' => '#000', 'trans' => 'hol_trans')
            ,'hol_trans' => array('t' => 'trans', 'v' => '4')
            ,'htxt_color' => array('t' => 'color', 'v' => '#fff')
            ,'bg_color' => array('t' => 'color', 'v' => '#fff')
            ,'txt_color' => array('t' => 'color', 'v' => '#333')
            ,'btntxt_color' => array('t' => 'color', 'v' => '#fff')
            ,'btnbg_color' => array('t' => 'color', 'v' => '#62acec')
            ,'hl_color' => array('t' => 'color', 'v' => '#62acec')
            ,'ftxt_color' => array('t' => 'color', 'v' => '#999')
            ,'fbg_color' => array('t' => 'color', 'v' => '#eee')
        )
        ,'_cvg_lp_connect_tmpl_3' => array(
            'bg_color' => array('t' => 'color', 'v' => '#000')
            ,'bg_tr_color' => array('t' => 'color', 'v' => '#5f5f7b', 'trans' => 'bg_tr_trans')
            ,'bg_tr_trans' => array('t' => 'trans', 'v' => '4')
            ,'bg_bl_color' => array('t' => 'color', 'v' => '#8d738e', 'trans' => 'bg_bl_trans')
            ,'bg_bl_trans' => array('t' => 'trans', 'v' => '4')
            ,'bg_br_color' => array('t' => 'color', 'v' => '#436f92', 'trans' => 'bg_br_trans')
            ,'bg_br_trans' => array('t' => 'trans', 'v' => '6')
            ,'hd_ol_color' => array('t' => 'color', 'v' => '#fff', 'trans' => 'hd_ol_trans')
            ,'hd_ol_trans' => array('t' => 'trans', 'v' => '1')
            ,'hd_br_color' => array('t' => 'color', 'v' => '#fff', 'trans' => 'hd_br_trans')
            ,'hd_br_trans' => array('t' => 'trans', 'v' => '2')
            ,'hd_txt_color' => array('t' => 'color', 'v' => '#fff')
            ,'bd_txt_color' => array('t' => 'color', 'v' => '#fff')
            ,'btn_txt_color' => array('t' => 'color', 'v' => '#fff')
            ,'btn_bg_color' => array('t' => 'color', 'v' => '#284358')
            ,'link_color' => array('t' => 'color', 'v' => '#fff')
            ,'ft_ol_color' => array('t' => 'color', 'v' => '#fff', 'trans' => 'ft_ol_trans')
            ,'ft_ol_trans' => array('t' => 'trans', 'v' => '1')
            ,'ft_br_color' => array('t' => 'color', 'v' => '#fff', 'trans' => 'ft_br_trans')
            ,'ft_br_trans' => array('t' => 'trans', 'v' => '2')
            ,'ft_txt_color' => array('t' => 'color', 'v' => '#fff')
        )
        ,'_cvg_lp_connect_tmpl_4' => array(
            'bg_color' => array('t' => 'color', 'v' => '#fff')
            ,'bg_bar_color' => array('t' => 'color', 'v' => '#3182bd', 'trans' => 'bg_bar_trans')
            ,'bg_bar_trans' => array('t' => 'trans', 'v' => '2')
            ,'bar_skew_color' => array('t' => 'color', 'v' => '#3182bd', 'trans' => 'bar_skew_trans')
            ,'bar_skew_trans' => array('t' => 'trans', 'v' => '8')
            ,'v_bg_color' => array('t' => 'color', 'v' => '#fff')
            ,'hd_txt_color' => array('t' => 'color', 'v' => '#333')
            ,'bd_txt_color' => array('t' => 'color', 'v' => '#333')
            ,'btn_txt_color' => array('t' => 'color', 'v' => '#fff')
            ,'btn_bg_color' => array('t' => 'color', 'v' => '#3182bd')
            ,'link_color' => array('t' => 'color', 'v' => '#000')
            ,'ft_bg_color' => array('t' => 'color', 'v' => '#f8f8f8')
            ,'ft_txt_color' => array('t' => 'color', 'v' => '#9e9e9e')
        )
    );
    
    /**
     * sets url for rest API
     *
     */
    private $rest_url = 'https://cvoutreach.com/wp-json/cvg_lp_connect/v2/';
    
    /**
     * JS file url
     *
     */
    public static $js_url = 'https://cvoutreach.com/lp/';
    
    /**
     * sets http header for rest API
     *
     */
    private $rest_headers = array(
        'user-agent' => 'WP CVG Landing Page Response Plugin',
        'compress' => false,
        'sslverify' => false,
        'headers' => array(
            'User-Agent: WP CVG Landing Page Response Plugin',
            'Accept: */*',
            'X-Requested-With: XMLHttpRequest'
        )
    );

    /**
     * Initialize the class and set its properties.
     *
     */
    public function __construct( $plugin_id, $version ) 
    {
        $this->plugin_id = $plugin_id;
        $this->version = $version;
        
        $this->rest_headers['headers'][] = "X-ConnectOrigin: ".site_url();

        // set default values for settings 
        self::$lp_options['_cvg_lp_connect_site_name'] = get_option('blogname');
        self::$lp_options['_cvg_lp_connect_site_link'] = get_option('siteurl');

        self::$lp_options['_cvg_lp_connect_tmpl_1']['hbg_image']['l'] = __('Default Banner Image', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['hbg_image']['v'] = self::$js_url.'connect/v'.$version.'/tmpl1/header/manlooking.jpg';
        //self::$lp_options['_cvg_lp_connect_tmpl_1']['hbg_image']['notes'] = __('* Not all Available Pages have a banner image associated with the page.  This image is used when an image is not specified.', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['hol_color']['l'] = __('Banner Image Overlay Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['hol_trans']['l'] = __('Banner Image Overlay Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['htxt_color']['l'] = __('Banner Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['bg_color']['l'] = __('Body Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['bg_image']['l'] = __('Body Background Image', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['txt_color']['l'] = __('Body Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['btntxt_color']['l'] = __('Button Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['btnbg_color']['l'] = __('Button Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['hl_color']['l'] = __('Highlight Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['ftxt_color']['l'] = __('Footer Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_1']['fbg_color']['l'] = __('Footer Background Color', $this->plugin_id);

        self::$lp_options['_cvg_lp_connect_tmpl_2']['hbg_image']['l'] = __('Default Banner Image', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['hbg_image']['v'] = self::$js_url.'connect/v'.$version.'/tmpl2/header/manlooking.jpg';
        //self::$lp_options['_cvg_lp_connect_tmpl_2']['hbg_image']['notes'] = __('* Not all Available Pages have a banner image associated with the page.  This image is used when an image is not specified.', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['hol_color']['l'] = __('Banner Image Overlay Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['hol_trans']['l'] = __('Banner Image Overlay Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['htxt_color']['l'] = __('Banner Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['bg_color']['l'] = __('Body Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['txt_color']['l'] = __('Body Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['btntxt_color']['l'] = __('Button Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['btnbg_color']['l'] = __('Button Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['hl_color']['l'] = __('Highlight Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['ftxt_color']['l'] = __('Footer Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_2']['fbg_color']['l'] = __('Footer Background Color', $this->plugin_id);

        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_color']['l'] = __('Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_tr_color']['l'] = __('Background Top Right Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_tr_trans']['l'] = __('Background Top Right Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_bl_color']['l'] = __('Background Bottom Left Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_bl_trans']['l'] = __('Background Bottom Left Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_br_color']['l'] = __('Background Bottom Right Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bg_br_trans']['l'] = __('Background Bottom Right Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['hd_ol_color']['l'] = __('Header Overlay Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['hd_ol_trans']['l'] = __('Header Overlay Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['hd_br_color']['l'] = __('Header Border Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['hd_br_trans']['l'] = __('Header Border Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['hd_txt_color']['l'] = __('Header Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['bd_txt_color']['l'] = __('Body Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['btn_txt_color']['l'] = __('Button Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['btn_bg_color']['l'] = __('Button Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['link_color']['l'] = __('Link Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['ft_ol_color']['l'] = __('Footer Overlay Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['ft_ol_trans']['l'] = __('Footer Overlay Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['ft_br_color']['l'] = __('Footer Border Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['ft_br_trans']['l'] = __('Footer Border Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_3']['ft_txt_color']['l'] = __('Footer Text Color', $this->plugin_id);

        self::$lp_options['_cvg_lp_connect_tmpl_4']['bg_color']['l'] = __('Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['bg_bar_color']['l'] = __('Background Bar Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['bg_bar_trans']['l'] = __('Background Bar Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['bar_skew_color']['l'] = __('Skewed Bar Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['bar_skew_trans']['l'] = __('Skewed Bar Transparency', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['v_bg_color']['l'] = __('Video Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['hd_txt_color']['l'] = __('Header Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['bd_txt_color']['l'] = __('Body Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['btn_txt_color']['l'] = __('Button Text Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['btn_bg_color']['l'] = __('Button Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['link_color']['l'] = __('Link Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['ft_bg_color']['l'] = __('Footer Background Color', $this->plugin_id);
        self::$lp_options['_cvg_lp_connect_tmpl_4']['ft_txt_color']['l'] = __('Footer Text Color', $this->plugin_id);
        
        // custom menu option
        add_action('admin_menu', array($this, 'plugin_menu') );
        
        // custom settings link
        add_filter('plugin_action_links_'.$plugin_id.'/'.$plugin_id.'.php', array($this, 'plugin_settings_link'));
        
        // add filter to check plugin updates
        add_filter('pre_set_site_transient_update_plugins', array(&$this, 'check_plugin_update'));
        
        // Define the alternative response for information checking
        add_filter('plugins_api', array(&$this, 'check_plugin_info'), 10, 3);
        
        // adds functionality to twicedaily wp cron
        add_action('cvg_twicedaily_event_hook', array($this, 'twicedaily_event') );
    }

    /**
     * Register the stylesheets & javascript for the admin area.
     *
     */
    public function enqueue_includes($p) 
    {
        $pages = array('toplevel_page_cvg-lp-connect','cv-outreach_page_cvg-lp-connect_logs');
        
        // load what we need for all pages
        if (in_array($p, $pages))
        {
            // load bootstrap
            wp_enqueue_style($this->plugin_id.'_css_bs', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, false );
            wp_enqueue_script($this->plugin_id.'_js_bs', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
            
            // load plugin specfic
            wp_enqueue_style($this->plugin_id, plugin_dir_url( __FILE__ ) . 'css/cvg-lp-connect-admin.css', array(), $this->version, false );
            wp_enqueue_script($this->plugin_id, plugin_dir_url( __FILE__ ) . 'js/cvg-lp-connect-admin.js', array( 'jquery' ), $this->version, false );
            
            // add localized labels to JS
            wp_localize_script($this->plugin_id, 'objectL10n_cvg', array(
                'cfg_rest_url' => $this->rest_url
                ,'cfg_js_url' => self::$js_url
                ,'not_set_before' => __("Sorry, it doesn't appear your site (", $this->plugin_id)
                ,'not_set_end' => __(") has been setup with CV Outreach.  Please contact us.  Thanks", $this->plugin_id)
                ,'multiple_sites' => __('Sorry, multiple sites found with your domain.  Please contact us.  Thanks', $this->plugin_id)
                ,'loading_imgs' => __('Loading Images...', $this->plugin_id)
                ,'unable_to_connect' => __('Unable to connect to the CV Outreach servers, try refreshing the page.', $this->plugin_id)
                ,'slug_or_page' => __('Please enter a New Page Slug or select an existing page from the drop down.', $this->plugin_id)
                ,'slug_page_not_both' => __('Please either enter a New Page Slug or select an existing page from the drop down, but not both.', $this->plugin_id)
                ,'enter_site_name' => __('Please enter a Site Name.', $this->plugin_id)
                ,'page_change' => __('! IMPORTANT !<br><br>By changing the Page Assication, you are changing the Landing page URL.  If you are seeing this during the initial page setup, you can disregard this message.  But, if Google Adwords traffic has already starting flowing into your site, this change will cause the traffic to see a 404 error or a blank page.  If you really need to change the page association, please corrdinate this change with CV Outreach so your Google Ads get updated as well!<br><br>Do you really want to make this change?', $this->plugin_id)
            ) );
        }
        
        // load for specific page
        if ($p == 'toplevel_page_cvg-lp-connect')
        {
            wp_enqueue_media();
            wp_enqueue_script($this->plugin_id.'_js_bs_cp', plugin_dir_url( __FILE__ ) . 'js/bootstrap-colorpicker.min.js', array( 'jquery' ), $this->version, false );
            wp_enqueue_script($this->plugin_id.'_js_bs_s', plugin_dir_url( __FILE__ ) . 'js/bootstrap-slider.min.js', array( 'jquery' ), $this->version, false );
            
            wp_enqueue_style($this->plugin_id.'_css_bs_cp', plugin_dir_url( __FILE__ ) . 'css/bootstrap-colorpicker.min.css', array(), $this->version, false );
            wp_enqueue_style($this->plugin_id.'_css_bs_s', plugin_dir_url( __FILE__ ) . 'css/bootstrap-slider.min.css', array(), $this->version, false );
        }
    }
    
    /**
     * Register settings link on the plugin page
     *
     */ 
    public function plugin_settings_link($links)
    {
         $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page='.$this->plugin_id) ) .'">'.__('Settings', $this->plugin_id).'</a>';
         $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page='.$this->plugin_id.'_logs') ) .'">'.__('Logs', $this->plugin_id).'</a>';
        
        return $links;
    }

    /**
     * Register menu link to set options
     *
     */
    public function plugin_menu()
    {
        add_menu_page( __('CV Outreach', $this->plugin_id), __('CV Outreach', $this->plugin_id), 'edit_posts', $this->plugin_id, array($this, 'manage_lps'), 'dashicons-cloud', 99);
        add_submenu_page($this->plugin_id, __('Remote Logs', $this->plugin_id), __('Remote Logs', $this->plugin_id), 'edit_posts', $this->plugin_id.'_logs', array($this, 'lp_logs') );
    }
    
    /**
     * This is a cron event that is called twice daily
     *
     */
    public function twicedaily_event()
    {
        $endpoints = get_option('_cvg_lp_connect_endpoints');

        if ((is_array($endpoints)) && (count($endpoints) > 0))
        {
            foreach($endpoints as &$ep)
            {
                if ($ep['_cvg_lp_connect_site_id'] > 0)
                {
                    $this->set_site_pages($ep['_cvg_lp_connect_site_id']);
                    $this->get_site_js($ep['_cvg_lp_connect_site_id']);
                    $this->get_site_info($ep['_cvg_lp_connect_site_id']);
                }
            }
        }
        else
        {
            $site_id = get_option('_cvg_lp_connect_site_id');
            
            if ($site_id > 0)
            {
                $this->set_site_pages($site_id);
                $this->get_site_js($site_id);
                $this->get_site_info($site_id);
            }
        }
    }
    
    /**
     * get the info of the latest version
     *
     */
    public function check_plugin_info($false, $action, $arg)
    {
        if ($arg->slug === $this->plugin_id) 
        {
            $request = wp_remote_get($this->rest_url.'info', $this->rest_headers);
            
            if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) 
            {
                $rtn = json_decode($request['body'], true);
                
                if ($rtn['status'] > 0)
                {
                    return unserialize($rtn['info']);
                }
                else
                {
                    return false;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Check to see if we have the latest version of the plugin
     *
     */
    public function check_plugin_update($transient)
    {
        if (empty($transient->checked)) 
        {
            return $transient;
        }
        
        $log = array('action' => 2, 'site_id' => 0, 'status' => 1, 'msg' => '');
        
        // check for new versions
        $request = wp_remote_get($this->rest_url.'version', $this->rest_headers);

        // check for errors
        if (is_wp_error($request)) 
        {
            $log['status'] = -1;
            $log['msg'] = __('Unable to reach the CV Outreach API: ', $this->plugin_id).$request->get_error_message();
        } 
        else if ($request['response']['code'] != 200)
        {
            $log['status'] = -2;
            $log['msg'] = __('Bad return from CV Outreach API.  Error ', $this->plugin_id).$request['response']['code']." ".$request['response']['message'];
        }
        else
        {
            // decode body of response
            $rtn = json_decode($request['body'], true);
            
            if ($rtn['status'] < 1)
            {
                $log['status'] = -3;
                $log['msg'] = __('Sorry, bad return CV Outreach API.  Please contact us.  Thanks', $this->plugin_id);
            }
            else
            {
                // if our returned version is greater then this version
                if (version_compare($this->version, $rtn['version'], '<')) 
                {
                    $log['status'] = 2;
                    $log['msg'] = "New version ".$rtn['version'];
                    
                    $obj = new stdClass();
                    $obj->slug = $this->plugin_id;
                    $obj->new_version = $rtn['version'];
                    $obj->url = $this->rest_url.'update';
                    $obj->package = $this->rest_url.'update';
                    $transient->response[$this->plugin_id.'/'.$this->plugin_id.'.php'] = $obj;
                }
            }
        }

        // log action
        $this->update_logs($log);
        
        return $transient;
    }
    
    /**
     * Retrevies all pages and HTML from CV Outreach servers
     *
     */
    public function set_site_pages($site_id)
    {
        $log = array('action' => 1, 'site_id' => $site_id, 'status' => 1, 'page_count' => 0, 'msg' => '');
        
        // get pages
        $rtn = $this->get_site_pages($site_id);
        
        // if we have a good return status update pages
        if ($rtn['status'] > 0)
        {
            // We save everything to this options
            $endpoints = get_option('_cvg_lp_connect_endpoints');

            if ((is_array($endpoints)) && (count($endpoints) > 0))
            {
                $found = 0;

                foreach($endpoints as &$ep)
                {
                    if ($ep['_cvg_lp_connect_site_id'] == $site_id)
                    {
                        $ep['_cvg_lp_connect_site_pages'] = $rtn['server']['pages'];
                        $found = 1;
                    }
                }

                if ($found)
                {
                    update_option('_cvg_lp_connect_endpoints', $endpoints, false);
                    $log['page_count'] = count($rtn['server']['pages']);
                }
            }
        }
        else
        {
            $log['status'] = $rtn['status'];
            $log['msg'] = $rtn['err'];
        }
        
        // log action
        $this->update_logs($log);
        
        return $log;
    }
    
    /**
     * Get JS file and stores locally
     * this way we don't have to link to it remotely
     *
     */
    public function get_site_js($site_id)
    {
        $js_dir = plugin_dir_path(dirname(__FILE__)).'public/libs/js/';
        $rtn = array('action' => 3, 'site_id' => $site_id, 'status' => 0, 'msg' => '');
        
        // Always delete cahce files
        // this prevents file from being write and then 
        // never updated below if something starts failing
        $this->clear_js_cache($site_id);
        
        // get pages from server
        $request = wp_remote_get(self::$js_url.$site_id.'.min.js', $this->rest_headers);

        // check for errors
        if (is_wp_error($request)) 
        {
            $rtn['status'] = -1;
            $rtn['msg'] = __('Unable to reach the CV Outreach API: ', $this->plugin_id).$request->get_error_message();
        } 
        else if ($request['response']['code'] != 200)
        {
            $rtn['status'] = -2;
            $rtn['msg'] = __('File does not exist.  Error ', $this->plugin_id).$request['response']['code']." ".$request['response']['message'];
        }
        else
        {
            $rtn['status'] = 1;
 
            // write body response to file
            file_put_contents($js_dir.'cvg_page_load_'.$site_id.'_'.time().'.min.js', $request['body']);
        }
        
        // log action
        $this->update_logs($rtn);
        
        return $rtn;
    }
    
    /**
     * Retrevies site info from CV Outreach servers
     *
     */
    public function get_site_info($site_id)
    {
        $rtn = array('action' => 5, 'site_id' => $site_id, 'status' => 0, 'msg' => '');
        
        // set url on server
        // this is a read-only value on remote side so no harm in setting
        $request = wp_remote_get($this->rest_url.'site?site_id='.$site_id, $this->rest_headers);

        // check for errors
        if (is_wp_error($request)) 
        {
            $rtn['status'] = -1;
            $rtn['msg'] = __('Unable to reach the CV Outreach API: ', $this->plugin_id).$request->get_error_message();
        } 
        else if ($request['response']['code'] != 200)
        {
            $rtn['status'] = -2;
            $rtn['msg'] = __('Bad return from CV Outreach API.  Error ', $this->plugin_id).$request['response']['code']." ".$request['response']['message'];
        }
        else
        {
            // decode body of response
            $rtn['server'] = json_decode($request['body'], true);

            if ($rtn['server']['status'] < 1)
            {
                $rtn['status'] = -3;
                $rtn['msg'] = __("Sorry, it doesn't appear your site has been setup with CV Outreach.  Please contact us.  Thanks", $this->plugin_id);
            }
            else
            {
                $rtn['status'] = 1;
                
                // We save everything to this option
                $endpoints = get_option('_cvg_lp_connect_endpoints');

                if ((is_array($endpoints)) && (count($endpoints) > 0))
                {
                    $found = 0;

                    foreach($endpoints as &$ep)
                    {
                        if ($ep['_cvg_lp_connect_site_id'] == $site_id)
                        {
                            $ep['_cvg_lp_connect_lat'] = $rtn['server']['lat'];
                            $ep['_cvg_lp_connect_lng'] = $rtn['server']['lng'];
                            $ep['_cvg_lp_connect_address'] = $rtn['server']['address'];
                            $ep['_cvg_lp_connect_locality'] = $rtn['server']['city'];
                            $ep['_cvg_lp_connect_region'] = $rtn['server']['state'];
                            $ep['_cvg_lp_connect_postal_code'] = $rtn['server']['zip'];
                            $ep['_cvg_lp_connect_country'] = $rtn['server']['country'];
                            
                            $found = 1;
                        }
                    }

                    if ($found)
                    {
                        update_option('_cvg_lp_connect_endpoints', $endpoints, false);
                    }
                }
            }
        }
        
        // log action
        $this->update_logs($rtn);
        
        return $rtn;  
    }
    
    /**
     * Sets page URL on CV Outreach servers
     *
     */
    public function site_page_url($site_id, $url)
    {
        $rtn = array('action' => 4, 'site_id' => $site_id, 'status' => 0, 'msg' => '');
        
        // set url on server
        // this is a read-only value on remote side so no harm in setting
        $request = wp_remote_get($this->rest_url.'site_url?site_id='.$site_id.'&url='.urlencode($url), $this->rest_headers);

        // check for errors
        if (is_wp_error($request)) 
        {
            $rtn['status'] = -1;
            $rtn['msg'] = __('Unable to reach the CV Outreach API: ', $this->plugin_id).$request->get_error_message();
        } 
        else if ($request['response']['code'] != 200)
        {
            $rtn['status'] = -2;
            $rtn['msg'] = __('Bad return from CV Outreach API.  Error ', $this->plugin_id).$request['response']['code']." ".$request['response']['message'];
        }
        else
        {
            // decode body of response
            $rtn['server'] = json_decode($request['body'], true);
            
            if ($rtn['server']['status'] < 1)
            {
                $rtn['status'] = -3;
                $rtn['msg'] = __("Sorry, it doesn't appear your site has been setup with CV Outreach.  Please contact us.  Thanks", $this->plugin_id);
            }
            else
            {
                $rtn['status'] = 1;
            }
        }
        
        // log action
        $this->update_logs($rtn);
        
        return $rtn;
    }
    
    /**
     * Retrevies all pages and HTML from CV Outreach servers
     *
     */
    public function get_site_pages($site_id)
    {
        $rtn = array('status' => 0);
        
        // get pages from server
        $request = wp_remote_get($this->rest_url.'pages?site_id='.$site_id.'&version='.urlencode($this->version), $this->rest_headers);

        // check for errors
        if (is_wp_error($request)) 
        {
            $rtn['status'] = -1;
            $rtn['err'] = __('Unable to reach the CV Outreach API: ', $this->plugin_id).$request->get_error_message();
        } 
        else if ($request['response']['code'] != 200)
        {
            $rtn['status'] = -2;
            $rtn['err'] = __('Bad return from CV Outreach API.  Error ', $this->plugin_id).$request['response']['code']." ".$request['response']['message'];
        }
        else
        {
            // decode body of response
            $rtn['server'] = json_decode($request['body'], true);
            
            if ($rtn['server']['status'] < 1)
            {
                $rtn['status'] = -3;
                $rtn['err'] = __("Sorry, it doesn't appear your site has been setup with CV Outreach.  Please contact us.  Thanks", $this->plugin_id);
            }
            else
            {
                $rtn['status'] = 1;
            }
        }
        
        return $rtn;
    }
    
    /**
     * writes log entries
     *
     */
    public function update_logs($log = array('action' => 0, site_id => 0, 'status' => -1, 'msg' => 'Bad fucntion call'))
    {
        $log['time'] = current_time('timestamp');
        
        // log the results
        $log_entries = get_option('_cvg_lp_connect_log');
        
        if (is_array($log_entries))
        {
            if (count($log_entries) > 99)
                array_pop($log_entries);
                
            array_unshift($log_entries, $log);
        }
        else
        {
            $log_entries = array();
            $log_entries[] = $log;
        }
        
        update_option('_cvg_lp_connect_log', $log_entries, false);
    }
    
    /**
     * Displays logs
     *
     */
    public function lp_logs()
    {
        $logs = get_option('_cvg_lp_connect_log');
        
        // print the page header
        echo '<div id="cvg_page_loader"><div id="cvg_loader"></div></div>';
        echo '<h1><img src="'.plugin_dir_url( __FILE__ ).'img/cvoutreach.png" class="logo"><br>'.__('Remote Server Logs', $this->plugin_id).'</h1>';
        echo '<ul class="list-group">';
        
        if (empty($logs))
        {
            echo '<li class="list-group-item">'.__('No logs created yet', $this->plugin_id).'</li></ul>';
            
            return;
        }

        foreach($logs as $l)
        {
            echo '
                <li class="list-group-item">
                    <span class="badge">'.date_i18n("m/d/Y H:i", $l['time']).'</span>
            ';
            
            if (isset($l['site_id']))
            {
                echo '<span class="site-id">'.$l['site_id'].' - </span>';
            }
            
            if ($l['action'] == 1)
            {
                if ($l['status'] > 0)
                {
                    printf(esc_html__('Pulled %d pages from remote server', $this->plugin_id), $l['page_count']);
                }
                else
                {
                    echo __('Error Status ', $this->plugin_id).$l['status'].__(' Pulling Pages: ', $this->plugin_id).$l['msg'];
                }
            }
            else if ($l['action'] == 2)
            {
                if ($l['status'] == 1)
                {
                    echo __('Plugin version check: No new version found', $this->plugin_id);
                }
                else if ($l['status'] == 2)
                {
                    echo __('New version of the plugin available: ', $this->plugin_id).$l['msg'];
                }
                else
                {
                    echo __('Error Status ', $this->plugin_id).$l['status'].__(' Checking Plugin Version: ', $this->plugin_id).$l['msg'];
                }
            }
            else if ($l['action'] == 3)
            {
                if ($l['status'] > 0)
                {
                    echo __('Pulled JS file from remote server', $this->plugin_id);
                }
                else
                {
                    echo __('Error Pulling JS File: ', $this->plugin_id).$l['msg'];
                }
            }
            else if ($l['action'] == 4)
            {
                if ($l['status'] > 0)
                {
                    echo __('Page URL Maintained', $this->plugin_id);
                }
                else
                {
                    echo __('Error Maintaining Page URL: ', $this->plugin_id).$l['msg'];
                }
            }
            else if ($l['action'] == 5)
            {
                if ($l['status'] > 0)
                {
                    echo __('Site Info Maintained', $this->plugin_id);
                }
                else
                {
                    echo __('Error Maintaining Site Information: ', $this->plugin_id).$l['msg'];
                }
            }
            else
            {
                echo __('Error Status ', $this->plugin_id).$l['status'].': '.$l['msg'];
            }
                    
            echo '</li>';
        }
        
        echo '</ul>';
    }
    
    /**
     * save the site page options
     *
     */
    public function save_lps()
    {
        global $wpdb;
        $rtn = array('status' => 1);
        $save_data = array();
        
        // roll through form POST data to save changes
        foreach($_POST as $k => $v)
        {
            if (strpos($k, '_cvg_lp_connect_') !== false)
            {
                $ignore = array('_cvg_lp_connect_page_slug');

                if (!in_array($k, $ignore))
                {
                    if (in_array($k, array('_cvg_lp_connect_ga','_cvg_lp_connect_ga_body')))
                    {
                        $save_data[$k] = stripslashes($v);
                    }
                    else
                    {
                        $save_data[$k] = $v;
                    }
                }
            }
        }

        // check if we need to upload an image from remote servers for selected template
        if (isset($_POST['_cvg_lp_connect_tmpl_'.$_POST['_cvg_lp_connect_tmpl']]['hbg_image']))
        {
            $hbg_image = $_POST['_cvg_lp_connect_tmpl_'.$_POST['_cvg_lp_connect_tmpl']]['hbg_image'];

            if (strpos($hbg_image, '.cvoutreach.com') !== false)
            {
                // look to see if we have already uploaded the image
                $image_id = $wpdb->get_var("SELECT ID FROM ".$wpdb->posts." WHERE post_title = '".esc_sql($hbg_image)."' AND post_type = 'attachment' limit 1");
                $post_tmpl = $_POST['_cvg_lp_connect_tmpl_'.$_POST['_cvg_lp_connect_tmpl']];

                if ($image_id > 0)
                {
                    $post_tmpl['hbg_image'] = wp_get_attachment_url($image_id);
                    $save_data['_cvg_lp_connect_tmpl_'.$_POST['_cvg_lp_connect_tmpl']] = $post_tmpl;
                }
                else
                {
                    // upload image from remote server
                    $image = media_sideload_image($hbg_image, 0, $hbg_image, 'src');

                    // if we don't have an error
                    if (!is_wp_error($image))
                    {
                        // reset the image URL in the tmpl
                        $post_tmpl['hbg_image'] = $image;
                        $save_data['_cvg_lp_connect_tmpl_'.$_POST['_cvg_lp_connect_tmpl']] = $post_tmpl;
                    }
                }
            }
        }

        // check if we need to create a new page
        if (!empty($_POST['_cvg_lp_connect_page_slug']))
        {
            $slug = $_POST['_cvg_lp_connect_page_slug'];
            $existing = get_page_by_path($slug);

            if (isset($existing->ID) && ($existing->ID > 0))
            {
                $rtn['status'] = 0;
                $rtn['err'] = sprintf(__('Sorry but the New Page Slug "%s" is already being used by page: "%s".  If you would like to use this page please select it in the "Associate with Existing Page" drop down.', $this->plugin_id), $slug, $existing->post_title);
            }
            else
            {
                $content = "\n<div id=\"cvg-page-container\">".__('Please do NOT delete this page!  If this page is deleted it will prevent the CV Outreach plugin from functioning properly and traffic coming from Google Adwords will receive an error message.  If you would like a more friendly appearance for your navigation or site links, you can change the page Title to whatever you like.', $this->plugin_id)."</div>";
                $content .= "\n<script src=\"".self::$js_url.$_POST['_cvg_lp_connect_site_id'].".min.js\" type=\"text/javascript\"></script>";

                $new_page = array(
                    'post_type' => 'page',
                    'post_title' => __('CV Outreach Placeholder LP', $this->plugin_id). " (".$save_data['_cvg_lp_connect_endpoint_name'].")",
                    'post_content' => $content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_name' => $slug
                );

                $new_id = wp_insert_post($new_page);

                if ($new_id > 0)
                {
                    $save_data['_cvg_lp_connect_page_id'] = $new_id;

                    // Check to see if page was auto added to menus
                    // If so remove it. It can always be added later
                    $menus = wp_get_nav_menus();

                    foreach ($menus as $menu) 
                    {
                        $items = wp_get_nav_menu_items($menu->term_id);

                        foreach ($items as $item)
                        {
                            if ($item->object_id == $new_id)
                            {
                                wp_delete_post($item->ID);
                            }
                        }
                    }
                }
                else
                {
                    $rtn['status'] = 0;
                    $rtn['err'] = sprintf(__('Sorry but we failed to create a New Page with a slug of "%s".', $this->plugin_id), $slug);
                }
            }
        }

        // We save everything to this options
        $endpoints = get_option('_cvg_lp_connect_endpoints');
        
        if ((is_array($endpoints)) && (count($endpoints) > 0))
        {
            $found = 0;
            
            // check to make sure page_id is not used by another page
            foreach($endpoints as $ep)
            {
                if (($ep['_cvg_lp_connect_page_id'] == $save_data['_cvg_lp_connect_page_id']) && ($ep['_cvg_lp_connect_site_id'] != $save_data['_cvg_lp_connect_site_id']))
                {
                    if ($_POST['_cvg_lp_connect_prev_page_id'] > 0)
                    {
                        $save_data['_cvg_lp_connect_page_id'] = $_POST['_cvg_lp_connect_prev_page_id'];
                    }
                    else
                    {
                        $save_data['_cvg_lp_connect_page_id'] = 0;
                    }
                    
                    $rtn['status'] = 0;
                    $rtn['err'] = sprintf(__('Sorry but the existing page selected is already used by "%s". The page change has not been saved.', $this->plugin_id), $ep['_cvg_lp_connect_endpoint_name']);
                }
            }
            
            foreach($endpoints as &$ep)
            {
                if ($ep['_cvg_lp_connect_site_id'] == $save_data['_cvg_lp_connect_site_id'])
                {
                    $ep = $save_data;
                    $found = 1;
                }
            }
            
            if (!$found)
            {
                $endpoints[] = $save_data;
            }
        }
        else
        {
            $endpoints = array($save_data);
        }

        update_option('_cvg_lp_connect_endpoints', $endpoints, false);
        
        // get remote server resources
        if (($rtn['status'] > 0) && ($_POST['_cvg_lp_connect_site_id'] > 0))
        {
            // get site pages off remote server 
            $page_rtn = $this->set_site_pages($_POST['_cvg_lp_connect_site_id']);

            if($page_rtn['status'] < 1)
            {
                $rtn['status'] = 0;
                $rtn['err'] = $page_rtn['msg'];
            }

            // get JS file off remote server
            $this->get_site_js($_POST['_cvg_lp_connect_site_id']);
        }
        
        return $rtn;
    }
    
    /**
     * Handle options page
     *
     */
    public function manage_lps()
    {        
        $available_pages = '';
        $update_rtn = array('status' => 1);
        
        // print the page header
        echo '<div id="cvg_page_loader"><div id="cvg_loader"></div></div>';
        echo '<h1><img src="'.plugin_dir_url( __FILE__ ).'img/cvoutreach.png" class="logo"><br>'.__('Landing Page Creator', $this->plugin_id).' <span id="cvg_lp_connect_site_name"></span></h1>';

        // handle the post update to set options
        if ((isset($_POST['_cvg_form_post'])) && ($_POST['_cvg_form_post'] == 1))
        {
            $update_rtn = $this->save_lps();
        }
        
        // get the endpoints that are setup
        $endpoints = get_option('_cvg_lp_connect_endpoints'); 
        $data = $this->get_endpoint_lp_options();

        // check if we have more then 1 endpoint stored
        if (is_array($endpoints))
        {
            if (isset($_GET['site_id']))
            {
                foreach($endpoints as $ep)
                {
                    if ($ep['_cvg_lp_connect_site_id'] == $_GET['site_id'])
                    {
                        $data = $this->get_endpoint_lp_options($ep);
                    }
                }
            }
        }
        
        if (!$data['_cvg_lp_connect_site_id'])
        {
            $data_old = array();
            
            // backwords compatable v1.3.6 - this is to read all the old options
            foreach(self::$lp_options as $k => $v)
            {
                $db_v = get_option($k);

                // if nothing is saved in the DB, set default values
                if ($db_v === false)
                {
                    if (strpos($k, '_cvg_lp_connect_tmpl_') !== false)
                    {
                        foreach(self::$lp_options[$k] as $tk => $tv)
                        {
                            if (!isset($data_old[$k][$tk])) 
                            {
                                $data_old[$k][$tk] = $tv['v'];
                            }
                        }
                    }
                    else
                    {
                        $data_old[$k] = $v;
                    }
                }
                else
                {
                    $data_old[$k] = $db_v;
                }
            }
            
            if ((isset($_GET['site_id'])) && ($data_old['_cvg_lp_connect_site_id'] == $_GET['site_id']))
            {
                $data = $data_old;
            }
        }
            
        // figure out what our page URL is
        $page_url = get_permalink($data['_cvg_lp_connect_page_id']);
        
        if (strpos($page_url, '?') !== false)
        {
            $preview_url = $page_url.'&preview_mode=1';
        }
        else
        {
            $preview_url = $page_url.'?preview_mode=1';
        }
        
        // if we have a page url
        if (!empty($page_url))
        {
            // update remote server with page URL
            $this->site_page_url($data['_cvg_lp_connect_site_id'], $page_url);
            $this->get_site_info($data['_cvg_lp_connect_site_id']);
            
            // get available pages and set them up with images
            if ((isset($data['_cvg_lp_connect_site_pages'])) && (!empty($data['_cvg_lp_connect_site_pages'])))
            {
                $site_pages = $data['_cvg_lp_connect_site_pages'];
            }
            else
            {
                // backwards compatible v1.3.6
                $site_pages = get_option('_cvg_lp_connect_site_pages');
            }
            
            if (is_array($site_pages))
            {
                $data['_cvg_lp_connect_site_pages'] = array_reverse($site_pages);

                $page_class = 'selected-page';
                $wrap_class = '';
                $page_images = '';

                foreach($data['_cvg_lp_connect_site_pages'] as $page)
                {
                    $available_pages .= '
                        <li>
                            <a id="_cvg_lp_connect_page_id_'.$page['id'].'" href="'.$preview_url.'&page='.$page['id'].'" target="_cvg_lp_connect_preview" class="cvg-page-preview '.$page_class.'">'.$page['title'].'</></a>
                        </li>';

                    $page_class = '';
                }
                
                $available_pages = '<ol class="available-pages">'.$available_pages.'</ol>';
            }
            else
            {
                $available_pages = '
                    <div id="cvg_error" class="alert alert-danger" role="alert">'.__('It appears there is a problem retrieving the landing pages off the CV Outreach servers. Your Landing Pages will still function correctly but some functionality of this plugin is not going to be available.<br><br>If this issue does not go away, it\'s most likely due to your hosting environment, which may be blocking the communication with cvoutreach.com. Please refer to your remote logs for more information and contact your hosting provider to have this issue fixed.', $this->plugin_id).'</div>
                ';
            }
            
            
        }
        else
        {
            $available_pages = __('Save Changes to see all available pages.', $this->plugin_id);
        }
        
        $submit_url = 'admin.php?page='.$this->plugin_id;
        
        if (isset($_GET['site_id']))
        {
            $submit_url .= '&site_id='.$_GET['site_id'];
        }
        
        // print the page body
        echo '
            <div id="cvg_error" class="alert alert-danger" role="alert">'.(($update_rtn['status'] < 1) ? $update_rtn['err'] : '').'</div>
            <div id="cvg_site_selector" class="cvg_hide">
                <div class="panel panel-default">
                    <div class="panel-heading">'.__('Multiple Pages Setup', $this->plugin_id).'</div>
                    <div id="cvg_site_selector_body" class="panel-body">
                        <p>'.__('Select one of the following to setup the Landing Page.  Both pages will need to be setup.', $this->plugin_id).'</p>
                        <div id="cvg_site_selector_list"></div>
                    </div>
                </div>
            </div>
            <div id="cvg_site_form" class="cvg_hide">
                <form method="post" action="'.$submit_url.'">
                <input type="hidden" name="_cvg_form_post" value="1">
                <input type="hidden" name="_cvg_lp_connect_site_id" id="_cvg_lp_connect_site_id" value="'.$data['_cvg_lp_connect_site_id'].'">
                <input type="hidden" name="_cvg_lp_connect_endpoint_name" id="_cvg_lp_connect_endpoint_name" value="'.$data['_cvg_lp_connect_endpoint_name'].'">
                <input type="hidden" name="_cvg_lp_connect_tmpl" id="_cvg_lp_connect_tmpl" value="'.$data['_cvg_lp_connect_tmpl'].'">
                <input type="hidden" name="cvg_lp_connect_existing_page" id="cvg_lp_connect_existing_page" value="'.$data['_cvg_lp_connect_page_id'].'">
                <div class="row"> 
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="tab active"><a href="#tab_details" aria-controls="tab_details" role="tab" data-toggle="tab">'.__('Page Details', $this->plugin_id).'</a></li>
                            <li role="presentation" class="tab"><a href="#tab_ga" aria-controls="tab_ga" role="tab" data-toggle="tab">'.__('Custom Header Code', $this->plugin_id).'</a></li>
                            <li role="presentation" class="tab"><a href="#tab_ga_body" aria-controls="tab_ga_body" role="tab" data-toggle="tab">'.__('Custom Body Code', $this->plugin_id).'</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane page-details active" id="tab_details">
                                <div class="form-group">
                                    <label for="_cvg_lp_connect_site_name">'.__('Page Title', $this->plugin_id).'</label>
                                    <input name="_cvg_lp_connect_site_name" type="text" id="_cvg_lp_connect_site_name" value="'.$data['_cvg_lp_connect_site_name'].'" class="form-control">
                                </div>
                                <p>'.__('Create a new page or associate the landing page with an existing page.  If you select an existing page, any existing content on that page is ignored and the CV Outreach template is applied.', $this->plugin_id).'</p>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="_cvg_lp_connect_page_slug">'.__('New Page Slug', $this->plugin_id).'</label>
                                            <input name="_cvg_lp_connect_page_slug" type="text" id="_cvg_lp_connect_page_slug" value="" class="form-control" placeholder="the-gospel">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="form_or">'.__('- OR -', $this->plugin_id).'</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="_cvg_lp_connect_page_page_id">'.__('Associate with Existing Page', $this->plugin_id).'</label>
                                            <input type="hidden" name="_cvg_lp_connect_prev_page_id" id="_cvg_lp_connect_prev_page_id" value="'.$data['_cvg_lp_connect_page_id'].'">
                                            '.wp_dropdown_pages(array('echo' => 0, 'show_option_none' => 'No page selected', 'option_none_value' => 0, 'name' => '_cvg_lp_connect_page_id', 'class' => 'form-control', 'id' => '_cvg_lp_connect_page_page_id', 'selected' => $data['_cvg_lp_connect_page_id'])).'
                                        </div>
                                    </div>
                                </div>
                                <p class="description">'.__('Page URL: ', $this->plugin_id).(($page_url) ? '<a href="'.$page_url.'" target=_new>'.$page_url.'</a>' : __('No url defined yet.', $this->plugin_id)).'</p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab_ga">
                                <div class="form-group">
                                    <label for="_cvg_lp_connect_ga">'.__('Custom Header Code', $this->plugin_id).'</label>
                                    <textarea name="_cvg_lp_connect_ga" type="text" rows=7 id="_cvg_lp_connect_ga" class="form-control">'.$data['_cvg_lp_connect_ga'].'</textarea>
                                    <p class="description">'.__('This code will be added to the header of the Landing Page.  Tags such as: &lt;script&gt; and &lt;style&gt; need to included.', $this->plugin_id).'</p>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab_ga_body">
                                <div class="form-group">
                                    <label for="_cvg_lp_connect_ga_body">'.__('Custom Body Code', $this->plugin_id).'</label>
                                    <textarea name="_cvg_lp_connect_ga_body" type="text" rows=7 id="_cvg_lp_connect_ga_body" class="form-control">'.$data['_cvg_lp_connect_ga_body'].'</textarea>
                                    <p class="description">'.__('This code will be added to the bottom of the Landing Page.  Tags such as: &lt;script&gt; and &lt;style&gt; need to included.', $this->plugin_id).'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default top-panel">
                            <div class="panel-heading">'.__('Available Pages Preview', $this->plugin_id).'</div>
                            <div class="panel-body">
                                '.$available_pages.'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" role="tablist">
        ';
        
        // print out template tabs
        foreach(array_reverse(self::$lp_options) as $k => $v)
        {
            if (strpos($k, '_cvg_lp_connect_tmpl_') !== false)
            {
                $t_id = intval(str_replace('_cvg_lp_connect_tmpl_', '', $k));
                echo '<li role="presentation" class="tab tab-tmpls '.(($data['_cvg_lp_connect_tmpl'] == $t_id) ? 'active' : '').'"><a href="#tab_tmpl'.$t_id.'" aria-controls="tab_tmpl'.$t_id.'" role="tab" data-toggle="tab" data-tmpl-id="'.$t_id.'">'.__('Template', $this->plugin_id).' '.$t_id.'</a></li>';
            }
        }
        
        echo '
                        </ul>
                        <div class="tab-content">
        ';
        
        // print out fields for each template setting
        foreach(self::$lp_options as $k => $v)
        {
            if (strpos($k, '_cvg_lp_connect_tmpl_') !== false)
            {
                $t_id = intval(str_replace('_cvg_lp_connect_tmpl_', '', $k));
                echo '<div role="tabpanel" class="tab-pane tmpls '.(($data['_cvg_lp_connect_tmpl'] == $t_id) ? 'active' : '').'" id="tab_tmpl'.$t_id.'">';

                foreach($v as $f => $attr)
                {
                    if ($attr['t'] == 'color')
                    {
                        if (isset($attr['trans']))
                        {
                            echo '
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="'.$k.'['.$f.']">'.$attr['l'].'</label>
                                            <div class="input-group colorpicker-component color-hex">
                                                <input name="'.$k.'['.$f.']" type="text" id="'.$k.'['.$f.']" value="'.$data[$k][$f].'" class="form-control">
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="'.$k.'['.$attr['trans'].']">'.self::$lp_options[$k][$attr['trans']]['l'].'</label>
                                            <input name="'.$k.'['.$attr['trans'].']" id="'.$k.'['.$attr['trans'].']" class="cvg-slider" data-slider-id="'.$k.'['.$attr['trans'].']" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="'.$data[$k][$attr['trans']].'"/>
                                        </div>
                                    </div>
                                    '.((isset($attr['notes'])) ? '<div class="notes">'.$attr['notes'].'</div>' : '').'
                                </div>
                            ';
                        }
                        else
                        {
                            echo '
                                <div class="form-group">
                                    <label for="'.$k.'['.$f.']">'.$attr['l'].'</label>
                                    <div class="input-group colorpicker-component color-hex">
                                        <input name="'.$k.'['.$f.']" type="text" id="'.$k.'['.$f.']" value="'.$data[$k][$f].'" class="form-control">
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                    '.((isset($attr['notes'])) ? '<div class="notes">'.$attr['notes'].'</div>' : '').'
                                </div>
                            ';
                        }
                    }
                    else if ($attr['t'] == 'img')
                    {
                        echo '
                                <div class="form-group">
                                    '.((isset($attr['img_lib'])) ? '<p class="description pull-right"><a href="#" class="default-images" data-tmpl-folder="'.$attr['img_lib'].'" data-plugin-version="'.$this->version.'" data-input="'.$k.'['.$f.']">'.__('CV Outreach Media', $this->plugin_id).'</a></p>' : '').'
                                    <label for="'.$k.'['.$f.']">'.$attr['l'].'</label>
                                    <div class="input-group">
                                        <input name="'.$k.'['.$f.']" type="text" id="'.$k.'['.$f.']" value="'.$data[$k][$f].'" class="form-control cvg-media">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></span>
                                    </div>
                                    '.((isset($attr['notes'])) ? '<div class="notes">'.$attr['notes'].'</div>' : '').'
                                </div>
                        ';
                    }
                }
                
                echo '</div>';
            }
        }
        
        echo '
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default preview-panel">
                            <div class="panel-heading">'.__('Page Preview', $this->plugin_id).'</div>
                            <div class="panel-body">
                                <div id="_cvg_lp_connect_preview_wrap">
                                    '.(($page_url) ? '<iframe id="_cvg_lp_connect_preview" name="_cvg_lp_connect_preview" src="'.$preview_url.'"></iframe>' : '').'
                                    <div id="_cvg_lp_connect_preview_disable" class="'.(($page_url) ? 'cvg_hide' : '').'"><div class="disable">'.__('Save Changes<br>to see preview.', $this->plugin_id).'</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="submit"><input type="submit" name="submit" id="_cvg_lp_connect_submit" class="button button-primary" value="'.__('Save Changes', $this->plugin_id).'"></p>
                </form>
            </div>
            <div class="modal fade" id="modal_default_images" tabindex="-1" role="dialog" aria-labelledby="my_modal_default_images">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="my_modal_default_images">'.__('CV Outreach Default Images', $this->plugin_id).'</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close', $this->plugin_id).'</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="my_modal_error">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="my_modal_error">'.__('CV Outreach Landing Page Error', $this->plugin_id).'</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">'.__('Close', $this->plugin_id).'</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="my_modal_confirm">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="my_modal_confirm">'.__('Confirm Action', $this->plugin_id).'</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" id="myModalConfirm_no" class="btn btn-default">'.__('No', $this->plugin_id).'</button>
                            <button type="button" id="myModalConfirm_yes" class="btn btn-primary">'.__('Yes', $this->plugin_id).'</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    
    /**
     * Static function to return option values for the landing page called from the public side
     * backwords compatable v1.3.6 - this is to read all the old options
     */
    public static function get_lp_options()
    {
        $o = array();
        
        foreach(self::$lp_options as $k => $v)
        {
            $db_v = get_option($k);
            
            if ($db_v === false)
            {
                $o[$k] = $v;
            }
            else
            {
                $o[$k] = $db_v;
            }
        }
    
        return $o;
    }
    
    /**
     * Static function to return option values for the landing page
     *
     */
    public function get_endpoint_lp_options($db_v = array())
    {
        $data = array();       
        
        // get all values for options
        foreach(self::$lp_options as $k => $v)
        {
            // if nothing is saved in the DB, set default values
            if (!isset($db_v[$k]))
            {
                if (strpos($k, '_cvg_lp_connect_tmpl_') !== false)
                {
                    foreach(self::$lp_options[$k] as $tk => $tv)
                    {
                        if (!isset($data[$k][$tk])) 
                        {
                            $data[$k][$tk] = $tv['v'];
                        }
                    }
                }
                else
                {
                    $data[$k] = $v;
                }
            }
            else
            {
                $data[$k] = $db_v[$k];
            }
        }
        
        return $data;
    }
    
    /**
     * Static function to clear cached JS file
     *
     */
    public static function clear_js_cache($site_id)
    {
        $js_dir = plugin_dir_path(dirname(__FILE__)).'public/libs/js/';

        // get all the JS templates that we have created
        $files = array_diff(scandir($js_dir), array('..', '.'));
        
        foreach($files as $file)
        {
            if (strpos($file, 'cvg_page_load_'.$site_id.'_') !== false)
            {
                unlink($js_dir.$file);
            }
        }
    }
    
    /**
     * Static function to return cached JS file
     * We timestamp file so we can get around any system 
     * caching that is done locally on this site
     *
     */
    public static function get_js_cache($site_id)
    {
        $js_dir = plugin_dir_path(dirname(__FILE__)).'public/libs/js/';
        $rtn = array('path' => $js_dir, 'name' => 'cvg_page_load.min.js');
        
        // get all the JS templates that we have created
        $files = array_diff(scandir($js_dir), array('..', '.'));
        
        foreach($files as $file)
        {
            if (strpos($file, 'cvg_page_load_'.$site_id.'_') !== false)
            {
                $rtn['name'] = $file;
            }
        }
        
        return $rtn;
    }
}
