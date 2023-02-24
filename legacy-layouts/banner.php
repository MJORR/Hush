<?php

/**
 * Banner
 * 
 * Can be used as a homepage banner or as a flexible banner content.
 */


$layout_options = '';

/* Flexible Content
------------------------------------------------------------------------------------------- */
if (hush_check_flexible($args) || ($is_preview ?? false)) {
    $settings = "banner";

    // plain background (colours and fonts normal)
    $plain_banner = false;
    if (hush_get_theme_option_value($settings, 'bg_color') == 'white' || hush_get_theme_option_value($settings, 'bg_color') == 'background') {
        $plain_banner = true;
    }

    // opactiy
    $opacity_color = null;
    if (hush_get_theme_option_value($settings, 'bgopacity_enabled')) {
        // own opacity colour
        if (hush_get_theme_option_value($settings, 'own_opacity') == true && get_sub_field('opacity_colour_change') == true) {
            $opacity_color = get_sub_field('opacity_colour');
        }
        // default opacity colour
        else {
            $opacity_color = hush_get_theme_option_value($settings, 'bgopacity_color');
        }

        $layout_options .= ' option-bgopacity';
        $plain_banner = false;
    }

    // video
    $video = null;
    if ($plain_banner == false && get_sub_field('banner_video_add') && hush_get_theme_option_value($settings, 'type') != 'text') {
        $video = get_sub_field('banner_video');
        $layout_options .= ' option-video';
    }

    // button type
    $button_type = get_sub_field('banner_button_type');
    if ($button_type == 'arrow') {
        $layout_options .= " option-button-arrow";
        $layout_options .= " option-buttonCols-" . get_sub_field('banner_buttons_per_line');
    }

    // background color
    if (hush_get_theme_option_value($settings, 'type') != 'wholeimage') {
        // individual background colour
        if (hush_get_theme_option_value($settings, 'own_bgcolor') == true && get_sub_field('background_color_change') == true) {
            $background_color = get_sub_field('background_colour');
            $text_color_override = hush_get_theme_option_value($settings, 'text_color'); // override text color
            $plain_banner = false;
        }
        // default background colour
        else {
            $background_color = hush_get_theme_option_value($settings, 'bg_color');
        }

        $layout_options .= ' option-' . strtolower(preg_replace('/\s+/', '', $background_color));
    }

    // option-nosectioncolor
    if (hush_get_theme_option_value('section', 'banners') == false)
        $layout_options .= ' option-nosectioncolor';
}
/* Front Page Banner
------------------------------------------------------------------------------------------- */ else {
    $settings = "frontbanner";
    hush_webpack_add_file("frontbanner", "singles");

    // plain background (colours and fonts normal)
    $plain_banner = false;
    if (hush_get_theme_option_value($settings, 'bg_color') == 'white' || hush_get_theme_option_value($settings, 'bg_color') == 'background') {
        $plain_banner = true;
    }

    // opacity
    $opacity_color = null;
    if ($plain_banner == false && hush_get_theme_option_value($settings, 'bgopacity_enabled')) {
        $layout_options .= ' option-bgopacity';
        $opacity_color = hush_get_theme_option_value($settings, 'bgopacity_color');
    }

    // video
    $video = null;
    if ($plain_banner == false && get_field('banner_video_add') && hush_get_theme_option_value($settings, 'type') != 'text') {
        $video = get_field('banner_video');
        $layout_options .= ' option-video';
    }

    // button type
    $button_type = get_field('banner_button_type');
    if ($button_type == 'arrow') {
        $layout_options .= " option-button-arrow";
        $layout_options .= " option-buttonCols-" . get_field('banner_buttons_per_line');
    }

    // front page
    if (is_front_page())
        $layout_options .= " option-homepage";

    // background color
    if (hush_get_theme_option_value($settings, 'type') != 'wholeimage') {
        $layout_options .= ' option-' . strtolower(preg_replace('/\s+/', '', hush_get_theme_option_value($settings, 'bg_color')));
    }
}


/* Parent Div Options
------------------------------------------------------------------------------------------- */
$parent_options = "";

// pagetitle
if (!hush_check_flexible($args) && (!($is_preview ?? false)))
    $parent_options .= ' option-pagetitle option-frontpage';

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
    $parent_options .= " option-plain";
?>

<div class="banner <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-imagebackground  layout-reset <?php echo $parent_options; ?> <?php echo $parent_options; ?>">

    <div class="banner__slides <?php echo hush_get_theme_options($settings); ?> <?php echo $layout_options ?? null; ?>">

        <?php
        // video
        if ($video ?? false) {
            get_template_part('components/video', null, [
                'video'     => $video,
                'darken'    => true
            ]);
        }
        ?>

        <?php
        if (hush_check_flexible($args) || ($is_preview ?? false)) :
        ?>
            <div class="banner__slides__slide">
                <?php
                get_template_part('layouts/parts/content', 'banner', [
                    'settings'          => $settings,
                    'opacity_color'     => $opacity_color,
                    'video'             => $video,
                    'button'            => $button_type,
                    'plain'             => $plain_banner
                ]);
                ?>
            </div>
            <?php
        else :
            if (have_rows('slides')) :
                // loop through all slides
                while (have_rows('slides')) : the_row();
            ?>
                    <div class="banner__slides__slide option-<?php echo hush_get_theme_option_value($settings, 'bg_color'); ?>">
                        <?php
                        get_template_part('layouts/parts/content', 'banner', [
                            'settings'          => $settings,
                            'opacity_color'     => $opacity_color,
                            'video'             => $video,
                            'button'            => $button_type,
                            'plain'             => $plain_banner
                        ]);
                        ?>
                    </div>
        <?php
                endwhile; // while (slides)
            endif; // have_rows (slides)
        endif; // flexible
        ?>
    </div>

    <?php
    // client frontpage banner
    if (file_exists(get_stylesheet_directory() . "/client-frontpage-banner.php") && $settings == "frontbanner") :
    ?>
        <div class="banner__client">
            <?php get_template_part('client', 'frontpage-banner'); ?>
        </div>
    <?php 
    elseif (file_exists(get_stylesheet_directory() . "/client-custom-bottom-banner.php") && $settings == "frontbanner") :
    ?>
        <div class="banner__client">
            <?php get_template_part('client', 'custom-bottom-banner'); ?>
        </div>
    <?php
    endif; // client frontpage banner

    // scroll icon
    if (hush_get_theme_option_value($settings, 'scrolldown') ?? false)
        get_template_part('components/scrolldown');

    if (hush_get_theme_option_value($settings, 'pagemenu_position') != "banner"):
        // menu + title notice
        if (!hush_check_flexible($args) && (!($is_preview ?? false)))
            get_template_part('layouts/parts/pagemenu', null, [
                'opacity_color'     => $opacity_color,
                'pagemenu'          => hush_get_theme_option_value($settings, 'pagemenu_position') ?? "below",
                'pagemenu_mobile'   => hush_get_theme_option_value($settings, 'pagemenu_mobile') ? hush_get_theme_option_value($settings, 'pagemenu_mobile_position') : false,
                'breadcrumb'        => hush_get_theme_option_value($settings, 'breadcrumb_position') ?? "below"
            ]);
    endif;
    ?>
</div>