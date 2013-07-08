<?php
class BEA_TW_Admin_Settings {
	static $settings_api;
	
	public function __construct() {
		self::$settings_api = new WeDevs_Settings_API();
		add_action( 'admin_menu', array( __CLASS__, 'add_option_page') );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
	}
	
	public static function add_option_page() {
		add_options_page( __( 'Twitter widget', 'bea-tw' ), __( 'Twitter widget', 'bea-tw' ), 'manage_options', 'bea-twitter-widget', array( __CLASS__, 'option_page_content' ) );
	} 
	
	public static function option_page_content() {
		include ( BEA_TW_DIR . 'views/admin/main-settings.php' );
	}
	
	/**
	 * admin_init
	 * 
	 * @access public
	 * @static
	 *
	 * @return mixed Value.
	 */
	public static function admin_init( ) {
		//set the settings
		self::$settings_api -> set_sections(self::get_settings_sections());
		self::$settings_api -> set_fields(self::get_settings_fields());

		//initialize settings
		self::$settings_api -> admin_init();
	}
	
	public static function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'bea_tw_main',
				'title' => __( 'General features', 'bea-tw' ),
				'desc' => false,
			)
		);
		return $sections;
	}
	
	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public static function get_settings_fields() {
		$settings_fields = array(
			'bea_tw_main' => array(
				array(
					'name' => 'twitter_consumer_key',
					'label' => __( 'Twitter consumer key', 'bea-tw' ),
					'desc' => '',
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'twitter_consumer_secret',
					'label' => __( 'Twitter consumer secret', 'bea-tw' ),
					'desc' => '',
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'twitter_access_token',
					'label' => __( 'Twitter access token', 'bea-tw' ),
					'desc' => '',
					'type' => 'text',
					'default' => ''
				),
				array(
					'name' => 'twitter_access_token_secret',
					'label' => __( 'Twitter access token secret', 'bea-tw' ),
					'desc' => '',
					'type' => 'text',
					'default' => ''
				),
				
			)
		);

		return $settings_fields;
	}
}