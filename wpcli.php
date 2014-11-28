<?php

class BetterExport_WPCLI_Command extends WP_CLI_Command {
	/**
	 * Export data.
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

	/**
	 * Import data.
	 * 
	 * ## OPTIONS
	 * 
	 *     --stdin
	 *
	 * ## EXAMPLES
	 * 
	 *     wp betterexport import --stdin
	 *
	 * @synopsis
	 */
	function import( $args, $assoc_args ) {
		if ( isset( $assoc_args[ 'stdin' ] ) ) {
			betterImport(file_get_contents( "php://stdin" ));
			WP_CLI::success( "Imported." );
		}
		WP_CLI::error( "No input." );
	}
}

WP_CLI::add_command( 'betterexport', 'BetterExport_WPCLI_Command' );

