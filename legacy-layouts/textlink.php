<?php

/**
 * Text Link
 * 
 * Displays text links that link to specific pages on the site and gets the title, text etc from the page/post. Can also be set manually.
 */

$layout_options = '';

// background
if (get_sub_field('background')) {
    $layout_options .= ' layout-background';
} else {
    $layout_options .= ' layout-nobackground';
}

// items_per_line
$layout_options .= ' option-items_per_line-' . get_sub_field('items_per_line');

if (hush_get_theme_option_value('textlink', 'linktype') == 'arrow' && hush_get_theme_option_value('textlink', 'link_line'))
    $layout_options .= ' option-link_line';

?>

<div class="textlink <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('textlink'); ?> <?php echo $layout_options ?? null; ?>">
    <div class="container">

        <?php 
        //heading option
        $heading = get_sub_field('display_heading');
        if($heading && hush_get_theme_option_value('textlink', 'display_heading') == true): ?>
            <h2><?php the_sub_field('heading'); ?></h2>
        <?php endif; ?>

        <?php
        // Links
        $links = get_sub_field('links');
        if ($links) :
        ?>
            <div class="textlink__links">
                <?php
                // loop through all links
                foreach ($links as $link) :

                    // manual
                    $content_file = $link['manual'] ? 'textlink-manual' : 'textlink';

                ?>
                    <div class="textlink__links__link" <?php hush_animation(); ?>>
                        <?php get_template_part('layouts/parts/content', $content_file, ['link' => $link]); ?>
                    </div>
                <?php
                endforeach; // foreach (links)
                ?>
            </div>

        <?php
        endif; // links
        ?>
    </div>
</div>