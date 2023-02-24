<div class="boxlink__links__outer <?php if ($args['a_column'] ?? false) : echo 'column'; endif; ?>">
    
    <?php
    // content
    if (get_field('page_text', $args['link']['post']->ID)) :
        $content = get_field('page_text', $args['link']['post']->ID);
    else :
        $content = get_extended($args['link']['post']->post_content);
        $content = apply_filters('the_content', $content['main']);
    endif;

    $content = strlen($content) > 180 ? substr($content, 0, 180) . "..." : $content;
    $content = strip_tags($content);
    ?>

    <?php
    // Image
    if ($args['links_have_images']) {
        if (get_field('image_square', $args['link']['post']->ID)) {
            $image = get_field('image_square', $args['link']['post']->ID);
        } else {
            if (get_field('image', $args['link']['post']->ID)) :
                $image = get_field('image', $args['link']['post']->ID);
            else :
                $image = get_field('default_page_image', 'option');
                $image = $image['image'];
            endif;
        }

        get_template_part('components/background', null, [
            'background'    => $image['sizes']['large'],
            'overlay'       => $args['link']['color'],
            'mobile-only'   => true,
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
                            'icon'      => get_field('page_icon', $args['link']['post']->ID),
                        ]);
                        ?>
                    </div>
                <?php
                endif; // icon
                ?>

                <div class="boxlink__links__header">
                    <h2>
                        <?php
                        // title
                        if (get_field('page_title', $args['link']['post']->ID)) :
                            the_field('page_title', $args['link']['post']->ID);
                        else :
                            echo get_the_title($args['link']['post']);
                        endif;
                        ?>
                    </h2>
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
                if (hush_get_theme_option_value('boxlink', 'linktype') == 'button') :
                    get_template_part('components/button', 'plain', [
                        'text'  => hush_get_theme_option_value('boxlink', 'link_prepend') . ' ' . get_the_title($args['link']['post']),
                        'white' => hush_get_theme_option_value('boxlink', 'button_white'),
                        'color' => $args['link']['color']
                    ]);

                elseif (hush_get_theme_option_value('boxlink', 'linktype') == 'arrow') :
                    get_template_part('components/arrow', 'plain', [
                        'text'  => hush_get_theme_option_value('boxlink', 'link_prepend') . ' ' . get_the_title($args['link']['post']),
                    ]);

                else :
                ?>
                    <?php echo hush_get_theme_option_value('boxlink', 'link_prepend'); ?>
                    <?php echo get_the_title($args['link']['post']); ?>
                <?php
                endif; // linktype
                ?>
            </div>
        <?php
        endif; // text
        ?>



    </div>

</div>