<?php
/**
 * @since           	2.6.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/wc_products
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

foreach ($cat_set[$item]['post_item'] as $key => $post_item) :

	if($post_item == "group") : ?>
		<div class="arc-post-item arc-post-featured_image">

			<a class="arc-post-product-url" href="<?php echo esc_url($product_url) ?>">

				<span class="arc-product_main_img <?php echo esc_attr($arc_product_hover_img[$item]); ?>">
					<?php echo $product_img; ?>
				</span>

				<?php if($set_item[$item]['group'] == 1 && !empty($shop_catalog_image_url[$item])) : ?>
					<img class="arc-post-img-product" src="<?php echo esc_url($shop_catalog_image_url[$item]); ?>">
				<?php endif; ?>
			</a>

			<?php if(!empty($best_seller[$item_id]) && $best_seller[$item_id] == 1) : ?>

				<span class="arc-post-item arc-post-is_on_sale arc-post-best_seller">
					<span><?php _e('best seller','tcard') ?></span>
				</span>
			
			<?php endif;

			if($product->is_on_sale() && $product->get_stock_status() == "instock" && $product->is_featured() == 0) : ?>
			
				<span class="arc-post-item arc-post-is_on_sale <?php echo esc_attr($set_bottom_class[$item]); ?>">
					<span><?php _e('Sale!','tcard') ?></span>
				</span>

			<?php endif;

			if($product->get_stock_status() == "outofstock") : ?>

				<span class="arc-post-item arc-post-is_on_sale out_of_stock <?php echo esc_attr($set_bottom_class[$item]); ?>">
					<span><?php _e('Out of stock','tcard') ?></span>
				</span>

			<?php endif;

			if($product->is_featured() == 1 && $product->get_stock_status() == "instock") : ?>

				<span class="arc-post-item arc-post-is_on_sale arc-post-is_featured <?php echo esc_attr($set_bottom_class[$item]); ?>">
					<span><?php _e('featured','tcard') ?></span>
				</span>
				
			<?php endif; ?>

		</div>

	<?php elseif($post_item == "image") : ?>

		<div class="arc-post-item arc-post-featured_image">

			<a class="arc-post-product-url" href="<?php echo esc_url($product_url) ?>">

				<span class="arc-product_main_img <?php echo esc_attr($arc_product_hover_img[$item]); ?>">
					<?php echo $product_img; ?>
				</span>

				<?php if(!empty($set_item[$item]['image']) && $set_item[$item]['image'] == 1 && !empty($shop_catalog_image_url[$item])) : ?>
					<img class="arc-post-img-product" src="<?php echo esc_url($shop_catalog_image_url[$item]); ?>">
				<?php endif; ?>
			</a>
			
		</div>

	<?php elseif($post_item == "name") :

		if(!empty($set_item[$item]['name']) && $set_item[$item]['name'] !== 0) : ?>
			<h3 class="arc-post-item arc-post-title">
				<?php echo self::count_words(esc_html($product->get_name()),$set_item[$item]['name']); ?>
			</h3>
		<?php else:?>
			<h3 class="arc-post-item arc-post-title"><?php echo esc_html($product->get_name()); ?></h3>
		<?php endif; 	

	elseif($post_item == "is_on_sale") :

		if($product->is_on_sale() && $product->get_stock_status() == "instock" && $product->is_featured() == 0) : ?>
		
			<span class="arc-post-item arc-post-is_on_sale <?php echo esc_attr($set_bottom_class[$item]); ?>">
				<span><?php _e('Sale!','tcard') ?></span>
			</span>

		<?php endif;

	elseif($post_item == "out_of_stock") :

		if($product->get_stock_status() == "outofstock") : ?>

			<span class="arc-post-item arc-post-is_on_sale out_of_stock <?php echo esc_attr($set_bottom_class[$item]); ?>">
				<span><?php _e('Out of stock','tcard') ?></span>
			</span>

		<?php endif;

	elseif($post_item == "featured") :

		if($product->is_featured() == 1 && $product->get_stock_status() == "instock") : ?>

			<span class="arc-post-item arc-post-is_on_sale arc-post-is_featured <?php echo esc_attr($set_bottom_class[$item]); ?>">
				<span><?php _e('featured','tcard') ?></span>
			</span>
			
		<?php endif;

	elseif($post_item == "price") :?>

		<span class="arc-post-item arc-post-regular_price <?php echo esc_attr($cut_price[$item]) ?>"><?php echo wc_format_decimal( $product->get_regular_price(), 2 ).$currency_symbol ?></span>

		<?php if($product->is_on_sale()) : ?>

			<span class="arc-post-item arc-post-sale_price"><?php echo wc_format_decimal( $product->get_sale_price(), 2 ).$currency_symbol; ?></span>

		<?php endif;

	elseif($post_item == "short_description") : ?>

		<div class="arc-post-item arc-post-content">
			<?php (!empty($set_item[$item]['short_description'])) ? $set_item[$item]['short_description'] : $set_item[$item]['short_description'] = 17;
			echo self::count_words($product->get_short_description(),$set_item[$item]['short_description']);?>
		</div>

	<?php elseif($post_item == "total_sales" || $post_item == "tax_status" || $post_item == "tax_class" || $post_item == "stock_quantity" || 
		$post_item == "weight" || $post_item == "dimensions" || $post_item == "shipping_class") :

		echo self::get_product_methods($product,$post_item,$set_item[$item][$post_item]);

	elseif($post_item == "rating") :

		echo self::product_rating($product);

	elseif($post_item == "add_to_cart") :

		echo self::add_to_cart($product,$pageurl,$loader_add_cart);

	elseif($post_item == "categories") :

		echo self::get_product_cat($item_id,', ',$set_item[$item][$post_item]); 

	elseif($post_item == "tags") :	

		echo self::get_product_tags($item_id,', ',$set_item[$item][$post_item]);

	endif;
	
	if(!in_array("group", $cat_set[$item]['post_item'])) :
	
		if(!empty($best_seller[$item_id]) && $best_seller[$item_id] == 1) : ?>

			<span class="arc-post-item arc-post-is_on_sale arc-post-best_seller">
				<span><?php _e('best seller','tcard') ?></span>
			</span>
			
		<?php endif;	
		
	endif;
endforeach;	