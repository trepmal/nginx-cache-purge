<?php
/**
 * This works for the following nginx configuration:
 *
 * fastcgi_cache_path [..] levels=1:2 [..];
 * fastcgi_cache_key  "$scheme://$host$request_uri";
 *
 * To Do
 * - clear !single pages when deemed necessary
 */

$url = isset( $_POST['url'] ) ? $_POST['url'] : ( isset( $argv[1] ) ? $argv[1] : '' );

$url = (array) $url;

if ( empty( $url ) ) {
    die('Invalid URL entered');
}

foreach( $url as $u ) {
	$u = trim( $u, '/' ) . '/';
	purge( $u );
}

function purge( $url ) {

	$frag = parse_url( $url );

	$cache_root = '/etc/nginx/cache/trepmal/';
	$query      = isset( $frag['query'] ) ? "?{$frag['query']}" : '';
	$hash       = md5( "{$frag['scheme']}://{$frag['host']}{$frag['path']}{$query}" );

	$hash_path  = $cache_root . substr( $hash, -1 ) .'/'. substr( $hash, -3, 2 ) .'/'. $hash;

	if ( ! is_file( $hash_path ) ) {
		echo "No cache set [{$url}::{$hash_path}]\n";
		return;
	}
	if ( unlink( $hash_path ) ) {
		echo "Cache removed [{$url}::{$hash_path}]\n";
	} else {
		echo "Cache could not be removed [{$url}::{$hash_path}]\n";
	}
}
