<?php
$exclude_pages = array();
$hide_parent = false;


hush_webpack_add_file("related", "layouts");

global $post;

// override page
if ($args['page'] ?? false) {
    $page_override = get_post($args['page'], OBJECT);

    if (isset($page_override->post_type) == 'page') {
        $post = $page_override;
        setup_postdata($post);
    }
}

// ancesters
$ancestors = get_post_ancestors($post->ID);


//$page_title_location = $post->post_parent ? true : false;
$page_title_location = true;


/* Get pages to exclude
------------------------------------------------------------------------------------------- */
// child
if ($post->post_parent || ($post->post_parent && isset($ancestors[1]))) {

    // parent
    $pages = get_pages([
        'include'  => $post->post_parent,
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
    $pages = get_pages([
        'child_of'  => $post->post_parent,
    ]);
    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;
        }
    }
}

// parent page
else {

    // get menu type
    $menu_type = get_field('section_menu');

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

    // child
    $pages = get_pages([
        'child_of'  => $post->ID,
    ]);
    foreach ($pages as $page) {
        if (isset($page->hide_on_section) && $page->hide_on_section) {
            $exclude_pages[] = $page->ID;
        }
    }
}


/* Setup get_pages arrays
------------------------------------------------------------------------------------------- */
// ancestor pages
$show_ancestor_parent = true;

$this_child_pages = get_pages([
    'child_of'      => $post->ID,
    'exclude'       => implode(", ", $exclude_pages),
]);

if (count($this_child_pages) > 0) {
    $show_ancestor_parent = false;
}


if ($post->post_parent && $show_ancestor_parent) {
    if (!$hide_parent) {
        $parent_id = $post->post_parent;
        $parent = [
            'title_li'  => '',
            'include'   => $post->post_parent,
            'echo'      => 0,
        ];
    }

    $children = [
        'title_li'      => '',
        'child_of'      => $post->post_parent,
        'echo'          => 0,
        'exclude'       => implode(", ", $exclude_pages),
        'depth'         => 1,
        'walker'        => new Walker_Menu(),
        'current_page'  => $post->ID
    ];
}

// from parent
else {

    if (!$hide_parent) {
        $parent_id = $post->ID;
        $parent = [
            'title_li'      => '',
            'include'       => $post->ID,
            'echo'          => 0,
            'walker'        => new Walker_Menu(),
            'current_page'  => $post->ID
        ];
    }

    $children = [
        'title_li'      => '',
        'child_of'      => $post->ID,
        'echo'          => 0,
        'exclude'       => implode(", ", $exclude_pages),
        'depth'         => 1,
        'walker'        => new Walker_Menu(),
        'current_page'  => $post->ID
    ];
}




/* Output
------------------------------------------------------------------------------------------- */

$parent_total = !$hide_parent ? count(get_pages($parent)) : 0;
$total_items = $parent_total + count(get_pages($children));

$relatedPages = get_field('extra_related_pages', $parent_id);

if ($total_items > 0 ||  $relatedPages > 0) :

    // setup layout options
    $layout_options = '';

    $layout_options .= ' option-border option-background_type-border';

    // parent
    if (!$hide_parent) {
        $parent_page = wp_list_pages($parent);

        if (hush_get_theme_option_value('related', 'parent_override')) {
            $parent_page = preg_replace('/(<a.*?>).*?(<\/a>)/', '$1' . hush_get_theme_option_value('related', 'parent_title') . '$2', $parent_page);
        }
    }

    // background
    if (hush_get_theme_option_value('related', 'location') == "sidebox") {
        if (hush_get_theme_option_value('related', 'add_background_colour')) {
            if (hush_get_theme_option_value('related', 'bg_color') == 'background') {
                $layout_options .= " option-bgcolor";
            } else {
                $layout_options .= ' option-bgcolor-color ' . hush_convert_option_text(hush_get_theme_option_value('related', 'bg_color'));
            }
        }
    }


    // location
    if (hush_get_theme_option_value('related', 'location') == "sidebox") :
?>
        <div class="sidebox__boxs__box <?php echo hush_get_theme_options('sidebox'); ?> <?php echo hush_get_theme_options('related'); ?> <?php echo $layout_options; ?>" style="<?php echo $style ?? null; ?>">
            <div class="sidebox__boxs__inner">

                <div class="related">
                    <h3><?php echo hush_get_theme_option_value('related', 'title') ?? 'Related Pages'; ?></h3>

                    <ul>
                        <?php echo !$hide_parent ? $parent_page : null; ?>
                        <?php echo wp_list_pages($children); ?>

                        <?php
                        if (have_rows('extra_related_pages', $parent_id)) :
                            while (have_rows('extra_related_pages', $parent_id)) : the_row();

                                $sub_value = get_sub_field('page');
                                $title = get_the_title($sub_value);
                                $permalink = get_permalink($sub_value);
                        ?>

                                <li><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></li>

                        <?php
                            endwhile;
                        endif;
                        ?>
                    </ul>
                </div>

            </div>
        </div>
    <?php
    elseif (hush_get_theme_option_value('related', 'location') == "title" && $page_title_location && !is_preview()) :
    ?>
        <div class="relatedpages <?php echo hush_get_theme_options('related'); ?>">
            <div class="<?php echo hush_get_container_size(hush_get_theme_option_value('related', 'container') ?? 'normal'); ?>">
                <ul>
                    <?php echo !$hide_parent ? $parent_page : null; ?>
                    <?php echo wp_list_pages($children); ?>

                    <?php
                    if (have_rows('extra_related_pages', $parent_id)) :
                        while (have_rows('extra_related_pages', $parent_id)) : the_row();

                            $sub_value = get_sub_field('page');
                            $title = get_the_title($sub_value);
                            $permalink = get_permalink($sub_value);
                    ?>

                            <li><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></li>

                    <?php
                        endwhile;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
<?php
    endif;


endif; // children

wp_reset_postdata();
