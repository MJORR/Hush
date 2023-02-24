<?php

/**
 * Woocommerce Category
 * 
 * Display categories.
 * 
 */

?>

<div class="woo-override layout-nobackground <?php echo hush_get_theme_options('woocommerce'); ?>">
    <div class="woocommerce woocommerce-category" <?php hush_animation(); ?>>
        <div class="container">

            <div class="woocommerce-products__title">
                <h2><?php echo get_sub_field('title'); ?></h2>

                <?php
                // View all button
                $view_all_link = get_permalink(wc_get_page_id('shop'));

                if (get_sub_field('change_link')) :
                    $link = get_sub_field('link');

                    if ($link['type'] == "cat") {
                        $view_all_link = get_term_link($link['category']);
                    } else {
                        $view_all_link = get_term_link($link['tag']);
                    }
                endif; // change_link

                if ($view_all_link) :
                ?>
                    <a href="<?php echo $view_all_link; ?>">
                        <?php
                        get_template_part("components/button", "plain", [
                            'text'          => "View All",
                            'nobackground'  => false
                        ]);
                        ?>
                    </a>
                <?php
                endif; // shop_page_url
                ?>
            </div>

            <div>
                <?php
                $ids = get_sub_field('display_by_category') ? 'ids="' . implode(',', get_sub_field('select_a_category')) . '"' : null;
                echo do_shortcode('[product_categories columns="3" ' . $ids . ']');
                ?>
            </div>

        </div>
    </div>
</div>