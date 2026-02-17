<?php
/**
 * Plugin Name:       RAH DB Tools – Database Viewer & Optimization
 * Plugin URI:        https://github.com/ridhwanahsan/rah-db-tools
 * Description:       A comprehensive database management tool for WordPress. View tables, optimize database, and more.
 * Version:           1.0.0
 * Author:            ridhwanahsan
 * Author URI:        https://github.com/ridhwanahsan
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Contributors:      ridhwanahsann
 * Text Domain:       rah-db-tools
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 *
 * @package           Rah_Db_Tools
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'RAH_DB_TOOLS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rah-db-tools-activator.php
 */
function rah_db_tools_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rah-db-tools-activator.php';
	Rah_Db_Tools\Includes\Rah_Db_Tools_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rah-db-tools-deactivator.php
 */
function rah_db_tools_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rah-db-tools-deactivator.php';
	Rah_Db_Tools\Includes\Rah_Db_Tools_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'rah_db_tools_activate' );
register_deactivation_hook( __FILE__, 'rah_db_tools_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rah-db-tools.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function rah_db_tools_run() {

	$plugin = new Rah_Db_Tools\Includes\Rah_Db_Tools();
	$plugin->run();

}
rah_db_tools_run();
