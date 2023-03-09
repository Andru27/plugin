<?php
/**
 * @since           2.0.5
 * @package         Tcard
 * @subpackage  	Arcfilter/admin
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterSaveData
{
  
	/**
	 * Save all data. 
	 * @since    2.0.5
	 */    
    public static function save(){

        global $wpdb;
        
        $arcfilter_table = $wpdb->prefix.'arcfilter';

        $group_id = sanitize_text_field($_POST['group_id']);

        if (isset( $_POST['arc_group_name'] )) {
            $title = htmlspecialchars($_POST['arc_group_name']);
            $modified_date = current_time( 'mysql' );
        }

        if(isset($_POST['category_number'])){
            $category_number = sanitize_text_field($_POST['category_number']);
        }
        
        $checked = array();

        if(isset($_POST['check_row'])){
            $check_row = $_POST['check_row'];
            $check_rows = array('category','options_filter');

            foreach ($check_rows as $key => $check) {
                if ( isset( $check_row[$check] ) && $check_row[$check] == 1) {
                    $check_row[$check] = 1;
                } else {
                    $check_row[$check] = 0;
                }
                $checked[$check] = $check_row[$check];
            }
        }

        (!empty($checked)) ? $checked = serialize($checked) : $checked = "";

        $all_categories = array();
        $categories = $_POST["categories"];
        if(isset($categories)){
            foreach ($categories as $key => $category) {
                foreach ($category as $type => $value) {
                    if($key == "set"){
                        for ($cat=0; $cat < $category_number; $cat++) {
                            if(!empty($value[$cat]))
                                $all_categories[$key][$type][$cat] = sanitize_text_field($value[$cat]);
                        }
                    }elseif($key == "style"){
                        if(!empty($value))
                            $all_categories[$key][$type] = sanitize_text_field($value); 
                    }
                }
            
            }  
        }


        $group_set = $_POST['group_set'];
        $settings = array();

        if(isset($group_set)){
            foreach ($group_set as $key => $setting) {
                
                if($key === "wc_sidebar_attribute"){
                    foreach ($setting as $attr => $attribute) {
                        foreach ($attribute as $value) {
                            $settings[$key][$attr][] = sanitize_text_field($value);
                        }
                    }
                }elseif($key === "random"){
                    foreach ($setting as $random => $anim) {
                        $settings[$key][] = $anim;
                    }
                }
                else{
                    if(!empty($setting))
                    $settings[$key] = $setting;
                }
                
            }

            $check_set = array('group_name');
            foreach ($check_set as $key => $check_box) {
                if ( isset( $group_set[$check_box] ) && $group_set[$check_box] == 1 ) {
                    $settings[$check_box] = 1;
                } else {
                    $settings[$check_box] = 0;
                }
            }
        }
        
     
        $all_items_style = array();
        for ($cat=0; $cat < $category_number; $cat++) {
            $items = $_POST["cat_items$cat"];
            if(isset($items)){
                foreach ($items as $style => $item) {
                    if(!empty($item))
                        if($style !== "set_style"){
                            foreach ($item as $nr => $name) {
                               if(!empty($name))
                               $all_items_style["cat_items$cat"][$style][$nr] = sanitize_text_field($name);
                            }
                        }else{
                             $all_items_style["cat_items$cat"][$style] = sanitize_text_field($item);
                        }

                }
            }
        }

        (!empty($all_categories)) ? $all_categories = serialize($all_categories) : $all_categories = "";
        (!empty($settings)) ? $settings = serialize($settings) : $settings = "";
        (!empty($all_items_style)) ? $all_items_style = serialize($all_items_style) : $all_items_style = "";


        $wpdb->query( $wpdb->prepare("INSERT INTO $arcfilter_table ( group_id, closed ,cat_number ,title, modified, categories, items, settings ) 
                VALUES ( %d, %s, %d, %s, %s, %s, %s, %s )
                ON DUPLICATE KEY 
                UPDATE closed = %s, cat_number = %d, title = %s, modified = %s, categories = %s, items = %s, settings = %s", 
                $group_id,$checked,$category_number,$title,$modified_date,$all_categories,$all_items_style,$settings,$checked,$category_number,$title,$modified_date,$all_categories,$all_items_style,$settings
            ) 
        );
	}

}