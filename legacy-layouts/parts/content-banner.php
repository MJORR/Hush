<?php
// background image
if (hush_get_theme_option_value($args['settings'], 'type') == 'wholeimage')
    get_template_part('components/background', null, ['background' => get_sub_field('background')]);

//opacity
if (!is_null($args['opacity_color'])) {
    if ($args['plain'] == false && hush_get_theme_option_value($args['settings'], 'bgopacity_type') == "full") {
        get_template_part('components/darken', null, ['color' => $args['opacity_color']]);
    } else {
        get_template_part('components/opacity', null, ['color' => $args['opacity_color']]);
    }
}

// title image
$title_image = hush_get_theme_option_value($args['settings'], 'titleimage') ? get_sub_field('title_image') : false;
$title_image_placement = hush_get_theme_option_value($args['settings'], 'titleimageabove');
?>

<div class="banner__slides__outer">
    <div class="banner__slides__inner <?php echo $title_image ? 'option-titleimage' : null; ?> <?php echo $title_image_placement ? 'option-titleimageabove' : null; ?>">



        <div class="banner__slides__inner__content">

            <?php
            if (hush_get_theme_option_value($args['settings'], 'text_background') && hush_get_theme_option_value($args['settings'], 'type') == 'wholeimage')
                get_template_part('components/darken', null, ['color' => hush_get_theme_option_value($args['settings'], 'content_bg')]);
            ?>

            <div class="banner__slides__inner__block">
                <div class="banner__slides__inner__block__content">

                    <?php
                    // 
                    if (hush_get_theme_option_value("banner", "text_in_link")) :
                    ?>

                    <?php if ( get_sub_field('turn_text_into_link')): ?>
                        <a href="<?php echo get_sub_field('link'); ?>" class="banner__textlink">
                    <?php endif; ?>

                    <?php
                    endif; 
                    ?>

                    <?php
                    // Subtitle
                    if (hush_get_theme_option_value("frontbanner", "sub_title") && get_sub_field('subtitle')) :
                    ?>
                        <div class="banner__subtitle">
                            <h3><?php the_sub_field('subtitle'); ?></h3>
                        </div>
                    <?php
                    // Type Image Inline
                    elseif (hush_get_theme_option_value($args['settings'], 'type') == 'image' && get_sub_field('subtitle')) :
                    ?>
                        <div class="banner__subtitle">
                            <h3><?php the_sub_field('subtitle'); ?></h3>
                        </div>
                    <?php
                    endif; // type == image
                    ?>

                    <div class="banner__title">
                        <h1><?php the_sub_field('title'); ?></h1>
                    </div>

                    <?php
                    // title image
                    if ($title_image) :
                    ?>
                        <div class="banner__titleimage">
                            <img src="<?php echo $title_image['sizes']['large']; ?>" alt="<?php echo $title_image['alt']; ?>">
                        </div>
                    <?php
                    endif; // title_image
                    ?>

                    <div class="banner__text">
                        <?php
                        if (get_sub_field('content')) :
                            the_sub_field('content');
                        else :
                            the_sub_field('text'); // legacy
                        endif;
                        ?>

                        <?php
                        //tippy text option
                        //if (is_front_page()):
                        if (is_front_page() || is_page_template( 'templates/front-page.php' )):
                            if (hush_get_theme_option_value("frontbanner", "tippy_text") ) :
                                if (have_rows('extra_text')) :
                                    while (have_rows('extra_text')) : the_row(); ?>
                                           
                                        <p><?php echo get_sub_field('main_text'); ?> <i data-tippy-content="<?php the_sub_field('hidden_text'); ?>" class="fal fa-info-circle"></i></p>

                                    <?php endwhile;
                                endif;                            
                            endif; 
                        endif; ?>
                    </div>


                    <?php
                    // 
                    if (hush_get_theme_option_value("banner", "text_in_link")) :
                    ?>

                    <?php if ( get_sub_field('turn_text_into_link')): ?>
                        </a>
                    <?php endif; ?>

                    <?php
                    endif; 
                    ?>

                </div>

                <?php
                // button or arrow
                if (get_sub_field('add_buttons')) :
                ?>
                    <div class="banner__slides__buttons">
                        <?php
                        $button_type = $args['button'];

                        // invert
                        $invert = false;

                        if (hush_get_theme_option_value($args['settings'], 'type') != 'wholeimage' && hush_get_theme_option_value($args['settings'], 'invertbutton')) {
                            $invert = true; // invert if not whole image
                        } elseif (hush_get_theme_option_value($args['settings'], 'bgbutton') && hush_get_theme_option_value($args['settings'], 'invertbutton')) {
                            $invert = true; // invert if buttons same colour as background
                        }


                        // buttons or arrow
                        foreach (get_sub_field('buttons') as $button) :
                            get_template_part('components/' . $button_type, null, [
                                'color'         => hush_get_theme_option_value($args['settings'], 'bgbutton') ? hush_get_theme_option_value($args['settings'], 'bg_color') : null,
                                'button'        => $button,
                                'nobackground'  => hush_get_theme_option_value($args['settings'], 'clearbutton'),
                                'white'         => !$args['plain'] ? hush_get_theme_option_value($args['settings'], 'whitebutton') : false,
                                'invert'        => !$args['plain'] ? $invert : false,
                            ]);
                        endforeach; // buttons
                        ?>
                    </div>
                <?php
                endif; // add_buttons 
                ?>
            </div>

        </div>

        <?php
        // Type Image Inline
        if (hush_get_theme_option_value($args['settings'], 'type') == 'image') :
            $image = get_sub_field('image');
            $alt_tag = $image['alt'];
        ?>

            <div class="banner__slides__inner__image">
                <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $alt_tag; ?>">
            </div>
        <?php
        endif; // type == image
        ?>
    </div>
</div>