<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterItems 
{

	/**
	 * @since    2.0.5
	 */
	public function show_items($url,$group_id){

		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$arcfilter =  $wpdb->get_row("SELECT * FROM $arcfilter_table WHERE group_id = $group_id");

		$this->items($url,$arcfilter,$group_id,$params = null,$all_items = null);
	}

	/**
	 * Get all items
	 * @since    2.0.5
	 */
	public function items($url,$arcfilter,$group_id,$params,$all_items){

		if(!empty($arcfilter->cat_number)){
			$cat_number = $arcfilter->cat_number;
			$start_count = 0;
		}else{
			$cat_number = "";
			$start_count = "";
		}
		
		if(!empty($arcfilter->closed)){
			$checkClosed = unserialize($arcfilter->closed);	
		}
		
		require_once ARCFILTER_PATH . "inc/ArcfilterController.php";
		$ArcfilterController = new ArcfilterController();

		$set_settings = $ArcfilterController->settings->get_settings($group_id,'back');
		$categories = $ArcfilterController->category->get_category($arcfilter,$category = null);

		$category_type = $arcfilter->category_type;

		$stop = 0;
		if(!empty($_REQUEST['tcardArc_category']) && $set_settings['display_type'] == "pagination"){
			$stop = $set_settings['first_items'];
		}else{
			if(empty($all_items)){
				if($set_settings['display_items'] !== "hidden"){
					$stop = $set_settings['first_items'];
				}
			}
			else{
				$stop = $set_settings['more_items'];
			}
		}

		if($url == ARCFILTER_ADMIN_URL){
			for ($category = $start_count; $category < $cat_number; $category++){
				
				$output_items = $this->get_items($arcfilter,$category);
				$output = $ArcfilterController->category->get_category($arcfilter,$category);

				require $url . "templates/ArcfilterItemsTemplate.php";
			}
		}else{

			if(!empty($_REQUEST['tcardArc_category']) && $set_settings['display_type'] == "pagination"){
				if($_REQUEST['tcardArc_category'] == "all"){
					$category_items = $categories['set']['category_id'];
					$params['category_active'] = "all";
				}else{
					if($category_type == "tcard"){
						foreach ($categories['set']['category_slug'] as $key => $slug) {
							if($slug == $_REQUEST['tcardArc_category']){
								$category_items[] = $categories['set']['category_id'][$key];
							}
						}
					}
					else{
		
						if(!in_array($_REQUEST['tcardArc_category'], $categories['set']['category_slug'])){

							$termchildren = get_terms(array('slug' => $_REQUEST['tcardArc_category']));
							foreach ($termchildren as $key => $value){
								$category_items[] = $value->term_id;
							}
							
						}else{

							for ($category = $start_count; $category < $cat_number; $category++){

								$output = $ArcfilterController->category->get_category($arcfilter,$category);
								if($_REQUEST['tcardArc_category'] == $output['category_slug']){
									$category_items[] = $output['category_id'];
								}
					
							}

						}
					}
					$params['category_active'] = $_REQUEST['tcardArc_category'];
				}

				if(!empty($_REQUEST['tcardArc_page'])){
					$cat_page = (int)$_REQUEST['tcardArc_page'] - 1;
				}else{
					$cat_page = 0;
				}
				
				if(!empty($params['start_page'])){
					$start = (int)$params['start_page'] * (int)$set_settings['first_items'];
				}else{
					$start = (int)($cat_page) * (int)$set_settings['first_items'];
				}
			}
			elseif(empty($_REQUEST['tcardArc_category']) && $set_settings['display_type'] == "pagination"){
				$category_items = $categories['set']['category_id'];
				$params['category_active'] = "all";

				if(!empty($_REQUEST['tcardArc_page'])){
					$cat_page = (int)$_REQUEST['tcardArc_page'] - 1;
				}else{
					$cat_page = 0;
				}

				if(!empty($params['start_page'])){
					$start = (int)$params['start_page'] * (int)$set_settings['first_items'];
				}else{
					$start = (int)($cat_page) * (int)$set_settings['first_items'];
				}
			}
			else{

				if(!empty($params['category_active'])){
					if($params['category_active'] == "all"){
						$category_items = $categories['set']['category_id'];
					}else{
						if($category_type == "tcard"){
							foreach ($categories['set']['category_slug'] as $key => $slug) {
								if($slug == $params['category_active']){
									$category_items[] = $categories['set']['category_id'][$key];
								}
							}
						}
						else{
							if(!in_array($params['category_active'], $categories['set']['category_slug'])){
								$termchildren = get_terms(array('slug' => $params['category_active']));
								foreach ($termchildren as $key => $value){
									$category_items[] = $value->term_id;
								}
							}else{
								for ($category = $start_count; $category < $cat_number; $category++){
									$output = $ArcfilterController->category->get_category($arcfilter,$category);
									if($output['category_slug'] == $params['category_active']){
										$category_items[] = $output['category_id'];
									}
								}
							}
						}
					}
				}else{
					$category_items = $categories['set']['category_id'];
					$params['category_active'] = "all";
				}
				$start = 0;
			}

			(!empty($category_items)) ? $category_items : $category_items = "";
		
			if(empty($all_items)){
				$all_items_arc = array();
			}else{
				$all_items_arc = $all_items;
			}

			if($category_type == "tcard") {

				require_once ARCFILTER_FRONT_URL . "classes/GetTcardSkins.php";
				GetTcardSkins::get_all_skins($categories,$category_items,$set_settings,$start,$stop,$all_items_arc);	
			}
			elseif($category_type == "woocommerce" && self::isWooCommerce() || $category_type == "post"){
				
				if(!empty($_REQUEST['min_price']) && !empty($_REQUEST['max_price'])){
					$params['min_price'] = $_REQUEST['min_price'];
					$params['max_price'] = $_REQUEST['max_price'];
				}

				require_once ARCFILTER_FRONT_URL . "classes/GetWPPosts.php";
				GetWPPosts::get_all_posts($category_type,$set_settings,$categories,$arcfilter,$start,$stop,$params,$category_items,$all_items_arc);
			}
		}

	}

	/**
	 * Get all items settings
	 * @since    2.0.5
	 */
	public function get_items($arcfilter,$category){
		
		if(!empty($arcfilter->items))	
		$items = unserialize($arcfilter->items);
		$output = array();

		if(!empty($items["cat_items$category"])){
            foreach ($items["cat_items$category"] as $style => $item) {
                if(!empty($item)){
                	$output[$style] = $item;
                }
            }
        }
  		
		return $output;
	}

	/**
	 * Check if WooCommerce is activated
	 */
    public static function isWooCommerce(){
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}