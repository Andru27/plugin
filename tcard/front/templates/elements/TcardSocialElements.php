<?php

/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');
if($element == "twitter_profile") : 
$twitter_profile = $tcardSocial->twitter_profile($skin);?>

<div class="tcard-profile twitter_profile <?php echo $output['tc_col']; ?>">

	<?php if($output_twitter['tp_image'] == 1 || $output_twitter['tp_website'] == 1 || $output_twitter['tp_email'] == 1) : ?>

		<div class="profile_banner">
			<?php if($output_twitter['tp_image'] == 1) : ?>
				
					<div class="tcard-avatar" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
				    	<?php $new_img = str_replace('_normal', '_bigger', $twitter_profile['profile_image_url']); ?>
				    	<a href="<?php echo esc_url('//twitter.com/' . $twitter_profile['screen_name']); ?>" target="_blank">
				    		<img src="<?php echo esc_url($new_img); ?>" alt="">
				    	</a>
				    </div>

			<?php endif;
			if($output_twitter['tp_website'] == 1 || $output_twitter['tp_email'] == 1) : ?>
			    <div class="tcard-profile-buttons">

			    	<?php if($output_twitter['tp_website'] == 1 && !empty($twitter_profile['website'])) : ?>
					    <a class="twitter-website icon" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?> target="_blank" href="<?php echo esc_url($twitter_profile['website']); ?>">
					       <i class="fas fa-globe"></i>
					    </a>
					<?php endif;

					if($output_twitter['tp_email'] == 1  && !empty($twitter_profile['email'])) : ?>
					    <a class="email icon" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?> href="mailto:<?php echo esc_attr($twitter_profile['email']); ?>">
				        	<i class="fas fa-envelope"></i>
					    </a>
					<?php endif; ?>    

				</div>
			<?php endif; ?> 
		</div>

	<?php endif;

	if($output_twitter['tp_name'] == 1 || $output_twitter['tp_description'] == 1 || $output_twitter['tp_location'] == 1) : ?>

		<div class="twitter_profile_info">
			
			<?php if($output_twitter['tp_name'] == 1) : ?>
				<h2 class="twitter_profile_name" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo esc_html($twitter_profile['name']); ?></h2>
			<?php endif;

			if($output_twitter['tp_description'] == 1) : ?>
				<p class="twitter_profile_description" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo esc_html($twitter_profile['description']); ?></p>
			<?php endif;

			if($output_twitter['tp_location'] == 1) : ?>
				<p class="twitter_profile_location" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><span><?php echo $output_twitter['twitter_profile_location']; ?></span>: <?php echo esc_html($twitter_profile['location']); ?></p>
			<?php endif;?>
		</div>

	<?php endif;

	if($output_twitter['tp_tweets'] == 1 || $output_twitter['tp_followers'] == 1 || $output_twitter['tp_friends'] == 1 || $output_twitter['tp_lists'] == 1) : ?>

		<div class="twitter_counts">

			<?php $counts_animations = $animations->get_animations($output['animation_in'],$output['animation_out']);
			if($output_twitter['tp_tweets'] == 1) : ?>

				<div class="twitter_count" <?php echo $counts_animations . " " . $animations->get_delay($output['delay']); ?>>

					<h4><?php echo esc_html($output_twitter['twitter_profile_tweets']); ?></h4>
					<?php echo (empty($twitter_profile['statuses_count']) ? $twitter_profile['statuses_count'] = 0 : $twitter_profile['statuses_count']); ?>
				</div>

			<?php endif;

			if($output_twitter['tp_followers'] == 1) : ?>

				<div class="twitter_count" <?php echo $counts_animations . " " . $animations->get_delay($output['delay']); ?>>

					<h4><?php echo esc_html($output_twitter['twitter_profile_followers']); ?></h4>
					<?php echo (empty($twitter_profile['followers_count']) ? $twitter_profile['followers_count'] = 0 : $twitter_profile['followers_count']); ?>
				</div>

			<?php endif;

			if($output_twitter['tp_friends'] == 1) : ?>	

				<div class="twitter_count" <?php echo $counts_animations . " " . $animations->get_delay($output['delay']); ?>>
					<h4><?php echo esc_html($output_twitter['twitter_profile_friends']); ?></h4>
					<?php echo (empty($twitter_profile['friends_count']) ? $twitter_profile['friends_count'] = 0 : $twitter_profile['friends_count']); ?>
				</div>

			<?php endif;

			if($output_twitter['tp_lists'] == 1) : ?>	

				<div class="twitter_count" <?php echo $counts_animations . " " . $animations->get_delay($output['delay']); ?>>
					<h4><?php echo esc_html($output_twitter['twitter_profile_lists']); ?></h4>
					<?php echo (empty($twitter_profile['listed_count']) ? $twitter_profile['listed_count'] = 0 : $twitter_profile['listed_count']); ?>
				</div>

			<?php endif; ?>	
		</div>

	<?php endif; ?>
		
</div>

<?php elseif($element == "twitter_feed") : 
$twitter_timeline = $tcardSocial->twitter_timeline($skin);
if($output_twitter["twitter_feed_type"] == "scroll") :
	$scroll =  'scroll';
	$active = '';
else: 
	$scroll =  '';
	$active = 'active';	
endif;?>
<div class="twitter_timeline <?php echo $output['tc_col'] ?>">
	<div class="tcard-slider <?php echo $scroll ?>">
		<div class="tcs-inner cubictime">

			<?php for ($item = 0; $item < $output_twitter["twitter_feed_count"]; $item++ ) : 

				if(!empty($twitter_timeline['id_str'][$item])) : 

					if($item == 0) :
						$classActive = $active;
					else :
						$classActive = '';
					endif;?>

					<div class="tcs-item <?php echo $classActive ?>">
						<div class="tcs-item-inner">
							<div class="tcs-item-header">
								<div class="tcs-author">
									<img src="<?php echo esc_url($twitter_timeline['profile_image_url'][$item]) ?>">
								</div>
								<div class="tcs-helem">
									<div class="tcs-author-name">
										<a href="<?php echo esc_url('//twitter.com/' . $twitter_timeline['screen_name'][$item]); ?>" target="_blank"><?php echo $twitter_timeline['name'][$item] ?></a>
									</div>
									<div class="tcs-created_at">
										<?php echo $twitter_timeline['created_at'][$item] ?>
									</div>
								</div>
							</div>
							<div class="tcs-bar">
								<span>
									<i class="fas fa-retweet"></i>
									<?php echo (empty($twitter_timeline['retweet_count'][$item])) ? $twitter_timeline['retweet_count'][$item] = 0 : $twitter_timeline['retweet_count'][$item]; ?>
								</span>
								<span>
									<i class="fas fa-heart"></i>
									<?php echo (empty($twitter_timeline['favorite_count'][$item])) ? $twitter_timeline['favorite_count'][$item] = 0 : $twitter_timeline['favorite_count'][$item]; ?>
								</span>
								<span>
									<?php $url_tweet = esc_url('twitter.com/'.$twitter_timeline['screen_name'][$item].'/status/'.$twitter_timeline['id_str'][$item].''); ?>
									<a href="<?php echo esc_url($url_tweet); ?>" target="_blank"><i class="fas fa-link"></i></a>
								</span>
							</div>
							<div class="tcs-item-content">
								<?php echo $twitter_timeline['text'][$item]; 

								if(!empty($twitter_timeline['url'][$item])) : ?>
									<img src="<?php echo esc_url($twitter_timeline['url'][$item]) ?>">
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif;

			endfor;?>

		</div>

		<?php if($output_twitter["twitter_feed_type"] == "slider") : ?>

			<div class="tc-slider-arrows">
				<div class="tc-slider-arrow left"></div>
				<div class="tc-slider-arrow right"></div>
			</div>

		<?php endif; ?>

	</div>
</div>
<?php endif; ?>