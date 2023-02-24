<div class="hero" style="background-image: url(<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]; ?>)">
    <div class="container">
        <div class="hero__feature">

            <?php the_title('<h1>', '</h1>'); ?>

            <div class="hero__subtitle">
                <?php the_excerpt(); ?>
            </div>

            <?php
            // ACF Hero group
            $link = get_field('cta_button');

            if ($link) :
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            ?>

                <a class="hush-btn-primary | option-end-rounded" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                    <?php echo esc_html($link_title); ?>
                </a>

            <?php endif; ?>

        </div>
    </div>
</div>
