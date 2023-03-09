<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardActivate 
{

	/**
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/TcardTables.php';
		TcardTables::create_tables();
		flush_rewrite_rules();
	}

}