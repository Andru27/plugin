<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/admin
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterAdmin 
{

	/**
	 * Construct
	 * @since    2.0.5
	 */
	public function __construct(){

		require_once ARCFILTER_PATH . 'inc/ArcfilterAjax.php';
    	require_once ARCFILTER_ADMIN_URL . 'ArcfilterSavaData.php';
	}	


	/**
	 * Register the stylesheets for the arcfilter admin area.
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		if($hook == 'tcard_page_arcfilter' ){
			wp_enqueue_style( ARCFILTER_NAME , ARCFILTER_BASE_URL . 'admin/css/arcfilter-admin.min.css', "" , TCARD_VERSION );
		}else{
			return;
		}
	}	

	/**
	 * Register the JavaScript for the arcfilter admin area.
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		if( $hook == 'tcard_page_arcfilter' ){
			wp_enqueue_script( ARCFILTER_NAME , ARCFILTER_BASE_URL . 'admin/js/arcfilter-admin.min.js', array( 'jquery' ), TCARD_VERSION, true ); 
			wp_localize_script( ARCFILTER_NAME, 'arcfilter', array(
				'select_category' 		=> wp_create_nonce("arcfilter_select_category"),
				'add_category' 			=> wp_create_nonce("arcfilter_add_category"),
				'group_id' 				=> $this->find_group('DESC')
			)); 	
		}else{
			return;
		}
	}

	/**
	 * Callback function for arcfilter admin page
	 *  @since 	2.0.5
	 */

	public function add_arcfilter_page(){

		add_submenu_page( 
			'tcard', 
			'Arcfilter', 
			'Arcfilter', 
			'manage_options', 
			'arcfilter', 
			array($this,'dashboard')
		);
	}

	/**
	 *  @since 	2.0.5
	 */
	public function dashboard(){

		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

		$group_id = $this->find_group('DESC');
		$groups = $this->sort_groups('DESC');

		require_once ARCFILTER_PATH . "inc/ArcfilterController.php";

		$tcard_table = $wpdb->prefix.'tcards';

		$tcard_output =  $wpdb->get_results("SELECT group_id,title,slug,skins_number FROM $tcard_table");
		
		$ArcfilterController = new ArcfilterController();

		$group_output =  $wpdb->get_row("SELECT * FROM $arcfilter_table WHERE group_id = $group_id");

		if(!empty($group_output)){
			$categories = unserialize($group_output->categories);
			$group_title = $group_output->title;
			$category_type = $group_output->category_type;
			$cat_number = $group_output->cat_number;
			$checkClosed = unserialize($group_output->closed);
		}else{
			$categories = "";
			$group_title = "";
			$category_type = "";
			$cat_number = "";
			$checkClosed['category'] = "";
			$checkClosed['items'] = "";
		}

		$output_settings = $ArcfilterController->settings->get_settings($group_id,'back');

		if($category_type == "post"){
			$post_categories = get_categories( $args = '' ); 
		}elseif($category_type == "woocommerce" && self::isWooCommerce()){
			$wc_get_attribute = wc_get_attribute_taxonomies();
			$post_categories = get_categories( $args = array('taxonomy' => 'product_cat') ); 
		}else{
			$post_categories = "";
			$wc_get_attribute = "";
		}
		
		if(!empty($categories['style']['style_type'])){
			$style_type = $categories['style']['style_type'];
		}else{
			$style_type = "";
		}

		$animationsIn = array('shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','hinge','jackInTheBox','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','slideInDown','slideInLeft','slideInRight','slideInUp');

		$animationsOut = array('shake','headShake','swing','tada','wobble','jello','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight','bounceOutUp','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig','flipOutX','flipOutY','lightSpeedOut','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge','jackInTheBox','rollOut','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp');

		$this->update_items_number($group_id,$categories,$tcard_output,$post_categories,$category_type);

    	require_once ARCFILTER_ADMIN_URL . "templates/ArcfilterDashboard.php";
	}

	/**
     * Create a new group
     * @since 2.0.5
     */
	public function create_group(){

        check_admin_referer( "arcfilter_create_group" );

        global $wpdb;

        $arcfilter_table = $wpdb->prefix.'arcfilter';

        $group = array(
        	'publish_up' 	=> current_time( 'mysql' ),
        	'modified' 		=> current_time( 'mysql' ),
        	'title'			=> 'New Group',
        );

        $wpdb->query( $wpdb->prepare("INSERT INTO $arcfilter_table ( publish_up, modified , title ) 
				VALUES ( %s, %s, %s )", 
				$group
			) 
		);

        $group_id = $this->find_group('DESC');
        wp_redirect( admin_url( "admin.php?page=arcfilter&group_id={$group_id}" ) );
	}

	/**
     * Delete arcfilter group displayed
     * @since 1.0.0
     */
  	public function delete_group() {

        check_admin_referer( "arcfilter_delete_group" );

        global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

        $group_id = absint( $_GET['get_group_id'] );

       	$group = "DELETE FROM $arcfilter_table WHERE group_id = %d";
	    $wpdb->query( $wpdb->prepare($group, $group_id) );

	    $group_id = $this->find_group('DESC');

		if(!empty($group_id)){
			wp_redirect( admin_url( "admin.php?page=arcfilter&group_id={$group_id}" ) );
		}else{
			wp_redirect( admin_url( "admin.php?page=arcfilter" ) );
		}
    }


	/**
     * @since 2.0.5
     */
    public function update_group(){

    	check_admin_referer( "arcfilter_update_group" );
    	
    	$group_id = sanitize_text_field( $_POST['group_id'] );
    	$group_id = (int)$group_id;

		ArcfilterSaveData::save();

		wp_redirect( admin_url( "admin.php?page=arcfilter&group_id={$group_id}" ) );
    }

    public function update_items_number($group_id,$categories,$tcard_output,$post_categories,$category_type){
    	global $wpdb;

    	$items_number = array();
    	$all_items = 0;
    	$all_arc_items = 0;
    
    	if(!empty($tcard_output) && $category_type == "tcard"){
	    	foreach ($tcard_output as $key => $tcard_groups) {
	    		if(!empty($categories['set']['category_id'])){
					foreach ($categories['set']['category_id'] as $cat => $category_id) {
			        	if($tcard_output[$key]->group_id == $category_id){
			        		$items_number[] = $tcard_output[$key]->skins_number;
			        		$all_items += $tcard_output[$key]->skins_number;
			        	}
			        }
	    		}	
	    	}
    	}elseif(!empty($post_categories) && $category_type == "post" || !empty($post_categories) && $category_type == "woocommerce" && self::isWooCommerce()){
			foreach ($post_categories as $cat => $post_category){
				if(!empty($categories['set']['category_id'])){
					foreach ($categories['set']['category_id'] as $cat => $category_id) {
						if($post_category->cat_ID == $category_id){
							$items_number[] = $post_category->count;
				        	$all_items += $post_category->count;
						}
					}
				}	
			}									
    	}

    	if(!empty($categories['set']['category_items'])){
	    	foreach ($categories['set']["category_items"] as $key => $value) {
	    		if(!empty($value))
	    		$categories['set']["category_items"][$key] = $items_number[$key];
	    		$all_arc_items += $value;
	    	}
    	}

    	if($all_items !== $all_arc_items){

    		$arcfilter_table = $wpdb->prefix.'arcfilter';

    		(!empty($categories)) ? $categories = serialize($categories) : $categories = "";

	        $wpdb->query( $wpdb->prepare("INSERT INTO $arcfilter_table ( group_id,categories ) 
	                VALUES ( %d, %s)
	                ON DUPLICATE KEY 
	                UPDATE categories = %s", 
	                $group_id,$categories,$categories
	            ) 
	        );

    	}
    }

	/**
     * Sort order of groups
     * @since 2.0.5
     */
 	public function sort_groups($order) {

 		global $wpdb;

		$arcfilter_table = $wpdb->prefix.'arcfilter';

 		$groups = array();

        $all_groups = $wpdb->get_results("SELECT group_id, title FROM $arcfilter_table ORDER BY modified $order");

        foreach ($all_groups as $group) {

  			 $groups[] = array(
  			 	'group_id' => $group->group_id,
                'title' => $group->title
            );
        }

        return $groups;
    }

	/**
     * Find the id of group
     * @since 2.0.5
     */
	public function find_group($order) {

		global $wpdb;
		
		$arcfilter_table = $wpdb->prefix.'arcfilter';

        $group = $wpdb->get_row("SELECT group_id FROM $arcfilter_table ORDER BY modified $order");
 			
 		if(!empty($group)){
 			$get_id = $group->group_id;
 		}else{
 			$get_id = "";
 		}

        if (isset($_REQUEST['group_id']) && $group_id = $_REQUEST['group_id']) {
            return (int)$group_id;
        }else{
	        return (int)$get_id;
        }

        return false;
    }

    /**
     * @since 2.0.5
     */
    public function select_category(){
    	ArcfilterAjax::select_category();
    }

    /**
     * @since 2.0.5
     */
    public function add_category(){
    	ArcfilterAjax::add_category();
    }

	/**
	 * Check if WooCommerce is activated
	 */
    public static function isWooCommerce(){
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}