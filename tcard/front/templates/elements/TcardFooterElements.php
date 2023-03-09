<?php

/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/public/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

if($element == "tc_button") : ?>

<div class="<?php echo $element. " " .$output['tc_col'] ?>">

	<?php 
	(!empty($output['tc_button_link'])) ? $output['tc_button_link'] : $output['tc_button_link'] = "";
	(!empty($output['tc_button_name'])) ? $output['tc_button_name'] : $output['tc_button_name'] = "";
	(!empty($output['tc_button_extra'])) ? $output['tc_button_extra'] : $output['tc_button_extra'] = "";
	if($output[$element] == "main") : ?>
		<h4 <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo $output['tc_button_extra']; ?><span class="tcard-button <?php echo $side ?>"> <?php echo $output['tc_button_name']; ?></span></h4>
	<?php else : ?>
		<div <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
			<?php echo $output['tc_button_extra']; ?>
			<a href="<?php echo esc_url($output['tc_button_link']); ?>" target="_blank"><span class="tcard-button"> <?php echo $output['tc_button_name']; ?></span></a>
		</div>
	<?php endif; ?>	
</div>


<?php elseif ($element == "social_list") : ?>
<div class="<?php echo $element. " " .$output['tc_col'] ?>">
	<ul class="tcard-list">

		<?php $social_animations = $animations->get_animations($output['animation_in'],$output['animation_out']);

		if(!empty($output['social_list_order'])) :
		
			foreach ($output['social_list_order'] as $key => $item) :

				if($item == "google+") {
					$icon = "google-plus-square";
					if(!empty($output[$element][$key]))
					$link = "plus.google.com/".$output[$element][$key];
				}elseif($item == "instagram" || $item == "linkedin" || $item == "flickr") {
					$icon = "$item";
					if(!empty($output[$element][$key]))
					$link = $item.".com/".$output[$element][$key];
				}else {
					$icon = "$item-square";
					if(!empty($output[$element][$key]))
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


			   	<li <?php echo $social_animations. " " .$animations->get_delay($output['delay']); ?>>
			        <a href="<?php echo esc_url($link) ?>" target="_blank"><i class="fab fa-<?php echo esc_html($icon); ?>"></i></a>
			    </li>
			<?php endforeach;

		endif; ?>  
	</ul>
</div>
<?php elseif ($element == "info") : ?>

<?php $info_animations = $animations->get_animations($output['animation_in'],$output['animation_out']); ?>

<div class="tcard-header-info <?php echo $output['tc_col'] ?>">
	<?php if(!empty($output["info_title"])) : ?>
		<h3 <?php echo $info_animations. " " .$animations->get_delay($output['delay']); ?>><?php echo $output['info_title']; ?></h3>
	<?php endif; ?>
	
	<?php if(!empty($output[$element])) : ?>
    	<div class="tcard-info-content" <?php echo $info_animations. " " .$animations->get_delay($output['delay']); ?>><?php echo $output[$element]; ?></div>
    <?php endif; ?>
</div>

<?php elseif ($element == "info_list") : ?>
<div class="<?php echo $element. " " .$output['tc_col'] ?>">
	<ul class="tcard-list">

		<?php $info_animations = $animations->get_animations($output['animation_in'],$output['animation_out']);

		if(!empty($output['info_list_title'])) :
		
			foreach ($output['info_list_title'] as $key => $item) : 
				if(!empty($item)) :
				(!empty($output['info_list_text'][$key])) ? $output['info_list_text'][$key] : $output['info_list_text'][$key] = ""; ?>

				   	<li <?php echo $info_animations. " " .$animations->get_delay($output['delay']); ?>>
				   		<h4><?php echo stripslashes($item);?></h4>
				        	<p><?php echo stripslashes($output['info_list_text'][$key])?></p> 
				    </li>

				<?php endif;
			endforeach;

		endif; ?> 

	</ul>
</div>

<?php elseif($element == "image_button") : ?>
<div class="tcard-button-container image-btn <?php echo $output['tc_col']; ?>">

	<?php if($output['image_button_type'] == "main") : ?>

		<div class="tcard-button <?php echo $element. " " .$output['button_pos'] . " " .$side ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>

		    <img src="<?php echo esc_url($output[$element]) ?>" alt="image_btn">

		</div>

	<?php else : ?>

		<div < class="tcard-button <?php echo $element. " " .$output['button_pos']; ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
			<a href="<?php echo esc_url($output['image_button_link']); ?>" target="_blank">
			
				<img src="<?php echo esc_url($output[$element]) ?>" alt="image_btn">

			</a>
		</div>

	<?php endif; ?>
	
</div>

<?php elseif($element === "twitter_profile" || $element === "twitter_feed") : ?>
	
	<?php require TCARD_FRONT_URL . "templates/elements/TcardSocialElements.php"; ?>

<?php endif; ?>