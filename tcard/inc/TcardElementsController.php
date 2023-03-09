<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardElementsController
{

	/**
	 * @since    1.0.0
	 */
	public $tcardHeader;

	/**
	 * @since    1.0.0
	 */
	public $tcardContent;

	/**
	 * @since    1.0.0
	 */
	public $tcardFooter;

	/**
	 * @since    1.0.0
	 */
	public $tcardSettings;

	/**
	 * Construct
	 * @since    1.0.0
	 */
	public function __construct($group_id, $urlfile)
	{

		require_once TCARD_PATH . "inc/elements-class/TcardHeader.php";
		$this->tcardHeader = new TcardHeader($group_id, $urlfile);

		require_once TCARD_PATH . "inc/elements-class/TcardContent.php";
		$this->tcardContent = new TcardContent($group_id, $urlfile);

		require_once TCARD_PATH . "inc/elements-class/TcardFooter.php";
		$this->tcardFooter = new TcardFooter($group_id, $urlfile);

		require_once TCARD_PATH . 'inc/elements-class/TcardSettings.php';
		$this->tcardSettings = new TcardSettings();


	}

}