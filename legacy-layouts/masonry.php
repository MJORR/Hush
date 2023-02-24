<?php

/**
 * Masonry Block
 * 
 * Displays category information or custom content can be added.
 */

$layout_options = '';

// background
include(locate_template('includes/background.php'));

?>

<div class="masonry <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('masonry'); ?> <?php echo $layout_options ?? null; ?>">
    <div class="container">
        <?php
        // Links
        $links = get_sub_field('masonry');
        if ($links) :
        ?>
            <div class="masonry__links">
                <?php
                // loop through all links
                foreach ($links as $link) :

                    // manual
                    $content_file = $link['custom_content'] ? 'masonry-manual' : 'masonry'; ?>

                    <div class="masonry__links__link" <?php hush_animation(); ?>>
                        <?php get_template_part('layouts/parts/content', $content_file, ['link' => $link]); ?>
                    </div>

                <?php
                endforeach; // foreach (links)
                ?>
            </div>

            <?php if (hush_get_theme_option_value('masonry', 'display_text') == true) { ?>
                <div class="masonry__content hover">
                    <?php the_sub_field('content'); ?>
                </div>
            <?php } ?>

        <?php
        endif; // links
        ?>
    </div>
</div>