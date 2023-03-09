<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

?>
<div class="wrap tcard">
	 <form accept-charset="UTF-8" action="<?php echo admin_url( 'admin-post.php'); ?>" method="post">
	 	<input type="hidden" name="action" value="tcard_update_group">
      <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">

	 	<?php wp_nonce_field( 'tcard_update_group' ); ?>

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

	 					<option value='?page=tcard&group_id=<?php echo $group['group_id'] ?>'<?php echo $selected; ?>><?php echo esc_html(stripslashes($group['title'])) ?></option>
	 				<?php endforeach; ?>

	 			</select>
	 			<div class="create-new-group"><?php _e( 'or', 'tcard' ) ?>
	 				<a style="margin-left: 5px" href="<?php echo wp_nonce_url(admin_url("admin-post.php?action=tcard_create_group"), "tcard_create_group") ?>"><?php _e( 'Create a new group', 'tcard' ) ?></a>
	 			</div>
	 		</div>
	 		<div class="header-btns">
	 			<span class="tcard-count-skin"><?php _e( 'Total skins:', 'tcard' ) ?><span><?php echo $group_skins_number ?></span></span>
	 			<div class="tc-header-icon tc-add-new-skin">
	 				<i class="fas fa-plus-square"></i>
	 				<input type="hidden" name="skins_number" value="<?php echo $group_skins_number ?>" />
	 			</div>
	 			<div class="tc-header-icon tcard-settings"><i class="fas fa-cog"></i></div>

	 			<?php $tcardElements->tcardSettings->settings(
	 				$group_id,
	 				'group',
	 				__( 'Group - ', 'tcard' ) . $group_title,
	 				'',
	 				$settings = array(
	 					'group_name' 			=> array(
	 						'input','checkbox',
	 						__( 'Group name', 'tcard' ),
	 						sprintf(
							    __( 'If you want to display %s name of this group %s set this option true', 'tcard' ),
							    "<br>","<br>"
							)
	 					),
	 					'tcardFlip' 			=> array(
	 						'input','checkbox',
	 						__( 'Turn off flip', 'tcard' ),
	 						__( 'Default: false', 'tcard' )
	 					),
	 					'tcardOn' => array(
	 						'select',array('button','hover'),
	 						__( 'Tcard on', 'tcard' ),
	 						__( 'Default: button', 'tcard' )
	 					),
	 					'animationFront' 		=> array(
	 						'select',array('ready','hover'),
	 						__( 'Animations front', 'tcard' ),
	 						__( 'Default: ready', 'tcard' )
	 					),
	 					'animationOneTime'		=> array(
	 						'input','checkbox',
	 						__( 'Animations once', 'tcard' ),
	 						__( 'Default: false', 'tcard' )
	 					),
	 					'randomColor'			=> array(
	 						'input','checkbox',
	 						__( 'Random color', 'tcard' ),
	 						__( 'Default: false', 'tcard' )
	 					),
	 					'durationCount'			=> array(
	 						'input','number',
	 						__( 'Count time', 'tcard' ),
	 						__( 'Default: 900', 'tcard' )
	 					),
	 					'individualGallery'		=> array(
	 						'input','checkbox',
	 						__( 'Individual gallery', 'tcard' ),
	 						__( 'Default: false', 'tcard' )
	 					),
	 					'autocomplete' 			=> array(
	 						'input','checkbox',
	 						__( 'Autocomplete', 'tcard' ),
	 						__( 'Default: off', 'tcard' )
	 					),
	 					'container_group' 		=> array(
	 						'select',array('fixed','fluid'),
	 						__( 'Container', 'tcard' ),
	 						__( 'Default: fixed', 'tcard' )
	 					),
	 					'widget_group' 			=> array(
	 						'input','checkbox',
	 						__( 'Widget group', 'tcard' ),
	 						__( 'Default: false', 'tcard' )
	 					),			
	 				),
	 				$get_skin_type
	 			);?>
	 			<?php if(!empty($group_id)) : ?>
		 			<a class="tc-header-icon delete-tcard-group" href="<?php echo wp_nonce_url(admin_url("admin-post.php?action=tcard_delete_group&get_group_id={$group_id}"), "tcard_delete_group") ?>"><i class="fas fa-trash-alt"></i></a>
		 		<?php endif; ?>
		 		<a class="tc-header-icon tcard-doc" href="https://addudev.com/work/tcard/documentation/" target="_blank"><i class="fas fa-book"></i></a>
		 		<a class="tc-header-icon tcard-logo" href="https://addudev.com/work/tcard" target="_blank"><img src="<?php echo TCARD_BASE_URL . 'admin/images/logo.png' ?>"/></a>
	 		</div>
	 	</div>

	 	<div class="tcard-sidebar">
	 		<div class="tcard-sidebar-head">
	 			<?php if(!empty($group_id)) : ?>
	 				<button class='alignleft button button-primary' type='submit' name='save' id='tcard-save'>Save</button>
	 				<span class="spinner"></span>
	 			<?php endif; ?>
	 		</div>
	 		<?php if(!empty($groups)) : ?>
		 		<div class="tcard-sidebar-item group-settings">
		 			<h4><?php _e( 'Set group name:', 'tcard' ) ?></h4>
		 			<input type="text" class="tcard-group-title tcard-input" name="tcard_group_name" value="<?php echo esc_html(stripslashes($group_title)); ?>">
		 		</div>
		 		<div class="tcard-sidebar-item group-settings">
		 			<h4><?php _e( 'Select Skin:', 'tcard' ) ?></h4>
		 			<select id="select-skin" name="tcard_skin_type">
		 				<option></option>
						<?php for($i = 1; $i <= 6; $i++) : ?>
							<option value="skin_<?php echo $i ?>" <?php selected( $get_skin_type, "skin_$i" ); ?>> Skin <?php echo $i ?> </option>
						<?php endfor; ?>
						<option value="customSkin" <?php selected( $get_skin_type, 'customSkin' ); ?>>Custom Skin</option>
					</select>
		 		</div>
	 		<?php endif; ?>
	 		<?php if($skin_name === "customSkin") : ?>
		 		<div class="tcard-sidebar-item elements-menu">
		 			<h4 class="tc-current-side" data-tcard-menu="tcard-header"><?php _e( 'Header', 'tcard' ) ?></h4>
		 			<h4 data-tcard-menu="tcard-content"><?php _e( 'Content', 'tcard' ) ?></h4>
		 			<h4 data-tcard-menu="tcard-footer"><?php _e( 'Footer', 'tcard' ) ?></h4>
		 			<h4 data-tcard-menu="tcard-social"><?php _e( 'Social', 'tcard' ) ?></h4>
		 		</div>
		 		<div class="tcard-sidebar-item elements">
		 			<?php echo $header_elements . $content_elements . $footer_elements; ?>
		 			<div class="tcard-item-inner" data-tcard-box="tcard-social">
						<div class="tcard-bar-element new-element tcard-social" data-element="twitter_profile">
							<?php _e( 'Twitter Profile', 'tcard' ) ?>
						</div>
						<div class="tcard-bar-element new-element tcard-social" data-element="twitter_feed">
							<?php _e( 'Twitter feed', 'tcard' ) ?>
						</div>
					</div>	
		 		</div>
	 		<?php elseif($get_skin_type == "skin_5") : ?>
	 			<div class="skin_5 tcard-sidebar-item group-settings">	
		 			<h4><?php _e( 'Select category:', 'tcard' ) ?></h4>	
		 			<select name="group_set[category_name]">
						<?php foreach ($categories as $key => $category) : 
							(!empty($group_settings['category_name'])) ? $group_settings['category_name'] : $group_settings['category_name'] = "";?>
							<option value="<?php echo $category->name ?>" <?php selected( $group_settings['category_name'], $category->name ); ?> ><?php echo $category->name; ?></option>
						<?php endforeach; ?>

					</select>
				</div>
				<div class="skin_5 tcard-sidebar-item group-settings">	
		 			<h4><?php _e( 'Order by:', 'tcard' ) ?></h4>	
		 			<select name="group_set[orderby_category]">
		 				<?php (!empty($group_settings['orderby_category'])) ? $group_settings['orderby_category'] : $group_settings['orderby_category'] = "";?>
						<option value="author" <?php selected( $group_settings['orderby_category'], 'author' ); ?>>author</option>
						<option value="title" <?php selected( $group_settings['orderby_category'], 'title' ); ?>>title</option>
						<option value="date" <?php selected( $group_settings['orderby_category'], 'date' ); ?>>date</option>
						<option value="modified" <?php selected( $group_settings['orderby_category'], 'modified' ); ?>>modified</option>
						<option value="rand" <?php selected( $group_settings['orderby_category'], 'rand' ); ?>>rand</option>
					</select>
				</div>
				<div class="skin_5 tcard-sidebar-item group-settings last-child">	
		 			<h4><?php _e( 'Order:', 'tcard' ) ?></h4>	
		 			<select name="group_set[order_category]">
		 				<?php (!empty($group_settings['order_category'])) ? $group_settings['order_category'] : $group_settings['order_category'] = "";?>
						<option value="DESC" <?php selected( $group_settings['order_category'], 'DESC' ); ?>>DESC</option>
						<option value="ASC" <?php selected( $group_settings['order_category'], 'ASC' ); ?>>ASC</option>
					</select>
				</div>
 			<?php endif; ?>
 			<div class="tcard-sidebar-item bootstrap">
				<h4><?php _e( 'Bootstrap:', 'tcard' ) ?></h4>
				<select class="tcard-bootstrap-version" name="tcard_bootstrap_version">
					<option></option>
					<option value="bootstrap4" <?php selected( get_option( 'tcard_bootstrap_version' ), 'bootstrap4' ); ?>>v4+</option>
					<option value="bootstrap3" <?php selected( get_option( 'tcard_bootstrap_version' ), 'bootstrap3' ); ?>>v3+</option>
				</select>
				<div class="bootstrap-info-btn"><i class="fas fa-info-circle"></i></div>
				<div class="bootstrap-info">
					<p style="font-weight: 500;"><?php _e( ' - This option will be applied for all tcard groups', 'tcard' ) ?></p>
					<p><?php _e( ' - If you already have installed one of this bootstrap version just let empty select area', 'tcard' ) ?></p>
				</div>
	 		</div>
	 		<div class="tcard-sidebar-item tcard-sidebar-info">
	 			<h3><?php _e( 'How to use', 'tcard' ) ?></h3>
	 			<p><?php _e( 'To display your tcard group, add the following shortcode (violet) to your page. If adding the tcard group to your theme files, additionally include the surrounding PHP function (magenta).', 'tcard' ) ?></p>
	 			<?php (!empty($group_id)) ? $code_group_id = $group_id : $code_group_id = ""; ?>
	 			<pre id="tcard-code">&lt;?php echo do_shortcode(<br>'<span class="tcard-shortcode">[tcard group_id="<?php echo $code_group_id; ?>"]</span>'<br>); ?&gt;</pre>
	 			<div class="copy-shortcode"><?php _e( 'Copy all', 'tcard' ) ?></div>
	 		</div>
	 	</div>
	 	<div class="tcard-container-skins <?php echo $skin_name; ?>">
	 		<?php if(!empty($group_output->skin_type)) $tcardSkinsController->skinType($group_id,TCARD_ADMIN_URL); ?>
	 	</div>
	 </form>
</div>