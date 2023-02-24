<?php

/**
 * Posts
 * 
 * Displays posts in link form and can be filtered by category or by tag, also displays the posts on the post archive page.
 */

$layout_options = '';

// pagination
if (isset($args['pagination']) ?? false) {
    $pagination_show = $args['pagination'];
}

$extra_classes = "";

$max_pages_displayed = get_sub_field('max_pages');

// color
if ($args['color'] ?? false) {
    $color = hush_convert_option_text($args['color']);
} else {
    $color = hush_convert_option_text(hush_get_theme_option_value('buttons', 'color', false));
}

// nosectioncolor
if ($args['nosectioncolor'] ?? false) {
    $extra_classes .= " option-nosectioncolor";

    $extra_classes .= " " . $color; // color
} else {
    $extra_classes .= " " . hush_replace_section_color($color, "buttons");
}

/* flexible layout post
-------------------------------------------------------- */
if (hush_check_flexible($args) || ($is_preview ?? false)) {

    // hush options
    $options = 'postslinks';

    // slick
    $slick = get_sub_field('slider') ?? true ? true : false;
    if (!$slick)
        $layout_options .= ' option-archive';

    // background
    if (get_sub_field('background')) {
        if (get_sub_field('background_type') == 1) {
            $layout_options .= ' layout-background-color ' . hush_convert_option_text(get_sub_field('background_colour'));
        } else {
            $layout_options .= ' layout-background';
        }
    } else {
        $layout_options .= ' layout-nobackground';
    }

    // date
    $show_date = get_sub_field('date') ? true : false;

    // cards
    if (get_sub_field('cards')) {
        $layout_options .= ' option-cards';

        // border
        if (get_sub_field('cards'))
            $layout_options .= ' option-border';
    }

    // featured
    $featured = false;
    if (get_sub_field('featured')) {
        $layout_options .= ' option-featured';
        $featured = true;
    }


    // category
    $show_category = get_sub_field('show_category') ? true : false;

    // post options
    $display_amount = get_sub_field('num');
    $layout_options .= ' option-show-' . $display_amount;

    $max_posts = get_sub_field('max');

    // posts
    if ($slick) {
        $posts_per_page =  $max_posts == 0 ? -1 : $max_posts;
        $no_found_rows = true;
    } else {
        $posts_per_page = get_sub_field('page_posts') ?? 9;
        $max_num_pages = get_sub_field("max_pages");

        $no_found_rows = $max_num_pages == 1 ? true : false;
    }

    // setup selector
    $selector = "postspage-" . get_row_index();


    global $pagination_used;

    if (is_null($pagination_used)) {
        if (is_front_page()) {
            $paged = get_query_var('page') ? get_query_var('page') : 1;
        } else {
            $paged = !$slick  && get_query_var('paged') ? get_query_var('paged') : 1;
        }
    } else {
        $paged = 1;
    }

    // setup args array
    $args = array(
        'post_type'         => 'post',
        'posts_per_page'    => $posts_per_page ?? -1,
        'paged'             => $paged ?? 1,
        'no_found_rows'     => $no_found_rows ?? false,
    );

    // order by
    if (get_sub_field('order_by')) {
        $args['orderby'] = get_sub_field('order_by');

        if (get_sub_field('order_by') != 'rand')
            $args['order'] = get_sub_field('order_direction');
    }

    // limit posts
    if (get_sub_field('limit_posts')) {
        $args['post__in'] = get_sub_field('posts');
    }

    // get posts
    $posts = new WP_Query($args);


    // filter and re-get posts
    if (!get_sub_field('limit_posts')) {
        $filter = get_sub_field('filter');
        if ($filter['category'] || $filter['tag']) {
            // category
            if ($filter['category']) {
                $args['category__in'] = $filter['category'];
            }

            // tag
            if ($filter['tag']) {
                $args['tag__in'] = $filter['tag'];
            }

            $check = new WP_Query($args);
            if ($check->have_posts()) {
                $posts = $check;
            } elseif (hush_get_theme_option_value($options, 'categorytag_empty')) {
                $posts = $check;
                $empty_message = true;
            }
        }
    }

    // return page (page)
    $return_page = get_the_ID();
}

/* posts archive page
--------------------------------------------------------------------------------------------------------------------- */ else {

    // hush options
    $options = 'posts-post';

    // slick
    $slick = false;

    // achive page
    $layout_options .= ' option-archive';

    // date
    $show_date = hush_get_theme_option_value($options, 'display_date') ? true : false;

    // cards
    if (hush_get_theme_option_value($options, 'cards')) {
        $layout_options .= ' option-cards';

        // border
        if (hush_get_theme_option_value($options, 'cards_border'))
            $layout_options .= ' option-border';
    }

    // featured
    $featured = false;

    // category
    $show_category = hush_get_theme_option_value($options, 'show_category') ? true : false;

    // display amount
    $display_amount = hush_get_theme_option_value($options, 'cols');
    $layout_options .= ' option-show-' . $display_amount;

    // user filters
    $filter_options = hush_get_theme_option_value($options, 'archive_filters');
    if ($filter_options) {
        // custom filters
        if ($filter_options['add_custom_filters']) {
            foreach ($filter_options['custom_filters'] as $custom_filter) {

                // get each category
                foreach ($custom_filter['categories'] as $custom_category) {
                    $filters[$custom_filter['name']][$custom_category] = get_category($custom_category)->name;
                }

                asort($filters[$custom_filter['name']]);
            }
        }

        // category filter
        if ($filter_options['category_filter']) {
            $archive_categories = hush_get_theme_option_value($options, 'archive_categories');

            // get names
            if ($archive_categories) {
                foreach ($archive_categories as $category) {
                    $filters['Category'][$category] = get_category($category)->name;
                }
            } else {
                foreach (get_categories() as $category) {
                    $filters['Category'][$category->term_id] = $category->name;
                }
            }

            // sort
            asort($filters['Category']);
        }

        // date filter
        if ($filter_options['date_filter']) {
            $filters['Date'] = [];
        }
    }

    // selector
    $selector = "archive";

    // setup posts args
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type'         => 'post',
        'posts_per_page'    => hush_get_theme_option_value($options, 'num'),
        'orderby'           => 'ID',
        'order'             => 'DESC',
        'post_status'       => 'publish',
        'paged'             => isset($pagination_show) && $pagination_show == false ? 1 : $paged,
    );

    // author
    if (is_author()) {
        $author = get_user_by('slug', get_query_var('author_name'));
        $args['author'] = $author->ID;
    }

    // tag
    if (is_tag()) {
        $tag = get_queried_object();
        $args['tag'] = $tag->slug;
    }

    // filter
    $filter_default = true;
    $query_vars_names = [];
    if (isset($filters)) {
        $categories_to_filter = []; // setup categories

        // fitler category and date (add filter list for customs)
        foreach ($filters as $filter_index => $filter) {
            if ($filter_index != 'Date') {
                // filter key
                $filter_key = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $filter_index));
                $query_vars_names[] = $filter_key;

                // selected
                $selected = get_query_var($filter_key) ? get_query_var($filter_key) : 0;

                // add to categories_to_filter
                if ($selected > 0) {
                    $categories_to_filter[] = $selected;
                }
            } elseif ($filter_index == 'Date') {
                $filter_dates = true;
                $query_vars_names[] = 'date';

                // filter by date
                if (get_query_var('date')) {
                    $args['monthnum'] = date('m', strtotime(get_query_var('date')));
                    $args['year'] = date('Y', strtotime(get_query_var('date')));
                }
            }
        }

        if (count($categories_to_filter) > 0) {
            $filter_default = false; // remove default categories
            $args['category__and'] = $categories_to_filter;
        }

        // add dates
        if (isset($filter_dates)) {
            $temp_args = $args;

            unset($temp_args['paged']); // remove paged to get all
            $temp_args['posts_per_page'] = -1; // get all posts

            unset($temp_args['monthnum']);
            unset($temp_args['year']);

            $temp_posts = new WP_Query($temp_args);

            if ($temp_posts->have_posts()) {
                while ($temp_posts->have_posts()) : $temp_posts->the_post();
                    $filters['Date'][get_the_date('M Y')] = get_the_date('M Y');
                endwhile;
                wp_reset_postdata();
            }
        }
    }

    // filter posts by category
    if (!is_author() && !is_tag()) {
        $default_category = get_term_by('term_id', get_option('default_category'), 'category');
        $category = is_home() ? $default_category : get_term_by('name', single_cat_title('', false), 'category');

        $show_archive_filters = true;
        $archive_categories = hush_get_theme_option_value($options, 'archive_categories');

        if ($filter_default == true) {

            if ($archive_categories) {
                // category not default
                if ($category->slug != $default_category->slug) {
                    // check if supported category (show category on it's own)
                    if ($archive_categories) {
                        if (!in_array($category->term_id, $archive_categories)) {
                            $args['category__in'] = [$category->term_id];

                            $show_archive_filters = false;
                        }
                    }
                }
                // show default categories
                else {
                    if ($archive_categories) {
                        $args['category__in'] = $archive_categories;
                    }
                }
            }
            // show only category
            else {
                $args['category__in'] = [$category->term_id];
            }
        }
        // add supported catagories to ensure only correct posts are shown
        else {
            if ($archive_categories) {
                $args['cat'] = $archive_categories;
            }
        }
    }

    // get posts
    //print_r($args); //! Testing
    $posts = new WP_Query($args);

    // return page (category)
    $category = get_queried_object();
    $return_page = $category->slug;
}
?>


<div class="posts <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $posts->have_posts() ? "found" : ""; ?> <?php echo $slick ? 'posts--slick' : null; ?> <?php echo hush_get_theme_options('postslinks'); ?> <?php echo $layout_options ?? null; ?>" data-display="<?php echo $display_amount; ?>" data-postspage="<?php echo get_row_index(); ?>" <?php hush_animation(); ?>>

    <?php if (get_sub_field('title')): ?>
        <div class="posts__heading">
            <h2><?php the_sub_field('title'); ?></h2>
        </div>
    <?php endif; ?>

    <?php if (get_sub_field('content')): ?>
        <div class="posts__content">
            <?php the_sub_field('content'); ?>
        </div>
    <?php endif; ?>

    <div class="posts__outer">

        <?php
        // Filters
        if (isset($filters) && $show_archive_filters == true) :
        ?>
            <form id="filterform" method="get" action="" class="dropdowns <?php echo hush_get_theme_options('dropdowns'); ?>">
                <?php
                foreach ($filters as $filter_index => $filter) :
                    // filter key
                    $filter_key = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $filter_index));

                    // selected
                    $selected = get_query_var($filter_key) ? get_query_var($filter_key) : null;
                ?>
                    <div class="dropdowns__filter">
                        <label for="<?php echo $filter_key; ?>"><?php echo $filter_index; ?>:</label>

                        <div class="select_dropdown ">
                            <select name="<?php echo $filter_key; ?>" id="<?php echo $filter_key; ?>">
                                <option value="">All</option>
                                <?php
                                foreach ($filter as $option_index => $option) :
                                ?>
                                    <option value="<?php echo $option_index; ?>" <?php echo $selected == $option_index ? 'selected' : null; ?>><?php echo $option; ?></option>
                                <?php
                                endforeach; // filter
                                ?>
                            </select>
                        </div>
                    </div>
                <?php
                endforeach; // filters
                ?>
            </form>

        <?php
        endif; // filters
        ?>


        <?php
        if ($posts->have_posts()) :
        ?>
            <div class="posts__links__outer">
                <div class="posts__links">
                    <?php
                    while ($posts->have_posts()) : $posts->the_post();

                        // image
                        if (get_field('image_square')) :
                            $image = get_field('image_square');
                        elseif (get_field('image')) :
                            $image = get_field('image');
                        else :
                            $image = get_field('default_page_image', 'option');
                            $image = $image['image'];
                        endif;

                        // return
                        if (hush_get_theme_option_value($options, 'back_links')) {

                            $querys = [
                                'return' => $return_page,
                            ];

                            if ($show_archive_filters ?? false) {
                                foreach ($query_vars_names as $var_name) {
                                    $querys[$var_name] = get_query_var($var_name);
                                }
                            }


                            // back link category
                            if (get_sub_field('back_link_category')) {
                                $terms = wp_get_post_categories(get_the_ID());

                                if ($terms) {

                                    if (count($terms) > 1) {
                                        if (function_exists('yoast_get_primary_term_id')) {
                                            $post_category = yoast_get_primary_term_id('category', get_the_ID());
                                        } else {
                                            $post_category = $terms[0];
                                        }
                                    } else {
                                        $post_category = $terms[0];
                                    }

                                    $post_category = get_category($post_category);

                                    if (isset($post_category->name)) {
                                        if (get_field('override_page', $post_category)) {
                                            $new_page = get_field('override_page', $post_category);
                                            $querys['return'] = $new_page->ID;
                                        }
                                    }
                                }
                            }

                            // process link
                            $link_to_post = add_query_arg($querys, get_permalink());
                        } else {
                            $link_to_post = get_permalink();
                        }
                    ?>
                        <a href="<?php echo $link_to_post; ?>" class="posts__links__link">
                            <div class="posts__links__outerlink">
                                <div class="posts__links__image">
                                    <?php get_template_part('components/background', null, ['background' => $image]); ?>
                                </div>

                                <div class="posts__links__inner">
                                    <div class="posts__links__title">
                                        <h3><?php the_title(); ?></h3>
                                    </div>

                                    <?php
                                    // Date
                                    if ($show_date && !$featured) :
                                    ?>
                                        <div class="posts__links__date">
                                            <small>
                                                <?php echo hush_get_theme_option_value('postslinks', 'date_prepend'); ?>

                                                <?php echo get_the_date(); ?>
                                            </small>
                                        </div>

                                    <?php
                                    endif; // show_date
                                    ?>

                                    <?php
                                    if ($show_category) :
                                        $terms = wp_get_post_categories(get_the_ID());

                                        if ($terms) :

                                            if (count($terms) > 1) {
                                                if (function_exists('yoast_get_primary_term_id')) {
                                                    $post_category = yoast_get_primary_term_id('category', get_the_ID());

                                                    if ($post_category == false) {
                                                        $post_category = $terms[0];
                                                    }
                                                } else {
                                                    $post_category = $terms[0];
                                                }
                                            } else {
                                                $post_category = $terms[0];
                                            }

                                            $post_category = get_category($post_category);

                                            if (isset($post_category->name)) :
                                    ?>
                                                <div class="posts__links__category">
                                                    <?php
                                                    get_template_part('components/categorylabel', null, [
                                                        'text'  => $post_category->name,
                                                        'color' => get_field('category_colour', $post_category),
                                                        'icon'  => get_field('category_icon', $post_category)
                                                    ]);
                                                    ?>
                                                </div>
                                    <?php
                                            endif; // isset($post_category->name)
                                        endif; // terms
                                    endif; // show_category
                                    ?>

                                    <?php
                                    // Text
                                    if (hush_get_theme_option_value('postslinks', 'titletext') && !$featured) :


                                        $content = get_field('page_text');

                                        if ($content == "") {
                                            if (!function_exists("list_searcheable_acf")) { // for admin preview
                                                require_once(get_template_directory() . '/functions/wordpress.php');
                                            }


                                            $fields_to_get = list_searcheable_acf();

                                            if (have_rows('layouts', get_the_ID())) :
                                                while (have_rows('layouts', get_the_ID())) : the_row();
                                                    foreach ($fields_to_get as $field) {
                                                        $field_output = get_sub_field($field);

                                                        if (!is_array($field_output))
                                                            $content .= preg_replace('#\[[^\]]+\]#', '', $field_output) . " ";
                                                    }
                                                endwhile;
                                            endif; // layouts

                                        }

                                        $content = wp_strip_all_tags($content);
                                        $content = strlen($content) > 180 ? substr($content, 0, 180) . "..." : $content;
                                        $content = strip_tags($content);

                                    ?>

                                        <div class="posts__links__text">
                                            <p><?php echo $content; ?></p>
                                        </div>
                                    <?php
                                    endif; // text
                                    ?>

                                    <?php
                                    // Button
                                    if (hush_get_theme_option_value('postslinks', 'button')) :
                                        $button_type = hush_get_theme_option_value('postslinks', 'button_type') ?? 'button';
                                        $button_color = $button_type == "button" && hush_get_theme_option_value('postslinks', 'button_primary') ? "primary" : get_sub_field('background_colour');
                                    ?>
                                        <div class="posts__links__button">
                                            <?php
                                            get_template_part("components/$button_type", 'plain', [
                                                'text'      => hush_get_theme_option_value('postslinks', 'button_text'),
                                                'color'     => $button_color
                                            ]);
                                            ?>
                                        </div>
                                    <?php
                                    endif; // button
                                    ?>
                                </div>
                            </div>
                        </a>
                    <?php
                    endwhile; // posts
                    wp_reset_postdata();
                    ?>
                </div>

                <?php
                // Scrollbar
                if (hush_get_theme_option_value('postslinks', 'scrollbar')) :
                ?>
                    <div class="container">
                        <div class="scrollbar">
                            <div class="handle">
                            </div>
                        </div>
                    </div>
                <?php
                endif; // scrollbar
                ?>
            </div>

        <?php
        // Empty
        elseif ($empty_message ?? false) :
        ?>
            <div class="posts__noresults">
                <i class="far fa-info-circle"></i>
                <h3><?php _e('No posts found', 'hush-parent'); ?></h3>
                <p><?php _e('Please come back again.', 'hush-parent'); ?></p>
            </div>
        <?php
        // No results
        else :
        ?>
            <div class="posts__noresults">
                <i class="fas fa-search"></i>
                <h3><?php _e('No results found', 'hush-parent'); ?></h3>
                <p><?php _e('We could not find anything that matched your search criteria. Please try again.', 'hush-parent'); ?></p>
            </div>

        <?php
        endif; // pages
        ?>
    </div>


    <?php
    // Pagination
    if ($posts->max_num_pages > 1 && !$slick && ($pagination_show ?? true)) :
    ?>
        <div class="posts__paged">
            <?php
            if (function_exists("post_list_pagination") && isset($selector)) :
                // pages
                if ($max_pages_displayed > 1 ?? false)
                    $paged_total_pages = $max_pages_displayed > $posts->max_num_pages ? $posts->max_num_pages : $max_pages_displayed;

                post_list_pagination(
                    $paged_total_pages ?? $posts->max_num_pages,
                    $selector ?? 'page',
                    $category->slug ?? null
                );
            endif; //post_list_pagination
            ?>
        </div>
    <?php
    endif; // pagination 
    ?>


    <?php if (hush_get_theme_option_value('postslinks', 'all_button_location') && get_sub_field('news_button')) :
        $button_text = get_sub_field('news_button_text');
        $button_link = get_sub_field('news_button_link'); ?>
        <div class="posts__button">
            <a href="<?php if ($button_link != '') : echo $button_link; else : echo esc_url(get_permalink(get_option('page_for_posts'))); endif; ?>" class="button  <?php if (hush_get_theme_option_value('postslinks', 'all_button_location_white')): ?> option-white <?php endif; ?> <?php echo hush_get_theme_options('buttons'); ?> <?php echo $extra_classes; ?>"><?php if ($button_text != '') : echo $button_text; else : _e('View all news', 'hush-parent'); endif; ?></a>
        </div>
    <?php endif; ?>


</div>

<?php if (!hush_get_theme_option_value('postslinks', 'all_button_location') && get_sub_field('news_button')) :
    $button_text = get_sub_field('news_button_text');
    $button_link = get_sub_field('news_button_link'); ?>
    <div class="posts__button">
        <a href="<?php if ($button_link != '') : echo $button_link; else : echo esc_url(get_permalink(get_option('page_for_posts'))); endif; ?>" class="button <?php echo hush_get_theme_options('buttons'); ?> <?php echo $extra_classes; ?>"><?php if ($button_text != '') : echo $button_text; else : _e('View all news', 'hush-parent'); endif; ?></a>
    </div>
<?php endif; ?>