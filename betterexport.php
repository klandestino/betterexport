<?php
/*
Plugin Name: Better Exports and Imports
Plugin URI: https://github.com/klandestino/betterexport
Description: Exports and imports.
Version: 0.0.1
Author: alfreddatakillen
Author URI: http://www.klandestino.se
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: betterexport

------------------------------------------------------------------------
This plugin, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/

if (!defined('ABSPATH')) exit();

$export_import_functions = array();

function add_export_import( $tag, $export_function_to_add, $import_function_to_add ) {
	global $export_import_functions;
	$export_import_functions[$tag] = array( 'export_function' => $export_function_to_add, 'import_function' => $import_function_to_add );
	return true;
}

add_action ( 'wp_ajax_export', 'ajax_export' );
add_action ( 'wp_ajax_nopriv_export', 'ajax_export' );

function ajax_export() {
	echo betterExport();
	exit();
}

function betterExport() {
	global $export_import_functions;
	$data = array();
	foreach ( $export_import_functions as $tag => $functions ) {
		$data[$tag] = call_user_func_array($functions[ 'export_function' ], array());
	}
	return json_encode($data, JSON_PRETTY_PRINT);
}

function betterImport($data) {
	global $export_import_functions;

	if (is_string( $data )) {
		$data = json_decode( $data );
	}

	foreach ( array_keys( $data ) as $tag ) {
		if (isset( $export_import_functions[ $tag ] )) {
			call_user_func_array( $export_import_functions[ $tag ], array( $data[ $tag ] ));
		}
	}
}

require_once( dirname( __FILE__ ) . '/users.php');

