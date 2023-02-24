<?php

$link = $args['link'];
$term = $link['post'];


$company = get_field('company', $term->ID);

//content
$content = get_field('content', $term->ID);

if (is_null($content)) :
    $content = get_field('page_text', $term->ID);
else: 
    $content = wp_trim_words( get_field('content', $term->ID ), $num_words = 50, $more = '...' );    
endif;


//images
if ( get_field('image', $term->ID) ) :
    $images = get_field('image', $term->ID);
    $image = $images['url'];
    $mobile_image = $image['image_mobile']['url'] ?? null;    
else:
    $images = get_field('default_page_image', 'option');
    $image = $images['image']['url'];
    $mobile_image = $image['image_mobile']['url'] ?? null;
endif;

if ($mobile_image) {
    $mobile_style = 'background-image: url(\'' . $mobile_image . '\');';
}

?>

<a href="<?php echo get_permalink($term->ID); ?>">
    <div class="tiles__links__container <?php echo hush_get_theme_options('tiles'); ?> ">

        <?php if (hush_get_theme_option_value('tiles', 'display_background_image') == true) { ?>

        <?php
        get_template_part('components/opacity', null, [
            'color'     => 'primary',
            'full'      => true,
        ]);
        ?>


        <div class="tiles__content" style="background-image:url('<?php echo $image ?? null; ?>');">

            <?php
            // Mobile Image
            if (!is_null($mobile_image)) :
            ?>
                <div class="background__mobile" style="<?php echo $mobile_style ?? null; ?>"></div>
            <?php
            endif; // type == image
            ?>

        <?php } else { ?>
            <div class="tiles__content">
        <?php } ?>    

            

            <div class="tiles__title">

                <?php if (hush_get_theme_option_value('tiles', 'display_icon') == true) { ?>
                    <div class="tiles__icon">
                        <?php if (get_field('page_icon', $term->ID)) {
                            get_template_part('components/icon', null, [
                                'icon'      => get_field('page_icon', $term->ID),
                            ]);
                        } else { ?>
                            <div class="icon">
                                <i class="fas fa-file"></i>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <h3><?php echo $term->post_title; ?></h3>

                <?php //echo $company; ?>

            </div>

            <?php if (hush_get_theme_option_value('tiles', 'display_description') == true) { ?>
                <div class="tiles__description">
                    <p><?php echo $content; ?></p>
                </div>
            <?php } ?>

            <?php if (hush_get_theme_option_value('tiles', 'display_button') == true) { ?>
                <div class="tiles__button">
                    <?php get_template_part('components/button', 'plain', [
                        'text'          => hush_get_theme_option_value('tiles', 'link_prepend') . ' ' . $term->post_title,
                        'nobackground'  => hush_get_theme_option_value('tiles', 'button_nobackground'),
                        'white'         => hush_get_theme_option_value('tiles', 'button_white'),
                    ]); ?>
                </div>
            <?php } ?>

        </div>
    </div>
</a>