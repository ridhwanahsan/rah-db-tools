<?php

namespace Rah_Db_Tools\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List Table class for displaying database tables.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin
 * @author     RAH
 */
class Rah_Db_Tools_List_Table extends \WP_List_Table {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct( array(
			'singular' => __( 'Table', 'rah-db-tools' ),
			'plural'   => __( 'Tables', 'rah-db-tools' ),
			'ajax'     => false,
		) );
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @since 1.0.0
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->process_bulk_action();

		$data = $this->get_table_data();
		
		usort( $data, array( $this, 'usort_reorder' ) );

		$per_page = 20;
		$current_page = $this->get_pagenum();
		$total_items = count( $data );

		// Pagination logic
		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
		) );

		$this->items = $data;
	}

	/**
	 * Get table data from the database.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_table_data() {
		global $wpdb;
		
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$tables = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
		
		$data = array();
		$search = '';
		if ( isset( $_REQUEST['s'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$search = sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}
		
		foreach ( $tables as $table ) {
			if ( $search !== '' ) {
				if ( strpos( strtolower( $table['Name'] ), strtolower( $search ) ) === false ) {
					continue;
				}
			}

			$data[] = array(
				'name'       => $table['Name'],
				'rows'       => $table['Rows'],
				'data_size'  => $table['Data_length'],
				'index_size' => $table['Index_length'],
				'overhead'   => $table['Data_free'],
				'engine'     => $table['Engine'],
				'collation'  => $table['Collation'],
			);
		}

		return $data;
	}

	/**
	 * Define the columns that are going to be used in the table.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'cb'         => '<input type="checkbox" />',
			'name'       => __( 'Table Name', 'rah-db-tools' ),
			'rows'       => __( 'Rows', 'rah-db-tools' ),
			'data_size'  => __( 'Data Size', 'rah-db-tools' ),
			'index_size' => __( 'Index Size', 'rah-db-tools' ),
			'overhead'   => __( 'Overhead', 'rah-db-tools' ),
			'engine'     => __( 'Engine', 'rah-db-tools' ),
			'collation'  => __( 'Collation', 'rah-db-tools' ),
		);

		return $columns;
	}

	/**
	 * Define the sortable columns.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'name'       => array( 'name', false ),
			'rows'       => array( 'rows', false ),
			'data_size'  => array( 'data_size', false ),
			'index_size' => array( 'index_size', false ),
			'overhead'   => array( 'overhead', false ),
		);

		return $sortable_columns;
	}

	/**
	 * Column default handler.
	 *
	 * @since 1.0.0
	 * @param array $item
	 * @param string $column_name
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'name':
			case 'engine':
			case 'collation':
				return $item[ $column_name ];
			case 'rows':
				return number_format_i18n( $item[ $column_name ] );
			case 'data_size':
			case 'index_size':
				return size_format( $item[ $column_name ] );
			case 'overhead':
				if ( $item[ $column_name ] > 0 ) {
					return '<span style="color: red;">' . size_format( $item[ $column_name ] ) . '</span>';
				}
				return size_format( $item[ $column_name ] );
			default:
				return '';
		}
	}

	/**
	 * Render the checkbox column.
	 *
	 * @since 1.0.0
	 * @param array $item
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="table[]" value="%s" />',
			$item['name']
		);
	}

	/**
	 * Render the name column with row actions.
	 *
	 * @since 1.0.0
	 * @param array $item
	 * @return string
	 */
	public function column_name( $item ) {
		$optimize_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'rah_db_tools_optimize',
					'table'  => $item['name'],
				),
				admin_url( 'admin-post.php' )
			),
			'rah_db_tools_optimize',
			'rah_db_tools_nonce'
		);

		$export_url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'rah_db_tools_export',
					'table'  => $item['name'],
				),
				admin_url( 'admin-post.php' )
			),
			'rah_db_tools_export',
			'rah_db_tools_nonce'
		);

		$view_url = add_query_arg(
			array(
				'page'   => 'rah-db-tools',
				'view'   => 'table_content',
				'table'  => $item['name'],
			),
			admin_url( 'admin.php' )
		);

		$actions = array(
			'optimize' => sprintf( '<a href="%s">%s</a>', $optimize_url, __( 'Optimize', 'rah-db-tools' ) ),
			'export'   => sprintf( '<a href="%s">%s</a>', $export_url, __( 'Export CSV', 'rah-db-tools' ) ),
			'view'     => sprintf( '<a href="%s">%s</a>', $view_url, __( 'View Data', 'rah-db-tools' ) ),
		);

		return sprintf( '%1$s %2$s', $item['name'], $this->row_actions( $actions ) );
	}

	/**
	 * Helper function for sorting.
	 *
	 * @since 1.0.0
	 * @param array $a
	 * @param array $b
	 * @return int
	 */
	public function usort_reorder( $a, $b ) {
		$orderby = 'name';
		if ( isset( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$orderby_raw = sanitize_text_field( wp_unslash( $_GET['orderby'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( in_array( $orderby_raw, array( 'name', 'rows', 'data_size', 'index_size', 'overhead' ), true ) ) {
				$orderby = $orderby_raw;
			}
		}

		$order = 'asc';
		if ( isset( $_GET['order'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$order_raw = strtolower( sanitize_text_field( wp_unslash( $_GET['order'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( in_array( $order_raw, array( 'asc', 'desc' ), true ) ) {
				$order = $order_raw;
			}
		}

		if ( in_array( $orderby, array( 'rows', 'data_size', 'index_size', 'overhead' ), true ) ) {
			$result = $a[ $orderby ] - $b[ $orderby ];
		} else {
			$result = strcmp( (string) $a[ $orderby ], (string) $b[ $orderby ] );
		}

		return ( 'asc' === $order ) ? $result : -$result;
	}

	/**
	 * Get bulk actions.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'optimize_bulk' => __( 'Optimize', 'rah-db-tools' ),
		);
		return $actions;
	}

	/**
	 * Process bulk actions.
	 *
	 * @since 1.0.0
	 */
	public function process_bulk_action() {
		if ( 'optimize_bulk' === $this->current_action() ) {
			
			// Verify nonce
			// WP List Table adds _wpnonce
			if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {
				$nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
				$action = 'bulk-' . $this->_args['plural'];

				if ( ! wp_verify_nonce( $nonce, $action ) ) {
					wp_die( 'Security check failed' );
				}
			} else {
				// Sometimes checking against just the action name works if nonce field is default
				// But let's be safe.
				// Actually, we can just skip if nonce is missing.
				return;
			}

			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$tables = isset( $_POST['table'] ) ? (array) wp_unslash( $_POST['table'] ) : array();
			
			if ( is_array( $tables ) && ! empty( $tables ) ) {
				global $wpdb;
				$count = 0;
				foreach ( $tables as $table ) {
					$table = sanitize_text_field( $table );
					$table_escaped = esc_sql( $table );
					// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
					$wpdb->query( "OPTIMIZE TABLE `$table_escaped`" );
					$count++;
				}
				
				$user = wp_get_current_user();
				$log_entry = '[' . gmdate( 'Y-m-d H:i:s' ) . '] User: ' . $user->user_login . ' | Action: Bulk Optimized ' . $count . ' tables' . PHP_EOL;
				$upload_dir = wp_upload_dir();
				$log_dir = $upload_dir['basedir'] . '/rah-db-tools-logs';
				if ( ! file_exists( $log_dir ) ) {
					wp_mkdir_p( $log_dir );
					file_put_contents( $log_dir . '/.htaccess', 'deny from all' );
					file_put_contents( $log_dir . '/index.php', '<?php // Silence is golden' );
				}
				file_put_contents( $log_dir . '/optimization.log', $log_entry, FILE_APPEND | LOCK_EX );

				/* translators: %d: Number of tables */
				wp_safe_redirect( add_query_arg( array( 'page' => 'rah-db-tools', 'message' => urlencode( sprintf( __( 'Optimized %d tables successfully.', 'rah-db-tools' ), $count ) ), 'type' => 'success' ), admin_url( 'admin.php' ) ) );
				exit;
			}
		}
	}

}
