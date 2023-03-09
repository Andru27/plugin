<?php
/**
 * @since           2.0.5
 * @package         Tcard
 * @subpackage  	Arcfilter/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');?>

<div id="arcfilter" class="wrap tcard">
	 <form accept-charset="UTF-8" action="<?php echo admin_url( 'admin-post.php'); ?>" method="post">
	 	<input type="hidden" name="action" value="arcfilter_update_group">
        <input type="hidden" name="group_id" value="<?php echo esc_attr($group_id); ?>">

	 	<?php wp_nonce_field( 'arcfilter_update_group' ); ?>

	 	<div class="tcard-page-header">
	 		<div class="select-tcard-group">
	 			<h4><?php _e( 'Select group:', 'tcard' ); ?></h4>
	 			<select onchange='if (this.value) window.location.href=this.value'>

	 				<?php foreach ($groups as $group) :

	 					if($group['group_id'] == $group_id) :
	 						$selected = "selected";
	 					else :
	 						$selected = '';
	 					endif ?>

	 					<option value='?page=arcfilter&group_id=<?php echo esc_attr($group['group_id']); ?>'<?php echo $selected; ?>><?php echo stripslashes($group['title']) ?></option>
	 				<?php endforeach; ?>

	 			</select>
	 			<div class="create-new-group"><?php _e( 'or', 'tcard' ) ?>
	 				<a style="margin-left: 5px" href="<?php echo wp_nonce_url(admin_url("admin-post.php?action=arcfilter_create_group"), "arcfilter_create_group") ?>"><?php _e( 'Create a new group', 'tcard' ) ?></a>
	 			</div>
	 		</div>
	 		<div class="header-btns">
	 			<span class="arcfilter-count-cat"><?php _e( 'Categories:', 'tcard' ) ?><span><?php echo esc_attr($cat_number); ?></span></span>
	 			<div class="tc-header-icon tcard-settings"><i class="fas fa-cog"></i></div>

	 			<?php $ArcfilterController->settings->settings(
	 				$group_id,
	 				'group',
	 				__( 'Group - ', 'tcard' ) . $group_title,
	 				'',
	 				$settings = array(
	 					'cat_all_text'	=> array(
	 						'input','text',
	 						__( 'Category "All" text', 'tcard' ),
	 						__( 'Default: All', 'tcard' )
	 					),
	 					'group_name' 			=> array(
	 						'input','checkbox',
	 						__( 'Group name', 'tcard' ),
	 						sprintf(
							    __( 'If you want to display %s name of this group %s set this option true', 'tcard' ),
							    "<br>","<br>"
							)
	 					),
	 					'date_format' 		=> array(
	 						'select',array('j F, Y','F, Y','l, F j, Y','j.n.Y'),
	 						__( 'Date format', 'tcard' )
	 					),
	 					'animations' 	=> array(
	 						'select',$animationsIn,
	 						__( 'Animations', 'tcard' ),
	 						__( 'If option random is false it will select all the time the first animation selected', 'tcard' )
	 					),
	 					'random' 		=> array(
	 						'select',$animationsIn,
	 						__( 'Random animations', 'tcard' ),
	 						__( 'Default: None', 'tcard' )
	 					),
	 					'delayAnimation'		=> array(
	 						'input','number',
	 						__( 'Delay animation', 'tcard' ),
	 						__( 'This option make delay between animations', 'tcard' )
	 					),
	 					'speed'			=> array(
	 						'input','number',
	 						__( 'Speed container', 'tcard' ),
	 						__( 'Option "speed" is the speed off container height', 'tcard' )
	 					),
	 					'loadingText'	=> array(
	 						'input','text',
	 						__( 'Loading text', 'tcard' ),
	 						__( 'Default: Loading...', 'tcard' )
	 					),
	 					'noData'		=> array(
	 						'input','text',
	 						__( 'No more items to show', 'tcard' ),
	 						__( 'Default: No more items', 'tcard' )
	 					),
	 					'counter'		=> array(
	 						'select',array('','onhover','shown'),
	 						__( 'Counter', 'tcard' ),
	 						__( 'Will show how many items are in category', 'tcard' )
	 					),
	 					'container_group' 		=> array(
	 						'select',array('fluid','fixed'),
	 						__( 'Container', 'tcard' ),
	 						__( 'Default: fixed', 'tcard' )
	 					),
	 					''						=> array('title'),
	 					'extra_small'			=> array(
	 						'select',12,
	 						__( 'Extra small' , 'tcard' ),
	 						sprintf(
							    __( '%s', 'tcard' ),
							    "v4+ = (<576px) <br> v3+ = (<768px)"
							)
	 					),
	 					'small'					=> array(
	 						'select',12,
	 						__( 'Small' , 'tcard' ),
	 						sprintf(
							    __( '%s', 'tcard' ),
							    "v4+ = (≥576px) <br> v3+ = (≥768px)"
							)
	 					),
	 					'medium'				=> array(
	 						'select',12,
	 						__( 'Medium' , 'tcard' ),
	 						sprintf(
							    __( '%s', 'tcard' ),
							    "v4+ = (≥768px) <br> v3+ = (≥992px)"
							)
						),	
	 					'large'					=> array(
	 						'select',12,
	 						__( 'Large' , 'tcard' ),
	 						sprintf(
							    __( '%s', 'tcard' ),
							    "v4+ = (≥992px) <br> v3+ = (≥1200px)"
							)
	 					),
	 					'extra_large'			=> array(
	 						'select',12,
	 						__( 'Extra large' , 'tcard' ),
	 						sprintf(
							    __( 'Width: %s only for bootstrap 4', 'tcard' ),
							    "≥1200px <br>"
							)
	 					),			
	 				),
					$category_type
	 			);
	 			
	 			if(!empty($group_id)) : ?>
		 			<a class="tc-header-icon delete-tcard-group" href="<?php echo wp_nonce_url(admin_url("admin-post.php?action=arcfilter_delete_group&get_group_id={$group_id}"), "arcfilter_delete_group") ?>"><i class="fas fa-trash-alt"></i></a>
		 		<?php endif; ?>
		 		<a class="tc-header-icon tcard-doc" href="https://addudev.com/work/tcard/arcfilter/create-a-group/" target="_blank"><i class="fas fa-book"></i></a>
		 		<a class="tc-header-icon tcard-logo" href="http://addudev.com/work/tcard/arcfilter" target="_blank"><img src="<?php echo ARCFILTER_BASE_URL . 'admin/images/logo.png' ?>"/></a>
	 		</div>
	 	</div>

	 	<div class="tcard-sidebar">
	 		<div class="tcard-sidebar-head">
	 			<?php if(!empty($group_id)) : ?>
	 				<button class='alignleft button button-primary' type='submit' name='save' id='tcard-save'>Save</button>
	 				<span class="spinner"></span>

	 				<?php if($category_type == "woocommerce" && $output_settings['display_type'] == "pagination") : ?>
	 					<span class="open-wc-advanced-filter">WC Filter</span>
	 				<?php endif;	
	 			endif; ?>
	 		</div>
	 		<?php if(!empty($groups)) :

	 			if($category_type == "woocommerce" && $output_settings['display_type'] == "pagination") : ?>

	 				<div class="wc-advanced-filter">

	 					<div class="advanced-filter-type">
	 						<div class="filter-head">
	 							<?php _e( 'Main', 'tcard' ) ?>
	 						</div>
	 						<div class="filter-options">

	 							<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Visible', 'tcard' ) ?></h4>
									<div class="tc-check-settings">
									  <input id="use_sidebar" class="tcard-input" type="checkbox" name="group_set[use_sidebar]" <?php checked($output_settings['use_sidebar'],true) ?> value="1">
									  <label for="use_sidebar"></label>
									</div> 
						 		</div>

								<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Filter position:', 'tcard' ) ?></h4>
						 			<select name="group_set[filter_position]" class="tcard-input">
						 				<option value="left" <?php selected($output_settings['filter_position'],'left') ?>><?php _e( 'left', 'tcard' ) ?></option>
						 				<option value="right" <?php selected($output_settings['filter_position'],'right') ?>><?php _e( 'right', 'tcard' ) ?></option>
						 			</select>
						 		</div>

						 		<div class="tcard-sidebar-item group-settings mobile">
						 			<div class="filter-head">
			 							<?php _e( 'Mobile', 'tcard' ) ?>
			 						</div>
			 						<div class="tcard-sidebar-item group-settings">
							 			<h4><?php _e( 'Menu text button:', 'tcard' ) ?></h4>
							 			<input class="tcard-input" type="text" name="group_set[button_text]" value="<?php echo esc_attr($output_settings['button_text']) ?>">
						 			</div>
						 			<div class="tcard-sidebar-item group-settings">
							 			<h4><?php _e( 'Sidebar title:', 'tcard' ) ?></h4>
							 			<input class="tcard-input" type="text" name="group_set[sidebar_title]" value="<?php echo esc_attr($output_settings['sidebar_title']) ?>">
						 			</div>
						 			<div class="tcard-sidebar-item group-settings">
							 			<h4><?php _e( 'Filter animation:', 'tcard' ) ?></h4>
							 			<select name="group_set[filter_animation]" class="tcard-input">
							 				<option value="slide" <?php selected($output_settings['filter_animation'],'slide') ?>><?php _e( 'slide', 'tcard' ) ?></option>
							 				<option value="fade" <?php selected($output_settings['filter_animation'],'fade') ?>><?php _e( 'fade', 'tcard' ) ?></option>
							 			</select>
						 			</div>
						 		</div>		
	 						</div>
	 					</div>

	 					<div class="advanced-filter-type">
	 						<div class="filter-head">
	 							<?php _e( 'Categories', 'tcard' ) ?>
	 						</div>
	 						<div class="filter-options">

	 							<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Visible', 'tcard' ) ?></h4>
									<div class="tc-check-settings">
									  <input id="use_sidebar_cat" class="tcard-input" type="checkbox" name="group_set[use_sidebar_cat]" <?php checked($output_settings['use_sidebar_cat'],true) ?> value="1">
									  <label for="use_sidebar_cat"></label>
									</div> 
						 		</div>
	 						 	<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Title:', 'tcard' ) ?></h4>
						 			<input type="text" class="tcard-group-title tcard-input" name="group_set[category_check_name]" value="<?php echo esc_attr($output_settings['category_check_name']) ?>">
						 		</div>		
	 						</div>
	 					</div>

	 					<div class="advanced-filter-type">
	 						<div class="filter-head">
	 							<?php _e( 'Price', 'tcard' ) ?>
	 						</div>
	 						<div class="filter-options">
								<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Visible:', 'tcard' ) ?></h4>
						 			<div class="tc-check-settings">
								  		<input id="af_price_check" type="checkbox" name="group_set[af_price_check]" <?php checked($output_settings['af_price_check'],true) ?> value="1">
								  		<label for="af_price_check"></label>
									</div>
						 		</div>	
	 						 	<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Title:', 'tcard' ) ?></h4>
						 			<input type="text" class="tcard-group-title tcard-input" name="group_set[af_price_name]" value="<?php echo esc_attr($output_settings['af_price_name']) ?>">
						 		</div>	
						 		<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Type:', 'tcard' ) ?></h4>
						 			<select class="price_type" name="group_set[af_price_type]" class="tcard-input">
						 				<option value="normal" <?php selected($output_settings['af_price_type'],'normal') ?>><?php _e( 'Normal', 'tcard' ) ?></option>
						 				<option value="slider" <?php selected($output_settings['af_price_type'],'slider') ?>><?php _e( 'Slider', 'tcard' ) ?></option>
						 			</select>
						 		</div>

						 		<?php ($output_settings['af_price_type'] == "normal") ? $af_price_normal = "normal" : $af_price_normal = ''; ?>	

						 		<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Price text:', 'tcard' ) ?></h4>
						 			<input type="text" placeholder="Price:" class="tcard-group-title tcard-input" name="group_set[af_price_values_text]" value="<?php echo esc_attr($output_settings['af_price_values_text']) ?>">
						 		</div>

						 		<div class="tcard-sidebar-item group-settings group_price <?php echo esc_attr($af_price_normal) ?>">
						 			<h4><?php _e( 'Min text:', 'tcard' ) ?></h4>
						 			<input type="text" placeholder="Min:" class="tcard-group-title tcard-input" name="group_set[af_price_value_min]" value="<?php echo esc_attr($output_settings['af_price_value_min']) ?>">
						 			<h4><?php _e( 'Max text:', 'tcard' ) ?></h4>
						 			<input type="text" placeholder="Max:" class="tcard-group-title tcard-input" name="group_set[af_price_value_max]" value="<?php echo esc_attr($output_settings['af_price_value_max']) ?>">
						 		</div>	

	 						</div>
	 					</div>

	 					<div class="advanced-filter-type attr">
	 						<div class="filter-head">
	 							<?php _e( 'Attribute', 'tcard' ) ?>
	 						</div>
	 						<div class="filter-options">	
						 		<div class="tcard-sidebar-item group-settings">
						 			<h4 class="add_attr_wc"><?php _e( 'Add', 'tcard' ) ?></h4>
						 			<select class="tcard-input">

						 				<?php foreach ($wc_get_attribute as $key => $attribute) : ?>

						 					<option value="<?php echo $attribute->attribute_name ?>" data-label="<?php echo $attribute->attribute_label ?>"><?php echo $attribute->attribute_label ?></option>

						 				<?php endforeach;?>	

						 			</select>
						 			<div class="wc_get_attributes">

							 			<?php if(!empty($output_settings['wc_sidebar_attribute']['name'])) :
								 			foreach ($output_settings['wc_sidebar_attribute']['name'] as $key => $attribute_name) : ?>

					 						 	<div class="wc_get_attribute">
					 						 		<input type="hidden" class="tcard-input" name="group_set[wc_sidebar_attribute][name][]" value="<?php echo esc_attr($attribute_name) ?>">
					 						 		<input type="hidden" class="tcard-input" name="group_set[wc_sidebar_attribute][label][]" value="<?php echo esc_attr($output_settings['wc_sidebar_attribute']['label'][$key]) ?>">
					 						 		<span class="remove_attr_wc"></span>
										 			<h4><?php echo esc_html($output_settings['wc_sidebar_attribute']['label'][$key]) ?></h4>
										 		</div>

				 						<?php endforeach;
				 						endif; ?>
				 					</div>
						 		</div>		
	 						</div>
	 					</div>

	 					<div class="advanced-filter-type">
	 						<div class="filter-head">
	 							<?php _e( 'Tags', 'tcard' ) ?>
	 						</div>
	 						<div class="filter-options">
	 							<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Visible:', 'tcard' ) ?></h4>
						 			<div class="tc-check-settings">
								  		<input id="af_tags_check" type="checkbox" name="group_set[af_tags_check]" <?php checked($output_settings['af_tags_check'],true) ?> value="1">
								  		<label for="af_tags_check"></label>
									</div>
						 		</div>
						 		<div class="tcard-sidebar-item group-settings">
						 			<h4><?php _e( 'Title:', 'tcard' ) ?></h4>
						 			<input type="text" class="tcard-group-title tcard-input" name="group_set[af_tags_name]" value="<?php echo esc_attr($output_settings['af_tags_name']) ?>">
						 		</div>		
	 						</div>
	 					</div>
	 					
	 				</div>
	 				
	 			<?php endif; ?>

		 		<div class="tcard-sidebar-item group-settings">
		 			<h4><?php _e( 'Set group name:', 'tcard' ) ?></h4>
		 			<input type="text" class="tcard-group-title tcard-input" name="arc_group_name" value="<?php echo stripslashes($group_title) ?>">
		 		</div>
		 		<div class="tcard-sidebar-item group-settings add-arcfilter-category">
 					<h4><?php _e( 'Category type:', 'tcard' ) ?></h4>

 					<select name="category_type" class="select_category_type">
 						<option></option>
 						<option value="tcard" <?php selected($category_type,'tcard') ?>>Tcard</option>
 						<option value="post" <?php selected($category_type,'post') ?>>Post</option>
 						<?php if(self::isWooCommerce()) : ?>
 							<option value="woocommerce" <?php selected($category_type,'woocommerce') ?>>WooCommerce</option>
 						<?php endif; ?>
 					</select>
		 		</div>

		 		<?php if(!empty($category_type)) : ?>
			 		<div class="tcard-sidebar-item group-settings">
			 			<h4><?php _e( 'Add category:', 'tcard' ) ?></h4>
			 
			 			<select class="tcard-input category_type">

				 				<?php 
				 				if($category_type == "tcard") :

					 				if(!empty($tcard_output)) : 
										foreach ($tcard_output as $key => $tcard_group) :  ?>

											<option data-items="<?php echo esc_attr($tcard_group->skins_number) ?>" data-slug="<?php echo esc_html($tcard_group->slug);?>" data-title="<?php echo esc_html($tcard_group->title);?>" value="<?php echo esc_attr($tcard_group->group_id); ?>"> <?php echo html_entity_decode(stripslashes($tcard_group->title));?> </option>

										<?php endforeach; 
									endif;
								elseif($category_type == "post" || $category_type == "woocommerce" && self::isWooCommerce()) :
									if(!empty($post_categories)) :
										foreach ($post_categories as $key => $post_category) : 
											if($post_category->category_parent == 0) : ?>
												<option data-items="<?php echo esc_attr($post_category->count); ?>" data-slug="<?php echo esc_html($post_category->slug);?>" data-title="<?php echo esc_html($post_category->name);?>" value="<?php echo esc_attr($post_category->cat_ID) ?>"> <?php echo html_entity_decode(stripslashes($post_category->name));?> </option>
											<?php endif;
										endforeach; 
									endif;
								endif;?>

			 			</select>
				 		<div class="add-arcfilter-cat">
			 				<?php _e('Add category','tcard') ?>
			 				<input type="hidden" name="category_number" value="<?php echo esc_attr($cat_number); ?>">
			 			</div>
			 		</div>

			 		<div class="tcard-sidebar-item group-settings">
						<h4><?php _e('Display Items:','tcard') ?></h4> 
			 			<select class="tcard-input display_items_hidden" name="group_set[display_items]">
			 				<?php if($output_settings['display_type'] !== 'pagination') : ?>
			 					<option class="remove_op" value="hidden" <?php selected( $output_settings['display_items'], "hidden" );?>><?php _e('Hidden','tcard') ?></option>
			 				<?php endif; ?>
							<option value="ajax" <?php selected( $output_settings['display_items'], "ajax" );?>><?php _e('Ajax','tcard') ?></option>
						</select>
		 			</div>

		 			<div class="tcard-sidebar-item group-settings">
						<h4><?php _e('Type of display:','tcard') ?></h4> 
			 			<select class="tcard-input type_of_display" name="group_set[display_type]">
			 				<option></option>
							<option value="button" <?php selected( $output_settings['display_type'], "button" );?>><?php _e('Load more','tcard') ?></option>
							<option value="pagination" <?php selected( $output_settings['display_type'], "pagination" );?>><?php _e('Pagination','tcard') ?></option>
							<option value="scroll" <?php selected( $output_settings['display_type'], "scroll" );?>><?php _e('Scroll','tcard') ?></option>
						</select>
		 			</div>

		 			<?php if(!empty($output_settings['display_type'])) :
		 				$first_items_active = "first_items_active";
		 			else :
		 				$first_items_active = "";
		 			endif; ?>	

		 			<div class="tcard-sidebar-item group-settings first_items <?php echo esc_attr($first_items_active) ?>">
						<h4><?php _e('Display first items:','tcard') ?></h4> 
			 			<input class="tcard-input" type="number" name="group_set[first_items]" value="<?php echo esc_attr($output_settings['first_items']) ?>">
		 			</div>
		 			<?php if($output_settings['display_type'] == "button" || $output_settings['display_type'] == "scroll") :
		 				$more_items_active = "active";
		 			else :
		 				$more_items_active = "";
		 			endif; ?>	
		 			<div class="tcard-sidebar-item group-settings more_items <?php echo esc_attr($more_items_active) ?>">
						<h4><?php _e('More items:','tcard') ?></h4> 
			 			<input class="tcard-input" type="number" name="group_set[more_items]" value="<?php echo esc_attr($output_settings['more_items']) ?>">
		 			</div>

		 		<?php endif;
	 		endif; ?>

	 		<div class="tcard-sidebar-item tcard-sidebar-info">
	 			<h3><?php _e( 'How to use', 'tcard' ) ?></h3>
	 			<p><?php _e( 'To display your arcfilter group, add the following shortcode (pink) to your page. If adding the arcfilter group to your theme files, additionally include the surrounding PHP function (magenta).', 'tcard' ) ?></p>
	 			<?php (!empty($group_id)) ? $code_group_id = $group_id : $code_group_id = ""; ?>
	 			<pre id="tcard-code">&lt;?php echo do_shortcode(<br>'<span class="tcard-shortcode">[arcfilter group_id="<?php echo esc_attr($code_group_id); ?>"]</span>'<br>); ?&gt;</pre>
	 			<div class="copy-shortcode"><?php _e( 'Copy all', 'tcard' ) ?></div>
	 		</div>
	 	</div>
	 	<?php if(!empty($category_type)) : ?>

	 	<div class="arcfilter-container_main">
		 	<div id="arcfilter-categories" class="arcfilter_container_main-inner arcfilter-categories">
		 		<div class="arcfilter-row">
		 			<div class="arc_bar_cat category_bar">
			 			<?php _e('Categories','tcard'); ?>
			 			<span class="tcard-arrow">
						  	<input class="tcard_check" type="checkbox" name="check_row[category]" value="1" <?php checked( $checkClosed['category'], 1 , true ); ?>>
								<label></label>
						</span>
						
						<div class="tcard-input category_select_style">
							<select name="categories[style][style_type]">
								<option value="style_1" <?php selected($style_type, 'style_1'); ?>>Style 1</option>
								<option value="style_2" <?php selected($style_type, 'style_2'); ?>>Style 2</option>
								<option value="style_3" <?php selected($style_type, 'style_3'); ?>>Style 3</option>
								<option value="style_4" <?php selected($style_type, 'style_4'); ?>>Style 4</option>
							</select>
						</div>
				 	</div>
				 	<?php (!empty($checkClosed['category'])) ? $close_cat = "close" : $close_cat = ""; ?>
					<div class="arc_container <?php echo esc_attr($close_cat); ?>">
					 	<?php $ArcfilterController->category->show_categories(ARCFILTER_ADMIN_URL,$group_id,null); ?>
			 		</div>
		 		</div>
		 	</div>
		 	<div id='arcfilter-items' class="arcfilter_container_main-inner arcfilter-items">
		 		<?php echo $ArcfilterController->items->show_items(ARCFILTER_ADMIN_URL,$group_id); ?>
		 	</div>

		 	<div class="arcfilter-row">
	 			
	 			<div class="arc_bar_cat category_bar">
		 			Options		 			
		 			<span class="tcard-arrow">
					  	<input class="tcard_check" type="checkbox" name="check_row[options_filter]" value="1" <?php checked( $checkClosed['options_filter'], 1 , true ); ?>>
							<label></label>
					</span>
			 	</div>
			 	<?php (!empty($checkClosed['options_filter'])) ? $close_options_filter = "close" : $close_options_filter = ""; ?>
			 	<div class="arc_container <?php echo esc_attr($close_options_filter); ?>">
					<?php if($output_settings['display_type'] == "pagination") :

					$no_page_active = "no_page_active";
					else :
						$no_page_active = "";
					endif; ?>	

					<div class="tcard-sidebar-item group-settings no_page <?php echo esc_attr($no_page_active) ?>">
						<h4><?php 
						printf(
						    __( 'Page exist %s %s message', 'tcard' ),
						    "?",">"
						) ?></h4> 
						<div class="right">
		 					<input class="tcard-input" type="text" name="group_set[no_page]" value="<?php echo esc_attr($output_settings['no_page']) ?>">
		 				</div>
					</div>

					<?php if($output_settings['display_type'] == "pagination") :
						$all_cat = "all_cat_active";
					else :
						$all_cat = "";
					endif; ?>	

					<div class="tcard-sidebar-item group-settings all_cat <?php echo esc_attr($all_cat) ?>">
						<h4><?php _e( 'Only "All" category', 'tcard' )?> </h4>
						<div class="right">
							<div class="tc-check-settings">
							  <input id="all_cat" class="tcard-input" type="checkbox" name="group_set[all_cat]" <?php checked($output_settings['all_cat'],true) ?> value="1">
							  <label for="all_cat"></label>
							</div>
						</div> 
					</div>

					<?php if($output_settings['display_type'] == "pagination") :
						$arrow_pagination = "arrow_pagination_active";
					else :
						$arrow_pagination = "";
					endif; ?>	

					<div class="tcard-sidebar-item group-settings arrow_pagination <?php echo esc_attr($arrow_pagination) ?>">
						<h4><?php _e( 'Next arrow text', 'tcard' )?> </h4>
						<div class="right">
							<input class="tcard-input" type="text" name="group_set[next_arrow_text]" value="<?php echo esc_attr(stripslashes($output_settings['next_arrow_text'])); ?>">
						</div>
					</div>

					<div class="tcard-sidebar-item group-settings arrow_pagination <?php echo esc_attr($arrow_pagination) ?>">
						<h4><?php _e( 'Prev arrow text', 'tcard' )?> </h4>
						<div class="right">
							<input class="tcard-input" type="text" name="group_set[prev_arrow_text]" value="<?php echo esc_attr(stripslashes($output_settings['prev_arrow_text'])); ?>">
						</div>
					</div>

					<?php if($category_type == "woocommerce") : ?>
			 			<div class="tcard-sidebar-item group-settings">
							<h4><?php _e( 'Best sellers badge', 'tcard' )?> </h4>
							<div class="right">
								<input class="tcard-input" type="number" name="group_set[get_best_seller]" value="<?php echo esc_attr(stripslashes($output_settings['get_best_seller'])); ?>">
							</div>
			 			</div>
			 		<?php endif; ?>
		
					<div class="tcard-sidebar-item group-settings">
			 			<h4><?php _e( 'Menu text button:', 'tcard' ) ?></h4>
			 			<div class="right">
			 				<input class="tcard-input" type="text" name="group_set[category_check_btn]" value="<?php echo esc_attr($output_settings['category_check_btn']) ?>">
			 			</div>
		 			</div>

					<div class="tcard-sidebar-item group-settings arrow_pagination image_loader <?php echo esc_attr($arrow_pagination) ?>">
						<?php (!empty($output_settings['arc_loader'])) ? $output_settings['arc_loader'] : $output_settings['arc_loader'] = ARCFILTER_ASSETS_URL . "img/loader.gif" ?>
						<h4><?php _e( 'Loader', 'tcard' )?> <img class="arc_loader" src="<?php echo esc_url($output_settings['arc_loader']); ?>"> </h4>
						<input class="arc-default-loader" type="hidden" value="<?php echo esc_url(ARCFILTER_ASSETS_URL . "img/loader.gif") ?>">
						<input class="tcard-input tcard-image-input" type="hidden" name="group_set[arc_loader]" value="<?php echo esc_attr(stripslashes($output_settings['arc_loader'])); ?>">
						<div class="right">
							<h4 class="tcard-up-image"> <?php _e( 'Upload', 'tcard' ) ?> </h4>
							<h4 class="tcard-up-default"> <?php _e( 'Default', 'tcard' ) ?> </h4>
						</div>
					</div>
					<?php if($category_type == "woocommerce") : ?>
						<div class="tcard-sidebar-item group-settings arrow_pagination image_loader loader_add_cart <?php echo esc_attr($arrow_pagination) ?>">
							<?php (!empty($output_settings['loader_add_cart'])) ? $output_settings['loader_add_cart'] : $output_settings['loader_add_cart'] = ARCFILTER_ASSETS_URL . "img/loader_add_cart.gif" ?>
							<h4><?php _e( 'Add to cart loader', 'tcard' )?> <img class="arc_loader" src="<?php echo esc_url($output_settings['loader_add_cart']); ?>"> </h4>
							<input class="arc-default-loader" type="hidden" value="<?php echo esc_url(ARCFILTER_ASSETS_URL . "img/loader.gif") ?>">
							<input class="tcard-input tcard-image-input" type="hidden" name="group_set[loader_add_cart]" value="<?php echo esc_attr(stripslashes($output_settings['loader_add_cart'])); ?>">
							<div class="right">
								<h4 class="tcard-up-image"> <?php _e( 'Upload', 'tcard' ) ?> </h4>
								<h4 class="tcard-up-default"> <?php _e( 'Default', 'tcard' ) ?> </h4>
							</div>
						</div>
					<?php endif;
					if($category_type !== "tcard") : ?>
					 	<div class="tcard-sidebar-item group-settings dropdown-menu">
					 		<div class="item-head">
	 							Dropdown menu 						
	 						</div>
					 		<div class="tcard-sidebar-item group-settings">
								<h4><?php _e( 'Visible', 'tcard' )?> </h4>
								<div class="right">
									<div class="tc-check-settings">
									  <input id="subcat_menu" class="tcard-input" type="checkbox" name="group_set[subcat_menu]" <?php checked($output_settings['subcat_menu'],true) ?> value="1">
									  <label for="subcat_menu"></label>
									</div>
								</div> 
				 			</div>
							<div class="tcard-sidebar-item group-settings">
					 			<h4><?php _e( 'Keep walker menu', 'tcard' ) ?></h4>
					 			<div class="right">
									<div class="tc-check-settings">
									  <input id="walker_menu" class="tcard-input" type="checkbox" name="group_set[walker_menu]" <?php checked($output_settings['walker_menu'],true) ?> value="1">
									  <label for="walker_menu"></label>
									</div> 
								</div>
					 		</div>

					 		<div class="tcard-sidebar-item group-settings">
					 			<h4><?php _e( 'Animation in', 'tcard' ) ?></h4>

					 			<div class="right">
									<select class="tcard-input" name="group_set[subnav_animationsIn]">
										<?php foreach ($animationsIn as $animationIn) : ?>
											<option value="<?php echo esc_attr($animationIn); ?>" <?php selected($output_settings['subnav_animationsIn'],$animationIn) ?>><?php echo $animationIn; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
					 		</div>
					 		<div class="tcard-sidebar-item group-settings">
					 			<h4><?php _e( 'Animation out', 'tcard' ) ?></h4>
					 			<div class="right">
									<select class="tcard-input" name="group_set[subnav_animationsOut]">
										<?php foreach ($animationsOut as $animationOut) : ?>
											<option value="<?php echo esc_attr($animationOut); ?>" <?php selected($output_settings['subnav_animationsOut'],$animationOut) ?>><?php echo $animationOut; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
					 		</div>
					 	</div>
			 		<?php endif; ?>	

				</div>
			</div>
	 	</div>
	 <?php endif; ?>
	 </form>
</div>