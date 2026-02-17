<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a SQL Query view for the plugin
 *
 * This file is used to markup the SQL Query aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

?>

<div class="wrap">
	<h1><?php esc_html_e( 'SQL Query Runner', 'rah-db-tools' ); ?></h1>
	<p><?php esc_html_e( 'Run custom SQL queries on your database. Use with caution!', 'rah-db-tools' ); ?></p>

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
	
	// Display Query Results
	if ( isset( $_GET['query_results'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$rah_db_tools_results = get_transient( 'rah_db_tools_query_results_' . get_current_user_id() );
		if ( $rah_db_tools_results !== false ) {
			echo '<div class="rah-db-tools-query-results">';
			echo '<h2>' . esc_html__( 'Query Results', 'rah-db-tools' ) . '</h2>';
			
			if ( is_array( $rah_db_tools_results ) && ! empty( $rah_db_tools_results ) ) {
				echo '<div style="overflow-x: auto;"><table class="widefat fixed striped">';
				echo '<thead><tr>';
				foreach ( array_keys( $rah_db_tools_results[0] ) as $rah_db_tools_column ) {
					echo '<th>' . esc_html( $rah_db_tools_column ) . '</th>';
				}
				echo '<thead><tr>';
				echo '<tbody>';
				foreach ( $rah_db_tools_results as $rah_db_tools_row ) {
					echo '<tr>';
					foreach ( $rah_db_tools_row as $rah_db_tools_cell ) {
						echo '<td>' . esc_html( print_r( $rah_db_tools_cell, true ) ) . '</td>'; // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
					}
					echo '</tr>';
				}
				echo '</tbody></table></div>';
			} elseif ( is_array( $rah_db_tools_results ) && empty( $rah_db_tools_results ) ) {
				echo '<p>' . esc_html__( 'Query returned no results.', 'rah-db-tools' ) . '</p>';
			} else {
				echo '<p>' . esc_html__( 'Query executed successfully.', 'rah-db-tools' ) . '</p>';
				if ( is_int( $rah_db_tools_results ) ) {
					/* translators: %d: Number of rows affected */
					echo '<p>' . sprintf( esc_html__( 'Rows affected: %d', 'rah-db-tools' ), intval( $rah_db_tools_results ) ) . '</p>';
				}
			}
			echo '</div>';
			delete_transient( 'rah_db_tools_query_results_' . get_current_user_id() );
		}
	}
	?>

	<div class="rah-db-tools-card">
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'rah_db_tools_sql_query', 'rah_db_tools_nonce' ); ?>
			<input type="hidden" name="action" value="rah_db_tools_sql_query">
			
			<p>
				<label for="rah_db_tools_sql"><?php esc_html_e( 'Enter SQL Query:', 'rah-db-tools' ); ?></label>
				<textarea name="rah_db_tools_sql" id="rah_db_tools_sql" rows="10" class="large-text code" placeholder="SELECT * FROM wp_options WHERE option_name = 'siteurl';"></textarea>
			</p>
			
			<p class="description">
				<?php esc_html_e( 'Supported statements: SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER. Please back up your database before running destructive queries.', 'rah-db-tools' ); ?>
			</p>

			<p>
				<button type="submit" class="button button-primary" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to execute this query?', 'rah-db-tools' ); ?>');">
					<?php esc_html_e( 'Run Query', 'rah-db-tools' ); ?>
				</button>
			</p>
		</form>
	</div>
</div>

<style>
	.rah-db-tools-card {
		background: #fff;
		border: 1px solid #ccd0d4;
		padding: 20px;
		margin-top: 20px;
		box-shadow: 0 1px 1px rgba(0,0,0,.04);
	}
	.rah-db-tools-query-results {
		background: #fff;
		border: 1px solid #ccd0d4;
		padding: 20px;
		margin-top: 20px;
		margin-bottom: 20px;
		box-shadow: 0 1px 1px rgba(0,0,0,.04);
	}
</style>
