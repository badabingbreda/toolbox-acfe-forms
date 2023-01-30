<?php
/**
 * Toolbox ACF Extended Forms
 *
 * @package     ToolboxACFEFroms
 * @author      Badabingbreda
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Toolbox ACF Extended Forms
 * Plugin URI:  https://www.badabing.nl
 * Description: Use Twig template to render ACF Extended Form
 * Version:     1.0.1
 * Author:      Badabingbreda
 * Author URI:  https://www.badabing.nl
 * Text Domain: toolboxacfeforms
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

use ToolboxACFEForms\Autoloader;
use ToolboxACFEForms\Init;

if ( defined( 'ABSPATH' ) && ! defined( 'TOOLBOXACFEFORMS_VERION' ) ) {
 register_activation_hook( __FILE__, 'TOOLBOXACFEFORMS_check_php_version' );

 /**
  * Display notice for old PHP version.
  */
 function TOOLBOXACFEFORMS_check_php_version() {
     if ( version_compare( phpversion(), '5.3', '<' ) ) {
        die( esc_html__( 'Toolbox ACFE Forms requires PHP version 5.3+. Please contact your host to upgrade.', 'toolboxacfeforms' ) );
    }
 }

  define( 'TOOLBOXACFEFORMS_VERSION'   , '1.0.1' );
  define( 'TOOLBOXACFEFORMS_DIR'     , plugin_dir_path( __FILE__ ) );
  define( 'TOOLBOXACFEFORMS_FILE'    , __FILE__ );
  define( 'TOOLBOXACFEFORMS_URL'     , plugins_url( '/', __FILE__ ) );

  define( 'CHECK_TOOLBOXACFEFORMS_PLUGIN_FILE', __FILE__ );

}

if ( ! class_exists( 'ToolboxACFEForms\Init' ) ) {

 /**
  * The file where the Autoloader class is defined.
  */
  require_once 'inc/Autoloader.php';
  spl_autoload_register( array( new Autoloader(), 'autoload' ) );

 $plugin_var = new Init();
 // looking for the init hooks? Find them in the Check_Plugin_Dependencies.php->run() callback

}
