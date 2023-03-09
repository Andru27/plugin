<?php
/**
 * @since           2.0.5
 * @package         Tcard
 * @subpackage  	Arcfilter/admin/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');?>	
<div class="category_box">
	<div class="category_header">
		<?php _e('Category Name:','tcard') ?>
		<input class="tcard-input" type="text" name="categories[set][category_name][<?php echo esc_attr($category); ?>]" value="<?php echo esc_html(stripslashes($output['category_name']));?>">
		<input class="tcard-input" type="hidden" name="categories[set][category_slug][<?php echo esc_attr($category); ?>]" value="<?php echo esc_html(stripslashes($output['category_slug']));?>">
		<input class="tcard-input" type="hidden" name="categories[set][category_type][<?php echo esc_attr($category); ?>]" value="<?php echo esc_html($output['category_type']);?>">
		<input class="tcard-input" type="hidden" name="categories[set][category_id][<?php echo esc_attr($category); ?>]" value="<?php echo esc_attr($output['category_id']);?>">
		<input class="tcard-input" type="hidden" name="categories[set][category_items][<?php echo esc_attr( $category); ?>]" value="<?php echo esc_attr($output['category_items']);?>">
	</div>
	<span class="arc-delete-category"><i class="fas fa-trash-alt"></i></span>
</div>