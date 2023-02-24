<?php

if (is_preview())
    return;

// get all pages and go through and remove if they have 'hide_on_section' set
$exclude_pages = array();
$hide_parent = false;
$show_pagemenu = [0, 1, 2, 3];
$show_breadcrumb = [];

$parent = [];
$children = [];


global $post;

if (is_search()) {
    $home_page = get_post(get_option('page_on_front'));
    if ($home_page) {
        $post = $home_page;
        setup_postdata($post);
    } else {
        return;
    }
}

// override page
if ($args['page'] ?? false) {
    $page_override = get_post($args['page'], OBJECT);

    if (isset($page_override->post_type) == 'page') {
        $post = $page_override;
        setup_postdata($post);
    }
}

// show grandchildren
$show_grandchildren = hush_get_theme_option_value("pagemenu", "dropdown");
$show_megamenu = hush_get_theme_option_value("pagemenu", "megamenu");


// get top level parent
$ancestors = get_post_ancestors($post->ID);
$root = count($ancestors) - 1;

if (isset($ancestors[$root])) {
    $parent_id = $ancestors[$root];
} else {
    $parent_id = 0;
}

/* Get pages to exclude
------------------------------------------------------------------------------------------- */
// child page
if ($post->post_parent) {

    // pagemenu and breadcrumb
    $show_pagemenu = hush_get_theme_option_value('pagemenu', 'toplevel') ? $show_pagemenu : get_field('section_pagemenu', $parent_id);
    $show_breadcrumb = get_field('section_breadcrumb', $parent_id) ?? $show_breadcrumb;

    // parent
    $pages = get_pages([
        'include'  => $parent_id,
    ]);
    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;

            if ($page->ID == $parent_id) {
                $hide_parent = true;
            }
        }
    }

    // child
    if (hush_get_theme_option_value('pagemenu', 'toplevel')) {
        $pages = get_pages([
            'child_of'  => 'front-page',
            'exclude'   => get_option('page_on_front'),
        ]);

        $exclude_pages[] = get_option('page_on_front');

        $parent_id = 'front-page';
    } else {
        $pages = get_pages([
            'child_of'  => $parent_id,
        ]);
    }

    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;
        }

        // grandchilden
        if ($show_grandchildren) {
            $grandchildren_pages = get_pages([
                'child_of'  => $page->ID
            ]);

            foreach ($grandchildren_pages as $grandchild) {
                if (isset($grandchild->hide_on_section) && $grandchild->hide_on_section) {
                    $exclude_pages[] = $grandchild->ID;
                }
            }
        }
    }
}

// parent page
else {
    // pagemenu and breadcrumb
    $show_pagemenu = $post->ID == get_option('page_on_front') || hush_get_theme_option_value('pagemenu', 'toplevel') ? $show_pagemenu : get_field('section_pagemenu') ?? $show_pagemenu;
    $show_breadcrumb = $post->ID == get_option('page_on_front') ? $show_breadcrumb : get_field('section_breadcrumb') ?? $show_breadcrumb;


    // parent
    $pages = get_pages([
        'include'  => $post->ID,
    ]);

    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;

            if ($page->ID == $post->ID) {
                $hide_parent = true;
            }
        }
    }

    // children
    if ($post->ID == get_option('page_on_front') || hush_get_theme_option_value('pagemenu', 'toplevel')) {
        $pages = get_pages([
            'child_of'  => 'front-page',
            'exclude'   => $post->ID == get_option('page_on_front') ? $post->ID : get_option('page_on_front'),
        ]);

        $exclude_pages[] = $post->ID == get_option('page_on_front') ? $post->ID : get_option('page_on_front'); // exclude front page

        $hide_parent = true;
    } else {
        $pages = get_pages([
            'child_of'  => $page->ID,
        ]);
    }

    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;
        }

        // grandchilden
        if ($show_grandchildren) {
            $grandchildren_pages = get_pages([
                'child_of'  => $page->ID
            ]);

            foreach ($grandchildren_pages as $grandchild) {
                if (isset($grandchild->hide_on_section) && $grandchild->hide_on_section) {
                    $exclude_pages[] = $grandchild->ID;
                }
            }
        }
    }
}



/* Setup get_pages arrays
------------------------------------------------------------------------------------------- */
// depth of menu
$menu_depth = 1;
if ($show_grandchildren) {
    $menu_depth = $show_megamenu ? 3 : 2;
}

// from children
if ($post->post_parent) {

    if (!$hide_parent) {
        $parent = [
            'title_li'      => '',
            'include'       => $parent_id,
            'walker'        => new Walker_Menu(),
        ];
    }

    $children = [
        'title_li'      => '',
        'child_of'      => $parent_id,
        'exclude'       => implode(", ", $exclude_pages),
        'depth'         => $menu_depth,
        'walker'        => new Walker_Menu(),
        'current_page'  => $post->ID
    ];
}
// from parent
else {
    if (!$hide_parent) {
        $parent = [
            'title_li'      => '',
            'include'       => $post->ID,
            'walker'        => new Walker_Menu(),
            'current_page'  => $post->ID
        ];
    }

    $children = [
        'title_li'      => '',
        'child_of'      => $post->ID == get_option('page_on_front') || hush_get_theme_option_value('pagemenu', 'toplevel') ? 'front-page' :  $post->ID,
        'exclude'       => implode(", ", $exclude_pages),
        'depth'         => $menu_depth,
        'walker'        => new Walker_Menu(),
        'current_page'  => $post->ID,
    ];
}


/* Get ready to output menu
------------------------------------------------------------------------------------------- */
$total_items = count(get_pages($parent)) + count(get_pages($children));
$page_level = count($ancestors) > 3 ? 3 : count($ancestors);


/* Title Menu
------------------------------------------------------------------------------------------- */
$activated_menu = true;
$override_pagemenu_locations = hush_get_theme_option_value('pagemenu', 'locations') ?? [];

// front page
if (is_front_page())
    $activated_menu = in_array("front", $override_pagemenu_locations);

// search
if (is_search())
    $activated_menu = in_array("search", $override_pagemenu_locations);

// show page menu
if ($total_items > 1 && in_array($page_level, $show_pagemenu) && $activated_menu && !isset($args['breadcrumb_only'])) : // && $args['pagemenu']

    $layout_options = "";

    // background

    //if (($args['client_plain'] == false ?? true)) {
    $background_color = ((hush_get_theme_option_value('pagemenu', 'bg_color') == 'inherit' && isset($args['opacity_color'])) ? $args['opacity_color'] : hush_replace_section_color(hush_get_theme_option_value('pagemenu', 'bg_color', false), "pagemenus"));
    $layout_options .= " option-text_color-" . hush_get_theme_option_value('pagemenu', 'text_color');

    $layout_options .= " " . hush_convert_option_text($background_color ?? 'primary');


    // section override
    if (!hush_get_theme_option_value('section', 'pagemenus'))
        $layout_options .= " option-nosectioncolor";

    // dropdown color
    $dropdown_color = hush_get_theme_option_value('pagemenu', 'grandchildren_color') == 'inherit' ? $background_color : hush_replace_section_color(hush_get_theme_option_value('pagemenu', 'grandchildren_color', false), "pagemenus_dropdowns");

    // megamenu
    if ($show_megamenu)
        $layout_options .= " option-megamenu";

    // location
    $layout_options .= " option-location-" . ($args['pagemenu'] ?? 'below');

    //mobilebelow
    if ($args['pagemenu_mobile'] ?? false) {
        $layout_options .= " option-location-mobile-" . $args['pagemenu_mobile'];
    }

?>
    <div class="banner__menu <?php echo hush_get_theme_options('pagemenu'); ?> <?php echo $layout_options; ?>" data-dropdown="<?php echo hush_convert_option_text($dropdown_color); ?>" data-dropdown-sectionoverride="<?php echo hush_get_theme_option_value('section', 'pagemenus_dropdowns'); ?>">
        <div class="<?php echo hush_get_container_size(hush_get_theme_option_value('pagemenu', 'container') ?? 'normal'); ?>">

            <div class="banner__menu__outer">

                <div class="banner__menu__items">
                    <ul>
                        <?php
                        !$hide_parent ? wp_list_pages($parent) : null;
                        wp_list_pages($children); // show grand children as well if allowed 
                        ?>
                    </ul>
                </div>

                <?php
                // Add Search
                if (hush_get_theme_option_value('pagemenu', 'search')) :
                ?>
                    <div class="banner__menu__search">
                        <?php get_search_form(['button' => hush_get_theme_option_value('pagemenu', 'search_color')]); ?>
                    </div>
                <?php
                endif; // search
                ?>
            </div>
        </div>
    </div>

<?php
endif; // page menu


/* Title Notice
------------------------------------------------------------------------------------------- */
if (get_field('add_title_notice') && hush_get_theme_options('notice', 'active')) {
    get_template_part('layouts/notice', null, ['title_notice' => true]);
    hush_webpack_add_file("notice", "layouts");
}


/* Breadcrumb
------------------------------------------------------------------------------------------- */
$layout_options = "";

$override_breadcrumb = false;
$override_breadcrumb_locations = hush_get_theme_option_value('pagebreadcrumb', 'locations') ?? [];

if ($override_breadcrumb_locations == false)
    $override_breadcrumb_locations = []; // change to array if false to prevent errors

// front page
if ((is_front_page() || get_option('page_on_front') == $post->ID) && in_array("front", $override_breadcrumb_locations))
    $override_breadcrumb = true;

// search
if (is_search() && in_array("search", $override_breadcrumb_locations))
    $override_breadcrumb = true;

// woo commerce


if ($args['breadcrumb_only'] ?? false) {
    include(locate_template('includes/woo_override.php'));
    if (isset($woo_override)) {
        if (in_array("woo", $override_breadcrumb_locations)) {
            $override_breadcrumb = true;
            $layout_options .= " option-inline";
        }
    } else {
        $override_breadcrumb = true;
        $layout_options .= " option-inline";
    }
}

// show breadcrumb
if ($total_items > 1 && in_array($page_level, $show_breadcrumb) || $override_breadcrumb) : // && $args['breadcrumb']

    //breadcrumb
    $layout_options .= " option-location-" . ($args['breadcrumb'] ?? 'below');
?>
    <div class="breadcrumb <?php echo $layout_options; ?> <?php echo hush_get_theme_options('pagebreadcrumb'); ?>">
        <div class="<?php echo hush_get_container_size(hush_get_theme_option_value('pagebreadcrumb', 'container') ?? 'normal'); ?>">
            <?php
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<div class="breadcrumb__outer">', '</div>');
            }
            ?>
        </div>
    </div>
<?php
endif;

wp_reset_postdata();
?>