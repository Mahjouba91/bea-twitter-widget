<?php
// don't load directly
if ( !defined('ABSPATH') )
	die('-1');
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">	<?php _e('Title', 'bea-tw' ); ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'screen_name' ); ?>">	<?php _e('Screen name', 'bea-tw' ); ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'screen_name' ); ?>" name="<?php echo $this->get_field_name( 'screen_name' ); ?>" value="<?php echo esc_attr($instance['screen_name']); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'count' ); ?>">	<?php _e('Number of tweets', 'bea-tw' ); ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo (int) $instance['count']; ?>" />
</p>

<p>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'exclude_replies' ); ?>" name="<?php echo $this->get_field_name( 'exclude_replies' ); ?>" <?php checked( $instance['exclude_replies'], true ); ?> value="1" />
	<label for="<?php echo $this->get_field_id( 'exclude_replies' ); ?>">	<?php _e('Exclude replies', 'bea-tw' ); ?></label>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'transient_duration' ); ?>">	<?php _e('Keep tweets in database for X seconds', 'bea-tw' ); ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'transient_duration' ); ?>" name="<?php echo $this->get_field_name( 'transient_duration' ); ?>" value="<?php echo esc_attr($instance['transient_duration']); ?>" />
</p>