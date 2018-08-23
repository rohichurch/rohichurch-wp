<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    cvg_lp_connect
 * @subpackage cvg_lp_connect/includes
 */
class cvg_lp_connect {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @access   protected
     * @var      cvg_lp_connect_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @access   protected
     * @var      string    $plugin_id    The string used to uniquely identify this plugin.
     */
    protected $plugin_id;

    /**
     * The current version of the plugin.
     *
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     */
    public function __construct() 
    {
        $this->plugin_id = 'cvg-lp-connect';
        $this->version = '1.4.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - cvg_lp_connect_Loader. Orchestrates the hooks of the plugin.
     * - cvg_lp_connect_i18n. Defines internationalization functionality.
     * - cvg_lp_connect_Admin. Defines all hooks for the admin area.
     * - cvg_lp_connect_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @access   private
     */
    private function load_dependencies() 
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cvg-lp-connect-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cvg-lp-connect-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cvg-lp-connect-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cvg-lp-connect-public.php';

        $this->loader = new cvg_lp_connect_loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the cvg_lp_connect_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @access   private
     */
    private function set_locale() 
    {
        $plugin_i18n = new cvg_lp_connect_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @access   private
     */
    private function define_admin_hooks() 
    {
        $plugin_admin = new cvg_lp_connect_admin( $this->get_cvg_lp_connect(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_includes', 1 );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access   private
     */
    private function define_public_hooks() 
    {
        $plugin_public = new cvg_lp_connect_public( $this->get_cvg_lp_connect(), $this->get_version() );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     */
    public function run() 
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_cvg_lp_connect() 
    {
        return $this->plugin_id;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    cvg_lp_connect_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() 
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version() 
    {
        return $this->version;
    }

}
