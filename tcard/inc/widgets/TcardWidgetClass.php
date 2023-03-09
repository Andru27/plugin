<?php
/**
 * @since           	1.7.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc/widgets
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardWidgetClass extends WP_Widget 
{
 

	/**
	 * @since    1.7.0
	 */
	private $widget_group;

	/**
	 * @since    1.7.0
	 */
	private $widget_skin;


	/**
	 * Construct
	 * @since    1.7.0
	 */
	public function __construct($widget_skin,$widget_group) {

		$this->widget_group = $widget_group;

		$this->widget_skin = $widget_skin;

		$widget_ops = array( 
			'classname' => 'tcard_widget',
			'description' => __("Tcard Widget", 'tcard'),
		);
		parent::__construct( 'tcard_widget', 'Tcard Widget', $widget_ops );
	}
 

	public function widget( $args, $instance ) {

		require_once TCARD_PATH . "inc/TcardSkinsController.php";
		$tcardSkinsController = new TcardSkinsController();

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) ){
			echo $args['before_title'] . esc_html($title) . $args['after_title'];
		}

		if(!empty($instance['group_widget'])) :

			foreach ($instance['group_widget'] as $key => $group_id) :

				$settings_group = $this->group_settings($this->widget_group['group_set'][$group_id]);?>

				<div id='tcard-widget-<?php echo esc_attr($group_id); ?>' class="tcard-widget-group tcard-widget-group-<?php echo $group_id ?>">
					<?php if($settings_group["group_name"] == true) : ?>
				        <div class="tcard-group-title">
				           <h2><?php echo wp_specialchars_decode(stripslashes($this->widget_group['title'][$group_id])) ?></h2> 
				        </div>
				    <?php endif; 

					$tcardSkinsController->public_skins($group_id,TCARD_FRONT_URL,"new-skin",$is_widget = false,$skin_index = null);

					echo html_entity_decode($this->add_custom_inline_css_groups($this->widget_group['skins_number'][$key],$this->widget_group['skin_type'][$key],$group_id)); ?>

					<script type="text/javascript">
			    	(function( $ ) {

			    		'use strict';

			        	var group = $(".tcard-widget-group-<?php echo esc_attr($group_id); ?>");

						group.each(function () {
						   $(this).find(".tcard").tcard({
								tcardFlip: <?php echo (int)$settings_group['tcardFlip']; ?>,
								tcardOn: '<?php echo (string)$settings_group['tcardOn']; ?>',
								animationFront: '<?php echo (string)$settings_group['animationFront']; ?>',
								animationOneTime: <?php echo (int)$settings_group['animationOneTime']; ?>,
								randomColor: <?php echo (int)$settings_group['randomColor']; ?>,
								durationCount: <?php echo (int)$settings_group['durationCount']; ?>,
								individualGallery: <?php echo (int)$settings_group['individualGallery']; ?>,
								autocomplete: <?php echo (int)$settings_group['autocomplete']; ?>,
						   });
						});
			   	 })( jQuery );
				    </script>

				</div>

			<?php endforeach;

		endif;

		if(!empty($instance['skin_widget'])) :
			foreach ($instance['skin_widget'] as $key => $skin) :

				if(!empty($instance['skin_group'][$key])){
					$group_id = $instance['skin_group'][$key];
					$skin_index = substr($skin, strlen($group_id));
					if(!empty($this->widget_skin[$key]['group_set'])){
						$settings_group = $this->group_settings($this->widget_skin[$key]['group_set']);
					}
				}else{
					$group_id = "";
					$skin_index = "";
					$settings_group = "";
				}?>

				<div id='tcard-widget-skin-<?php echo esc_attr($group_id.$skin_index); ?>' class="tcard-widget-skin tcard-widget-skin-<?php echo esc_attr($group_id.$skin_index) ?>">
				    <?php $tcardSkinsController->public_skins($group_id,TCARD_FRONT_URL,"new-skin",$is_widget = true,$skin_index); 

				    echo html_entity_decode($this->add_custom_inline_css_skins($key,$skin_index,$group_id));?>

				    <script type="text/javascript">
				    (function( $ ) {

				    		'use strict';

				        	var group = $(".tcard-widget-skin-<?php echo $group_id.$skin_index ?>");

							group.each(function () {
							   $(this).find(".tcard").tcard({
									tcardFlip: <?php echo (int)$settings_group['tcardFlip']; ?>,
									tcardOn: '<?php echo (string)$settings_group['tcardOn']; ?>',
									animationFront: '<?php echo (string)$settings_group['animationFront']; ?>',
									animationOneTime: <?php echo (int)$settings_group['animationOneTime']; ?>,
									randomColor: <?php echo (int)$settings_group['randomColor']; ?>,
									durationCount: <?php echo (int)$settings_group['durationCount']; ?>,
									individualGallery: <?php echo (int)$settings_group['individualGallery']; ?>,
									autocomplete: <?php echo (int)$settings_group['autocomplete']; ?>,
							   });
							});
				    })( jQuery );
				    </script>

				</div>

			<?php endforeach;	
		endif;	
		echo $args['after_widget'];
	}

	/**
	 * Sets the default settings if are empty.
	 * @since    1.7.0
	 */
	public function group_settings($settings){

		$settings_group = $settings;
		if(empty($settings_group['tcardFlip'])){
			$settings_group['tcardFlip'] = 0;
		}

		if(empty($settings_group['tcardOn'])){
			$settings_group['tcardOn'] = "button";
		}

		if(empty($settings_group['animationFront'])){
			$settings_group['animationFront'] = "ready";
		}

		if(empty($settings_group['animationOneTime'])){
			$settings_group['animationOneTime'] = 0;
		}

		if(empty($settings_group['randomColor'])){
			$settings_group['randomColor'] = 0;
		}

		if(empty($settings_group['durationCount'])){
			$settings_group['durationCount'] = 900;
		}

		if(empty($settings_group['individualGallery'])){
			$settings_group['individualGallery'] = 0;
		}

		if(empty($settings_group['autocomplete'])){
			$settings_group['autocomplete'] = 0;
		}

		return $settings_group;		
	}         

	public function form( $instance ) {

		$group_widget = ! empty( $instance['group_widget'] ) ? $instance['group_widget'] : array();
		$skin_widget = ! empty( $instance['skin_widget'] ) ? $instance['skin_widget'] : array();
		$skin_group = ! empty( $instance['skin_group'] ) ? $instance['skin_group'] : array();


		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'tcard' );
		}?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php if(!empty($this->widget_group['group_id'])) :
			foreach ($this->widget_group['group_id'] as $key => $group_id) : ?>
	 		<p>
	        	<label>        	
	        	<input class="checkbox" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'group_widget' ) ); ?>[]" value="<?php echo esc_attr($group_id) ?>" <?php checked( ( in_array($group_id, $group_widget ) ) ? $group_id : '', $group_id ); ?> /> Group - <?php echo esc_html($this->widget_group['title'][$group_id]); ?> </label>
	   		 </p>
			<?php endforeach;
		endif;

		if(!empty($this->widget_skin)) :
			foreach ($this->widget_skin as $skin => $widget) : 
				$check_skin =  $widget['group_id'].$widget['skin_index'];
				$check_group = $widget['group_id']?>
		 		<p>
		        	<label>        	
		        	<input class="checkbox" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'skin_widget' ) ); ?>[<?php echo esc_attr($skin) ?>]" value="<?php echo esc_attr($check_skin) ?>" 
		        	<?php checked( ( in_array( $check_skin, $skin_widget ) ) ? $check_skin : '', $check_skin ); ?> />
		        	<input type="hidden" name="<?php echo esc_attr( $this->get_field_name( 'skin_group' ) ); ?>[<?php echo esc_attr($widget['skin_index']) ?>]" value="<?php echo esc_attr($check_group) ?>" /> 
		        	Group <?php echo esc_html($widget['group_title']); ?> - Skin <?php echo esc_html($skin); ?> </label>
		   		 </p>
			<?php endforeach;
		endif;	

	}
     
	public function update( $new_instance, $old_instance ) {

		$group_widget = ( ! empty ( $new_instance['group_widget'] ) ) ? (array) $new_instance['group_widget'] : array();
		$skin_widget = ( ! empty ( $new_instance['skin_widget'] ) ) ? (array) $new_instance['skin_widget'] : array();
		$skin_group = ( ! empty ( $new_instance['skin_group'] ) ) ? (array) $new_instance['skin_group'] : array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		$instance['group_widget'] = array_map( 'sanitize_text_field', $group_widget );
		$instance['skin_widget'] = array_map( 'sanitize_text_field', $skin_widget );
		$instance['skin_group'] = array_map( 'sanitize_text_field', $skin_group );
		return $instance;

	}

	/**
	 * Add css
	 * @since    1.7.0
	 */
	public function add_custom_inline_css_skins($skin,$skin_index,$group_id){

		global $wpdb;

		$customSkin[$skin] = $this->widget_skin[$skin];

		if(!empty($customSkin[$skin]['skin_type'])){
			$pre_skin = $this->check_pre_skins($customSkin[$skin]['skin_type']);
			$skin_type = $customSkin[$skin]['skin_type'];
		}else{
			$pre_skin = "";
			$skin_type = "";
		}

		require_once TCARD_PATH . "inc/TcardStyle.php";

		if($skin_type !== $pre_skin){
			$css ='<style type="text/css">';
			$css .= TcardStyle::set_style($customSkin[$skin],'front','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'back','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'header-front','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'header-back','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'content-front','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'content-back','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'footer-front','glass_front',$group_id,$skin_index,'widget_skin');
			$css .= TcardStyle::set_style($customSkin[$skin],'footer-back','glass_front',$group_id,$skin_index,'widget_skin');
				
			$css .='</style>';
			return $css;
		}
	}

	/**
	 * Add css
	 * @since    1.7.0
	 */
	public function add_custom_inline_css_groups($skins_number,$skin_type,$group_id){


		$customSkins = $this->widget_group;
		$selector = ".tcard-widget-group-$group_id";
		
		$pre_skin = $this->check_pre_skins($skin_type);

		require_once TCARD_PATH . "inc/TcardStyle.php";

		if($skin_type !== $pre_skin){
			$css ='<style type="text/css">';
				for ($skin = 0; $skin < $skins_number; $skin++){
					if(!empty($customSkins['skin'][$skin])){
						$customSkin = $customSkins['skin'][$skin];	
					}
					
					$css .= TcardStyle::set_style($customSkin,'front','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'back','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'header-front','glass_front',$group_id,$skin,'widget_group');;
					$css .= TcardStyle::set_style($customSkin,'header-back','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'content-front','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'content-back','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'footer-front','glass_front',$group_id,$skin,'widget_group');
					$css .= TcardStyle::set_style($customSkin,'footer-back','glass_front',$group_id,$skin,'widget_group');
				}
			$css .='</style>';
			return $css;
		}
	}

	/**
	 * Check if is one of pre-made skins
	 * @since    1.7.0
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