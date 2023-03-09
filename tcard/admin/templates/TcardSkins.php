<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');
(!empty($addHeight[$skin])) ? $addHeight[$skin] : $addHeight[$skin] = "";
?>
<div class="tcard-row <?php echo $closed. " " .$addHeight[$skin] ?>">
	<div class="tcard-row-bar">
		<span><?php echo $countSkin; ?>.<span class="tcard-skin-order"><?php echo $skin + 1; ?> </span> 
		<?php if($skin_type !== "skin_5") : ?>
		<span class="tcard-arrow">
		  	<input class="tcard_reorder tcard_check" type="checkbox" name="tcard_check_order<?php echo $skin; ?>" value="1" <?php checked( $checkClosed, 1 , true ); ?>>
				<label></label>
		</span>
		<span class="skin-cloned-after"></span>
		<?php endif; ?>
	</span>
	<div class="tcard-row-bar-btns">
		<?php if($skin_type !== $pre_skin) : ?>
			<span class="tcard-clone-skin"><i class="fas fa-clone"></i></span>
		<?php endif; ?>		
		<span class="tcard-settings"><i class="fas fa-cog"></i></span>
		<?php $elementsController->tcardSettings->settings(
	 				$group_id,
	 				'skin',
	 				$skin_type. "." . ($skin + 1),
	 				$skin,
	 				$settings = array(
	 					'main' => array(
	 						'main_animation'		=> array('select',array(
	 							'flip-y to-left',
	 							'flip-y to-right',
	 						    'flip-x to-top',
	 						    'flip-x to-bottom',
	 						    'rotate-y to-left',
	 						    'rotate-y to-right',
								'rotate-x to-top',
								'rotate-x to-bottom',
	 						),'Main animation',''),
	 						'cubicbezier'			=> array(
	 							'input','checkbox',
	 							__( 'Cubicbezier' , 'tcard' ),
	 							__( 'Default: false' , 'tcard' )
	 						),
	 						'frostedglass_main'		=> array(
	 							'input','checkbox',
	 							__( 'Frostedglass' , 'tcard' ),
	 							__( 'Default: false' , 'tcard' )
	 						),
	 						'viewIn'				=> array(
	 							'select','viewIn',
	 							__( 'Viewport In' , 'tcard' ),
	 							sprintf(
								    __( 'Default: false %s if is empty', 'tcard' ),
								    "<br>"
								)
	 						),
	 						'viewOut'				=> array(
	 							'select','viewOut',
	 							__( 'Viewport Out' , 'tcard' ),
	 							sprintf(
								    __( 'Default: false %s if Viewport In is empty', 'tcard' ),
								    "<br>"
								)
	 						),
		 					'setOffsetView'			=> array(
		 						'input','number',
		 						__( 'Set viewIn' , 'tcard' ),
		 						sprintf(
								    __( 'Default: %s', 'tcard' ),
								    "200px"
								)
		 					),
		 					'widget_skin'			=> array(
	 							'input','checkbox',
	 							__( 'Widget Skin' , 'tcard' ),
	 							__( 'Default: false' , 'tcard' )
	 						),
	 						'max_width'				=> array(
	 							'input','text',
	 							__( 'Max Width' , 'tcard' ),
	 							__( 'Default: 280px', 'tcard' )
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
	 					'style'		=> array(
							'tcard-front' => array('tcard-front','tcard-header','tcard-content','tcard-footer'),
							'tcard-back'  => array('tcard-back','tcard-header','tcard-content','tcard-footer')
	 					),
	 					'social' => array(
	 						'twitter_username'				=> array(
	 							'input','text',
	 							__( 'Twitter username' , 'tcard' ),
	 							__( 'Username without @ character' , 'tcard' )
	 						),
							'twitter_token'				=> array(
	 							'input','text',
	 							__( 'Twitter access token' , 'tcard' )
	 						),
	 						'twitter_stoken'			=> array(
	 							'input','text',
	 							__( 'Twitter access token secret' , 'tcard' )
	 						),
	 						'twitter_key'				=> array(
	 							'input','text',
	 							__( 'Twitter consumer key' , 'tcard' )
	 						),
	 						'twitter_csecret'			=> array(
	 							'input','text',
	 							__( 'Twitter consumer secret' , 'tcard' )
	 						),	
	 					)
	 				),
	 				$skin_type
	 			);?>
		<span class="tcard-delete-skin"><i class="fas fa-trash-alt"></i></span>
	</div>
	</div>
	<div class="tcard-skin">
		<input type="hidden" class="tcard_skin_id" name="skin_id[]" value="<?php echo $get_skins[$skin]->skin_id ?>">
		<?php if(!empty($headerElements)) : ?>
			<div class="tcard-item tcard-header" data-item="tcard-header">
				<div class="tcard-item-bar"><span class="tcard-item-title">Header</span> 
					<?php if($skin_type !== $pre_skin) : ?>
						<span class="tcard-delete-item"><i class="fas fa-trash-alt"></i></span>
					<?php endif; ?>
				</div>

				<?php if(!empty($headerElements['front'])) : ?>
					<div class="tcard-main-elem front-side" data-side="front">
						<div class="tcard-item-bar">Front Side</div>
						<div class="tcard-item-elements">
							<?php $elementsController->tcardHeader->show_element( $skin,'front',$headerElements['front'],$type_action,$skinCloned ) ?>	
						</div>
					</div>
				<?php endif; ?>

				<?php if(!empty($headerElements['back'])) : ?>
					<div class="tcard-main-elem back-side" data-side="back">
						<div class="tcard-item-bar">Back Side</div>
						<div class="tcard-item-elements">
							<?php $elementsController->tcardHeader->show_element( $skin,'back',$headerElements['back'],$type_action,$skinCloned ) ?>	
						</div>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php if(!empty($contentElements)) : ?>
			<div class="tcard-item tcard-content" data-item="tcard-content">
				<div class="tcard-item-bar"><span class="tcard-item-title">Content</span> 
					<?php if($skin_type !== $pre_skin) : ?>
						<span class="tcard-delete-item"><i class="fas fa-trash-alt"></i></span>
					<?php endif; ?>
				</div>

				<?php if(!empty($contentElements['front'])) : ?>
					<div class="tcard-main-elem front-side" data-side="front">
						<div class="tcard-item-bar">Front Side</div>
						<div class="tcard-item-elements">
							<?php echo $elementsController->tcardContent->show_element( $skin,'front', $contentElements['front'],$type_action,$skinCloned ) ?>	
						</div>
					</div>
				<?php endif; ?>

				<?php if(!empty($contentElements['back'])) : ?>
					<div class="tcard-main-elem back-side" data-side="back">
						<div class="tcard-item-bar">Back Side</div>
						<div class="tcard-item-elements">
							<?php $elementsController->tcardContent->show_element( $skin,'back', $contentElements['back'],$type_action,$skinCloned ) ?>	
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if(!empty($footerElements)) : ?>
			<div class="tcard-item tcard-footer" data-item="tcard-footer">
				<div class="tcard-item-bar"><span class="tcard-item-title">Footer</span> 
					<?php if($skin_type !== $pre_skin) : ?>
						<span class="tcard-delete-item"><i class="fas fa-trash-alt"></i></span>
					<?php endif; ?>
				</div>

				<?php if(!empty($footerElements['front'])) : ?>
					<div class="tcard-main-elem front-side" data-side="front">
						<div class="tcard-item-bar">Front Side</div>
						<div class="tcard-item-elements">
							<?php $elementsController->tcardFooter->show_element( $skin,'front',$footerElements['front'],$type_action,$skinCloned ) ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if(!empty($footerElements['back'])) : ?>
					<div class="tcard-main-elem back-side" data-side="back">
						<div class="tcard-item-bar">Back Side</div>
						<div class="tcard-item-elements">
							<?php $elementsController->tcardFooter->show_element( $skin,'back',$footerElements['back'],$type_action,$skinCloned ) ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; 
		if($skin_type !== "skin_5") :

		?>
		<div class="tcard-item tcard-gallery">
			<div class="tcard-item-bar tcard-gallery-bar">
				<span class="tcard-item-title"><?php _e( 'Gallery:' , 'tcard' ) ?></span>
				<span class="assigns-tcard-gallery">
					<?php _e( 'Assigns to' , 'tcard' ) ?>
					<select name="tcg_gallery<?php echo $skin ?>[user]">
						<option></option>
							<?php (!empty($gallery['user'])) ? $gallery_user = $gallery['user']  : $gallery_user = 0; 
							foreach ($users as $key => $user) : ?>
								<option value="<?php echo $user->ID ?>" <?php selected( $gallery_user, $user->ID ); ?> ><?php echo $user->user_login; ?></option>
							<?php endforeach;?>
					</select>
				</span>
				<span class="thumbnail-name">
					<span class="tcard-item-title" style="margin-left: 10px"><?php _e( 'Thumbnail title:' , 'tcard' ) ?></span>
					<select name="tcg_gallery<?php echo $skin ?>[thumbnail]">
						<option></option>
						<?php (!empty($gallery['thumbnail'])) ? $gallery_thumbnail = $gallery['thumbnail']  : $gallery_thumbnail = "";  ?>
						<option value="user_name" <?php selected( $gallery_thumbnail, "user_name" ); ?> >User name</option>
						<option value="thumbnail_title" <?php selected( $gallery_thumbnail, "thumbnail_title" ); ?> >Text</option>
					</select>
					<?php if(!empty($gallery['thumbnail']) && $gallery['thumbnail'] == "thumbnail_title") : ?>
					<input class="thumbnail_title" type="text" name="tcg_gallery<?php echo $skin ?>[thumbnail_title]" value="<?php echo $gallery['thumbnail_title'] ?>">
					<?php endif; ?>
				</span>
				<?php if(empty($gallery['user'])) : ?>
					<span class="tc-multiple-images"><i class="fas fa-cloud-upload-alt"></i></i></span>
				<?php endif; ?>
			</div>
			<div class="gallery">
				<?php if(!empty($gallery['image'])) :
				
					foreach ($gallery['image'] as $key => $image) : ?>
						<div class="tcg-box" style="background-image: url(<?php echo esc_url($image); ?>)">
							<input type="hidden" name="tcg_gallery<?php echo $skin ?>[image][]" value='<?php echo esc_url($image); ?>'>
							<div class="remove-tcg-img"></div>
						</div>
					<?php endforeach; 
					
				endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>