<?php

/**
 * Logo ticker
 * 
 * Displays a logo ticker.
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

<div class="logo-ticker-block <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options ?? null; ?> <?php echo hush_get_theme_options('logo_ticker'); ?> " <?php hush_animation(); ?>>
    <div class="container">
        <ul class="logo-ticker">
            <?php $i = 1;
            while ($i <= 8) : ?>
                <?php if (have_rows('logo_ticker')) :
                    while (have_rows('logo_ticker')) : the_row();

                        $image = get_sub_field('image');
                        $imageURL = get_sub_field('image_url'); ?>

                        <li>
                            <a href="<?php echo $imageURL; ?>" target="_blank">
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                            </a>
                        </li>
            <?php endwhile;
                endif;
                $i++;
            endwhile; ?>
        </ul>
    </div>
</div>