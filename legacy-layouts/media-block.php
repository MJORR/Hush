<?php
// news
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 6,
    'orderby' => 'date',
);
$news = new WP_Query($args);

// twitter
$aggregator_plugin = new Aggregator();

// picks the data source
$sources    = get_field('data_sources', 'option');
if ($sources ?? false) {
    foreach ($sources as $key => $source) {
        switch ($source['source_type']) {
            case 'Facebook':
                $sources = 'facebook';
                break;
            case 'Instagram':
                $sources = 'instagram';
                break;
            case 'Twitter':
                $sources = 'twitter';
                break;
            case 'Twitter V2':
                $sources = 'twitter v2';
                break;
            case 'Posts':
                $sources = 'posts';
                break;
        }
    }
}


$twitter = $aggregator_plugin->generateAggregator($sources, 'combined', 'desc', 3);

$layout_options = '';
// background
include(locate_template('includes/background.php'));
?>

<div class="connected <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="container">

        <div class="connected__outer">
            <!-- Left -->
            <div class="connected__outer__left">
                <div class="connected__title">
                    <?php if (get_sub_field('news_title')) : ?>
                        <h2><?php the_sub_field('news_title'); ?></h2>
                    <?php endif; ?>

                    <?php if (get_sub_field('news_button') && get_sub_field('display_top')) :

                        $button_text = get_sub_field('news_button_text');
                    ?>
                        <div class="connected__link">
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="button <?php echo hush_get_theme_options('buttons'); ?>"><?php if ($button_text != '') : echo $button_text; else : _e('Latest News', 'hush-parent'); endif; ?></a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="connected__news">
                    <div class="connected__news__items">
                        <?php
                        // news
                        if ($news->have_posts()) :
                            while ($news->have_posts()) : $news->the_post();
                                // post content
                                $post = get_post();
                                $content = get_extended($post->post_content);
                                $content = apply_filters('the_content', $content['main']);
                                $content = strlen($content) > 120 ? substr($content, 0, 120) . "..." : $content;
                                $content = strip_tags($content, ['<a>']);

                                // image
                                if (get_field('image_square')) :
                                    $image = get_field('image_square');
                                elseif (get_field('image')) :
                                    $image = get_field('image');
                                else :
                                    $image = get_field('default_page_image', 'option');
                                    $image = $image['image'];
                                endif;
                        ?>

                                <a href="<?php echo get_permalink(); ?>">
                                    <div class="connected__news__item">

                                        <?php if (get_sub_field('news_date') || get_sub_field('news_time')) : ?>
                                            <div class="connected__news__date">
                                                <?php if (get_sub_field('news_date')) : ?>
                                                    <?php echo get_the_date('j M Y'); ?>
                                                <?php endif; ?>

                                                <?php if (get_sub_field('news_time')) : ?>
                                                    <div class="time"><?php echo get_the_time(); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="connected__news__image" <?php if ($image != "") : ?>style="background-image: url('<?php echo $image['url']; ?>');" <?php endif; ?>></div>
                                        <h5><?php the_title(); ?></h5>
                                        <p><?php echo $content; ?></p>
                                    </div>
                                </a>
                        <?php
                            endwhile; // posts
                            wp_reset_postdata();
                        endif; // posts
                        ?>
                    </div>
                </div>

                <?php if (get_sub_field('news_button') && !get_sub_field('display_top')) :

                    $button_text = get_sub_field('news_button_text');
                ?>
                    <div class="connected__link__bottom">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="button <?php echo hush_get_theme_options('buttons'); ?> option-primary"><?php if ($button_text != '') : echo $button_text; else : _e('Latest News', 'hush-parent'); endif; ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right -->
            <div class="connected__outer__right">

                <?php if (get_sub_field('social_media_title')) : ?>
                    <div class="connected__title">
                        <h2><?php the_sub_field('social_media_title'); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="connected__twitter">
                    <?php
                    // twitter feed
                    if ($twitter) :
                        foreach ($twitter as $tweet) :
                    ?>
                            <div class="connected__twitter__tweet" data-link="<?php echo $tweet['link']; ?>">
                                <?php if (get_sub_field('social_media_username')) : ?>
                                    <h5><?php echo $tweet['username']; ?></h5>
                                <?php endif; ?>

                                <p><?php echo $tweet['content']; ?></p>
                                
                                <?php if (get_sub_field('social_timestamp')) : ?>
                                    <p class="time"><i class="fab fa-twitter"></i> <?php echo timeAgo($tweet['timestamp']); ?></p>
                                <?php endif; ?>
                            </div>
                    <?php
                        endforeach; // twitter
                    else :
                        _e('No Feed', 'hush-parent');
                    endif; // count twitter
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>