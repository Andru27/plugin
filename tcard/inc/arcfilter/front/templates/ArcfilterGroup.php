<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');?>
<div class="arcfilter-group arcfilter-group-<?php echo esc_attr($group_id ." ".$set_settings['container_group']) ?>" data-group-id="<?php echo esc_attr($group_id); ?>">
	<?php if(!empty($set_settings['group_name']) && $set_settings['group_name'] == 1) : ?>
		<div class="arcfilter-group-title tcard-group-title">
			<h2><?php echo html_entity_decode(stripslashes($group_title)); ?></h2>
		</div>
	<?php endif; 
	if($set_settings['use_sidebar'] == 1) : ?>
		<div class="arc_open_wc_sidebar">
			<h4 class="arc_open_wc_sidebar_btn_text"><?php echo esc_html($set_settings['button_text']); ?></h4>
			<div class="arc_open_wc_sidebar_btn">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	<?php endif; 


	if($set_settings['use_sidebar_cat'] == 0) : ?>

		<div class="arc_mobile_open_menu"><?php echo esc_html($set_settings['category_check_btn']); ?></div>
		<div class="arcfilter-menu arc-top-menu">
			<?php echo $ArcfilterController->category->show_categories(ARCFILTER_FRONT_URL,$group_id,'menu'); ?>
		</div>

	<?php endif;

	if($set_settings['use_sidebar'] == 1) : ?>
		<div class="arcfilter-menu <?php echo esc_attr($menu_type); ?>" <?php echo esc_attr($filter_position); ?>>
			<div class="arc-mobile_sidebar_title">
				<?php echo esc_html($set_settings['sidebar_title']); ?>
			</div>
			<div class="arc_mobile_open_menu <?php echo $btn_type ?>"></div>
			<?php echo $ArcfilterController->category->show_categories(ARCFILTER_FRONT_URL,$group_id,'sidebar'); ?>
		</div>
	<?php endif;?>

	<div class="arcfilter-items container-fluid <?php echo esc_attr($wc_filter_sidebar . " " . "arc_" . $category_type); ?>">

		<div class="row">
			<?php echo $ArcfilterController->items->show_items(ARCFILTER_FRONT_URL,$group_id); ?>
		</div>
		
		<?php if($category_type == "tcard") : 

			for ($category = 0; $category < $group->cat_number; $category++) :

				if(!empty($tcard_output)) :

					foreach ($tcard_output as $card => $tcard) :

						if($get_categories['set']['category_id'][$category] == $tcard->group_id):

							$tcard_settings = unserialize($tcard->settings);

							if(empty($tcard_settings['tcardFlip'])){
								$tcard_settings['tcardFlip'] = 0;
							}

							if(empty($tcard_settings['tcardOn'])){
								$tcard_settings['tcardOn'] = "button";
							}

							if(empty($tcard_settings['animationFront'])){
								$tcard_settings['animationFront'] = "ready";
							}

							if(empty($tcard_settings['animationOneTime'])){
								$tcard_settings['animationOneTime'] = 0;
							}

							if(empty($tcard_settings['randomColor'])){
								$tcard_settings['randomColor'] = 0;
							}

							if(empty($tcard_settings['durationCount'])){
								$tcard_settings['durationCount'] = 900;
							}

							if(empty($tcard_settings['individualGallery'])){
								$tcard_settings['individualGallery'] = 0;
							}

							if(empty($tcard_settings['autocomplete'])){
								$tcard_settings['autocomplete'] = 0;
							}
							$all_set_tcard = array('tcardFlip','tcardOn','animationFront','animationOneTime','randomColor','durationCount','individualGallery','autocomplete');

							$arcfilter_style = array('.arcfilter-group-'.$group_id,'.tcard.'.$category_type.$get_categories['set']['category_id'][$category]);

							$category_js = $get_categories['set']['category_type'][$category].$get_categories['set']['category_id'][$category];
							foreach ($all_set_tcard as $tcard_set) {
								$tcard_settings_load[$category_js][$tcard_set] = $tcard_settings[$tcard_set];
							}
					
						echo html_entity_decode(self::add_custom_inline_css($tcard->skin_type,$tcard->skins_number,$tcard->group_id,$arcfilter_style));?>

						<script type="text/javascript">
						(function( $ ) {
							'use strict';
							$(".arcfilter-group").each(function(){
								var tcard = $(this).find(".tcard.<?php echo $category_type.$get_categories['set']['category_id'][$category] ?>");
								tcard.tcard({
						            tcardFlip: <?php echo (int)$tcard_settings['tcardFlip']; ?>,
						            tcardOn: '<?php echo (string)$tcard_settings['tcardOn']; ?>',
						            animationFront: '<?php echo (string)$tcard_settings['animationFront']; ?>',
						            animationOneTime: <?php echo (int)$tcard_settings['animationOneTime']; ?>,
						            randomColor: <?php echo (int)$tcard_settings['randomColor']; ?>,
						            durationCount: <?php echo (int)$tcard_settings['durationCount']; ?>,
						            individualGallery: <?php echo (int)$tcard_settings['individualGallery']; ?>,
						            autocomplete: <?php echo (int)$tcard_settings['autocomplete']; ?>,
						        }); 
							});
						})( jQuery );
						</script>

						<?php endif;

					endforeach;

				endif;

			endfor;	

		endif; ?>

	</div>

	<?php if($set_settings['display_type'] == "button" && $set_settings['first_items'] !== "'all'") : ?>

		<div class="arc-loadmore col-xs-12 col-12">
	        <div class="inner-arc-loadmore">
	            <span class="arc-load-text">Load More</span> 
	        </div>
	    </div>
	<?php elseif($set_settings['display_type'] == "pagination" && $set_settings['first_items'] !== "'all'") : ?>	    
		<div class="arc-pagination col-xs-12 col-12">
			<?php if(!empty($set_settings['prev_arrow_text']) && $calc_pages > 1) : ?>
				<div class="arc-arrow_pagination arc-arrow-prev">
					<?php echo html_entity_decode(stripslashes($set_settings['prev_arrow_text'])); ?>
				</div>
			<?php endif; ?>
	        <ul class="inner-arc-pagination">
	        	<?php for ($i=0; $i < $calc_pages; $i++) : ?>
	        		<li class="arc-page" data-page="<?php echo esc_attr(($i + 1)) ?>"><?php echo esc_html(($i + 1)); ?></li> 
	        	<?php endfor; ?>
	        </ul>
	        <?php if(!empty($set_settings['next_arrow_text']) && $calc_pages > 1) : ?>
				<div class="arc-arrow_pagination arc-arrow-next">
					<?php echo html_entity_decode(stripslashes($set_settings['next_arrow_text'])); ?>
				</div>
			<?php endif; ?>
			<?php (!empty($set_settings['arc_loader'])) ? $set_settings['arc_loader'] : $set_settings['arc_loader'] = ARCFILTER_ASSETS_URL . "img/loader.gif" ?>
			<img class="arcfilter_loader" src="<?php echo esc_url($set_settings['arc_loader']) ?>">
	    </div>
	<?php endif; ?>
</div>
<script type="text/javascript">
	(function( $ ) {
		'use strict';
		var arcfilterGroup = $('.arcfilter-group-<?php echo $group_id; ?>');
	
		arcfilterGroup.each(function () {

			<?php (is_array($set_settings['animations'])) ? $animations = json_encode($set_settings['animations']) : $animations = "'".$set_settings['animations']."'";
			(!empty($tcard_settings_load)) ? $tcard_settings_load = json_encode($tcard_settings_load) : $tcard_settings_load = 'null';?>
		
		    $(this).find(".arcfilter-items").arcfilter({
		        type: '<?php echo (string)esc_attr($set_settings['display_items']); ?>',
		        displayItems: <?php echo $set_settings['first_items']; ?>,
		        animations: <?php echo html_entity_decode($animations); ?>,
		        random: <?php echo esc_attr($set_settings['set_random']); ?>,
		        delayAnimation: <?php echo (int)esc_attr($set_settings['delayAnimation']); ?>,
		        speed: <?php echo (int)esc_attr($set_settings['speed']); ?>,
		        chooseLoad: '<?php echo (string)$set_settings['display_type']; ?>',
		        loadItems: <?php echo (int)$set_settings['more_items']; ?>,
		        loading: <?php echo $set_settings['set_loading']; ?>,
		        loadingText: '<?php echo (string)$set_settings['loadingText']; ?>',
		        noData: '<?php echo (string)$set_settings['noData']; ?>',
		        counter: '<?php echo (string)$set_settings['counter']; ?>',
		        tcard_set: <?php echo html_entity_decode($tcard_settings_load); ?>,
		        cat_page: '<?php echo (string)$category_page; ?>',
		        page: <?php echo (int)$data_page; ?>,
		        walker_menu: <?php echo esc_attr($set_settings['walker_menu']); ?>,
		        use_param: <?php echo html_entity_decode($all_params); ?>,
		    });
		});
	})( jQuery );
</script>