<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

?>

<div class="tcard-element <?php echo $output['tc_col']. " " .$element ?>" data-element="<?php echo $element. "-" . ($elemNumber + 1) ?>">
	<input class="tcard-input" type="hidden" name="elements<?php echo $skin. "_" .$side ?>[footer][]" value="<?php echo esc_attr($element) ?>">
	<div class="tcard-element-bar <?php echo $no_width_set; ?>">
		<?php if($element == "image_button") : ?>
			<h4><?php _e( 'Button:', 'tcard' ) ?> </span> 
				<span class="tcard-button-type <?php echo $element ?>">
					<img class="tcard-avatar-src" src="<?php echo esc_url($output[$element]) ?>">
				</span>
			</h4>
		<?php else: ?>
			<?php echo $output['title'] ?>: <span><?php echo $check ?></span>
		<?php endif; ?>	
	</div>
	<div class="tcard-modal">
		<div class="tcard-modal-body modal-elements">
			<div class="tcard-modal-header <?php echo $social_menu ?>">
				<h4><?php _e( 'Footer:', 'tcard' ) ?> <?php echo $output['title'] ?></h4>
				<?php if($skin_type !== $pre_skin && $element == "info_list") : ?>
					<h4 class="tcard-add-item" data-itemnum="<?php echo esc_attr($elemNumber) ?>"> <?php _e( 'Add Item', 'tcard' ) ?> </h4>
				<?php endif ?>
				<?php if($element == "twitter_profile") : ?>

					<div class="settings-btns">
						<div class="settings-btn tc-current-side" data-menu-container="settings_twitter"><?php _e( 'Settings', 'tcard' ) ?></div>
						<div class="settings-btn" data-menu-container="twitter_text"><?php _e( 'Text', 'tcard' ) ?></div>
						<div class="settings-btn" data-menu-container="twitter_animations"><?php _e( 'Animations', 'tcard' ) ?></div>
					</div>

				<?php endif; ?>
				
			</div>
			<div class="tcard-modal-content <?php echo $element ?>">
				<?php if($element === "tc_button") : 

					(!empty($output['tc_button_link'])) ? $output['tc_button_link'] : $output['tc_button_link'] = "";
					(!empty($output['tc_button_name'])) ? $output['tc_button_name'] : $output['tc_button_name'] = "";
					(!empty($output['tc_button_extra'])) ? $output['tc_button_extra'] : $output['tc_button_extra'] = "";?>

					<?php if($skin_type !== $pre_skin) : ?>

						<div class="tcard-modal-item">
							<h4><?php _e( 'Button type:', 'tcard' ) ?> </h4> 
							<select class="tcard-input tc-show-input" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>][]">
								<option value="main" <?php selected( $output[$element], 'main' ); ?>>main</option>
								<option value="link" <?php selected( $output[$element], 'link' ); ?>>link</option>
							</select>
						</div>

					<?php endif;?>

					<div class="tcard-modal-item tchp_text_btn <?php echo $display ?>">
						<h4><?php _e( 'Button URL:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>_link][]" value="<?php echo esc_url($output['tc_button_link']) ?>">
					</div>
					
					<div class="tcard-modal-item">
						<h4><?php _e( 'Button Name:', 'tcard' ) ?> </h4> 
						<input class="tcard-input tc-input-title" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>_name][]" value="<?php echo esc_attr($output['tc_button_name']) ?>">
					</div>
					<div class="tcard-modal-item">
						<h4><?php _e( 'Extra Text:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>_extra][]" value="<?php echo esc_attr($output['tc_button_extra']) ?>">
					</div>

					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'footer',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'footer',$side, $skin, $output['delay'] ) ?>
					</div>

				<?php elseif($element === "social_list") : ?>

					<div class="tcard-modal-item">
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">facebook</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">twitter</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">google+</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">instagram</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">pinterest</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">reddit</div> 
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">linkedin</div> 
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">tumblr</div>
						<div class="tc-list tcard-add-item tcard_con_reg_menu" data-itemnum="<?php echo $elemNumber ?>">flickr</div>
					</div>
					<div class="tcard-modal-sortable">

						<?php if(!empty($output['social_list_order'])) :

							foreach ($output['social_list_order'] as $key => $item) :

								(!empty($output[$element][$key])) ? $output[$element][$key] : $output[$element][$key] = "";

								if($item == "google+") :
									$icon = "google-plus-square";
								elseif($item == "instagram" || $item == "linkedin" || $item == "flickr") :
									$icon = "$item";	
								else :
									$icon = "$item-square";
								endif; ?>

								<div class="tcard-modal-item">
									<div class="tcard-modal-item-inner tcard_con_reg">
										<input class="tcard-input" type="hidden" name="footer<?php echo $skin. "_" .$side. "[" .$element. "_order" .$elemNumber ?>][]" value="<?php echo esc_attr($item) ?>">
										<h4><i class="fab fa-<?php echo $icon; ?>"></i></h4>
										<input class="tcard-input" type="text" placeholder="<?php echo $item; ?> username" name="footer<?php echo $skin. "_" .$side. "[" .$element.$elemNumber ?>][]" value="<?php echo stripslashes($output[$element][$key]) ?>">
										<h4 class="tcard-btn-style tcard-remove-item"></h4>
										<?php echo $animations->set_delay( 'footer',$side, $skin, $output['delay'] ) ?>
									</div>
								</div>
							<?php endforeach;

						endif; ?>

					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'footer',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>

				<?php elseif($element == "image_button") : ?>

					<div class="tcard-modal-item last">
						<h4><?php _e( 'Position:', 'tcard' ) ?></h4> 
						<select class="tcard-input" name="footer<?php echo $skin. "_" .$side ?>[button_pos][]">
							<option value="left-button" <?php selected( $output['button_pos'], 'left-button' ); ?>>Left</option>
							<option value="center-button" <?php selected( $output['button_pos'], 'center-button' ); ?>>Center</option>
							<option value="right-button" <?php selected( $output['button_pos'], 'right-button' ); ?>>Right</option>
						</select>
					</div>

					<div class="tcard-modal-item">
						<h4><?php _e( 'Button type:', 'tcard' ) ?> </h4> 
						<select class="tcard-input tc-show-input" name="footer<?php echo $skin. "_" .$side. "[" .$element . "_type" ?>][]">
							<option value="main" <?php selected( $output[$element . "_type"], 'main' ); ?>>main</option>
							<option value="link" <?php selected( $output[$element . "_type"], 'link' ); ?>>link</option>
						</select>
					</div>

					<div class="tcard-modal-item tchp_text_btn <?php echo $display_link ?>">
						<h4><?php _e( 'Button URL:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>_link][]" value="<?php echo esc_url($output['tc_button_link']) ?>">
					</div>

					<div class="tcard-modal-item <?php echo esc_attr($element) ?>">
						<div class="tcard-modal-item-inner">
							<h4><?php _e( 'Image:', 'tcard' ) ?>
												
								<img class="tcard-avatar-src" src="<?php echo esc_url($output[$element]) ?>">
							
							</h4>
							<input class="tcard-input tcard-image-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo $output[$element] ?>">
							<h4 class="tcard-btn-style tcard-up-image"> Upload Image </h4>
						</div>
					</div>

					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'footer',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
						$animations->set_delay( 'footer',$side, $skin, $output['delay'] ) ?>
					</div>
				<?php elseif($element === "info") : 

					(!empty($output["info_title"])) ? $output["info_title"] : $output["info_title"] = "";
					(!empty($output[$element])) ? $output[$element] : $output[$element] = "";?>

					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4><?php _e( 'Title:', 'tcard' ) ?> </h4> 
							<input class="tcard-input tc-input-title" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>_title][]" value="<?php echo $output["info_title"] ?>">
						</div>
						<?php echo $animations->set_delay( 'footer',$side, $skin, $output['delay'] ); ?>
					</div>

					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4 class="tc-modal-editor-title"><?php _e( 'Description:', 'tcard' ) ?> </h4> 
							<textarea id="tc-footer-editor-<?php echo $side. "_" .$element.$skin.$elemNumber; ?>" class="tcard-textarea tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element ?>][]"><?php echo $output[$element] ?></textarea>
						</div>
						<?php echo $animations->set_delay( 'footer',$side, $skin, $output['delay'] ); ?>
					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'footer',$side, $skin, $output['animation_in'], $output['animation_out'] ); ?>
					</div>

				<?php elseif($element === "info_list") : ?>
					<div class="tcard-modal-sortable">

						<?php for ($i = 0; $i < $info_list; $i++) : 
							(!empty($output['info_list_title'][$i])) ? $output['info_list_title'][$i] : $output['info_list_title'][$i] = "";
							(!empty($output['info_list_text'][$i])) ? $output['info_list_text'][$i] : $output['info_list_text'][$i] = "";
							?>
								<div class="tcard-modal-item tcard_con_reg">
									<div class="tcard-modal-item-inner">
										<h4 class="tcard-with-em"><?php _e( 'Item Title:', 'tcard' ) ?> <br><span class="tcard-em">Require</span></h4> 
										<input class="tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element. "_title" .$elemNumber ?>][]" value="<?php echo esc_attr(stripslashes($output['info_list_title'][$i])) ?>">
										<h4 class="tcard-remove-item"></h4>
									</div>
									<div class="tcard-modal-item-inner">
										<h4>Item Text: </h4> 
										<input class="tcard-input" type="text" name="footer<?php echo $skin. "_" .$side. "[" .$element. "_text" .$elemNumber ?>][]" value="<?php echo esc_attr(stripslashes($output['info_list_text'][$i])) ?>">
									</div>
									<?php echo $animations->set_delay( 'footer',$side, $skin, $output['delay'] ) ?>
								</div>
						<?php endfor;?>
					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'footer',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>
					
				<?php elseif($element === "twitter_profile" || $element === "twitter_feed") : ?>

					<?php require TCARD_ADMIN_URL . "templates/elements/TcardSocialElements.php"; ?>

				<?php endif; ?>
			</div>
			<div class="tcard-modal-footer">
				<div class="tcard-close-modal">Close</div>
			</div>
		</div>
	</div>
	<?php if($skin_type !== $pre_skin) : ?>
		<span class="tcard-delete-element"><i class="fas fa-trash-alt"></i></span>
		<div class="tcard-element-size">
			<span class="decreases-size"> <i class="fas fa-chevron-left"></i> </span> <input class="elem-width tcard-input" type="text" name="footer<?php echo $skin. "_" .$side;?>[element_width][]" value="<?php echo $output['element_width'] ?>" readonly>  <span class="increase-size"> <i class="fas fa-chevron-right"></i> </span>
		</div>
	<?php endif; ?>
</div>