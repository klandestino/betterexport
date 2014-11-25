<?php

if (!defined('ABSPATH')) exit();

add_export_import( 'users', 'export_import_users' );

function export_import_users() {
	$data = array();
	$users = get_users(array());
	foreach ($users as $user) {

		$caps = array();
		foreach ($user->caps as $cap => $val) {
			if ($val) $caps[] = $cap;
		}
		sort($caps);

		$data[$user->user_login] = array(
			'user_pass' => $user->user_pass,
			'caps' => $caps
		);
		ksort($data[$user->user_login]);

	}

	return $data;
}
