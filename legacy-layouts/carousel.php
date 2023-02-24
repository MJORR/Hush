<?php

/**
 * Carousel
 * 
 * Displays carousel 
 * 
 */

hush_webpack_add_file("posts");

$layout_options = '';

// background
include(locate_template('includes/background.php'));

// cols
$starting_flex = number_format((100 / get_sub_field('cols')), 2, '.', '');
?>

<div class="carousel <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> posts--slick <?php echo $layout_options ?? null; ?> <?php echo hush_get_theme_options('carousel'); ?>" <?php hush_animation(); ?> data-display="<?php echo get_sub_field('cols'); ?>">
    <div class="container">
        <div class="posts__links carousel__items">
            <?php
            // Items
            while (have_rows('items')) : the_row();
            ?>
                <div class="carousel__item" style="<?php echo 'flex: ' . $starting_flex . '% 0 0;'; ?>">
                    <div class="carousel__item__picture">
                        <?php
                        get_template_part('components/background', null, [
                            'background'    => get_sub_field('image')
                        ]);
                        ?>
                    </div>

                    <h3><?php the_sub_field("title"); ?></h3>

                    <?php the_sub_field('content'); ?>
                </div>
            <?php
            endwhile; // items
            ?>
        </div>
    </div>
</div>