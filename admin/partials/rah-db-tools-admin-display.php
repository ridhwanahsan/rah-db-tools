<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a Dashboard view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

// Check if we are viewing table content
$rah_db_tools_view = isset( $_GET['view'] ) ? sanitize_text_field( wp_unslash( $_GET['view'] ) ) : 'list'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$rah_db_tools_table = isset( $_GET['table'] ) ? sanitize_text_field( wp_unslash( $_GET['table'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$rah_db_tools_table_for_sql = '' !== $rah_db_tools_table ? esc_sql( $rah_db_tools_table ) : '';

?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php
	if ( isset( $_GET['message'] ) && isset( $_GET['type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$rah_db_tools_message = sanitize_text_field( wp_unslash( urldecode( $_GET['message'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$rah_db_tools_type = sanitize_text_field( wp_unslash( $_GET['type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		?>
		<div class="notice notice-<?php echo esc_attr( $rah_db_tools_type ); ?> is-dismissible">
			<p><?php echo esc_html( $rah_db_tools_message ); ?></p>
		</div>
		<?php
	}
	?>

	<?php if ( 'table_content' === $rah_db_tools_view && ! empty( $rah_db_tools_table ) ) : ?>
		
		<p>
			<a href="<?php echo esc_url( remove_query_arg( array( 'view', 'table', 'paged' ) ) ); ?>" class="button"><?php esc_html_e( '&larr; Back to Tables', 'rah-db-tools' ); ?></a>
		</p>

		<h2><?php printf( 
			/* translators: %s: Table name */
			esc_html__( 'Data for table: %s', 'rah-db-tools' ), 
			esc_html( $rah_db_tools_table ) 
		); ?></h2>

		<?php
		global $wpdb;
		
		// Validate table exists
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$rah_db_tools_table_exists = $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $rah_db_tools_table ) );

		if ( ! $rah_db_tools_table_exists ) {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Table does not exist.', 'rah-db-tools' ) . '</p></div>';
		} else {
			// Pagination for table view
			$rah_db_tools_per_page = 50;
			$rah_db_tools_current_page = isset( $_GET['paged'] ) ? max( 1, intval( wp_unslash( $_GET['paged'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$rah_db_tools_offset = ( $rah_db_tools_current_page - 1 ) * $rah_db_tools_per_page;

			// Get total rows
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$rah_db_tools_total_rows = $wpdb->get_var( "SELECT COUNT(*) FROM `$rah_db_tools_table_for_sql`" );
			$rah_db_tools_total_pages = ceil( $rah_db_tools_total_rows / $rah_db_tools_per_page );

			// Get Data
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$rah_db_tools_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$rah_db_tools_table_for_sql` LIMIT %d OFFSET %d", $rah_db_tools_per_page, $rah_db_tools_offset ), ARRAY_A );

			if ( ! empty( $rah_db_tools_results ) ) {
				$rah_db_tools_columns = array_keys( $rah_db_tools_results[0] );
				?>
				<div class="rah-db-tools-table-container" style="overflow-x: auto;">
					<table class="widefat fixed striped">
						<thead>
							<tr>
								<?php foreach ( $rah_db_tools_columns as $rah_db_tools_column ) : ?>
									<th><?php echo esc_html( $rah_db_tools_column ); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $rah_db_tools_results as $rah_db_tools_row ) : ?>
								<tr>
									<?php foreach ( $rah_db_tools_row as $rah_db_tools_cell ) : ?>
										<td title="<?php echo esc_attr( is_string( $rah_db_tools_cell ) ? $rah_db_tools_cell : print_r( $rah_db_tools_cell, true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r ?>">
											<?php 
											// Show full content but scrollable if too long
											$rah_db_tools_cell_content = is_string( $rah_db_tools_cell ) ? $rah_db_tools_cell : print_r( $rah_db_tools_cell, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
											// Just echo the content, CSS will handle the rest
											echo esc_html( $rah_db_tools_cell_content );
											?>
										</td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<?php
				// Pagination Links
				if ( $rah_db_tools_total_pages > 1 ) {
					$rah_db_tools_page_links = paginate_links( array(
						'base'    => add_query_arg( 'paged', '%#%' ),
						'format'  => '',
						'prev_text' => __( '&laquo;', 'rah-db-tools' ),
						'next_text' => __( '&raquo;', 'rah-db-tools' ),
						'total'   => $rah_db_tools_total_pages,
						'current' => $rah_db_tools_current_page,
					) );

					if ( $rah_db_tools_page_links ) {
						echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post( $rah_db_tools_page_links ) . '</div></div>';
					}
				}
			} else {
				echo '<p>' . esc_html__( 'No data found in this table.', 'rah-db-tools' ) . '</p>';
			}
		}
		?>

	<?php else : ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="rah-db-tools-optimize-form">
			<?php wp_nonce_field( 'rah_db_tools_optimize', 'rah_db_tools_nonce' ); ?>
			<input type="hidden" name="action" value="rah_db_tools_optimize">
			<input type="hidden" name="optimize_all" value="1">
			<p>
				<button type="submit" class="button button-primary" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to optimize all tables?', 'rah-db-tools' ); ?>');">
					<?php esc_html_e( 'Optimize All Tables', 'rah-db-tools' ); ?>
				</button>
			</p>
		</form>

		<form method="post">
			<input type="hidden" name="page" value="rah-db-tools" />
			<?php
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class-rah-db-tools-list-table.php';
			$rah_db_tools_list_table = new \Rah_Db_Tools\Admin\Rah_Db_Tools_List_Table();
			$rah_db_tools_list_table->prepare_items();
			$rah_db_tools_list_table->search_box( __( 'Search Tables', 'rah-db-tools' ), 'search_id' );
			$rah_db_tools_list_table->display();
			?>
		</form>

	<?php endif; ?>

</div>
