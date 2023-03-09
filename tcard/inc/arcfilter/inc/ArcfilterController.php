<?php
/**
 * @since           2.0.5
 * @package         Tcard
 * @subpackage  	Arcfilter/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class ArcfilterController 
{

	/**
	 * @since    2.0.5
	 */
	public $settings;

	/**
	 * @since    2.0.5
	 */
	public $category;

	/**
	 * @since    2.0.5
	 */
	public $items;
	/**
	 * Construct
	 * @since    2.0.5
	 */
	public function __construct()
	{

		require_once ARCFILTER_PATH . "inc/ArcfilterSettings.php";
		$this->settings = new ArcfilterSettings();

		require_once ARCFILTER_PATH . "inc/ArcfilterCategory.php";
		$this->category = new ArcfilterCategory();

		require_once ARCFILTER_PATH . "inc/ArcfilterItems.php";
		$this->items = new ArcfilterItems();
	}

}	