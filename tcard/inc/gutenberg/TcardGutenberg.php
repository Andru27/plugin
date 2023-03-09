<?php
/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardGutenberg 
{

	public function __construct($groups){

		$this->tcard_register_block_type($groups);
		add_filter( 'block_categories', array($this,'tcard_block_categories'), 10, 2 );

	}

	/**
	 * Register the JavaScript for gutenberg plugin.
	 * @since    2.8.3
	 */
	public function tcard_register_block_type($groups){
		global $pagenow;
		
		if(!empty($groups['arcfilter']) || !empty($groups['tcard']) && $pagenow == "post.php"){

			wp_register_script(
		        'tcard-block',
		        TCARD_BASE_URL . "inc/gutenberg/js/tcard_block.min.js",
		        array( 'wp-blocks', 'wp-element' )
		    );

			foreach ($groups['arcfilter'] as $key => $value) {

				$check = wp_specialchars_decode($value['title']);
				$check = preg_replace ('/<[^>]*>/', ' ', $check);
				$check = strip_tags(stripslashes($check));
				$groups['arcfilter'][$key]['title'] = $check;
			
			}

			$all_groups = array(
				"tcard" 		=> json_encode($groups['tcard']),
				"arcfilter" 	=> json_encode($groups['arcfilter'])
			);

		    wp_localize_script( 'tcard-block', 'tcard_block', array(
				'groups' 	=> $all_groups,
			)); 

			foreach ($groups['tcard'] as $key => $group) {

				register_block_type( 'tcard/'.$key.'-group-'.$value['group_id'].'', array(
			        'editor_script' => 'tcard-block',
			    ));
			}

			foreach ($groups['arcfilter'] as $key => $value) {

				register_block_type( 'arcfilter/'.$key.'-group-'.$value['group_id'].'', array(
			        'editor_script' => 'tcard-block',
			    ));
			
			}

		}
	}


	/**
	 * Register gutenberg category Tcard.
	 * @since    2.8.3
	 */
	public function tcard_block_categories( $categories, $post ) {

	    return array_merge(
	        $categories,
	        array(
	            array(
	                'slug' => 'tcard',
	                'title' => __( 'Tcard', 'tcard' )
	            ),
	            array(
	                'slug' => 'arcfilter',
	                'title' => __( 'Arcfilter', 'tcard' )
	            ),
	        )
	    );
	}
}