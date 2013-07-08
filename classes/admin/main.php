<?php
class BEA_TW_Admin_Main {
	/**
	 * Register hooks
	 */
	function __construct() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init_check_custom_messages' ) );
	}
	
	/**
	 * Check URL for display messages
	 */
	public static function admin_init_check_custom_messages() {
	}
}