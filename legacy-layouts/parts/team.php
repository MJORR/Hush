<?php
// search
$search = array(
    'post_type'         => 'team',
    'post_status'       => 'publish',
    'posts_per_page'    => -1,
    'order'             =>  $args['order_by'] == 'admin' ? 'DESC' : 'ASC',
    'orderby'           => $args['order_by'] ?? false,
);

// category
if (isset($args['category']) ?? false) {
    // get team with category
    if ($args['category']) {
        $search['tax_query'] = array(
            array(
                'taxonomy' => 'team-category',
                'field' => 'term_id',
                'terms' => $args['category']
            ),
        );
    }
    // non category team members
    else {
        $search['tax_query'] = array(
            array(
                'taxonomy' => 'team-category',
                'terms'    => get_terms('team-category', ['fields' => 'ids']),
                'operator' => 'NOT IN'
            ),
        );
    }
}

// filter (by team member)
if ($args['filter']) {
    $search['post__in'] = $args['filter'];
}

$posts = new WP_Query($search);

// return page
$return_page = get_the_ID();

// settings
$settings = 'team';
$styleTeam = hush_get_theme_option_value($settings, 'style');

?>

<?php
if ($posts->have_posts()) :
?>
    <div class="team <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('team'); ?> <?php echo $args['layout_options']; ?>">

        <div class="team__members">

            <?php
            global $used_team_title;
            if (!$used_team_title ?? true) :
                $used_team_title = true;

                // subtitle
                if ($args['subtitle'] ?? false) :
            ?>
                    <h3><?php echo get_sub_field('subtitle'); ?></h3>
                <?php
                endif;

                // title
                if ($args['title'] ?? false) :
                ?>
                    <h2><?php echo get_sub_field('title'); ?></h2>
            <?php
                endif;
            endif; // used titles
            ?>

            <?php
            // Category
            if (($args['category'] ?? false) && $args['category_title'] ?? false) :
                $category = $args['category'];
            ?>
                <div class="team__category">
                    <h4><?php echo $category->name; ?></h4>
                </div>

                <?php if (hush_get_theme_option_value('team', 'category_description') == true) : ?>
                    <div class="team__category__description">
                        <p><?php echo $category->description; ?></p>
                    </div>
                <?php endif; ?>
            <?php
            endif; // category
            ?>

            <div class="team__members__outer">
                <?php
                while ($posts->have_posts()) : $posts->the_post();

                    // image
                    if (get_field('image')) :
                        $image = get_field('image');
                    else :
                        $image = get_field('default_page_image', 'option');
                    endif;

                    $linkedin = get_field('linkedin');
                    $instagram = get_field('instagram');
                    $facebook = get_field('facebook');
                    $twitter = get_field('twitter');

                    //popup
                    $popup = null;
                    if ($styleTeam == 'pop-up') {
                        $popup = 'data-featherlight=".popup-' . get_the_ID() . '" data-featherlight-persist="false"';
                    }
                ?>

                    <div class="team__members__person <?php echo $styleTeam; ?>" data-target="<?php the_ID(); ?>" <?php hush_animation(); ?>>
                        <a href="<?php echo get_permalink(); ?>?return=<?php echo $return_page; ?>" class="main" data-target="<?php the_ID(); ?>" <?php echo $popup; ?>>
                            <div class="team__members__image">
                                <?php get_template_part('components/background', null, ['background' => $image]); ?>

                                <?php if (hush_get_theme_option_value('team', 'hover') == true) : ?>

                                    <?php $hover = get_field('hover_content'); ?>

                                    <div class="team__members__hover">
                                        <div class="team__members__title">
                                            <?php the_title(); ?>
                                        </div>

                                        <div class="team__members__role">
                                            <small><?php the_field('role'); ?></small>
                                        </div>

                                        <?php if (hush_get_theme_option_value('team', 'hover_description') == true) : ?>
                                            <div class="team__members__hover__content">
                                                <?php echo $hover; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php
                                        // Social
                                        if (hush_get_theme_option_value('team', 'social_media') == true) :
                                        ?>
                                            <?php
                                            if ($linkedin || $instagram || $facebook || $twitter != '') :
                                            ?>
                                                <div class="team__members__social">
                                                    <ul class="social">
                                                        <?php if ($linkedin != '') { ?> <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php } ?>
                                                        <?php if ($instagram != '') { ?> <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fa-fw fab fa-instagram"></i></a></li><?php } ?>
                                                        <?php if ($facebook != '') { ?> <li><a href="<?php echo $facebook; ?>" target="_blank"><i class="fa-fw fab fa-facebook"></i></a></li><?php } ?>
                                                        <?php if ($twitter != '') { ?> <li><a href="<?php echo $twitter; ?>" target="_blank"><i class="fa-fw fab fa-twitter"></i></a></li><?php } ?>
                                                    </ul>
                                                </div>
                                            <?php
                                            endif; // linkedin, instagram, facebook and twitter
                                            ?>
                                        <?php
                                        endif; // team social_media
                                        ?>

                                        <a href="<?php echo get_permalink(); ?>?return=<?php echo $return_page; ?>">
                                            <div class="button option-secondary <?php echo hush_get_theme_options('buttons'); ?>"><?php _e('Read More', 'hush-parent'); ?> </div>
                                        </a>

                                    </div>

                                <?php endif; ?>

                                <?php if (hush_get_theme_option_value('team', 'click_to_find_more') == true) : ?>
                                    <div class="team__members__image__more">
                                        <p>Click to find out more</p>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </a>

                        <?php
                        //dont display any content before hover
                        if (hush_get_theme_option_value('team', 'hover') == true) : ?>

                        <?php else : ?>
                            <div class="team__members__content">
                                <a href="<?php echo get_permalink(); ?>?return=<?php echo $return_page; ?>" class="main" data-target="<?php the_ID(); ?>" <?php echo $popup; ?>>
                                    <div class="team__members__title">
                                        <?php the_title(); ?>
                                    </div>

                                    <div class="team__members__role">
                                        <small><?php the_field('role'); ?></small>
                                    </div>
                                </a>

                                <?php
                                // Social
                                if (hush_get_theme_option_value('team', 'social_media') == true && hush_get_theme_option_value('team', 'below_description') == true) :
                                ?>

                                    <?php
                                    if ($linkedin || $instagram || $facebook || $twitter != '') :
                                    ?>
                                        <div class="team__members__social">
                                            <ul class="social">
                                                <?php if ($linkedin != '') { ?> <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php } ?>
                                                <?php if ($instagram != '') { ?> <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fa-fw fab fa-instagram"></i></a></li><?php } ?>
                                                <?php if ($facebook != '') { ?> <li><a href="<?php echo $facebook; ?>" target="_blank"><i class="fa-fw fab fa-facebook"></i></a></li><?php } ?>
                                                <?php if ($twitter != '') { ?> <li><a href="<?php echo $twitter; ?>" target="_blank"><i class="fa-fw fab fa-twitter"></i></a></li><?php } ?>
                                            </ul>
                                        </div>
                                    <?php
                                    endif; // linkedin, instagram, facebook and twitter
                                    ?>

                                <?php
                                endif; // team social_media
                                ?>

                                <?php
                                // Inner
                                $inner = get_field('slide_up_content');
                                if ($inner) :
                                ?>
                                    <div class="team__members__inner">
                                        <?php echo $inner; ?>
                                    </div>
                                <?php
                                endif; // inner
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Popup
                        global $popup_ids;
                        $popup_ids = !is_array($popup_ids) ? $popup_ids = [] : $popup_ids;

                        if ($styleTeam == 'pop-up' && !in_array(get_the_ID(), $popup_ids)) :
                            $popup_ids[] = get_the_ID();
                        ?>
                            <div class="team__members__popup <?php if (hush_get_theme_option_value('team', 'display_in_columns') == true) : ?> display_in_columns <?php endif; ?> popup-<?php the_ID(); ?>" data-target="<?php the_ID(); ?>">
                                <!--<i class="fa fa-times"></i>-->
                                <div class="team-member-popup__wrapper">

                                    <div class="team__members__person">

                                        <div class="image">
                                            <?php get_template_part('components/background', null, ['background' => $image]); ?>
                                        </div>

                                        <div class="team__members__content">
                                            <div class="titleinner">
                                                <div class="team__members__title">
                                                    <?php the_title(); ?>
                                                </div>

                                                <div class="team__members__role">
                                                    <small><?php the_field('role'); ?></small>
                                                </div>


                                            </div>

                                            <?php if (hush_get_theme_option_value('team', 'social_media') == true) { ?>
                                                <?php if ($linkedin || $instagram != '') { ?>
                                                    <div class="team__members__social">
                                                        <?php if (hush_get_theme_option_value('team', 'display_social_media_title') == true) { ?>
                                                            <?php echo hush_get_theme_option_value('team', 'social_media_title'); ?>
                                                        <?php } ?>
                                                        <ul class="social">
                                                            <?php if ($linkedin != '') { ?> <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li><?php } ?>
                                                            <?php if ($instagram != '') { ?> <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fa-fw fab fa-instagram"></i></a></li><?php } ?>
                                                            <?php if ($facebook != '') { ?> <li><a href="<?php echo $facebook; ?>" target="_blank"><i class="fa-fw fab fa-facebook"></i></a></li><?php } ?>
                                                            <?php if ($twitter != '') { ?> <li><a href="<?php echo $twitter; ?>" target="_blank"><i class="fa-fw fab fa-twitter"></i></a></li><?php } ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php
                                            // Inner
                                            $inner = get_field('popup_content');
                                            if ($inner) :
                                            ?>
                                                <div class="team__members__inner">
                                                    <?php echo $inner; ?>
                                                </div>
                                            <?php
                                            endif; // inner
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif; // Popup type
                        ?>

                    </div>



                <?php
                endwhile; // posts
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php
endif; // posts->have_posts
?>