<?php

namespace Knoxweb\WPLH\Options_Meta;

use Knoxweb\WPLH\Options\Register;

class Options_Meta {

	const KEY = Register::KEY;
	const METABOX = Register::METABOX;

	public function __construct() {
		add_action( 'cmb2_admin_init', [ $this, 'add_options_page_metabox' ] );

	}

	public function add_options_page_metabox() {
		$cmb = new_cmb2_box( array(
			'id'         => self::METABOX,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => [
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => [ self::KEY ],
			],
		) );
		$cmb->add_field( [
			'name'    => __( 'Login Page' ),
			'desc'    => __( 'Select the page where the login form will show up' ),
			'id'      => 'login_page',
			'type'    => 'select',
			'options' => $this->list_of_pages(),

		] );
		$cmb->add_field( [
			'name'    => __( 'Logout Page' ),
			'desc'    => __( 'Select the page where users will end up when logged out' ),
			'id'      => 'logout_page',
			'type'    => 'select',
			'options' => $this->list_of_pages(),
		] );
		$cmb->add_field( [
			'name'    => __( 'Frontend Dashboard' ),
			'desc'    => __( 'Where we send users upon login' ),
			'id'      => 'frontend_dashboard_page',
			'type'    => 'select',
			'options' => $this->list_of_pages(),
		] );
		$cmb->add_field( [
			'name'    => __( 'Lost Password Page' ),
			'desc'    => __( 'Where we send users upon login' ),
			'id'      => 'lostpassword_page',
			'type'    => 'select',
			'options' => $this->list_of_pages(),
		] );
	}

	public function list_of_pages() {
		$pages = get_pages( [
			'sort_order' => 'asc',
			'post_type'  => 'page',
		] );

		$list = [];

		foreach ( $pages as $page => $value ) {
			$list[ $value->ID ] = $value->post_title;
		}


		return $list;

	}
}
