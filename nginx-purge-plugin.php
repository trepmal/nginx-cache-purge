<?php

//Plugin Name: Nginx Permalink Purge

add_action( 'save_post', 'npp_save_post', 10, 2 );

function npp_save_post( $post_id, $post ) {

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) //no auto saving
		return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) //verify permissions
		return;

	if ( 'revision' == $post->post_type )
		return;

	$permalink = get_permalink( $post_id );
	$resp = wp_remote_post( 'http://' . $_SERVER['SERVER_ADDR'] . ':765', array(
		'body' => array( 'url' => array( $permalink, site_url() ) )
	) );
	// die( '<pre>' . $permalink . '<br />' . print_r( $resp, true ) .'</pre>' );
}

