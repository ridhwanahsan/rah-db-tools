<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a Dashboard view for the plugin
 *
 * This file is used to markup the dashboard-facing aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

global $wpdb;

// Get database stats
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_tables = $wpdb->get_results( "SHOW TABLE STATUS", ARRAY_A );
$rah_db_tools_total_tables = count( $rah_db_tools_tables );
$rah_db_tools_total_rows = 0;
$rah_db_tools_total_data_size = 0;
$rah_db_tools_total_index_size = 0;
$rah_db_tools_total_overhead = 0;
$rah_db_tools_engine_counts = array();

foreach ( $rah_db_tools_tables as $rah_db_tools_table ) {
	$rah_db_tools_total_rows += $rah_db_tools_table['Rows'];
	$rah_db_tools_total_data_size += $rah_db_tools_table['Data_length'];
	$rah_db_tools_total_index_size += $rah_db_tools_table['Index_length'];
	$rah_db_tools_total_overhead += $rah_db_tools_table['Data_free'];
	
	if ( isset( $rah_db_tools_engine_counts[ $rah_db_tools_table['Engine'] ] ) ) {
		$rah_db_tools_engine_counts[ $rah_db_tools_table['Engine'] ]++;
	} else {
		$rah_db_tools_engine_counts[ $rah_db_tools_table['Engine'] ] = 1;
	}
}

$rah_db_tools_total_size = $rah_db_tools_total_data_size + $rah_db_tools_total_index_size;

// Top 5 Largest Tables
usort( $rah_db_tools_tables, function( $a, $b ) {
	return ( $b['Data_length'] + $b['Index_length'] ) - ( $a['Data_length'] + $a['Index_length'] );
} );
$rah_db_tools_largest_tables = array_slice( $rah_db_tools_tables, 0, 5 );

// Autoloaded Options Size
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_autoload_size = $wpdb->get_var( "SELECT SUM(LENGTH(option_value)) FROM $wpdb->options WHERE autoload = 'yes'" );

?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="rah-db-tools-dashboard-widgets">
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Overview', 'rah-db-tools' ); ?></h2>
			<table class="widefat">
				<tbody>
					<tr>
						<td><?php esc_html_e( 'Total Tables', 'rah-db-tools' ); ?></td>
						<td><strong><?php echo esc_html( number_format_i18n( $rah_db_tools_total_tables ) ); ?></strong></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Total Rows', 'rah-db-tools' ); ?></td>
						<td><strong><?php echo esc_html( number_format_i18n( $rah_db_tools_total_rows ) ); ?></strong></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Total Size', 'rah-db-tools' ); ?></td>
						<td><strong><?php echo esc_html( size_format( $rah_db_tools_total_size ) ); ?></strong></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Data Size', 'rah-db-tools' ); ?></td>
						<td><strong><?php echo esc_html( size_format( $rah_db_tools_total_data_size ) ); ?></strong></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Index Size', 'rah-db-tools' ); ?></td>
						<td><strong><?php echo esc_html( size_format( $rah_db_tools_total_index_size ) ); ?></strong></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Total Overhead', 'rah-db-tools' ); ?></td>
						<td>
							<?php if ( $rah_db_tools_total_overhead > 0 ) : ?>
								<strong style="color: red;"><?php echo esc_html( size_format( $rah_db_tools_total_overhead ) ); ?></strong>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=rah-db-tools' ) ); ?>" class="button button-small"><?php esc_html_e( 'Optimize Now', 'rah-db-tools' ); ?></a>
							<?php else : ?>
								<strong style="color: green;"><?php esc_html_e( '0 B', 'rah-db-tools' ); ?></strong>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Storage Engines', 'rah-db-tools' ); ?></h2>
			<table class="widefat">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Engine', 'rah-db-tools' ); ?></th>
						<th><?php esc_html_e( 'Count', 'rah-db-tools' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rah_db_tools_engine_counts as $rah_db_tools_engine => $rah_db_tools_count ) : ?>
						<tr>
							<td><?php echo esc_html( $rah_db_tools_engine ); ?></td>
							<td><?php echo esc_html( number_format_i18n( $rah_db_tools_count ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'System Info', 'rah-db-tools' ); ?></h2>
			<table class="widefat">
				<tbody>
					<tr>
						<td><?php esc_html_e( 'PHP Version', 'rah-db-tools' ); ?></td>
						<td><?php echo esc_html( phpversion() ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'MySQL Version', 'rah-db-tools' ); ?></td>
						<td><?php echo esc_html( $wpdb->db_version() ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'WordPress Version', 'rah-db-tools' ); ?></td>
						<td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Memory Limit', 'rah-db-tools' ); ?></td>
						<td><?php echo esc_html( ini_get( 'memory_limit' ) ); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Autoloaded Options', 'rah-db-tools' ); ?></td>
						<td>
							<strong><?php echo esc_html( size_format( $rah_db_tools_autoload_size ) ); ?></strong>
							<?php if ( $rah_db_tools_autoload_size > 1048576 ) : // > 1MB warning ?>
								<span style="color: red; margin-left: 5px;">(<?php esc_html_e( 'High!', 'rah-db-tools' ); ?>)</span>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="rah-db-tools-dashboard-widgets">
		<div class="rah-db-tools-card" style="flex: 2;">
			<h2><?php esc_html_e( 'Largest Tables', 'rah-db-tools' ); ?></h2>
			<table class="widefat striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Table Name', 'rah-db-tools' ); ?></th>
						<th><?php esc_html_e( 'Rows', 'rah-db-tools' ); ?></th>
						<th><?php esc_html_e( 'Size', 'rah-db-tools' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $rah_db_tools_largest_tables as $rah_db_tools_table ) : ?>
						<tr>
							<td><?php echo esc_html( $rah_db_tools_table['Name'] ); ?></td>
							<td><?php echo esc_html( number_format_i18n( $rah_db_tools_table['Rows'] ) ); ?></td>
							<td><?php echo esc_html( size_format( $rah_db_tools_table['Data_length'] + $rah_db_tools_table['Index_length'] ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	.rah-db-tools-dashboard-widgets {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		margin-top: 20px;
	}
	.rah-db-tools-card {
		background: #fff;
		border: 1px solid #ccd0d4;
		padding: 0 20px 20px;
		flex: 1;
		min-width: 300px;
		box-shadow: 0 1px 1px rgba(0,0,0,.04);
	}
	.rah-db-tools-card h2 {
		border-bottom: 1px solid #eee;
		padding-bottom: 10px;
		margin-bottom: 15px;
	}
	.rah-db-tools-card table td {
		padding: 8px 10px;
	}
</style>
