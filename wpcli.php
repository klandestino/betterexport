<?php

class BetterExport_WPCLI_Command extends WP_CLI_Command {
	/**
	 * Output the export JSON to stdout.
	 * 
	 * ## OPTIONS
	 * 
	 *     --stdout
	 *
	 * ## EXAMPLES
	 * 
	 *     wp betterexport export
	 *     wp betterexport export --stdout
	 *
	 * @synopsis
	 */
	function export( $args, $assoc_args ) {

		if ( isset( $assoc_args['stdout'] ) ) {
			echo( betterExport() . "\n");
			exit();
		}
		
		$filename = 'betterexport-' . time() . '.json';
		if ( file_exists( $filename ) ) {
			WP_CLI::error( "File exists: " . $filename ); 
		}
		if (file_put_contents( $filename, betterExport() ) === false) {
			WP_CLI::error( "Error writing to file: " . $filename ); 
		}
		WP_CLI::success( "Exported to file: " . $filename ); 

	}
}

WP_CLI::add_command( 'betterexport', 'BetterExport_WPCLI_Command' );

