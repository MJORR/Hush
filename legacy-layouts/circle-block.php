<?php

/**
 * Circle block
 * 
 * Displays a circle or square/rectangle
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

$normal_link = get_sub_field('display_normal_link');

?>

<div class="circle <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('circle'); ?> <?php echo $layout_options ?? null; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <div class="circle__items">

            <?php if (get_sub_field('title')): ?>
                <div class="circle__items__content"><?php the_sub_field('title'); ?></div>
            <?php endif; ?>
            <?php
            // circle
            while (have_rows('circle')) : the_row();
                // circle options
                $circle_options = '';

                // hover colour
                $circle_options .= ' option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('color')));

                // link
                if ($normal_link):
                    $link = get_sub_field('normal_link');
                else:
                    $link = '#' . get_sub_field('anchor_link');
                endif;

                // bg_image
                $bg_image = get_sub_field('background_image'); ?>

                <?php
                // Link
                if ($link) :
                ?>

                <a href="<?php echo $link; ?>">
                
                <?php
                endif; // Link
                ?>

                    <div class="circle__items__item" <?php if ($bg_image): ?> style="background-image: url(<?php echo $bg_image['url']; ?>);" <?php endif; ?> >
                        <div class="circle__items__item__overlay <?php echo $circle_options; ?>"></div>
                    </div>
                    <div class="circle__items__inner">

                        <div class="circle__items__title">
                            <h2><?php the_sub_field('title'); ?></h2>
                        </div>

                        <?php
                        // Text
                        $text = get_sub_field('text');
                        if ($text) :
                        ?>
                            <div class="circle__items__text">
                                <?php echo $text; ?>
                            </div>
                        <?php
                        endif; // text
                        ?>

                    </div>


                <?php
                // Link
                if ($link) :
                ?>

                </a>
                
                <?php
                endif; // Link
                ?>




            <?php
            endwhile; // circle
            ?>
        </div>
    </div>
</div>