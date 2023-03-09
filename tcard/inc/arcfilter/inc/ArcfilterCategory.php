<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterCategory
{

	/**
	 * Show Categories
	 * @since    2.0.5
	 */
	public function show_categories($url,$group_id,$type){
		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$categories =  $wpdb->get_row("SELECT category_type,cat_number,categories FROM $arcfilter_table WHERE group_id = $group_id");

		$this->categories($group_id,$url,$categories,$type);
	}

	/**
	 * Set all categories
	 * @since    2.0.5
	 */
	public function categories($group_id,$url,$categories,$type){


		(!empty($categories->category_type)) ? $category_type = $categories->category_type : $category_type = "";
		(!empty($categories->cat_number)) ? $cat_number = $categories->cat_number : $cat_number = "";
		
		if($url == ARCFILTER_ADMIN_URL){

			for ($category = 0; $category < $cat_number; $category++){

				$output = $this->get_category($categories,$category);

			  	require $url . "templates/ArcfilterCategoryTemplate.php";
			}

		}else{
			require_once ARCFILTER_PATH . "inc/ArcfilterController.php";
			$ArcfilterController = new ArcfilterController();

			$set_settings = $ArcfilterController->settings->get_settings($group_id,'front');
			$get_categories = $this->get_category($categories,$category = null);

			$items_number = 0;

			if($category_type == "post"){
				$post_args = array(
					'posts_per_page'   => -1,
					'category__in'     => $get_categories['set']['category_id'],
					'orderby'          => "date",
					'order'            => "ASC",
					'post_type'        => 'post',
					'post_status'      => 'publish',
					'suppress_filters' => true 
				);

				$posts = get_posts( $post_args );

				$items_number = count($posts);
			}
			elseif($category_type == "woocommerce"){
				$post_args = array(
					'posts_per_page'   => -1,
					'orderby'          => "date",
					'order'            => "ASC",
					'post_type'        => 'product',
					'post_status'      => 'publish',
					'tax_query' => array( 
					    array(
					      'taxonomy' => 'product_cat',
					      'field' => 'id',
					      'terms' => $get_categories['set']['category_id']
					    )
					)
				);

				$posts = get_posts( $post_args );

				$items_number = count($posts);
			}
			else{
				if(!empty($get_categories['set']['category_items'])){
					foreach ($get_categories['set']['category_items'] as $value) {
						$items_number += $value;
					}
				}
			}

			if($set_settings['counter'] == "onhover"){
				$onhover = 'onhover';
			}
			else{
				$onhover = '';
			}
				
			$menu_style = $get_categories['style']['style_type'];
			
			if($type == "menu"){
				if($set_settings['use_sidebar_cat'] == 0){
					require $url . "templates/filter/MenuTemplate.php";
				}
			}else{
				if($set_settings['use_sidebar'] == 1 && self::isWooCommerce()){

					$price = self::get_min_max_price($get_categories);
					$all_tags = self::get_product_tags($get_categories,$post_args);

					(!empty($set_settings['wc_sidebar_attribute'])) ? $wc_sidebar_attribute = $set_settings['wc_sidebar_attribute'] : $wc_sidebar_attribute = "";

					$all_attribute = self::get_product_attr($get_categories,$wc_sidebar_attribute);

					if(empty($_REQUEST['min_price']) || $_REQUEST['min_price'] == 0){
						$start = $price['min'];
					}else{
						$start = $_REQUEST['min_price'];
					}

					if(empty($_REQUEST['max_price']) || $_REQUEST['max_price'] == 0){
						$stop = $price['max'];
					}else{
						$stop = $_REQUEST['max_price'];
					}

					(!empty($_REQUEST['tags'])) ? $selected_tags = explode(" ", $_REQUEST['tags']) : $selected_tags = array();
		
					require_once $url . "templates/filter/WcSidebarTemplate.php";
				}
			}			
		}
	}

	/**
	 * Get price: min > max
	 * @since    2.7.0
	 */
	public static function get_min_max_price($categories){

		$products_args = array(
			'posts_per_page'   	=> -1,
			'post_type'        	=> 'product',
			'post_status'      	=> 'publish',
			'meta_key' 		   	=> '_price',
		    'orderby' 			=> 'meta_value_num',
		    'order' 			=> 'ASC',
			'tax_query' => array( 
			    array(
			      'taxonomy' => 'product_cat',
			      'field' => 'id',
			      'terms' => $categories['set']['category_id']
			    )
			) 
		);

		$get_products = get_posts( $products_args );
		$all_prices = array();
		if(!empty($get_products)){
			foreach ($get_products as $item => $get_product) {
				$product = wc_get_product($get_product->ID);
				$product_price = get_post_meta( $product->get_id(),'_price' );
				$all_prices[] = $product_price[0]; 
			}

			$max = count($all_prices) - 1;
			$price = array(
				"min" => $all_prices[0],
				"max" => $all_prices[$max],
			);
		}

		return $price;
	}

	/**
	 * Get products tags
	 * @since  	2.7.1
	 */
	public static function get_product_tags($categories,$post_args){

		$get_products = get_posts( $post_args );
		$all_tags = array();

		if(!empty($get_products)){
			foreach ($get_products as $item => $get_product) {
				$product = wc_get_product($get_product->ID);
				$tags = get_the_terms( $product->get_id(), 'product_tag' );
				if(!empty($tags))
				foreach ($tags as $key => $tag) {
					$all_tags['slug'][] = $tag->slug;
					$all_tags['name'][] = $tag->name;
				}
			}

			$all_tags['slug'] = array_unique($all_tags['slug']);
			$all_tags['name'] = array_unique($all_tags['name']);
		}

		return $all_tags;
	}

	/**
	 * Get products attribute
	 * @since    2.7.1
	 */
	public static function get_product_attr($categories,$wc_sidebar_attribute){

		$products_args = array(
			'posts_per_page'   	=> -1,
			'post_type'        	=> 'product',
			'post_status'      	=> 'publish',
			'meta_key' 		   	=> '_product_attributes',
		    'order' 			=> 'ASC',
			'tax_query' => array( 
			    array(
			      'taxonomy' => 'product_cat',
			      'field' => 'id',
			      'terms' => $categories['set']['category_id']
			    )
			) 
		);

		$get_products = get_posts( $products_args );
		$all_attribute = array();


		if(!empty($get_products)){
			foreach ($get_products as $item => $get_product) {
				$product = wc_get_product($get_product->ID);
				$product_attributes = get_post_meta( $product->get_id(),'_product_attributes' );
				foreach ($product_attributes as $key => $attr) {
					if(!empty($wc_sidebar_attribute["name"]))
					foreach ($wc_sidebar_attribute["name"] as $key => $name) {

						if(!empty($attr["pa_".$name])){
							$all_attr = get_the_terms( $product->get_id(), "pa_".$name );
							foreach ($all_attr as $key => $slug) {
								$all_attribute["pa_".$name]['slug'][] 	= $slug->slug;
								$all_attribute["pa_".$name]['name'][] 	= $slug->name;
							}
						}
					}
				}
			}

			foreach ($all_attribute as $key => $value) {
				if($key !== "label"){
					$all_attribute[$key]['slug'] = array_unique($value['slug']);
					$all_attribute[$key]['name'] = array_unique($value['name']);
				}else{
					$all_attribute[$key] = array_unique($value);
				}
			}
		}

		return $all_attribute;
	}

	/**
	 * Get all subcategories
	 * @since    2.6.0
	 */
	public static function menu_lvl($taxonomies, $termID,$parentSlug,$lvl = 0){
		
	    $terms = get_terms($taxonomies,array('parent' => $termID));
	    $lvl++;

        foreach ($terms as $key => $term) {

        	$parentSlug[$lvl] = $term->slug;
        	$slugs = implode(" ", $parentSlug);

        	$has_child = get_terms($taxonomies,array('parent' => $term->term_id));
       		if(!empty($has_child)){
				$subnav_has_child = "<span class='subnav_has_child'></span>";
			}else{
				$subnav_has_child = "";
			}

	       	if(empty($output)){
	 			$output = "<ul class='arc-subnav arc-nav-lvl$lvl'>
					<li class='arc-nav-item-list' data-nav-lvl='$lvl'>
						<p class='arc-subnav-item arc-nav-item' data-item-lvl='$lvl' data-items='$term->count'  data-parent='$slugs' data-category='$term->slug'>
							".$term->name."	
							<span class='arc-filter-counter sub-items-counter'>(".$term->count.")</span>
							$subnav_has_child
						</p>";
						$output .=  self::menu_lvl($taxonomies, $term->term_id,$parentSlug,$lvl);
					$output .="</li>";
				
        	}else{
        		$output .= "<li class='arc-nav-item-list' data-item-lvl='$lvl'>
					<p class='arc-subnav-item arc-nav-item' data-items='$term->count' data-item-lvl='$lvl' data-parent='$slugs' data-category='$term->slug'>
						".$term->name."
						<span class='arc-filter-counter sub-items-counter'>(".$term->count.")</span>
						$subnav_has_child
					</p>";
					$output .=  self::menu_lvl($taxonomies, $term->term_id,$parentSlug,$lvl);
				$output .="</li>";
        	}
        }
	    
	    if(!empty($output))
	    return $output."</ul>";
	}

	/**
	 * Get all categories
	 * @since    2.0.5
	 */
	public function get_category($categories,$category){
		
		if(!empty($categories)){
			$categories = unserialize($categories->categories);
		}

		$emptyValues = array('category_name','category_group','category_id','category_slug');

		if($category !== null){
			if(!empty($categories['set'])){
				foreach ($categories['set'] as $key => $cate) {
					if(!empty($cate[$category]))
					$output[$key] = html_entity_decode(stripslashes($cate[$category]));
				}
			}

			foreach ($emptyValues as $key) {
				if(empty($output[$key])){
					$output[$key] = "";
				}
			}

			(!empty($output['category_name'])) ? $output['category_name'] : $output['category_name'] = $output['category_id'];

			return $output;
		}else{

			($categories['style']['style_type']) ? $categories['style']['style_type'] : $categories['style']['style_type'] = "";

			foreach ($emptyValues as $key) {
				if(empty($categories['set'][$key])){
					$categories['set'][$key] = "";
				}
			}

			return $categories;
		}
	}

	/**
	 * Check if WooCommerce is activated
	 */
    public static function isWooCommerce(){
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}