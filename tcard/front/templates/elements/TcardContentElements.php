<?php

/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/public/templates/elements
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

if($element == "skills") : ?>

<div class="tcard-skills <?php echo $output[$element]. " ". $output['tc_col'] ?>">
	<div class="tcard-skills-container">
	<?php $skill_animation = $animations->get_animations($output['animation_in'],$output['animation_out']);

	if($output["skills_number"] == "percent") :
		$prt = "%"; 
	 else :
		$prt = ""; 
	endif;

	for ($i = 0; $i < $skills_number[$skin][$side][$elemNumber]; $i++) : 

		(!empty($output['skill_percent'][$i])) ? $output['skill_percent'][$i] : $output['skill_percent'][$i] = "";
    	(!empty($output['skill'][$i])) ? $output['skill'][$i] : $output['skill'][$i] = "";

		if($output[$element] == "bar") : ?>

		<div class="skill-item" <?php echo $skill_animation. " " .$animations->get_delay($output['delay']); ?>>
	        <h3 class="skill-title"><?php echo stripslashes($output['skill'][$i]); ?></h3>
	        <div class="tcard-skill-point" data-number="<?php echo $output['skill_percent'][$i] ?>">
	            <div class="tcard-progress-bar">
	                <div class="tcard-bar"></div>
	            </div>
	            <?php if($skin_type == "skin_1") : ?>
	           	 	<span class="count"></span> / <span>1000</span>
	        	<?php else : ?>	
	        		<div class="skill_percent"><span class="count"></span><?php echo $prt; ?></div>
	        	<?php endif; ?>	
	        </div>
    	</div> 

    	<?php else :?>
    	<div class="skill-item" <?php echo $skill_animation. " " .$animations->get_delay($output['delay']); ?>>
	        <h5 class="skill-title"><?php echo stripslashes($output['skill'][$i]); ?></h5>
	        <div class="tcard-skill-point" data-number="<?php echo $output['skill_percent'][$i] ?>">
	            <svg id="svg">
	            <circle class="circle-progress" r="25" cx="30" cy="30" transform="rotate(-90, 30, 30)"></circle>
	            </svg>
	            <div class="skill_percent"><span class="count"></span><?php echo $prt; ?></div>
	        </div>
	    </div> 

   		<?php endif;

	endfor; ?>
	</div>
</div>

<?php elseif($element == "info") : ?>

<div class="content-info <?php echo $output['tc_col']; ?>">

	<?php if(!empty($output["info_title"])) : ?>
    	<h3 <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo $output["info_title"] ?></h3>
	<?php endif; ?>

	<?php if(!empty($output[$element])) : ?>
    	<div <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>><?php echo $output[$element] ?></div>
    <?php endif; ?>

</div>

<?php elseif($element == "item") : ?>

<div class="tcard-content-item <?php echo $output['tc_col']; ?>">

	<?php $item_animation = $animations->get_animations($output['animation_in'],$output['animation_out']);
	if(!empty($output[$element])) :

		foreach ($output[$element] as $key => $value) : 

			if($skin_type == "skin_6" && $side == "back"){
				$tag = $key + 3;
			}else{
				$tag = $key + 2;
			}

		?>
		<h<?php echo $tag; ?> <?php echo $item_animation. " " .$animations->get_delay($output['delay']); ?>><?php echo stripslashes($output[$element][$key]) ?></h<?php echo $tag; ?>>

		<?php endforeach;

	endif; ?>
</div>

<?php elseif($element === "ellipsis_text") : 
(!empty($output[$element])) ? $output[$element] : $output[$element] = "";
?>
<div class="tcard-ellipsis_text <?php echo $output['tc_col']; ?>" data-text="ellipsis" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>
	<?php echo $output[$element] ?>
</div>

<?php elseif($element === "profile") : 

	(!empty($output['profile'])) ? $output['profile'] : $output['profile'] = "";
?>

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

<?php elseif($element === "list") : ?>

<?php $list_animations = $animations->get_animations($output['animation_in'],$output['animation_out']); ?>

<ul class="tcard-list <?php echo $output['tc_col'] ?>">
	<?php for ($i = 0; $i < $list_number[$skin][$side][$elemNumber]; $i++) : ?>

   	 	<li <?php echo $list_animations. " " .$animations->get_delay($output['delay']); ?>><?php echo stripslashes($output[$element][$i]) ?></li>

    <?php endfor; ?>
</ul>

<?php elseif($element === "contact" || $element === "register") : ?>

	<?php if($element === "register"){

			$registration_validation = TcardForms::registration_validation($group_id,$side,$skin);

			if ( !empty( $registration_validation ) ) {
				$reg_errors = $registration_validation;
			}else{
				TcardForms::registration($group_id,$side,$skin);
			}
			if(empty($output["register_button"])){
				$submit_button = __( 'Create account', 'tcard' );
			}else{
				$submit_button = $output["register_button"];
			}
		}else{
                        
			if(empty($output["contact_button"])){
				$submit_button = __( 'Send Message', 'tcard' );
			}else{
				$submit_button = $output["contact_button"];
			}
		}

	$form_animations = $animations->get_animations($output['animation_in'],$output['animation_out']);

	if(!empty($reg_errors)) :?>
		<div class="tcard-errors <?php echo $element ?>">
			<div class="tc-close-errors">X</div>
	  			<?php foreach ($reg_errors as $key => $error) :?>
	  				<p> <span class="tc-line-error">-</span> <?php echo $error; ?> </p>
	  			<?php endforeach; ?>
	  	</div>
	<?php endif;?>
		<form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="post" class="tcard-form <?php echo $element. " " .$output['tc_col'] ?>" id="tcard-<?php echo $element.$group_id.$side.$skin ?>" data-group_id="<?php echo $group_id ?>" autocomplete="off">

			<?php if(!empty($output[$element])) : 
					$count = 0;
				    foreach ($output[$element] as $key => $contact_item) : 

					  	if($contact_item == "full name" || $contact_item == "first name" || $contact_item == "last name") :
						 	$icon_item = '<i class="fas fa-user"></i>';
						elseif($contact_item == "username") :
							$icon_item = '<i class="fas fa-user-plus"></i>';
						elseif($contact_item == "message") :
							$icon_item = '<i class="fas fa-envelope-open"></i>';
						elseif($contact_item == "email") :
							$icon_item = '<i class="fas fa-envelope"></i>';
						elseif($contact_item == "phone") :
							$icon_item = '<i class="fas fa-phone"></i>';
						elseif($contact_item == "company") :
							$icon_item = '<i class="fas fa-building"></i>';
						elseif($contact_item == "password") :
							$icon_item = '<i class="fas fa-unlock-alt"></i>';
						elseif($contact_item == "repeat password") :
							$icon_item = '<i class="fas fa-lock"></i>';
						elseif($contact_item == "nickname") :
							$icon_item = '<i class="fas fa-user-tag"></i>';
						elseif($contact_item == "website") :
							$icon_item = '<i class="fas fa-globe"></i>';
						elseif($contact_item == "subject") :
							$icon_item = '<i class="far fa-edit"></i>';	
						elseif($contact_item == "description") :
							$icon_item = '<i class="fas fa-file-alt"></i>';
						endif;

					$nameInput = str_replace(" ","_",$contact_item);

					if(!empty($output['register_item'][$key])){
						$labelName = $output['register_item'][$key];
					}
					elseif(!empty($output['contact_item'][$key])){
						$labelName = $output['contact_item'][$key];
					}
					else{
						$labelName = $contact_item;
					}
					if($contact_item !== "message"){
						$count++;
						$InputNum = $count - 1;
					}
					if($contact_item == "message" || $contact_item == "description") : ?>

						<div class="tcard-form-item message" <?php echo $form_animations. " " .$animations->get_delay($output['delay']); ?>>
						    <div class="tcard-icon">
						        <?php echo $icon_item; ?>
						    </div>
						    <label><?php echo $contact_item; ?></label>
						    <textarea class="tcard-<?php echo esc_attr($nameInput) ?>" data-field="<?php echo esc_attr($nameInput) ?>" name="<?php echo "tcard_".$nameInput.$group_id.$side.$skin; ?>"></textarea>
						</div>

					<?php else : ?>
						<div class="tcard-form-item" <?php echo $form_animations. " " .$animations->get_delay($output['delay']); ?>>
						    <div class="tcard-icon">
						        <?php echo $icon_item; ?>
						    </div>
						    <label><?php echo stripslashes($labelName); ?></label>
						    <?php if($contact_item == "password" || $contact_item == "repeat password"){
						    	$type_input = "password";
						    }else{
						    	$type_input = "text";
						    } 
						    ?>
						    <input class="tcard-<?php echo esc_attr($nameInput) ?>" data-field="<?php echo esc_attr($nameInput.$InputNum) ?>" type="<?php echo esc_attr($type_input); ?>" name="<?php echo "tcard_".$nameInput.$group_id.$side.$skin; ?>">
						</div>
					<?php endif; ?>

				<?php endforeach; ?>
			<?php endif; ?>
			<div class="tcard-submit">
				<input class="tc-form-button <?php echo esc_attr($element) ?>" type="submit" name="tcard-submit" value="<?php echo esc_attr(stripslashes($submit_button)) ?>">
			</div>
			<?php wp_nonce_field( "tcard_".$element.$group_id.$side.$skin ."_action", "tcard_".$element.$group_id.$side.$skin ."_nonce" )?>
		</form>  
<?php elseif($element == "login") :

	if ( is_user_logged_in() ) :

		if(empty($output["msjafter_login"])){
			$output["msjafter_login"] = __( 'Hello','tcard' );
		}

		if(empty($output['logout_login'])){
			$output['logout_login'] = __( 'Logout','tcard' );;
		} 

   		$current_user = wp_get_current_user();
   		(!empty($output['login_display_title'][0])) ? $output['login_display_title'][0] : $output['login_display_title'][0] = "";
	   	if($output['login_display_title'][0] == 1) : ?>

			<div class="tc-login_display_title after_log">
		  		<h2><?php echo $output[$element][0]; ?></h2>
		  	</div>

		<?php endif; ?>

		<div class="tcard-login">
			<h2 class="tcard-login-title"><?php echo esc_html( $output["msjafter_login"] ). " " .$current_user->user_login ?></h2>
			<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php echo esc_attr( $output['logout_login'] ); ?>">
				<?php echo esc_html( $output['logout_login'] ); ?>
			</a>
		</div>

		<?php if(!empty($output['after_login'])) : ?>
		<ul class="tcard-list tcard-login-profile">

			<?php foreach ($output['after_login'] as $value => $option) :
				if(!empty($current_user->$option)) : 
					if($option == "user_url") : ?>
						<li><a href="<?php echo esc_url( $current_user->$option ) ?>"><?php echo esc_html( $current_user->$option ) ?></a></li>
					<?php else: ?>
						<li><?php echo esc_html( $current_user->$option ) ?> </li>
					<?php endif;
				endif;
			endforeach; ?>

		</ul>
		<?php endif; ?>

	<?php else :

		if ( isset( $_REQUEST['login'] ) ) {
		    $errors = explode( ',', $_REQUEST['login'] );
		    foreach ( $errors as $error ) {
		    	if(isset($_REQUEST['username'])){
		    		$username = trim($_REQUEST['username'] );
		    	}
		        $all_errors[] = TcardForms::get_error_message_login($error,$username);
		    }
		}
		
		(!empty($output[$element][0])) ? $output[$element][0] : $output[$element][0] = "";
	  	(empty($output[$element][1]) ? $output[$element][1] = __( 'Username', 'tcard' ) 	: $output[$element][1]);
	  	(empty($output[$element][2]) ? $output[$element][2] = __( 'Password', 'tcard' ) 	: $output[$element][2]);
	  	(empty($output[$element][3]) ? $output[$element][3] = __( 'Login', 'tcard' ) 		: $output[$element][3]);
	  	(empty($output[$element][4]) ? $output[$element][4] = __( 'Remember me', 'tcard' ) 	: $output[$element][4]); ?>

	  	<?php if(!empty($all_errors)) :?>
			<div class="tcard-errors <?php echo $element ?>">
				<div class="tc-close-errors">X</div>
		  			<?php foreach ($all_errors as $key => $error) :?>
		  				<p> <span class="tc-line-error">-</span> <?php echo $error; ?> </p>
		  			<?php endforeach; ?>
		  	</div>
	  	<?php endif;?>
	  	<div class="tc-login_display_title before_log">
	  		<h2><?php echo $output[$element][0]; ?></h2>
	  	</div>
		<form class="tcard-form <?php echo $element. " " .$output['tc_col'] ?>" method="post" action="<?php bloginfo('url') ?>/wp-login.php"" autocomplete="off">
		    <div class="tcard-form-item">
		        <div class="tcard-icon">
		            <i class="fas fa-user"></i>
		        </div>
		        <label for="user_login<?php echo $group_id.$side.$skin ?>"><?php echo $output[$element][1]; ?></label>
		        <input id="user_login<?php echo $group_id.$side.$skin ?>" type="text" name="log">
		    </div>
		    <div class="tcard-form-item psw">
		        <div class="tcard-icon">
		           <i class="fas fa-unlock-alt"></i>
		        </div>
		        <label for="user_pass<?php echo $group_id.$side.$skin ?>"><?php echo $output[$element][2]; ?></label>
		        <input id="user_pass<?php echo $group_id.$side.$skin ?>" type="password" name="pwd">
		    </div>
		    <div class="tcard-form-item remember">
		        <label for="<?php echo $element.$elemNumber.$group_id.$side.$skin ?>rememberme"><?php echo $output[$element][4]; ?></label>
		        <div>
		            <input type="checkbox" name="rememberme" value="forever" id="<?php echo $element.$elemNumber.$group_id.$side.$skin ?>rememberme">
		            <label for="<?php echo $element.$elemNumber.$group_id.$side.$skin ?>rememberme" class="tocheck"></label>
		        </div>
		    </div>
		    <div class="tcard-submit">
		        <input class="tc-form-button" type="hidden" name="redirect_to" value="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>">
		        <input class="tc-form-button" type="submit" name="tcard-submit" value="<?php echo $output[$element][3]; ?>" />
		    </div>
		   <?php wp_nonce_field( "tcard_login_action", "tcard_login_nonce" ); ?>
		</form>

	<?php endif; ?>

<?php elseif($element === "address") : ?>

<div class="tcard-address <?php echo $output['tc_col'] ?>">
	<ul class="tcard-list <?php echo $element ?>" <?php echo $animations->get_animations($output['animation_in'],$output['animation_out']). " " .$animations->get_delay($output['delay']); ?>>

		<?php if(!empty($output[$element])) : ?>
		    <li>
		        <div class="tcard-icon address-icon">
		            <i class="fas fa-map-marker-alt"></i>
		        </div>
		       	<div class="address"><?php echo $output[$element] ?></div>
		    </li>
		<?php endif; ?>

		<?php if(!empty($output['address_email'])) : ?>
	    <li>
	        <div class="tcard-icon email-icon">
	            <i class="fas fa-envelope"></i>
	        </div>
	        <div class="address_email"><?php echo $output['address_email'] ?></div>
	    </li>
	    <?php endif; ?>

	    <?php (!empty($output['address_phone'][0])) ? $output['address_phone'][0] : $output['address_phone'][0] = "";
	    (!empty($output['address_phone'][1])) ? $output['address_phone'][1] : $output['address_phone'][1] = "";
	    if( !empty($output['address_phone'][0]) || $output['address_phone'][1] ) : ?>
	    <li>
	        <div class="tcard-icon phone-icon">
	            <i class="fas fa-phone"></i>
	        </div>

	        <?php if(!empty($output['address_phone'][0])) : ?>
	        	<div class="address_phone"><?php echo $output['address_phone'][0] ?></div>
	        <?php endif; ?>

	        <?php if(!empty($output['address_phone'][1])) : ?>
	        	<div class="address_phone"><?php echo $output['address_phone'][1] ?></div>
	        <?php endif; ?>

	    </li>
	    <?php endif; ?>
	</ul>
</div>

<?php elseif($element === "slider") : ?>

<div class="tcard-slider <?php echo $output['tc_col'] ?>">
	<div class="tcs-inner cubictime">

		<?php if(!empty($output['slider_items_order'])) :

			for ($slider_item = 0; $slider_item < count($output['slider_items_order']); $slider_item++) : 

				($slider_item == 0) ? $active = "active" : $active = "";?>

				<div class="tcs-item <?php echo $active ?>">
					<div class="tcs-item-inner">

						<?php if(!empty($output["slider_item_title"][$slider_item])) : ?>
							<div class="tcs-title">
								<h3><?php echo stripslashes($output["slider_item_title"][$slider_item]) ?></h3>
							</div>
						<?php endif; ?>

						<?php if(!empty($output["slider"][$slider_item])) : ?>
							<div class="tcs-info">
								<?php echo html_entity_decode(stripslashes( $output["slider"][$slider_item])) ?>
							</div>
						<?php endif; ?>

						<?php if(!empty($output["slider_btntext"][$slider_item])) : ?>

							<a class="tcs-button" target="_blank" href="<?php echo esc_url($output["slider_btnlink"][$slider_item]) ?>"><?php echo stripslashes($output["slider_btntext"][$slider_item]) ?></a>

						<?php endif; ?>

					</div>
				</div>
			<?php endfor;

		endif;?>

	</div>

	<div class="tc-slider-arrow left"></div>
	<div class="tc-slider-arrow right"></div>

</div>

<?php elseif($element === "twitter_profile" || $element === "twitter_feed") : ?>
	
	<?php require TCARD_FRONT_URL . "templates/elements/TcardSocialElements.php"; ?>

<?php elseif($element === "tcard_post" ) : 
	
	$args = array(
		'posts_per_page'   => $this->group->skins_number,
		'category_name'    => $settings["category_name"],
		'orderby'          => $settings['orderby_category'],
		'order'            => $settings['order_category'],
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts = get_posts( $args );

	if(!empty($output['tcard_post']) && !empty($posts[$skin]->ID)) : ?>

		<div class="tcard-post <?php echo $output['tc_col'] ?>">

			<?php foreach ($output['tcard_post'] as $key => $post_col) : ?>

				<div class="tcard_post_item <?php echo "tcard_post-".$post_col ?>">
					<?php if($post_col == "title") : 

						if(!empty($output['tcard_post_title']) && $output['tcard_post_title'] !== 0) :

							$tcard_post_content = explode(' ', get_the_title($posts[$skin]->ID));

							if(!empty($tcard_post_content)){
								$count_words = count($tcard_post_content);
							}

							$content_words = array();?>
							<h3>
								<?php for ($i=0; $i < $output['tcard_post_title'] ; $i++) {
									
									if($i == $output['tcard_post_title'] - 1){
										if($count_words > $output['tcard_post_title']){
											if(!empty($tcard_post_content[$i]))
												$content_words[$i] = $tcard_post_content[$i] . "...";
										}
									}else{
										if(!empty($tcard_post_content[$i])){
											$content_words[$i] = $tcard_post_content[$i] . " ";
										}else{
											$content_words[$i] = "";
										}
									}
									if(!empty($content_words[$i]))
									echo html_entity_decode($content_words[$i]);
								}?>
							</h3>
						<?php else:?>
							<h3><?php echo get_the_title($posts[$skin]->ID); ?></h3>
						<?php endif; ?>

					<?php elseif($post_col == "content") : 

							(!empty($output['tcard_post_content'])) ? $output['tcard_post_content'] : $output['tcard_post_content'] = 17;

							$tcard_post_content = explode(' ', html_entity_decode($posts[$skin]->post_content));

							if(!empty($tcard_post_content)){
								$count_words = count($tcard_post_content);
							}

							$content_words = array();

							for ($i=0; $i < $output['tcard_post_content'] ; $i++) {
								
								if($i == $output['tcard_post_content'] - 1){
									if($count_words > $output['tcard_post_content']){
										if(!empty($tcard_post_content[$i]))
										$content_words[$i] = $tcard_post_content[$i] . "...";
									}
								}else{
									if(!empty($tcard_post_content[$i])){
										$content_words[$i] = $tcard_post_content[$i] . " ";
									}else{
										$content_words[$i] = "";
									}
									
								}
								if(!empty($content_words[$i]))
								echo html_entity_decode($content_words[$i]);
							}

					elseif($post_col == "comment_count") :
						(!empty($output['tcard_post_comment_count'])) ? $output['tcard_post_comment_count'] : $output['tcard_post_comment_count'] = "";
						if($output['tcard_post_comment_count'] == 'comment_count_post_text'){
							echo $output['tcard_post_comment_count_text'] . " " . get_comments_number( $posts[$skin]->ID );
						}elseif($output['tcard_post_comment_count'] == 'comment_count_post_icon'){
							echo '<i class="fas fa-comments"></i>' . " " . get_comments_number( $posts[$skin]->ID );
						}else{
							echo get_comments_number( $posts[$skin]->ID );
						}

					elseif($post_col == "date") :
						(!empty($output['tcard_post_date'])) ? $output['tcard_post_date'] : $output['tcard_post_date'] = "";
						if($output['tcard_post_date'] == 'date_post_text'){
							echo $output['tcard_post_date_text'] . " " . get_the_date( "j.m.Y", $posts[$skin]->ID );
						}elseif($output['tcard_post_date'] == 'date_post_icon'){
							echo '<i class="fas fa-calendar-alt"></i>' . " " . get_the_date( "j.m.Y", $posts[$skin]->ID );
						}else{
							echo get_the_date( "j.m.Y", $posts[$skin]->ID );
						}

					elseif($post_col == "post_button") : ?>  

						<a href="<?php echo get_permalink($posts[$skin]->ID); ?>"><?php echo $output['tcard_post_post_button']; ?></a>

					<?php elseif($post_col == "author") :
						(!empty($output['tcard_post_author'])) ? $output['tcard_post_author'] : $output['tcard_post_author'] = "";
						if($output['tcard_post_author'] == 'author_post_text'){
							echo $output['tcard_post_author_text'] . " " . get_the_author_meta('display_name',$posts[$skin]->post_author);
						}elseif($output['tcard_post_author'] == 'author_post_icon'){
							echo '<i class="fas fa-user-tag"></i>' . " " . get_the_author_meta('display_name',$posts[$skin]->post_author);
						}else{
							echo get_the_author_meta('display_name',$posts[$skin]->post_author);
						}

					elseif($post_col == "featured_image") : ?>

						<img src="<?php echo get_the_post_thumbnail_url($posts[$skin]->ID, 'large'); ?>" />

					<?php elseif($post_col == "show_category") :
						(!empty($output['tcard_post_show_category'])) ? $output['tcard_post_show_category'] : $output['tcard_post_show_category'] = "";
						if($output['tcard_post_show_category'] == 'show_category_post_text'){
							echo $output['tcard_post_show_category_text'] . " ";
							echo the_category( ', ' , '' , $posts[$skin]->ID );
						}elseif($output['tcard_post_show_category'] == 'show_category_post_icon'){
							echo '<i class="fas fa-folder-open"></i>' . " ";
							echo the_category( ', ' , '' , $posts[$skin]->ID );
						}else{
							echo the_category( ', ' , '' , $posts[$skin]->ID );
						}

					 endif;?>	

				</div>

			<?php endforeach; ?>

		</div>

	<?php endif;

endif; ?>