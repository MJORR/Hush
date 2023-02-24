<?php

/**
 * Banner (Post and Post Archive)
 * 
 * Post title banner variant. 
 */

$layout_options = '';

// post type
$custom_title = false;
if (is_post_type_archive()) {
    $post_type = hush_get_theme_option_value('posts-post', 'title_override') ? 'post' : 'page';
    $settings = 'banner-' . $post_type;
}

// custom post
elseif ($args['custom_post'] ?? false) {
    $settings = 'customtitles_' . $args['custom_post'];

    if ($args['contents'])
        $custom_title = $args['contents'];
}

// post options
else {
    $post_type = hush_get_theme_option_value('posts-' . get_post_type(), 'title_override') ? get_post_type() : 'page';
    $settings = 'banner-' . $post_type;
}

// plain background (colours and fonts normal)
$plain_banner = false;
if (hush_get_theme_option_value($settings, 'bg_color') == 'white' || hush_get_theme_option_value($settings, 'bg_color') == 'background') {
    $plain_banner = true;
}


// opacity
$opacity_color = null;
if (hush_get_theme_option_value($settings, 'bgopacity_enabled')) {
    $layout_options .= ' option-bgopacity';
    $opacity_color = hush_get_theme_option_value($settings, 'bgopacity_color');

    $plain_banner = false;
}

// image type
if ($plain_banner == false && hush_get_theme_option_value($settings, 'type') != 'wholeimage')
    $layout_options .= ' option-' . strtolower(preg_replace('/\s+/', '', hush_get_theme_option_value($settings, 'bg_color')));

// pagemenu location (from return page)
$return_menus = false;

if (!is_author() && !is_tag()) {

    if (hush_get_theme_option_value('posts-' . get_post_type(), 'return_menus') && (get_query_var('return') ?? false)) {
        // check return is a page
        $return_page = get_post(get_query_var('return'));

        if (isset($return_page->post_type) == 'page') {
            $return_menus = $return_page->ID;

            $pagemenu_location = hush_get_theme_option_value('banner-page', 'pagemenu_position') ?? "below";
            $breadcrumb_location = hush_get_theme_option_value('banner-page', 'breadcrumb_position') ?? "below";
        }
    }
    // pagemenu location (from primary category)
    elseif (hush_get_theme_option_value('posts-' . get_post_type(), 'return_menus')) {
        $terms = wp_get_post_categories(get_the_ID());

        if ($terms) {
            if (count($terms) > 1) {
                if (function_exists('yoast_get_primary_term_id')) {
                    $post_category = yoast_get_primary_term_id('category', get_the_ID());

                    if (!$post_category)
                        $post_category = $terms[0];
                } else {
                    $post_category = $terms[0];
                }
            } else {
                $post_category = $terms[0];
            }

            $post_category = get_category($post_category);

            if (isset($post_category->name)) {
                if (get_field('override_page', $post_category)) {
                    $new_page = get_field('override_page', $post_category) ?? false;
                    if ($new_page) {
                        $return_page = get_post($new_page);
                    }
                }
            }

            if (isset($return_page->post_type) == 'page') {
                $return_menus = $return_page->ID;

                $pagemenu_location = hush_get_theme_option_value('banner-page', 'pagemenu_position') ?? "below";
                $breadcrumb_location = hush_get_theme_option_value('banner-page', 'breadcrumb_position') ?? "below";
            }
        }
    }
}

/* Parent Div Options
------------------------------------------------------------------------------------------- */
$parent_options = "";

// height
$parent_options .= ' option-height-' . hush_get_theme_option_value($settings, 'height');

// bgopacity
$parent_options .= ' option-bgopacity_type-' . hush_get_theme_option_value($settings, 'bgopacity_type');

// bg_color
$parent_options .= " " . hush_convert_option_text(hush_get_theme_option_value($settings, 'bg_color'));

// text_color
if (!$plain_banner && !isset($text_color_override)) {
    $parent_options .= " option-text_color-" . hush_get_theme_option_value($settings, 'text_color');
} elseif (isset($text_color_override)) {
    $parent_options .= " option-text_color-" . $text_color_override;
}

// plain
if ($plain_banner)
    $parent_options .= " option-plain"
?>


<div class="banner option-pagetitle <?php echo $parent_options; ?>">
    <?php
    // bg opacity 
    if ($plain_banner == false && hush_get_theme_option_value($settings, 'bgopacity')) {
        if (hush_get_theme_option_value($settings, 'bgopacity_type') == 'full') {
            get_template_part('components/darken', null, ['color' => $opacity_color]);
        }
    }
    ?>

    <div class="banner__slides option-pagetitle <?php echo hush_get_theme_options($settings); ?> <?php echo $layout_options ?? null; ?>">
        <div class="banner__slides__slide">
            <?php get_template_part('layouts/parts/content', 'banner-post', ['settings' => $settings, 'opacity_color' => $opacity_color, 'custom_title' => $custom_title, 'plain' => $plain_banner]); ?>
        </div>
    </div>

    <?php
    // page menu (if supported)
    if (hush_get_theme_option_value($settings, 'pagemenu_position') != "banner"){
        if ($return_menus) {
            get_template_part('layouts/parts/pagemenu', null, [
                'opacity_color'     => $opacity_color,
                'pagemenu'          => hush_get_theme_option_value($settings, 'pagemenu_position') ?? "below",
                'pagemenu_mobile'   => hush_get_theme_option_value($settings, 'pagemenu_mobile') ? hush_get_theme_option_value($settings, 'pagemenu_mobile_position') : false,
                'breadcrumb'        => hush_get_theme_option_value($settings, 'breadcrumb_position') ?? "below",
                'page'              => $return_menus,
            ]);
        }
    }

    // client bottom banner
    if (file_exists(get_stylesheet_directory() . "/client-custom-bottom-banner.php") && hush_get_theme_option_value($settings, 'add_custom_bottom') == true) :
    ?>
        <div class="banner__client">
            <?php get_template_part('client', 'custom-bottom-banner'); ?>
        </div>
    <?php
    endif; // client bottom banner

    // scroll icon
    if (hush_get_theme_options($settings, 'scrolldown'))
        get_template_part('components/scrolldown');
    ?>
</div>

<?php
// related pages
if ($return_menus) {
    if (hush_get_theme_option_value('related', 'enabled') && hush_get_theme_option_value('related', 'location') == "title")
        get_template_part('layouts/parts/related', null, [
            'page'              => $return_menus,
        ]);
}

// image
if (hush_get_theme_option_value($settings, 'imagebelow') && !is_category() && !is_author() && !is_tag() && !is_archive()) {
    get_template_part("layouts/image", null, ['title' => true]);
    hush_webpack_add_file("image", "layouts");
}
