<?php

namespace Knoxweb\WPLH\CMB2Check;

class CMB2Check {
	public function __construct() {
		add_action( 'admin_notices', [ $this, 'admin_notice' ], 25 );
	}

	public function admin_notice() {
		if ( ! is_admin() ) {
			return;
		}

		if ( ! class_exists( 'CMB2_Base' ) ) {

			$link = site_url() . '/wp-admin/plugin-install.php?s=CMB2&tab=search'
			?>
			<div class="notice notice-success is-dismissible">
				<p>
					<strong><?php _e( 'WP Login Handling' ); ?></strong><?php _e( ' requires installing:' ); ?>
					<span>
						<a href="<?php echo esc_url( $link ); ?>">
							<strong><?php _e( 'CMB2' ); ?></strong>
							<?php _e( ' (By WebDevStudios)' ); ?>
						</a>
					</span>
				</p>
			</div>
			<?php
		}
	}
}

new CMB2Check();