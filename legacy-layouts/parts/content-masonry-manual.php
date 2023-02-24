<?php
$link = $args['link'];

$buttonAdd = $link['add_button'];
$button = $link['button'];

// link
$link_a = hush_get_button($button);

// edge
if (hush_get_theme_option_value('masonry', 'display_border') == true) {
    $edge = "border-left: 10px solid ";
    $edge .= $link['colour_edge'] != '' ? "var(--theme-color-" . strtolower(preg_replace('/\s+/', '', $link['colour_edge'])) . ")" : "var(--theme-color-primary)";
}
?>


<a href="<?php echo $link_a['link']; ?>">
    <div class="masonry__links__container <?php echo hush_get_theme_options('masonry'); ?> " style="<?php echo $edge ?? null; ?>">

        <?php if (hush_get_theme_option_value('masonry', 'no_colour_opacity') == true) { ?>
            <?php
            get_template_part('components/opacity', null, [
                'color'     => 'primary',
                'full'      => true,
            ]);
            ?>
        <?php } ?>

        <div class="masonry__content" style="background-image:url('<?php echo $link['background_image']['url']; ?>');">

            <div class="masonry__title">

                <?php if (hush_get_theme_option_value('masonry', 'display_icon') == true) { ?>
                    <div class="masonry__icon">
                        <?php
                        get_template_part('components/icon', null, [
                            'icon'      => $link['icon'],
                        ]);
                        ?>
                    </div>
                <?php } ?>

                <h3><?php echo $link['title']; ?></h3>
            </div>

            <?php if ($link['content']): ?>
                <div class="masonry__description">
                    <?php echo $link['content']; ?>
                </div>
            <?php endif; ?>

            <?php
            // Button
            if ($buttonAdd && hush_get_theme_option_value('masonry', 'display_button')) :
            ?>
                <div class="masonry__button">
                    <?php get_template_part('components/button', 'plain', [
                        'text'          => hush_get_theme_option_value('masonry', 'link_prepend') . ' ' . $link['button']['text'] ?? null,
                        'nobackground'  => hush_get_theme_option_value('masonry', 'button_nobackground'),
                        'white'         => hush_get_theme_option_value('masonry', 'button_white'),
                    ]); ?>
                </div>
            <?php
            endif; // button
            ?>

        </div>
    </div>
</a>