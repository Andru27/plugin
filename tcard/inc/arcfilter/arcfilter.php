<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class Arcfilter 
{

	protected $loader;

	public $plugin_arcfilter;

	public function __construct($loader){

		$this->plugin_arcfilter = 'arcfilter';

		$this->loader = $loader;
		$this->constants();
		$this->admin();
		$this->front();
	}

	/**
     * Define Arcfilter constants
     */
	private function constants() {
		
		$this->define('ARCFILTER_NAME', 	  				$this->plugin_arcfilter );
		$this->define('ARCFILTER_PATH', 	  				plugin_dir_path( __FILE__ ));
		$this->define('ARCFILTER_BASE_URL',	  				trailingslashit(plugins_url('tcard/inc/arcfilter')));
		$this->define('ARCFILTER_ADMIN_URL',  				trailingslashit(ARCFILTER_PATH . 'admin'));
		$this->define('ARCFILTER_ASSETS_URL', 				trailingslashit(ARCFILTER_BASE_URL . 'assets'));
		$this->define('ARCFILTER_FRONT_URL', 				trailingslashit(ARCFILTER_PATH . 'front'));
    }

    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

	public function admin(){

		require_once ARCFILTER_ADMIN_URL . 'ArcfilterAdmin.php';

		$ArcfilterAdmin  = new ArcfilterAdmin();

		$this->loader->add_action( 'admin_menu', $ArcfilterAdmin ,'add_arcfilter_page' );
		$this->loader->add_action( 'admin_enqueue_scripts', $ArcfilterAdmin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $ArcfilterAdmin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_post_arcfilter_create_group', $ArcfilterAdmin, 'create_group' );
		$this->loader->add_action( 'admin_post_arcfilter_delete_group', $ArcfilterAdmin, 'delete_group' );
		$this->loader->add_action( 'admin_post_arcfilter_update_group', $ArcfilterAdmin, 'update_group' );
		$this->loader->add_action( 'wp_ajax_arcfilter_select_category', $ArcfilterAdmin, 'select_category' );
		$this->loader->add_action( 'wp_ajax_arcfilter_add_category', $ArcfilterAdmin, 'add_category' );
	}

	public function front(){

		require_once ARCFILTER_FRONT_URL . 'ArcfilterFront.php';

		$ArcfilterFront  = new ArcfilterFront();

		$this->loader->add_action( 'init', $ArcfilterFront, 'add_shortcode' );
		$this->loader->add_action( 'wp_enqueue_scripts', $ArcfilterFront, 'enqueue_styles', 30 );
		$this->loader->add_action( 'wp_enqueue_scripts', $ArcfilterFront, 'enqueue_scripts', 30 );
		$this->loader->add_action( 'wp_ajax_arcfilter_load_items', $ArcfilterFront, 'load_items' );
		$this->loader->add_action( 'wp_ajax_nopriv_arcfilter_load_items', $ArcfilterFront, 'load_items' );
	}

}