<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/classes
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class GetTcardSkins 
{
	public static function get_all_skins($categories,$category_items,$set_settings,$start,$stop,$all_items_tcard){

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';
		
		$type_action = "new-skin";


		$get_skins = array();
		$all_skin_type = array();
		$cat_slug = array();

		if(!empty($categories['set']['category_id'])){
			foreach ($categories['set']['category_id'] as $key => $category_id) {

				$get_all_skins = $wpdb->get_results("SELECT * FROM $tcard_skin_table WHERE group_id = $category_id");
				$group = $wpdb->get_results("SELECT * FROM $tcard_table WHERE group_id = $category_id");

				foreach ($get_all_skins as $key => $value) {
					$get_skins['skins'][] = $value;
					$get_skins['skin_index'][] = $key;

					foreach ($group as $gr => $set) {
						$get_skins['skin_type'][] = $set->skin_type;
						$cat_slug[$category_id][] = $set->slug;
					}
				}
			}
		}

		if(!empty($get_skins) && $set_settings['display_items'] == "hidden" || empty($set_settings['first_items'])){
			$stop = count($get_skins['skins']);
		}	
	
		require_once TCARD_PATH . "inc/TcardStyle.php";

		if(!empty($get_skins)){
			$all_skins = count($get_skins['skins']);
		}else{
			$all_skins = 0;
		}

		$count_item = -1;

		if($set_settings['display_type'] == "pagination"){
			if($start > $all_skins){
				echo '<div class="no-page">'.esc_html($set_settings['no_page']).'</div>;';
				return;
			}
		}

		for ($item=$start; $item < $all_skins; $item++) {

			if(!empty($get_skins['skins'][$item])){ 

				$skin = $get_skins['skin_index'][$item];	
				$skin_type = $get_skins['skin_type'][$item];
				$group_id = $get_skins['skins'][$item]->group_id;
					
				foreach ($category_items as $key => $cat_ID) {
					if($cat_ID == $group_id){
						if(!in_array($item, $all_items_tcard)){
							$count_item++;
							for ($load = 0; $load < $stop; $load++) { 
								if($count_item == $load){

									if($skin_type == "skin_5"){
										$args = array(
											'posts_per_page'   => $group->skins_number,
											'category_name'    => $group_settings["category_name"],
											'orderby'          => $group_settings['orderby_category'],
											'order'            => $group_settings['order_category'],
											'post_type'        => 'post',
											'post_status'      => 'publish',
											'suppress_filters' => true 
										);
										$posts = get_posts( $args );
									}

									$arcfilter = esc_attr("tcard$group_id");

									require_once TCARD_PATH . "inc/TcardElementsController.php";
									$elementsController = new TcardElementsController($group_id, TCARD_FRONT_URL);


									if(!empty($get_skins['skins'][$item]->elements)){
										$all_elements = unserialize($get_skins['skins'][$item]->elements);
									}
							
									if(!empty($all_elements[$skin]['header'])){
										$headerElements = $all_elements[$skin]['header'];
									}else{
										$headerElements = "";
									}
									if(!empty($all_elements[$skin]['content'])){
										$contentElements = $all_elements[$skin]['content'];
									}else{
										$contentElements = "";
									}
									if(!empty($all_elements[$skin]['footer'])){
										$footerElements = $all_elements[$skin]['footer'];
									}else{
										$footerElements = "";
									}

									if(!empty($get_skins['skins'][$item]->gallery)){
										$gallery = unserialize($get_skins['skins'][$item]->gallery);
									}
						
									if(!empty($get_skins['skins'][$item]->settings)){
										$settings = unserialize($get_skins['skins'][$item]->settings);
									}

									if(!empty($all_elements[$skin]['content']['front'])){
										$login = in_array('login', $all_elements[$skin]['content']['front']);
									}else{
										$login = "";
									}

									$set_columns = array('extra_small','small','medium','large','extra_large');

									foreach ($set_columns as $column) {
										if(!empty($settings[$column])){
											if($settings[$column] == "Inherit"){
												$settings[$column] = "";
											}
											$settings["column"] = $settings['extra_small']." ".$settings['small']." ".$settings['medium']." ".$settings['large']." ".$settings['extra_large'];
											$settings["column"] = preg_replace('/\s+/', ' ',esc_attr($settings["column"]));
										}else{
											$settings["column"] = "";
										}
									}

									if(!empty($settings["main_cubicbezier"]) && $settings["main_cubicbezier"] == true){
										$settings["main_cubicbezier"] = "cubicbezier";
									}else{
										$settings["main_cubicbezier"] = "";
									}

							
									if(!empty($settings['main_frostedglass_main'])){
										if($settings['main_frostedglass_main'] == true){
											$settings['main_frostedglass_main'] = "frosted-glass";
										}else{
											$settings['main_frostedglass_main'] = "";
										}
									}else{
										$settings['main_frostedglass_main'] = "";
									}

									$pre_skin = self::check_pre_skins($skin_type);

									if($skin_type == $pre_skin){
										(!empty($settings["tcard-front_background-color_class"])) ? $settings["tcard-front_background-color_class"] : $settings["tcard-front_background-color_class"] = "";
										$front_background_color[$skin] = $settings["tcard-front_background-color_class"];
										(!empty($settings["tcard-back_background-color_class"])) ? $settings["tcard-back_background-color_class"] : $settings["tcard-back_background-color_class"] = "";
										$back_background_color[$skin] = $settings["tcard-back_background-color_class"];
									}else{
										$front_background_color[$skin] = "";
										$back_background_color[$skin] = "";
									}

									if($skin_type == "skin_5"){
										if(!empty(get_the_post_thumbnail_url($posts[$skin]->ID, 'large'))){
											$backgroundPost = 'style="background-image: url('.get_the_post_thumbnail_url($posts[$skin]->ID, 'large').')"';
										}else{
											$backgroundPost = "";	
										}
									}else{
										$backgroundPost = "";
									}

									if($skin_type == $pre_skin){
										$skin_name = $skin_type;
									}else{
										$skin_name = "customSkin";
									}

									if(!empty($settings["main_max_width"])){
										$max_width[$skin] = 'style=max-width:'.esc_attr($settings["main_max_width"]).';';
									}else{
										$max_width[$skin] = "";
									}
									(!empty($settings["main_animation"])) ? $settings["main_animation"] : $settings["main_animation"] = "";
									$tcard_class[$skin] = $skin_name." ".$settings["main_animation"]." ".$settings["main_cubicbezier"]." ".$settings['main_frostedglass_main'];
									$tcard_class[$skin] = preg_replace('/\s+/', ' ',esc_attr($tcard_class[$skin]));

									if(!empty($settings['viewIn'])){
										$viewIn[$skin] = 'data-view-in='.esc_attr($settings['viewIn']).'';

										if(!empty($settings['viewOut'])){
											$viewOut[$skin] = 'data-view-out='.esc_attr($settings['viewOut']).'';
										}

										if(empty($settings['setOffsetView'])){
											$offsetView[$skin] = 'data-offsetView="200"';
										}else{
											$offsetView[$skin] = 'data-offsetView='.esc_attr($settings['setOffsetView']).'';
										}
										
									}else{
										$viewIn[$skin] = "";
										$viewOut[$skin] = "";
										$offsetView[$skin] = "";
									}

									if(!empty($settings['tcard-front_frostedglass']) && $settings['tcard-front_frostedglass'] == 1){
										$settings['tcard-front_frostedglass'] =  "frosted-glass";
									}else{
										$settings['tcard-front_frostedglass'] = "";
									}

									if(!empty($settings['tcard-back_frostedglass']) && $settings['tcard-back_frostedglass'] == 1){
										$settings['tcard-back_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-back_frostedglass'] = "";
									}

									if(!empty($settings['tcard-front-tcard-header_frostedglass']) && $settings['tcard-front-tcard-header_frostedglass'] == 1){
										$settings['tcard-front-tcard-header_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-front-tcard-header_frostedglass'] = "";
									}

									if(!empty($settings['tcard-back-tcard-header_frostedglass']) && $settings['tcard-back-tcard-header_frostedglass'] == 1){
										$settings['tcard-back-tcard-header_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-back-tcard-header_frostedglass'] = "";
									}

									if(!empty($settings['tcard-front-tcard-content_frostedglass']) && $settings['tcard-front-tcard-content_frostedglass'] == 1){
										$settings['tcard-front-tcard-content_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-front-tcard-content_frostedglass'] = "";
									}

									if(!empty($settings['tcard-back-tcard-content_frostedglass']) && $settings['tcard-back-tcard-content_frostedglass'] == 1){
										$settings['tcard-back-tcard-content_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-back-tcard-content_frostedglass'] = "";
									}

									if(!empty($settings['tcard-front-tcard-footer_frostedglass']) && $settings['tcard-front-tcard-footer_frostedglass'] == 1){
										$settings['tcard-front-tcard-footer_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-front-tcard-footer_frostedglass'] = "";
									}

									if(!empty($settings['tcard-back-tcard-footer_frostedglass']) && $settings['tcard-back-tcard-footer_frostedglass'] == 1){
										$settings['tcard-back-tcard-footer_frostedglass'] = "frosted-glass";
									}else{
										$settings['tcard-back-tcard-footer_frostedglass'] = "";
									}

									$front_style[$skin] = TcardStyle::set_style($settings,'front','box',$group_id,$skin,'group');
									$back_style[$skin] = TcardStyle::set_style($settings,'back','box',$group_id,$skin,'group');

									$hfront_style[$skin] = TcardStyle::set_style($settings,'header-front','box',$group_id,$skin,'group');
									$hback_style[$skin] = TcardStyle::set_style($settings,'header-back','box',$group_id,$skin,'group');

									$cfront_style[$skin] = TcardStyle::set_style($settings,'content-front','box',$group_id,$skin,'group');
									$cback_style[$skin] = TcardStyle::set_style($settings,'content-back','box',$group_id,$skin,'group');

									$ffront_style[$skin] = TcardStyle::set_style($settings,'footer-front','box',$group_id,$skin,'group');
									$fback_style[$skin] = TcardStyle::set_style($settings,'footer-back','box',$group_id,$skin,'group');
											
									if(!empty($arcfilter)){
										$arcfilter;
										$data_arcfilter = 'data-categories="all '.esc_attr($cat_slug[$group_id][$skin]).'"'. " " . 'data-number="'.esc_attr($item).'"';
										$arcfilter_item = 'arcfilter-item animated ';
									}else{
									 	$arcfilter = '';
									 	$data_arcfilter = '';
									 	$arcfilter_item = '';
									}
							
									require TCARD_FRONT_URL . "templates/TcardSkins.php";
							 	}
							}
						}
					}
				}
			}
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
}