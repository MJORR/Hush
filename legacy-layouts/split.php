<?php

/**
 * Split Blocks
 * 
 * Displays two part text and image blocks. Can go up to 3 wide.
 */

$layout_options = '';

// Items
$element_rows = get_sub_field('rows');

// text align
$text_align = get_sub_field('content_align');

// image size
if (hush_get_theme_option_value('split', 'imagesize_own')) {
    $layout_options .= " option-imagesize-" . get_sub_field("imagesize");
} else {
    $layout_options .= " option-imagesize-" . hush_get_theme_option_value('split', 'imagesize');
}

// background color
if (get_sub_field('add_background_colour')) {
    $background_color = true;
}

// container
if (get_sub_field('container')) {
    $layout_options .= ' option-container';
}

// background
if (get_sub_field('background')) {
    if (get_sub_field('background_type') == 1) {
        $layout_options .= ' layout-reset layout-background-color option-' . strtolower(preg_replace('/\s+/', '', get_sub_field('background_colour')));
        $white_overright = true;
    } else {
        $layout_options .= ' layout-background layout-reset';
    }
} else {
    $layout_options .= ' layout-reset';
}

// image starting side
$layout_options .= " option-start-" . get_sub_field('start');

// large text box
if (get_sub_field('largetext')) {
    $layout_options .= " option-largetext";
}
?>


<div class="split <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('split'); ?> <?php echo $layout_options; ?> split__rows__<?php the_sub_field('rows'); ?> ">
    <div class="split__outer">

        <?php if (have_rows('content')) : ?>
            <?php
            while (have_rows('content')) : the_row();
                $layout_options = ''; // reset options    

                // image
                $image = get_sub_field('image');

                // background color
                $background_style = null;
                if ($background_color ?? false) {
                    if (get_sub_field('background') != 'White') {
                        $background_style = 'background-color: ' . hush_get_theme_color(get_sub_field('background')) . ";";
                        $background_style .= 'color: ' . hush_get_theme_color(get_sub_field('background'), true) . ";";

                        $layout_options .= ' option-backgroundColor';
                    } else {
                        $background_color = false;
                    }
                }
            ?>

                <div class="split__block <?php echo $element_rows == 1 ? 'flex-column' : ''; ?> <?php echo $layout_options; ?>" style="<?php echo $background_style; ?>" <?php hush_animation(); ?>>
                    <div class="inner" <?php if (hush_get_theme_option_value('split', 'anchor_tags') == true): ?>id="<?php the_sub_field('anchor_tag'); ?>" <?php endif; ?> >
                        <div class="split__block__content">
                            <div class="split__block__inner">
                                <div class="<?php echo $text_align; ?>">
                                    <?php // title 
                                    ?>
                                    <div class="split__block__content__title">
                                        <h2><?php the_sub_field('title'); ?></h2>
                                    </div>

                                    <?php
                                    // Sub Title
                                    $sub_title = get_sub_field('sub_title');
                                    if (!empty($sub_title)) : ?>
                                        <div class="split__block__content__sub_title">
                                            <?php the_sub_field('sub_title'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    // Text
                                    $text = get_sub_field('text');
                                    if (!empty($text)) : ?>
                                        <div class="split__block__content__text">
                                            <?php the_sub_field('text'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Button -->
                                    <?php if (get_sub_field('add_button')) : ?>

                                        <div class="split__block__button">

                                            <?php foreach (get_sub_field('buttons') as $button) : ?>

                                                <?php
                                                $white = $background_color ?? false;
                                                get_template_part('components/button', null, [
                                                    'button' => $button,
                                                    'white' => $white_overright ?? false ? true : $white,
                                                ]);
                                                ?>

                                            <?php endforeach; ?>

                                        </div>
                                    <?php endif; // template button 
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="split__block__image" style="background-image: url('<?php echo $image['sizes']['medium_large']; ?>')"></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>