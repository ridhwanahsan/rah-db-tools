<?php

namespace Rah_Db_Tools\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin
 * @author     RAH
 */
class Rah_Db_Tools_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rah_Db_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rah_Db_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rah-db-tools-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rah_Db_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rah_Db_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rah-db-tools-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		// Add top level menu
		add_menu_page(
			__( 'RAH DB Tools', 'rah-db-tools' ), 
			__( 'RAH DB Tools', 'rah-db-tools' ), 
			'manage_options', 
			'rah-db-tools', 
			array( $this, 'display_plugin_admin_page' ),
			'dashicons-database',
			30
		);

		// Add Dashboard submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'Database Viewer', 'rah-db-tools' ),
			__( 'Database Viewer', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools',
			array( $this, 'display_plugin_admin_page' )
		);

		// Add Dashboard Analysis submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'Dashboard', 'rah-db-tools' ),
			__( 'Dashboard', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools-dashboard',
			array( $this, 'display_plugin_dashboard_page' )
		);

		// Add Cleanup submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'DB Cleanup', 'rah-db-tools' ),
			__( 'DB Cleanup', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools-cleanup',
			array( $this, 'display_plugin_cleanup_page' )
		);

		// Add SQL Runner submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'SQL Runner', 'rah-db-tools' ),
			__( 'SQL Runner', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools-sql',
			array( $this, 'display_plugin_sql_page' )
		);

		// Add Scheduler submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'Scheduler', 'rah-db-tools' ),
			__( 'Scheduler', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools-scheduler',
			array( $this, 'display_plugin_scheduler_page' )
		);

		// Add Search & Replace submenu
		add_submenu_page(
			'rah-db-tools',
			__( 'Search & Replace', 'rah-db-tools' ),
			__( 'Search & Replace', 'rah-db-tools' ),
			'manage_options',
			'rah-db-tools-search-replace',
			array( $this, 'display_plugin_search_replace_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		// Include the partial for the admin page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-admin-display.php';
	}

	/**
	 * Render the dashboard page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_dashboard_page() {
		// Include the partial for the dashboard page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-dashboard-display.php';
	}

	/**
	 * Render the cleanup page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_cleanup_page() {
		// Include the partial for the cleanup page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-cleanup-display.php';
	}

	/**
	 * Render the SQL Query page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_sql_page() {
		// Include the partial for the SQL page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-sql-display.php';
	}

	/**
	 * Render the Scheduler page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_scheduler_page() {
		// Include the partial for the scheduler page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-scheduler-display.php';
	}

	/**
	 * Render the Search & Replace page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_search_replace_page() {
		// Include the partial for the search & replace page
		require_once plugin_dir_path( __FILE__ ) . 'partials/rah-db-tools-search-replace-display.php';
	}

	/**
	 * Handle database optimization.
	 *
	 * @since 1.0.0
	 */
	public function handle_optimization() {
		check_admin_referer( 'rah_db_tools_optimize', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		global $wpdb;

		if ( isset( $_POST['table'] ) ) {
			$table = sanitize_text_field( wp_unslash( $_POST['table'] ) );
			$table_escaped = esc_sql( $table );
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$result = $wpdb->query( "OPTIMIZE TABLE `$table_escaped`" );

			if ( $result ) {
				$this->log_action( "Optimized table: $table" );
				/* translators: %s: Table name */
				$message = sprintf( __( 'Table %s optimized successfully.', 'rah-db-tools' ), $table );
				$type = 'success';
			} else {
				/* translators: %s: Table name */
				$message = sprintf( __( 'Failed to optimize table %s.', 'rah-db-tools' ), $table );
				$type = 'error';
			}
		} elseif ( isset( $_POST['optimize_all'] ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$tables = $wpdb->get_results( 'SHOW TABLES', ARRAY_N );
			$count = 0;
			foreach ( $tables as $table ) {
				$table_name = $table[0];
				$table_name_escaped = esc_sql( $table_name );
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->query( "OPTIMIZE TABLE `$table_name_escaped`" );
				$count++;
			}
			
			$this->log_action( "Optimized all tables ($count tables)" );
			/* translators: %d: Number of tables */
			$message = sprintf( __( 'Optimized %d tables successfully.', 'rah-db-tools' ), $count );
			$type = 'success';
		} else {
			$message = __( 'No action specified.', 'rah-db-tools' );
			$type = 'warning';
		}

		// Redirect back to admin page with message
		// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools', 'message' => urlencode( $message ), 'type' => $type ), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Handle CSV export.
	 *
	 * @since 1.0.0
	 */
	public function handle_export() {
		check_admin_referer( 'rah_db_tools_export', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		if ( isset( $_POST['table'] ) ) {
			global $wpdb;
			$table = sanitize_text_field( wp_unslash( $_POST['table'] ) );
			$table_escaped = esc_sql( $table );
			
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$columns = $wpdb->get_col( "DESCRIBE `$table_escaped`", 0 );
			
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$rows = $wpdb->get_results( "SELECT * FROM `$table_escaped`", ARRAY_A );

			if ( empty( $rows ) ) {
				// Using simple redirect for admin actions, ensuring exit
				// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
				wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools', 'message' => urlencode( __( 'Table is empty.', 'rah-db-tools' ) ), 'type' => 'warning' ), admin_url( 'admin.php' ) ) );
				exit;
			}

			// Set headers for download
			header( 'Content-Type: text/csv; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=' . $table . '-' . gmdate( 'Y-m-d' ) . '.csv' );

			$output = fopen( 'php://output', 'w' );
			
			// Output column headers
			fputcsv( $output, $columns );
			
			// Output rows
			foreach ( $rows as $row ) {
				fputcsv( $output, $row );
			}
			
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
			fclose( $output );
			exit;
		}
	}

	/**
	 * Handle database cleanup.
	 *
	 * @since 1.0.0
	 */
	public function handle_cleanup() {
		check_admin_referer( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		global $wpdb;
		$cleanup_type = isset( $_POST['cleanup_type'] ) ? sanitize_text_field( wp_unslash( $_POST['cleanup_type'] ) ) : '';
		$count = 0;
		$message = '';
		$type = 'success';

		switch ( $cleanup_type ) {
			case 'revisions':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type = 'revision'" );
				/* translators: %d: Number of revisions */
				$message = sprintf( __( 'Deleted %d post revisions.', 'rah-db-tools' ), $count );
				break;
			case 'spam_comments':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = $wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'" );
				/* translators: %d: Number of comments */
				$message = sprintf( __( 'Deleted %d spam comments.', 'rah-db-tools' ), $count );
				break;
			case 'trashed_posts':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$count = $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_status = 'trash'" );
				/* translators: %d: Number of posts */
				$message = sprintf( __( 'Deleted %d trashed posts.', 'rah-db-tools' ), $count );
				break;
			case 'trashed_comments':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$count = $wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'" );
				/* translators: %d: Number of comments */
				$message = sprintf( __( 'Deleted %d trashed comments.', 'rah-db-tools' ), $count );
				break;
			case 'transients':
				$time_now = time();
				// Find expired transients
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$expired_transients = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s AND option_value < %d", '_transient_timeout_%', $time_now ) );
				
				$count = 0;
				if ( ! empty( $expired_transients ) ) {
					foreach ( $expired_transients as $transient ) {
						// Delete the timeout option
						delete_option( $transient );
						// Delete the data option (remove '_timeout' from the key)
						$transient_data = str_replace( '_transient_timeout_', '_transient_', $transient );
						delete_option( $transient_data );
						$count++;
					}
				}
				/* translators: %d: Number of transients */
				$message = sprintf( __( 'Deleted %d expired transients.', 'rah-db-tools' ), $count );
				break;
			case 'orphaned_postmeta':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$count = $wpdb->query( "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL" );
				/* translators: %d: Number of meta entries */
				$message = sprintf( __( 'Deleted %d orphaned post meta entries.', 'rah-db-tools' ), $count );
				break;
			case 'orphaned_commentmeta':
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$count = $wpdb->query( "DELETE cm FROM $wpdb->commentmeta cm LEFT JOIN $wpdb->comments c ON c.comment_ID = cm.comment_id WHERE c.comment_ID IS NULL" );
				/* translators: %d: Number of meta entries */
				$message = sprintf( __( 'Deleted %d orphaned comment meta entries.', 'rah-db-tools' ), $count );
				break;
			default:
				$message = __( 'Invalid cleanup type.', 'rah-db-tools' );
				$type = 'error';
		}

		if ( $count > 0 ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$this->log_action( "Cleanup: $message" );
		}

		// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-cleanup', 'message' => urlencode( $message ), 'type' => 'success' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Handle SQL Query execution.
	 *
	 * @since 1.0.0
	 */
	public function handle_sql_query() {
		check_admin_referer( 'rah_db_tools_sql_query', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		global $wpdb;
		
		if ( isset( $_POST['rah_db_tools_sql'] ) && ! empty( $_POST['rah_db_tools_sql'] ) ) {
			// We cannot sanitize_text_field because SQL needs special characters.
			// However, we must be extremely careful. This is an admin tool, so we assume admin knows what they are doing.
			$query = wp_unslash( $_POST['rah_db_tools_sql'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			
			// Basic validation to prevent empty queries
			if ( empty( trim( $query ) ) ) {
				// Using simple redirect for admin actions, ensuring exit
				// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
				wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-sql', 'message' => urlencode( __( 'Query cannot be empty.', 'rah-db-tools' ) ), 'type' => 'error' ), admin_url( 'admin.php' ) ) );
				exit;
			}

			// Execute Query
			// Check if it's a SELECT query to return results
			if ( stripos( $query, 'SELECT' ) === 0 || stripos( $query, 'SHOW' ) === 0 || stripos( $query, 'DESCRIBE' ) === 0 ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.PreparedSQL.NotPrepared
				$results = $wpdb->get_results( $query, ARRAY_A );
				
				if ( $wpdb->last_error ) {
					$message = __( 'SQL Error: ', 'rah-db-tools' ) . $wpdb->last_error;
					$type = 'error';
				} else {
					// Store results in a transient to display on the page
					set_transient( 'rah_db_tools_query_results_' . get_current_user_id(), $results, 60 );
					$message = __( 'Query executed successfully.', 'rah-db-tools' );
					$type = 'success';
					
					// Log the read query (optional, maybe too verbose)
					$this->log_action( "Executed SQL Query: $query" );
					
					// Using simple redirect for admin actions, ensuring exit
					// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
					wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-sql', 'message' => urlencode( $message ), 'type' => $type, 'query_results' => 1 ), admin_url( 'admin.php' ) ) );
					exit;
				}
			} else {
				// INSERT, UPDATE, DELETE, etc.
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.PreparedSQL.NotPrepared
				$result = $wpdb->query( $query );
				
				if ( $result === false ) {
					$message = __( 'SQL Error: ', 'rah-db-tools' ) . $wpdb->last_error;
					$type = 'error';
				} else {
					/* translators: %d: Number of rows affected */
					$message = sprintf( __( 'Query executed successfully. Rows affected: %d', 'rah-db-tools' ), $result );
					$type = 'success';
					$this->log_action( "Executed SQL Query: $query" );
				}
			}

			// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-sql', 'message' => urlencode( $message ), 'type' => $type ), admin_url( 'admin.php' ) ) );
		exit;
	} else {
			// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-sql', 'message' => urlencode( __( 'No query provided.', 'rah-db-tools' ) ), 'type' => 'warning' ), admin_url( 'admin.php' ) ) );
		exit;
	}
	}

	/**
	 * Handle scheduler settings save.
	 *
	 * @since 1.0.0
	 */
	public function handle_scheduler_save() {
		check_admin_referer( 'rah_db_tools_scheduler', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		$scheduler_enabled = isset( $_POST['scheduler_enabled'] ) ? 1 : 0;
		$scheduler_frequency = isset( $_POST['scheduler_frequency'] ) ? sanitize_text_field( wp_unslash( $_POST['scheduler_frequency'] ) ) : 'weekly';
		$scheduler_tasks = isset( $_POST['scheduler_tasks'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['scheduler_tasks'] ) ) : array();

		update_option( 'rah_db_tools_scheduler_enabled', $scheduler_enabled );
		update_option( 'rah_db_tools_scheduler_frequency', $scheduler_frequency );
		update_option( 'rah_db_tools_scheduler_tasks', $scheduler_tasks );

		// Clear existing schedule
		$timestamp = wp_next_scheduled( 'rah_db_tools_scheduled_cleanup' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'rah_db_tools_scheduled_cleanup' );
		}

		// Set new schedule if enabled
		if ( $scheduler_enabled ) {
			wp_schedule_event( time(), $scheduler_frequency, 'rah_db_tools_scheduled_cleanup' );
			$message = __( 'Scheduler settings saved and cron job updated.', 'rah-db-tools' );
		} else {
			$message = __( 'Scheduler disabled.', 'rah-db-tools' );
		}

		$this->log_action( $message );

		// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-scheduler', 'message' => urlencode( $message ), 'type' => 'success' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Execute scheduled tasks.
	 *
	 * @since 1.0.0
	 */
	public function execute_scheduled_tasks() {
		$tasks = get_option( 'rah_db_tools_scheduler_tasks', array() );
		global $wpdb;

		if ( empty( $tasks ) ) {
			return;
		}

		$log_messages = array();

		if ( in_array( 'optimize_tables', $tasks ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$tables = $wpdb->get_results( 'SHOW TABLES', ARRAY_N );
			foreach ( $tables as $table ) {
				$table_name = $table[0];
				$table_name_escaped = esc_sql( $table_name );
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->query( "OPTIMIZE TABLE `$table_name_escaped`" );
			}
			$log_messages[] = "Optimized all tables";
		}

		if ( in_array( 'revisions', $tasks ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type = 'revision'" );
			if ( $count > 0 ) $log_messages[] = "Deleted $count revisions";
		}

		if ( in_array( 'spam_comments', $tasks ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count = $wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'" );
			if ( $count > 0 ) $log_messages[] = "Deleted $count spam comments";
		}

		if ( in_array( 'trashed_items', $tasks ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count_posts = $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_status = 'trash'" );
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$count_comments = $wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'" );
			if ( $count_posts > 0 || $count_comments > 0 ) $log_messages[] = "Deleted $count_posts trashed posts and $count_comments trashed comments";
		}

		if ( in_array( 'transients', $tasks ) ) {
			$time_now = time();
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$expired_transients = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s AND option_value < %d", '_transient_timeout_%', $time_now ) );
			
			$count = 0;
			if ( ! empty( $expired_transients ) ) {
				foreach ( $expired_transients as $transient ) {
					delete_option( $transient );
					$transient_data = str_replace( '_transient_timeout_', '_transient_', $transient );
					delete_option( $transient_data );
					$count++;
				}
			}
			if ( $count > 0 ) $log_messages[] = "Deleted $count expired transients";
		}

		if ( ! empty( $log_messages ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$this->log_action( "Scheduled Run: " . implode( ', ', $log_messages ) );
		}
	}

	/**
	 * Handle Search & Replace.
	 *
	 * @since 1.0.0
	 */
	public function handle_search_replace() {
		check_admin_referer( 'rah_db_tools_search_replace', 'rah_db_tools_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'rah-db-tools' ) );
		}

		global $wpdb;

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$search_str = isset( $_POST['search_str'] ) ? wp_unslash( $_POST['search_str'] ) : '';
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$replace_str = isset( $_POST['replace_str'] ) ? wp_unslash( $_POST['replace_str'] ) : '';
		$tables = isset( $_POST['tables'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['tables'] ) ) : array();
		$dry_run = isset( $_POST['dry_run'] ) ? 1 : 0;

		if ( empty( $search_str ) ) {
			// Using simple redirect for admin actions, ensuring exit
			// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
			wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-search-replace', 'message' => urlencode( __( 'Search term cannot be empty.', 'rah-db-tools' ) ), 'type' => 'error' ), admin_url( 'admin.php' ) ) );
			exit;
		}

		if ( empty( $tables ) ) {
			// Using simple redirect for admin actions, ensuring exit
			// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
			wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-search-replace', 'message' => urlencode( __( 'Please select at least one table.', 'rah-db-tools' ) ), 'type' => 'error' ), admin_url( 'admin.php' ) ) );
			exit;
		}

		$total_rows_affected = 0;
		$total_cells_affected = 0;
		$log_details = array();

		foreach ( $tables as $table ) {
			$table = esc_sql( $table );
			// Get columns for the table
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$columns = $wpdb->get_results( "DESCRIBE `$table`", ARRAY_A );
			$pk = '';
			$text_columns = array();

			foreach ( $columns as $col ) {
				if ( $col['Key'] == 'PRI' ) {
					$pk = esc_sql( $col['Field'] );
				}
				// Only search in text-based columns
				if ( preg_match( '/char|text|blob/i', $col['Type'] ) ) {
					$text_columns[] = esc_sql( $col['Field'] );
				}
			}

			if ( empty( $pk ) || empty( $text_columns ) ) {
				continue;
			}

			// Process rows
			// To avoid memory issues, we process in chunks
			$limit = 1000;
			$offset = 0;
			$table_rows_affected = 0;

			while ( true ) {
				$query = "SELECT `$pk`, `" . implode( "`, `", $text_columns ) . "` FROM `$table` LIMIT %d OFFSET %d";
				// Column names are already escaped with esc_sql()
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, PluginCheck.Security.DirectDB.UnescapedDBParameter, WordPress.DB.PreparedSQL.NotPrepared
				$rows = $wpdb->get_results( $wpdb->prepare( $query, $limit, $offset ), ARRAY_A );

				if ( empty( $rows ) ) {
					break;
				}

				foreach ( $rows as $row ) {
					$update_row = false;
					$update_data = array();

					foreach ( $text_columns as $col ) {
						$data = $row[ $col ];
						if ( is_string( $data ) && strpos( $data, $search_str ) !== false ) {
							// Found a match
							
							// Handle serialized data
							if ( is_serialized( $data ) ) {
								$unserialized = @unserialize( $data );
								if ( $unserialized !== false ) {
									$this->recursive_str_replace( $search_str, $replace_str, $unserialized );
									$new_data = serialize( $unserialized );
								} else {
									// Serialization failed or not actually serialized
									$new_data = str_replace( $search_str, $replace_str, $data );
								}
							} else {
								$new_data = str_replace( $search_str, $replace_str, $data );
							}

							if ( $data !== $new_data ) {
								$update_row = true;
								$update_data[ $col ] = $new_data;
								$total_cells_affected++;
							}
						}
					}

					if ( $update_row ) {
						$table_rows_affected++;
						if ( ! $dry_run ) {
							// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
							$wpdb->update( $table, $update_data, array( $pk => $row[ $pk ] ) );
						}
					}
				}

				$offset += $limit;
			}
			
			if ( $table_rows_affected > 0 ) {
				$total_rows_affected += $table_rows_affected;
				$log_details[] = "$table ($table_rows_affected rows)";
			}
		}

		if ( $dry_run ) {
			/* translators: 1: Number of rows, 2: Number of cells */
			$message = sprintf( __( 'Dry Run Completed: %1$d rows would be updated across %2$d cells.', 'rah-db-tools' ), $total_rows_affected, $total_cells_affected );
			$type = 'warning';
		} else {
			/* translators: 1: Number of rows, 2: Number of cells */
			$message = sprintf( __( 'Search & Replace Completed: %1$d rows updated across %2$d cells.', 'rah-db-tools' ), $total_rows_affected, $total_cells_affected );
			$type = 'success';
			if ( $total_rows_affected > 0 ) {
				$this->log_action( "Search & Replace: Replaced '$search_str' with '$replace_str'. Details: " . implode( ', ', $log_details ) );
			}
		}

		// Using simple redirect for admin actions, ensuring exit
		// phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		wp_redirect( add_query_arg( array( 'page' => 'rah-db-tools-search-replace', 'message' => urlencode( $message ), 'type' => $type ), admin_url( 'admin.php' ) ) );
		exit;
	}

	/**
	 * Recursive string replace helper for arrays/objects.
	 *
	 * @param string $search
	 * @param string $replace
	 * @param mixed $subject
	 */
	private function recursive_str_replace( $search, $replace, &$subject ) {
		if ( is_string( $subject ) ) {
			$subject = str_replace( $search, $replace, $subject );
		} elseif ( is_array( $subject ) ) {
			foreach ( $subject as &$value ) {
				$this->recursive_str_replace( $search, $replace, $value );
			}
			unset( $value );
		} elseif ( is_object( $subject ) ) {
			$vars = get_object_vars( $subject );
			foreach ( $vars as $key => $val ) {
				$this->recursive_str_replace( $search, $replace, $subject->$key );
			}
		}
	}

	/**
	 * Log actions to a file or database option.
	 * For simplicity, we'll use error_log or a custom log file in uploads.
	 * The user requirement: "Log all optimization actions (table name, user, timestamp)."
	 * Let's log to a custom log file in wp-content/uploads/rah-db-tools-logs/
	 *
	 * @since 1.0.0
	 * @param string $message The message to log.
	 */
	private function log_action( $message ) {
		$user = wp_get_current_user();
		$user_login = $user->user_login;
		$timestamp = gmdate( 'Y-m-d H:i:s' );
		$log_entry = "[$timestamp] User: $user_login | Action: $message" . PHP_EOL;

		$upload_dir = wp_upload_dir();
		$log_dir = $upload_dir['basedir'] . '/rah-db-tools-logs';
		
		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}

		// Create .htaccess to protect logs
		if ( ! file_exists( $log_dir . '/.htaccess' ) ) {
			file_put_contents( $log_dir . '/.htaccess', 'deny from all' );
		}

		if ( ! file_exists( $log_dir . '/index.php' ) ) {
			file_put_contents( $log_dir . '/index.php', '<?php // Silence is golden' );
		}

		$log_file = $log_dir . '/optimization.log';
		file_put_contents( $log_file, $log_entry, FILE_APPEND | LOCK_EX );
	}

}
