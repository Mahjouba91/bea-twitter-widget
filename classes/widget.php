<?php
class BEA_TW_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct( 'bea-twitter-widget', __('Bea Twitter Widget', 'bea-tw'),
			array( 'classname' => 'bea-twitter-widget', 'description' => __('Simply add a Twitter Widget', 'bea-tw' ) )
		);
	}
	
	public function widget( $args, $instance ) {
		
		extract( $args );
		
		if (!isset( $widget_id ) || empty( $widget_id ) ) {
			return false;
		}
		
		if ( !isset( $instance['screen_name'] ) || empty( $instance['screen_name'] ) || !isset( $instance['count'] ) || (int) $instance['count'] <= 0 ) {
			return false;
		}
		
		$instance['exclude_replies'] = ( isset( $instance['exclude_replies'] ) && (int) $instance['exclude_replies'] == 1 ) ? 'true' : 'false';
		$instance['transient_duration'] = ( isset( $instance['transient_duration'] ) && (int) $instance['transient_duration'] > 0 ) ? $instance['transient_duration'] : 3600;
	
		// Get the latest tweets
		$twitter = BEA_TW_Base::get_tweets_from_db( 'screen_name=' . urlencode( $instance['screen_name'] ) . '&count=' . (int) $instance['count'] . '&exclude_replies=' . $instance['exclude_replies'], $widget_id, $instance['transient_duration'] );
		if ( empty( $twitter ) || !is_array( $twitter ) ) {
			return false;
		}
		
		if ( empty( $twitter ) ) {
			return false;
		}
		
		echo $before_widget;
		
		// Get the tpl with condition
		$tpl =  BEA_TW_DIR . 'views/client/widget.tpl.php';
		if ( is_file( STYLESHEETPATH . '/twitter-widget/widget.tpl.php' ) ) {// Use custom template from child theme
			$tpl =  STYLESHEETPATH . '/twitter-widget/widget.tpl.php';
		} elseif ( is_file( TEMPLATEPATH . '/twitter-widget/widget.tpl.php' ) ) {// Use custom template from parent theme
			$tpl = TEMPLATEPATH . '/twitter-widget/widget.tpl.php';
		} 
		
		include( $tpl );
		
		echo $after_widget;
		
		return true;
	}
	

	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 				= stripslashes($new_instance['title']);
		$instance['screen_name']		= stripslashes($new_instance['screen_name']);
		$instance['count']				=(int) $new_instance['count'];
		$instance['exclude_replies']	= ( (int) $new_instance['exclude_replies'] == 1 ) ? 1 : 0;
		$instance['transient_duration']	= ( (int) $new_instance['transient_duration'] > 1 ) ? $new_instance['transient_duration'] : 3600;
		
		// Reset transient when update widget
		if ( isset( $_POST['widget-id'] ) && is_array( $_POST['widget-id'] ) ){
			foreach ( $_POST['widget-id'] as $widget_id ) {
				if ( strpos($widget_id, 'bea-twitter-widget') !== false ) {
					delete_transient( 'tweets_for_' . $widget_id );
				}
			}
		}
		
		return $instance;
	}
	
	public function form( $instance ) {
		$defaults = array( 'title' => __('Twitter Widget', 'bea-tw'), 'screen_name' => '', 'count' => 4, 'exclude_replies' => 1, 'transient_duration' => 3600 );
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		include( BEA_TW_DIR . 'views/admin/widget.php' );
	}
}