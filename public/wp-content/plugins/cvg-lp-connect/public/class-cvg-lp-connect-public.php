<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/public
 */
class cvg_lp_connect_public 
{
    /**
     * The ID of this plugin.
     *
     */
    private $plugin_id;

    /**
     * The version of this plugin.
     *
     */
    private $version;
    
    /**
     * The options for endpoint.
     *
     */
    private static $options = array();

    /**
     * Initialize the class and set its properties.
     *
     */
    public function __construct( $plugin_id, $version ) 
    {
        $this->plugin_id = $plugin_id;
        $this->version = $version;

        // add custom template for landing pages
        add_filter('template_include', array($this, 'lp_theme_tmpl'));
        
        // the autoptimize plugin does not play well, so make sure to ignore it
        add_filter('autoptimize_filter_noptimize', array($this, 'lp_noptimize'),10,0);
    }
    
    /**
     * prevent page from being optimized by the autoptimize plugin
     *
     */
    public function lp_noptimize()
    {
        global $post;
        
        // Prevent our page from being optimized
        if ($post->ID == get_option('_cvg_lp_connect_page_id'))
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    /**
     * Adds hook to the page that is selected for the landing pages
     *
     */
    public function lp_theme_tmpl($t)
    {
        global $post;
        
        // if this is our page then highjack it with our tmpl
        if ($post)
        {
            $endpoints = get_option('_cvg_lp_connect_endpoints');
            
            if (is_array($endpoints))
            {
                foreach($endpoints as $ep)
                {
                    if ($post->ID == $ep['_cvg_lp_connect_page_id'])
                    {
                        self::$options = $ep;
                        $t = plugin_dir_path( __FILE__ ) . 'tmpls/'.$ep['_cvg_lp_connect_tmpl'].'/cvg-lp-connect-tmpl.php';
                    }
                }
                
                // backwords compatable v1.3.6 - this is to read all the old options
                if ((empty(self::$options)) && ($post->ID == get_option('_cvg_lp_connect_page_id')))
                {
                    $t = plugin_dir_path( __FILE__ ) . 'tmpls/'.get_option('_cvg_lp_connect_tmpl').'/cvg-lp-connect-tmpl.php';
                }
            }
            // backwords compatable v1.3.6 - this is to read all the old options
            else if ($post->ID == get_option('_cvg_lp_connect_page_id'))
            {
                $t = plugin_dir_path( __FILE__ ) . 'tmpls/'.get_option('_cvg_lp_connect_tmpl').'/cvg-lp-connect-tmpl.php';
            }
        }
            
        return $t;
    }
    
    /**
     * Called from the templates and return all page values
     *
     */
    public static function get_setup()
    {
        $rtn = array('error' => 0);
        
        // get all options & tmpl
        if (!empty(self::$options))
        {
            $rtn['opt'] = self::$options;
        }
        // backwords compatable v1.3.6 - this is to read all the old options
        else
        {
            $rtn['opt'] = cvg_lp_connect_admin::get_lp_options();
        }
        
        $rtn['tmpl'] = $rtn['opt']['_cvg_lp_connect_tmpl_'.$rtn['opt']['_cvg_lp_connect_tmpl']];
        
        if (!is_array($rtn['tmpl']))
        {
            $rtn['error'] = 1;
        }
        else
        {
            foreach($rtn['tmpl'] as $k => $v)
            {
                if (strpos($k, 'color') !== false)
                {
                    list($r, $g, $b) = sscanf($v, "#%02x%02x%02x");
                    $rtn['tmpl'][$k] = $r.','.$g.','.$b;
                }
                else if (strpos($k, 'trans') !== false)
                {
                    if ($v == 10)
                    {
                        $trans = '1';
                    }
                    else if ($v == 0)
                    {
                        $trans = '0';
                    }
                    else
                    {
                        $trans = '0.'.$v;
                    }
                    
                    $rtn['tmpl'][$k] = $trans;
                }
            }
        }

        // get lib dir
        $rtn['libd'] = plugins_url('/libs', __FILE__ );
        
        // check if our JS file exists
        $js_cache = cvg_lp_connect_admin::get_js_cache($rtn['opt']['_cvg_lp_connect_site_id']);
        
        if(file_exists($js_cache['path'].$js_cache['name']))
        {  
            $rtn['js_file'] = $rtn['libd'].'/js/'.$js_cache['name'];
        }
        else
        {
            $rtn['js_file'] = cvg_lp_connect_admin::$js_url.$rtn['opt']['_cvg_lp_connect_site_id'].'.min.js';
        }
        
        $rtn['pages'] = array();

        // get pages
        if (!empty(self::$options))
        {
            if (isset(self::$options['_cvg_lp_connect_site_pages']))
            {
                $rtn['pages'] = self::$options['_cvg_lp_connect_site_pages'];
            }
        }
        // backwords compatable v1.3.6 - this is to read all the old options
        else
        {
            $rtn['pages'] = get_option('_cvg_lp_connect_site_pages');
        }

        if (!empty($rtn['pages']))
        {
            // get page base on url parameter
            if (isset($_GET['page']))
            {
                foreach($rtn['pages'] as $p)
                {
                    if ($p['id'] == $_GET['page'])
                    {
                        $rtn['page'] = $p;
                    }
                }
            }

            // if we don't have a page from url parameter
            // then get default page by using the last page
            if (empty($rtn['page']))
            {
                $rtn['page'] = array_pop($rtn['pages']);
            }
            
            // figure out banner image
            if (!empty($rtn['page']['image']))
            {
                $rtn['banner_image'] = $rtn['page']['image'];
            }
            else if (isset($rtn['tmpl']['hbg_image']))
            {
                $rtn['banner_image'] = $rtn['tmpl']['hbg_image'];
            }

            // get page title if one doesn't exist
            if (!$rtn['page']['title'])
            {
                if(preg_match('/<div[^>]*?header\-text[^<]*?<h1>([^<]*?)<\/h1>/i', $rtn['page']['content'], $m))
                {
                    $t = trim($m[1]);
                    $t = preg_replace('/\n/', '', $t);
                    
                    $rtn['page']['title'] = htmlspecialchars($t);
                }
            }
            else
            {
                $rtn['page']['title'] = htmlspecialchars($rtn['page']['title']);
            }

            // set page description.
            if (preg_match('/<div[^>]*?top\-text[^<]*?<p>([^<]*?)<\/p>/i', $rtn['page']['content'], $m))
            {
                $rtn['page']['desc'] = trim($m[1]);
                $rtn['page']['desc'] = preg_replace('/\n/', '', $rtn['page']['desc']);
                
                if ((strlen($rtn['page']['desc']) > 157) && (preg_match('/^.{1,157}\b/s', $rtn['page']['desc'], $match)))
                {
                    $rtn['page']['desc'] = trim($match[0])."...";
                }
                
                $rtn['page']['desc'] = htmlspecialchars($rtn['page']['desc']);
            }
            
            if (isset($rtn['page']['kw']))
            {
                $rtn['page']['kw'] = htmlspecialchars($rtn['page']['kw']);
            }
        }
        // Some WP sites have problems with curl calls
        // if we have at least a site ID we can still render the page
        // The page is rendered by the remote JS file
        else if (intval($rtn['opt']['_cvg_lp_connect_site_id']) > 100)
        {
            $rtn['page'] = array();
            
            // get page base on url parameter
            if (isset($_GET['page']))
            {
                $rtn['page']['title'] = $_GET['page'];
            }
            
            $rtn['page']['content'] = __('Loading...', 'cvg-lp-connect');
        }
        else
        {
            $rtn['error'] = 1;
        }
        
        if ($rtn['error'])
        {
            $rtn['page'] = array();
            $rtn['page']['title'] = __('Error', 'cvg-lp-connect');
            $rtn['page']['desc'] = __('Sorry, but the page has not been setup yet.', 'cvg-lp-connect');
        }
        
        return $rtn;
    }
    
    /**
     * Minimize CSS for the templates
     *
     */
    public static function css_str_replace($css)
    {
        $css = trim($css);
        $css = preg_replace('/\t/', "", $css);
        $css = preg_replace('/\r/', "", $css);
        $css = preg_replace('/\n/', " ", $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = preg_replace('/{\s+/', '{', $css);
        $css = preg_replace('/\s+{/', '{', $css);
        $css = preg_replace('/\s+}/', '}', $css);
        $css = preg_replace('/}\s+/', '}', $css);
        $css = preg_replace('/;\s+/', ';', $css);
        $css = preg_replace('/:\s+/', ':', $css);
        $css = preg_replace('/,\s+/', ',', $css);

        return $css;
    }
}
