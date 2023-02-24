<?php
$button = hush_get_button($args['button']);

$extra_classes = "";

// color
if ($args['color'] ?? false) {
    $color = hush_convert_option_text($args['color']);
} else {
    $color = hush_convert_option_text(hush_get_theme_option_value('buttons', 'color', false));
}

// nosectioncolor
if ($args['nosectioncolor'] ?? false) {
    $extra_classes .= " option-nosectioncolor";

    $extra_classes .= " " . $color; // color
} else {
    $extra_classes .= " " . hush_replace_section_color($color, "buttons");
}


// no invert
if ($args['noinvert'] ?? false) {
    $extra_classes .= " option-noinvert";
} elseif ($args['invert'] ?? false) {
    $extra_classes .= " option-invert";
}

// no background
if ($args['nobackground'] ?? false)
    $extra_classes .= ' option-nobackground';

// white
if ($args['white'] ?? false)
    $extra_classes .= ' option-white ';

// small
if ($args['small'] ?? false)
    $extra_classes .= ' option-small';

if (hush_get_theme_option_value("buttons", "custom_class")) {
    // css custom classes
    if ($button['css_class']) {
        $extra_classes .= ' ' . $button['css_class'];
    }
}



if (isset($button)) :
?>
    <a href="<?php echo $button['link']; ?>" <?php echo $button['tab'] ?? false ? 'target="_blank"' : ''; ?> <?php echo $button['download_file'] ? 'download' : null; ?> class="button <?php echo hush_get_theme_options('buttons'); ?> <?php echo $extra_classes; ?>">
        <?php
        if ($button['tab']) :
            echo '<i class="fas fa-external-link"></i>';
        endif;
        ?>
        <?php echo $button['text']; ?>
    </a>
<?php
endif; // button
?>