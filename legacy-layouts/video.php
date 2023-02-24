<?php

/**
 * Video
 * 
 * 
 */


$layout_options = '';

// height
$height = get_sub_field('height');

// container
if (get_sub_field('container')) {
    $layout_options .= ' option-container';

    // padding
    if (get_sub_field('padding')) {
        $layout_options .= ' option-padding';
    }
}

// container
if (get_sub_field('rounded_corners')) {
    $layout_options .= ' option-rounded-corners';
}

// background
if (get_sub_field('background')) {
    if (get_sub_field('background_type') == 1) {
        $layout_options .= ' layout-background-color option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour')));
    } else {
        $layout_options .= ' layout-background';
    }
} else {
    if (get_sub_field('container')) {
        $layout_options .= ' layout-nobackground';
    } else {
        $layout_options .= ' layout-nobackground layout-reset';
    }
}

// background opacity
if (get_sub_field('add_opacity_to_background'))
    $layout_options .= ' option-background-opacity';


?>

<div class="video-block <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options; ?> height--<?php echo $height; ?>" <?php hush_animation(); ?>>

    <?php if (get_sub_field('title')) : ?>
        <h2><?php the_sub_field('title'); ?></h2>
    <?php endif; ?>

    <div class="video-block__inner">
        <?php
        // video
        if (get_sub_field('type') == 'video') {
            get_template_part('components/video', null, [
                'video'     => get_sub_field('video'),
                'muted'     => false,
                'autoplay'  => get_sub_field('autoplay')
            ]);
        }
        // embed
        elseif (get_sub_field('type') == 'embed') {
            the_sub_field('embed_code');
        }
        ?>
    </div>
</div>