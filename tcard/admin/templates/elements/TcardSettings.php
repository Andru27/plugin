<?php
/**
 * @since           2.1.5
 * @package         Tcard
 * @subpackage  	Tcard/admin/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

?>
<div class="menu-sides">
	<?php foreach ($element as $menu_item => $main_sides) : 
			($menu_item == "tcard-front") ? $curr = "tc-current-side" : $curr = '';
			$title = str_replace('tcard-', '', $menu_item); ?>
			<div class="menu-sides-item <?php echo $curr ?>" data-menu-side="<?php echo $menu_item ?>"><?php _e($title,'tcard'); ?></div>
	<?php endforeach; ?>
</div>
	
<?php 
(!empty($output['tcard-front_frostedglass']) && $output['tcard-front_frostedglass'] == 1) ? $factive = "is_active" : $factive = "";
(!empty($output['tcard-front-tcard-header_frostedglass']) && $output['tcard-front-tcard-header_frostedglass'] == 1) ? $hfactive = "is_active" : $hfactive = "";
(!empty($output['tcard-front-tcard-content_frostedglass']) && $output['tcard-front-tcard-content_frostedglass'] == 1) ? $cfactive = "is_active" : $cfactive = "";
(!empty($output['tcard-front-tcard-footer_frostedglass']) && $output['tcard-front-tcard-footer_frostedglass'] == 1) ? $ffactive = "is_active" : $ffactive = "";
(!empty($output['tcard-back_frostedglass']) && $output['tcard-back_frostedglass'] == 1) ? $bactive = "is_active" : $bactive = "";
(!empty($output['tcard-back-tcard-header_frostedglass']) && $output['tcard-back-tcard-header_frostedglass'] == 1) ? $hbactive = "is_active" : $hbactive = "";
(!empty($output['tcard-back-tcard-content_frostedglass']) && $output['tcard-back-tcard-content_frostedglass'] == 1) ? $cbactive = "is_active" : $cbactive = "";
(!empty($output['tcard-back-tcard-footer_frostedglass']) && $output['tcard-back-tcard-footer_frostedglass'] == 1) ? $fbactive = "is_active" : $fbactive = ""; ?>

<div class="card-admin <?php echo $output['main_animation']; ?>">
	<div class="tcard-style">
		<div class="tcard-front" <?php echo TcardStyle::set_style($output,'front','box',$group_id,$skin,$widget = null); ?>>
			<div class="glass glass-front <?php echo $factive ?>" <?php echo TcardStyle::set_style($output,'front','glass',$group_id,$skin,$widget = null); ?>></div>
			<div class="tcard-header" <?php echo TcardStyle::set_style($output,'header-front','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-header-front <?php echo $hfactive ?>" <?php echo TcardStyle::set_style($output,'header-front','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>
			<div class="tcard-content" <?php echo TcardStyle::set_style($output,'content-front','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-content-front <?php echo $cfactive ?>" <?php echo TcardStyle::set_style($output,'content-front','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>
			<div class="tcard-footer" <?php echo TcardStyle::set_style($output,'footer-front','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-footer-front <?php echo $ffactive ?>" <?php echo TcardStyle::set_style($output,'footer-front','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>		
		</div>
		<div class="tcard-back" <?php echo TcardStyle::set_style($output,'back','box',$group_id,$skin,$widget = null); ?>>
			<div class="glass glass-back <?php echo $bactive ?>" <?php echo TcardStyle::set_style($output,'back','glass',$group_id,$skin,$widget = null); ?>></div>
			<div class="tcard-header" <?php echo TcardStyle::set_style($output,'header-back','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-header-back <?php echo $hbactive ?>" <?php echo TcardStyle::set_style($output,'header-back','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>
			<div class="tcard-content" <?php echo TcardStyle::set_style($output,'content-back','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-content-back <?php echo $cbactive ?>" <?php echo TcardStyle::set_style($output,'content-back','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>
			<div class="tcard-footer" <?php echo TcardStyle::set_style($output,'footer-back','box',$group_id,$skin,$widget = null); ?>>
				<div class="glass-box glass-footer-back <?php echo $fbactive ?>" <?php echo TcardStyle::set_style($output,'footer-back','glass',$group_id,$skin,$widget = null); ?>></div>
			</div>		
		</div>								
	</div>
</div>

<?php foreach ($element as $menu_item => $main_sides) : 
	($menu_item == "tcard-front") ? $active_side = "active_side" : $active_side = ""; ?>
	<div class="tcard-modal-side <?php echo $active_side ?>" data-modal-side="<?php echo $menu_item; ?>">

		<div class="menu_sides_boxs">
			<?php foreach ($main_sides as $set_menu) : 
				$title = str_replace('tcard-', '', $set_menu);
				if($set_menu == "tcard-front" || $set_menu == "tcard-back") :
					$active = "active";
				else:
					$active = "";
				endif;
				($title == "front") ? $title = 'side' : $title;
				($title == "back") ? $title = 'side' : $title;

				if($skin_type == "skin_1" && $set_menu !== "tcard-footer" 	|| 
					$skin_type == "skin_2" && $set_menu !== "tcard-footer" 	|| 
					$skin_type == "skin_3" && $set_menu !== "tcard-footer"	|| 
					$skin_type == "skin_4" && $set_menu !== "tcard-footer" 	|| 
					$skin_type == "skin_6" && $set_menu !== "tcard-footer"	|| 
					$skin_type == "skin_5" && $set_menu !== "tcard-header" && $set_menu !== "tcard-footer" ||
					$skin_type !== $pre_skin) : ?>
					<div class="menu_sides_box <?php echo $active ?>" data-menu-side_box="<?php echo $set_menu; ?>">
						<?php _e($title,'tcard') ?>
					</div>
			<?php endif;
			endforeach; ?>
		</div>

		<?php foreach ($main_sides as $set_menu) : 
			if($set_menu == "tcard-front" || $set_menu == "tcard-back") :
				$active = "active";
				$set = $set_menu;
			else:
				$set = $menu_item . "-" .$set_menu;
				$active = "";
			endif;
			$all_css_set = array('_box_shadow_on','_box_shadow_h','_box_shadow_v','_box_shadow_b','_box_shadow_s','_box_shadow_o','_box_shadow_c','_box_shadow_cc','_border_type','_border-style','_border-top-style','_border-right-style','_border-bottom-style','_border-left-style','_border-width','_border-top-width','_border-right-width','_border-bottom-width','_border-left-width','_border-color','_border-top-color','_border-right-color','_border-bottom-color','_border-left-color','_border_radius_type','_border-radius','_border-top-left-radius','_border-top-right-radius','_border-bottom-right-radius','_border-bottom-left-radius','_background-color','_background-image','_background-position','_background-size','_background-repeat','_background-attachment','_frostedglass','_frostedglass_bg_color','_frostedglass_img','_frostedglass_opa','_padding-top','_padding-right','_padding-bottom','_padding-left','_margin-top','_margin-right','_margin-bottom','_margin-left','_frostedglass_bg_colorg','_frostedglass_blur','_background-color_class','_color','_font-weight','_font-family');
			foreach ($all_css_set as $key => $css_set) {
				(!empty($output[$set.$css_set])) ? $output[$set.$css_set] = esc_attr($output[$set.$css_set]) : $output[$set.$css_set] = "";
			}?>
			<div class="tcard-modal-side_box <?php echo $active ?>" data-modal-side_box="<?php echo $set_menu; ?>">
				
				<div class="set_box">
			      	<div class="set_box_title">
			       		<?php _e('Box Shadow','tcard') ?>
			      	</div>
				    <div class="set_box_inner">
				        <div class="box_shadow_none">
				          	<?php _e('Shadow:','tcard') ?>
				          	<select class="select_type_set select_shadow tcard-input" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_on"?>]">
				          		<option></option>
				            	<option value="shadow_on" <?php selected( $output[$set."_box_shadow_on"], 'shadow_on' ); ?>>on</option>
				          	</select>
				        </div>

				        <?php 
				        if(!empty($output[$set."_box_shadow_on"])){
					        if($output[$set."_box_shadow_on"] == "shadow_on") : 
					        	$active = "active";
					        endif;
				        }else{
				        	$active = "";
				        }?>

				        <div class="sides_box box_shadow_value <?php echo $active ?>" data-active-box="shadow_on">
				          	<ul class="mini_boxs_ul">
				            	<li><?php _e('H-offset','tcard') ?>
				              		<input class="shadow-h tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_h"?>]" value="<?php echo $output[$set. "_box_shadow_h"] ?>"/>
				            	</li>
					            <li><?php _e('V-offset','tcard') ?>
					              	<input class="shadow-v tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_v"?>]" value="<?php echo $output[$set. "_box_shadow_v"] ?>"/>
					            </li>
					            <li><?php _e('Blur','tcard') ?>
					              	<input class="shadow-b tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_b"?>]" value="<?php echo $output[$set. "_box_shadow_b"] ?>"/>
					            </li>
					            <li><?php _e('Spread','tcard') ?>
					              	<input class="shadow-s tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_s"?>]" value="<?php echo $output[$set. "_box_shadow_s"] ?>"/>
					            </li>
					            <li><?php _e('Opacity','tcard') ?>
					              	<input class="shadow-o tcard-input" type="text" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_o"?>]" value="<?php echo $output[$set. "_box_shadow_o"] ?>"/>
					            </li>
					            <li class="half">
					              	<input class="shadow-c tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_c"?>]" value="<?php echo $output[$set. "_box_shadow_c"] ?>"/>
					              	<input class="tcard-input tcard-color-shadow" type="hidden" name="skin_set<?php echo $skin . "[" . $set."_box_shadow_cc"?>]" value="<?php echo $output[$set. "_box_shadow_cc"] ?>"/>
					            </li>
				          	</ul>
				        </div>
				    </div>
			    </div>
			    <?php if($skin_type !== $pre_skin) : 
			    	$border_style_p = array('none','dotted','dashed','solid','double','groove','ridge','inset','outset'); ?>
			    <div class="set_box">
				    <div class="set_box_title">
				    	<?php _e('Border','tcard') ?>
				    </div>
			      	<div class="set_box_inner">
			        	<div class="box_shadow_none">
			          		<?php _e('Apply to:','tcard') ?>
			          		<select class="select_type_set select_border tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border_type"?>]">
			          			<option></option>
			            		<option value="all_borders" <?php selected( $output[$set."_border_type"], 'all_borders' ); ?>><?php _e('all borders','tcard') ?></option>
			            		<option value="separate_border" <?php selected( $output[$set."_border_type"], 'separate_border' ); ?>><?php _e('separate border','tcard') ?></option>
			          		</select>
			        	</div>
				         <?php 

				        if(!empty($output[$set."_border_type"])){
					        if($output[$set."_border_type"] == "all_borders") : 
					        	$border_all_class = "border_all_class";
					        	$separate_border = "";
					        elseif($output[$set."_border_type"] == "separate_border"):
					        	$separate_border = "separate_border";
					        	$border_all_class = "";
					        endif;
				        }else{
				        	$border_all_class = "";
				        	$separate_border = "";	
				        }?>
				        <div class="sides_box border_all <?php echo $border_all_class ?>" data-active-box="all_borders">
							<ul class="mini_boxs_ul">
								<li class="side_title"><?php _e('All:','tcard') ?></li>
								<li class="border_width_box"><?php _e('Width(px)','tcard') ?>
									<input class="border-width tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_border-width"?>]" value="<?php echo $output[$set. "_border-width"] ?>"/>
								</li>
								<li class="border_style_box"><?php _e('Style','tcard') ?>
									<select class="border-style tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border-style"?>]">
										<option></option>
										<?php foreach ($border_style_p as $key => $border_style) : ?>
											<option value="<?php echo esc_attr($border_style) ?>" <?php selected( $output[$set."_border-style"], $border_style ); ?>><?php _e($border_style,'tcard') ?></option>
										<?php endforeach; ?>	
									</select>
								</li>
								<li class="border_color_box half">
									<input class="border-color tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-color"?>]" value="<?php echo $output[$set. "_border-color"] ?>"/>
								</li>
							</ul>
				        </div>
						<div class="sides_box border_all <?php echo $separate_border ?>" data-active-box="separate_border">
							<ul class="mini_boxs_ul borders">
								<li class="side_title"><?php _e('Top:','tcard') ?></li>
								<li class="border_width_box"><?php _e('Width(px)','tcard') ?>
									<input class="border-top-width tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_border-top-width"?>]" value="<?php echo $output[$set. "_border-top-width"] ?>"/>
								</li>
								<li class="border_style_box"><?php _e('Style','tcard') ?>
									<select class="border-top-style tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border-top-style"?>]">
										<option></option>
										<?php foreach ($border_style_p as $key => $border_style) : ?>
											<option value="<?php echo esc_attr($border_style) ?>" <?php selected( $output[$set."_border-top-style"], $border_style ); ?>><?php _e($border_style,'tcard') ?></option>
										<?php endforeach; ?>	
									</select>
								</li>
								<li class="border_color_box half">
									<input class="border-top-color tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-top-color"?>]" value="<?php echo $output[$set. "_border-top-color"] ?>"/>
								</li>
								<li class="side_title"><?php _e('Right:','tcard') ?></li>
								<li class="border_width_box"><?php _e('Width(px)','tcard') ?>
									<input class="border-right-width tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_border-right-width"?>]" value="<?php echo $output[$set. "_border-right-width"] ?>"/>
								</li>
								<li class="border_style_box"><?php _e('Style','tcard') ?>
									<select class="border-right-style tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border-right-style"?>]">
										<option></option>
										<?php foreach ($border_style_p as $key => $border_style) : ?>
											<option value="<?php echo esc_attr($border_style) ?>" <?php selected( $output[$set."_border-right-style"], $border_style ); ?>><?php _e($border_style,'tcard') ?></option>
										<?php endforeach; ?>	
									</select>
								</li>
								<li class="border_color_box half">
									<input class="border-right-color tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-right-color"?>]" value="<?php echo $output[$set. "_border-right-color"] ?>"/>
								</li>
								<li class="side_title"><?php _e('Bottom:','tcard') ?></li>
								<li class="border_width_box"><?php _e('Width(px)','tcard') ?>
									<input class="border-bottom-width tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_border-bottom-width"?>]" value="<?php echo $output[$set. "_border-bottom-width"] ?>"/>
								</li>
								<li class="border_style_box"><?php _e('Style','tcard') ?>
									<select class="border-bottom-style tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border-bottom-style"?>]">
										<option></option>
										<?php foreach ($border_style_p as $key => $border_style) : ?>
											<option value="<?php echo esc_attr($border_style) ?>" <?php selected( $output[$set."_border-bottom-style"], $border_style ); ?>><?php _e($border_style,'tcard') ?></option>
										<?php endforeach; ?>	
									</select>
								</li>
								<li class="border_color_box half">
									<input class="border-bottom-color tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-bottom-color"?>]" value="<?php echo $output[$set. "_border-bottom-color"] ?>"/>
								</li>
								<li class="side_title"><?php _e('Left:','tcard') ?></li>
								<li class="border_width_box"><?php _e('Width(px)','tcard') ?>
									<input class="border-left-width tcard-input" type="number" name="skin_set<?php echo $skin . "[" . $set."_border-left-width"?>]" value="<?php echo $output[$set. "_border-left-width"] ?>"/>
								</li>
								<li class="border_style_box"><?php _e('Style','tcard') ?>
									<select class="border-left-style tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border-left-style"?>]">
										<option></option>
										<?php foreach ($border_style_p as $key => $border_style) : ?>
											<option value="<?php echo esc_attr($border_style) ?>" <?php selected( $output[$set."_border-left-style"], $border_style ); ?>><?php _e($border_style,'tcard') ?></option>
										<?php endforeach; ?>	
									</select>
								</li>
								<li class="border_color_box half">
									<input class="border-left-color tcard-input tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-left-color"?>]" value="<?php echo $output[$set. "_border-left-color"] ?>"/>
								</li>
							</ul>
						</div>
			      	</div>
			    </div>

			    <div class="set_box">
			      	<div class="set_box_title">
			        	<?php _e('Border Radius','tcard') ?>
			      	</div>
			      	<div class="set_box_inner">
			        	<div class="box_shadow_none">
			          		<?php _e('Apply to:','tcard') ?>
			          		<select class="select_type_set select_border_radius tcard-input" name="skin_set<?php echo $skin . "[" . $set."_border_radius_type"?>]">
			          			<option></option>
			            		<option value="all_corners" <?php selected( $output[$set."_border_radius_type"], 'all_corners' ); ?>><?php _e('all corners','tcard') ?></option>
			            		<option value="separate_corner" <?php selected( $output[$set."_border_radius_type"], 'separate_corner' ); ?>><?php _e('separate corner','tcard') ?></option>
			          		</select>
			        	</div>
			        	 <?php 
			        	 if(!empty($output[$set."_border_radius_type"])){
					        if($output[$set."_border_radius_type"] == "all_corners") : 
					        	$border_all_class = "border_all_class";
					        	$separate_border = "";
					        elseif($output[$set."_border_radius_type"] == "separate_corner"):
					        	$separate_border = "separate_border";
					        	$border_all_class = "";
					        endif;
				        }else{
				        	$border_all_class = "";
				        	$separate_border = "";	
				        }?>
				        <div class="sides_box all_corners <?php echo $border_all_class ?>" data-active-box="all_corners">
				          	<ul class="mini_boxs_ul border_radius">
				            	<li class="side_title"><span><?php _e('All:','tcard') ?></span>
				              		<input class="tcard-input border-radius" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-radius"?>]" value="<?php echo $output[$set. "_border-radius"] ?>"/>
				            	</li>
				          	</ul>
				        </div>
				        <div class="sides_box separate_corner <?php echo $separate_border ?>" data-active-box="separate_corner">
				          	<ul class="mini_boxs_ul border_radius">
				            	<li class="side_title"><span><?php _e('Top-Right:','tcard') ?></span>
				              		<input class="tcard-input border-top-right-radius" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-top-right-radius"?>]" value="<?php echo $output[$set. "_border-top-right-radius"] ?>"/>
				            	</li>
				            	<li class="side_title"><span><?php _e('Top-Left:','tcard') ?></span>
				              		<input class="tcard-input border-top-left-radius" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-top-left-radius"?>]" value="<?php echo $output[$set. "_border-top-left-radius"] ?>"/>
				            	</li>
				            	<li class="side_title"><span><?php _e('Bottom-Right:','tcard') ?></span>
				              		<input class="tcard-input border-bottom-right-radius" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-bottom-right-radius"?>]" value="<?php echo $output[$set. "_border-bottom-right-radius"] ?>"/>
				            	</li>
				            	<li class="side_title"><span><?php _e('Bottom-Left:','tcard') ?></span>
				              		<input class="tcard-input border-bottom-left-radius" type="text" name="skin_set<?php echo $skin . "[" . $set."_border-bottom-left-radius"?>]" value="<?php echo $output[$set. "_border-bottom-left-radius"] ?>"/>
				            	</li>
				          	</ul>
				        </div>
			      	</div>
			    </div>
			<?php endif;
			
			    $bg_pos = array('center center','left top','left center','left bottom','right top','right center','right bottom','center top','center bottom');
			    $bg_size = array('auto','length','cover','contain','initial','inherit');
			    $bg_repeat = array('no-repeat','repeat','repeat-x','repeat-y','initial','inherit');
			    $bg_attachment = array('scroll','fixed','local','initial','inherit');
			    ?>
			    <div class="set_box">
			      	<div class="set_box_title">
			        	<?php _e('Background','tcard') ?>
			     	</div>
			      	<div class="set_box_inner">
			        	<div class="box_shadow_none with_margin">
			          		<?php _e('Image','tcard') ?> <h4 class="tcard-remove-image"><?php _e('Remove','tcard') ?></h4> 
			          		<input class="tcard-input tcard-image-input" type="hidden" name="skin_set<?php echo $skin . "[" . $set."_background-image"?>]" value="<?php echo $output[$set. "_background-image"] ?>"/>
			          		<h4 class="set_upload_bg"> <?php _e('Upload','tcard') ?></h4>
			        	</div>
			        	<?php if($skin_type == $pre_skin && $set == "tcard-front" ||
			        			$skin_type == $pre_skin && $set == "tcard-back") : ?>
			        	<div class="box_shadow_none with_margin">	
			        		<span><?php _e('Color:','tcard') ?></span>
			        		<?php $colors = array("air-force-blue","alizarin","alizarin-crimson","amaranth","amber","american-rose","android-green","awesome","azure","beige","black","blue","darkblue","ball-blue","bleu-de-france","blue-green","blue-purple","bright-green","canary-yellow","carmine","carolina-blue","cerulean","cerulean-blue","chrome-yellow","cinnabar","cool-black","cornflower-blue","dark-slate-gray","dark-gray","davy-grey","debian-red","deep-magenta","deep-pink","egyptian-blue","electric-yellow","electric-violet","jungle-green","lemon","lemon-lime","lava","lavender-blue","light-sea-green","light-slate-gray","majorelle-blue","medium-persian-blue","magenta","navy","orange","persian-red","prussian-blue","paris-green","rose-madder","royal-blue","saint-blue","sea-blue","screamin-green","shamrock-green","true-blue","teal","yellowgreen") ?>

							<select class="tcard-input" name="skin_set<?php echo $skin . "[" . $set."_background-color_class"?>]">
								<?php foreach ($colors as $col => $color) : ?>
									<option value="<?php echo $color ?>" <?php selected( $output[$set. "_background-color_class"], $color ); ?>><?php _e($color,'tcard') ?></option>
								<?php endforeach; ?>	
							</select>
						</div>	
			        	<?php elseif($skin_type !== $pre_skin) : ?>
			        		<div class="box_shadow_none with_margin with_margin_color">
			        			<?php _e('Color:','tcard') ?>
				          		<input class="tcard-input background-color tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_background-color"?>]" value="<?php echo $output[$set. "_background-color"] ?>"/>
				        	</div>										        	
			        	<?php endif; ?>	
				        <div class="box_shadow_none with_margin">
				         	<span><?php _e('Position:','tcard') ?></span>
				          	<select class="tcard-input background-position" name="skin_set<?php echo $skin . "[" . $set."_background-position"?>]">
				          		<option></option>
				   				<?php foreach ($bg_pos as $key => $pos) : ?>
				   					<option value="<?php echo esc_attr($pos) ?>" <?php selected( $output[$set."_background-position"], $pos); ?>><?php _e($pos,'tcard') ?></option>
				   				<?php endforeach; ?>	
				           	</select>
				        </div>
				        <div class="box_shadow_none with_margin">
				          	<span><?php _e('Size:','tcard') ?></span>
				          	<select class="tcard-input background-size" name="skin_set<?php echo $skin . "[" . $set."_background-size"?>]">
				          		<option></option>
				          		<?php foreach ($bg_size as $key => $size) : ?>
				   					<option value="<?php echo esc_attr($size) ?>" <?php selected( $output[$set."_background-size"], $size); ?>><?php _e($size,'tcard') ?></option>
				   				<?php endforeach; ?>
				           	</select>
				        </div>
				        <div class="box_shadow_none with_margin">
				          	<span><?php _e('Repeat:','tcard') ?></span>
				          	<select class="tcard-input background-repeat" name="skin_set<?php echo $skin . "[" . $set."_background-repeat"?>]">
				          		<option></option>
				          		<?php foreach ($bg_repeat as $key => $repeat) : ?>
				   					<option value="<?php echo esc_attr($repeat) ?>" <?php selected( $output[$set."_background-repeat"], $repeat); ?>><?php _e($repeat,'tcard') ?></option>
				   				<?php endforeach; ?>
				           	</select>
				        </div>
				        <div class="box_shadow_none with_margin">
				          	<span><?php _e('Attachment:','tcard') ?></span>
				          	<select class="tcard-input background-attachment" name="skin_set<?php echo $skin . "[" . $set."_background-attachment"?>]">
				          		<option></option>
					            <?php foreach ($bg_attachment as $key => $attachment) : ?>
				   					<option value="<?php echo esc_attr($attachment) ?>" <?php selected( $output[$set."_background-attachment"], $attachment); ?>><?php _e($attachment,'tcard') ?></option>
				   				<?php endforeach; ?>
				           	</select>
				        </div>
			      	</div>
			    </div>
			    <?php if($set == "tcard-front" || $set == "tcard-back") : ?>
					<div class="set_box font_set">
				      	<div class="set_box_title">
				        	<?php _e('Font','tcard') ?>
				      	</div>
				      	<div class="set_box_inner">
					        <ul class="mini_boxs_ul">
					          	<li class="font_color"><?php _e('Color:','tcard') ?>
						  			<input class="tcard-input font_color tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_color"?>]" value="<?php echo $output[$set."_color"] ?>">
					          	</li>
					          	<li class="font_color"><?php _e('Font family:','tcard') ?>
					          		<select class="tcard-input font_size" type="text" name="skin_set<?php echo $skin . "[" . $set."_font-family"?>]" value="<?php echo $output[$set."_font-family"] ?>">
					          			<option value="inherit"><?php _e('Theme default','tcard') ?></option>
					          			<option value="Lato,sans-serif"><?php _e('Lato(Tcard default)','tcard') ?></option>
					          		</select>
					          	</li>
					          	<li class="font_color"><?php _e('Font weight:','tcard') ?>
					          		<input class="tcard-input font_size" type="number" name="skin_set<?php echo $skin . "[" . $set."_font-weight"?>]" value="<?php echo $output[$set."_font-weight"] ?>">
					          	</li>
					        </ul>
				      	</div>
				    </div>
				<?php endif; ?>
			    <?php if($skin_type !== $pre_skin) : ?>
			    <div class="set_box">
			      	<div class="set_box_title">
			        	<?php _e('Overlay > Frostedglass','tcard') ?>
			      	</div>
			      	<div class="set_box_inner frostedglass">
				        <ul class="mini_boxs_ul">
				          	<li><p><?php _e('Frostedglass:','tcard') ?></p>
				            	<div class="tc-check-settings">
									<input class="tcard-input display_frostedglass" id="<?php echo $set.$skin."frostedglass" ?>" type="checkbox" <?php checked($output[$set."_frostedglass"], 1 ); ?> name="skin_set<?php echo $skin . "[" . $set."_frostedglass"?>]" value="1">
					  				<label for="<?php echo $set.$skin."frostedglass" ?>"></label>
								</div>
				          	</li>
				        <?php if($skin_type !== $pre_skin) : ?>  	
				          	<li class="frostedglass_color_li"><?php _e('Color:','tcard') ?>
					  			<input class="tcard-input frostedglass_bg_colorg tcard-color-picker" type="text" name="skin_set<?php echo $skin . "[" . $set."_frostedglass_bg_colorg"?>]" value="<?php echo $output[$set."_frostedglass_bg_colorg"] ?>">
					  			<input class="tcard-input frostedglass_bg_color" type="hidden" name="skin_set<?php echo $skin . "[" . $set."_frostedglass_bg_color"?>]" value="<?php echo $output[$set."_frostedglass_bg_color"] ?>">
				          	</li>
				          	<li><p><?php _e('Background image:','tcard') ?></p>
				            	<div class="tc-check-settings">
									<input class="tcard-input frostedglass_image_set" id="<?php echo $set.$skin."frostedglass_img" ?>" type="checkbox" <?php checked($output[$set."_frostedglass_img"], 1 ); ?> name="skin_set<?php echo $skin . "[" . $set."_frostedglass_img"?>]" value="1">
					  				<label for="<?php echo $set.$skin."frostedglass_img" ?>"></label>
								</div>
				          	</li>
				          	<li><p><?php _e('Blur:','tcard') ?></p>
					  			<input class="tcard-input frostedglass_blur" type="number" name="skin_set<?php echo $skin . "[" . $set."_frostedglass_blur"?>]" value="<?php echo $output[$set."_frostedglass_blur"] ?>">
				          	</li>
				          	<li><p><?php _e('Opacity:','tcard') ?></p>
				            	<input class="tcard-input frostedglass_opacity" type="text" name="skin_set<?php echo $skin . "[" . $set."_frostedglass_opa"?>]" value="<?php echo $output[$set."_frostedglass_opa"] ?>" />
				          	</li>
				        <?php endif; ?>  	
				        </ul>
			      	</div>
			    </div>
				<?php endif; 
				if($skin_type !== $pre_skin) : ?>
			    	<div class="set_box">
				      	<div class="set_box_title">
				        	<?php _e('Padding','tcard') ?>
				      	</div>
				      	<div class="set_box_inner">
				      		<ul class="mini_boxs_ul padding">
				            	<li><?php _e('Top','tcard') ?>
				              		<input class="tcard-input padding-top" type="number" name="skin_set<?php echo $skin . "[" . $set."_padding-top"?>]" value="<?php echo $output[$set. "_padding-top"] ?>"/>
				            	</li>
					            <li><?php _e('Right','tcard') ?>
					              	<input class="tcard-input padding-right" type="number" name="skin_set<?php echo $skin . "[" . $set."_padding-right"?>]" value="<?php echo $output[$set. "_padding-right"] ?>"/>
					            </li>
					            <li><?php _e('Bottom','tcard') ?>
					              	<input class="tcard-input padding-bottom" type="number" name="skin_set<?php echo $skin . "[" . $set."_padding-bottom"?>]" value="<?php echo $output[$set. "_padding-bottom"] ?>"/>
					            </li>
					            <li><?php _e('Left','tcard') ?>
					              	<input class="tcard-input padding-left" type="number" name="skin_set<?php echo $skin . "[" . $set."_padding-left"?>]" value="<?php echo $output[$set. "_padding-left"] ?>"/>
					            </li>
				          	</ul>
				      	</div>
				    </div>
				    <?php if($set_menu !== "tcard-front" && $set_menu !== "tcard-back") : ?>
			    	<div class="set_box">
				      	<div class="set_box_title">
				       		<?php _e('Margin','tcard') ?>
				      	</div>
				      	<div class="set_box_inner">
				        	<ul class="mini_boxs_ul padding">
				            	<li><?php _e('Top','tcard') ?>
				              		<input class="tcard-input margin-top" type="number" name="skin_set<?php echo $skin . "[" . $set."_margin-top"?>]" value="<?php echo $output[$set. "_margin-top"] ?>"/>
				            	</li>
					            <li><?php _e('Right','tcard') ?>
					              	<input class="tcard-input margin-right" type="number" name="skin_set<?php echo $skin . "[" . $set."_margin-right"?>]" value="<?php echo $output[$set. "_margin-right"] ?>"/>
					            </li>
					            <li><?php _e('Bottom','tcard') ?>
					              	<input class="tcard-input margin-bottom" type="number" name="skin_set<?php echo $skin . "[" . $set."_margin-bottom"?>]" value="<?php echo $output[$set. "_margin-bottom"] ?>"/>
					            </li>
					            <li><?php _e('Left','tcard') ?>
					              	<input class="tcard-input margin-left" type="number" name="skin_set<?php echo $skin . "[" . $set."_margin-left"?>]" value="<?php echo $output[$set. "_margin-left"] ?>"/>
					            </li>
				          	</ul>
				      	</div>
				    </div>
				    <?php endif; 
				endif;?>		
			</div>
		<?php endforeach; ?>
	</div>

<?php endforeach; ?>