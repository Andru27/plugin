<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardSkinsController 
{

	/**
	 * @since    1.0.0
	 */
	public $group;


	/**
	 * @since    1.0.0
	 */
	public function skinType($group_id,$file_url){

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';

	    $this->group = $wpdb->get_row("SELECT * FROM $tcard_table WHERE group_id = $group_id");

		if($file_url == TCARD_ADMIN_URL){
			$this->admin_skins($group_id,$file_url,$startCount = null,$stopCount = null,$skin_type = null,"new-skin",$skinCloned = null);
		}else{
			$this->public_skins($group_id,$file_url,"new-skin",$is_widget = false,$skin_index = null);
		}

	}
	
	/**
	 * @since    1.0.0
	 */	
	public function admin_skins($group_id,$file_url,$startCount,$stopCount,$skin_type,$type_action,$skinCloned){

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$group = $this->group;
		$get_skins = $wpdb->get_results("SELECT * FROM $tcard_skin_table WHERE group_id = $group_id");

		require_once TCARD_PATH . "inc/TcardElementsController.php";
		$elementsController = new TcardElementsController($group_id, $file_url);

		if(!empty($group->skin_type)){
			$skin_type = $group->skin_type;
			$stopCount = $group->skins_number;
			$startCount = 0;
		}
		
		$countSkin = str_replace("_", " ", $skin_type);
		$users = get_users(array(
		    'orderby' => 'ID',
		    'order' => 'ASC',
		));

		require_once TCARD_ADMIN_URL . "TcardSetElements.php";
		$tcardsetElements = new TcardSetElements();
		$pre_skin = self::check_pre_skins($skin_type);
		for ($skin = $startCount; $skin < $stopCount; $skin++) {

			if($skin_type !== $pre_skin){

				/**
				 * @since    1.4.0
				 */	

				if($skin_type == "customSkin"){
					if($type_action == "new-skin"){
						if(!empty($get_skins[$skin]->elements)){
							$all_elements = unserialize($get_skins[$skin]->elements);
						}else{
							$all_elements = "";
						}
					}else if($type_action == "clone-skin"){
						$closed = "closed";
						$all_elements = unserialize($get_skins[$skinCloned]->elements);
					}	
				}else{
					if($type_action == "new-skin"){
						$elements_skin = $tcardsetElements->set_elements($skin,$skin_type);
						if(!empty($elements_skin)){
							$all_elements = $elements_skin;
						}else{
							$all_elements = unserialize($get_skins[$skin]->elements);
						}
					}else if($type_action == "clone-skin"){
						$closed = "closed";
						$all_elements = unserialize($get_skins[$skinCloned]->elements);
					}
				}	
			}else{

				$elements_skin = $tcardsetElements->set_elements($skin,$skin_type);

				if(!empty($elements_skin)){
					$all_elements = $elements_skin;
				}else{
					if($skin_type !== "skin_5"){
						$all_elements = unserialize($get_skins[$skin]->elements);
					}
				}
			}

			/**
			 * @since    1.4.0
			 */	

			if($type_action == "new-skin"){
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
			}else if($type_action == "clone-skin"){

				if(!empty($all_elements[$skinCloned]['header'])){
					$headerElements = $all_elements[$skinCloned]['header'];
				}else{
					$headerElements = "";
				}
				if(!empty($all_elements[$skinCloned]['content'])){
					$contentElements = $all_elements[$skinCloned]['content'];
				}else{
					$contentElements = "";
				}
				if(!empty($all_elements[$skinCloned]['footer'])){
					$footerElements = $all_elements[$skinCloned]['footer'];
				}else{
					$footerElements = "";
				}
				
				$clonedElem[$skin] = $all_elements[$skinCloned];
				$clonedSet = unserialize($get_skins[$skinCloned]->settings);

				$clonedElem = serialize($clonedElem);
				$clonedSet = serialize($clonedSet);

				$headerWidth = unserialize($get_skins[$skinCloned]->header);
				$contentWidth = unserialize($get_skins[$skinCloned]->content);
				$footerWidth = unserialize($get_skins[$skinCloned]->footer);

				$hcelem_width[$skin]['front']['element_width'] = $headerWidth[$skinCloned]['front']['element_width'];
				$hcelem_width[$skin]['back']['element_width'] = $headerWidth[$skinCloned]['back']['element_width'];

				$ccelem_width[$skin]['front']['element_width'] = $contentWidth[$skinCloned]['front']['element_width'];
				$ccelem_width[$skin]['back']['element_width'] = $contentWidth[$skinCloned]['back']['element_width'];
				
				$fcelem_width[$skin]['front']['element_width'] = $footerWidth[$skinCloned]['front']['element_width'];
				$fcelem_width[$skin]['back']['element_width'] = $footerWidth[$skinCloned]['back']['element_width'];

				$hcelem_width = serialize($hcelem_width);
				$ccelem_width = serialize($ccelem_width);
				$fcelem_width = serialize($fcelem_width);

				$wpdb->query( $wpdb->prepare("INSERT INTO $tcard_skin_table ( skin_id, closed ,elements,header,content,footer,settings ) 
	                	VALUES ( %d, %d, %s, %s, %s, %s, %s )
	                	ON DUPLICATE KEY 
	                	UPDATE closed = %d, elements = %s, header= %s, content= %s, footer= %s, settings= %s", 
	                	$get_skins[$skin]->skin_id,1,$clonedElem,$hcelem_width,$ccelem_width,$fcelem_width,$clonedSet,1,$clonedElem,$hcelem_width,$ccelem_width,$fcelem_width,$clonedSet
		            ) 
		        ); 
				$get_skins[$skin]->closed = 1;
			}

			/**
			 * @since    1.0.0
			 */	

			if(!empty($get_skins[$skin]->closed)){
				$closed = "closed";
				$checkClosed = $get_skins[$skin]->closed;
			}else{
				$closed = "open";
				$checkClosed  = "";
			}

			if(!empty($get_skins[$skin]->gallery)){
				$gallery = unserialize($get_skins[$skin]->gallery);
			}else{
				$gallery = "";
			}
			
			(!empty($gallery['image'])) ? $have_images = "have_images" : $have_images = "";
			if($skin_type !== "skin_5"){
				(empty($headerElements) && empty($contentElements) && empty($footerElements)) ? $addHeight[$skin] = "extra-height" : '';
			}

			require $file_url . "templates/TcardSkins.php";
		}
	}

	/**
	 * @since    1.0.0
	 */
	public function public_skins($group_id,$file_url,$type_action,$is_widget,$skin_index){


		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$group = $wpdb->get_row("SELECT * FROM $tcard_table WHERE group_id = $group_id");
		$get_skins = $wpdb->get_results("SELECT * FROM $tcard_skin_table WHERE group_id = $group_id");

		require_once TCARD_PATH . "inc/TcardElementsController.php";
		$elementsController = new TcardElementsController($group_id, $file_url);

		$skin_type = $group->skin_type;

		$group_settings = unserialize($group->settings);

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
		
		if($is_widget == true){
			$skins_number = $skin_index + 1;
			$startCount = $skin_index;
		}else{
			$skins_number = $group->skins_number;
			$startCount = 0;
		}

		require_once TCARD_PATH . "inc/TcardStyle.php";

		for ($skin = $startCount; $skin < $skins_number; $skin++) {
			if(!empty($get_skins[$skin]->elements)){
				$all_elements = unserialize($get_skins[$skin]->elements);
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

			if(!empty($get_skins[$skin]->gallery)){
				$gallery = unserialize($get_skins[$skin]->gallery);
			}
			
			if(!empty($get_skins[$skin]->settings)){
				$settings = unserialize($get_skins[$skin]->settings);
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
				$settings['tcard-front_frostedglass'] = "frosted-glass";
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

	
			$arcfilter = '';
			$data_arcfilter = '';
			$arcfilter_item = '';
			

			require $file_url . "templates/TcardSkins.php";

		}

		if($skin_type == "skin_5"){
			wp_reset_postdata();
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