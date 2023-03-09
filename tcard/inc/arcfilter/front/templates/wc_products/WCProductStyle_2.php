<?php
/**
 * @since           	2.6.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/templates/wc_products
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<div class="arc-post-item arc-post-featured_image">

	<a class="arc-post-product-url" href="<?php echo esc_url($product_url) ?>">

		<span class="arc-product_main_img <?php echo esc_attr($arc_product_hover_img[$item]); ?>">
			<?php echo $product_img; ?>
		</span>

		<?php if(!empty($set_item[$item]['group']) && $set_item[$item]['group'] == 1 && !empty($shop_catalog_image_url[$item])) : ?>
			<img class="arc-post-img-product" src="<?php echo esc_url($shop_catalog_image_url[$item]); ?>">
		<?php endif; ?>
	</a> 	

	<?php if(!empty($best_seller[$item_id]) && $best_seller[$item_id] == 1) : ?>

		<span class="arc-post-item arc-post-is_on_sale arc-post-best_seller">
			<span><?php _e('best seller','tcard') ?></span>
		</span>
		
	<?php endif;

	if(!empty($best_seller[$item_id]) && $best_seller[$item_id] == 1){
		$set_bottom_class[$item] = "set_bottom_class";
	}else{
		$set_bottom_class[$item] = "";
	}

	if($product->is_on_sale() && $product->get_stock_status() == "instock" && $product->is_featured() == 0) : ?>
	
		<span class="arc-post-item arc-post-is_on_sale <?php echo esc_attr($set_bottom_class[$item]); ?>">
			<span><?php _e('Sale!','tcard') ?></span>
		</span>

	<?php endif;

	if($product->get_stock_status() == "outofstock") : ?>

		<span class="arc-post-item arc-post-is_on_sale out_of_stock <?php echo esc_attr($set_bottom_class[$item]); ?>">
			<span>
				<?php if(empty($set_bottom_class[$item])){
					$br = "<br>";
				}else{
					$br = "";
				}
				echo sprintf(__( 'Out %s of stock', 'tcard' ),$br);?>	
			</span>
		</span>

	<?php endif;

	if($product->is_featured() == 1 && $product->get_stock_status() == "instock") : ?>

		<span class="arc-post-item arc-post-is_on_sale arc-post-is_featured <?php echo esc_attr($set_bottom_class[$item]); ?>">
			<span><?php _e('featured','tcard') ?></span>
		</span>
		
	<?php endif; ?>

</div>

<?php if(!empty($set_item[$item]['name']) && $set_item[$item]['name'] !== 0) : ?>
	<h3 class="arc-post-item arc-post-title">
		<?php echo self::count_words(esc_html($product->get_name()),$set_item[$item]['name']); ?>
	</h3>
<?php else:?>
	<h3 class="arc-post-item arc-post-title"><?php echo esc_html($product->get_name()); ?></h3>
<?php endif;

echo self::product_rating($product);?>

<span class="arc-post-item arc-post-regular_price <?php echo esc_attr($cut_price[$item]) ?>"><?php echo wc_price($product->get_regular_price()); ?></span>

<?php if($product->is_on_sale()) : ?>

	<span class="arc-post-item arc-post-sale_price"><?php echo wc_price($product->get_sale_price()); ?></span>

<?php endif;

echo self::add_to_cart($product,$pageurl,$loader_add_cart); ?>