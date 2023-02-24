<?php

/**
 * Bubbles
 * 
 * Displays a bubble (can be 3 types of shapes - circle (default), square or rectangle)
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

// rows
$layout_options .= ' option-rows-' . get_sub_field('rows');

// icons
$icons = get_sub_field('add_icon') ? true : false;

// shadow
if (get_sub_field('shadows'))
    $layout_options .= ' option-shadows';

// opacity
if (get_sub_field('opacity')){
    $layout_options .= ' option-opacity';
}

// plain
if (get_sub_field('plain')) {
    $layout_options .= ' option-plain';

    // rounded
    if (get_sub_field('rounded'))
        $layout_options .= ' option-rounded';
}

// padding
if (get_sub_field('padding')) {
    $layout_options .= ' option-padding';
}

?>

<div class="bubbles <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('bubbles'); ?> <?php echo $layout_options ?? null; ?>" <?php hush_animation(); ?>>
    <div class="container">
        <div class="bubbles__items">

            <?php if (get_sub_field('title')): ?>
                <h2><?php the_sub_field('title'); ?></h2>
            <?php endif; ?>
            <?php
            // Bubbles
            while (have_rows('bubbles')) : the_row();
                // bubble options
                $bubble_options = '';

                // colour
                $bubble_options .= ' option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('color')));

                // background image
                if (get_sub_field('background_image')) {
                    $bubble_options .= ' option-bg-image';
                }

                // button
                $button = get_sub_field('add_button') ? get_sub_field('button') : false;

                // link
                $link = get_sub_field('add_link') ? true : false;

                $add_background_image = get_sub_field('add_background_image') ? true : false;

                $image = get_sub_field('background_image');
                
            ?>
                <div class="bubbles__items__item <?php echo $bubble_options; ?>" <?php if ($add_background_image) : ?> style="background-image: url(<?php echo $image['url']; ?>);" <?php endif; ?>>
                    <div class="bubbles__items__inner">

                        <?php
                        // Link
                        if ($link) :
                        ?>

                        <a href="<?php the_sub_field('link'); ?>">
                        
                        <?php
                        endif; // Link
                        ?>

                        <?php
                        // Icons
                        if ($icons) :
                        ?>
                            <div class="bubbles__items__icons">
                                <?php
                                get_template_part('components/icon', null, [
                                    'icon'  => get_sub_field('icon'),
                                    'title' => get_sub_field('title')
                                ]);
                                ?>
                            </div>
                        <?php
                        endif; // icons
                        ?>

                        <div class="bubbles__items__title">
                            <h2><?php the_sub_field('title'); ?></h2>
                        </div>

                        <?php
                        // Text
                        $text = get_sub_field('text');
                        if ($text) :
                        ?>
                            <div class="bubbles__items__text">
                                <?php echo $text; ?>
                            </div>
                        <?php
                        endif; // text
                        ?>

                        <?php
                        // Link
                        if ($link) :
                        ?>

                        </a>
                        
                        <?php
                        endif; // Link
                        ?>

                        <?php
                        // Button (absolute) 
                        if ($button) :
                        ?>
                            <div class="bubbles__items__button">
                                <?php get_template_part('components/button', null, [
                                    'button'    => $button,
                                    'color'     => hush_get_theme_option_value('bubbles', 'primary_button') ? 'primary' : get_sub_field('color'),
                                    'invert'    => hush_get_theme_option_value('bubbles', 'primary_button') ? false : true,
                                ]); ?>
                            </div>
                        <?php
                        endif; // button
                        ?>
                    </div>

                </div>
            <?php
            endwhile; // bubbles
            ?>
        </div>
    </div>
</div>