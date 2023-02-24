<?php

/**
 * Image
 * 
 * Displays an image/s.
 * With an extra option of adding captions
 * 
 */

$layout_options = '';

if(get_sub_field('no_padding')):
    $layout_options .= 'option-no_padding ';
endif;

// background opacity
if (get_sub_field('add_opacity_to_background'))
    $layout_options .= 'option-background-opacity ';

if (hush_get_theme_option_value('image', 'imagesize_own')) :
    $layout_options .= 'option-image_size-' . get_sub_field('image_size');
else :
    $layout_options .= 'option-image_size-' . hush_get_theme_option_value('image', 'image_size');
endif;

// background
include(locate_template('includes/background.php'));

$container = hush_get_theme_option_value('image', 'background_container') == true ? hush_get_container_size(get_sub_field('container') ?? 'normal') : null;
?>

<div class="image-block <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('image'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>

    <div class="image-block-container <?php echo $container; ?>">
        <?php
        // flexible field
        if (hush_check_flexible($args) || ($is_preview ?? false)) :
            if (have_rows('images')) :
                while (have_rows('images')) : the_row();

                    $image = get_sub_field('image'); ?>

                    <div class="images" style="background-image: url('<?php echo $image['url']; ?>');">

                        <?php if (hush_get_theme_option_value('image', 'captions') == true) { ?>

                            <?php if ($image['caption'] != '') { ?>
                                <div class="image-block-caption">
                                    <p><?php echo $image['caption']; ?></p>
                                </div>
                            <?php } ?>

                        <?php } ?>
                    </div>

            <?php
                endwhile; // images
            endif;  // images

        // title image
        elseif ($args['title'] ?? false) :
            if (get_field('image')) :
                $image = get_field('image');
            else :
                $image = get_field('default_page_image', 'option');
                $image = $image['image'];
            endif;
            ?>

            <div class="images" style="background-image: url('<?php echo $image['sizes']['2048x2048']; ?>');">

                <?php if (hush_get_theme_option_value('image', 'captions') == true) { ?>

                    <?php if ($image['caption'] != '') { ?>
                        <div class="image-block-caption">
                            <p><?php echo $image['caption']; ?></p>
                        </div>
                    <?php } ?>

                <?php } ?>
            </div>
        <?php
        endif; // args
        ?>
    </div>

</div>