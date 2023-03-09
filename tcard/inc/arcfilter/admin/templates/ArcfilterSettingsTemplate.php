<?php
/**
 * @since           2.5.5
 * @package         Tcard
 * @subpackage  	Arcfilter/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');?>
<div class="tcard-modal modal-settings">
	<div class="tcard-modal-body <?php echo $arc_set_class; ?>">
		<div class="tcard-modal-header">
			<h4> <?php echo $set_text ?> </h4>
		</div>
		<div class="tcard-modal-content">
			<?php if($type == "group") : ?>
				<table class="table-tc-settings">
					<tbody>
					<?php foreach ($elements as $key => $element) : 
						(!empty($output[$key])) ? $output[$key] : $output[$key] = "";?>
						<tr>
							<?php (!empty($element[2])) ? $element[2] : $element[2] = "";?>
							<?php (!empty($element[3])) ? $element[3] : $element[3] = ""; ?>
						    <td class="tc-td"><?php echo $element[2]; ?></td>
						    <td class="tc-td2">
						    	<?php (!empty($element[1]) ? $element[1] : $element[1] = "") ?>
						    	<?php if($element[0] == "title") : ?>	
						    		<h3><?php _e( 'Set columns', 'tcard' ) ?></h3>
						    	<?php elseif($element[0] == "select") : 

						    		if($key == "random") : ?>
						    			<select class="animations-random" multiple="multiple" name="<?php echo esc_attr($type) ?>_set[<?php echo esc_attr($key); ?>][]">
						    			<?php foreach ($element[1] as $opt => $option) : 
						    	
						    				if(!empty($output[$key]) && $option == in_array($option, $output[$key])) :
												$selected = "selected";
											else :
												$selected = "";
											endif;?>
						    				<option value="<?php echo esc_attr($option); ?>" <?php echo $selected; ?>><?php echo esc_html($option); ?></option>
						    			<?php endforeach; ?>	
						    		</select>
						    		<?php elseif($key == "animations" || $key == "counter" || $key == "container_group" || $key == "date_format"): ?>
										<select name="<?php echo $type ?>_set[<?php echo $key; ?>]">
							    			<?php foreach ($element[1] as $opt => $option) : 
							    			
							    				if($key == "date_format") :
							    					$html = date($option);
							    				else: 
							    					$html = $option;
							    				endif;?>
							    				<option value="<?php echo esc_attr($option) ?>" <?php selected($output[$key],$option) ?>><?php echo esc_html($html) ?></option>
							    			<?php endforeach; ?>	
							    		</select>
						    		<?php else:

					    				if($key == "extra_large"){
											$col = "col-xl-";
										}
										elseif($key == "large"){
											$col = "col-lg-";
										}
										elseif($key == "medium"){
											$col = "col-md-";
										}
										elseif($key == "small"){
											$col = "col-sm-";
										}
										elseif($key == "extra_small"){
											if(get_option( 'tcard_bootstrap_version' ) === 'bootstrap3'){
												$col = "col-xs-";
											}elseif(get_option( 'tcard_bootstrap_version' ) === 'bootstrap4'){
												$col = "col-";
											}elseif(empty(get_option( 'tcard_bootstrap_version' ))){
												$col = array('col-','col-xs-');
											}
										}

										if($key == "extra_small"){
											$inherit = "";
										}else{
											$inherit = "Inherit";
										}?>

						    			<select class="tcard-input" name="<?php echo esc_attr($type) ?>_set[<?php echo esc_attr($key); ?>]">
						    				
						    				<?php if(!empty($inherit)) :?>
					    						<option value="<?php echo esc_attr($inherit); ?>" <?php selected( $output[$key],$inherit); ?>><?php echo esc_html($inherit); ?></option>
					    					<?php endif;
					    					if(is_array($col)) :
					    						for ($i = $element[1]; $i > 0; $i=$i-1) : ?>
							    					<option value="<?php echo $col[0].$i ." ".$col[1].$i ?>" <?php selected( $output[$key],$col[0].$i ." ".$col[1].$i ); ?>><?php echo $col[1].$i ?></option>
							    				<?php endfor;
							    			else:

							    				for ($i = $element[1]; $i > 0; $i=$i-1) : ?>
							    					<option value="<?php echo esc_attr($col.$i); ?>" <?php selected( $output[$key],$col.$i ); ?>><?php echo esc_html($col.$i); ?></option>
							    				<?php endfor;

							    			endif;?>
							    			
							    		</select>

						    		<?php endif;
						    	else :

						    		if($element[1] == "checkbox") :
						    			
						    			if(!empty($output[$key]) && $output[$key] == 1) :
				 							$checked = "checked";
				 						else :
				 							$checked = "";
				 						endif; 
				 						?>

						    			<div class="tc-check-settings">
										  <input id="<?php echo esc_attr($key) ?>" type="<?php echo esc_attr($element[1]) ?>" name="<?php echo esc_attr($type. "_set[".$key); ?>]" value="1" <?php echo $checked; ?>>
										  <label for="<?php echo esc_attr($key) ?>"></label>
										</div>
						    		<?php elseif($element[1] == "number" || $element[1] == "text") : 
						    		(empty($output["cat_all_text"])) ? $output["cat_all_text"] = "All" : $output["cat_all_text"];
						    		(empty($output["loadingText"])) ? $output["loadingText"] = "Loading..." : $output["loadingText"];
						    		(empty($output["noData"])) ? $output["noData"] = "No more items" : $output["noData"];
						
						    		($key == "speed") ? $speed = "400" : $speed = ""?>

						    			<input type="<?php echo esc_attr($element[1]) ?>" placeholder="<?php echo esc_attr($speed) ?>" name="<?php echo esc_attr($type. "_set[".$key) ?>]" value="<?php echo esc_attr($output[$key]) ?>">
						    		<?php endif;	

						    	endif; ?>	
						    </td>
						    <td>
						    	<div class="setting-info"><?php echo esc_html($element[3]); ?></div>
						    	<?php if($key == "random") : ?>
						    		<div class="clear-random"><?php _e('Clear animations', 'tcard') ?></div>
						    	<?php endif; ?>
						    </td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php elseif($type == "items") : 

				if($elements['set_style'] == "custom") : ?>

					<?php if($category_type == "post") : ?>
						<div class="modal-post-header">
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">title</div>     
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">date</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">comment count</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">button</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">content</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">author</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">featured image</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">show category</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($category) ?>">tags</div>
						</div>
						<?php elseif($category_type == "woocommerce") : ?>

							<div class="modal-post-header select_woocommerce">
								<?php $wc_all_methods = array('group','name','is_on_sale','out_of_stock','featured','price','short_description','total_sales','tax_status','tax_class','stock_quantity','weight','dimensions','shipping_class','image','rating','add_to_cart','tags','categories');
 
								foreach ($wc_all_methods as $key => $wc_method) : 
									if($wc_method == "group"):
										$title_wc_method = "group image";
									else:
										$title_wc_method = str_replace("_"," ",$wc_method);
									endif;
									?>
									
									<div class="select_wc_method" data-method="<?php echo esc_attr($wc_method); ?>" data-itemnum="<?php echo esc_attr($category) ?>"><?php echo esc_html($title_wc_method); ?></div>

								<?php endforeach; ?>
							
							</div>
						<?php endif; ?>
					

				<?php 
					$modal_post_content = "modal-post-content";
				else :
					$modal_post_content = "";
				endif;?>
				
				
				<div class="<?php echo esc_attr($modal_post_content); ?> arcfilter_item_post">
						
					<?php 
					
						if($category_type == "post") :
							if(empty($elements['post_item']) || $elements['set_style'] == "style_1"){
								$elements['post_item'] = array('featured_image','title','date','content','post_button','author','comment_count','tags','show_category');
							}
							elseif($elements['set_style'] == "style_2"){
								$elements['post_item'] = array('title','content','featured_image');
							}
							elseif($elements['set_style'] == "style_3"){
								$elements['post_item'] = array('featured_image','title','content','date','author','comment_count','post_button');
							}
							elseif($elements['set_style'] == "style_4"){
								$elements['post_item'] = array('show_category','title','featured_image','content','post_button','tags');
							}

							if(!empty($elements['post_item'])):
								foreach ($elements['post_item'] as $key => $post_item) :

									(!empty($elements['set_item'][$post_item])) ? $elements['set_item'][$post_item] : $elements['set_item'][$post_item] = "";?>

									<div class="tc_post_item <?php echo esc_attr($post_item); ?>">
										<input class="tcard-input" type="hidden" name="cat_items<?php echo esc_attr($category); ?>[post_item][]" value="<?php echo esc_attr($post_item) ?>">
										
										<?php if($elements['set_style'] == "custom") : ?>
											<div class="remove-post-item"></div>
										<?php endif;		 
										if($post_item == "post_button") : ?>
												<h4>Button</h4>
										<?php else : 
												$title_item = str_replace("_"," ",$post_item)?>
												<h4><?php echo esc_html($title_item); ?></h4>	
										<?php endif; ?>
										

										<?php if($post_item == "title" || $post_item == "content") : 
											
											if($elements['set_style'] == "style_2") :
												if($post_item == "content") :
													$max_words = 6;
												else:
													$max_words = 3; 	
												endif;
											else :
												if($post_item == "content") :
													$max_words = 17;
												else:
													$max_words = ""; 	
												endif;
											endif;?>

											<span><?php _e('Max words','tcard') ?></span> 
											<input class="tcard-input" type="number" placeholder="<?php echo esc_attr($max_words); ?>" name="cat_items<?php echo esc_attr($category . "[set_item][" .$post_item); ?>]" value="<?php echo esc_attr($elements['set_item'][$post_item]); ?>">

										<?php elseif($post_item == "post_button") : ?>
											<span><?php _e('Button Text','tcard') ?></span> 
											<input class="tcard-input" type="text" placeholder="Read More" name="cat_items<?php echo esc_attr($category . "[set_item][" .$post_item); ?>]" value="<?php echo esc_attr($elements['set_item'][$post_item]); ?>">

										<?php elseif($post_item == "comment_count" || $post_item == "tags" || $post_item == "date" || $post_item == "author" || $post_item == "show_category") :

											if($elements['set_item'][$post_item] == $post_item.'_post_text') :
												$display_text = "display_input";
											else :
												$display_text = '';
											endif;?>	

											<span><?php _e('Type','tcard') ?></span> 
											<select class="post_select_type tcard-input" name="cat_items<?php echo esc_attr($category . "[set_item][" .$post_item); ?>]">
												<option></option>
												<option value='<?php echo esc_attr($post_item) ?>_post_icon' <?php selected( $elements['set_item'][$post_item], $post_item.'_post_icon' ); ?>>Icon</option>
												<option value="<?php echo esc_attr($post_item) ?>_post_text" <?php selected( $elements['set_item'][$post_item], $post_item.'_post_text' ); ?>>Text</option>
											</select> 
											<?php (!empty($elements['set_item'][$post_item. "_text"])) ? $elements['set_item'][$post_item. "_text"] : $elements['set_item'][$post_item. "_text"] = ""; ?>

											<input class="tcard-input input-type-text <?php echo $display_text ?>" type="text" name="cat_items<?php echo $category . "[set_item][" .$post_item. "_text" ?>]" value="<?php echo esc_attr($elements['set_item'][$post_item. "_text"]); ?>">
										<?php endif; ?>	
									</div>

								<?php endforeach; 
							endif;
						else :

							if(empty($elements['post_item']) || $elements['set_style'] == "style_1"){
								$elements['post_item'] = array('group','name','price','rating','short_description','add_to_cart');
							}
							elseif($elements['set_style'] == "style_2"){
								$elements['post_item'] = array('group','name','rating','price','add_to_cart');
							}
							elseif($elements['set_style'] == "style_3"){
								$elements['post_item'] = array('group','price','name','add_to_cart','categories','tags','rating');
							}
							elseif($elements['set_style'] == "style_4"){
								$elements['post_item'] = array('group','categories','name','price','add_to_cart','rating');
							}

							if(!empty($elements['post_item'])):

								foreach ($elements['post_item'] as $key => $post_item) :

									(!empty($elements['set_item'][$post_item])) ? $elements['set_item'][$post_item] : $elements['set_item'][$post_item] = "";?>

									<div class="tc_post_item <?php echo esc_attr($post_item); ?>">
										<input class="tcard-input" type="hidden" name="cat_items<?php echo esc_attr($category); ?>[post_item][]" value="<?php echo esc_attr($post_item) ?>">
										
										<?php if($elements['set_style'] == "custom") : ?>
											<div class="remove-post-item"></div>
										<?php endif;		 
										if($post_item == "group"):
											$title_item = "group image";
										else:
											$title_item = str_replace("_", " ", $post_item);
											$title_item = ucfirst($title_item);
										endif;?>
										<h4><?php echo esc_html($title_item); ?></h4>
										

										<?php if($post_item == "name" || $post_item == "short_description") : 
											
											if($post_item == "short_description") :
												$max_words = 17;
											else:
												$max_words = ""; 	
											endif;?>

											<span><?php _e('Max words','tcard') ?></span> 
											<input class="tcard-input" type="number" placeholder="<?php echo esc_attr($max_words); ?>" name="cat_items<?php echo esc_attr($category . "[set_item][".$post_item); ?>]" value="<?php echo esc_attr($elements['set_item'][$post_item]); ?>">
										<?php elseif($post_item == "image") : ?>
											<span><?php _e('Change image on hover','tcard') ?></span> 	
											<div class="tc-check-settings hover_image">
											  <input id="hover_image<?php echo $category ?>" type="checkbox" <?php checked($elements['set_item'][$post_item] , 1) ?> name="cat_items<?php echo esc_attr($category . "[set_item][".$post_item); ?>]" value="1">
											  <label for="hover_image<?php echo $category ?>"></label>
											</div>

										<?php elseif($post_item == "group") : ?>	
											<span><?php _e('Change image on hover','tcard') ?> 	
											<div class="tc-check-settings hover_image">
											  <input id="group_hover_image<?php echo $category ?>" type="checkbox" <?php checked($elements['set_item'][$post_item] , 1) ?> name="cat_items<?php echo esc_attr($category . "[set_item][".$post_item); ?>]" value="1">
											  <label for="group_hover_image<?php echo $category ?>"></label>
											</div>
											Badges: <span class="group_badges">
											<?php printf(
											    __( 'Sale%s Out of stock%s Featured', 'tcard' ),
											    ",",","
											);?></span>
											</span>
										<?php elseif($post_item !== "is_on_sale" && $post_item !== "featured" && $post_item !== "out_of_stock" && $post_item !== "price" && $post_item !== "add_to_cart" && $post_item !== "rating") : ?>
											<span><?php _e('Text','tcard') ?></span> 
											<input class="tcard-input" placeholder="<?php echo esc_attr($title_item); ?>" type="text" name="cat_items<?php echo $category . "[set_item][" .$post_item ?>]" value="<?php echo esc_attr($elements['set_item'][$post_item]); ?>">
										<?php endif; ?>	
									</div>

								<?php endforeach;
							endif;
							
						endif; ?>

				</div>
			<?php endif; ?>
		</div>
		<div class="tcard-modal-footer">
			<div class="tcard-close-modal">
				Close
			</div>
		</div>
	</div>
</div>