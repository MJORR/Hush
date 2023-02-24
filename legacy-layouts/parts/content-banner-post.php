<?php
// background image
if (!is_post_type_archive()) {
    $archive_image = false; // show default image first
    $post_category = get_queried_object();
    if ($post_category) {
        if (get_field('page_images', $post_category)) {
            $images = get_field('page_images', $post_category);
            $alt_tag = $images['alt'];

            if (is_archive()) {
                $archive_image = true; // found an image
            }
        }
    }

    if (!$archive_image) {
        if (get_field('image') && !is_post_type_archive()) :
            $images['image'] = get_field('image');
            $images['image_mobile'] = get_field('image_mobile');

            $image = get_field('image');
            $alt_tag = $image['alt'];
        else :
            $images = get_field('default_page_image', 'option');
            $alt_tag = $images['alt'];
        endif;
    }

    // show background image
    if (hush_get_theme_option_value($args['settings'], 'type') == 'wholeimage' && isset($images))
        get_template_part('components/background', null, ['background' => $images]);
}


//opacity
if (!is_null($args['opacity_color'])) {
    if ($args['plain'] == false && hush_get_theme_option_value($args['settings'], 'bgopacity_type') == "full") {
        get_template_part('components/darken', null, ['color' => $args['opacity_color']]);
    } else {
        get_template_part('components/opacity', null, ['color' => $args['opacity_color']]);
    }
}

?>

<div class="banner__slides__outer">
    <div class="banner__slides__inner">

        <div class="banner__slides__inner__content">

            <?php
            if (hush_get_theme_option_value($args['settings'], 'text_background'))
                get_template_part('components/darken', null, ['color' => hush_get_theme_option_value($args['settings'], 'content_bg')]);
            ?>

            <div class="banner__slides__inner__block">

                <?php
                // Backlink
                if (hush_get_theme_option_value('posts-post', 'show_back_link') ?? true)
                    get_template_part('layouts/parts/backlink');

                // Title
                if ($args['custom_title']) : // Only show below for normal posts
                    echo $args['custom_title'];
                else :
                ?>

                    <div class="banner__title">
                        <h1>
                            <?php
                            //override title
                            if (get_field('page_title')) :
                                the_field('page_title');
                            
                            // archive title
                            elseif (is_post_type_archive()) :
                                $post_type = 'posts-' . get_post_type();
                                $title = hush_get_theme_post_option_value('name');

                                echo $title == "" ? post_type_archive_title() : $title;

                            // category
                            elseif (is_category()) :
                                echo $post_category->name;

                            // tag
                            elseif (is_tag()) :
                                $tag = get_queried_object();
                                echo $tag->name;

                            // author
                            elseif (is_author()) :
                                $author = get_user_by('slug', get_query_var('author_name'));
                                echo $author->display_name;

                            // post title
                            else :
                                the_title();

                            endif; 
                            ?>
                        </h1>
                    </div>


                    <?php
                    // content
                    if (is_category()) :
                        $post_type = 'posts-' . get_post_type();

                        if ($post_category->description) :
                    ?>
                            <div class="banner__text">
                                <?php echo wpautop($post_category->description); ?>
                            </div>

                        <?php
                        endif; // $post_category->description
                    elseif (!is_archive()) : // is_category
                        if (get_field('page_text')) :
                        ?>
                            <div class="banner__text">
                                <?php the_field('page_text'); ?>
                            </div>
                    <?php
                        endif; // page_text
                    endif; // is_category
                    ?>

                    <?php
                    $title_buttons = get_field('page_buttons');
                    if ($title_buttons['add_buttons'] ?? false) :
                    ?>
                        <div class="banner__slides__buttons">
                            <?php
                            // invert
                            $invert = false;

                            if (hush_get_theme_option_value($args['settings'], 'type') != 'wholeimage' && hush_get_theme_option_value($args['settings'], 'invertbutton')) {
                                $invert = true; // invert if not whole image
                            } elseif (hush_get_theme_option_value($args['settings'], 'bgbutton') && hush_get_theme_option_value($args['settings'], 'invertbutton')) {
                                $invert = true; // invert if buttons same colour as background
                            }


                            // buttons
                            foreach ($title_buttons['buttons'] as $button) :
                                get_template_part('components/button', null, [
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

                <?php
                endif; // custom title
                ?>
            </div>
        </div>

        <?php
        // Type Image Inline
        if (hush_get_theme_option_value($args['settings'], 'type') == 'image') :
        ?>

            <div class="banner__slides__inner__image">
                <img src="<?php echo $images['image']['sizes']['large']; ?>" alt="<?php echo $alt_tag; ?>">
            </div>
        <?php
        endif; // type == image
        ?>
    </div>
</div>