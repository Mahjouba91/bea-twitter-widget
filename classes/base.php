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
	 * Load the codebird PHP SDK
	 *
	 * @author Benjamin Niess
	 */
	public static function load_sdk() {
		require_once( BEA_TW_DIR . 'libraries/codebird/src/codebird.php' );
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
		
		// Remove last row of the array with the twitter status
		if ( isset( $tweets['httpstatus'] ) ) {
			unset( $tweets['httpstatus'] );
		}

		// Add date in the array
		foreach ( $tweets as $tweet_key => $tweet ) {
			if ( !isset( $tweet['created_at'] ) ) {
				continue;
			}
			$tweets[$tweet_key]['time_ago'] = self::calculate_time_ago( $tweet['created_at'] );
		}
		
		return $tweets;
	}
	
	
	/**
	 * Get Tweets from database or directly from Twitter API
	 * 
	 * @param (string) $args : The tweeter arguments string (ex : 'screen_name=foo&count=4&exclude_replies=true')
	 * @param (string) $widget_id : The widget ID
	 * @param (int) $transient_time : The number of seconds between each syncrho 
	 * 
	 * @return (array) : The tweets
	 * 
	 * @author Benjamin Niess
	 */
	public static function get_tweets_from_db( $args = '',  $widget_id = '', $transient_time = 3600 ) {
		if ( empty( $widget_id ) ) {
			return false;
		}
		$transient_name = 'tweets_for_' . $widget_id;
		
		// First check if the transient is up to date
		$tweets = maybe_unserialize( get_transient( $transient_name ) );
		if ( !empty( $tweets ) && is_array( $tweets ) ) {
			return $tweets;
		}
		
		// Get the tweets with the twitter API
		$tweets = self::get_tweets( $args );
		if ( empty( $tweets ) || !is_array( $tweets ) ) {
			return false;
		}
		
		// Set the transient
		set_transient( $transient_name, maybe_serialize( $tweets ), (int) $transient_time );
		
		return $tweets;
		
	}

	/**
	 * Calculate the time ago the tweet has been published
	 * 
	 * @param string $date the tweet date
	 * 
	 * @return string the time ago
	 */
	public static function calculate_time_ago( $date_string = '' ) {
		if ( empty( $date_string ) ) {
			return false;
		}
		
		$created_timestamp = strtotime( $date_string );
		if ( (int) $created_timestamp <= 0 ) {
			return false;
		}
		
		$seconds_ago = time() - $created_timestamp;
		if ( (int) $seconds_ago <= 0 ) {
			return false;
		}
		
		$periods = array( __("second(s)", 'bea-tw' ), __("minute", 'bea-tw' ), __("hour", 'bea-tw' ), __("day", 'bea-tw' ), __("week", 'bea-tw' ), __("month", 'bea-tw' ), __("year", 'bea-tw' ), __("decade", 'bea-tw' ) );
		$lengths = array("60","60","24","7","4.35","12","10");
		
		for( $j = 0; $seconds_ago >= $lengths[$j] && $j < count( $lengths ) -1 ; $j++ ) {
			$seconds_ago /= $lengths[$j];
		}
		
		$seconds_ago = round($seconds_ago);
		if ( $seconds_ago != 1) {
			 $periods[$j].= "s"; 
		}
		return $seconds_ago . ' ' . $periods[$j];
		
	}
}