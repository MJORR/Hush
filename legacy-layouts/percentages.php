<?php

/**
 * Percentages
 * 
 * Displays a maxiumn of 4 percentages in a row.
 * 
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

?>

<div class="percentages <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?>  <?php echo hush_get_theme_option_value('percentages', 'title_alignment'); ?> <?php if (hush_get_theme_option_value('percentages', 'background_container') != true) {
                                                                                                                                                                    echo $layout_options ?? null;
                                                                                                                                                                } ?>" <?php hush_animation(); ?>>

    <div class="container <?php if (hush_get_theme_option_value('percentages', 'background_container') == true) {
                                echo $layout_options ?? null;
                            } ?>">

        <div class="heading">
            <div class="heading__inner">
                <div class="heading__inner__title">
                    <h2><?php echo get_sub_field('header'); ?></h2>
                </div>
            </div>
        </div>

        <div class="percentages_stats <?php echo hush_get_theme_options('percentages'); ?>">
            <div class="percentages_stats_outer">

                <?php if (have_rows('percentages')) :
                    while (have_rows('percentages')) : the_row();

                        $number = get_sub_field('number');
                        $text = get_sub_field('text');
                        $colour = get_sub_field('colour'); ?>

                        <div class="percentages_stats_stat">
                            <div class="percentages_stats_inner">
                                <div class="percentages_stats_number">
                                    <span>
                                        <?php echo $number; ?>
                                    </span>

                                    <?php if (hush_get_theme_option_value('percentages', 'percentages_background_colour') == true) { ?>
                                        <?php get_template_part('components/darken', null, [
                                            'color' => $colour,
                                            'fill'  => $colour != 'Primary' ? true : false,
                                        ]); ?>
                                    <?php } ?>
                                </div>
                                <div class="percentages_stats_text"><?php echo $text; ?></div>
                            </div>
                        </div>

                <?php endwhile;
                endif; ?>

            </div>
        </div>

    </div>

</div>