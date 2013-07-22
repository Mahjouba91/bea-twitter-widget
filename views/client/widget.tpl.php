<?php
// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

if ( isset( $title )  && !empty( $title ) ) {
	echo $before_title . $title . $after_title;
}

?>
<ul>
	<?php
	foreach ( $twitter as $tweet ) : ?>
		<li class="bea-tweets">
			<?php
			$text = isset( $tweet['text'] ) ? $tweet['text'] : '';
			$user = ( isset( $tweet['user'] ) && is_array( $tweet['user'] ) ) ? $tweet['user'] : array();
			$time_ago = isset( $tweet['time_ago'] ) ? $tweet['time_ago'] : '';
			?>
			<span class="bea-user-info">@<?php echo $user['screen_name']; ?></span>
			<p><?php echo $text; ?></p>
			<span class="bea-created-time"><?php echo $time_ago; ?> <?php _e( 'ago', 'bea-tw'); ?></span>
		</li>
	<?php endforeach; ?>
</ul>