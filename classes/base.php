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
			$cb->setReturnFormat( CODEBIRD_RETURNFORMAT_ARRAY );
			
		} catch ( Exception $e ) {
			_e( "Synchro error : ", 'bea-tw' ); 
			echo $e->getMessage();
		}
		
		return $cb;
	}
	
	/**
	 * Retrieve an array of tweets depending on params
	 * 
	 * @param (string) $args : The tweeter arguments string (ex : 'screen_name=foo&count=4&exclude_replies=true')
	 * @return (array) : The tweets
	 * 
	 * @author Benjamin Niess
	 */
	public static function get_tweets( $args = '' ) {
		if ( empty( $args ) ) {
			return false;
		}
		
		$twitter_instance = self::get_twitter_instance();
		if ( empty( $twitter_instance ) ) {
			return false;
		}
		
		$tweets = $twitter_instance->statuses_userTimeline( $args );
		if ( empty( $tweets ) || !is_array( $tweets ) ) {
			return false;
		}
		
		if ( isset( $tweets['errors'] ) && is_array( $tweets['errors'] ) ) {
			// IF you want to trace debug...
			foreach ( $tweets['errors'] as $error ) {
				//var_dump($error['message']);
			}
			return false;
		}
		
		return $tweets;
	}
	
	public static function get_tweets_from_db( $args = '',  $transient_name = '', $transient_time = 3600 ) {
		if ( empty( $transient_name ) ) {
			return false;
		}
		
		// First check if the transient is up to date
		$tweets = maybe_unserialize( get_transient( $transient_name ) );
		if ( !empty( $tweets ) && is_array( $tweets ) ) {
			echo "from transient";
			return $tweets;
		}
		
		// Get the tweets with the twitter API
		$tweets = self::get_tweets( $args );
		if ( empty( $tweets ) || !is_array( $tweets ) ) {
			return false;
		}
		echo "from api";
		
		// Set the transient
		set_transient( $transient_name, maybe_serialize( $tweets ), (int) $transient_time );
		
		return $tweets;
		
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