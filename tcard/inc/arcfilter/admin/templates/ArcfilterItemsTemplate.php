
<?php
/**
 * @since           2.0.5
 * @package         Tcard
 * @subpackage  	Arcfilter/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<div class="arcfilter-row">
	<div class="arc_bar_cat">

		<span>
			<?php printf(
		    __( 'Items: %s', 'tcard' ),
		    html_entity_decode(stripslashes($output['category_name']))
		);?>
		</span>
		<?php if($category_type !== "tcard") :
	
			(!empty($output_items['set_style'])) ? $output_items['set_style'] : $output_items['set_style'] = "";?>
			<select name="cat_items<?php echo $category ?>[set_style]" class="select_style_items tcard-input">
				<option value="style_1" <?php selected($output_items['set_style'],'style_1'); ?> >Style 1</option>
				<option value="style_2" <?php selected($output_items['set_style'],'style_2'); ?> >Style 2</option>
				<option value="style_3" <?php selected($output_items['set_style'],'style_3'); ?> >Style 3</option>
				<option value="style_4" <?php selected($output_items['set_style'],'style_4'); ?> >Style 4</option>
				<option value="custom" <?php selected($output_items['set_style'],'custom'); ?> >Custom</option>
			</select>

			<div class="tcard-settings arcfilter-items-set"><i class="fas fa-cog"></i></div>
			<?php $ArcfilterController->settings->settings(
	 				$group_id,
	 				'items',
	 				__( 'Category - ', 'tcard' ) . $output['category_name'],
	 				$category,
	 				$output_items,
	 				$category_type
	 			);?>
		<?php endif; ?>
	</div>
</div>