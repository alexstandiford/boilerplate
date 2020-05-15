<?php
/**
 * Rest Endpoint Abstraction
 *
 * @since 1.0.0
 * @package Underpin\Abstracts
 */

namespace Underpin\Abstracts;

use WP_Rest_Request;
use function Underpin\underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Rest_Endpoint
 *
 * @since   1.0.0
 *
 * @package Underpin\Abstracts
 */
abstract class Rest_Endpoint extends Feature_Extension {

	/**
	 * The REST API's namespace.
	 *
	 * @since 1.0.0
	 */
	public $rest_namespace = 'underpin/v1';

	public $route = '/';

	public $args = [ 'methods' => 'GET' ];

	/**
	 * Endpoint callback.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Rest_Request $request The request object.
	 * @return mixed the REST endpoint response.
	 */
	abstract function endpoint( WP_Rest_Request $request );

	/**
	 * Rest_Endpoint constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->args['callback'] = [ $this, 'endpoint' ];
	}

	/**
	 * @inheritDoc
	 */
	public function do_actions() {
		add_action( 'rest_api_init', [ $this, 'register' ] );
	}

	/**
	 * Registers the endpoints
	 *
	 * @since 1.0.0
	 *
	 * return void
	 */
	public function register() {
		$registered = register_rest_route( $this->rest_namespace, $this->route, $this->args );

		if ( false === $registered ) {
			underpin()->logger()->log(
				'error',
				'rest_route_was_not_registered',
				'The rest route ' . $this->route . ' was not registered. There is probably a __doing_it_wrong notice explaining this further.',
				$this->route,
				[ 'namespace' => $this->rest_namespace, 'args' => $this->args ]
			);
		} else {
			underpin()->logger()->log(
				'notice',
				'rest_route_registered',
				'The rest route ' . $this->route . ' was registered successfully',
				$this->route,
				[ 'namespace' => $this->rest_namespace, 'args' => $this->args ]
			);
		}
	}
}