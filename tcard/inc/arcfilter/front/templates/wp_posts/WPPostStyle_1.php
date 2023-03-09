<?php
/**
 * @since           	2.5.7
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/wp_posts
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

$cat_set[$item]['post_item'] = array('featured_image','title','date','content','post_button','author','comment_count','tags','show_category');

foreach ($cat_set[$item]['post_item'] as $key => $post_col) : 
	(empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] = "" : $set_item[$item][$post_col];
	if($post_col == "title") :

		if(!empty($set_item[$item][$post_col]) && $set_item[$item][$post_col] !== 0) : ?>
			<h3 class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
				<?php echo self::count_words(get_the_title($get_posts[$item]->ID),$set_item[$item][$post_col]); ?>
			</h3>
		<?php else:?>
			<h3 class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>"><?php echo get_the_title($get_posts[$item]->ID); ?></h3>
		<?php endif; ?>

	<?php elseif($post_col == "content") : ?>

		<div class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
			<?php (!empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] : $set_item[$item][$post_col] = 17;
			echo self::count_words($get_posts[$item]->post_content,$set_item[$item][$post_col]);?>
		</div>

	<?php elseif($post_col == "featured_image") :

		if(!empty(get_the_post_thumbnail_url($get_posts[$item]->ID, 'large'))) : ?>
			<div class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
				<img src="<?php echo get_the_post_thumbnail_url($get_posts[$item]->ID, 'large'); ?>" />
			</div>
		<?php endif;
		
	elseif($post_col == "post_button") :

		(empty($set_item[$item][$post_col])) ? $set_item[$item][$post_col] = __("Read More",'tcard') : $set_item[$item][$post_col];?>  

		<div class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
			<a href="<?php echo get_permalink($get_posts[$item]->ID); ?>"><?php echo esc_html($set_item[$item][$post_col]); ?></a>
		</div>

	<?php elseif($post_col == "date") : ?>

		<span class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
			<?php if($set_item[$item][$post_col] == 'date_post_text'){
				echo esc_html($cat_set[$item]['set_item'][$post_col."_text"]) . " " . get_the_date($set_settings['date_format'], $get_posts[$item]->ID );
			}elseif($set_item[$item][$post_col] == 'date_post_icon'){
				echo '<i class="fas fa-calendar-alt"></i>' . " " . get_the_date($set_settings['date_format'], $get_posts[$item]->ID );
			}else{
				echo get_the_date($set_settings['date_format'], $get_posts[$item]->ID );
			}?>
		</span>

	<?php endif;
endforeach;?>
<div class="arc-post-item-footer">

	<?php foreach ($cat_set[$item]['post_item'] as $key => $post_col) : 

		if($post_col == "show_category") : ?>

			<span class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
				<?php if($set_item[$item][$post_col] == 'show_category_post_text'){
					echo "<span>".esc_html($cat_set[$item]['set_item'][$post_col."_text"])."</span>" . " ";
					echo the_category( ', ' , '' , $get_posts[$item]->ID );
				}elseif($set_item[$item][$post_col] == 'show_category_post_icon'){
					echo '<i class="fas fa-folder-open"></i>' . " ";
					echo the_category( ', ' , '' , $get_posts[$item]->ID );
				}else{
					echo the_category( ', ' , '' , $get_posts[$item]->ID );
				}?>
			</span>

		<?php elseif($post_col == "author") : ?>

			<span class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
				<?php if($set_item[$item][$post_col] == 'author_post_text'){
					echo "<span>".esc_html($cat_set[$item]['set_item'][$post_col."_text"])."</span>" . " " . get_the_author_meta('display_name',$get_posts[$item]->post_author);
				}elseif($set_item[$item][$post_col] == 'author_post_icon'){
					echo '<i class="fas fa-user-tag"></i>' . " " . get_the_author_meta('display_name',$get_posts[$item]->post_author);
				}else{
					echo get_the_author_meta('display_name',$get_posts[$item]->post_author);
				}?>
			</span>

		<?php elseif($post_col == "tags") : 
			if(!empty($all_tags)) : ?>

				<span class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
					<?php if($set_item[$item][$post_col] == 'tags_post_text'){
						echo "<span>".esc_html($cat_set[$item]['set_item'][$post_col."_text"])."</span>" . " " . html_entity_decode($all_tags);
					}elseif($set_item[$item][$post_col] == 'tags_post_icon'){
						echo '<i class="fas fa-tags"></i>' . " " . $all_tags;
					}else{
						echo $all_tags;
					}?>
				</span>

			<?php endif;
		elseif($post_col == "comment_count") : ?>

			<span class="arc-post-item arc-post-<?php echo esc_attr($post_col); ?>">
				<?php if($set_item[$item][$post_col] == 'comment_count_post_text'){
					echo "<span>".esc_html($cat_set[$item]['set_item'][$post_col."_text"]) ."</span>" . " " . get_comments_number( $get_posts[$item]->ID );
				}elseif($set_item[$item][$post_col] == 'comment_count_post_icon'){
					echo '<i class="fas fa-comments"></i>' . " " . get_comments_number( $get_posts[$item]->ID );
				}else{
					echo get_comments_number( $get_posts[$item]->ID );
				}?>
			</span>

		<?php endif;
	endforeach;?>
</div>