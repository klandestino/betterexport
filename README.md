# betterexport

This adds import/export functionality to WordPress, implemented the way we think it should be implemented.

Still under heavy development. Not production ready.


## Some general principles

* Plugins and themes can add their own options/data into the export files, registering export and import functions.
* The export is in JSON format.
* We are sorting the keys and pretty printing the JSON, to get as readable diffs as possible between exports. (To make it easier to see what has happened on your site.)
* Support for WP-Cli.


## WP-Cli Commands

### Exporting

To save the export JSON in a timestamped file:

	wp betterexport export

To save the export JSON in a timestamped file (and overwrite if it already exists):

	wp betterexport export --overwrite

To output the export JSON to stdout:

	wp betterexport export --stdout

### Importing

Pipe JSON into WP-Cli this way:

	cat exportfile.json | wp betterexport import --stdin


## How to add your own data to export files

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


## Generic filters

* betterexport_export_filename - Filter for the export filename.


## Users import/export

### Filters (users)

* betterexports_users_logins_to_export - An array of user logins to export into export file. Use this filter to restrict which users to be exported.
* betterexports_users_logins_to_import - An array of user logins to import from an export file. Use this filter to restrict which users to be imported.
