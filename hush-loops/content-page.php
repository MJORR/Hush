<?php

/**
 * Template for content in page
 *
 * @package hush
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="container">
        <div class="content-page">

            <?php
            the_content();
            ?>

        </div><!-- .entry-content -->
    </div>
</article><!-- #post-## -->
