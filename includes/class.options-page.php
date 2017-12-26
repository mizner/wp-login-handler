<?php

namespace Knoxweb\WPLH\Options;

class Register {

	const NAME = 'Login Options';
	const KEY = 'login_options';
	const METABOX = 'login_options_metabox';

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		// hook in our save notices
		add_action( 'cmb2_save_options-page_fields_' . self::METABOX, array( $this, 'settings_notices' ), 10, 2 );

	}

	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( self::KEY, self::KEY );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$options_page = add_menu_page( self::NAME, self::NAME, 'manage_options', self::KEY, [
			$this,
			'admin_page_display'
		] );
		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-{$this->$options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo self::KEY; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( self::METABOX, self::KEY ); ?>
		</div>
		<?php
	}


	public function settings_notices( $object_id, $updated ) {
		if ( self::KEY !== $object_id || empty( $updated ) ) {
			return;
		}
		add_settings_error( self::KEY . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( self::KEY . '-notices' );
	}

	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, [ 'key', 'metabox_id', 'title', 'options_page', 'select' ], true ) ) {
			return $this->{$field};
		}
		//error_log( 'Invalid property: ' . $field );
	}
}

