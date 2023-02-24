<?php
$layout_options = '';

// color
if ($args['color'] ?? false)
    $layout_options .= " option-" . strtolower(preg_replace('/\s+/', '', $args['color']));

// fill
if ($args['fill'] ?? false)
    $layout_options .= " option-100";
?>

<div class="darken option-<?php echo $layout_options; ?>">
</div>