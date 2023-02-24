<?php
$layout_options = '';
$video = $args['video'];

// darken
if ($args['darken'] ?? false)
    $layout_options .= ' option-darken';

// autoplay video
$autoplay = isset($args['autoplay']) ? $args['autoplay'] : true;
if (!$autoplay)
    $layout_options .= ' option-manual';

// muted
$muted = isset($args['muted']) ? $args['muted'] : true;
?>

<div class="video <?php echo $layout_options; ?>" aria-hidden="true">
    <?php
    if (!$autoplay) :
    ?>
        <div class="video__play"></div>
    <?php
    endif; // autoplay
    ?>

    <video class="video__object" <?php echo $muted ? 'muted' : null; ?> playsinline <?php echo $autoplay ? 'autoplay' : null; ?> loop>
        <source src="<?php echo $video['url']; ?>" type="video/mp4">
    </video>
</div>