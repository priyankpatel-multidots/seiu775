<?php
/**
 * @author            Kona Macphee <kona@fidgetylizard.com>
 * @since             1.0.0
 * @package           Skip_Confirmation_On
 *
 * @wordpress-plugin
 * Plugin Name:       Skip Confirmation On
 * Plugin URI:        https://wordpress.org/plugins/skip-confirmation-on/
 * Description:       Changes the tickbox default to NOT send an email to a new user when adding them to a WordPress or WordPress Multisite website.
 * Version:           1.0.2
 * Author:            Fidgety Lizard
 * Author URI:        https://fidgetylizard.com
 * Contributors:			fliz, kona
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       skip-confirmation-on
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Skip_Confirmation_On' ) )
{
  class Skip_Confirmation_On
  {
    /**
     * Construct the plugin object
     */
    public function __construct()
    {
			// We want our scripts queued on the admin side only
			add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );	

			// Prepare for i18n translations
			add_action( 'plugins_loaded', array( $this, 'load_my_textdomain' ) );
		
    } // END public function __construct

    /**
     * Activate the plugin
     */
    public static function activate()
    {
      // Nothing to do here
    } // END public static function activate

    /**
     * Deactivate the plugin
     */
    public static function deactivate()
    {
      // Nothing to do here
    } // END public static function deactivate

		/**
		 * Set up the necessary CSS and JS 
		 */
		public function add_scripts()
		{
			global $pagenow;
			if ( 'user-new.php' == $pagenow ) {
				if ( is_multisite() ) {
					// Add the JS that ticks the checkbox(es) if present
					wp_enqueue_script(
						'flizsco-checkbox-ms-js',
						plugin_dir_url( __FILE__ ) . 'js/flizsco-checkbox-ms.js',
						array( 'jquery' ) // Depends on jquery
					);
				}
				else {
					// Add the JS that ticks the checkbox(es) if present
					wp_enqueue_script(
						'flizsco-checkbox-js',
						plugin_dir_url( __FILE__ ) . 'js/flizsco-checkbox.js',
						array( 'jquery' ) // Depends on jquery
					);
				}
			}
    } // END public function add_scripts
 

		/**
		 * Set things up for i18n
		 */
		public function load_my_textdomain() 
		{
		  load_plugin_textdomain( 
				'skip-confirmation-on', 
				FALSE, 
				basename( dirname( __FILE__ ) ) . '/languages/' 
			);
		}
  } // END class Skip_Confirmation_On
} // END if ( ! class_exists( 'Skip_Confirmation_On' ) )



if ( class_exists( 'Skip_Confirmation_On' ) )
{
  // Installation and uninstallation hooks
  register_activation_hook(
		__FILE__, 
		array( 'Skip_Confirmation_On', 'activate' )
	);
  register_deactivation_hook(
		__FILE__, 
		array( 'Skip_Confirmation_On', 'deactivate' )
	);
  // instantiate the plugin class
  $wp_plugin_template = new Skip_Confirmation_On();
}
?>
