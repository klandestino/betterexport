betterexport
============

Better WordPress exports and imports.

Still under heavy development. Not production ready.


Some principles
---------------

* Plugins and themes can add their own options/data into the export files, registering export and import functions.
* The export is in JSON format.
* We are sorting the keys and pretty printing the JSON, to get as readable diffs as possible between exports.


WP-Cli Commands
---------------

To save the export JSON in a timestamped file:

	wp betterexport export

To output the export JSON to stdout:

	wp betterexport export --stdout


How to add your own data to export files
----------------------------------------

Adding your own data to export files is simple and follow normal WordPress patterns.

Example:

	function my_theme_options_export() {
		$data = array( 'background_color' => get_option( 'my_background' ) );
		return $data;
	}
	
	function my_theme_options_import($data) {
		update_option( 'my_background', $data[ 'background_color' ] );
	}

	if (function_exists( 'add_export_import' )) { // Only if plugin is active...
		add_export_import( 'my_theme_stuff', 'my_theme_options_export', 'my_theme_options_import' );
	}


Filters - users
---------------

* betterexports_users_logins_to_export - An array of user logins to export into export file. Use this filter to restrict which users to be exported.
* betterexports_users_logins_to_import - An array of user logins to import from an export file. Use this filter to restrict which users to be imported.
