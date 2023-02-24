<?php

/**
 * Narrow
 * 
 * Displays a now div with an image.
 * Option of image, icon and carousel
 */

$layout_options = '';
$layout_bg = '';

// background

if (hush_get_theme_option_value('narrow', 'overlapping_text') == true) {

    if (get_sub_field('background')) {
        $layout_bg .= ' layout-background';
    }

    $layout_options .= ' layout-nobackground';
} else {
    if (get_sub_field('background')) {
        $layout_options .= ' layout-background';
    } else {
        $layout_options .= ' layout-nobackground';
    }
}

// border
if (get_sub_field('border'))
    $layout_options .= ' option-border';


// overlap
if (get_sub_field('add_text_overlap'))
    $layout_options .= ' option-overlapping';


$overlap = get_sub_field('add_text_overlap');

// start side
$layout_options .= ' option-start-' . get_sub_field('start');
?>

<div class="narrow <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('narrow'); ?> <?php echo $layout_options; ?>">


    <?php if ($overlap != '1') {  ?>
        <div class="container">
        <?php } ?>

        <?php
        if (have_rows('block')) :
            while (have_rows('block')) : the_row();
                $image_type = get_sub_field('image_type');

                // image
                $icon = false;
                $image = '';
                $second_image = '';

                if (hush_get_theme_option_value('narrow', 'image_carousel') == true && get_sub_field('add_carousel')) {
                    $image_type = "carousel";
                }


                if ($image_type == 'image') {
                    // get right image
                    if (hush_get_theme_option_value('narrow', 'square_images')) {
                        $image = get_sub_field('image_square');
                    } elseif (hush_get_theme_option_value('narrow', 'two_images')) {
                        $image = get_sub_field('image');
                        $second_image = get_sub_field('second_image');
                    } else {
                        $image = get_sub_field('image');
                    }

                    // image
                    $image_alt = $image['title'] ?? null;
                    $second_image_alt = $second_image['title'] ?? null;
                    $image = $image['sizes']['large'] ?? null;
                    $second_image = $second_image['sizes']['large'] ?? null;
                }
                // icon
                elseif ($image_type == 'icon') {
                    $icon = get_sub_field('icon');
                    $image = false;
                } ?>


                <?php if ($overlap == '1') {  ?>
                    <div class="overlapping-narrow-container">

                        <?php if ($layout_bg != '') { ?>
                            <div class="<?php echo $layout_bg; ?>"></div>
                        <?php } ?>

                        <div class="container">
                        <?php } ?>



                        <div class="alternative <?php if ($image_type == 'carousel') : ?> carousel <?php endif; ?>">
                            <div class="image <?php if ($image_type == 'carousel') : ?> <?php if ($overlap == '1') { ?> narrow_overlapping_slider <?php } else { ?> narrow_slider <?php } ?>   <?php endif; ?> <?php echo $image ? 'contains-image' : null; ?> <?php echo $second_image ? 'contains-multi-image' : null; ?>">

                                <?php
                                if ($image && $second_image ?? false) :
                                ?>
                                    <img src="<?php echo $image; ?>" alt="<?php echo $image_alt; ?>">
                                    <img src="<?php echo $second_image; ?>" alt="<?php echo $second_image_alt; ?>">

                                <?php
                                elseif ($image ?? false) :
                                ?>
                                    <img src="<?php echo $image; ?>" alt="<?php echo $image_alt; ?>">

                                <?php
                                elseif ($image_type == 'carousel') :
                                ?>
                                    <?php
                                    if (hush_get_theme_option_value('narrow', 'image_carousel') == true) :
                                        $images = get_sub_field('carousel');
                                        foreach ($images as $image) :
                                    ?>

                                            <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />

                                    <?php
                                        endforeach; // images
                                    endif; // image_carousel
                                    ?>
                                <?php
                                else :
                                    echo $icon;
                                endif;
                                ?>
                            </div>

                            <div class="text">

                                <?php if (get_sub_field('add_subtitle')) : ?>
                                    <h3><?php the_sub_field('subtitle'); ?></h3>
                                <?php endif; ?>

                                <?php if (!get_sub_field('hide_title')) : ?>
                                    <h2><?php the_sub_field('heading'); ?></h2>
                                <?php endif; ?>

                                <?php the_sub_field('content'); ?>

                                <!-- Button -->
                                <?php
                                if (get_sub_field('add_buttons')) :
                                ?>
                                    <div class="cta__buttons">
                                        <?php
                                        foreach (get_sub_field('buttons') as $button) :
                                            get_template_part('components/button', null, [
                                                'button' => $button,
                                            ]);
                                        endforeach; // buttons
                                        ?>
                                    </div>
                                <?php
                                endif; // template button
                                ?>
                            </div>
                        </div>

                        <?php if ($overlap == '1') {  ?>

                        </div>

                    </div>

                <?php } ?>
        <?php
            endwhile;
        endif;
        ?>
        <?php if ($overlap != '1') {  ?>
        </div>
    <?php } ?>
</div>