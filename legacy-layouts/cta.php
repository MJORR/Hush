<?php

/**
 * CTA - Call to Action
 * 
 * Displays Call to Action
 */

$layout_options = '';

if (hush_check_flexible($args) || ($is_preview ?? false)) {
    $custom = get_sub_field('custom');
    $template = get_sub_field('cta');
    $content = get_sub_field('content');
}
// footer cta
else {
    $footer_cta = get_field('footer_cta_content');

    $custom = $footer_cta['custom'];
    $template = $footer_cta['cta'];
    $content = $footer_cta['content'];
}

// opactiy
$settings = "cta";
if (hush_get_theme_option_value($settings, 'bgopacity_enabled')) {

    $opacity_color = hush_get_theme_option_value($settings, 'bgopacity_color');
    //$layout_options .= " option-bgopacity_type-" . hush_get_theme_option_value($settings, 'bgopacity_type');
}

// global template
if (!$custom) {
    $templates = get_field('cta_templates', 'option');
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
    $template = $content;
}

if (is_array($template)) :

    // background
    if ($template['background_type'] == 'color') {
        $style = 'background-color: ' . (($is_preview ?? false) ? '#f280ab' :  hush_get_theme_color($template['background_colour'])) . ";";
        $style .= 'color: ' . (($is_preview ?? false) ? 'white' :  hush_get_theme_color($template['background_colour'], true)) . ";";
        $layout_options .= ' option-background_type-color';
    } elseif ($template['background_type'] == 'image') {
        $style = 'background-image: url(\'' . $template['background_image']['sizes']['large'] . '\');';
        $layout_options .= ' option-background_type-image';

        $mobile_image = $template['image_mobile']['sizes']['large'] ?? false;
        if ($mobile_image) {
            $mobile_style = 'background-image: url(\'' . $mobile_image . '\');';
        }
    }

    $layout_options .= ' layout-imagebackground';

    // extended
    if ($template['extended'])
        $layout_options .= ' option-extended';

    // mobileonly
    $mobile_image = false;
    if ($mobile_image ?? false) {
        $mobile = 'option-mobileonly';
    }

    // link (non extended)
    if (hush_get_theme_option_value($settings, 'linktype') == "link" && $template['add_link'] && !$template['extended']) {
        $layout_options .= " option-titlearrow";
    }
?>

    <div class="cta <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('cta'); ?> <?php echo $layout_options ?? null; ?> <?php echo $mobile ?? null; ?>" style="<?php echo $style ?? null; ?>" <?php hush_animation(); ?>>
        <?php
        //opacity
        if ($opacity_color ?? false) {
            if (hush_get_theme_option_value($settings, 'bgopacity_type') == "full") {
                get_template_part('components/darken', null, ['color' => $opacity_color, 'fill' => true]);
            } else {
                get_template_part('components/opacity', null, ['color' => $opacity_color]);
            }
        }
        ?>

        <div class="cta__outer">

            <?php
            if ($template['background_type'] == 'image') :
                get_template_part('components/darken');
            endif;
            ?>

            <?php
            // Mobile Image 
            if (!is_null($mobile_image)) :
            ?>
                <div class="background__mobile" style="<?php echo $mobile_style ?? null; ?>"></div>
            <?php
            endif; // type == image
            ?>

            <div class="cta__left">
                <?php
                // icon
                $icon = $template['icon'];
                if ($icon) :
                ?>
                    <div class="cta__icon">
                        <?php echo $icon; ?>
                    </div>
                <?php
                endif; // icon
                ?>

                <div class="cta__title">
                    <?php
                    if ($template['show_title']) :
                        // Link
                        if (hush_get_theme_option_value($settings, 'linktype') == "link" && $template['add_link'] && !$template['extended']) :
                            $title_link = hush_get_button($template['link']);
                    ?>
                            <a href="<?php echo $title_link['link']; ?>">
                                <h2 class="bold"><?php echo $template['title']; ?></h2>
                            </a>
                        <?php
                        else :
                        ?>
                            <h2 class="bold"><?php echo $template['title']; ?></h2>
                    <?php
                        endif; // link
                    endif; // show_title
                    ?>
                </div>

                <?php
                // Exended 
                if ($template['extended']) :
                ?>
                    <div class="cta__extended">
                        <?php
                        $sections = $template['sections'];
                        foreach ($sections as $section) :

                            // link
                            $link_section = hush_get_theme_option_value($settings, 'linktype') == "link" && $section['add_link'] ? "link" : null;

                        ?>
                            <div class="cta__extended__section <?php echo $link_section ?? null; ?> <?php echo 'cta__extended__section--' . count($sections); ?>">
                                <?php
                                if (hush_get_theme_option_value($settings, 'linktype') == "link" && $section['add_link']) :
                                    $section_title_link = hush_get_button($section['link']);
                                ?>
                                    <a href="<?php echo $section_title_link['link']; ?>">
                                        <h3><?php echo $section['title']; ?></h3>
                                    </a>

                                <?php
                                else :
                                ?>
                                    <h3><?php echo $section['title']; ?></h3>
                                <?php
                                endif; // link
                                ?>

                                <?php echo $section['text']; ?>

                                <?php
                                if ($section['add_buttons']) :
                                ?>
                                    <div class="cta__buttons">
                                        <?php
                                        foreach ($section['buttons'] as $button) :
                                            get_template_part('components/button', null, [
                                                'button' => $button,
                                                'nobackground' => true,
                                                'white' => $template['background_type'] == 'image' ? true : false,
                                                'color' => $template['background_type'] == 'color' && $template['background_colour'] == 'Primary' ? 'Secondary' : 'Primary',
                                            ]);
                                        endforeach; // section
                                        ?>
                                    </div>
                                <?php
                                endif; // cta extended button
                                ?>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                <?php
                // Text
                else :
                ?>
                    <div class="cta__text">
                        <?php echo $template['text']; ?>
                    </div>
                <?php
                endif; // extended
                ?>
            </div>



            <!-- Button -->
            <?php
            if ($template['add_button'] && !$template['extended'] && hush_get_theme_option_value($settings, 'linktype') == "buttons") :
            ?>
                <div class="cta__right">
                    <div class="cta__buttons">
                        <?php
                        foreach ($template['buttons'] as $button) :
                            get_template_part('components/button', null, [
                                'button' => $button,
                                'nobackground' => hush_get_theme_option_value('cta', 'clearbutton'),
                                'white' => $template['background_type'] != 'none' ? hush_get_theme_option_value('cta', 'whitebutton') : false,
                                'color' => $template['background_type'] == 'color' && $template['background_colour'] == 'Primary' ? 'Secondary' : 'Primary',
                            ]);
                        endforeach; // buttons
                        ?>
                    </div>
                </div>
            <?php
            endif; // template button
            ?>

        </div>
    </div>

<?php
endif; //is_array('template)