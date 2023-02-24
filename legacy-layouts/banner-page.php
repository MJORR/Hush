<?php

/**
 * Banner (Page Title)
 * 
 * Page title banner variant. 
 */

$layout_options = '';
$settings = 'banner-page';

// client plain
$client_plain_banner = get_field('plain') ?? false;

// plain background (colours and fonts normal)
$plain_banner = false;
if (hush_get_theme_option_value($settings, 'bg_color') == 'white' || hush_get_theme_option_value($settings, 'bg_color') == 'background') {
    $plain_banner = true;
}

// opacity
$opacity_color = null;
if (hush_get_theme_option_value($settings, 'bgopacity_enabled') && $client_plain_banner == false) {
    $layout_options .= ' option-bgopacity';
    $opacity_color = hush_get_theme_option_value($settings, 'bgopacity_color');

    $plain_banner = false;
}

// video
$page_video = get_field('page_video');
$video = null;

$page_video_show = $page_video['show'] ?? false;

if ($plain_banner == false && $page_video_show) {
    $title_video = $page_video['video'] ?? false;

    if ($title_video) {
        $video = $title_video;
        $layout_options .= ' option-video';
    }
}

// image type
if ($plain_banner == false && hush_get_theme_option_value($settings, 'type') != 'wholeimage')
    $layout_options .= ' option-' . strtolower(preg_replace('/\s+/', '', hush_get_theme_option_value($settings, 'bg_color')));


/* Parent Div Options
------------------------------------------------------------------------------------------- */
$parent_options = "";

// height
$parent_options .= ' option-height-' . hush_get_theme_option_value($settings, 'height');

// bgopacity
$parent_options .= ' option-bgopacity_type-' . hush_get_theme_option_value($settings, 'bgopacity_type');

// bg_color
if ($client_plain_banner == false)
    $parent_options .= " " . hush_convert_option_text(hush_get_theme_option_value($settings, 'bg_color'));

// text_color
if (!$plain_banner && !isset($text_color_override)) {
    $parent_options .= " option-text_color-" . hush_get_theme_option_value($settings, 'text_color');
} elseif (isset($text_color_override)) {
    $parent_options .= " option-text_color-" . $text_color_override;
}

// plain
if ($plain_banner || $client_plain_banner)
    $parent_options .= " option-plain";
?>

<div class="banner option-pagetitle <?php echo $parent_options; ?>">


    <div class="banner__slides option-title <?php echo hush_get_theme_options($settings); ?> <?php echo $layout_options ?? null; ?>">
        <?php
        // video
        if ($video ?? false) {
            get_template_part('components/video', null, ['video' => $video, 'darken' => true]);
        }
        ?>
        <div class="banner__slides__slide">
            <?php get_template_part('layouts/parts/content', $settings, [
                'settings'          => $settings,
                'opacity_color'     => $opacity_color,
                'video'             => $video,
                'plain'             => $plain_banner,
                'client_plain'      => $client_plain_banner
            ]); ?>
        </div>
    </div>

    <?php
    if (hush_get_theme_option_value($settings, 'pagemenu_position') != "banner") {
        // menu + title notice
        get_template_part('layouts/parts/pagemenu', null, [
            'opacity_color'     => $opacity_color,
            'pagemenu'          => hush_get_theme_option_value($settings, 'pagemenu_position') ?? "below",
            'pagemenu_mobile'   => hush_get_theme_option_value($settings, 'pagemenu_mobile') ? hush_get_theme_option_value($settings, 'pagemenu_mobile_position') : false,
            'breadcrumb'        => hush_get_theme_option_value($settings, 'breadcrumb_position') ?? "below",
            'client_plain'      => $client_plain_banner
        ]);
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
if (hush_get_theme_option_value('related', 'enabled') && hush_get_theme_option_value('related', 'location') == "title")
    get_template_part('layouts/parts/related');

// image
if (hush_get_theme_option_value($settings, 'imagebelow')) {
    get_template_part("layouts/image", null, ['title' => true]);
}
?>