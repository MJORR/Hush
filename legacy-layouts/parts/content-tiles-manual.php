<?php
$link = $args['link'];

$buttonAdd = $link['add_button'];
$button = $link['button'];

// link
$link_a = hush_get_button($button);

?>


<a href="<?php echo $link_a['link']; ?>">
    <div class="tiles__links__container <?php echo hush_get_theme_options('tiles'); ?> ">


        <?php if (hush_get_theme_option_value('tiles', 'display_background_image') == true) { ?>

        <?php
        get_template_part('components/opacity', null, [
            'color'     => 'primary',
            'full'      => true,
        ]);
        ?>

        <div class="tiles__content" style="background-image:url('<?php echo $link['background_image']['url']; ?>');">

        <?php } else { ?>
            <div class="tiles__content">
        <?php } ?>        

            <div class="tiles__title">

                <?php if (hush_get_theme_option_value('tiles', 'display_icon') == true) { ?>
                    <div class="tiles__icon">
                        <?php
                        get_template_part('components/icon', null, [
                            'icon'      => $link['icon'],
                        ]);
                        ?>
                    </div>
                <?php } ?>

                <h3><?php echo $link['title']; ?></h3>
            </div>

            <div class="tiles__description">
                <?php echo $link['content']; ?>
            </div>

            <?php
            // Button
            if ($buttonAdd) :
            ?>
                <div class="tiles__button">
                    <?php get_template_part('components/button', 'plain', [
                        'text'          => hush_get_theme_option_value('tiles', 'link_prepend') . ' ' . $link['button']['text'] ?? null,
                        'nobackground'  => hush_get_theme_option_value('tiles', 'button_nobackground'),
                        'white'         => hush_get_theme_option_value('tiles', 'button_white'),
                    ]); ?>
                </div>
            <?php
            endif; // button
            ?>

        </div>
    </div>
</a>