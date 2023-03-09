<?php
/**
 * @link       https://www.addudev.com
 * @since      1.0.0
 * @package    Tcard
 * @author     Cloanta Alexandru <alexandrucloanta@yahoo.com>
 */

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardAnimations
{

	private $count_anim;
	private $count_delay;

	/**
	 * Construct.
	 * @since    1.0.0
	 */ 
	public function __construct(){
		$this->count_anim = -1;
		$this->count_delay = -1;
	}

	/**
	 * Set animations in admin panel.
	 * @since    1.0.0
	 */ 
	public function set_animation( $name, $side, $skin,$valuein,$valueout){
		$this->count_anim++;
		$animations_in = array('shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight',
			'bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig',
			'flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','hinge',
			'jackInTheBox','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','slideInDown','slideInLeft','slideInRight','slideInUp'
		);
		$animations_out = array('shake','headShake','swing','tada','wobble','jello','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight',
		'bounceOutUp','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig',
		'flipOutX','flipOutY','lightSpeedOut','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge',
		'jackInTheBox','rollOut','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp'
		);

		if(empty($valuein[$this->count_anim])){
			$valuein[$this->count_anim] = ' ';
		}

		if(empty($valueout[$this->count_anim])){
			$valueout[$this->count_anim] = ' ';
		}

		$html = "<div class='tcard-animation'>";
		$html .= "<h4>".__( 'Animation In:', 'tcard' )."</h4>";
		$html .= "<select class='tcard-input' name='$name"."$skin". '_' ."$side". '[animation_in][]' ."'>
				<option></option>";
			    foreach($animations_in as $animation_in){
				    $html .= "<option value='$animation_in' ". selected( $valuein[$this->count_anim] , $animation_in, false ) ." >$animation_in</option>";
			    }		    	
		$html .= "</select>";
		$html .= "</div>";
		$html .= "<div class='tcard-animation'>";
		$html .= "<h4>".__( 'Animation Out:', 'tcard' )."</h4>";
		$html .= "<select class='tcard-input' name='$name"."$skin". '_' ."$side". '[animation_out][]' ."'>
				<option></option>";
			    foreach($animations_out as $animation_out){
				    $html .= "<option value='$animation_out' ". selected( $valueout[$this->count_anim], $animation_out, false ) ." >$animation_out</option>";
			    }		    	
			$html .= "</select>";
		$html .= "</div>";
		return $html;
	}

	/**
	 * Set delay for animations in admin panel.
	 * @since    1.0.0
	 */ 
	public function set_delay( $name, $side, $skin, $delay ){
		$this->count_delay++;
		if(empty($delay[$this->count_delay])){
			$delay[$this->count_delay] = ' ';
		}
		$html = "<div class='tcard-animation'>
			<h4>".__( 'Delay:', 'tcard' )."</h4>";
		$html .= "<input class='tcard-input' type='number' name='$name"."$skin". '_' ."$side". '[delay][]' ."' value=".esc_attr($delay[$this->count_delay])."></div>";
		return $html;
	}

	/**
	 * Get animations in front of site
	 * @since    1.0.0
	 */ 
	public function get_animations($valuein,$valueout){
		$this->count_anim++;
		if(!empty($valuein[$this->count_anim])){
			$value = "data-animationin=".esc_attr($valuein[$this->count_anim])." ";
		}
		if(!empty($valueout[$this->count_anim])){
			$value .= "data-animationout=".esc_attr($valueout[$this->count_anim])."";
		}
		if(!empty($value))
		return $value;
	}

	/**
	 * Get delay in front of site
	 * @since    1.0.0
	 */ 
	public function get_delay($delay){
		$this->count_delay++;
		if(!empty($delay[$this->count_delay])){
			$value = "data-delay=".esc_attr($delay[$this->count_delay])."";
		}
		if(!empty($value))
		return $value;
	}
}