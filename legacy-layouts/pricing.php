<?php

/**
 * Pricing
 * 
 * Displays a repeater field with the option of an extra repeater field to display a list
 * 
 */
?>

<div class="pricing <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-nobackground <?php echo hush_get_theme_options('pricing'); ?> " <?php hush_animation(); ?>>
    <div class="container">

        <div class="text <?php if (hush_get_theme_option_value('pricing', 'most_popular') == true) {
                                echo 'most_popular';
                            } ?>">
            <div class="text-container">
                <?php if (get_sub_field('heading') != '') { ?>
                    <h2><?php the_sub_field('heading'); ?></h2>
                <?php } ?>
                <?php the_sub_field('content'); ?>
            </div>
        </div>

        <?php
        if (have_rows('block')) :
            while (have_rows('block')) : the_row(); ?>

                <?php $mostPopular = get_sub_field('most_popular_price'); ?>
                <div class="block <?php if (hush_get_theme_option_value('pricing', 'most_popular') == true) {
                                        if ($mostPopular == '1') {
                                            echo 'most_popular';
                                        }
                                    } ?>">
                    <div class="block__content">
                        <div class="block__content_heading">
                            <h3><?php the_sub_field('heading'); ?></h3>
                        </div>

                        <div class="block__content_container">
                            <?php if (hush_get_theme_option_value('pricing', 'pricemonth_separate') == true) : ?>
                                <h4><?php the_sub_field('price'); ?></h4>
                                <p><?php the_sub_field('per_monthyear'); ?></p>
                            <?php else : ?>
                                <h4><?php the_sub_field('price'); ?><?php the_sub_field('per_monthyear'); ?></h4>
                            <?php endif; ?>

                            <?php the_sub_field('extra_information'); ?>
                        </div>
                    </div>

                    <?php if (have_rows('list')) : ?>
                        <div class="block__list">
                            <?php while (have_rows('list')) : the_row();

                                $icon = get_sub_field('icon');
                                $points = get_sub_field('points');
                            ?>
                                <div><?php echo $icon; ?> <?php echo $points; ?></div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <?php

                    $button = get_sub_field('add_button') ? get_sub_field('button') : false;

                    if ($button) :
                    ?>
                        <div class="block__button">
                            <?php get_template_part('components/button', null, [
                                'button'    => $button,
                            ]); ?>
                        </div>
                    <?php
                    endif;
                    ?>

                </div>
        <?php endwhile;
        endif; ?>
    </div>
</div>