<?php

/**
 * Accordion
 * 
 * Displays a accordion as a drop down.
 * With an extra option of an image carousel within the accordion
 * 
 */
$layout_options = '';
$white = '';

// background
include(locate_template('includes/background.php'));

if (get_sub_field('background_type') == 1):
    $white = true;
endif;

?>

<div class="accordion <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('accordion'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">

        <?php 
        //heading option
        $heading = get_sub_field('display_heading');
        if($heading && hush_get_theme_option_value('accordion', 'display_heading') == true): ?>
            <h2><?php the_sub_field('heading'); ?></h2>
        <?php endif; ?>

        <?php
        if (have_rows('accordion')) :
            while (have_rows('accordion')) : the_row();
                // content
                $content = get_sub_field('content');

                $to_replace = ['h4', 'h3', 'h2'];
                $replace_with = ['h6', 'h5', 'h4'];

                $content = str_replace($to_replace, $replace_with, $content);
        ?>
                <div class="dropdown">
                    <div class="dropdown__top">
                        <h3>
                            <?php
                            //icon option
                            $icon = get_sub_field('display_icon');
                            if ($icon && hush_get_theme_option_value('accordion', 'display_icon') == true) :
                                the_sub_field('icon');
                            endif;

                            //normal title
                            the_sub_field('heading'); ?>
                        </h3>
                    </div>
                    <div class="dropdown__btm">
                        <div class="dropdown__btm__inner">
                            <?php echo $content; ?>

                            <!-- Button -->
                            <?php
                            if (get_sub_field('display_button')  && hush_get_theme_option_value('accordion', 'display_button') == true) :
                            ?>
                                <div class="cta__buttons">
                                    <?php
                                    foreach (get_sub_field('buttons') as $button) :
                                        get_template_part('components/button', null, [
                                            'button' => $button,
                                            'white'  => $white,
                                        ]);
                                    endforeach; // buttons
                                    ?>
                                </div>
                            <?php
                            endif; // template button
                            ?>

                            <?php
                            $images = get_sub_field('gallery');
                            if ($images && get_sub_field('image_carousel') && hush_get_theme_option_value('accordion', 'image_carousel') == true) :
                            ?>
                                <div class="accordion__gallery">
                                    <div class="accordion__gallery__main">
                                        <?php
                                        foreach ($images as $image) :
                                        ?>
                                            <div class="accordion__gallery__large">

                                                <button class="enlarge" data-target="<?php echo $image['id']; ?>">
                                                    <i aria-hidden class="far fa-search-plus" title="<?php _e('Enlarge', 'hush-parent'); ?>"></i>
                                                    <span class="sr-only"><?php _e('Enlarge', 'hush-parent'); ?></span>
                                                </button>

                                                <?php
                                                get_template_part('components/background', null, ['background' => $image['sizes']['large']]);
                                                ?>

                                                <?php if (hush_get_theme_option_value('accordion', 'captions') == true) { ?>

                                                    <?php if ($image['caption'] != '') { ?>
                                                        <div class="accordion__gallery__caption">
                                                            <p><?php echo $image['caption']; ?></p>
                                                        </div>
                                                    <?php } ?>

                                                <?php } ?>
                                            </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>

                                    <div class="accordion__gallery__thumbs">
                                        <?php
                                        foreach ($images as $image) :
                                        ?>
                                            <div class="accordion__gallery__thumb">
                                                <?php
                                                get_template_part('components/background', null, ['background' => $image['sizes']['large']]);
                                                ?>
                                            </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>

                                    <?php foreach ($images as $image) : ?>
                                        <div class="accordion__gallery__popup" data-attr="<?php echo $image['id']; ?>">
                                            <div class="accordion__gallery__popup__wrapper">
                                                <i class="fa fa-times"></i>

                                                <div class="accordion__gallery__popup__wrapper__content">
                                                    <div class="image-container">
                                                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php
                            endif; // images
                            ?>

                        </div>
                    </div>
                </div>
        <?php endwhile;
        endif; ?>
    </div>
</div>