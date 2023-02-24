<?php

/**
 * Team
 * 
 * Displays team members with options 
 *          - links to the single page
 *          - links to the single page with hover effect  
 *          - display in a popup
 *          - have slide up content
 */

$layout_options = '';

// background
if (get_sub_field('background')) {
    $layout_options .= ' layout-background';
} else {
    $layout_options .= ' layout-nobackground';
}

// get team members
$order_by = get_sub_field('order_by');

// categories
$categories = '';
if (get_sub_field('categories')) {
    $categories = get_terms([
        'taxonomy'  => 'team-category',
    ]);

    // reset if no categories
    $categories = !is_array($categories) ? false : $categories;
}


// filter posts by category
if (get_sub_field('filter')['category'] ?? false) {
    $category_filter = get_sub_field('filter')['category'];

    $search = array(
        'post_type'         => 'team',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array(
                'taxonomy' => 'team-category',
                'field' => 'term_id',
                'terms' => $category_filter
            ),
        ),
    );

    $team_members_to_filter = new WP_Query($search);

    if ($team_members_to_filter->have_posts()) {
        $filter = wp_list_pluck($team_members_to_filter->posts, 'ID');
    }
}


// title and subtitle
$title = get_sub_field('title') ? get_sub_field('title') : false;
$subtitle = get_sub_field('subtitle') ? get_sub_field('subtitle') : false;



// loop through each non category and then each category
if ($categories) {
    // team members without a category
    if (!isset($category_filter)) {
        get_template_part('layouts/parts/team', null, [
            'order_by'          => $order_by,
            'layout_options'    => $layout_options,
            'category'          => false,
            'filter'            => $filter ?? false,
            'title'             => $title,
            'subtitle'          => $subtitle,
        ]);
    }

    // loop each category
    foreach ($categories as $category) {
        // filter category
        if ($category_filter ?? false) {
            $show_category = in_array($category->term_id, $category_filter) ? true : false;
        }

        // load category
        if ($show_category ?? true) {
            get_template_part('layouts/parts/team', null, [
                'order_by'          => $order_by,
                'layout_options'    => $layout_options,
                'category'          => $category,
                'category_title'    => get_sub_field('display_title') ?? false,
                'filter'            => $filter ?? false,
                'title'             => $title,
                'subtitle'          => $subtitle,
            ]);
        }
    }
}

// all teams members (no categories)
else {
    get_template_part('layouts/parts/team', null, [
        'order_by'          => $order_by,
        'layout_options'    => $layout_options,
        'filter'            => $filter ?? false,
        'title'             => $title,
        'subtitle'          => $subtitle,
    ]);
}


// reset globals
global $used_team_title;
$used_team_title = false;

global $popup_ids;
$popup_ids = [];
