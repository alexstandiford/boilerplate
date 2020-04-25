<?php
/**
 * Script Loader
 *
 * @since   1.0.0
 * @package Plugin_Name_Replace_Me\Registries\Loaders
 */


namespace Plugin_Name_Replace_Me\Registries\Loaders;


use Plugin_Name_Replace_Me\Abstracts\Registries\Loader_Registry;
use Plugin_Name_Replace_Me\Abstracts\Script;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Scripts
 * Loader for scripts
 *
 * @since   1.0.0
 * @package Plugin_Name_Replace_Me\Registries\Loaders
 */
class Scripts extends Loader_Registry {

	public function __construct() {
		parent::__construct( '\Plugin_Name_Replace_Me\Abstracts\Script' );
	}

	/**
	 * @inheritDoc
	 */
	protected function set_default_items() {
//		$this->add( 'scriptName', '\Plugin_Name_Replace_Me\Loaders\Scripts\Script_Name' );
	}

	/**
	 * @param string $key
	 * @return Script|\WP_Error Script Resulting script class, if it exists. WP_Error, otherwise.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	/**
	 * Enqueues a script.
	 *
	 * @since 1.0.0
	 *
	 * @param string $handle The script that should be enqueued.
	 * @return true|\WP_Error true if the script was enqueued. A WP Error otherwise.
	 */
	public function enqueue( $handle ) {
		$script = $this->get( $handle );

		if ( $script instanceof Script ) {
			$script->enqueue();

			return true;
		} else {
			return plugin_name_replace_me()->logger()->log(
				'plugin_name_replace_me_error',
				'script_not_enqueued',
				'The specified script could not be enqueued because it has not been registered.',
				$handle
			);
		}
	}
}