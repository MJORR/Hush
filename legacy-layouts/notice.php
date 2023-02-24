<?php
$layout_options = '';

// title notice
if ($args['title_notice'] ?? false) {
    $notice = get_field('title_notice');
    $layout_options .= " option-title";

    if (!hush_get_theme_option_value('notice', 'title_notice_colour_override'))
        $layout_options .= ' option-nosectioncolor';
}
// notice
else {
    $notice = get_field('page_notice');

    if (!hush_get_theme_option_value('notice', 'notice_override'))
        $layout_options .= ' option-nosectioncolor';

    // close
    $layout_options .= ' option-close';
}

// notice type
$notice_type = $args['title_notice'] ?? false ? 'title' : 'notice';


//  custom
if ($args['custom'] ?? false) {
    $notice = $args['custom'];
}


$custom = $notice['custom'] ?? false;


// auto
if ($args['auto'] ?? false) {
    $custom = true; //simulate custom

    $notice['content'] = $args['auto'];
}


// global template
if (!$custom) {
    $template = $notice['notice'] ?? false;

    $templates = get_field('notice_templates', 'option');

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
    $template = $notice['content'];
}

if (is_array($template) ?? false) :
?>

    <div class="notice <?php echo hush_get_theme_options('notice'); ?> <?php echo $layout_options; ?> option-<?php echo strtolower(preg_replace('/\s+/', '', $template['color'])); ?>">
        <div class="notice__layout">

            <?php
            //get_template_part('components/darken', null, ['color' => $template['color']]);
            ?>

            <div class="notice__content">
                <?php
                // icon
                $icon = $template['icon'];
                if ($icon) :
                ?>
                    <div class="notice__content__icon">
                        <?php echo $icon; ?>
                    </div>
                <?php
                endif; // icon
                ?>

                <?php
                if ($template['show_title']) :
                ?>
                    <div class="notice__content__title">
                        <p><strong><?php echo $template['title']; ?></strong></p>
                    </div>
                <?php
                endif; // show_title
                ?>

                <div class="notice__content__text">
                    <?php echo $template['notice_text']; ?>
                </div>

                <?php
                // Button
                if ($template['add_button']) :
                ?>
                    <div class="notice__content__button">
                        <?php get_template_part('components/button', null, [
                            'button'        => $template['button'],
                            'nobackground'  => true,
                            'color'         => $template['color'],
                            'invert'        => true,
                            'small'         => true
                        ]); ?>
                    </div>
                <?php
                endif; // template button
                ?>

                <?php
                // Close
                if ($notice_type == 'notice') :
                ?>
                    <div class="notice__close"></div>
                <?php
                endif; // notice
                ?>
            </div>
        </div>
    </div>

<?php
endif; // template
?>