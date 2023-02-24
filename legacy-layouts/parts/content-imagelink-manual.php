<?php
$link = $args['link'];

// content
$content = $link['content'];
$content = strlen($content) > 180 ? substr($content, 0, 180) . "..." : $content;
$content = strip_tags($content);
?>

<div class="imagelink__links__image">
    <?php
    // Image
    get_template_part('components/background', null, [
        'background' => $link['image']['sizes']['large'],
        'overlay'    => $link['color'],
    ]);
    ?>
</div>

<div class="imagelink__links__outer <?php if (!get_sub_field('overlap_text_image')): echo 'layout-background-color'; endif; ?> <?php if (get_sub_field('add_background_colour')): ?> option-<?php echo strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour'))); ?><?php endif; ?>">

    <div class="imagelink__links__all">
        <div class="imagelink__links__top">

            <div class="imagelink__links__title">
                <?php
                // Icon
                if ($args['show_icon']) :
                ?>
                    <div class="imagelink__links__icon">
                        <?php
                        get_template_part('components/icon', null, [
                            'icon'      => $link['icon'],
                        ]);
                        ?>
                    </div>
                <?php
                endif; // icon
                ?>

                <div class="imagelink__links__header">
                    <h2><?php echo $link['title']; ?></h2>
                </div>
            </div>

            <?php
            // Description
            if ($args['show_description']) :
            ?>
                <div class="imagelink__links__content">
                    <p><?php echo $content; ?></p>
                </div>
            <?php
            endif; // Description
            ?>
        </div>

        <?php
        if ($args['text']) :
        ?>
            <div class="imagelink__links__linktext">
                <?php
                if (hush_get_theme_option_value('imagelink', 'linktype') == 'button') :
                    get_template_part('components/button', 'plain', [
                        'text'  => hush_get_theme_option_value('imagelink', 'link_prepend') . ' ' . $link['title'],
                        'nobackground'  => hush_get_theme_option_value('imagelink', 'button_nobackground'),
                        'white'         => hush_get_theme_option_value('imagelink', 'button_white'),
                    ]);

                elseif (hush_get_theme_option_value('imagelink', 'linktype') == 'arrow') :
                    get_template_part('components/arrow', 'plain', [
                        'text'  => hush_get_theme_option_value('imagelink', 'link_prepend') . ' ' . get_the_title($args['link']['post']),
                    ]);

                else :
                ?>
                    <?php echo hush_get_theme_option_value('imagelink', 'link_prepend'); ?>
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