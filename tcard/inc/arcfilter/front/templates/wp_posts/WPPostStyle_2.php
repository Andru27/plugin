<?php
/**
 * @since           	2.5.7
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/wp_posts
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<a href="<?php echo get_permalink($get_posts[$item]->ID); ?>">
	<div class="arc-post-item-over">
		<?php $cat_set[$item]['post_item'] = array('title','content','featured_image');

		foreach ($cat_set[$item]['post_item'] as $key => $post_col) : 
				(empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] = "" : $set_item[$item][$post_col];
				if($post_col == "title") :

					(!empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] : $set_item[$item][$post_col] = 3;

					if(!empty($set_item[$item][$post_col]) && $set_item[$item][$post_col] !== 0) : ?>
						<h3 class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
							<?php echo self::count_words(get_the_title($get_posts[$item]->ID),$set_item[$item][$post_col]); ?>
						</h3>
					<?php else:?>
						<h3 class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>"><?php echo get_the_title($get_posts[$item]->ID); ?></h3>
					<?php endif; ?>

				<?php elseif($post_col == "content") : ?>

					<div class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
						<?php (!empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] : $set_item[$item][$post_col] = 6;
						echo self::count_words($get_posts[$item]->post_content,$set_item[$item][$post_col]);?>
					</div>

			<?php endif;
		endforeach; ?>				
	</div>
	<?php if(in_array("featured_image", $cat_set[$item]['post_item'])) : ?>

			<?php if(!empty(get_the_post_thumbnail_url($get_posts[$item]->ID, 'large'))) : ?>
				<div class="arc-post-item arc-post-featured_image">
					<img src="<?php echo get_the_post_thumbnail_url($get_posts[$item]->ID, 'large'); ?>" />
				</div>
			<?php else: ?>
				<div class="arc-post-item arc-post-featured_image">
					<img src="<?php echo esc_url(ARCFILTER_ASSETS_URL . "img/no_img.png"); ?>" />
				</div>
			<?php endif; ?>	
		

 	<?php endif; ?>
</a>