<?php

/**
 * heading
 * 
 * Displays a heading with options to customise.
 */

$layout_options = '';

// background
if (get_sub_field('background')) {
    if (get_sub_field('background_type') == 1) {
        $layout_options .= ' layout-background-color option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour')));
    } else {
        $layout_options .= ' layout-background';
    }
} else {
    $layout_options .= ' layout-nobackground';
}

// plain title
if (get_sub_field('title_plain'))
    $layout_options .= ' option-plain';

// no title
if (!get_sub_field('show_title') && !get_sub_field('title_image'))
    $layout_options .= ' option-no-title';

// column
if (get_sub_field('column')) {
    $layout_options .= ' option-column';
}
// full width (if column = false)
else {
    if (get_sub_field('full_width'))
        $layout_options .= ' option-fullwidth';
}

// side
$layout_options .= ' option-titleside-' . get_sub_field('title_side');

// top_border
if (get_sub_field('top_border'))
    $layout_options .= ' option-bordertop';

// bottom_border
if (get_sub_field('bottom_border'))
    $layout_options .= ' option-borderbottom';


// left_right_border
if (get_sub_field('left_right_border'))
    $layout_options .= ' option-border-leftright';

// increase_content_size
if (get_sub_field('increase_content_size'))
    $layout_options .= ' option-increase-size';


// title function
$title = function () {
    $subtitle_size  = get_sub_field('title_plain') ? 'h4' : 'h3';
    $title_size     = get_sub_field('title_plain') ? 'h3' : 'h2';

    // link
    $link           = get_sub_field('link');
    $link_open      = get_sub_field('add_link') && $link ? "<a href='{$link}'>" : null;
    $link_close     = get_sub_field('add_link') && $link ? "</a>" : null;

    if (get_sub_field('show_title')) {
        // sub title
        $subtitle = get_sub_field('show_sub_title') && get_sub_field('sub_title') && hush_get_theme_option_value("heading", "subtitle") ? "<{$subtitle_size}>" . get_sub_field('sub_title') . "</{$subtitle_size}>" : false;

        return "
            {$subtitle}
            {$link_open}<{$title_size}>" . get_sub_field('title') . "</{$title_size}>{$link_close}
        ";
    }

    return "";
};


?>

<div class="heading <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('heading'); ?> <?php echo $layout_options ?? null; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <div class="heading__inner">

            <div class="heading__inner__title">
                <?php
                if (get_sub_field('title_image')) :
                    get_template_part('components/icon', null, ['icon' => get_sub_field('image')]);
                endif; // title Image

                echo $title();

                // title button
                if (hush_get_theme_option_value("heading", "title_button") == true) :

                    // button
                    $button = get_sub_field('add_button') ? get_sub_field('button') : false;

                    // Button (absolute)
                    if ($button) :
                ?>
                        <div class="heading__inner__button">
                            <?php get_template_part('components/button', null, [
                                'button'    => $button,
                            ]); ?>
                        </div>
                <?php
                    endif; // button
                endif;
                ?>
            </div>

            <?php
            // Content
            if (get_sub_field('content')) :
            ?>
                <div class="heading__inner__content">
                    <?php the_sub_field('content'); ?>
                </div>
            <?php
            endif; // content
            ?>

            <?php

            // button
            if (hush_get_theme_option_value("heading", "title_button") != true) :
                $button = get_sub_field('add_button') ? get_sub_field('button') : false;

                // Button (absolute)
                if ($button) :
            ?>
                    <div class="heading__inner__button">
                        <?php get_template_part('components/button', null, [
                            'button'    => $button,
                        ]); ?>
                    </div>
            <?php
                endif; // button
            endif;
            ?>

        </div>
    </div>
</div>