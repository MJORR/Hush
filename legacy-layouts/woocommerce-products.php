<?php

/**
 * Woocommerce Products
 * 
 * Display woo commerce products and can be filtered by category and/or tags.
 * 
 */


// category
$display_category = get_sub_field('display_by_category');
$category = get_sub_field('select_a_category');

// tags
$display_tags = get_sub_field('display_by_tags');
$tags = get_sub_field('select_a_tag');


// construct tax query
if ($display_category) :
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $category,
        'operator' => 'IN',
    );
endif;

if ($display_tags) :
    $tax_query[] = array(
        'taxonomy' => 'product_tag',
        'field' => 'id',
        'terms' => $tags,
        'operator' => 'IN',
    );
endif;

if ($display_category || $display_tags) {
    $tax_query['relation'] = 'OR';
}

$args = array(
    'post_type'         => 'product',
    'posts_per_page'    => 8,
    'tax_query'         => $tax_query ?? null,
);

$loop = new WP_Query($args);


if ($loop->have_posts()) :
?>
    <div class="woo-override layout-nobackground <?php echo hush_get_theme_options('woocommerce'); ?>">
        <div class="woocommerce woocommerce-products " <?php hush_animation(); ?>>
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

                <div class="woocommerce columns-4">
                    <ul class="products columns-4">
                        <?php

                        while ($loop->have_posts()) : $loop->the_post();
                            global $product; ?>

                            <li class="product <?php echo wc_get_loop_class(); ?>">

                                <a href="<?php echo get_permalink($loop->post->ID) ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                                    <?php woocommerce_show_product_sale_flash($post, $product); ?>

                                    <?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                                    else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />'; ?>

                                    <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>

                                    <span class="price"><?php echo $product->get_price_html(); ?></span>

                                </a>

                                <?php woocommerce_template_loop_add_to_cart($loop->post, $product); ?>

                            </li>

                        <?php endwhile; ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
<?php
endif; // have_posts
?>