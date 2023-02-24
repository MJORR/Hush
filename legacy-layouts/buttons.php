<?php

/**
 * Buttons
 * 
 * Shows buttons, option for individual button colour can be set from Hush Options
 */


$layout_options = '';

// button type
$button_type = get_sub_field('banner_button_type');
if ($button_type == 'arrow') {
    $layout_options .= " option-button-arrow";
    $layout_options .= " option-buttonCols-" . get_sub_field('banner_buttons_per_line');
}

// colours
$custom_colours = hush_get_theme_option_value('buttonslayout', 'custom_colours') && $button_type == 'button' ? true : false;

// background
include(locate_template('includes/background.php'));

// alignment
$layout_options .= " option-alignment-" . get_sub_field('alignment');
?>

<div class="buttons <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('buttonslayout'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="container">
        <div class="buttons__all">
            <?php
            // buttons
            foreach (get_sub_field('buttons') as $button) :
                // output button
                get_template_part('components/' . $button_type, null, [
                    'button'    => $button,
                    'color'     => $custom_colours == true ? $button['color'] : false,
                ]);
            endforeach; // buttons
            ?>
        </div>
    </div>
</div>