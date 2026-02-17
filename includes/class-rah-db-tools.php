<?php

namespace Rah_Db_Tools\Includes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/includes
 * @author     RAH
 */
class Rah_Db_Tools {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Rah_Db_Tools_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'RAH_DB_TOOLS_VERSION' ) ) {
			$this->version = RAH_DB_TOOLS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'rah-db-tools';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Rah_Db_Tools_Loader. Orchestrates the hooks of the plugin.
	 * - Rah_Db_Tools_i18n. Defines internationalization functionality.
	 * - Rah_Db_Tools_Admin. Defines all hooks for the admin area.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rah-db-tools-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rah-db-tools-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rah-db-tools-admin.php';

		$this->loader = new Rah_Db_Tools_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rah_Db_Tools_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Rah_Db_Tools_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new \Rah_Db_Tools\Admin\Rah_Db_Tools_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Handle AJAX actions if needed, or form submissions
		// For now, simple form handling in the admin page logic or via hooks
		$this->loader->add_action( 'admin_post_rah_db_tools_optimize', $plugin_admin, 'handle_optimization' );
		$this->loader->add_action( 'admin_post_rah_db_tools_export', $plugin_admin, 'handle_export' );
		$this->loader->add_action( 'admin_post_rah_db_tools_cleanup', $plugin_admin, 'handle_cleanup' );
		$this->loader->add_action( 'admin_post_rah_db_tools_sql_query', $plugin_admin, 'handle_sql_query' );
		$this->loader->add_action( 'admin_post_rah_db_tools_scheduler', $plugin_admin, 'handle_scheduler_save' );
		$this->loader->add_action( 'admin_post_rah_db_tools_search_replace', $plugin_admin, 'handle_search_replace' );

		// Register Cron Job Handler
		$this->loader->add_action( 'rah_db_tools_scheduled_cleanup', $plugin_admin, 'execute_scheduled_tasks' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Rah_Db_Tools_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
