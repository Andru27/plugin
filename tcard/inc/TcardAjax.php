<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardAjax
{
	
	/**
	 * @since    1.0.0
	 */
	public static function add_skin(){

		check_ajax_referer( 'tcard_add_skin', 'security' );

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

	    $skin_type = sanitize_text_field($_POST['nameSkin']);
	    $startCount = sanitize_text_field($_POST['startCount']);
	    $stopCount = sanitize_text_field($_POST['stopCount']);
	    $group_id = sanitize_text_field($_POST['group_id']);

		/**
		 * @since    1.4.0
		 */		    
	    $type_action = sanitize_text_field($_POST['type_action']);
	    $skinCloned = sanitize_text_field($_POST['skinCloned']);
	  	
		/**
		 * @since    1.0.0
		 */		  	
	    require_once TCARD_PATH . "inc/TcardSkinsController.php";
	    $tcardSkinsController = new TcardSkinsController();

	    $wpdb->insert(
			$tcard_skin_table,
			array('group_id' => $group_id )
		);

	    $tcardSkinsController->admin_skins($group_id,TCARD_ADMIN_URL,$startCount,$stopCount,$skin_type,$type_action,$skinCloned);
	    
		$wpdb->update( 
			$tcard_table, 
			array( 
				'skins_number' => $stopCount
			), 
			array( 
				'group_id' => $group_id 
			), 
			array( '%d' ), 
			array( '%d' ) 
		);

	 	die();
	}

	/**
	 * @since    1.0.0
	 */
	public static function delete_skin(){

		check_ajax_referer( 'tcard_delete_skin', 'security' );

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$group_id = sanitize_text_field($_POST['group_id']);
		$skin_key = sanitize_text_field($_POST['skin_key']);
		$skins_number = sanitize_text_field($_POST['skins_number']);

        $skins = $wpdb->get_results("SELECT skin_id FROM $tcard_skin_table WHERE group_id =  $group_id");

  
 		if(!empty($skins[$skin_key]->skin_id)){

        	$wpdb->delete($tcard_skin_table,array('skin_id' => $skins[$skin_key]->skin_id));

    	}else{
			http_response_code(500);
    	}

        $wpdb->update( 
			$tcard_table, 
			array( 
				'skins_number' => $skins_number
			), 
			array( 
				'group_id' => $group_id 
			), 
			array( '%d' ), 
			array( '%d' ) 
		);

		die();
	}

	/**
	 * @since    1.0.0
	 */
	public static function select_skin(){

		check_ajax_referer( 'tcard_select_skin', 'security' );

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$group_id = sanitize_text_field($_POST['group_id']);
		$skin_type = sanitize_text_field($_POST['skin_type']);
		$group_name = sanitize_text_field($_POST['group_name']);
	

		require_once TCARD_PATH . "inc/TcardSkinsController.php";
	    $tcardSkinsController = new TcardSkinsController();
	    $tcardSkinsController->admin_skins($group_id,TCARD_ADMIN_URL,$startCount = null,$stopCount = null,$skin_type,'new-skin',$skinCloned = null);

        $wpdb->update( 
			$tcard_table, 
			array( 
				'title' => $group_name,
				'skin_type' => $skin_type
			), 
			array( 
				'group_id' => $group_id 
			), 
			array( '%s' ),
			array( '%s' ), 
			array( '%d' ) 
		);
        
		die();
	}

	/**
	 * @since    1.0.0
	 */
	public static function add_element(){

		check_ajax_referer( 'tcard_add_element', 'security' );
		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

	    $tc_parent = $_GET['tc_parent'];
	    $element = $_GET['tc_element'];
	    $side = $_GET['skin_side'];
	    $skin = $_GET['skin_index'];
	    $group_id = $_GET['group_id'];
	    $elemNumber = $_GET['elemNumber'];

	    require_once TCARD_PATH . "inc/elements-class/TcardAnimations.php";

	    $animations = new TcardAnimations();

	   	if($element === "twitter_profile"){
			$social_menu = "social_menu";
		}else{
			$social_menu = "";
		}
		


		$parent = str_replace('Tcard', '', $tc_parent);
		$parent = str_replace('Elements', '', $parent);
		$parent = lcfirst($parent);
		
		$check = 'empty';

	    if($element == "tc_button"){
			$output['title'] = str_replace("tc_", " ", $element);
		}
		elseif($element == "header_title"){
			$output['title'] = str_replace("header_", " ", $element);
		}
		elseif($element == "tcard_post"){
			$output['title'] = str_replace("tcard_", " ", $element);
		}
		else{
			$output['title'] = str_replace("_", " ", $element);
		}

		$item_list = 3;
		
		$after_login = array(
			'user_email' 		=> 'Email',
			'user_firstname' 	=> 'First name',
			'user_lastnam' 		=> 'Last name',
			'display_name' 		=> 'Display name',
			'description'		=> 'Description',
			'nickname' 			=> 'Nickname',
			'user_url' 			=> 'Website',

		);

		$check_twitter_fields = array('image','website','email','name','description','location','tweets','followers','friends','lists');

		$output['tc_col'] = "tc-4";
		$output['element_width'] = "100%";
	    $skin_type = $wpdb->get_row("SELECT skin_type FROM $tcard_table WHERE group_id = $group_id");
	    $skin_type = $skin_type->skin_type;
	    $pre_skin = self::check_pre_skins($skin_type);

	  	require_once TCARD_ADMIN_URL . "templates/elements/$tc_parent.php";

	  	die();
	}

	/**
	 * Allow users to upload images from the font side of site
	 * @since    1.0.0
	 */
	public static function gallery_images(){
		check_ajax_referer( 'tcard_user_images', 'security' );
		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

	    $images = $_POST['tc_user_images'];
	    $skin_id = sanitize_text_field($_POST['skin_id']);

	    $gallery = array();
	    $curr_user = wp_get_current_user();

	    $gallery['user'] = $curr_user->ID;
	    $gallery['type'] = sanitize_text_field($_POST['gallery_type']);
	    $gallery['thumbnail'] = sanitize_text_field($_POST['thumbnail']);
	    $gallery['thumbnail_title'] = sanitize_text_field($_POST['thumbnail_title']);

	    foreach ($images as $key => $image) {
	    	$gallery['image'][] = sanitize_text_field($image);
	    }
	    
	    (empty($gallery)) ? $gallery = "" : $gallery = serialize($gallery);

		$wpdb->update( 
			$tcard_skin_table, 
			array( 
				'gallery' 	=> $gallery
			), 
			array( 
				'skin_id' => $skin_id 
			), 
			array( '%s' ), 
			array( '%d' ) 
		);
        
		die(); 
	}


	public static function gallery_type(){
		check_ajax_referer( 'tcard_gallery_type', 'security' );

		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

		$skin_id = sanitize_text_field($_POST['skin_id']);

		$gallery['type'] = sanitize_text_field($_POST['gallery_type']);

	    (empty($gallery)) ? $gallery = "" : $gallery = serialize($gallery);

		$wpdb->update( 
			$tcard_skin_table, 
			array( 
				'gallery' 	=> $gallery
			), 
			array( 
				'skin_id' => $skin_id 
			), 
			array( '%s' ), 
			array( '%d' ) 
		);
        
		die();
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