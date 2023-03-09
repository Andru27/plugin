<?php

/**
 * @since           1.0.0
 * @package         Tcard
 * @subpackage  	Tcard/public/templates
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

if(!empty($get_skins)) :
?>
<div id="tcard-group-<?php echo esc_attr($group_id) ?>" class="tcard-group tcard-group-<?php echo esc_attr($group_id) ?>">
    <div class="<?php echo esc_attr($settings["container_group"]) ?>">
    <?php if($settings["group_name"] == true) : ?>
        <div class="row">
            <div class="tcard-group-title">
               <h2><?php echo wp_specialchars_decode(stripslashes($group->title)) ?></h2> 
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php $tcardSkinsController->skinType($group_id,TCARD_FRONT_URL); ?>
    </div>
    <?php if($settings['individualGallery'] == 1) :

        for ($skin = 0; $skin < $skins_number; $skin++) :

            if(!empty($all_gallery[$skin])){
                $gallery = unserialize($all_gallery[$skin]);
            }else{
                $gallery = "";
            }
            $skin_id = $get_skins[$skin]->skin_id;
            
            if(!empty($gallery['image']) || !empty($gallery['user'])) : ?>
      
                <div class="tcg-group" data-tcg-group="group-<?php echo esc_attr($group_id.$skin); ?>">

                    <?php if($curr_user->ID == $gallery['user'] && is_user_logged_in()) : 
                            $user_gallery[$skin] = "data-user-log='login'";
                        else:
                            $user_gallery[$skin] = "";    
                        endif; ?>

                    <div class="tcg fade-in" <?php echo esc_attr($user_gallery[$skin]); ?> data-tcg-skin_id="<?php echo esc_attr($skin_id); ?>" data-tcg-open="card-<?php echo esc_attr($skin); ?>">

                        <?php if(!empty($gallery['image'])) :

                            foreach ($gallery['image'] as $key => $image) : ?>
                                <img class="tcg-item" src="<?php echo esc_url($image); ?>" alt=" ">
                            <?php endforeach;

                        endif; ?>
                        <div class="tcg-arrow tcg-left"></div>
                        <div class="tcg-arrow tcg-right"></div>
                    </div>
                    <div class="tcg-header">
                        <div class="tcg-counter">
                            <span class="tcg-current-counter"></span> / <span class="tcg-counter-all"></span>
                        </div>

                        <?php if($curr_user->ID == $gallery['user'] && is_user_logged_in()) : ?>

                            <div class="tcg-header-btn bar"><p class="tcg-upload-images"><?php _e('Upload Images','tcard') ?></p></div>
                            <div class="tcg-header-btn"><p class="tcg-delete-image"><?php _e('Delete Image','tcard') ?></p></div>

                        <?php endif;?>

                        <div class="tcg-close">
                            <span class="tcg-line"></span>
                            <span class="tcg-line"></span>
                        </div>
                    </div>

                </div>  

            <?php endif;
        
        endfor;

    else : ?>    

        <?php if(!empty($all_gallery)) : ?>

           <div class="tcg-group" data-tcg-group="group-<?php echo esc_attr($group_id); ?>">
            
                <?php for ($skin = 0; $skin < $skins_number; $skin++) :

                    if(!empty($all_gallery[$skin])){
                        $gallery = unserialize($all_gallery[$skin]);
                    }else{
                        $gallery = "";
                    }
                    $skin_id = $get_skins[$skin]->skin_id;
  
                    if(!empty($gallery['image']) || !empty($gallery['user'])) : 
                         
                        if($curr_user->ID == $gallery['user'] && is_user_logged_in()){
                            $user_gallery[$skin] = "data-user-log='login'";
                        }else{
                            $user_gallery[$skin] = "";
                        }

                        ?>
                        <div class="tcg fade-in" <?php echo esc_attr($user_gallery[$skin]); ?> data-tcg-skin_id="<?php echo esc_attr($skin_id); ?>" data-tcg-open="card-<?php echo esc_attr($skin); ?>" data-tcg-type="<?php echo esc_attr($gallery['type']); ?>" data-thumbnail="<?php echo esc_attr($gallery['thumbnail']); ?>" data-title="<?php echo esc_attr($gallery['thumbnail_title']); ?>">

                            <?php if(!empty($gallery['image'])) :

                                foreach ($gallery['image'] as $key => $image) : ?>
                                    <img class="tcg-item" src="<?php echo esc_url($image); ?>" alt=" ">
                                <?php endforeach; ?>

                            <?php endif; ?>

                            <div class="tcg-arrow tcg-left"></div>
                            <div class="tcg-arrow tcg-right"></div>

                        </div>

                    <?php endif;

                endfor; ?>

                <div class="tcg-header">
                    <div class="tcg-counter">
                        <span class="tcg-current-counter"></span> / <span class="tcg-counter-all"></span>
                    </div>

                    <?php for ($skin = 0; $skin < $skins_number; $skin++) :

                        $gallery = unserialize($all_gallery[$skin]);

                        if($curr_user->ID == $gallery['user'] && $gallery['user'] !== $gallery['user']  && is_user_logged_in()) : ?>

                            <div class="tcg-header-btn bar"><p class="tcg-upload-images"><?php _e('Upload Images','tcard') ?></p></div>
                            <div class="tcg-header-btn"><p class="tcg-delete-image"><?php _e('Delete Image','tcard') ?></p></div>

                        <?php endif;

                    endfor;?>

                    <div class="tcg-close">
                        <span class="tcg-line"></span>
                        <span class="tcg-line"></span>
                    </div>
                    <div class='tcg-toggle-sidebar'>
                        <span class='tcg-line'></span>
                        <span class='tcg-line'></span>
                        <span class='tcg-line'></span>
                        <span class='tcg-line'></span>
                    </div>
                </div>

                 <div class="tcg-sidebar">
                    <?php for ($skin = 0; $skin < $skins_number; $skin++) :

                        if(!empty($all_gallery[$skin])){
                           $user_thumbnail = unserialize($all_gallery[$skin]);
                        }else{
                            $user_thumbnail = "";
                        }
                        if(!empty($user_thumbnail['user'])){
                            $user_name = get_user_by('id', $user_thumbnail['user']);
                            $user_name = $user_name->display_name;
                        }else{
                            $user_name = "";
                        }

                        (!empty($user_thumbnail['thumbnail'])) ? $user_thumbnail['thumbnail'] : $user_thumbnail['thumbnail'] = "";
                        (!empty($user_thumbnail['thumbnail_title'])) ? $user_thumbnail['thumbnail_title'] : $user_thumbnail['thumbnail'] = "";

                        if(!empty($user_thumbnail['image'][0])) :
                            $user_bg = "style='background-image: url(".esc_url($user_thumbnail['image'][0]).");'";
                        else:
                            $user_bg = "";
                        endif;

                        if(!empty($user_bg)) : ?>
                        
                            <div class="tcg-user" data-tcg-user="card-<?php echo esc_attr($skin); ?>" <?php echo $user_bg; ?>>

                                <?php if($user_thumbnail['thumbnail'] == "thumbnail_title") : ?>
                                    <h4><?php echo esc_html($user_thumbnail['thumbnail_title']); ?></h4>
                                <?php else : ?>
                                    <h4><?php echo esc_html($user_name); ?></h4>
                                <?php endif; ?>
                            </div>

                    <?php endif;
                    endfor;?>
                </div>

            </div>
        <?php endif;
    endif; ?>
    <?php echo html_entity_decode(self::add_custom_inline_css($skin_type,$skins_number,$group_id)); ?>

    <script type="text/javascript">
        (function( $ ) {

            'use strict';

            var group = $(".tcard-group-<?php echo esc_attr($group_id) ?>");

            group.each(function () {
                $(this).find(".tcard").tcard({
                    tcardFlip: <?php echo (int)$settings['tcardFlip']; ?>,
                    tcardOn: '<?php echo (string)$settings['tcardOn']; ?>',
                    animationFront: '<?php echo (string)$settings['animationFront']; ?>',
                    animationOneTime: <?php echo (int)$settings['animationOneTime']; ?>,
                    randomColor: <?php echo (int)$settings['randomColor']; ?>,
                    durationCount: <?php echo (int)$settings['durationCount']; ?>,
                    individualGallery: <?php echo (int)$settings['individualGallery']; ?>,
                    autocomplete: <?php echo (int)$settings['autocomplete']; ?>,
                });
            });
            
        })( jQuery );
    </script>
    </div>
</div>
<?php endif; ?>