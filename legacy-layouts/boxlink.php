<?php

/**
 * Box Link
 * 
 * Displays boxes that link to specific pages on the site and gets the title, text etc from the page/post.
 * But with the text overlapping the image.
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
if (hush_get_theme_option_value('boxlink', 'linktype') == 'arrow' && hush_get_theme_option_value('boxlink', 'link_line'))
    $layout_options .= ' option-link_line';

// hovercolor
if (get_sub_field('hovercolor'))
    $layout_options .= ' option-hovercolor';

// title underline
if (get_sub_field('show_title_line'))
    $layout_options .= ' option-title-line';

// image
if (get_sub_field('image')) {
    $layout_options .= ' option-image';
    $links_have_images = true;
} else {
    $links_have_images = false;
}

// hover effect
$layout_options .= ' option-effect-' . get_sub_field('effect');

// links
if (get_sub_field('text'))
    $layout_options .= ' option-text';

// column
if (get_sub_field('show_icon')) {
    if (get_sub_field('a_column'))
        $layout_options .= ' option-column';
}

?>

<div class="boxlink <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('boxlink'); ?> <?php echo $layout_options ?? null; ?>">
    <?php
    // Links
    $links = get_sub_field('links');
    $show_icon = get_sub_field('show_icon');
    $show_description = get_sub_field('show_description');

    if ($links) :
    ?>
        <div class="boxlink__links">
            <?php
            // loop through all links
            foreach ($links as $link) :
                // manual
                $content_file = $link['manual'] ? 'boxlink-manual' : 'boxlink';

                // link
                if ($link['manual']) {
                    $link_a = hush_get_button($link['link']);

                    $box_link = 'href="' . $link_a['link'] . '"';
                    $data_link = $link_a['link'];

                    if (!get_sub_field('dont_open_link_in_new_tab') && $link_a['tab'])
                        $box_link .= ' target="blank"';

                    if (get_sub_field('dont_open_link_in_new_tab') && $link_a['tab'])
                        $box_link .= '';

                    if ($link_a['download_file'])
                        $box_link .= ' download';
                } elseif (is_object($link['post'])) {
                    $box_link = 'href="' . get_permalink($link['post']->ID) . '"';
                    $data_link = get_permalink($link['post']->ID);
                }

                if ($box_link ?? false) :
            ?>
                    <a <?php echo $box_link; ?> data-link="<?php echo $data_link; ?>" class="boxlink__links__link <?php echo hush_convert_option_text($link['color']); ?>" <?php hush_animation(); ?>>
                        <?php
                        get_template_part('components/darken', null, [
                            'color' => $link['color']
                        ]);
                        ?>

                        <?php get_template_part('layouts/parts/content', $content_file, [
                            'link'              => $link,
                            'show_icon'         => $show_icon,
                            'show_description'  => $show_description,
                            'links_have_images' => $links_have_images,
                            'text'              => get_sub_field('text'),
                            'color'             => $link['color']
                        ]); ?>
                    </a>
            <?php
                endif; // boxlink
            endforeach; // foreach (links)
            ?>
        </div>

    <?php
    endif; // links
    ?>
</div>