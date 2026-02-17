<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a Search & Replace view for the plugin
 *
 * This file is used to markup the search-replace aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Search & Replace', 'rah-db-tools' ); ?></h1>
	<p><?php esc_html_e( 'Find and replace data in your database. Supports serialized data.', 'rah-db-tools' ); ?></p>

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

	<div class="rah-db-tools-card">
		<div class="notice notice-warning inline">
			<p><strong><?php esc_html_e( 'Warning:', 'rah-db-tools' ); ?></strong> <?php esc_html_e( 'This operation is irreversible. Please backup your database before running a search and replace!', 'rah-db-tools' ); ?></p>
		</div>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'rah_db_tools_search_replace', 'rah_db_tools_nonce' ); ?>
			<input type="hidden" name="action" value="rah_db_tools_search_replace">
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="search_str"><?php esc_html_e( 'Search for', 'rah-db-tools' ); ?></label></th>
						<td>
							<input type="text" name="search_str" id="search_str" class="regular-text" required placeholder="http://old-site.com">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="replace_str"><?php esc_html_e( 'Replace with', 'rah-db-tools' ); ?></label></th>
						<td>
							<input type="text" name="replace_str" id="replace_str" class="regular-text" required placeholder="https://new-site.com">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Select Tables', 'rah-db-tools' ); ?></th>
						<td>
							<label><input type="checkbox" id="rah-db-tools-select-all-tables"> <?php esc_html_e( 'Select All', 'rah-db-tools' ); ?></label>
							<div class="rah-db-tools-tables-list" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; margin-top: 5px;">
								<?php
								global $wpdb;
								// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
								$rah_db_tools_tables = $wpdb->get_results( "SHOW TABLES", ARRAY_N );
								foreach ( $rah_db_tools_tables as $rah_db_tools_table ) {
									$rah_db_tools_table_name = $rah_db_tools_table[0];
									echo '<label style="display:block;"><input type="checkbox" name="tables[]" value="' . esc_attr( $rah_db_tools_table_name ) . '"> ' . esc_html( $rah_db_tools_table_name ) . '</label>';
								}
								?>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Dry Run', 'rah-db-tools' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="dry_run" value="1" checked>
								<?php esc_html_e( 'Do a "dry run" first (only show what would be changed, do not modify database)', 'rah-db-tools' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary" onclick="return confirm('<?php esc_attr_e( 'Are you sure? This can affect your entire site.', 'rah-db-tools' ); ?>');">
					<?php esc_html_e( 'Run Search & Replace', 'rah-db-tools' ); ?>
				</button>
			</p>
		</form>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		$('#rah-db-tools-select-all-tables').change(function() {
			$('.rah-db-tools-tables-list input[type="checkbox"]').prop('checked', $(this).prop('checked'));
		});
	});
</script>

<style>
	.rah-db-tools-card {
		background: #fff;
		border: 1px solid #ccd0d4;
		padding: 20px;
		margin-top: 20px;
		box-shadow: 0 1px 1px rgba(0,0,0,.04);
		max-width: 800px;
	}
</style>
