(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed that this file is only loaded if the current page is
	 * the settings page for the plugin.
	 */

	$(function() {
		// Add spinner logic here if needed
		$('form.rah-db-tools-optimize-form').on('submit', function() {
			var $spinner = $('<span class="spinner is-active"></span>');
			$(this).find('button').after($spinner);
		});
	});

})( jQuery );
