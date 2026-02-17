<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a Scheduler view for the plugin
 *
 * This file is used to markup the scheduler-facing aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

// Get current settings
$rah_db_tools_scheduler_enabled = get_option( 'rah_db_tools_scheduler_enabled', 0 );
$rah_db_tools_scheduler_frequency = get_option( 'rah_db_tools_scheduler_frequency', 'weekly' );
$rah_db_tools_scheduler_tasks = get_option( 'rah_db_tools_scheduler_tasks', array() );
$rah_db_tools_next_run = wp_next_scheduled( 'rah_db_tools_scheduled_cleanup' );

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Advanced Automation (Scheduler)', 'rah-db-tools' ); ?></h1>
	<p><?php esc_html_e( 'Schedule automatic database cleanup and optimization tasks.', 'rah-db-tools' ); ?></p>

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
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'rah_db_tools_scheduler', 'rah_db_tools_nonce' ); ?>
			<input type="hidden" name="action" value="rah_db_tools_scheduler">
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Enable Scheduler', 'rah-db-tools' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="scheduler_enabled" value="1" <?php checked( $rah_db_tools_scheduler_enabled, 1 ); ?>>
								<?php esc_html_e( 'Enable automatic cleanup', 'rah-db-tools' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Frequency', 'rah-db-tools' ); ?></th>
						<td>
							<select name="scheduler_frequency">
								<option value="daily" <?php selected( $rah_db_tools_scheduler_frequency, 'daily' ); ?>><?php esc_html_e( 'Daily', 'rah-db-tools' ); ?></option>
								<option value="weekly" <?php selected( $rah_db_tools_scheduler_frequency, 'weekly' ); ?>><?php esc_html_e( 'Weekly', 'rah-db-tools' ); ?></option>
								<option value="monthly" <?php selected( $rah_db_tools_scheduler_frequency, 'monthly' ); ?>><?php esc_html_e( 'Monthly', 'rah-db-tools' ); ?></option>
							</select>
							<p class="description">
								<?php 
								if ( $rah_db_tools_next_run ) {
									/* translators: %s: Next run date and time */
									printf( esc_html__( 'Next run scheduled for: %s', 'rah-db-tools' ), esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $rah_db_tools_next_run ) ) );
								} else {
									esc_html_e( 'No tasks scheduled.', 'rah-db-tools' );
								}
								?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Tasks to Run', 'rah-db-tools' ); ?></th>
						<td>
							<fieldset>
								<label>
									<input type="checkbox" name="scheduler_tasks[]" value="optimize_tables" <?php checked( in_array( 'optimize_tables', $rah_db_tools_scheduler_tasks ) ); ?>>
									<?php esc_html_e( 'Optimize Database Tables', 'rah-db-tools' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="scheduler_tasks[]" value="revisions" <?php checked( in_array( 'revisions', $rah_db_tools_scheduler_tasks ) ); ?>>
									<?php esc_html_e( 'Clean Post Revisions', 'rah-db-tools' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="scheduler_tasks[]" value="spam_comments" <?php checked( in_array( 'spam_comments', $rah_db_tools_scheduler_tasks ) ); ?>>
									<?php esc_html_e( 'Clean Spam Comments', 'rah-db-tools' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="scheduler_tasks[]" value="trashed_items" <?php checked( in_array( 'trashed_items', $rah_db_tools_scheduler_tasks ) ); ?>>
									<?php esc_html_e( 'Clean Trashed Items (Posts & Comments)', 'rah-db-tools' ); ?>
								</label><br>
								<label>
									<input type="checkbox" name="scheduler_tasks[]" value="transients" <?php checked( in_array( 'transients', $rah_db_tools_scheduler_tasks ) ); ?>>
									<?php esc_html_e( 'Clean Expired Transients', 'rah-db-tools' ); ?>
								</label>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Save Settings', 'rah-db-tools' ); ?></button>
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
		max-width: 800px;
	}
</style>
