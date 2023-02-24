<?php

$layout_options = '';

$sidepop = get_field('page_popout');

$custom = $sidepop['custom'] ?? false;

// auto
if ($args['auto'] ?? false) {
    $custom = true; //simulate custom

    $sidepop['content'] = $args['auto'];
}

// global template
if (!$custom) {
    $template =  $sidepop['sidepop'] ?? false;

    $templates = get_field('sidepop_templates', 'option');
    if ($templates) {
        foreach ($templates  as $id => $template_inner) {
            if ($template_inner['id'] == $template) {
                $template = $template_inner;
                break;
            }
        }
    }
}
// custom
else {
    $template = $sidepop['content'];
}

if (is_array($template)) :
?>

    <a href="<?php echo $template['link']; ?>" class="side_popout <?php echo hush_get_theme_options('side_popout'); ?> <?php echo hush_convert_option_text($template['background_colour']); ?>">
        <div class="side_popout__layout">

            <div class="side_popout__content">
                <?php
                // icon
                $icon = $template['icon'];
                if ($icon) :
                ?>
                    <div class="side_popout__icon">
                        <?php echo $icon; ?>
                    </div>
                <?php
                endif; // icon
                ?>


                <?php echo $template['title']; ?>

            </div>
        </div>
    </a>
<?php
endif; // template
?>