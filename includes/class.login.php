<?php

namespace Knoxweb\WPLH\Login;

use Knoxweb\WPLH\Options\Register;

class Login {

	private $data;

	public function __construct( $data ) {

		$this->data = $data;
//  	_log( 'Staring Hooks and Filters' );
		add_action( 'init', [ $this, 'wp_login_override' ], 17 );
		add_filter( 'login_redirect', [ $this, 'login_redirect' ] );
//  	add_filter( 'logout_redirect', [ $this, 'logout_redirect' ] );
		add_filter( 'the_content', [ $this, 'login_form' ], 10, 2, $data );
//  	add_filter( 'the_content', [ $this, 'lostpassword_form' ] );
		add_action( 'template_redirect', [ $this, 'login_page_while_signed_in' ] );
//  	add_action( 'template_redirect', [ $this, 'frontend_dashboard_while_logged_out' ] );
//  	add_action( 'login_form_lostpassword', [ $this, 'lostpassword_redirect' ] );
//  	add_action( 'login_form_lostpassword', [ $this, 'do_password_lost' ] );
		add_action( 'login_form_middle', [ $this, 'add_lost_password_link' ] );
		add_action( 'login_form_bottom', [ $this, 'recaptcha' ] );
	}

	public function is_wp_login_page() {
		$server = $this->data->server;

		return ( 'GET' === $server->request_method && 'wp-login.php' === $server->request_uri );
	}

	public function wp_login_override() {

		$redirection_page = $this->data->options->login_page;

		if ( ! $redirection_page ) {
			return false;
		}


		if ( $this->is_wp_login_page() ) {
			wp_redirect( get_the_permalink( $redirection_page ) );
			exit;
		}
	}

	public function login_form() {

		$login_page = $this->data->options->login_page;

		if ( ! $login_page ) {
			return false;
		}

		$template_path = $this->data->plugin->path . 'templates/login-form.php';

		if ( is_page( $login_page ) ) {
			include_once $template_path;
		}
	}

	public function lostpassword_form() {


		if ( ! $this->data->options->lostpassword_page ) {
			return;
		}

		if ( is_page( $this->data->options->lostpassword_page ) ) {
			include_once WPLH_PATH . 'templates/lost-password.php';
		}
	}

	public function frontend_dashboard_while_logged_out() {
		if ( ! $this->options() ) {
			return;
		}

		if ( ! is_user_logged_in() && is_page( $this->options->frontend_dashboard_page ) ) {
			wp_redirect( get_the_permalink( $this->options->login_page ) );
		}
	}

	public function login_page_while_signed_in() {
		$user = $this->data->user;
		if ( ! $this->data->options ) {
			return;
		}

		if ( $user->logged_in && is_page( $this->data->options->login_page ) ) {
			wp_redirect( get_the_permalink( $this->data->options->frontend_dashboard_page ) );
		}
	}

	public function logout_redirect( $url, $request, $user ) {

		$page_id = $this->data->options->logout_page;

		if ( $page_id ) {
			wp_redirect( get_the_permalink( $page_id ) );
			exit;
		}

		return $url;

	}

	public function login_redirect( $url, $request, $user ) {

		$page_id = $this->data->options->frontend_dashboard_page;

		if ( $page_id ) {
			wp_redirect( get_the_permalink( $page_id ) );
			exit;
		}

		return $url;

	}

	/**
	 * Redirects the user to the custom "Forgot your password?" page instead of
	 * wp-login.php?action=lostpassword.
	 */
	public function lostpassword_redirect() {
		if ( $this->data->options->lostpassword_page && $this->data->options->lostpassword_page ) {
			if ( is_user_logged_in() ) :
				wp_redirect( get_the_permalink( $this->data->options->frontend_dashboard_page ) );
				exit;
            elseif ( 'GET' === $this->data->server ) :
				wp_redirect( get_the_permalink( $this->data->options->lostpassword_page ) );
				exit;
			endif;
		}
	}

	function add_lost_password_link() {

		$redirect_url = '/home';

		$lostpassword_url = wp_lostpassword_url( $redirect_url );
		ob_start();
		?>
        <a href="<?php echo $lostpassword_url ?>"><?php _e( 'Lost Password?' ) ?></a>
		<?php

		$content = ob_get_clean();

		return $content;
	}

	function recaptcha() {
		ob_start();
		?>
        <h1>Recaptcha</h1>
		<?php
		wp_enqueue_script( 'recaptcha' );
		?>
        <div class="g-recaptcha" data-sitekey="6LcA3ycUAAAAADBsDT_yP5NWpJPCabq1K-er2qwT"></div>
		<?php
		$content = ob_get_clean();

		return $content;
	}

}