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
	<input class="tcard-input" type="hidden" name="elements<?php echo $skin. "_" .$side ?>[content][]" value="<?php echo esc_attr($element) ?>">
	<div class="tcard-element-bar <?php echo $no_width_set; ?>"><?php echo $output['title'] ?>: <span><?php echo $check ?></span></div>
	<div class="tcard-modal">
		<div class="tcard-modal-body modal-elements">
			<div class="tcard-modal-header <?php echo $social_menu ?>">
				<h4><?php _e( 'Content:', 'tcard' ) ?> <?php echo $output['title'] ?></h4>
				<?php if($skin_type !== $pre_skin && $element == "skills" || $element == "list") : ?>
					<h4 class="tcard-add-item" data-itemnum="<?php echo esc_attr($elemNumber) ?>"><?php _e( 'Add Item', 'tcard' ) ?></h4>
				<?php endif ?>
				<?php if($element == "twitter_profile") : ?>

					<div class="settings-btns">
						<div class="settings-btn tc-current-side" data-menu-container="settings_twitter"><?php _e( 'Settings', 'tcard' ) ?></div>
						<div class="settings-btn" data-menu-container="twitter_text"><?php _e( 'Text', 'tcard' ) ?></div>
						<div class="settings-btn" data-menu-container="twitter_animations"><?php _e( 'Animations', 'tcard' ) ?></div>
					</div>

				<?php endif; ?>

				<?php if($element == "slider") : ?>

					<h4 class="tcard-add-slide" data-itemnum="<?php echo esc_attr($elemNumber) ?>"> <?php _e( 'Add Slide', 'tcard' ) ?> </h4>

				<?php endif; ?>
				
			</div>
			<div class="tcard-modal-content <?php echo $element ?>">

				<?php if($element === "skills") : ?>
					
					<?php if($skin_type !== $pre_skin) : ?>
						<div class="tcard-modal-item">
							<h4><?php _e( 'Skills type:', 'tcard' ) ?> </h4> 
							<select class="tcard-input tc-skills-type" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]">
								<option value="bar" <?php selected( $output[$element], 'bar' ); ?>>Bar</option>
								<option value="circle" <?php selected( $output[$element], 'circle' ); ?>>Circle</option>
							</select>
						</div>
						<div class="tcard-modal-item">
							<h4><?php _e( 'Skill percent:', 'tcard' ) ?> </h4> 
							<select class="tcard-input tc-skills-type" name="content<?php echo $skin. "_" .$side. "[" .$element . "_number" ?>][]">
								<option value="percent" <?php selected( $output["skills_number"], 'percent' ); ?>>With sign (%)</option>
								<option value="number" <?php selected( $output["skills_number"], 'number' ); ?>>Without sign (%)</option>
							</select>
						</div>
					<?php endif;
					if(!empty($skills_number[$skin][$side][$elemNumber])) : 
						for ($i = 0; $i < $skills_number[$skin][$side][$elemNumber]; $i++) : 
							(!empty($output['skill'][$i])) ? $output['skill'][$i] : $output['skill'][$i] = "";
							(!empty($output['skill_percent'][$i])) ? $output['skill_percent'][$i] : $output['skill_percent'][$i] = "";?>
							<div class="tcard-modal-item tc-skill-item">
								<div class="tc-skill-name">
									<h4>Skill name: </h4> 
									<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element. "_skill" .$elemNumber ?>][]" value="<?php echo stripslashes($output['skill'][$i]) ?>">
									<?php if($skin_type !== $pre_skin) : ?>
										<h4 class="tcard-remove-item"></h4>
									<?php endif; ?>
								</div>
								<div class="tc-skill-percent">
									<h4>Skill percent:</h4> 
									<input class="tcard-input" type="number" name="content<?php echo $skin. "_" .$side. "[" .$element. "_percent" .$elemNumber ?>][]" value="<?php echo $output['skill_percent'][$i] ?>">
								</div>
								<?php echo $animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
							</div>
						<?php endfor; ?>
					<?php endif; ?>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>

				<?php elseif($element === "info") : 

					(!empty($output["info_title"])) ? $output["info_title"] : $output["info_title"] = "";?>

					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4><?php _e( 'Title:', 'tcard' ) ?> </h4> 
							<input class="tcard-input tc-input-title" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_title][]" value="<?php echo $output["info_title"] ?>">
						</div>
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>
					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4><?php _e( 'Description:', 'tcard' ) ?> </h4> 
							<textarea id="tc-content-editor-<?php echo $side. "_" .$element.$skin.$elemNumber; ?>" class="tcard-textarea tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]"><?php echo (!empty($output[$element])) ? $output[$element] : $output[$element] = ""; ?></textarea>
						</div>
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>

				<?php elseif($element === "item") : ?>

					<?php $title_item[0] = "tc-input-title"; 

					for ($i = 0; $i < $item_list; $i++) : 

						if($skin_type == "skin_6" && $side == "back"){
							$tag = $i + 3;
						}else{
							$tag = $i + 2;
						}

						(!empty($output['item'][$i])) ? $item_list_text = stripslashes($output['item'][$i]) : $item_list_text = "";
						?>

						<div class="tcard-modal-item">
							<div class="tcard-modal-item-inner">
								<h4 class="tcard-with-em"><?php _e( 'Text:', 'tcard' ) ?> <br> <em class="tcard-em">H<?php echo $tag ?> <?php _e( 'tag', 'tcard' ) ?></em></h4>
								<input class="tcard-input <?php echo $title_item[$i] ?>" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element.$elemNumber ?>][]" value="<?php echo $item_list_text; ?>">
							</div>
							<?php echo $animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
						</div>
					<?php endfor ?>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>

				<?php elseif($element === "ellipsis_text") : ?>

					<div class="tcard-modal-item tc-textarea-title">
						<h4><?php _e( 'Description:', 'tcard' ) ?> </h4> 
						<textarea id="tc-content-editor-<?php echo $side. "_" .$element.$skin.$elemNumber; ?>" class="tcard-textarea tcard-input tc-input-title" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]"><?php echo (!empty($output[$element])) ? $output[$element] : $output[$element] = ""; ?></textarea>
					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>

				<?php elseif($element === "profile") : 

					(!empty($output[$element])) ? $output[$element] : $output[$element] = "";
					(!empty($output['profile_email'])) ? $profile_email_em = $output['profile_email'] : $profile_email_em = "";
					
					?>

					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4 class="tcard-with-em"><?php _e( 'Image:', 'tcard' ) ?> <br> <em class="tcard-em"><?php printf(__( 'Image size: %s', 'tcard' ), "80 X 80"); ?></em> </h4>
							<input class="tcard-input tcard-image-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo $output[$element] ?>">
							<h4 class="tcard-up-image"> <?php _e( 'Upload Image', 'tcard' ) ?> </h4>
						</div>
						<div class="tcard-modal-item-inner tcard-profile-image <?php echo $avatar_is_set ?>">
							<img class="tcard-avatar-src" src="<?php echo esc_url($output[$element]) ?>">
						</div>
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>

					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4 class="tcard-with-em"><?php _e( 'Button Type:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'If the gallery exists', 'tcard' ) ?></em></h4> 
							<select class="tcard-input tc-show-input" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_btntype][]">
								<option value="icon" <?php selected( $output['profile_btntype'], 'icon' ); ?>>Icon</option>
								<option value="text" <?php selected( $output['profile_btntype'], 'text' ); ?>>Text</option>
							</select>
							<input class="tcard-input tchp_text_btn <?php echo $display ?>" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_btntext][]" value="<?php echo $output['profile_btntext'] ?>" style="margin-top: 10px;">
						</div>
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>
					
					<div class="tcard-modal-item">
						<div class="tcard-modal-item-inner">
							<h4><?php _e( 'Email:', 'tcard' ) ?></h4> 
							<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_email][]" value="<?php echo $profile_email_em ?>">
						</div>
						<div class="tcard-modal-item-inner">
							<h4 class="tcard-with-em"><?php _e( 'Button Type:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'If is an email set:', 'tcard' ) ?></em></h4> 
							<select class="tcard-input tc-show-input" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_emailtype][]">
								<option value="icon" <?php selected( $output['profile_emailtype'], 'icon' ); ?>>Icon</option>
								<option value="text" <?php selected( $output['profile_emailtype'], 'text' ); ?>>Text</option>
							</select>
							<input class="tcard-input tchp_text_btn <?php echo $display ?>" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_emailtext][]" value="<?php echo $output['profile_emailtext'] ?>" style="margin-top: 10px;">
						</div>
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>

				<?php elseif($element === "list") : ?>
					<div class="tcard-modal-sortable">
						<?php for ($i = 0; $i < $list_number[$skin][$side][$elemNumber]; $i++) : ?>
							<div class="tcard-modal-item tcard_con_reg">
								<div class="tcard-modal-item-inner">
									<h4>Text: </h4> 
									<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element.$elemNumber ?>][]" value="<?php echo stripslashes($output[$element][$i]) ?>">
									<h4 class="tcard-remove-item"></h4>
								</div>
								<?php echo $animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
							</div>
						<?php endfor; ?>
					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>

				<?php elseif($element === "contact" || $element == "register") : ?>

					<div class="tcard-modal-item tcard_modal_menu_con">
						<?php if($element === "contact") : ?>

							<div class="tc-list tcard-add-item tcard_con_reg_menu">full name</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">first name</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">last name</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">subject</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">email</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">phone</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">website</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">company</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">message</div>
							<?php (!empty($output['contact_item'])) ? $label = $output['contact_item'] : $label = "";
							(!empty($output[$element."_admin_email"])) ? $contact_admin_email = $output[$element."_admin_email"] : $contact_admin_email = "";
							(!empty($output[$element."_button"])) ? $output[$element."_button"] : $output[$element."_button"] = "";
							$submit_button = "Send Message";
	

						elseif($element == "register") : ?>

							<div class="tc-list tcard-add-item tcard_con_reg_menu">username</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">email</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">password</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">repeat password</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">first name</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">last name</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">website</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">nickname</div>
							<div class="tc-list tcard-add-item tcard_con_reg_menu">description</div>
							<?php (!empty($output['register_item'])) ? $label = $output['register_item'] : $label = "";
							(!empty($output[$element."_button"])) ? $output[$element."_button"] : $output[$element."_button"] = "";
							

							$submit_button = "Create account";
							
						endif; ?>
					</div>
					<?php if($element == "contact") : ?>
						<div class="tcard-modal-item">
							<h4 class="tcard-with-em"><?php _e( 'Email:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: admin email', 'tcard' ) ?></em></h4>  
							<input class="tcard-input" type="text" placeholder="<?php echo get_option("admin_email") ; ?>" name="content<?php echo $skin. "_" .$side. "[".$element."_admin_email" ?>][]" value="<?php echo $contact_admin_email; ?>">
						</div>
					<?php endif;?>
					<div class="tcard-modal-sortable">		
						<?php if(!empty($output[$element])) :

							foreach ($output[$element] as $key => $contact_item) : 
								(!empty($label[$key])) ? $set_label = stripslashes($label[$key]) : $set_label = "";
								?>
								<div class="tcard-modal-item">
									<div class="tcard-modal-item-inner tcard_con_reg">
										<input class="tcard-input" type="hidden" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo $contact_item ?>">
										<h4 class="tcard-with-em">Label name: <br> <em class="tcard-em">Default : <?php echo $contact_item; ?></em></h4>  
										<input class="tcard-input" placeholder="<?php echo $contact_item ?>" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_item][]" value="<?php echo $set_label; ?>">
										<h4 class="tcard-remove-item"></h4>
										<?php echo $animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
									</div>
								</div>
							<?php endforeach;

						endif; ?>
					</div>
					<div class="tcard-modal-item">
						<h4 class="tcard-with-em"><?php _e( 'Submit button:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default:', 'tcard' ) ?> <?php echo $submit_button; ?></em></h4>  
						<input class="tcard-input" type="text" placeholder="<?php echo $submit_button; ?>" name="content<?php echo $skin. "_" .$side. "[".$element."_button" ?>][]" value="<?php echo $output[$element."_button"] ?>">
					</div>
					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) ?>
					</div>

				<?php elseif($element === "login") : 

					(!empty($output[$element][0])) ? $output[$element][0] : $output[$element][0] = "";
					(!empty($output[$element][1])) ? $output[$element][1] : $output[$element][1] = "";
					(!empty($output[$element][2])) ? $output[$element][2] : $output[$element][2] = "";
					(!empty($output[$element][3])) ? $output[$element][3] : $output[$element][3] = "";
					(!empty($output[$element][4])) ? $output[$element][4] : $output[$element][4] = "";
					(!empty($output['login_display_title'][0])) ? $output['login_display_title'][0] : $output['login_display_title'][0] = "";
					(!empty($output['logout_login'])) ? $output['logout_login'] : $output['logout_login'] = "";
					(!empty($output['msjafter_login'])) ? $output['msjafter_login'] : $output['msjafter_login'] = "";
					?>

					<div class="tcard-modal-item">
						<h4><?php _e( 'Login title:', 'tcard' ) ?></h4>  
						<input class="tcard-input tc-input-title" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo stripslashes($output[$element][0]) ?>">
					</div>

					<div class="tcard-modal-item">
						<h4 class="tcard-with-em"><?php _e( 'Label login:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Login', 'tcard' ) ?></em></h4>  
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo stripslashes($output[$element][1]) ?>">
					</div>

					<div class="tcard-modal-item">
						<h4 class="tcard-with-em"><?php _e( 'Label password:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Password', 'tcard' ) ?></em></h4>  
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo stripslashes($output[$element][2]) ?>">
					</div>

					<div class="tcard-modal-item">
						<h4 class="tcard-with-em"><?php _e( 'Label button:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Submit', 'tcard' ) ?></em></h4>  
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo stripslashes($output[$element][3]) ?>">
					</div>

					<div class="tcard-modal-item">
						<h4 class="tcard-with-em"><?php _e( 'Remember password:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Remember me', 'tcard' ) ?></em></h4>  
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]" value="<?php echo stripslashes($output[$element][4]) ?>">
					</div>

					<div class="tcard-modal-item after_login">
						<div class="tcard-modal-item">
							<h4><?php _e( 'After Login display:', 'tcard' ) ?></h4> <span class="clear_after_login"><?php _e( 'Clear', 'tcard' ) ?></span>
							<select id="alex" multiple="multiple" name="content<?php echo $skin. "_" .$side. "["."after_".$element ?>][]">
								<?php foreach ($after_login as $value => $option) : 
									if($value == in_array($value, $output['after_login'])) :
										$selected = "selected";
									else :
										$selected = "";
									endif; ?>	
									<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $option ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="tcard-modal-item">
							<h4 class="tcard-with-em"><?php _e( 'Title:', 'tcard' ) ?> </h4>  
							<div class="tc-check-settings">
							  <input id="display_title" type="checkbox" name="content<?php echo $skin. "_" .$side. "[" .$element."_display_title".$elemNumber ?>][]" <?php checked( $output['login_display_title'][0], 1 , true ); ?> value="1">
							  <label for="display_title"></label>
							</div>
						</div>
						<div class="tcard-modal-item">
							<h4 class="tcard-with-em"><?php _e( 'Message to user:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Hello', 'tcard' ) ?> 'username'</em></h4>  
							<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "["."msjafter_".$element ?>][]" value="<?php echo $output['msjafter_login'] ?>">
						</div>
						<div class="tcard-modal-item">
							<h4 class="tcard-with-em"><?php _e( 'Logout button:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: Logout', 'tcard' ) ?></em></h4>  
							<input class="tcard-input" type="text" placeholder="<?php _e( 'Logout', 'tcard' ) ?>" name="content<?php echo $skin. "_" .$side. "["."logout_".$element ?>][]" value="<?php echo $output['logout_login'] ?>">
						</div>
					</div>

				<?php elseif($element === "address") : 
					(!empty($output[$element] )) ? $output[$element] : $output[$element] = ""; 
					(!empty($output['address_email'])) ? $output['address_email'] : $output['address_email'] = "";
					(!empty($output['address_phone'][0])) ? $output['address_phone'][0] : $output['address_phone'][0] = "";
					(!empty($output['address_phone'][1])) ? $output['address_phone'][1] : $output['address_phone'][1] = "";
					?>

					<div class="tcard-modal-item tc-textarea-title">
						<h4><?php _e( 'Address:', 'tcard' ) ?> </h4> 
						<textarea id="tc-content-editor-<?php echo $side. "_" .$element.$skin.$elemNumber; ?>" class="tcard-textarea tcard-input tc-input-title" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>][]"><?php echo $output[$element] ?></textarea>
					</div>
					<div class="tcard-modal-item">
						<h4><?php _e( 'Email:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_email][]" value="<?php echo $output['address_email'] ?>">
					</div>
					<div class="tcard-modal-item">
						<h4><?php _e( 'Phone:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_phone][]" value="<?php echo $output['address_phone'][0] ?>">
					</div>
					<div class="tcard-modal-item">
						<h4><?php _e( 'Phone 2:', 'tcard' ) ?> </h4> 
						<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_phone][]" value="<?php echo $output['address_phone'][1] ?>">
					</div>

					<div class="tcard-modal-item">
						<?php echo $animations->set_animation( 'content',$side, $skin, $output['animation_in'], $output['animation_out'] ) .
							$animations->set_delay( 'content',$side, $skin, $output['delay'] ) ?>
					</div>
				<?php elseif($element === "slider") : ?>	
			
						<?php if(!empty($output['slider_items_order'])) : ?>

							<div class="tcard-modal-item slider-menu-modal">
								<?php for ($slider_item = 0; $slider_item < count($output['slider_items_order']); $slider_item++) :

									($slider_item == 0) ? $curr_slide =  "tc-current-side" : $curr_slide =  "";?>
									<div class="settings-btn <?php echo $curr_slide ?>" data-menu-container="slide_<?php echo $slider_item; ?>">Slide <?php echo $slider_item + 1; ?></div>
								<?php endfor; ?>
							</div>

						<?php endif; ?>
					
					<?php if(!empty($output['slider_items_order'])) :
						for ($slider_item = 0; $slider_item < count($output['slider_items_order']); $slider_item++) :

							if(!empty($output["slider_btntext"][$slider_item])){
								$btntext = stripslashes($output["slider_btntext"][$slider_item]);
							}else{
								$btntext = "";
							}

							if(!empty($output["slider_btnlink"][$slider_item])){
								$btnlink = esc_url($output["slider_btnlink"][$slider_item]);
							}else{
								$btnlink = "";
							}
							
							(!empty($output[$element][$slider_item])) ? $slider_item_area =  html_entity_decode(stripslashes($output[$element][$slider_item])) : $slider_item_area = "";

							(!empty($output["slider_item_title"][$slider_item])) ? $slider_item_title = stripslashes($output["slider_item_title"][$slider_item]) : $slider_item_title = "";

							($slider_item == 0) ? $display_block =  "style='display:block'" : $display_block =  "";?>
							<div class="tcard-modal-container slider_container" <?php echo $display_block; ?> data-modal-container="slide_<?php echo $slider_item; ?>">
								<div class="tcard-remove-slide" data-remove-slide="slide_<?php echo $slider_item; ?>">Remove Slide</div>
								<input class="tcard-input" type="hidden" name="content<?php echo $skin. "_" .$side. "[" .$element. "_items_order" .$elemNumber ?>][]" value="<?php echo $output['slider_items_order'][$slider_item] ?>">

								<div class="tcard-modal-item">
									<h4><?php _e( 'Title:', 'tcard' ) ?> </h4> 
									<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_item_title<?php echo $elemNumber  ?>][]" value="<?php echo $slider_item_title; ?>">
								</div>

								<div class="tcard-modal-item">
									<h4 class="tc-modal-editor-title"><?php _e( 'Description:', 'tcard' ) ?> </h4> 
									<textarea id="tc-content-editor-<?php echo $side. "_" .$element.$skin.$elemNumber.$slider_item; ?>" class="tcard-textarea tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element.$elemNumber  ?>][]"><?php echo $slider_item_area; ?></textarea>
								</div>

								<div class="tcard-modal-item">
									<div class="tcard-modal-item-inner">
										<h4><?php _e( 'Button Text:', 'tcard' ) ?> </h4> 
										<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_btntext<?php echo $elemNumber  ?>][]" value="<?php echo $btntext; ?>">
									</div>
									<div class="tcard-modal-item-inner">
										<h4><?php _e( 'Button Link:', 'tcard' ) ?> </h4> 
										<input class="tcard-input" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element ?>_btnlink<?php echo $elemNumber  ?>][]" value="<?php echo $btnlink ?>">
									</div>
								</div>				
							</div>
						<?php endfor;
					endif; ?>
						
				<?php elseif($element === "twitter_profile" || $element === "twitter_feed") : ?>

					<?php require TCARD_ADMIN_URL . "templates/elements/TcardSocialElements.php"; ?>

				<?php elseif($element === "tcard_post") : ?>
						
						<div class="modal-post-header">
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">title</div>     
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">date</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">comment count</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">button</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">content</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">author</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">featured image</div>
							<div class="tc-post-element" data-itemnum="<?php echo esc_attr($elemNumber) ?>">show category</div>
						</div>
						
						<div class="modal-post-content">
								
							<?php if(!empty($output['tcard_post'])) :
								
								foreach ($output['tcard_post'] as $key => $post_item) : ?>
								
								<div class="tc_post_item <?php echo $post_item ?>">
									<input type="hidden" name="content<?php echo $skin. "_" .$side. "[" .$element.$elemNumber ?>][]" value="<?php echo $post_item ?>">
									<div class="remove-post-item"></div>
									<?php if($post_item == "post_button") : ?>
											<h4>Button</h4>
									<?php else : 
											$title_item = str_replace("_"," ",$post_item)?>
											<h4><?php echo $title_item; ?></h4>	
									<?php endif; ?>
									

									<?php if($post_item == "title" || $post_item == "content") : 

										if($post_item == "content") :
											$max_words = 17;
										else:
											$max_words = ""; 	
										endif;
										(!empty($output[$element . "_" . $post_item])) ? $output[$element . "_" . $post_item] : $output[$element . "_" . $post_item] = "";
										?>
										<span><?php _e('Max words','tcard') ?></span> 
										<input class="tcard-input" type="number" placeholder="<?php echo $max_words ?>" name="content<?php echo $skin. "_" .$side. "[" .$element . "_" . $post_item ?>][]" value="<?php echo $output[$element . "_" . $post_item] ?>">

									<?php elseif($post_item == "post_button") : ?>
										<span><?php _e('Button Text','tcard') ?></span> 
										<input class="tcard-input" type="text" placeholder="Read More" name="content<?php echo $skin. "_" .$side. "[" .$element . "_" . $post_item ?>][]" value="<?php echo $output[$element . "_" . $post_item] ?>">

									<?php elseif($post_item == "comment_count" || $post_item == "date" || $post_item == "author" || $post_item == "show_category") :
										(!empty($output[$element . "_" . $post_item])) ? $output[$element . "_" . $post_item] : $output[$element . "_" . $post_item] = ""; 
										if($output[$element . "_" . $post_item] == $post_item.'_post_text') :
											$display_text = "display_input";
										else :
											$display_text = '';
										endif;	

										?>
										<span><?php _e('Type','tcard') ?></span> 
										<select class="post_select_type tcard-input" name="content<?php echo $skin. "_" .$side. "[" .$element . "_" . $post_item ?>][]">
											<option></option>
											<option value='<?php echo $post_item ?>_post_icon' <?php selected( $output[$element . "_" . $post_item], $post_item.'_post_icon' ); ?>>Icon</option>
											<option value="<?php echo $post_item ?>_post_text" <?php selected( $output[$element . "_" . $post_item], $post_item.'_post_text' ); ?>>Text</option>
										</select>	
										<?php (!empty($output[$element . "_" . $post_item. "_text"])) ? $output[$element . "_" . $post_item. "_text"] : $output[$element . "_" . $post_item. "_text"] = ""; ?>
										<input class="tcard-input input-type-text <?php echo $display_text ?>" type="text" name="content<?php echo $skin. "_" .$side. "[" .$element . "_" . $post_item. "_text" ?>][]" value="<?php echo $output[$element . "_" . $post_item. "_text"] ?>">
									<?php endif; ?>	

								</div>

								<?php endforeach; 

							endif;?>

						</div>
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
			<span class="decreases-size"> <i class="fas fa-chevron-left"></i> </span> <input class="elem-width tcard-input" type="text" name="content<?php echo $skin. "_" .$side;?>[element_width][]" value="<?php echo $output['element_width'] ?>" readonly>  <span class="increase-size"> <i class="fas fa-chevron-right"></i> </span>
		</div>
	<?php endif; ?>
</div>