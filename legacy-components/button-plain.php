<?php
$extra_classes = "";

// color
if ($args['color'] ?? false) {
    $color = hush_convert_option_text($args['color']);
} else {
    $color = hush_convert_option_text(hush_get_theme_option_value('buttons', 'color', false));
}

$extra_classes .= " " . hush_replace_section_color($color, "buttons");

// no background
if ($args['nobackground'] ?? false)
    $extra_classes .= ' option-nobackground';

// white
if ($args['white'] ?? false)
    $extra_classes .= ' option-white';

if (hush_get_theme_option_value("buttons", "custom_class")) {
    // css custom classes
    if ($args['css_class']) {
        $extra_classes .= ' ' . preg_replace("/[^A-Za-z0-9 ]/", "", $args['css_class']);
    }
}


?>

<div class="button <?php echo hush_get_theme_options('buttons'); ?> <?php echo $extra_classes; ?>">
    <?php echo $args['text']; ?>
</div>