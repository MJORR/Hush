<?php

/**
 * Main Content
 * 
 * Displays a text from a wysiwyg.
 */

$layout_options = '';

// highlight
if (get_sub_field('highlight'))
    $layout_options .= ' option-highlight';

// background opacity
if (get_sub_field('add_opacity_to_background'))
    $layout_options .= ' option-background-opacity';

// read more
$readMore = get_sub_field('readmore');

// button option
$buttonLink = '';
if (hush_get_theme_option_value('main', 'button_or_link') == 'button')
    $buttonLink .= ' button';

// background
include(locate_template('includes/background.php'));
?>

<div class="main-content <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('main'); ?>  <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <div class="text <?php echo $readMore ? 'view-all' : null; ?>">
            <?php the_sub_field('content'); ?>
        </div>


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

        <?php
        // Readmore
        if ($readMore == true) :
        ?>
            <div class="read-more <?php if (hush_get_theme_option_value('main', 'button_or_link') == 'button') {
                                        echo $buttonLink;
                                        echo hush_get_theme_options('buttons');
                                    } ?>"> <?php _e('Read More', 'hush-parent'); ?></div>
        <?php
        endif; // readMore
        ?>
    </div>
</div>