<?php
/*
 Plugin Name: BEA Twitter Widget
 Version: 0.1
 Plugin URI: https://github.com/benjaminniess/bea-twitter-widget
 Description: Simply add a widget twitter using the 1.1 auth API. 
 Author: Benjamin Niess
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Network: false
 Text Domain: bea-twitter-widget

 ----

 Copyright 2013 Benjamin Niess (bniess@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

// Plugin constants
define('BEA_TW_VERSION', '0.1');

// Plugin URL and PATH
define('BEA_TW_URL', plugin_dir_url ( __FILE__ ));
define('BEA_TW_DIR', plugin_dir_path( __FILE__ ));

// Function for easy load files
function _BEA_TW_load_files($dir, $files, $prefix = '') {
	foreach ($files as $file) {
		if ( is_file($dir . $prefix . $file . ".php") ) {
			require_once($dir . $prefix . $file . ".php");
		}
	}	
}

// Plugin functions
_BEA_TW_load_files(BEA_TW_DIR . 'functions/', array());

// Plugin client classes
_BEA_TW_load_files(BEA_TW_DIR . 'classes/', array('main','widget', 'base'));

// Plugin admin classes
if (is_admin()) {
	_BEA_TW_load_files(BEA_TW_DIR . 'classes/admin/', array( 'main', 'settings' ) );
	_BEA_TW_load_files(BEA_TW_DIR . 'libraries/wordpress-settings-api-class-master/', array( 'class.settings-api' ) );
}


add_action('plugins_loaded', 'init_BEA_TW_plugin');
function init_BEA_TW_plugin() {
	// Client
	new BEA_TW_Main();
	new BEA_TW_Base();

	// Admin
	if (is_admin()) {
		new BEA_TW_Admin_Main();
		new BEA_TW_Admin_Settings();
	}

	// Widget
	add_action('widgets_init', create_function('', 'return register_widget("BEA_TW_Widget");'));
}