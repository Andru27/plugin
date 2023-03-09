<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardAdmin 
{

	/**
	 * Construct
	 * @since    1.0.0
	 */
	public function __construct(){

		require_once TCARD_PATH . "inc/TcardAjax.php";

    	require_once TCARD_ADMIN_URL . 'TcardSaveData.php';

	}	

	/**
	 * Register the stylesheets for the admin area.
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		if( $hook == 'toplevel_page_tcard' || $hook == 'tcard_page_arcfilter' ){

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( TCARD_NAME , TCARD_BASE_URL . 'admin/css/tcard-admin.min.css', "" , TCARD_VERSION );
			wp_enqueue_style( TCARD_NAME."fontawesome" , TCARD_ASSETS_URL . 'fontawesome/css/fontawesome-all.min.css', "" ,'all');
		}else{
			return;
		}
	}	

	/**
	 * Register the JavaScript for the admin area.
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		if( $hook == 'toplevel_page_tcard' || $hook == 'tcard_page_arcfilter' ){
		    wp_enqueue_script("jquery-ui-draggable");
		    wp_enqueue_script("jquery-ui-droppable");
		    wp_enqueue_editor();
		    wp_enqueue_media();
		    wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( TCARD_NAME , TCARD_BASE_URL . 'admin/js/tcard-admin.min.js', array( 'jquery' ), TCARD_VERSION, true );
			wp_localize_script( TCARD_NAME, 'tcard', array(
				'add_skin' 				=> wp_create_nonce("tcard_add_skin"),
				'delete_skin' 			=> wp_create_nonce("tcard_delete_skin"),
				'select_skin' 			=> wp_create_nonce("tcard_select_skin"),
				'add_element' 			=> wp_create_nonce("tcard_add_element"),
				'gallery_type'			=> wp_create_nonce("tcard_gallery_type"),
				'group_id' 				=> $this->find_group('DESC')
			)); 	
		}else{
			return;
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function add_tcard_page(){

		add_menu_page(
	        'Tcard',
	        'Tcard',
	        'manage_options',
	        'tcard', 
	        array( $this, "dashboard" ),
	        'dashicons-index-card',
	        77
	    );
	}

	/**
	 * Callback function for admin page
	 * @since 1.0.0
	 */
	public function dashboard(){

		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';

		$group_id = $this->find_group('DESC');
		$groups = $this->sort_groups('DESC');

		require_once TCARD_PATH . "inc/TcardSkinsController.php";
		require_once TCARD_PATH . "inc/TcardElementsController.php";
		
		$tcardSkinsController = new TcardSkinsController();
		$tcardElements = new TcardElementsController($group_id, $urlfile = null);

		$group_output =  $wpdb->get_row("SELECT * FROM $tcard_table WHERE group_id = $group_id");

		$categories = get_categories( $args = '' ); 

		if(!empty($group_output)){
			$group_settings = unserialize($group_output->settings);
			$get_skin_type = $group_output->skin_type;
			$group_title = $group_output->title;
			$group_skins_number = $group_output->skins_number;
		}else{
			$group_settings = "";
			$get_skin_type = "";
			$group_title = "";
			$group_skins_number = "";
		}


		$header_elements = $this->create_elements("tcard-header","Header",array('front','back'),array('header_title','info','profile','button_four_line','button_three_line','button_arrow','button_squares','gallery_button',"social_button","image_button"),'tcard-header','TcardHeaderElements');

		$content_elements = $this->create_elements("tcard-content","Content",array('front','back'),array('skills','info','item','ellipsis_text','slider','profile','list','contact','register','login','address','tcard_post'),'tcard-content','TcardContentElements');
		
		$footer_elements = $this->create_elements("tcard-footer","Footer",array('front','back'),array('tc_button','social_list','info','info_list','image_button'),'tcard-footer','TcardFooterElements');

		/**
		 * @since 1.6.0
		 */	
		$pre_skin = $this->check_pre_skins($get_skin_type);

		if($get_skin_type == $pre_skin){
			$skin_name = $get_skin_type;
		}else{
			$skin_name = "customSkin";
		}

		/**
		 * @since 1.0.0
		 */	
		require_once TCARD_ADMIN_URL . 'templates/TcardDashboard.php';
	}

	/**
     * Create a new group
     * @since 1.0.0
     */
	public function create_group(){

        check_admin_referer( "tcard_create_group" );

        global $wpdb;

        $tcard_table = $wpdb->prefix.'tcards';

        $group = array(
        	'publish_up' 	=> current_time( 'mysql' ),
        	'modified' 		=> current_time( 'mysql' ),
        	'title'			=> 'New Group',
        );

        $wpdb->query( $wpdb->prepare("INSERT INTO $tcard_table ( publish_up, modified , title ) 
				VALUES ( %s, %s, %s )", 
				$group
			) 
		);

        $group_id = $this->find_group('DESC');
        wp_redirect( admin_url( "admin.php?page=tcard&group_id={$group_id}" ) );
	}

	/**
     * Delete group displayed
     * @since 1.0.0
     */
  	public function delete_group() {

        check_admin_referer( "tcard_delete_group" );

        global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';
		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

        $group_id = absint( $_GET['get_group_id'] );

       	$group = "DELETE FROM $tcard_table WHERE group_id = %d";
	    $wpdb->query( $wpdb->prepare($group, $group_id) );

	    $skins = "DELETE FROM $tcard_skin_table WHERE group_id = %d";
	    $wpdb->query( $wpdb->prepare($skins, $group_id ) );
    
	    $group_id = $this->find_group('DESC');

		if(!empty($group_id)){
			wp_redirect( admin_url( "admin.php?page=tcard&group_id={$group_id}" ) );
		}else{
			wp_redirect( admin_url( "admin.php?page=tcard" ) );
		}
    }

    /**
     * Sort order of groups
     * @since 2.8.3
     */
    public function TcardGutenberg(){

    	if ( function_exists( 'register_block_type' ) ) {

    		require_once TCARD_PATH . "inc/gutenberg/TcardGutenberg.php";

    		$groups = array(
    			"tcard"			=> $this->sort_groups('DESC'),
    			"arcfilter"		=> $this->sort_groups_filter('DESC')
    		);

    		$TcardGutenberg = new TcardGutenberg($groups);
    		
		}
	}	

	/**
     * Sort order of groups
     * @since 1.0.0
     */
 	public function sort_groups($order) {

 		global $wpdb;

		$tcard_table = $wpdb->prefix.'tcards';

 		$groups = array();

        $all_groups = $wpdb->get_results("SELECT group_id, title FROM $tcard_table ORDER BY modified $order");

        foreach ($all_groups as $group) {

  			 $groups[] = array(
  			 	'group_id' => $group->group_id,
                'title' => $group->title
            );
        }

        return $groups;
    }

	/**
     * Sort order of groups
     * @since 2.8.3
     */
 	public function sort_groups_filter($order) {

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
     * @since 1.0.0
     */
	public function find_group($order) {

		global $wpdb;
		
		$tcard_table = $wpdb->prefix.'tcards';

        $group = $wpdb->get_row("SELECT group_id FROM $tcard_table ORDER BY modified $order");
 			
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
     * @since 1.0.0
     */
    public function update_group(){

    	check_admin_referer( "tcard_update_group" );
    	
    	$group_id = sanitize_text_field( $_POST['group_id'] );
    	$group_id = (int)$group_id;

		TcardSaveData::save();

		wp_redirect( admin_url( "admin.php?page=tcard&group_id={$group_id}" ) );
    }


    /**
     * Create elements for sidebar.
     * @since 1.0.0
     */
    public function create_elements($mainElem,$title,$sides,$elements,$item,$file){

    	global $wpdb;

		$group_id = $this->find_group('DESC');

		$tcard_table = $wpdb->prefix.'tcards';

		$group_output =  $wpdb->get_row("SELECT * FROM $tcard_table WHERE group_id = $group_id");

		$categories = get_categories( $args = '' );

		if(!empty($group_output)){
			$group_settings = unserialize($group_output->settings);
		}
		

		(!empty($group_settings['category_name'])) ? $group_settings['category_name'] : $group_settings['category_name'] = "";
		(!empty($group_settings['orderby_category'])) ? $group_settings['orderby_category'] : $group_settings['orderby_category'] = "";
		(!empty($group_settings['order_category'])) ? $group_settings['order_category'] : $group_settings['order_category'] = "";

    	$html = "<div class='tcard-item-inner' data-tcard-box='$item' data-file='$file'>";


			$html .= "
			<div class='tcard-item new-box $mainElem' data-item='$mainElem'>
				<div class='tcard-item-bar'><span class='tcard-item-title'>$title</span> <span class='tcard-delete-item'><i class='fas fa-trash-alt'></i></span></div>
				<div class='tcard-main-elem front-side' data-side='front'>
					<div class='tcard-item-bar'>Front Side</div>
					<div class='tcard-item-elements'></div>
				</div>
				<div class='tcard-main-elem back-side' data-side='back'>
					<div class='tcard-item-bar'>Back Side</div>
					<div class='tcard-item-elements'></div>
				</div>
			</div>";

			foreach ($sides as $key => $side) {
				$html .= 
	    		"<div class='tcard-main-elem new-box $side-side' data-item='$mainElem' data-side='$side'>
					<div class='tcard-item-bar'>$side side</div>
					<div class='tcard-item-elements'></div>
				</div>";
			}

			foreach ($elements as $key => $element) {

				$title = str_replace("_", " ", $element);

				if($element == "gallery_button"){
					$title = str_replace("gallery", " ", $element);
				}elseif($element == "social_button"){
					$title = str_replace("social_", " ", $element);
				}
				elseif($element == "header_title"){
					$title = str_replace("header_", " ", $element);
				}elseif($element == "tc_button"){
					$title = str_replace("tc_", " ", $element);
				}elseif($element == "tcard_post"){
					$title = str_replace("tcard_", " ", $element);
				}
				if($element == 'header' || $element == 'content' || $element == 'footer' || $element == 'front_side' || $element == 'back_side'){
					$newElem = "new-box";
				}else{
					$newElem = "new-element";
				}
				if($element == "tcard_post"){
					$html .= "<div class='tcard-post-element'>
							 <h3 class='post-open_set'> <span>$title</span> ". __("element ",'tcard') ."</h3>
							 <div class='select-category-post'>
							    <div class='tc_post_settings'>
							    	<span>
								    	<h4>Category:</h4>
								 		<select name='group_set[category_name]'>";
									 		foreach ($categories as $key => $category) {
									 			$html .= "<option value='$category->name' ".selected( $group_settings['category_name'], $category->name, false ).">$category->name</option>";
									 		}
								$html .= "</select>
									</span>
									<span>
							 			<h4>".__( 'Order by:', 'tcard' )."</h4>	
							 			<select name='group_set[orderby_category]'>;
											<option value='author' ".selected( $group_settings['orderby_category'], 'author', false ).">author</option>
											<option value='title' ".selected( $group_settings['orderby_category'], 'title', false ).">title</option>
											<option value='date' ".selected( $group_settings['orderby_category'], 'date', false ).">date</option>
											<option value='modified' ".selected( $group_settings['orderby_category'], 'modified', false ).">modified</option>
											<option value='rand' ".selected( $group_settings['orderby_category'], 'rand', false ).">rand</option>
										</select>
									</span>
									<span>
										<h4>".__( 'Order:', 'tcard' )."</h4>		
							 			<select name='group_set[order_category]'>
											<option value='DESC' ".selected( $group_settings['order_category'], 'DESC', false ).">DESC</option>
											<option value='ASC' ".selected( $group_settings['order_category'], 'ASC', false ).">ASC</option>
										</select>
									</span>
							    </div>
								<div class='tcard-bar-element $element $newElem' data-element='$element'>Add post</div>
							 </div>	
						</div>";
				}else{
					$html .= "<div class='tcard-bar-element $element $newElem' data-element='$element'>";
						if($element === "button_four_line"  || 
							$element === "button_three_line" || 
							$element === "button_arrow"  ||
							$element === "button_squares"){
								$html .= "<h4> Button :</span> 
								<span class='tcard-button-type $element'>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
									<span class='tcard-btn-line'></span>
								</span>
							</h4>";
						}elseif($element == "gallery_button"){
							$html .= "<h4 style='height:19px;'>Button : <i class='fas fa-camera'></i></h4>";
						}elseif($element == "social_button"){
							$html .= "<h4 style='height:19px;'>Button : <i class='fas fa-share-alt'></i></h4>";
						}else{
							$html .= $title;
						}
					$html .= "</div>";
				}
			}
    	$html .= "</div>";

    	return $html;
    }

	/**
     * @since 1.0.0
     */
	public function add_skin(){
		TcardAjax::add_skin();
	}

	/**
     * @since 1.0.0
     */
	public function delete_skin(){

		TcardAjax::delete_skin();
	}

	/**
     * @since 1.0.0
     */
	public function select_skin(){

		TcardAjax::select_skin();
	}

	/**
     * @since 1.0.0
     */
	public function add_element(){

		TcardAjax::add_element();
	}

	/**
     * @since 1.3.0
     */
	public function gallery_type(){

		TcardAjax::gallery_type();
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