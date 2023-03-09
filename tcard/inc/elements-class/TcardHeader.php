<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardHeader
{

	/**
	 * @since    1.0.0
	 */
	private $group;

	/**
	 * @since    1.0.0
	 */
	private $tcardAnimations;

	/**
	 * @since    1.0.0
	 */
	private $group_id;

	/**
	 * @since    1.0.0
	 */
	private $urlfile;

	/**
	 * @since    1.3.0
	 */
	private $tcardSocial;

	/**
	 * Construct.
	 * @since    1.0.0
	 */
	public function __construct($group_id, $urlfile){
		
		global $wpdb;
		
		$tcard_table = $wpdb->prefix.'tcards';

		$this->group_id = $group_id;

		$this->urlfile = $urlfile;

		$this->group = $wpdb->get_row("SELECT skin_type,settings FROM $tcard_table WHERE group_id = $this->group_id");

		require_once TCARD_PATH . "inc/elements-class/TcardAnimations.php";
		require_once TCARD_PATH . "inc/elements-class/TcardSocial.php";

	}

	/**
	 * @since    1.0.0
	 */
	public function show_element($skin,$side,$headerElements,$type_action,$skinCloned){

		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$elements[$skin]['header'][$side] = $headerElements;

		$all_settings = $wpdb->get_results("SELECT settings FROM $tcard_skin_table WHERE group_id = $this->group_id");

		$this->tcardAnimations = new TcardAnimations();
		$this->tcardSocial = new TcardSocial($this->group_id);
		$width = 0;
		$ebutton = 0;
		$sbutton = 0;
		if(!empty($elements[$skin]['header'][$side])) {
			foreach ($elements[$skin]['header'][$side] as $key => $element) {
				$width++;

				if (!isset($elemNumbers[$element])){
					$elemNumbers[$element]= 0;
					$elemNumber = $elemNumbers[$element];
				} 
				else{
					$elemNumbers[$element]++;
					$elemNumber = $elemNumbers[$element];
				}
				
				if ($element == "button_four_line"  			|| 
						$element == "button_three_line" 		|| 
						$element == "button_arrow"  			||
						$element == "button_squares" 			||
						$element == "gallery_button"			||
						$element == "social_button"				){
					$ebutton++;
					$elemNumber = $ebutton - 1;
				}

				if($element == "button_three_line" || $element == "button_arrow"){
					$sbutton++;
					$button = $sbutton - 1;		
				}else{
					$button = "";
				}

				$group_id = $this->group_id;
				$skin_type = $this->group->skin_type;
				$animations = $this->tcardAnimations;

				$settings = unserialize($this->group->settings);
				
				$output = $this->get_elements($skin,$side,$element,$elemNumber,$width,$button,$type_action,$skinCloned);
				$check = $this->check_element($element,$output);
				$pre_skin = self::check_pre_skins($skin_type);
				$skin_settings = unserialize($all_settings[$skin]->settings);

				$parent = "header";
				$tcardSocial = $this->tcardSocial;

				$output_twitter = $this->tcardSocial->get_social_settings($parent,$skin,$side,$element,$elemNumber);
				$check_twitter_fields = array('image','website','email','name','description','location','tweets','followers','friends','lists');
				
				if($element === "twitter_profile"){
					$social_menu = "social_menu";
					$tp_settings = array('social_twitter_username','social_twitter_key','social_twitter_token','social_twitter_csecret','social_twitter_stoken');
					foreach ($tp_settings as $key => $tp_setting) {
						if(empty($skin_settings[$tp_setting])){
							$tp_check = str_replace('social_twitter_', "", $tp_setting);
							$tp_checks[] = $tp_check;
						}
					}
					if(!empty($tp_checks)){
						$check = "empty: " . implode(",",$tp_checks);
					}else{
						$check = "Is set";
					}
				}else{
					$social_menu = "";
				}

				if($element == "twitter_feed" && !empty($output_twitter['twitter_feed_type'])){
					$check = $output_twitter['twitter_feed_type'];
				}

				if($skin_type == $pre_skin){
					$no_width_set = "no_width_set";
				}else{
					$no_width_set = "";
				}

				if(!empty($output[$element."_type"]) && $output[$element."_type"] == "link"){
					$display_link = "is-set";
				}else{
					$display_link = "";
				}
				
				if(!empty($output['profile'])){
					$avatar_is_set = "is-set";
					$check = __( 'Is set', 'tcard' );
				}

				if(!empty($output['profile_btntype']) && $output['profile_btntype'] == "text" || !empty($output['gallery_button_type']) && $output['gallery_button_type'] == "text"){
					$display = "is-set";
				}

				$gallery = $wpdb->get_results("SELECT gallery FROM $tcard_skin_table WHERE group_id = $group_id");
				$gallery = unserialize($gallery[$skin]->gallery);

				(!empty($output[$element])) ? $output[$element] : $output[$element] = "";
				(!empty($output['animation_in'])) ? $output['animation_in'] : $output['animation_in'] = "";
				(!empty($output['animation_out'])) ? $output['animation_out'] : $output['animation_out'] = "";
				(!empty($output['delay'])) ? $output['delay'] : $output['delay'] = "";

				require $this->urlfile . "templates/elements/TcardHeaderElements.php";
			};
		};
	}

	/**
	 * @since    1.0.0
	 */
	public function get_elements($skin,$side,$element,$elemNumber,$width,$button,$type_action,$skinCloned){

		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$output = array();

		if($element == "header_title"){
			$itemTitle = str_replace("header_", " ", $element);
		}else{
			$itemTitle = str_replace("_", " ", $element);
		}
		

		$all_header = $wpdb->get_results("SELECT skin_id,header FROM $tcard_skin_table WHERE group_id = $this->group_id");

		$sub_elems = array('info_title','profile_btntype','profile_btntext','profile_emailtype','profile_emailtext','profile_email','button_pos','gallery_button_type','gallery_button_text','social_button_order','social_button','image_button','image_button_type','image_button_link');

		if($type_action == "new-skin"){
			$header_element = unserialize($all_header[$skin]->header);
			if(!empty($header_element)){
				foreach ($header_element as $key => $value) {
					if(!empty($value[$side][$element][$elemNumber])){
						$output[$element]	= html_entity_decode(stripslashes($value[$side][$element][$elemNumber]));
					}else{
						$output[$element] = "";
					}
					foreach ($sub_elems as $key => $sub_elem) {
					
							if($sub_elem == "info_title" || $sub_elem == "profile_btntext" || $sub_elem == "profile_emailtext" || $sub_elem == "gallery_button_text"){
								if(!empty($value[$side][$sub_elem][$elemNumber])){
									$output[$sub_elem] 	= stripslashes($value[$side][$sub_elem][$elemNumber]);
								}else{
									$output[$sub_elem] = "";
								}
								
							}elseif($sub_elem == "social_button_order" || $sub_elem == "social_button"){
								if(!empty($value[$side][$sub_elem.$elemNumber]))
								$output[$sub_elem]	= $value[$side][$sub_elem.$elemNumber];
							}else{
								if(!empty($value[$side][$sub_elem][$elemNumber])){
									$output[$sub_elem]	= $value[$side][$sub_elem][$elemNumber];	
								}else{
									$output[$sub_elem] = "";
								}
								
							}
					}

					if(!empty($value[$side]["style_btn"][$button])){
						if($element == "button_three_line" || $element == "button_arrow"){
							$output['style_btn'] = $value[$side]["style_btn"][$button];		
						}
					}else{
						$output['style_btn'] = "";
					}
					
					if(!empty($value[$side]['element_width'][$width - 1])){
						$output['element_width'] = $value[$side]['element_width'][$width - 1];
					}else{
						$output['element_width'] = "";
					}

					if(!empty($value[$side]["animation_in"])){
							$output['animation_in']	= $value[$side]["animation_in"];
					}else{
						$output['animation_in'] = "";
					}
					if(!empty($value[$side]["animation_out"])){
							$output['animation_out'] = $value[$side]["animation_out"];
					}else{
						$output['animation_out'] = "";
					}
					if(!empty($value[$side]["delay"])){
							$output['delay'] = $value[$side]["delay"];
					}else{
						$output['delay'] = "";
					}
				}
			}
		}elseif($type_action == "clone-skin"){
			$header_element = unserialize($all_header[$skinCloned]->header);

			if(!empty($header_element)){
				foreach ($header_element as $key => $value) {
					if(!empty($value[$side]['element_width'][$width - 1])){
						$output['element_width'] = esc_attr($value[$side]['element_width'][$width - 1]);
					}else{
						$output['element_width'] = "";
					}
				}
			}
		}

		if(empty($output['element_width'])){
			$output['element_width'] = "100%";
		}

		$output['title'] = $itemTitle;

		if($output['element_width'] == "100%" || empty($output['element_width'])){
			$output['tc_col'] = "tc-4";
		}elseif($output['element_width'] == "75%"){
			$output['tc_col'] = "tc-3";
		}elseif($output['element_width'] == "50%"){
			$output['tc_col'] = "tc-2";
		}elseif($output['element_width'] == "25%"){
			$output['tc_col'] = "tc-1";
		}
		
		$output['tc_col'] = esc_attr($output['tc_col']);

		$skin_type = $this->group->skin_type;

		if($skin_type == self::check_pre_skins($skin_type)){

			if($element == "header_title" && $skin_type !== "skin_6"){
				$output['tc_col'] = "tc-3";
			}elseif($element == "header_title" && $skin_type == "skin_6"){
				if($side == "back")
				$output['tc_col'] = "tc-2";
			}else{
				$output['tc_col'] = "tc-4";
			}


			if($element == "social_button" || $element == "button_four_line" || $element == "button_arrow"){
				$output['tc_col'] = "tc-1";
			}

			if($element == "button_three_line" && $skin_type == "skin_6" 	|| 
				$element == "social_button" && $skin_type == "skin_6" 		|| 
				$element == "gallery_button" && $skin_type == "skin_6"		){
				if($side == "back"){
					$output['tc_col'] = "tc-1";
				}elseif($side == "front"){
					$output['tc_col'] = "tc-2";
				}
				
			}
			
			$output['tc_col'] = esc_attr($output['tc_col']);

			if($element == "social_button" || $element == "button_four_line" || $element == "gallery_button"){
				$output['button_pos'] = "right-button";
			}elseif($element == "button_arrow"){
				$output['button_pos'] = "right-button to-right";
			}
			elseif($element == "button_three_line"){
				$output['button_pos'] = "left-button to-right";
			}
		}

		return $output;
	}

	/**
	 * @since    1.0.0
	 */
	public function check_element($element,$output){
		if($element == "info" && !empty($output['info_title'])){
			$text = $output['info_title'];
		}	
		else{
			if(!empty($output[$element])){
				$text = $output[$element];
			}else{
				$text = "";
			}
			
		}
		if(empty($text)){
			$check =  __( 'empty', 'tcard' );
		}else{
			if(!is_array($element)){
				$check = wp_specialchars_decode($text);
				$check = preg_replace ('/<[^>]*>/', ' ', $check);
				$check = strip_tags(stripslashes(mb_strimwidth($check,0, 15,"...")));
			}
		}
		return $check;
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