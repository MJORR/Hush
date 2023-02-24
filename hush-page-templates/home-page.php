<?php

/**
 * Template Name: Home
 *
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hush
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>

<?php get_template_part('hush-components/hero'); ?>
<main>


    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('hush-loops/content', 'page'); ?>

    <?php endwhile; ?>

</main><!-- #main -->

<?php
get_footer();
