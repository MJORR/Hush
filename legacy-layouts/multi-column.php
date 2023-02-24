<?php

/**
 * Multi Column
 * 
 * option for image carousel
 * option for two image
 * option for up to 4 columns
 * 
 */

$layout_options = '';
$layout_bg = '';

// background
if (get_sub_field('background')) {
    $layout_options .= ' layout-background';
} else {
    $layout_options .= ' layout-nobackground';
}

if (get_sub_field('image_bottom')) {
    $layout_options .= ' option-image-bottom';
}

if (get_sub_field('gap_between_items')) {
    $layout_options .= ' option-item-gap';
}

$numrows = count(get_sub_field('block'));
?>

<div class="multi-column <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('multi_column'); ?> <?php echo $layout_options; ?>">

    <div class="container flex-<?php echo $numrows; ?> ">

        <?php
        if (have_rows('block')) :
            while (have_rows('block')) : the_row();

                $image_type = '';
                $image = '';
                $second_image = '';

                if (hush_get_theme_option_value('multi_column', 'image_carousel') == true && get_sub_field('add_carousel')) {
                    $image_type = "carousel";
                }

                if (hush_get_theme_option_value('multi_column', 'two_images')) {
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

        ?>

                <div class="alternative <?php if ($image_type) : ?> carousel <?php endif; ?>">
                    <div class="image <?php if ($image_type) : ?> multi_column_slider  <?php endif; ?> <?php echo $image ? 'contains-image' : null; ?> <?php echo $second_image ? 'contains-multi-image' : null; ?>">

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
                        elseif (hush_get_theme_option_value('multi_column', 'image_carousel') == true) :
                            $images = get_sub_field('carousel');
                            foreach ($images as $image) : ?>

                                <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />

                        <?php
                            endforeach; // images
                        endif; // image_carousel
                        ?>

                    </div>

                    <div class="text">

                        <?php if (hush_get_theme_option_value('multi_column', 'subtitle') == true) : ?>
                            <?php if (get_sub_field('add_subtitle')) : ?>
                                <h3><?php the_sub_field('subtitle'); ?></h3>
                            <?php endif; ?>
                        <?php endif; ?>

                        <h2>
                            <?php
                            //before heading icon
                            if (hush_get_theme_option_value('multi_column', 'before_heading_icon') == true) : ?>
                                <?php echo get_sub_field('icon'); ?>
                            <?php endif; ?>

                            <?php
                            //heading
                            the_sub_field('heading'); ?>
                        </h2>


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

        <?php
            endwhile;
        endif;
        ?>

    </div>

</div>