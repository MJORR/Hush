<?php

$link = $args['link'];
$term = $link['post'];
$post_category = get_category($term);

$image = get_field('page_images', $post_category);
$image = $image['image']['url'] ?? null;
$mobile_image = $image['image_mobile']['url'] ?? null;


if (is_null($image)) :
    $images = get_field('default_page_image', 'option');

    $image = $images['image']['url'];
    $mobile_image = $image['image_mobile']['url'] ?? null;
endif;



$catColor = get_field('category_colour', $post_category);
$borderColor = ' var(--theme-color-' . strtolower(preg_replace('/\s+/', '', $catColor)) . ')';

if ($mobile_image) {
    $mobile_style = 'background-image: url(\'' . $mobile_image . '\');';
}

// link
if (get_field('override_page', "category_" . $term)) {
    $category_link = get_permalink(get_field('override_page', "category_" . $term));
} else {
    $category_link = get_category_link($term);
}

?>

<a href="<?php echo $category_link; ?>">
    <div class="masonry__links__container <?php echo hush_get_theme_options('masonry'); ?> " <?php if (hush_get_theme_option_value('masonry', 'display_border') == true) { ?> style="border-left: 10px solid <?php if ($catColor != '') { echo $borderColor; } else { echo 'var(--theme-color-primary)'; } ?>;" <?php } ?>>

        <?php if (hush_get_theme_option_value('masonry', 'no_colour_opacity') == true) { ?>
            <?php
            get_template_part('components/opacity', null, [
                'color'     => 'primary',
                'full'      => true,
            ]);
            ?>
        <?php } ?>

        <div class="masonry__content" style="background-image:url('<?php echo $image ?? null; ?>');">

            <?php
            // Mobile Image
            if (!is_null($mobile_image)) :
            ?>
                <div class="background__mobile" style="<?php echo $mobile_style ?? null; ?>"></div>
            <?php
            endif; // type == image
            ?>

            <div class="masonry__title">

                <?php if (hush_get_theme_option_value('masonry', 'display_icon') == true) { ?>
                    <div class="masonry__icon">
                        <?php if (get_field('category_icon', $post_category)) {

                            get_template_part('components/icon', null, [
                                'icon'      => get_field('category_icon', $post_category),
                            ]);
                        } else { ?>
                            <div class="icon">
                                <i class="fas fa-file"></i>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>


                <h3><?php echo $post_category->name; ?></h3>
            </div>

            <?php if (hush_get_theme_option_value('masonry', 'display_description') == true) { ?>
                <div class="masonry__description">
                    <p><?php echo $post_category->description; ?></p>
                </div>
            <?php } ?>

            <?php if (hush_get_theme_option_value('masonry', 'display_button') == true) { ?>
                <div class="masonry__button">
                    <?php get_template_part('components/button', 'plain', [
                        'text'          => hush_get_theme_option_value('masonry', 'link_prepend') . ' ' . $post_category->name,
                        'nobackground'  => hush_get_theme_option_value('masonry', 'button_nobackground'),
                        'white'         => hush_get_theme_option_value('masonry', 'button_white'),
                    ]); ?>
                </div>
            <?php } ?>

        </div>
    </div>
</a>