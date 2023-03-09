<?php
/**
 * @since           	1.9.0
 * @package         	Tcard
 * @subpackage  		Tcard/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardStyle
{

	public static function set_style($output,$action,$type,$group_id,$skin,$widget){
	
		if($type !== 'glass_front'){
			$open = "style='";
			$close = "'";
		}else{
			$open = "";
			$close = "";
		}

		if(!empty($output)){
			$style = "$open";
				foreach ($output as $key => $set) {
					if(stripos($key,'tcard-header') !== false){
						if(stripos($key,'tcard-front') !== false && $action == "header-front"){
							$style .= self::style_value($output,$key,'tcard-front','tcard-header',$type,$group_id,$skin,$widget);
						}
						elseif(stripos($key,'tcard-back') !== false && $action == "header-back"){
							$style .= self::style_value($output,$key,'tcard-back','tcard-header',$type,$group_id,$skin,$widget);
						}
					}
					elseif(stripos($key,'tcard-content') !== false){
						if(stripos($key,'tcard-front') !== false && $action == "content-front"){
							$style .= self::style_value($output,$key,'tcard-front','tcard-content',$type,$group_id,$skin,$widget);
						}
						elseif(stripos($key,'tcard-back') !== false && $action == "content-back"){
							$style .= self::style_value($output,$key,'tcard-back','tcard-content',$type,$group_id,$skin,$widget);
						}
					}
					elseif(stripos($key,'tcard-footer') !== false){
						if(stripos($key,'tcard-front') !== false && $action == "footer-front"){
							$style .= self::style_value($output,$key,'tcard-front','tcard-footer',$type,$group_id,$skin,$widget);
						}
						elseif(stripos($key,'tcard-back') !== false && $action == "footer-back"){
							$style .= self::style_value($output,$key,'tcard-back','tcard-footer',$type,$group_id,$skin,$widget);
						}
					}
					else{
						if(stripos($key,'tcard-front') !== false && $action == "front"){
							$style .= self::style_value($output,$key,'tcard-front',$box = null,$type,$group_id,$skin,$widget);
						}
						elseif(stripos($key,'tcard-back') !== false && $action == "back"){
							$style .= self::style_value($output,$key,'tcard-back',$box = null,$type,$group_id,$skin,$widget);
						}
					}
				
				}
			$style .= "$close";
			if($style !== $open.$close){
				return $style;
			}			
		}
	}

	public static function style_value($output,$key,$side,$box,$type,$group_id,$skin,$widget){
		if(!empty($output[$key])){
			if(stripos($key,'tcard-header') !== false || stripos($key,'tcard-content') !== false || stripos($key,'tcard-footer') !== false){
				$set = str_replace($side.'-'.$box.'_','', $key);
				$shadow = $side.'-'.$box.'_';
				$class_front = $side.' .'.$box;
			}else{
				if(stripos($key,'tcard-front') !== false || stripos($key,'tcard-back') !== false){
					$set = str_replace($side.'_','', $key);
					$shadow = $side.'_';
					$class_front = $side;
				}
			}

			if($set !== "box_shadow_on" && $set !== "border_type" && 
				$set !== "border_radius_type" && $set !== "frostedglass_opa" && $set !== 'frostedglass' && $set !== 'frostedglass_bg_colorg' && $set !== 'frostedglass_bg_color' && $set !== 'frostedglass_img' && $set !== 'frostedglass_blur' && $set !== 'background-color_class' && $type == "box"){
				if($set == "background-image"){
					if(!empty($output[$key]))
					return esc_attr($set.":url(".$output[$key].");");
				}elseif($set == "border-width" || $set == "border-top-width" || 
						$set == "border-right-width" || $set == "border-bottom-width" || $set == 'padding-top' ||
						$set == "padding-bottom" || $set == "padding-left" ||
						$set == "margin-top" || $set == "margin-right" || $set == "margin-bottom" || $set == "margin-left") {
						return esc_attr($set.":".$output[$key]."px;");
				}elseif($set == "box_shadow_h" || $set == "box_shadow_v" || $set == "box_shadow_s" || $set == "box_shadow_b" || 
						$set == "box_shadow_o" || $set == "box_shadow_c" || $set == "box_shadow_cc"){
					if($set == "box_shadow_c"){
						(!empty($output[$shadow.'box_shadow_h'])) ? $h = $output[$shadow.'box_shadow_h'] : $h = 0;
						(!empty($output[$shadow.'box_shadow_v'])) ? $v = $output[$shadow.'box_shadow_v'] : $v = 0;
						(!empty($output[$shadow.'box_shadow_b'])) ? $b = $output[$shadow.'box_shadow_b'] : $b = 0;
						(!empty($output[$shadow.'box_shadow_s'])) ? $s = $output[$shadow.'box_shadow_s'] : $s = 0;
						(!empty($output[$shadow.'box_shadow_cc'])) ? $c = $output[$shadow.'box_shadow_cc'] : $c = "";
						return '-webkit-box-shadow: '.$h.'px '.$v.'px '.$b.'px '.$s.'px rgba('.$c.');
								-moz-box-shadow: '.$h.'px '.$v.'px '.$b.'px '.$s.'px rgba('.$c.');
								box-shadow: '.$h.'px '.$v.'px '.$b.'px '.$s.'px rgba('.$c.');';
					}	
				}
				else{
					if(!empty($output[$key]))
					return esc_attr($set.":".$output[$key].";");
				}	
			}

			if($set == 'frostedglass_bg_color' && $type == "glass"){
				if(!empty($output[$shadow.'frostedglass_bg_color'])){
					$box_shadow = 
					'-webkit-box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');
					-moz-box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');
					box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');';

					if(!empty($output[$shadow.'frostedglass_blur'])){
						$box_shadow .= 
						'-webkit-filter: blur('.$output[$shadow.'frostedglass_blur'].'px);
	    				filter: blur('.$output[$shadow.'frostedglass_blur'].'px);';
					}

					if(!empty($output[$shadow.'frostedglass_img'])){
						if($output[$shadow.'frostedglass_img'] == 1){
							$box_shadow .= 'background: inherit;'; 
						}
					}
					return $box_shadow;
				}
			}

			if($widget == 'widget_skin'){
				$selector = ".tcard-widget-skin.tcard-widget-skin-".$group_id.$skin." .tcard.customSkin.tcard-".$skin ."";
			}elseif($widget == 'widget_group'){
				$selector = ".tcard-widget-group.tcard-widget-group-".$group_id." .tcard.customSkin.tcard-".$skin ."";
			}elseif($widget == 'group'){
				$selector = ".tcard-group-".$group_id." .tcard.customSkin.tcard-".$skin ."";
			}else{
				if(is_array($widget)){
					$selector = "$widget[0] $widget[1].customSkin.tcard-".$skin;
				}
			}

			if($set == 'frostedglass_bg_color' && $type == "glass_front"){
				if(!empty($output[$shadow.'frostedglass_bg_color']) || !empty($output[$shadow.'frostedglass']) && $output[$shadow.'frostedglass'] == 1){
					$glass = '
						'.$selector." .".$class_front.'.frosted-glass:before{
							-webkit-box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');
							-moz-box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');
							box-shadow: inset 0 0 0 1000px rgba('. $output[$shadow.'frostedglass_bg_color'] . ');'."\n";
							if(!empty($output[$shadow.'frostedglass_blur'])){
								$glass .= 
								'-webkit-filter: blur('.$output[$shadow.'frostedglass_blur'].'px);
			    				filter: blur('.$output[$shadow.'frostedglass_blur'].'px);';
							}
							if(!empty($output[$shadow.'frostedglass_img'])){
								if($output[$shadow.'frostedglass_img'] == 1){
								$glass .= "background: inherit;"; 
								}
							}
					$glass .= "\n}";
				
					$glass = preg_replace('/^\s+|\r|\s+$/m', '', $glass);
					return $glass."\n";
				}
			}
		}
	}
}