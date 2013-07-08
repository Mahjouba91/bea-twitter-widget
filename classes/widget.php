<?php
class BEA_TW_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct( 'bea-twitter-widget', __('Bea Twitter Widget', 'bea-tw'),
			array( 'classname' => 'bea-twitter-widget', 'description' => __('Simply add a Twitter Widget', 'bea-tw' ) )
		);
	}
	
	public function widget( $args, $instance ) {
		extract( $args );
		
		// Get data from instance
		$title = $instance['title'];
		
		echo $before_widget;
		
		echo "The Twitter Widget";
		
		echo $after_widget;
		
		return true;
	}
	

	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 		= stripslashes($new_instance['title']);
		
		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => __('Twitter Widget', 'bea-tw') );
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		include( BEA_TW_DIR . 'views/admin/widget.php' );
	}
}