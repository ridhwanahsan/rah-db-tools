<?php

namespace Rah_Db_Tools\Includes;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/includes
 * @author     RAH
 */
class Rah_Db_Tools_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Deactivation logic here (e.g., unschedule cron jobs)
		$timestamp = wp_next_scheduled( 'rah_db_tools_scheduled_cleanup' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'rah_db_tools_scheduled_cleanup' );
		}
	}

}
