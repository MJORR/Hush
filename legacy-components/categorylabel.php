<?php
$extra_classes = "";

// color
if ($args['color'] ?? false)
    $extra_classes .= ' ' . hush_convert_option_text($args['color']);
?>

<div class="categorylabel <?php echo hush_get_theme_options('categories'); ?> <?php echo $extra_classes; ?> option-nosectioncolor">
    <?php
    // icon
    if (hush_get_theme_option_value('categories', 'icon') && $args['icon'] ?? false)
        get_template_part("components/icon", null, ['icon' => $args['icon']]);
    ?>

    <span><?php echo $args['text']; ?></span>
</div>