<?php

namespace Knoxweb\WPLH\Data;

use Knoxweb\WPLH\Options;
use Knoxweb\WPLH\Helpers;

class Object {

	public function __construct() {
		$this->options = $this->options_page();
		$this->server  = $this->server_data();
		$this->plugin  = $this->plugin();
		$this->user    = $this->user();
	}

	function user() {
		return Helpers::array_to_object( [
			'logged_in' => is_user_logged_in(),
		] );
	}

	function plugin() {
		return Helpers::array_to_object( [
			'path' => plugin_dir_path( __DIR__ ),
		] );
	}

	function server_data() {
		return Helpers::array_to_object( [
			'request_method' => $_SERVER['REQUEST_METHOD'],
			'request_uri'    => basename( $_SERVER['REQUEST_URI'] ),
		] );
	}

	function options_page() {
		$data = get_option( Options\Register::KEY );

		if ( ! $data ) {
			return false;
		}

		$data = Helpers::array_to_object( $data );

		return ( $data );
	}

}