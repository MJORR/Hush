<?php
// Back Link
if (get_query_var('return')) :
    $return_id = get_query_var('return');

    // page / post
    if (is_numeric($return_id)) {
        $post_to_return = get_post(get_query_var('return'));

        $return_link = get_permalink($post_to_return);
        $return_name = get_the_title($post_to_return);
    }
    // category
    else {
        $post_to_return = get_category_by_slug($return_id);

        $return_link = get_category_link($post_to_return);

        // get all querystrings, remove return and add to return link
        parse_str($_SERVER['QUERY_STRING'], $query_strings);
        unset($query_strings['return']);

        $return_link = add_query_arg($query_strings, $return_link);

        $return_name = $post_to_return->name;
    }
?>
    <div class="banner__back">
        <a href="<?php echo $return_link; ?>"><?php _e('Back to', 'hush-parent'); ?> <?php echo $return_name; ?></a>
    </div>
<?php
endif; // return
?>