<?php

namespace Knoxweb\WPLH\Assets;

class Assets {
	function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 15 );
	}

	function enqueue_scripts() {
		wp_register_script( 'recaptcha', '//www.google.com/recaptcha/api.js', [ null ], '1.0', true );
	}
}

new Assets();