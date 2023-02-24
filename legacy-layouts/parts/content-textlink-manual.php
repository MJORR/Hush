<?php
$link = $args['link'];

// content
$content = $link['content'];
$content = strlen($content) > 180 ? substr($content, 0, 180) . "..." : $content;
$content = strip_tags($content);

// link
$link_a = hush_get_button($link['link']);
?>

<a href="<?php echo $link_a['link']; ?>" <?php echo $link_a['tab'] ? 'target="_blank"' : ''; ?> <?php echo $link_a['download_file'] ? 'download' : null; ?>>
    <div class="textlink__links__all">

        <div class="textlink__links__title">
            <div class="textlink__links__icon">
                <?php
                get_template_part('components/icon', null, [
                    'icon'      => $link['icon'],
                ]);
                ?>
            </div>
        </div>

        <div class="textlink__links__content">
            <h3><?php echo $link['title']; ?></h3>

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
                        'text'          => $link_title,
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