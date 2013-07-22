<?php
// don't load directly
if ( !defined('ABSPATH') )
	die('-1');
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">	<?php _e('Title', 'bea-tw' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'screen_name' ); ?>">	<?php _e('Screen name', 'bea-tw' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'screen_name' ); ?>" name="<?php echo $this->get_field_name( 'screen_name' ); ?>" value="<?php echo esc_attr($instance['screen_name']); ?>" />
</p>

<!-- TODO -->