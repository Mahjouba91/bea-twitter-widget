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
		<li>
			<?php
		//	var_dump($tweet);
			$text = isset( $tweet['text'] ) ? $tweet['text'] : '';
			$text = isset( $tweet['text'] ) ? $tweet['text'] : '';
			echo $text;
			?>
		</li>
	<?php endforeach; ?>
</ul>