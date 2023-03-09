<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterFront
{

	/**
	 * Construct
	 * @since    2.0.5
	 */
	public function __construct(){

		require_once ARCFILTER_PATH . 'inc/ArcfilterAjax.php';

	}	

	/**
	 * Register the stylesheets for the arcfilter front area.
	 * @since    2.0.5
	 */
	public function enqueue_styles($hook) {

		wp_enqueue_style( "jquery-ui-slider-css" , ARCFILTER_BASE_URL . "assets/jquery-slider/jquery-ui.min.css", "" , TCARD_VERSION );
		wp_enqueue_style( ARCFILTER_NAME , ARCFILTER_BASE_URL . 'front/css/arcfilter.min.css', "" , TCARD_VERSION );
	}

	/**
	 * Register the JavaScript for the arcfilter front area.
	 * @since    2.0.5
	 */
	public function enqueue_scripts($hook) {
		
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script( ARCFILTER_NAME , ARCFILTER_BASE_URL . 'front/js/arcfilter.min.js', array( 'jquery' ), TCARD_VERSION, false );
 		
		wp_localize_script( ARCFILTER_NAME, 'arcfilter_ajax', array(
			'ajaxurl' 				=> admin_url('admin-ajax.php'),
			'pageurl'				=> $_SERVER["REQUEST_URI"],
			'arcfilter_load_items' 	=> wp_create_nonce("arcfilter_load_items")
		));	
	}


	/**
	 * Shortcode.
	 * @since    2.0.5
	 */
	public function add_shortcode(){
		add_shortcode('arcfilter',array( $this , 'group' ));
	}


	/**
	 * Display group for the public-facing side of the site.
	 * @since    2.0.5
	 */
	public function group($attr){

		extract(shortcode_atts(array(
                'group_id' => ''
                    ), $attr));

		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$group = $wpdb->get_row("SELECT * FROM $arcfilter_table WHERE group_id = $group_id");

		if(!empty($group->title)){
			$group_title = $group->title;
		}
		else{
			$group_title = "";
		}
		
		if(!empty($group->category_type)){
			$category_type = $group->category_type;
		}else{
			$category_type = "";
		}

		require_once ARCFILTER_PATH . "inc/ArcfilterController.php";
		$ArcfilterController = new ArcfilterController();

		$get_categories = $ArcfilterController->category->get_category($group,$category = null);
		$set_settings = $ArcfilterController->settings->get_settings($group_id,'front');

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

			global $wpdb;
			$tcard_table = $wpdb->prefix.'tcards';
			$tcard_output = $wpdb->get_results("SELECT * FROM $tcard_table");

			if(!empty($get_categories['set']['category_items'])){
				foreach ($get_categories['set']['category_items'] as $value) {
					$items_number += $value;
				}
			}
		}

		if(!empty($_REQUEST['tcardArc_category']) && $set_settings['display_type'] == "pagination"){
			$category_page = $_REQUEST['tcardArc_category'];
		}else{
			$category_page = 'all';
		}

		if(!empty($_REQUEST['tcardArc_page']) && $set_settings['display_type'] == "pagination"){
			$data_page = $_REQUEST['tcardArc_page'];
		}else{
			$data_page = 1;
		}

	    if($set_settings['first_items'] == "'all'"){
    		$calc_pages = ceil($items_number / $items_number);
    	}else{
    		$calc_pages = ceil($items_number / $set_settings['first_items']);
    	}

    	if(!empty($set_settings['use_sidebar']) && $set_settings['use_sidebar'] == 1){
			$menu_type = 'arc-nav-sidebar' . " ". $get_categories['style']['style_type'] . " " .$set_settings['filter_position'] . " " .$set_settings['filter_animation'];
			$wc_filter_sidebar = 'wc_filter_sidebar';
			$btn_type = "arc_sidebar-btn";
			$filter_position = 'data-dirr='.ucfirst($set_settings['filter_position']).'';
		}else{
			$menu_type = '';
			$wc_filter_sidebar = '';
			$btn_type = '';
			$filter_position = '';
		}
	
		if($category_type == "woocommerce"){
			$all_params = array("tcardArc_category","tcardArc_page","min_price","max_price",'tags');
			if(!empty($set_settings['wc_sidebar_attribute'])){
				foreach ($set_settings['wc_sidebar_attribute'] as $attribute_name) {
					foreach ($attribute_name as $key => $name) {
						array_push($all_params,$set_settings['wc_sidebar_attribute']["name"][$key]);
					}
				}
			}
		}else{
			$all_params = array("tcardArc_category","tcardArc_page");
		}

		$all_params = json_encode($all_params);

		if(empty($group) && !empty($group_id)){
			return "<h3 class='tcard-not-group'>Arcfilter group-$group_id does not exist!!</h3>";
		}else{
			if(!empty($group_id)){
				ob_start();
			  		 require ARCFILTER_FRONT_URL . "templates/ArcfilterGroup.php";
			 	return ob_get_clean();
			}
		}
	
	}

	/**
	 * Add css for custom skin when using the front_frostedglass or back_frostedglass option
	 * @since    2.0.5
	 */
	public static function add_custom_inline_css($skin_type,$skins_number,$group_id,$arcfilter){

		global $wpdb;
		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$get_skins =  $wpdb->get_results("SELECT settings FROM $tcard_skin_table WHERE group_id = $group_id");
		$pre_skin = self::check_pre_skins($skin_type);
		require_once TCARD_PATH . "inc/TcardStyle.php";

		if($skin_type !== $pre_skin){
			$css ='<style type="text/css">';
				for ($skin = 0; $skin < $skins_number; $skin++){
					if(!empty($get_skins[$skin]->settings)){
						$customSkin = unserialize($get_skins[$skin]->settings);
					}
					$css .= TcardStyle::set_style($customSkin,'front','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'back','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'header-front','glass_front',$group_id,$skin,$arcfilter);;
					$css .= TcardStyle::set_style($customSkin,'header-back','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'content-front','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'content-back','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'footer-front','glass_front',$group_id,$skin,$arcfilter);
					$css .= TcardStyle::set_style($customSkin,'footer-back','glass_front',$group_id,$skin,$arcfilter);
				}
			$css .='</style>';
			return $css;
		}
	}

	/**
	 * Check if is one of pre-made skins
	 * @since    1.0.0
	 */
	public static function check_pre_skins($skin_type){

		$pre_skin_type = array("skin_1","skin_2","skin_3","skin_4","skin_5","skin_6");

		foreach ($pre_skin_type as $pre_skin) {
			if($skin_type == $pre_skin){
				return $pre_skin;
			}
		}
	}

	 /**
     * @since 2.0.5
     */
	public function load_items(){
		ArcfilterAjax::load_items();
	}

}