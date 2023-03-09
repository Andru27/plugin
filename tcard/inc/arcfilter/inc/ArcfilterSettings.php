<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterSettings 
{

	/**
	 * @since    2.0.5
	 */
	public function settings($group_id,$type, $title, $category ,$elements,$category_type){

		$output = $this->get_settings($group_id,'back');

		$title = wp_specialchars_decode($title);
		$title = preg_replace ('/<[^>]*>/', ' ', $title);
		$title = strip_tags(stripslashes(mb_strimwidth($title,0, 20,"...")));
	
		if($type == "group"){
			$set_text = $title . " : " . __( 'settings', 'tcard' );
			$arc_set_class = '';
		}
		else{
			$set_text = $title . " : " . __( 'items settings', 'tcard' );
			$arc_set_class = 'arcfilter-settings';
		}

		require ARCFILTER_ADMIN_URL . "templates/ArcfilterSettingsTemplate.php";
	}

	/**
	 * @since    2.5.5
	 */
	public function get_settings($group_id,$action){

		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';


		$settings =  $wpdb->get_row("SELECT category_type,settings FROM $arcfilter_table WHERE group_id = $group_id");

		if(!empty($settings->category_type)){
			$category_type = $settings->category_type;
		}

		if(!empty($settings->settings)){
			$settings = unserialize($settings->settings);	
		}

		$all_settings = array();

		if($action == "front"){
			if(!empty($settings)){
				foreach ($settings as $key => $setting) {
					if(!empty($setting)){

						if($key !== "random"){
							$all_settings[$key] = $setting;
						}
						elseif($key == "random"){
							if(!empty($settings['random'])){
								$all_settings['animations'] = $setting;
								$all_settings['set_random'] = 'true';
							}
						}

						if($key == "loadingText"){
							if(!empty($settings['loadingText'])){
								$all_settings['set_loading'] = 'true';
							}
						}
					}
				}
			}

			if(empty($all_settings['first_items'])){
				$all_settings['first_items'] = "'all'";
			}

			if(empty($all_settings['animations'])){
				$all_settings['animations'] = 'bounceInUp';
			}

			if(empty($all_settings['delayAnimation'])){
				$all_settings['delayAnimation'] = 0;
			}

			if(empty($all_settings['speed'])){
				$all_settings['speed'] = 400;
			}

			if(empty($all_settings['display_items'])){
				$all_settings['display_items'] = "hidden";
			}		

			if(!is_array($all_settings['animations'])){
				$all_settings['set_random'] = 'false';
			}

			if(empty($all_settings['more_items'])){
				$all_settings['more_items'] = 0;
			}

			if(empty($all_settings['loadingText'])){
				$all_settings['loadingText'] = "";
				$all_settings['set_loading'] = 'false';
			}

			if(empty($all_settings['next_arrow_text'])){
				$all_settings['next_arrow_text'] = "";
			}

			if(empty($all_settings['prev_arrow_text'])){
				$all_settings['prev_arrow_text'] = "";
			}

			if(empty($all_settings['cat_all_text'])){
				$all_settings['cat_all_text'] = __("All",'tcard');
			}

			if(!empty($all_settings['container_group'])){
				if($all_settings['container_group'] == "fixed"){
					$all_settings['container_group'] = "container";
				}else{
					$all_settings['container_group'] = "container-fluid";
				}
			}


			if(empty($all_settings['counter'])){
				$all_settings['counter'] = "false";
			}

			if(empty($all_settings['walker_menu'])){
				$all_settings['walker_menu'] = 'false';
			}

			if(empty($all_settings['subnav_animationsIn'])){
				$all_settings['subnav_animationsIn'] = 'fadeInUp';
			}

			if(empty($all_settings['subnav_animationsOut'])){
				$all_settings['subnav_animationsOut'] = 'fadeOutDown';
			}

			if(empty($all_settings['filter_animation'])){
				$all_settings['filter_animation'] = 'slide';
			}
			
			if(empty($all_settings['use_sidebar']) || $all_settings['display_type'] !== "pagination" || $category_type !== "woocommerce"){
				$all_settings['use_sidebar'] = 0;
			}
			
			if(empty($all_settings['no_page'])){
				$all_settings['no_page'] = __('Oops!! This page does not exist.','tcard');
			}

			if(empty($all_settings['af_price_type'])){
				$all_settings['af_price_type'] = 'normal';
			}

			if(empty($all_settings['af_price_values_text'])){
				$all_settings['af_price_values_text'] = 'Price:';
			}

			if(empty($all_settings['af_price_value_min'])){
				$all_settings['af_price_value_min'] = 'Min:';
			}

			if(empty($all_settings['af_price_value_max'])){
				$all_settings['af_price_value_max'] = 'Max:';
			}

		}else{
			if(!empty($settings)){
				foreach ($settings as $key => $setting) {
					if(!empty($setting)){
						$all_settings[$key] = $setting;
						if($key == "random"){
							$all_settings["animations"] = "";
						}
					}
				}
			}
			if(empty($all_settings['no_page'])){
				$all_settings['no_page'] = __('Oops!! This page does not exist.','tcard');
			}
		}
				

		$sets = array('display_items','subnav_animationsIn','subnav_animationsOut','display_type','first_items','more_items','all_cat','next_arrow_text','prev_arrow_text','date_format','subcat_menu','use_sidebar','walker_menu','get_best_seller','filter_animation','sidebar_title','button_text','category_check','category_check_name','filter_position','af_price_check','af_price_name','af_price_type','af_tags_check','af_tags_name','af_color_check','af_color_name','af_color_type','af_size_check','af_size_name','af_price_values_text','af_price_value_min','af_price_value_max','use_sidebar_cat','category_check_btn','container_group');
		
		foreach ($sets as $key => $set) {
			if(empty($all_settings[$set])){
				$all_settings[$set] = '';
			}else{
				$all_settings[$set];
			}
		}

		return $all_settings;
		
	}
}	