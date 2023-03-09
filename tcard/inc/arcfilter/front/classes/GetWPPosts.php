<?php
/**
 * @since           	2.5.5
 * @package         	Tcard
 * @subpackage  		Arcfilter/front/classes
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class GetWPPosts 
{
	public static function get_all_posts($category_type,$set_settings,$categories,$arcfilter,$start,$stop,$params,$category_items,$all_items_arc){

		$get_posts = array();

		$category_active 	= $params['category_active'];
		(!empty($params['pageurl'])) ? $pageurl = $params['pageurl'] : $pageurl = null;

		if($category_type == "post"){
			$post_args = array(
				'posts_per_page'   => -1,
				'category__in'     => $categories['set']['category_id'],
				'orderby'          => "date",
				'order'            => "ASC",
				'post_type'        => 'post',
				'post_status'      => 'publish',
			);

			$get_posts = get_posts( $post_args );
		}elseif($category_type == "woocommerce" && self::isWooCommerce()){


			if(!empty($params['min_price'])){
				$min_price = $params['min_price'];

			}elseif(!empty($_REQUEST['min_price'])){
				$min_price = $_REQUEST['min_price'];
			}else{
				$min_price = null;
			}

			if(!empty($params['max_price'])){
				$max_price = $params['max_price'];

			}elseif(!empty($_REQUEST['max_price'])){
				$max_price = $_REQUEST['max_price'];
			}else{
				$max_price = null;
			}

			$price = wc_get_min_max_price_meta_query(
				array( 
     				'min_price' => $min_price,
            		'max_price' => $max_price,
            	)
			);

			if(!empty($params['tags'])){
				foreach ($params['tags'] as $key => $tags) {
					$all_selected_tags[] = sanitize_text_field($tags);
				}
			}elseif(!empty($_REQUEST['tags'])){
				$all_selected_tags = explode(" ", $_REQUEST['tags']);
			}

			if(!empty($all_selected_tags)){
				$selected_tags = array(
			      'taxonomy' => 'product_tag',
			      'field' => 'slug',
			      'terms' => $all_selected_tags
			    );
			}else{
				$selected_tags = "";
			}

			if(!empty($params['attributes'])){
				foreach ($params['attributes'] as $attr_name => $value) {
					$all_attributes['pa_'.$attr_name] = $params['attributes'][$attr_name];
				}
			}else{
				if(!empty($set_settings['wc_sidebar_attribute']['name'])){
					foreach ($set_settings['wc_sidebar_attribute']['name'] as $key => $attr_name) {
						if(!empty($_REQUEST[$attr_name]))
						$all_attributes['pa_'.$attr_name] = explode(" ", $_REQUEST[$attr_name]);
					}
				}
			}

			if(!empty($all_attributes)){
				foreach ($all_attributes as $key => $value) {
					$set_attr[] = array(
				      'taxonomy' => $key,
				      'field' => 'slug',
				      'terms' => $value
				    );
				}
			}else{
				$set_attr = "";
			}

			$products_args = array(
				'posts_per_page'   	=> -1,
				'orderby'          	=> "date",
				'order'            	=> "ASC",
				'post_type'        	=> 'product',
				'post_status'     	=> 'publish',
				'meta_query' 		=> array($price),
				'tax_query' 		=> array( 
				    array(
				      'taxonomy' => 'product_cat',
				      'field' => 'id',
				      'terms' => $categories['set']['category_id']
				    ),
				    $selected_tags,
				    $set_attr
				),
			);

			$get_posts = get_posts( $products_args );
		}

		if(!empty($get_posts)){
			$all_posts = count($get_posts);
		}else{
			$all_posts = 0;
		}	

		if($set_settings['display_items'] == "hidden" || empty($set_settings['first_items'])){
			$stop = $all_posts;
		}

		$all_cols = array('extra_small','small','medium','large','extra_large');
		foreach ($all_cols as $key => $col) {
			if($set_settings[$col] == "Inherit"){
				$set_settings[$col] = "";
			}
		}
		$post_cols = $set_settings['extra_small'] . " " . $set_settings['small'] . " " . $set_settings['medium'] . " " . $set_settings['large'] . " " . $set_settings['extra_large'];
			

		$count_item = -1;
		$out_item = -1;
		$count_cat = 0;
		$cat_set = array();
	
		if($set_settings['display_type'] == "pagination"){
			if($start > $all_posts || empty($category_items) || $all_posts == 0){
				echo '<div class="no-page">'.html_entity_decode($set_settings['no_page']).'</div>';
				return;
			}
		}

		if($set_settings['display_type'] == "pagination" && $category_active !== "all" && $start > 0){
			for ($item=0; $item < $all_posts; $item++) {
				if($category_type == "post"){
					$post_cat = wp_get_post_categories($get_posts[$item]->ID);
				}elseif($category_type == "woocommerce" && self::isWooCommerce()){
					$product = wc_get_product($get_posts[$item]->ID);
					$product_id = $product->get_id();
		       		$post_cat = wc_get_product_term_ids($product_id, 'product_cat');
				}
				foreach ($post_cat as $key => $cat_ID) {
					if(in_array($cat_ID, $category_items)){
						$out_item++;
						if($out_item < $start){
							$all_items_arc[] = $item;
						}
					}
				}
			}
		}

		$set_item = array();

		for ($item=$start; $item < $all_posts; $item++) {
			if(!empty($get_posts[$item]->ID)){

				if($category_type == "post"){

					$post_cat = wp_get_post_categories($get_posts[$item]->ID);
					$item_id = $get_posts[$item]->ID;
					$item_type = "arcfilter-wp-post";
				}elseif($category_type == "woocommerce" && self::isWooCommerce()){
					$product = wc_get_product($get_posts[$item]->ID);
			
		       		$post_cat = wc_get_product_term_ids($product->get_id(), 'product_cat');
				}

				foreach ($categories['set']['category_id'] as $cat_index => $category_id) {
					$output_items = self::get_items($arcfilter,$cat_index);

					($category_type == "woocommerce") ? $taxonomies = 'product_cat' : $taxonomies = 'category';
					$termchildren = get_terms($taxonomies,array('child_of' => $category_id));

					foreach ($post_cat as $cat => $value) {
						if(stripos($value, $category_id) !== false){
							if(!isset($cat_set[$item])){
								$cat_set[$item]['cat_name'] = $categories['set']['category_slug'][$cat_index]." ";
								$cat_set[$item]['set_style'] = $output_items["set_style"]." ";

								if(!empty($output_items["post_item"])){
									$cat_set[$item]['post_item'] = $output_items["post_item"];
								}
								
								if(!empty($output_items["set_item"])){
									$cat_set[$item]['set_item'] = $output_items["set_item"];
								}
								
							}else{
								$cat_set[$item]['cat_name'] .= $categories['set']['category_slug'][$cat_index]." ";
							}
						}
						if($item == 0 && $categories['set']['category_slug'][$cat_index] == $category_active &&
						$set_settings['display_type'] == 'pagination' && $category_type == "woocommerce"){
							$data_count = 'data-count='.$all_posts.'';
						}else{
							$data_count = '';
						}
					}
					if($set_settings['subcat_menu'] == 1){
						foreach ($termchildren as $cat => $children) {
							if(in_array($children->term_id, $post_cat)){
								$cat_set[$item]['cat_name'] .= $children->slug." ";
								if($item == 0 && $category_active == $children->slug &&
								$set_settings['display_type'] == 'pagination' && $category_type == "woocommerce"){
									$data_count = 'data-count='.$children->count.'';
								}else{
									$data_count = '';
								}
							}
						}
					}
				}

				if(!empty($cat_set[$item]['cat_name'])){
					$cat_set[$item]['cat_name'] = trim($cat_set[$item]['cat_name']);
				}

				if(!empty($cat_set[$item]['set_style'])){
				 	$cat_set[$item]['set_style']= trim($cat_set[$item]['set_style']);
				}

				(!empty($cat_set[$item]['post_item'])) ? $cat_set[$item]['post_item'] : $cat_set[$item]['post_item'] = "";

				if(!empty($cat_set[$item]['post_item'])) :	

					foreach ($cat_set[$item]['post_item'] as $key => $post_col) : 

						(!empty($cat_set[$item]['set_item'][$post_col])) ? $set_item[$item][$post_col] = $cat_set[$item]['set_item'][$post_col] : $set_item[$item][$post_col] = "";
						(!empty($cat_set[$item]['set_item'][$post_col."_text"])) ? $cat_set[$item]['set_item'][$post_col."_text"] : $cat_set[$item]['set_item'][$post_col."_text"] = "";
				
					endforeach;
					
				endif;

				if($category_active == "all"){
					if(!in_array($item, $all_items_arc)){
						$count_item++;
						for ($load = 0; $load < $stop; $load++) {
							if($count_item == $load){
								if($category_type == "post"){
									$all_tags = self::get_tags($get_posts[$item]->ID,", ");
									require ARCFILTER_FRONT_URL . "templates/GetItemsTemplate.php";
								}elseif($category_type == "woocommerce" && self::isWooCommerce()){
									self::get_product($item,$cat_set,$set_item,$product,$pageurl,$set_settings,$categories,$post_cols,$category_type,$all_posts);
								}
							}
						}		
					}

				}else{	

					foreach ($post_cat as $key => $cat_ID) {

						if(in_array($cat_ID, $category_items)){

							if(!in_array($item, $all_items_arc)){
								$count_item++;
								for ($load = 0; $load < $stop; $load++) {

									if($count_item == $load){

										if($category_type == "post"){
											$all_tags = self::get_tags($get_posts[$item]->ID,", ");
											require ARCFILTER_FRONT_URL . "templates/GetItemsTemplate.php";
										}elseif($category_type == "woocommerce" && self::isWooCommerce()){

											self::get_product($item,$cat_set,$set_item,$product,$pageurl,$set_settings,$categories,$post_cols,$category_type,$all_posts);
										}
									}
								}		
							}
						}
					}
				}
			}			
		}				
		wp_reset_postdata();
	}

	/**
	 * Get products
	 * @since   2.5.5
	 */
    public static function get_product($item,$cat_set,$set_item,$product,$pageurl,$set_settings,$categories,$post_cols,$category_type,$all_posts) {
		if($product->is_sold_individually() == 0){
			$item_id = $product->get_id();
			$item_type = "arcfilter-wc-product";
			$currency_symbol = get_woocommerce_currency_symbol();
			$product_url = get_permalink( $item_id ) ;
			
			($product->is_on_sale()) ? $cut_price[$item] = "cut_price" : $cut_price[$item] = '';  	

			$product_img = $product->get_image($size = 'woocommerce_thumbnail'); 
  			$product_img_gallery = $product->get_gallery_image_ids();

  			if(!empty($product_img_gallery)){
  				$shop_catalog_image_url[$item] = wp_get_attachment_image_src( $product_img_gallery[0], 'shop_catalog' )[0];
  			}

  			if(!empty($set_item[$item]['group']) && $set_item[$item]['group'] == 1 && !empty($shop_catalog_image_url[$item]) ||
  				!empty($set_item[$item]['image']) && $set_item[$item]['image'] == 1 && !empty($shop_catalog_image_url[$item])){

				$arc_product_hover_img[$item] = "arc-product_hover_img";
  			}
  			else{
  				$arc_product_hover_img[$item] = "";
  			}

			$best_seller = self::get_best_seller($set_settings,$categories);

			if(!empty($best_seller[$item_id]) && $best_seller[$item_id] == 1){
				$set_bottom_class[$item] = "set_bottom_class";
			}else{
				$set_bottom_class[$item] = "";
			}
			
			(empty($set_settings['loader_add_cart'])) ? $loader_add_cart = ARCFILTER_ASSETS_URL . "img/loader_add_cart.gif" : $loader_add_cart = $set_settings['loader_add_cart'];

			if($item == 0 && $set_settings['display_type'] == 'pagination'){
				$data_count = 'data-count='.esc_attr($all_posts).'';
			}else{
				$data_count = ""; 
			}

			require ARCFILTER_FRONT_URL . "templates/GetItemsTemplate.php";
		}
    }

    /**
	 * @since   2.5.6
	 */
    public static function get_product_cat($item_id,$separator,$title){
    	$cat_ids = wc_get_product_term_ids($item_id, 'product_cat');
		foreach ($cat_ids as $key => $cat_id) {
			$all_cat[] = sprintf( '<a href="%s">%s</a>',get_category_link($cat_id),get_the_category_by_ID($cat_id) );
		}

		$title_cat = '<span>'.$title.' </span>';

		$html = '<div class="arc-post-item arc-post-show_category">
			'.$title_cat .implode($separator, $all_cat).'
		</div>';

		return $html;
    }

    /**
	 * @since   2.5.6
	 */
    public static function get_product_tags($item_id,$separator,$title){
    	$tags = get_the_terms( $item_id, 'product_tag' );
    	if(!empty($tags)){
			foreach ($tags as $key => $tag) {
				$all_tags[] = sprintf( '<a href="%s">%s</a>',get_tag_link($tag->term_id),esc_html( $tag->name ));
			}

			if(empty($title)){
				$title_tags = "";
			}else{
				$title_tags = '<span>'.$title.' </span>';
			}

			$html = '<div class="arc-post-item arc-post-tags">
				'.$title_tags .implode($separator, $all_tags).'
			</div>';

			return $html;
    	}else{
    		return false;
    	}
    }

    /**
	 * @since   2.5.7
	 */
	public static function get_best_seller($set_settings,$categories){

		$products_args = array(
			'posts_per_page'   	=> -1,
			'post_type'        	=> 'product',
			'post_status'      	=> 'publish',
			'meta_key' 		   	=> 'total_sales',
		    'orderby' 			=> 'meta_value_num',
		    'order' 			=> 'DESC',
			'tax_query' => array( 
			    array(
			      'taxonomy' => 'product_cat',
			      'field' => 'id',
			      'terms' => $categories['set']['category_id']
			    )
			) 
		);

		$get_posts = get_posts( $products_args );

		(!empty($set_settings['get_best_seller'])) ? $set_settings['get_best_seller'] : $set_settings['get_best_seller'] = 0;
		for ($item=0; $item < $set_settings['get_best_seller']; $item++) {
			if(!empty($get_posts[$item])){

				$product[$item] = wc_get_product($get_posts[$item]->ID);
				$total_sales[$item] = get_post_meta( $product[$item]->get_id() );

				if($total_sales[$item]['total_sales'][0] > 0){
	       			$all_products_sales[$product[$item]->get_id()] = 1;
				}
			}
		}
		if(!empty($all_products_sales))
	    return $all_products_sales;
	}

	public static function product_rating($product){
		$rating_count = $product->get_rating_count();
		$average = $product->get_average_rating();

		if ( 'yes' === get_option( 'woocommerce_enable_review_rating' ) ){
			$html = '<div class="arc-post-item arc-post-rating">
					<span class="arc-product-rating">
							<span class="star-full" style="width: '.esc_attr(($average / 5) * 100).'%"></span>
						</span>
					</div>';
			return $html;
		}else{
			return false;
		}
	}

	/**
	 * @since   2.5.7
	 */
	public static function get_product_methods($product,$method,$title){

		$get = "get_";
		$get_method = $get.$method;
		if(empty($title)){
			$title = str_replace("_", " ", $method);
			$title = ucfirst($title).":";
		}

		if($method == "dimensions"){
	
			$dimension_string = get_option( 'woocommerce_dimension_unit' );
			$dimensions = $product->get_dimensions($formatted = false);

			$html = '<div class="arc-post-item arc-post-'.esc_attr($method).'">
				'.$title.'  
				<span>'.$dimensions['length'].' x</span>
				<span>'.$dimensions['width'].' x</span>
				<span>'.$dimensions['height'].'</span>
				<span>'.$dimension_string.'</span>
			</div>';

		}
		else{
			$html = '<div class="arc-post-item arc-post-'.esc_attr($method).'">
				'.esc_html($title).' <span>'.$product->$get_method().'</span>
			</div>';
		}

		return $html;
	}

	/**
	 * @since   2.5.8
	 */
	public static function add_to_cart($product,$pageurl,$loader_add_cart){
		if ( $product ) {
   			$args = array();
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
			}

			if($pageurl == null){
				$btn_url = $product->add_to_cart_url();
			}else{
				$btn_url = $pageurl . "&add-to-cart=". $product->get_id();
			}

			$btn = sprintf( 
					'<div class="arc-post-item arc-post-add_to_cart">
						<a href="%s" data-quantity="%s" class="%s" %s>%s
							<span class="arc_add_to_cart_loader"><img src='.esc_url($loader_add_cart).'></span>
						</a>
					</div>',
					esc_url( $btn_url ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				);

			return $btn;
		}
	}

	/**
	 * @since   2.5.5
	 */
	public static function count_words($excerpt,$limit) {

		$excerpt = self::remove_html_comments($excerpt);
	  	$excerpt = explode(' ', $excerpt,(int)$limit + 1);

	  	if (count($excerpt) >= (int)$limit + 1) {
	   	array_pop($excerpt);
	   	$excerpt = implode(" ",$excerpt).'...';
	  	} 
	  	else {
	    	$excerpt = implode(" ",$excerpt);
	  	}

	  	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);

	  	return $excerpt;

	}

	/**
	 * @since   2.9.1
	 */
	public static function remove_html_comments($content) {
		return preg_replace('/<!--(.|\s)*?-->/', '', $content);
	}

	/**
	 * @since   2.0.5
	 */
	public static function get_tags($post_ID,$separator){
		$arc_post_tags = get_the_tags( $post_ID );
		$count_tags = array();
		if(!empty($arc_post_tags)){
			foreach ($arc_post_tags as $key => $value) {
				$count_tags[] = sprintf( '<a href="%s">%s</a>',get_tag_link($value->term_id),esc_html( $value->name ));
			}
			$all_tags = implode($separator, $count_tags);
			return $all_tags;
		}else{
			return false;
		}	
	}

	/**
	 * @since   2.0.5
	 */
	public static function get_items($arcfilter,$category){
		
		if(!empty($arcfilter->items))	
		$items = unserialize($arcfilter->items);
		$output = array();

		if(!empty($items["cat_items$category"])){
            foreach ($items["cat_items$category"] as $style => $item) {
                if(!empty($item)){
                	$output[$style] = $item;
                }
            }
        }
  		
		return $output;
	}
	
	/**
	 * Check if WooCommerce is activated
	 */
    public static function isWooCommerce(){
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}