<?php

/**
 * Timeline
 * 
 * Displays a horizontal timeline.
 * 
 * 
 */

$layout_options = '';

// background
if (get_sub_field('background')) {
    if (get_sub_field('background_type') == 1) {
        $layout_options .= ' layout-background-color option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour')));
        $layout_options .= ' layout-white-timeline';
    } else {
        $layout_options .= ' layout-background';
    }
} else {
    $layout_options .= ' layout-nobackground';
}

//image radius
if (get_sub_field('image_radius')) {
    $layout_options .= ' layout-image-radius';
} 

?>

<div class="timeline <?php echo hush_get_theme_options('timeline'); ?> <?php echo $layout_options ?? null; ?>" <?php hush_animation(); ?> >
    <div class="container">

        <?php if (get_sub_field('add_heading')): ?>
            <h2><?php echo get_sub_field('heading'); ?></h2>
        <?php endif; ?>

        <div class="history__slider">

            <ul class="history__slider__thumbs">
                <?php $i = 0; 
                if (have_rows('year')) :
                    while (have_rows('year')) : the_row(); 

                        $image = get_sub_field('image');
                        //$imageURL = $image['url']; ?>

                            <li class="history__slider__thumb <?php if ($i == 0): ?> active<?php endif; ?>">
                                <div class="image-block">
                                    <?php if ( $image !='' ): ?>
                                    <figure class="background-image" style="background-image: url('<?php echo $image['url']; ?>');"></figure>
                                    <?php endif; ?>
                                </div>                                
                                <span><?php the_sub_field('date'); ?></span>
                            </li>

                    <?php $i++;
                    endwhile; 
                endif; ?>            
            </ul>

            <ul class="history__slider__main">
                <?php $i = 0; 
                if (have_rows('year')) :
                    while (have_rows('year')) : the_row(); ?>
                                
                        <li<?php if ($i == 0): ?> class="active"<?php endif; ?>>
                            <h3><?php the_sub_field('date'); ?></h3>
                            <?php the_sub_field('content'); ?>                      
                        </li>                 

                    <?php $i++;
                    endwhile; 
                endif; ?>        
            </ul>

        </div>

    </div>
</div>