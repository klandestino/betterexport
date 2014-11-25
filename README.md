betterexport
============

Better WordPress exports and imports.

Still under heavy development. Not production ready.


Some principles
---------------

* Plugins and themes can add their own options/data into the export files, registering export and import functions.
* The export is in JSON format.
* We are sorting the keys and pretty printing the JSON, to get as readable diffs as possible between exports.


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

	add_export_import( 'my_theme_stuff', 'my_theme_options_export', 'my_theme_options_import' );


