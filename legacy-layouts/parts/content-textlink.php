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

<a href="<?php echo the_permalink($args['link']['post']); ?>">
    <div class="textlink__links__all">

        <div class="textlink__links__title">
            <div class="textlink__links__icon">

                <?php if (get_field('page_icon', $args['link']['post']->ID) != '') {

                    get_template_part('components/icon', null, [
                        'icon'      => get_field('page_icon', $args['link']['post']->ID),
                    ]);
                } elseif (get_post_type($args['link']['post']->ID) == 'team') { ?>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>

                <?php } elseif (get_post_type($args['link']['post']->ID) == 'stores') { ?>
                    <div class="icon">
                        <i class="fas fa-store"></i>
                    </div>

                <?php } else { ?>
                    <div class="icon">
                        <i class="fas fa-file"></i>
                    </div>
                <?php } ?>

            </div>
        </div>

        <div class="textlink__links__content">
            <h3>
                <?php
                // title
                if (get_field('page_title', $args['link']['post']->ID)) :
                    the_field('page_title', $args['link']['post']->ID);
                else :
                    echo get_the_title($args['link']['post']);
                endif;
                ?>
            </h3>

            <p><?php echo $content; ?></p>

            <div class="textlink__links__linktext">
                <?php
                if (hush_get_theme_option_value('textlink', 'manual_link') && ($args['link']['manual_link'] ?? false)) {
                    $link_title = $args['link']['manual_link_text'];
                } else {
                    $link_title = hush_get_theme_option_value('textlink', 'link_prepend') . " " . get_the_title($args['link']['post']);

                    if (hush_get_theme_option_value('textlink', 'link_override'))
                        $link_title = hush_get_theme_option_value('textlink', 'link_override_text');
                }

                if (hush_get_theme_option_value('textlink', 'linktype') == 'button') :
                    get_template_part('components/button', 'plain', [
                        'text'  => $link_title
                    ]);

                elseif (hush_get_theme_option_value('textlink', 'linktype') == 'arrow') :
                    get_template_part('components/arrow', 'plain', [
                        'text'  => $link_title,
                    ]);

                else :
                ?>
                    <?php echo $link_title; ?>
                <?php
                endif; // linktype
                ?>
            </div>

        </div>

    </div>
</a>