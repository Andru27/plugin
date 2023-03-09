<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterAjax
{
	
	/**
	 * @since    2.0.5
	 */

	public static function select_category(){
		
		check_ajax_referer( 'arcfilter_select_category', 'security' );

		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$group_id = sanitize_text_field($_POST['group_id']);
		$category_type = sanitize_text_field($_POST['category_type']);
		$cat_number = 0;
		$categories = "";

		$wpdb->query( $wpdb->prepare("INSERT INTO $arcfilter_table ( group_id ,category_type,cat_number,categories ) 
                VALUES ( %d, %s, %s, %s)
                ON DUPLICATE KEY 
                UPDATE category_type = %s, cat_number = %s, categories = %s", 
                $group_id,$category_type,$cat_numbe,$categories,$category_type,$cat_numbe,$categories
            ) 
        );

		die();
	}

	/**
	 * @since    2.0.5
	 */
	public static function add_category(){

		check_ajax_referer( 'arcfilter_add_category', 'security' );

		$group_id = sanitize_text_field($_POST['group_id']);
		$category = sanitize_text_field($_POST['number']);
		$output['category_id'] 		= sanitize_text_field($_POST['category_id']);
		$output['category_type'] 	= sanitize_text_field($_POST['category_type']);
		$output['category_slug'] 	= sanitize_text_field($_POST['category_slug']);
		$output['category_items']	= sanitize_text_field($_POST['category_items']);
		$output['category_name'] 	= html_entity_decode(stripslashes($_POST['category_name']));

		require_once ARCFILTER_PATH . "inc/ArcfilterController.php";
		$ArcfilterController = new ArcfilterController();

		$category_type = $output['category_type'];

		ob_start();
			require ARCFILTER_ADMIN_URL . "templates/ArcfilterCategoryTemplate.php";
		$html_category = ob_get_clean();

		ob_start();
			require ARCFILTER_ADMIN_URL . "templates/ArcfilterItemsTemplate.php";
		$html_items = ob_get_clean();

		$html = array(
			"items" => $html_items,
			"category" => $html_category
		);

		ob_get_clean();
		ob_clean();
        echo json_encode($html);

		die();
	}

	/**
	 * @since    2.0.5
	 */
	public static function load_items(){

		check_ajax_referer( 'arcfilter_load_items', 'security' );

		global $wpdb;
		
		$group_id = sanitize_text_field($_POST['group_id']);
		$pageurl = sanitize_text_field($_POST['pageurl']);

		(!empty($_POST['category'])) ? $category_active = sanitize_text_field($_POST['category']) : $category_active = sanitize_text_field($_POST['tcardArc_category']);

		$all_items = $_POST['all_items'];

		$start_page = sanitize_text_field($_POST['start_page']);

		$min_price = sanitize_text_field($_POST['min_price']);

		$max_price = sanitize_text_field($_POST['max_price']);

		$tags = $_POST['tags'];

		$attributes = $_POST['attributes'];

		$params = array(
			"category_active" 	=> $category_active,
			"start_page"		=> $start_page,
			"pageurl"			=> $pageurl,
			"price"				=> array(
				"min_price"			=> $min_price,
				"max_price"			=> $max_price
			),
			"tags"				=> $tags,
			"attributes"		=> $attributes
		);

		$params["attributes"] = stripslashes(html_entity_decode($params['attributes']));
		$params["attributes"] = json_decode($params["attributes"],true);
		
		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$arcfilter =  $wpdb->get_row("SELECT * FROM $arcfilter_table WHERE group_id = $group_id");
		
		require_once ARCFILTER_PATH . "inc/ArcfilterController.php";
		$ArcfilterController = new ArcfilterController();

		ob_start();
			$ArcfilterController->items->items(ARCFILTER_FRONT_URL,$arcfilter,$group_id,$params,$all_items);
		$items = ob_get_clean();
		
		ob_get_clean();
		ob_clean();
		echo $items;

		die();
	}
}
