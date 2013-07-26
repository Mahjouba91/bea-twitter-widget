bea twitter widget
======================

Simply add a widget twitter using the 1.1 auth API. 

How to install :
1 : Create an application here https://dev.twitter.com/docs/api/1.1
2 : Upload the plugin in your plugins folder and activate it
3 : In your WP admin, fill-in the app fields in settings > twitter widget
4 : Go to apparence > widgets and add the widget

Note : If you want to get tweets, without widget, there is a function :
bea_get_tweets( $args,  $widget_id, $transient_time );
$args = twitter args (for example : "screen_name=foo&count=4")
$widget_id = a custom ID (it will be stored in your db with this slug)
$transient_time : the number of seconds you want to keep tweets in db before refreshing
