<?php
/**
 * Plugin Name: WP Login Handling
 * Description: Plugin for handling login and redirection
 * Version: 1.0
 * Author: Knoxweb
 * Author URI: http://knoxweb.com
 * License:
 */

namespace Knoxweb\WPLH;

defined( 'ABSPATH' ) or die;

require_once 'includes/class.helpers.php';
require_once 'includes/class.get-data.php';
require_once 'includes/class.assets.php';
require_once 'includes/class.cmb2check.php';
require_once 'includes/class.options-page.php';
require_once 'includes/class.options-meta.php';
require_once 'includes/class.login.php';
require_once 'includes/class.lostpassword.php';

use Knoxweb\WPLH\Data;
use Knoxweb\WPLH\Assets;
use Knoxweb\WPLH\CMB2Check;
use Knoxweb\WPLH\Options;
use Knoxweb\WPLH\Options_Meta;
use Knoxweb\WPLH\Login;
use Knoxweb\WPLH\LostPassword;

add_action( 'plugins_loaded', __NAMESPACE__ . '\\start_plugin' );
function start_plugin() {
	$data = new Data\Object();
	new Assets\Assets();
	new CMB2Check\CMB2Check();
	new Options\Register();
	new Options_Meta\Options_Meta();
	new Login\Login( $data );
	new LostPassword( $data );
}




