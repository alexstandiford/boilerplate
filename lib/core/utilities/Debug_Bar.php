<?php
/**
 *
 *
 * @since
 * @package
 */


namespace Plugin_Name_Replace_Me\Core\Utilities;


use Plugin_Name_Replace_Me\Core\Abstracts\Admin_Bar_Menu;
use Plugin_Name_Replace_Me\Core\Factories\Debug_Bar_Section;
use Plugin_Name_Replace_Me\Core\Traits\Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Debug_Bar
 *
 *
 * @since
 * @package
 */
class Debug_Bar extends Admin_Bar_Menu {
	use Templates;

	public function __construct() {
		parent::__construct( 'plugin_name_replace_me_debugger', [
			'parent' => 'top-secondary',
			'title'  => 'Plugin Name Replace Me Events',
			'href'   => '#',
			'meta'   => [
				'onclick' => '',
			],
		] );

		plugin_name_replace_me()->scripts()->add( 'debug', '\Plugin_Name_Replace_Me\Core\Utilities\Debug_Bar_Script' );
		plugin_name_replace_me()->styles()->add( 'debug', '\Plugin_Name_Replace_Me\Core\Utilities\Debug_Bar_Style' );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ], 11 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ], 11 );
		add_action( 'shutdown', [ $this, 'render_callback' ] );
	}

	/**
	 * Loads in the debug bar script
	 *
	 * @since 1.0.0
	 */
	public function enqueue_assets() {
		plugin_name_replace_me()->scripts()->enqueue( 'debug' );
		plugin_name_replace_me()->styles()->enqueue( 'debug' );
	}

	/**
	 * @inheritDoc
	 */
	protected function get_templates() {
		return [
			'wrapper' => [
				'override_visibility' => 'public',
			],
			'section' => [
				'override_visibility' => 'public',
			],
			'console' => [
				'override_visibility' => 'public',
			],
			'tabs'    => [
				'override_visibility' => 'public',
			],
			'section-menu'    => [
				'override_visibility' => 'public',
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	protected function get_template_group() {
		return 'debug-bar';
	}

	/**
	 * Renders the actual debug bar.
	 */
	public function render_callback() {
		echo $this->get_template( 'wrapper', [
			'sections' => [
				new Debug_Bar_Section(
					'logged-events',
					plugin_name_replace_me()->logger()->get_request_events(),
					'Logged Events',
					"Here's what was logged during this session."
				),
				new Debug_Bar_Section(
					'registered-items',
					plugin_name_replace_me()->export_registered_items(),
					'Registered Items',
					"Here's what items were registered during this session."
				),
			],
		] );
	}
}