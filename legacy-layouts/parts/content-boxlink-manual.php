<div class="boxlink__links__outer <?php if ($args['a_column'] ?? false) : echo 'column'; endif; ?>">
    <?php
    $link = $args['link'];

    $args['css_class'] = '';

    // content
    $content = $link['content'];
    $content = strlen($content) > 180 ? substr($content, 0, 180) . "..." : $content;
    $content = strip_tags($content);
    ?>


    <?php
    // Image
    if ($args['links_have_images']) {
        get_template_part('components/background', null, [
            'background' => $link['image']['sizes']['large'],
            'overlay'    => $link['color'],
        ]);
        get_template_part('components/darken');
    }
    ?>



    <div class="boxlink__links__all">
        <div class="boxlink__links__top">

            <div class="boxlink__links__title">
                <?php
                // Icon
                if ($args['show_icon']) :
                ?>
                    <div class="boxlink__links__icon">
                        <?php
                        get_template_part('components/icon', null, [
                            'icon'      => $link['icon'],
                        ]);
                        ?>
                    </div>
                <?php
                endif; // icon
                ?>

                <div class="boxlink__links__header">
                    <h2><?php echo $link['title']; ?></h2>
                </div>
            </div>

            <?php
            // Description
            if ($args['show_description']) :
            ?>
                <div class="boxlink__links__content">
                    <p><?php echo $content; ?></p>
                </div>
            <?php
            endif; // Description
            ?>
        </div>

        <?php
        if ($args['text']) :
        ?>
            <div class="boxlink__links__linktext">
                <?php
                if (hush_get_theme_option_value('boxlink', 'manual_link') && ($args['link']['manual_link'] ?? false)) {
                    $link_title = $args['link']['manual_link_text'];
                } else {
                    $link_title = hush_get_theme_option_value('boxlink', 'link_prepend') . " " . get_the_title($args['link']['post']);

                    if (hush_get_theme_option_value('boxlink', 'link_override'))
                        $link_title = hush_get_theme_option_value('boxlink', 'link_override_text');
                }


                if (hush_get_theme_option_value('boxlink', 'linktype') == 'button') :
                    get_template_part('components/button', 'plain', [
                        //'text'  => hush_get_theme_option_value('boxlink', 'link_prepend') . ' ' . $link['title']
                        'white' => hush_get_theme_option_value('boxlink', 'button_white'),
                        'text'  => $link_title,
                    ]);

                elseif (hush_get_theme_option_value('boxlink', 'linktype') == 'arrow') :
                    get_template_part('components/arrow', 'plain', [
                        //'text'  => hush_get_theme_option_value('boxlink', 'link_prepend') . ' ' . get_the_title($args['link']['post']),
                        'text'  => $link_title,
                    ]);

                else :
                ?>
                    <?php echo hush_get_theme_option_value('boxlink', 'link_prepend'); ?>
                    <?php echo $link['title']; ?>
                <?php
                endif; // linktype
                ?>
            </div>
        <?php
        endif; // text
        ?>
    </div>

</div>