<?php
$layout_options = "";

// color
$layout_options .= " " . hush_convert_option_text($args['color'] ?? 'primary');

if ($args['change_opacity'] ?? false)
    $layout_options .= " change_opacity-" . $args['change_opacity'];

// full widrh
if ($args['full'] ?? false)
    $layout_options .= " option-width";
?>

<div class="opacity <?php echo $layout_options; ?>">
</div>