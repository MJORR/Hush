<?php

/**
 * Author
 * 
 * Displays the author of a post or page.
 * 
 */

$post_date = get_the_date('M jS, Y', $post->ID);
$get_author_id = get_the_author_meta('ID');
$get_author_description = get_the_author_meta('description');
$get_author_email = get_the_author_meta('email');
$get_author_facebook = get_the_author_meta('facebook');
$get_author_instagram = get_the_author_meta('instagram');
$get_author_linkedin = get_the_author_meta('linkedin');
$get_author_twitter = get_the_author_meta('twitter');
$get_author_youtube = get_the_author_meta('youtube');



// profile image
if (get_field('profile_image', "user_" . $get_author_id)) {
    $image = get_field('profile_image', "user_" . $get_author_id);

    if ($image) {
        $get_author_gravatar = $image['sizes']['large'];
    } else {
        $get_author_gravatar = get_avatar_url($get_author_id);
    }
} else {
    $get_author_gravatar = get_avatar_url($get_author_id);
}




if (hush_get_theme_option_value('author', 'override_user_profile_colour') == true) {
    $get_author_colour = hush_get_theme_option_value('author', 'new_user_profile_colour');
} elseif (get_the_author_meta('profile_color') != '') {
    $get_author_colour = get_the_author_meta('profile_color');
} else {
    $get_author_colour = ' transparent';
}

$layout_options = '';

// background
if (get_sub_field('background')) {
    if (get_sub_field('background_type') == 1) {
        $layout_options .= ' layout-background-color option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour')));
    } else {
        $layout_options .= ' layout-background';
    }
} else {
    $layout_options .= ' layout-nobackground';
}

?>

<div <?php hush_animation(); ?> class="author <?php echo ($is_preview) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('author'); ?>  <?php if (hush_get_theme_option_value('author', 'background_container') != true) {
                                                                                                                                                    echo $layout_options ?? null;
                                                                                                                                                } else {
                                                                                                                                                    echo "layout-nobackground";
                                                                                                                                                    if (get_sub_field('background')) : echo " option-background_container";
                                                                                                                                                    endif;
                                                                                                                                                } ?>">
    <div class="container  <?php if (hush_get_theme_option_value('author', 'background_container') == true) {
                                echo $layout_options ?? null;
                            } ?>">

        <div class="user-info">
            <?php if (hush_get_theme_option_value('author', 'display_user_image') == true) { ?>
                <div class="image">
                    <?php echo '<img style="border: 5px solid' . $get_author_colour . ' " src="' . $get_author_gravatar . '" />'; ?>
                </div>
            <?php } ?>

            <div class="content">
                <h3><?php echo get_the_author_meta('display_name', $get_author_id); ?></h3>

                <?php if (hush_get_theme_option_value('author', 'display_date') == true) { ?>
                    <p><?php echo $post_date; ?></p>
                <?php } ?>

                <?php if (hush_get_theme_option_value('author', 'display_description') == true) { ?>
                    <p><?php echo $get_author_description; ?></p>
                <?php } ?>

                <?php if (hush_get_theme_option_value('author', 'display_email') == true) { ?>
                    <p><a href="mailto:<?php echo $get_author_email; ?>"><?php echo $get_author_email; ?></a></p>
                <?php } ?>

                <?php
                // social media
                if (hush_get_theme_option_value('author', 'display_social_media') == true) {

                    if ($get_author_facebook != '' || $get_author_instagram != '' || $get_author_linkedin != '' || $get_author_twitter != '' || $get_author_youtube != '') :
                ?>


                        <div class="social-media">

                            <?php if ($get_author_facebook != '') { ?>
                                <a href="<?php echo $get_author_facebook; ?>" target="_blank" aria-label="Facebook">
                                    <i class="fa-fw fab fa-facebook"></i>
                                    <div class="sr-only"><?php echo $get_author_facebook; ?></div>
                                </a>
                            <?php } ?>

                            <?php if ($get_author_instagram != '') { ?>
                                <a href="<?php echo $get_author_instagram; ?>" target="_blank" aria-label="Instagram">
                                    <i class="fa-fw fab fa-instagram"></i>
                                    <div class="sr-only"><?php echo $get_author_instagram; ?></div>
                                </a>
                            <?php } ?>

                            <?php if ($get_author_linkedin != '') { ?>
                                <a href="<?php echo $get_author_linkedin; ?>" target="_blank" aria-label="Linkedin">
                                    <i class="fa-fw fab fa-linkedin"></i>
                                    <div class="sr-only"><?php echo $get_author_linkedin; ?></div>
                                </a>
                            <?php } ?>

                            <?php if ($get_author_twitter != '') { ?>
                                <a href="<?php echo $get_author_twitter; ?>" target="_blank" aria-label="Twitter">
                                    <i class="fa-fw fab fa-twitter"></i>
                                    <div class="sr-only"><?php echo $get_author_twitter; ?></div>
                                </a>
                            <?php } ?>

                            <?php if ($get_author_youtube != '') { ?>
                                <a href="<?php echo $get_author_youtube; ?>" target="_blank" aria-label="Youtube">
                                    <i class="fa-fw fab fa-youtube"></i>
                                    <div class="sr-only"><?php echo $get_author_youtube; ?></div>
                                </a>
                            <?php } ?>
                        </div>

                <?php
                    endif;
                } ?>
            </div>
        </div>

    </div>
</div>