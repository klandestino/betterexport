<?php

if (!defined('ABSPATH')) exit();

add_export_import( 'users', 'betterexport_users_export', 'betterexport_users_import' );

function betterexport_users_export() {
	$data = array();
	$users = array();
	$logins = array();

	foreach (get_users(array()) as $user) {
		$logins[] = $user->user_login;
		$users[ $user->user_login ] = $user;
	}
	$logins = apply_filters( 'betterexport_users_logins_to_export', $logins);

	foreach ($logins as $login) {

		$user = $users[ $login ];

		$caps = array();
		foreach ($user->caps as $cap => $val) {
			if ( $val ) {
				$caps[] = $cap;
			}
		}
		sort( $caps );

		$data[ $login ] = array(
			'user_pass' => $user->user_pass,
			'caps' => $caps
		);
		ksort( $data[ $login ] );

	}

	ksort( $data );

	return $data;
}

function betterexport_users_import($data) {

	global $wpdb;

	foreach ( array_keys ($data ) as $user ) {
		$logins[] = $user;
	}
	$logins = apply_filters( 'betterexport_users_logins_to_import', $logins);

	foreach ($logins as $login) {

		$userinfo = $data[ $login ];

		$user_id = username_exists($login);
		if (is_null ($user_id) ) {
			$user_id = wp_insert_user( array(
				'user_login' => $login,
				'user_pass' => wp_generate_password(20, true, true)
			));
		} else {
			
		}
		if (is_wp_error( $user_id )) {
			continue;
		}

		if ( isset( $userinfo[ 'user_pass' ] ) ) {
			$wpdb->update( $wpdb->users, array('user_pass' => $userinfo[ 'user_pass' ] ), array( 'ID' => $user_id ) );
		}
		
	}
}


