<?php

/**
 * Image Link
 * 
 * Displays boxes that link to specific pages on the site and gets the title, text etc from the page/post.
 * But with an image then text.
 * 
 */

$layout_options = '';

// background
if (get_sub_field('background')) {
    $layout_options .= ' layout-background';
}

// height
$layout_options .= ' option-height-' . get_sub_field('height');

// items_per_line
$layout_options .= ' option-items_per_line-' . get_sub_field('items_per_line');

// link line
if (hush_get_theme_option_value('imagelink', 'linktype') == 'arrow' && hush_get_theme_option_value('imagelink', 'link_line'))
    $layout_options .= ' option-link_line';

// hovercolor
if (get_sub_field('hovercolor'))
    $layout_options .= ' option-hovercolor';

// title underline
if (get_sub_field('show_title_line'))
    $layout_options .= ' option-title-line';

// hover effect
$layout_options .= ' option-effect-' . get_sub_field('effect');

// links
if (get_sub_field('text'))
    $layout_options .= ' option-text';

// overlap text and image
if (get_sub_field('overlap_text_image'))
    $layout_options .= ' option-overlap-text-image';
?>

<div class="imagelink <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('imagelink'); ?> <?php echo $layout_options ?? null; ?>">
    <?php
    // Links
    $links = get_sub_field('links');
    $show_icon = get_sub_field('show_icon');
    $show_description = get_sub_field('show_description');
    $show_title = get_sub_field('show_title');

    if ($links) :
    ?>

        <?php if ($show_title) : ?>
            <div class="imagelink__links__heading">
                <h2><?php the_sub_field('title'); ?></h2>
            </div>
        <?php endif; ?>

        <div class="imagelink__links">

            <?php
            // loop through all links
            foreach ($links as $link) :

                // manual
                $content_file = $link['manual'] ? 'imagelink-manual' : 'imagelink';

                // link
                if ($link['manual']) {
                    $link_a = hush_get_button($link['link']);

                    $box_link = 'href="' . $link_a['link'] . '"';
                    $data_link = $link_a['link'];
                    if ($link_a['tab'])
                        $box_link .= ' target="blank"';

                    if ($link_a['download_file'])
                        $box_link .= ' download';
                } else {
                    $box_link = 'href="' . get_permalink($link['post']->ID) . '"';
                    $data_link = get_permalink($link['post']->ID);
                }
            ?>
                <a <?php echo $box_link; ?> data-link="<?php echo $data_link; ?>" class="imagelink__links__link <?php echo hush_convert_option_text($link['color']); ?>" <?php hush_animation(); ?>>

                    <?php get_template_part('layouts/parts/content', $content_file, [
                        'link'              => $link,
                        'show_icon'         => $show_icon,
                        'show_description'  => $show_description,
                        'text'              => get_sub_field('text'),
                        'color'             => $link['color']
                    ]); ?>
                </a>
            <?php
            endforeach; // foreach (links)
            ?>
        </div>

    <?php
    endif; // links
    ?>
</div>