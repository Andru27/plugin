<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardTables
{

	/**
	 * @since    1.0.0
	 */ 
	public static function create_tables(){
		global $wpdb;

		/**
		 * @since    1.0.0
		 */ 
		$charset_collate = $wpdb->get_charset_collate();

		$tcards_version = "1.2";
		$tcard_table_db_version = get_option( "tcards_table_db_version" );

		if ( $tcard_table_db_version != $tcards_version ) {

			$tcards = $wpdb->prefix . "tcards";

			$sql = "CREATE TABLE $tcards (
				group_id int(11) NOT NULL AUTO_INCREMENT,
				skin_type varchar(25) NOT NULL,
				skins_number int(11) NOT NULL,
				title text NOT NULL,
				slug text NOT NULL,
				publish_up datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				settings longtext NOT NULL,
				PRIMARY KEY (group_id)
			) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			update_option('tcards_table_db_version',$tcards_version);
		}

		/**
		 * @since    1.0.0
		 */ 
		$tcard_skins_version = "1.1";
		$tcard_skin_db_version = get_option( "tcard_skin_db_version" );

		if ( $tcard_skin_db_version != $tcard_skins_version ) {

			$tcard_skins = $wpdb->prefix . "tcard_skins";
		
			$sql_skin = "CREATE TABLE $tcard_skins (
				skin_id int(11) NOT NULL AUTO_INCREMENT,
				group_id int(11) NOT NULL,
				closed tinyint(1) NOT NULL,
				elements longtext NOT NULL, 
				header longtext NOT NULL, 
				content longtext NOT NULL, 
				footer longtext NOT NULL,
				gallery longtext NOT NULL,
				settings longtext NOT NULL,  
				PRIMARY KEY (skin_id)
			) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql_skin);
			update_option('tcard_skin_db_version',$tcard_skins_version);
		}

		/**
		 * @since    2.0.5
		 */ 
		$arcfilter_version = "1.0";
		$arcfilter_db_version = get_option( "arcfilter_db_version" );

		if ( $arcfilter_db_version != $arcfilter_version ) {

			$arcfilter = $wpdb->prefix . "arcfilter";
		
			$sql_arcfilter = "CREATE TABLE $arcfilter (
				group_id int(11) NOT NULL AUTO_INCREMENT,
				closed varchar(512) NOT NULL,
				category_type varchar(512) NOT NULL,
				cat_number tinyint(1) NOT NULL,
				title text NOT NULL,
				publish_up datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				categories longtext NOT NULL,
				items longtext NOT NULL,
				settings longtext NOT NULL,  
				PRIMARY KEY (group_id)
			) $charset_collate;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql_arcfilter);
			update_option('arcfilter_db_version',$arcfilter_version);
		}
	}
}