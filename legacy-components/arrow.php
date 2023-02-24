<?php
$button = hush_get_button($args['button']);

$extra_classes = "";


if (isset($button)) :
?>
    <a href="<?php echo $button['link']; ?>" <?php echo $button['tab'] ? 'target="_blank"' : ''; ?> <?php echo $button['download'] ? 'download' : null; ?> class="arrow <?php echo hush_get_theme_options('arrows'); ?> <?php echo $extra_classes; ?>">
        <div class="outer">
            <div class="inner"><?php echo $button['text']; ?></div>
        </div>
    </a>
<?php
endif; // button
?>