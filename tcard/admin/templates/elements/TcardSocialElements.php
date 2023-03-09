<?php
/**
 * @since           1.3.0
 * @package         Tcard
 * @subpackage  	Tcard/admin/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

if($element == "twitter_profile") : ?>
<div class="tcard-modal-container" data-modal-container="settings_twitter">
	<table class="table-tc-settings">
		<tbody>

			<?php foreach ($check_twitter_fields as $field) : ?>

				<tr>
					<td class="tc-td twitter_profile"><?php _e( $field, 'tcard' ) ?></td>
					<td class="tc-td2">

						<div class="tc-check-settings">
						  <input class="tcard-input" id="tp_<?php echo $field.$skin.$side.$elemNumber ?>" type="checkbox" name="<?php echo $parent.$skin. "_" .$side . "[tp_$field][$elemNumber]" ?>" value="1" <?php checked( $output_twitter["tp_$field"], 1 , true ); ?>>
						  <label for="tp_<?php echo $field.$skin.$side.$elemNumber ?>"></label>
						</div> 
					</td>
					<td>
						<div class="setting-info">

							<?php if($field == 'name') :
								 _e( 'Display user name', 'tcard' );

							elseif($field == 'description') :
								 _e( 'Display biography section', 'tcard' );

							elseif($field == 'location') :
								 _e( 'Shows user location', 'tcard' );

							elseif($field == 'image') :
								 _e( 'Display profile image ', 'tcard' );

							elseif($field == 'banner') :
								 _e( 'Display profile banner', 'tcard' );

							elseif($field == 'website') :
								 _e( 'Display user website', 'tcard' );

							elseif($field == 'email') :
								printf(
									 __( 'Need special permissions %s Look %s here %s', 'tcard' ),
									 "<br>",'<a href="https://support.twitter.com/forms/platform">','</a>'
								);

							elseif($field == 'tweets') :
								printf(
									 __( 'Display how many tweets %s the user has sent', 'tcard' ),
									 "<br>"
								);	
							
							elseif($field == 'followers') :
								 _e( 'Display number of followers', 'tcard' );

							elseif($field == 'friends') :
								 _e( 'Display number of friends', 'tcard' );

							elseif($field == 'lists') :
								 _e( 'Display number of lists', 'tcard' );

							endif;?>	
						</div>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
</div>	
<div class="tcard-modal-container" data-modal-container="twitter_text">

	<?php foreach ($check_twitter_fields as $field) : 

		if($field == 'location' || $field == 'tweets' || $field == 'followers' || $field == 'friends' || $field == 'lists') : ?>
			<div class="tcard-modal-item" style="text-transform: capitalize;">
				<h4><?php _e( $field . ':', 'tcard' ) ?> </h4> 
				<input class="tcard-input" style="text-transform: capitalize;" placeholder="<?php echo $field ?>" type="text" name="<?php echo $parent.$skin. "_" .$side. "[" .$element. "_" .$field ?>][]" value="<?php echo $output_twitter[$element. "_" .$field] ?>">
			</div>
		<?php endif;

	endforeach; ?>	
</div>
<div class="tcard-modal-container" data-modal-container="twitter_animations">
	<?php foreach ($check_twitter_fields as $field) : 

		if($field == 'image' || $field == 'website' || $field == 'email' || $field == 'name' || $field == 'description' || $field == 'location') : ?>

			<div class="tcard-modal-item twitter_profile_anim">
				<h4><?php _e( $field.':', 'tcard' ) ?> </h4> 
				
				<?php echo $animations->set_animation( $parent,$side, $skin, $output['animation_in'], $output['animation_out'] ) .
					$animations->set_delay( $parent,$side, $skin, $output['delay'] ) ?>
			</div>	

		<?php endif;

	endforeach; ?>

	<div class="tcard-modal-item twitter_profile_anim">
		<h4><?php _e( 'Counts:', 'tcard' ) ?> </h4> 
		<?php echo $animations->set_animation( $parent,$side, $skin, $output['animation_in'], $output['animation_out'] ) ;?>
	</div>

	<?php foreach ($check_twitter_fields as $field) : 

		if($field == 'tweets' || $field == 'followers' || $field == 'friends' || $field == 'lists') : ?>
			<div class="tcard-modal-item twitter_profile_anim">
				<h4><?php _e( $field.':', 'tcard' ) ?> </h4> 
				<?php echo $animations->set_delay( $parent,$side, $skin, $output['delay'] ) ?>
			</div>	
		<?php endif;

	endforeach; ?>
</div>	

<?php elseif($element == "twitter_feed") : ?>
		
		<div class="tcard-modal-item">
			<h4><?php _e( 'Type:', 'tcard' ) ?></h4> 
			<select class="tcard-input" name="<?php echo $parent.$skin. "_" .$side. "[" .$element ?>_type][]">
				<option value="slider" <?php selected( $output_twitter[$element. "_type"], 'slider' ); ?>><?php _e( 'Slider', 'tcard' ) ?></option>
				<option value="scroll" <?php selected( $output_twitter[$element. "_type"], 'scroll' ); ?>><?php _e( 'Scroll', 'tcard' ) ?></option>
			</select>
		</div>

		<div class="tcard-modal-item">
			<h4 class="tcard-with-em"><?php _e( 'Tweets number:', 'tcard' ) ?> <br> <em class="tcard-em"><?php _e( 'Default: 20', 'tcard' ) ?></em> </h4>
			<input class="tcard-input" type="number" name="<?php echo $parent.$skin. "_" .$side. "[" .$element ?>_count][]" value="<?php echo $output_twitter[$element. "_count"] ?>">
		</div>	

<?php endif; ?>