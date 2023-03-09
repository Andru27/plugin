<?php
/**
 * Plugin Name:       Tcard
 * Plugin URI:        https://addudev.com/work/tcard
 * Description:       Tcard plugin create multiple type of cards: profile, contact, address, login, register etc.
 * Version:           2.9.1
 * Author:            Cloanta Alexandru
 * Author URI:        https://www.addudev.com
 * Text Domain:       tcard
 * Domain Path:       /lang/
 **/
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

if ( ! class_exists( 'Tcard' ) ) :

	class Tcard {

		protected $loader;

		public $plugin_name;

		public $version;


		/**
	     * Constructor
	     */
		public function __construct() {

			$this->plugin_name = 'tcard';

			$this->version = '2.9.1';

			$this->constants();
			$this->classes();
			$this->admin();
			$this->front();
			$this->arcfilter();
			$this->loader->add_action( 'init', $this ,'load_plugin_textdomain');
			$this->run_loader();
		}

		/**
	     * Define Tcard constants
	     */
		private function constants() {
			
			$this->define('TCARD_NAME', 	  	$this->plugin_name );
			$this->define('TCARD_VERSION', 	  	$this->version);
			$this->define('TCARD_PATH', 	  	plugin_dir_path( __FILE__ ));
			$this->define('TCARD_BASE_URL',	  	trailingslashit(plugins_url('tcard')));
			$this->define('TCARD_ASSETS_URL', 	trailingslashit(TCARD_BASE_URL . 'assets'));
			$this->define('TCARD_ADMIN_URL',  	trailingslashit(TCARD_PATH . 'admin'));
			$this->define('TCARD_FRONT_URL', 	trailingslashit(TCARD_PATH . 'front'));
			$this->define('TCARD_CACHE_URL',	trailingslashit(TCARD_PATH . 'social_cache'));

	    }

	    private function define( $name, $value ) {
            if ( ! defined( $name ) ) {
                define( $name, $value );
            }
        }

		/**
	     * All Tcard classes
	     */
		private function classes() {

			require_once TCARD_PATH . 'inc/TcardLoader.php';

			require_once TCARD_ADMIN_URL . 'TcardAdmin.php';

			require_once TCARD_FRONT_URL . 'TcardFront.php';

			require_once TCARD_PATH . 'inc/arcfilter/arcfilter.php';

			$this->loader = new TcardLoader();

		}

		/**
	     * Tcard Set plugin_textdomain
	     */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				'tcard',
				FALSE,
				dirname( plugin_basename( __FILE__ ) ) . '/lang/'
			);
		}

		/**
	     * All Tcard Admin Hooks
	     */
		private function admin() {

			$tcardAdmin = new TcardAdmin();

			$this->loader->add_action( 'admin_menu', $tcardAdmin ,'add_tcard_page' );
			$this->loader->add_action( 'admin_enqueue_scripts', $tcardAdmin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $tcardAdmin, 'enqueue_scripts' );
			$this->loader->add_action( 'admin_post_tcard_create_group', $tcardAdmin, 'create_group' );
			$this->loader->add_action( 'admin_post_tcard_delete_group', $tcardAdmin, 'delete_group' );
			$this->loader->add_action( 'admin_post_tcard_update_group', $tcardAdmin, 'update_group' );
			$this->loader->add_action( 'wp_ajax_tcard_add_skin', $tcardAdmin, 'add_skin' );
			$this->loader->add_action( 'wp_ajax_tcard_delete_skin', $tcardAdmin, 'delete_skin' );
			$this->loader->add_action( 'wp_ajax_tcard_select_skin', $tcardAdmin, 'select_skin' );
			$this->loader->add_action( 'wp_ajax_tcard_add_element', $tcardAdmin, 'add_element' );
			$this->loader->add_action( 'wp_ajax_tcard_gallery_type', $tcardAdmin, 'gallery_type' );
			$this->loader->add_action( 'init', $tcardAdmin , 'TcardGutenberg' );
		}

		/**
	     * All Tcard Front Hooks
	     */
		private function front() {

			$TcardFront = new TcardFront();

			$this->loader->add_action( 'wp_enqueue_scripts', $TcardFront, 'enqueue_styles', 30 );
			$this->loader->add_action( 'wp_enqueue_scripts', $TcardFront, 'enqueue_scripts', 30  );
			$this->loader->add_action( 'init', $TcardFront, 'add_filters_shortcode' );
			$this->loader->add_action( 'wp_ajax_tcard_user_images', $TcardFront, 'user_images' );
			$this->loader->add_action( 'wp_ajax_tcard_contact', $TcardFront, 'contact' );
			$this->loader->add_action( 'wp_ajax_nopriv_tcard_contact', $TcardFront, 'contact' );
			$this->loader->add_action( 'widgets_init', $TcardFront, 'load_widget' );
			
		}

		private function arcfilter(){

			$arcfilter = new Arcfilter($this->loader);
		}

		private function run_loader() {
			$this->loader->run();
		}

		/**
	     * Tcard Initialisation
	     */

		public static function init() {
			
			$tcard = new self();

		}
	}

	/**
	 * Activate Tcard
	 */
	function activate_tcard() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/TcardActivate.php';
		TcardActivate::activate();
	}
	register_activation_hook( __FILE__, 'activate_tcard' );

	/**
	 * Deactivate Tcard
	 */
	function deactivate_tcard() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/TcardDeactivate.php';
		TcardDeactivate::deactivate();
	}
	register_deactivation_hook( __FILE__, 'deactivate_tcard' );

	add_action( 'plugins_loaded', array( 'Tcard', 'init' ), 10 );

endif;