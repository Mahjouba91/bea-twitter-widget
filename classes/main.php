<?php
class BEA_TW_Main {

	public function __construct() {
		add_action( 'init', array( __CLASS__, 'init' ) );
	}
	
	public static function init() {
		BEA_TW_Base::get_twitter_instance();
	}
}