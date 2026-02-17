<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a Cleanup view for the plugin
 *
 * This file is used to markup the cleanup-facing aspects of the plugin.
 *
 * @package    Rah_Db_Tools
 * @subpackage Rah_Db_Tools/admin/partials
 */

global $wpdb;

// Count Revisions
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_revisions_count = $wpdb->get_var( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'revision'" );

// Count Spam Comments
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_spam_comments_count = $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 'spam'" );

// Count Trashed Posts
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_trashed_posts_count = $wpdb->get_var( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status = 'trash'" );

// Count Trashed Comments
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_trashed_comments_count = $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = 'trash'" );

// Count Expired Transients
$rah_db_tools_time_now = time();
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_expired_transients_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(option_name) FROM $wpdb->options WHERE option_name LIKE %s AND option_value < %d", '_transient_timeout_%', $rah_db_tools_time_now ) );

// Count Orphaned Post Meta
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_orphaned_postmeta_count = $wpdb->get_var( "SELECT COUNT(pm.meta_id) FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL" );

// Count Orphaned Comment Meta
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$rah_db_tools_orphaned_commentmeta_count = $wpdb->get_var( "SELECT COUNT(cm.meta_id) FROM $wpdb->commentmeta cm LEFT JOIN $wpdb->comments c ON c.comment_ID = cm.comment_id WHERE c.comment_ID IS NULL" );

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Database Cleanup', 'rah-db-tools' ); ?></h1>
	<p><?php esc_html_e( 'Clean up unnecessary data to reduce database size and improve performance.', 'rah-db-tools' ); ?></p>

	<?php
	if ( isset( $_GET['message'] ) && isset( $_GET['type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$rah_db_tools_message = sanitize_text_field( wp_unslash( $_GET['message'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$rah_db_tools_type = sanitize_text_field( wp_unslash( $_GET['type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		?>
		<div class="notice notice-<?php echo esc_attr( $rah_db_tools_type ); ?> is-dismissible">
			<p><?php echo esc_html( $rah_db_tools_message ); ?></p>
		</div>
		<?php
	}
	?>

	<div class="rah-db-tools-card-container">
		
		<!-- Revisions -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Post Revisions', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of revisions */
				wp_kses_post( __( 'Found: <strong>%d</strong> revisions', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_revisions_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="revisions">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_revisions_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Revisions', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Spam Comments -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Spam Comments', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of spam comments */
				wp_kses_post( __( 'Found: <strong>%d</strong> spam comments', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_spam_comments_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="spam_comments">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_spam_comments_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Spam Comments', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Trashed Posts -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Trashed Posts', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of trashed posts */
				wp_kses_post( __( 'Found: <strong>%d</strong> trashed posts', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_trashed_posts_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="trashed_posts">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_trashed_posts_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Trashed Posts', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Trashed Comments -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Trashed Comments', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of trashed comments */
				wp_kses_post( __( 'Found: <strong>%d</strong> trashed comments', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_trashed_comments_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="trashed_comments">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_trashed_comments_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Trashed Comments', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Expired Transients -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Expired Transients', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of expired transients */
				wp_kses_post( __( 'Found: <strong>%d</strong> expired transients', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_expired_transients_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="transients">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_expired_transients_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Transients', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Orphaned Post Meta -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Orphaned Post Meta', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of orphaned post meta entries */
				wp_kses_post( __( 'Found: <strong>%d</strong> orphaned post meta', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_orphaned_postmeta_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="orphaned_postmeta">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_orphaned_postmeta_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Post Meta', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

		<!-- Orphaned Comment Meta -->
		<div class="rah-db-tools-card">
			<h2><?php esc_html_e( 'Orphaned Comment Meta', 'rah-db-tools' ); ?></h2>
			<p><?php printf( 
				/* translators: %d: Number of orphaned comment meta entries */
				wp_kses_post( __( 'Found: <strong>%d</strong> orphaned comment meta', 'rah-db-tools' ) ), 
				intval( $rah_db_tools_orphaned_commentmeta_count ) 
			); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'rah_db_tools_cleanup', 'rah_db_tools_nonce' ); ?>
				<input type="hidden" name="action" value="rah_db_tools_cleanup">
				<input type="hidden" name="cleanup_type" value="orphaned_commentmeta">
				<button type="submit" class="button button-primary" <?php disabled( $rah_db_tools_orphaned_commentmeta_count, 0 ); ?>>
					<?php esc_html_e( 'Clean Comment Meta', 'rah-db-tools' ); ?>
				</button>
			</form>
		</div>

	</div>
</div>

<style>
	.rah-db-tools-card-container {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		margin-top: 20px;
	}
	.rah-db-tools-card {
		background: #fff;
		border: 1px solid #ccd0d4;
		padding: 20px;
		width: 300px;
		box-shadow: 0 1px 1px rgba(0,0,0,.04);
	}
	.rah-db-tools-card h2 {
		margin-top: 0;
		border-bottom: 1px solid #eee;
		padding-bottom: 10px;
		margin-bottom: 15px;
	}
</style>
