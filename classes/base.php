<?php
class BEA_TW_Base {
	
	
	public static function activate() {

	}

	public static function deactivate() {

	}

	/**
	 * Check if the admin has entered all infos
	 */
	public static function is_admin_ready() {
		$bea_tw_options = get_option( 'bea_tw_main' );
		if ( !isset( $bea_tw_options['twitter_consumer_key'] ) || empty( $bea_tw_options['twitter_consumer_key'] ) || !isset( $bea_tw_options['twitter_consumer_secret'] ) || empty( $bea_tw_options['twitter_consumer_secret'] ) || !isset( $bea_tw_options['twitter_access_token'] ) || empty( $bea_tw_options['twitter_access_token'] ) || !isset( $bea_tw_options['twitter_access_token_secret'] ) || empty( $bea_tw_options['twitter_access_token_secret'] ) ) {
			return false;
		}

		return $bea_tw_options;
	}

	/**
	 * Get instance of codebird
	 * 
	 */
	public static function get_twitter_instance() {
		global $cb;
		
		$tw_infos = self::is_admin_ready();
		if ( empty( $tw_infos ) ) {
			return false;
		}
		
		self::load_sdk();
		
		try {
			$cb = \Codebird\Codebird::getInstance();
			$cb::setConsumerKey( $tw_infos['twitter_consumer_key'], $tw_infos['twitter_consumer_secret'] );
			$cb->setToken( $tw_infos['twitter_access_token'], $tw_infos['twitter_access_token_secret'] );
		} catch ( Exception $e ) {
			_e( "Synchro error : ", 'bea-tw' ); 
			echo $e->getMessage();
		}
		
		return $cb;
	}
	
	
	/**
	 * Load the codebird PHP SDK
	 *
	 * @author Benjamin Niess
	 */
	public static function load_sdk() {
		require_once( BEA_TW_DIR . 'libraries/codebird/src/codebird.php' );
	}

}