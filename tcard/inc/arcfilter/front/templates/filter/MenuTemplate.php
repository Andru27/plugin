<?php
/**
 * @since           	2.6.0
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/filter
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<ul class="arc-nav-filter <?php echo esc_attr($menu_style); ?>">
	<?php if($get_categories['style']['style_type'] == "style_1" && empty($set_settings['use_sidebar_cat'])) : ?>
		<li class="arc-nav-line"></li>
	<?php endif;
	if(!empty($set_settings['display_type'])) : ?>
	
		<li class="arc-nav-item-list item-list-first">
			<span class="arc-nav-item arc-nav-main-item <?php echo esc_attr($onhover); ?>" data-items="<?php echo esc_attr($items_number); ?>" data-category="all"
				data-tcard="all"><?php echo html_entity_decode(stripslashes($set_settings['cat_all_text'])); ?>
				<span class="arc-filter-counter"></span>
			</span>

		</li>

		<?php if(empty($set_settings['all_cat'])) :
			for ($category = 0; $category < $cat_number; $category++) :
				
				$data_items = $get_categories['set']['category_items'][$category];
				$cat_title = esc_html(stripslashes($get_categories['set']['category_name'][$category]));
				$data_category = esc_attr(stripslashes($get_categories['set']['category_slug'][$category]));
				($category_type == "woocommerce") ? $taxonomies = 'product_cat' : $taxonomies = 'category';
				$category_id = $get_categories['set']['category_id'][$category];
	
				if(self::isWooCommerce()){
					$termchildren = get_terms($taxonomies,array('child_of' => $category_id));
				}else{
					$termchildren = array();
				}
				

				if($category_type == "tcard"){
					$data_tcard = 'data-tcard="tcard'.esc_attr($category_id).'"';
				}else{
					$data_tcard = "";
				}

				if(!empty($termchildren) && $set_settings['subcat_menu'] == 1) :
					$parent_has_child = esc_html("<span class='subnav_has_child'></span>");
				else :
					$parent_has_child = "";
				endif;?>

				<li class="arc-nav-item-list item-list-first">
					<p class="arc-nav-item arc-nav-main-item <?php echo esc_attr($onhover); ?>" data-items="<?php echo esc_attr($data_items); ?>" data-category="<?php echo $data_category; ?>" <?php echo $data_tcard; ?>><?php echo $cat_title;?>
						<span class="arc-filter-counter"></span>
						<?php echo $parent_has_child; ?>
					</p>
					<?php if($category_type !== "tcard" && $set_settings['subcat_menu'] == 1) :

						if(!empty($termchildren)) : ?>
							<ul class="arc-subnav arc-nav-lvl0" data-animationin="<?php echo esc_attr($set_settings['subnav_animationsIn']) ?>" data-animationout="<?php echo esc_attr($set_settings['subnav_animationsOut']) ?>">
								<?php foreach ($termchildren as $key => $value) : 
									$term_ids[] = $value->term_id;
									if(!in_array($value->parent, $term_ids)) : 
										$parentSlug[0] = $value->slug;
										$has_child = get_terms($taxonomies,array('parent' => $value->term_id));
							       		if(!empty($has_child)) :
											$subnav_has_child = esc_html("<span class='subnav_has_child'></span>");
										else :
											$subnav_has_child = "";
										endif; ?>
										
										<li class="arc-nav-item-list" data-nav-lvl="0">
											<p class="arc-nav-item arc-subnav-item" data-item-lvl="0" data-items="<?php echo esc_attr($value->count); ?>" data-parent='<?php echo esc_attr($value->slug) ?>' data-category="<?php echo esc_attr($value->slug) ?>"><?php echo $value->name;?>
												<span class="arc-filter-counter sub-items-counter">(<?php echo esc_attr($value->count); ?>)</span>
												<?php echo $subnav_has_child; ?>
											</p>
											<?php echo self::menu_lvl($taxonomies,$value->term_id,$parentSlug); ?>
										</li>

									<?php endif;

								endforeach; ?>
							</ul>
						<?php endif;
					endif; ?>
				</li>

			<?php endfor;
		endif;	

	endif; ?>
</ul>	