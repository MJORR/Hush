<?php
// twitter
$aggregator_plugin = new Aggregator();

// picks the data source
$sources    = get_field('data_sources', 'option');
if ($sources ?? false) {
    foreach ($sources as $key => $source) {
        switch ($source['source_type']) {
            case 'Facebook':
                $sources = 'facebook';
                $icon = 'fa-facebook';
                break;
            case 'Instagram':
                $sources = 'instagram';
                $icon = 'fa-instagram';
                break;
            case 'Twitter':
                $sources = 'twitter';
                $icon = 'fa-twitter';
                break;
            case 'Twitter V2':
                $sources = 'twitter v2';
                $icon = 'fa-twitter';
                break;
            case 'Posts':
                $sources = 'posts';
                break;
        }
    }
}


$twitter = $aggregator_plugin->generateAggregator($sources, 'combined', 'desc', 4);

$layout_options = '';
// background
include(locate_template('includes/background.php'));
?>

<div class="social-feed <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="container">

        <div class="social-feed__outer">

            <?php if (get_sub_field('social_feed_title') && get_sub_field('display_other_social_links')) : ?>
                <div class="social-feed__title__container">
            <?php endif; ?>

                <?php if (get_sub_field('social_feed_title')) : ?>
                    <div class="social-feed__title">
                        <h2><?php the_sub_field('social_feed_title'); ?>
                        <?php if (get_sub_field('handle_name')): ?>
                            <span><?php echo get_sub_field('handle_name'); ?></span>
                        <?php endif; ?>
                        </h2>
                    </div>
                <?php endif; ?>

                <?php if (get_sub_field('display_other_social_links')): ?>
                    <div class="social-feed-others">
                        <?php echo output_social(); ?>  
                    </div>
                <?php endif; ?>

            <?php if (get_sub_field('social_feed_title') && get_sub_field('display_other_social_links')) : ?>
                </div>
            <?php endif; ?>

            <div class="social-feed__twitter">
                <?php
                // twitter feed
                if ($twitter) :
                    foreach ($twitter as $tweet) :
                        $default_image = get_sub_field('default_image');
                ?>
                        <div class="social-feed__twitter__tweet" data-link="<?php echo $tweet['link']; ?>" <?php if ($default_image): ?> style="background-image: url(<?php echo $default_image['url']; ?>);" <?php endif; ?>>
                            <div class="social-feed__twitter__tweet__overlay"></div>
                            <div class="social-feed__twitter__tweet__content">
                                <!--<h5><?php //echo $tweet['username']; ?></h5>-->
                                <p><?php echo $tweet['content']; ?></p>
                                <p class="time"><i class="fab <?php echo $icon; ?>"></i> 
                                    <?php if(get_sub_field('display_timestamp')): ?>
                                        <?php echo timeAgo($tweet['timestamp']); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
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