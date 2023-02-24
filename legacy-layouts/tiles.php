<?php

/**
 * Tiles
 * 
 * Displays tile blocks, either in a grid form or in a row.
 * 
 */

$layout_options = '';

// background
include(locate_template('includes/background.php'));

//carousel row option
$style = '';
if (hush_get_theme_option_value('tiles', 'style') == 'row') {
    $style = 'row_slider';
}


?>

<div class="tiles <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('tiles'); ?> <?php echo $layout_options ?? null; ?>">
    <?php if (hush_get_theme_option_value('tiles', 'container') == true) { ?>
        <div class="container">
        <?php } ?>
        <?php
        // Links
        $links = get_sub_field('tiles');
        if ($links) :
        ?>
            <div class="tiles__links <?php echo $style; ?>">
                <?php
                // loop through all links
                foreach ($links as $link) :

                    // manual
                    $content_file = $link['custom_content'] ? 'tiles-manual' : 'tiles';

                ?>
                    <div class="tiles__links__link" <?php hush_animation(); ?>>
                        <?php get_template_part('layouts/parts/content', $content_file, ['link' => $link]); ?>
                    </div>
                <?php
                endforeach; // foreach (links)
                ?>
            </div>

        <?php
        endif; // links
        ?>
        <?php if (hush_get_theme_option_value('tiles', 'container') == true) { ?>
        </div>
    <?php } ?>
</div>