<?php
/**
 * @since           	2.6.0
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/filter
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); 

	if($set_settings['use_sidebar_cat'] == 1) :?>
	
		<div class="arc-wc-categories arc-wc-sidebar-item">
			<?php if(!empty($set_settings['category_check_name'])) : ?>

				<h4><?php echo esc_html($set_settings['category_check_name']); ?></h4>

			<?php endif;
			require_once $url . "templates/filter/MenuTemplate.php"; ?>
		</div>	 

	<?php endif;

	if($set_settings['af_price_check'] == 1) :
		
		$currency_symbol = get_woocommerce_currency_symbol(); ?>

		<div class="arc-wc-price arc-wc-sidebar-item <?php echo esc_attr($set_settings['af_price_type']); ?>">

			
				<h4>
					<?php if(!empty($set_settings['af_price_name'])) : ?>
						<span><?php echo esc_html($set_settings['af_price_name']); ?></span>
					<?php endif; 

					if($set_settings['af_price_type'] == "normal") : ?>
						<div class="arc_btn_filter_items"><?php _e('Filter','tcard'); ?></div>
					<?php endif; ?>
				</h4>
		

			<?php if($set_settings['af_price_type'] == "slider") : ?>
				<div id="arc-slider-range" data-min="<?php echo esc_attr($price["min"]) ?>" data-max="<?php echo esc_attr($price["max"]) ?>" data-start="<?php echo esc_attr($start); ?>" data-stop="<?php echo esc_attr($stop); ?>"></div>

				<div class="arc_price_values">
					<?php echo esc_html($set_settings['af_price_values_text']); ?> 
					<span class="arc_price"><span class="arc_min_price"><?php echo esc_attr($start); ?></span><?php echo $currency_symbol; ?></span> - 
					<span class="arc_price"><span class="arc_max_price"><?php echo esc_attr($stop); ?></span><?php echo $currency_symbol; ?></span>
				</div>
			<?php else : ?>

				<div class="arc_price_values" data-min="<?php echo esc_attr($price["min"]) ?>" data-max="<?php echo esc_attr($price["max"]) ?>" data-start="<?php echo esc_attr($start); ?>" data-stop="<?php echo esc_attr($stop); ?>">

					<div class="arc_min_value">
						<?php echo esc_html($set_settings['af_price_value_min']); ?>
						<input type="number" min="<?php echo esc_attr($price["min"]) ?>" max="<?php echo esc_attr($price["max"]) ?>" value="<?php echo esc_attr($start); ?>"> 
					</div>

					<div class="arc_max_value">
						<?php echo esc_html($set_settings['af_price_value_max']); ?> 
						<input type="number" min="<?php echo esc_attr($price["min"]) ?>" max="<?php echo esc_attr($price["max"]) ?>" value="<?php echo esc_attr($stop); ?>">
					</div>

					<div class="arc_price_text">
						<?php echo esc_html($set_settings['af_price_values_text']); ?> 
						<span class="arc_price"><span class="arc_min_price"><?php echo esc_attr($start); ?></span><?php echo $currency_symbol; ?></span> - 
						<span class="arc_price"><span class="arc_max_price"><?php echo esc_attr($stop); ?></span><?php echo $currency_symbol; ?></span>
					</div>
				</div>
			<?php endif; ?>
		</div>

	<?php endif;

	if(!empty($set_settings['wc_sidebar_attribute'])) : 
		$count_attr = -1;
		foreach ($all_attribute as $key => $attribute) :

			$active_attr = str_replace("pa_", "", $key);
			$checked_attrs = array();
			$count_attr++; ?>

			<div class="arc-wc-attributes arc-wc-sidebar-item <?php echo esc_attr($set_settings['wc_sidebar_attribute']['label'][$count_attr]); ?>" data-wc-attr="<?php echo esc_attr($set_settings['wc_sidebar_attribute']['name'][$count_attr]); ?>">
	
				<h4>
					<span><?php echo esc_html($set_settings['wc_sidebar_attribute']['label'][$count_attr]); ; ?></span>
					<div class="arc_btn_filter_items" data-parent-attr="<?php echo esc_attr($set_settings['wc_sidebar_attribute']['name'][$count_attr]); ?>"><?php _e('Filter','tcard'); ?></div>
				</h4>

				<?php foreach ($attribute['slug'] as $attr => $slug) : 

					if(!empty($_REQUEST[$active_attr])) :
						$selected_attrs[$key] = explode(" ", $_REQUEST[$active_attr]);

						foreach ($selected_attrs[$key] as $value) :

							if($value == $slug) :
								$checked_attrs[$key][$attr] = $value;
							endif;
							
						endforeach;

					endif;

					if(!empty($checked_attrs[$key][$attr]) && $checked_attrs[$key][$attr] == $slug) : 
						$checked_attr[$key][$attr] = esc_html("arc_check_attr");
					else:
						$checked_attr[$key][$attr] = "";
					endif;

					if(stripos($key,'color') !== false) : ?>
						<span class="arc-wc-attr arc-wc-attr_color arc_<?php echo esc_attr($key. " " .$checked_attr[$key][$attr]); ?>" style="background: <?php echo esc_attr($attribute['name'][$attr]); ?>" data-attr="<?php echo esc_attr($slug); ?>" data-parent-attr="<?php echo esc_attr($set_settings['wc_sidebar_attribute']['name'][$count_attr]); ?>"></span>
					<?php else: ?>

						<span class="arc-wc-attr arc-wc-attr_diff arc_<?php echo esc_attr($key. " " .$checked_attr[$key][$attr]); ?>" data-attr="<?php echo esc_attr($slug); ?>" data-parent-attr="<?php echo esc_attr($set_settings['wc_sidebar_attribute']['name'][$count_attr]); ?>"><?php echo esc_attr($attribute['name'][$attr]); ?></span>

					<?php endif;	
				endforeach; ?>	
			
			</div>

		<?php endforeach; 
	endif;

	if($set_settings['af_tags_check'] == 1) : ?>

		<div class="arc-wc-tags arc-wc-sidebar-item">
			
			
				<h4>
					<?php if(!empty($set_settings['af_tags_name'])) : ?>
						<span><?php echo esc_html($set_settings['af_tags_name']); ?></span>
					<?php endif; ?>
					<div class="arc_btn_filter_items"><?php _e('Filter','tcard'); ?></div>
				</h4>
		
			<?php if(!empty($all_tags['slug'])) :

				foreach ($all_tags['slug'] as $key => $tag) : 

					if(in_array($tag, $selected_tags)) :
						$checked_tag[$key] = esc_attr("checked_tag");
					else:
						$checked_tag[$key] = '';
					endif;?>

					<span class="arc-wc-tag <?php echo esc_attr($checked_tag[$key]); ?>" data-tag="<?php echo esc_attr($tag); ?>">
						<span class="arc_check_tag"></span>
						<?php echo esc_attr($all_tags['name'][$key]); ?>
					</span>

				<?php endforeach; 

			endif;?>

		</div>

	<?php endif;
