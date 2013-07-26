<?php
/**
 * Meta function for BEA_TW_Base::get_tweets_from_db
 * 
 * @author Benjamin Niess
 */
function bea_get_tweets( $args = '',  $widget_id = '', $transient_time = 3600 ) {
	return BEA_TW_Base::get_tweets_from_db( $args,  $widget_id, $transient_time );
}