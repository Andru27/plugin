<?php

/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/public/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');
(!empty($output['button_pos'])) ? $output['button_pos'] : $output['button_pos'] = "";
(!empty($output['style_btn'])) ? $output['style_btn'] : $output['style_btn'] = ""; 
if($element == "header_title") : ?>

	<div class="tcard-header-title <?php echo $output['tc_col'] ?>">
	    <h2 <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo $output["header_title"]; ?></h2>
	</div>

<?php elseif($element == "info") : ?>

<?php $info_animations = $animations->get_animations($output['animation_in'],$output['animation_out']); ?>

<div class="tcard-header-info <?php echo $output['tc_col'] ?>">
	<?php if(!empty($output["info_title"])) : ?>
		<h3 <?php echo $info_animations. " " .$animations->get_delay($output['delay']); ?>><?php echo $output['info_title']; ?></h3>
	<?php endif; ?>

	<?php if(!empty($output[$element])) : ?>
    	<div class="tcard-info-content" <?php echo $info_animations. " " .$animations->get_delay($output['delay']); ?>><?php echo $output[$element]; ?></div>
    <?php endif; ?>
</div>

<?php elseif($element == "profile") : ?>

<div class="tcard-profile <?php echo $output['tc_col'] ?>">

    <div class="tcard-avatar" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
        <img src="<?php echo $output['profile'] ?>" alt="man">
    </div>

    <div class="tcard-profile-buttons">

	    <?php $animation_link = $animations->get_animations($output['animation_in'],$output['animation_out']);
	    $delay_link = $animations->get_delay($output['delay']);

	    if($settings['individualGallery'] == 1){
	    	$gallery_id = $group_id.$skin;
	    }
		else {
			$gallery_id = $group_id;
		}

	    if(!empty($gallery['image']) || !empty($gallery['user'])) : ?>

	    	<a class="tcard-button-gallery <?php echo $output['profile_btntype'] ?>" <?php echo $animation_link. " " .$delay_link; ?> data-tcg="group-<?php echo $gallery_id ?>" data-open-tcg="card-<?php echo $skin ?>">
	        	<?php if($output['profile_btntype'] == "text") :
	        		echo $output['profile_btntext'];
	        	else : ?>
	        		<i class="fas fa-camera"></i>
	        	<?php endif; ?>
	    	</a>
	    <?php endif;

	    $animation_link_email = $animations->get_animations($output['animation_in'],$output['animation_out']);
	    $delay_link_email = $animations->get_delay($output['delay']);

	    if(!empty($output['profile_email'])) : ?>

	     <a class="email <?php echo $output['profile_emailtype'] ?>" href="mailto:<?php echo $output['profile_email'] ?>" <?php echo $animation_link_email. " " .$delay_link_email; ?>>
	    	<?php if($output['profile_emailtype'] == "text") :
	        		echo $output['profile_emailtext'];
	        	else : ?>
	        		<i class="fas fa-envelope"></i>
	        	<?php endif; ?>
	    </a>

	    <?php endif; ?>
	</div>

</div>

<?php elseif ($element == "button_four_line"  		|| 
				$element == "button_three_line" 	|| 
				$element == "button_arrow"  		||
				$element == "button_squares"		) :?>

	<div class="tcard-button-container <?php echo $output['tc_col']; ?>">
		<div class="tcard-button <?php echo $side. " " .$element. " " .$output['button_pos']. " ".$output['style_btn']; ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
			<span class="tcard-btn-line"></span>
	    </div>
	</div>	

<?php elseif($element == "gallery_button") : ?>

<?php if($settings['individualGallery'] == 1) :
		$gallery_id = $group_id.$skin;
	else :
		$gallery_id = $group_id;
	endif;

	$animation_link_gallery = $animations->get_animations($output['animation_in'],$output['animation_out']);
	$delay_link_gallery = $animations->get_delay($output['delay']);

	if(!empty($gallery['image']) || !empty($gallery['user'])) : ?>
	<div class="tcard-button-container <?php echo $output['tc_col']; ?>">
		<a class="tcard-button tcard-button-gallery <?php echo $element. " " .$output['button_pos']. " ".$output['style_btn']; ?>" <?php echo $animation_link_gallery. " " .$delay_link_gallery; ?> href="#" data-tcg="group-<?php echo $gallery_id ?>" data-open-tcg="card-<?php echo $skin ?>">

			<?php if($output['gallery_button_type'] == "text") :
				echo $output['gallery_button_text'];
			else : ?>
				<i class="fas fa-camera"></i>
			<?php endif; ?>

		</a>
	</div>	
	<?php endif; ?>

<?php elseif($element == "social_button") : ?>

<div class="tcard-button-container social-btn <?php echo $output['tc_col']; ?>">
	<div class="tcard-button <?php echo $element. " " .$output['button_pos']. " ".$output['style_btn']; ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
		<span class="tcard-btn-line"></span>
		<span class="tcard-btn-line"></span>
		<span class="tcard-btn-line"></span>
	    <div class="tcard-social-list">

	    	<?php if(!empty($output['social_button_order'])) :
	    	
	    		foreach ($output['social_button_order'] as $key => $item) :
	    			
		    		if($item == "google+") {
						$icon = "google-plus-square";
						$link = "plus.google.com/".$output[$element][$key];
					}elseif($item == "instagram" || $item == "linkedin" || $item == "flickr") {
						$icon = "$item";
						$link = $item.".com/".$output[$element][$key];
					}else {
						$icon = "$item-square";
						$link = $item.".com/".$output[$element][$key];
					}

					if($item == "reddit"){
						$link = 'reddit.com/user/'.$output[$element][$key];
					}elseif($item == "linkedin"){
						$link = $item.".com/in/".$output[$element][$key];
					}elseif($item == "tumblr"){
						$link = $output[$element][$key].".tumblr.com";
					}elseif($item == "flickr"){
						$link = $item.".com/photos/".$output[$element][$key];
					}
					
					?>

	    			<a href="<?php echo esc_url($link) ?>" target="_blank"><i class="fab fa-<?php echo esc_html($icon); ?>"></i></a>

	    		<?php endforeach;

			endif; ?>

	    </div>
	</div>
</div>

<?php elseif($element == "image_button") : ?>
<div class="tcard-button-container image-btn <?php echo $output['tc_col']; ?>">

	<?php if($output['image_button_type'] == "main") : ?>

		<div class="tcard-button <?php echo $element. " " .$output['button_pos'] . " " .$side ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>

		    <img src="<?php echo esc_url($output[$element]) ?>" alt="image_btn">

		</div>

	<?php else : ?>

		<div class="tcard-button <?php echo $element. " " .$output['button_pos']; ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
			<a href="<?php echo esc_url($output['image_button_link']); ?>" target="_blank">
			
				<img src="<?php echo esc_url($output[$element]) ?>" alt="image_btn">

			</a>
		</div>

	<?php endif; ?>
	
</div>

<?php elseif($element === "twitter_profile" || $element === "twitter_feed") : ?>
	
	<?php require TCARD_FRONT_URL . "templates/elements/TcardSocialElements.php"; ?>

<?php endif; ?>