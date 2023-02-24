<?php

/**
 * Testimonials
 * 
 * Displays testimonials with the option to choose a carousel, as cards or plain.
 */

$layout_options = '';

// Button
if (get_sub_field('add_button'))
    $layout_options .= " option-button";

// Opacity
if (!get_sub_field('background_opacity'))
    $layout_options .= " option-no-opacity";

// Background
if (get_sub_field('add_background_image'))
    $layout_options .= " option-image";

// Carousel Buttons
$layout_options .= " option-slick-adjust";

// Card
if (get_sub_field('display_as_cards') && !get_sub_field('display_as_carousel'))
    $layout_options .= " option-display-card";

// Per Row
if (get_sub_field('display_as_carousel') != 1 && get_sub_field('per_row'))
    $layout_options .= " option-per-row-" . get_sub_field('per_row');

//Carousel Slides
$slides_to_show = ( (get_sub_field('per_slide')) ? get_sub_field('per_slide') : 1);

$alternate_testimonial_slide = ((hush_get_theme_option_value('testimonials', 'display_alternative_block_style') == true) ? true : false);

// Bg color
$layout_options .= ' option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('bg_color')));

// Testimonials
if (get_sub_field('filter')) {
    // filter by posts
    if (get_sub_field('filter_type') == 'individual') {
        $testimonials = get_sub_field('testimonials');
    }
    // filter by category
    else {
        // posts
        $args = array(
            'post_type'     => 'testimonials',
            'orderby'       => 'date',
            'category__in'  => get_sub_field('categories'),
        );

        $testimonials = new WP_Query($args);
        $testimonials = $testimonials->posts;
    }
} else {
    // posts
    $args = array(
        'post_type' => 'testimonials',
        'orderby' => 'date',
    );

    $testimonials = new WP_Query($args);
    $testimonials = $testimonials->posts;
}

// background
include(locate_template('includes/background.php'));
?>

<div class="testimonials <?php if (get_sub_field('display_as_carousel')): ?> option-slickdots-dots <?php endif; ?> <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-background <?php echo hush_get_theme_options('testimonials'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <?php
    // Background
    if (get_sub_field('add_background_image')) :
        get_template_part('components/background', null, ['background' => get_sub_field('background'), 'overlay' => !get_sub_field('background_opacity') ? 'black' : null]);
    endif;

    ?>

    <?php if (get_sub_field('display_as_carousel') && hush_get_theme_option_value('testimonials', 'display_background_image') == true) :
        if ($testimonials) : ?>
            <div class="testimonials__gallery__backgrounds">
                <?php foreach ($testimonials as $item) : ?>
                    <div class="testimonials__gallery__background">
                        <?php get_template_part('components/background', null, ['background' => get_field('image', $item)]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
    <?php endif;
    endif; ?>

    <?php
    // Opacity
    if (get_sub_field('background_opacity')) :
        get_template_part('components/opacity', null, ['color' => get_sub_field('bg_color')]);
    endif;
    ?>

    <div class="testimonials__outer">

        <div class="testimonials__inner">

            <?php if (get_sub_field('add_title')) : ?>
                <div class="testimonials__inner__title">
                    <h3><?php the_sub_field('title'); ?></h3>
                </div>
            <?php endif; ?>

            <?php if (get_sub_field('add_intro_text')) : ?>
                <div class="testimonials__inner__content">
                    <?php the_sub_field('content'); ?>
                </div>
            <?php endif; ?>

            <?php //quote mark
            if (hush_get_theme_option_value('testimonials', 'display_quote') == true) : ?>
                <div class="testimonials__inner__quote">
                    <i class="fas fa-quote-left"></i>
                </div>
            <?php endif; ?>

            <?php
            // testimonials
            if ($testimonials) :
            ?>
                <!-- carousel option -->
                <div class="testimonials__rows <?php if (get_sub_field('display_as_carousel')) : ?> testimonials__rows__slider  <?php endif; ?>" <?php if (get_sub_field('display_as_carousel')) : ?> data-slides="<?php echo $slides_to_show; ?>" <?php endif; ?>>
                    <?php
                    foreach ($testimonials as $item) :

                    if ($alternate_testimonial_slide == false) :
                        include(locate_template('layouts/parts/testimonial-slide-default.php'));
                    else :
                        include(locate_template('layouts/parts/testimonial-slide-alt.php'));
                    endif; 

                    endforeach; // testimonials
                    ?>
                </div>
            <?php
            endif; // testimonials
            ?>

            <?php
            // Button (absolute)
            if (get_sub_field('add_button')) :
            ?>
                <div class="testimonials__inner__button">
                    <?php get_template_part('components/button', null, [
                        'button'    => get_sub_field('button'),
                        'color'     => hush_get_theme_option_value('testimonials', 'color_buttons') ? get_sub_field('bg_color') : false,
                        'invert'    => !hush_get_theme_option_value('testimonials', 'invert_buttons') ? false : true,
                    ]); ?>
                </div>
            <?php
            endif; // button
            ?>
        </div>

    </div>
</div>

<?php
if ($testimonials) :
    if (get_sub_field('display_as_carousel') && hush_get_theme_option_value('testimonials', 'carousel_thumbnails') == true) :
?>
        <div class="container">
            <div class="testimonials__gallery">
                <div class="testimonials__gallery__thumbs">
                    <?php
                    foreach ($testimonials as $item) :
                    ?>
                        <div class="testimonials__gallery__thumb">
                            <?php
                            get_template_part('components/background', null, ['background' => get_field('image', $item)]);
                            ?>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
<?php
    endif;
endif;
?>