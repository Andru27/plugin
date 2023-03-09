<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardSetElements
{

	/**
	 * Sets the skin elements. 
	 * @since    1.0.0
	 */ 	
	function set_elements($skin,$skin_type)
	{

		if($skin_type == "skin_1"){
			$all_elements = array(
				$skin => array(
					'header' => array(
						'front' => array("header_title","button_four_line"),
						'back' => array("header_title","button_four_line")
					),
					'content' => array(
						'front' => array("item"),
						'back' => array("profile","skills",'info')
					),
					'footer' => array(
						'front' => array("social_list"),
						'back' => array("info_list")
					)
				)
			);
		}
		elseif($skin_type == "skin_2"){
			$all_elements = array(
				$skin => array(
					'header' => array(
						'back' => array("header_title","social_button",'profile'),
					),
					'content' => array(
						'back' => array("info","skills")
					),
					'footer' => array(
						'back' => array("info_list")
					)
				)
			);
		}
		elseif($skin_type == "skin_3"){
			$all_elements = array(
				$skin => array(
					'header' => array(
						'front' => array("header_title","button_arrow"),
						'back' => array("header_title","button_arrow")
					),
					'content' => array(
						'front' => array("login"),
						'back' => array("item","register")
					),
					'footer' => array(
						'front' => array("tc_button")
					)
				)
			);
		}
		elseif($skin_type == "skin_4"){
			$all_elements = array(
				$skin => array(
					'header' => array(
						'front' => array("header_title","social_button",'info'),
						'back' => array("header_title","button_arrow",'info')
					),
					'content' => array(
						'front' => array("address"),
						'back' => array("contact")
					),
					'footer' => array(
						'front' => array("tc_button")
					)
				)
			);
		}
		elseif($skin_type == "skin_6"){
			$all_elements = array(
				$skin => array(
					'header' => array(
						'front' => array("button_three_line","social_button"),
						'back' => array("button_three_line","header_title","gallery_button")
					),
					'content' => array(
						'front' => array("item"),
						'back' => array("item","info","skills")
					),
					'footer' => array(
						'back' => array("tc_button")
					)
				)
			);
		}elseif($skin_type == "skin_5"){
			$all_elements = "";
		}
		
		return $all_elements;
	}
}