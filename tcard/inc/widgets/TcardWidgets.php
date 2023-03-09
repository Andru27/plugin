<?php

/**
 * @since           	1.7.0
 * @package        	Tcard
 * @subpackage  		Tcard/inc/widgets
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardWidgets
{


	/**
	 * Create a widget. Will be displayed in appearance -> widgets
	 * @since    1.7.0
	 */
	public function create_widget_sidebar() {
	
		
		$widget_skin = $this->find_skin_widget();
		$widget_group = $this->find_widget_group();

		if(!empty($widget_skin) || !empty($widget_group)){
			require_once TCARD_PATH . "inc/widgets/TcardWidgetClass.php";
			$sidebar = new TcardWidgetClass($widget_skin,$widget_group);
			register_widget( $sidebar );
		}
	}

	/**
	 * Find the skin that has the widget enabled
	 * @since    1.7.0
	 */
	public function find_skin_widget(){
		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$skins_value = $wpdb->get_results("SELECT settings FROM $tcard_skin_table");

		$widget = array();

		foreach ($skins_value as $key => $value) {
			$settings[$key] = unserialize($skins_value[$key]->settings);
			
			if(!empty($settings[$key]['main_widget_skin'])){
				if($settings[$key]['main_widget_skin'] == 1){
					foreach ($settings[$key] as $set => $setts) {
						$widget[$key][$set] = $setts;
						foreach ($widget[$key] as $id => $group_id) {
							if($id == "group_id"){
								$group_value = $wpdb->get_row("SELECT skin_type,title,settings FROM $tcard_table WHERE group_id = $group_id");
								$widget[$key]['group_set'] 			= unserialize($group_value->settings);
								$widget[$key]['group_title'] 			= $group_value->title;
								$widget[$key]['skin_type'] 			= $group_value->skin_type;
							}
						}
					}
				}
			}
		}
		return $widget;	
	}

	/**
	 * Find the group that has the widget enabled
	 * @since    1.7.0
	 */
	public static function find_widget_group() {
		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$group_value = $wpdb->get_results("SELECT group_id,skin_type,skins_number,title,settings FROM $tcard_table");
		$widget = array();
		if(!empty($group_value)){
			foreach ($group_value as $key => $value) {
				$settings = unserialize($value->settings);
				if(!empty($settings['widget_group']) && $settings['widget_group'] == 1){
					$widget['group_set'][$value->group_id] 			= $settings;
					$widget['group_id'][] 									= $value->group_id;
					$widget['title'][$value->group_id] 					= $value->title;
					$widget['skin_type'][] 									= $value->skin_type;
					$widget['skins_number'][] 								= $value->skins_number;
					$skins_value[] = $wpdb->get_results("SELECT settings FROM $tcard_skin_table WHERE group_id = $value->group_id");
				}

			}
		}
		if(!empty($skins_value)){
			foreach ($skins_value as $key => $settings) {
				foreach ($settings as $skin => $setting) {
					$widget['skin'][] = unserialize($setting->settings);
				}	
			}		
		}
		return $widget;	
	}

}
