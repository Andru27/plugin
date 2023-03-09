<?php
/**
 * @since           	2.0.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<div class="arcfilter-item <?php echo esc_attr($item_type) ?> arc-post-<?php echo esc_attr($item_id); ?> <?php echo esc_attr($cat_set[$item]['set_style'] . " " . $post_cols); ?> animated" data-categories="all <?php echo esc_attr($cat_set[$item]['cat_name']); ?>" data-number="<?php echo esc_attr($item) ?>" <?php echo esc_attr($data_count)?>>
	<div class="arcfilter-item-inner">
		
		<?php if($category_type == "post") :

			require ARCFILTER_FRONT_URL . "templates/wp_posts/WPPost".ucfirst($cat_set[$item]['set_style']).".php";

		else: 

			require ARCFILTER_FRONT_URL . "templates/wc_products/WCProduct".ucfirst($cat_set[$item]['set_style']).".php";

		endif;?>
	</div>
</div>	