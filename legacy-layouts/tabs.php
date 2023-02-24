<?php

/**
 * Tab Block
 * 
 * Displays a text from a wysiwyg.
 * With the option to add an image
 * Max of 5 tabs
 
 */

$layout_options = null;

?>

<div class="tabs-block <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-nobackground container <?php echo hush_get_theme_options('tab'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>

    <div class="tabs">
        <?php
        if (have_rows('tab')) :
            $counter = 0;
            while (have_rows('tab')) : the_row();
                $counter++;
                $tabLabel = get_sub_field('tab_label');
                $tabLabelIcon = get_sub_field('tab_label_icon'); ?>

                <?php

                if ($counter < 2) { ?>

                    <input type="radio" id="tab-<?php echo $counter; ?>" name="tab-1" checked="checked">
                    <label for="tab-<?php echo $counter; ?>"><?php if (hush_get_theme_option_value('tab', 'tab_label_icons') == true) {
                                                                    echo $tabLabelIcon;
                                                                } ?> <?php echo $tabLabel; ?></label>

                <?php } else { ?>

                    <input type="radio" id="tab-<?php echo $counter; ?>" name="tab-1">
                    <label for="tab-<?php echo $counter; ?>"><?php if (hush_get_theme_option_value('tab', 'tab_label_icons') == true) {
                                                                    echo $tabLabelIcon;
                                                                } ?> <?php echo $tabLabel; ?></label>

                <?php } ?>
        <?php
            endwhile;
        endif;
        ?>

        <div class="tab-content">
            <?php
            if (have_rows('tab')) :
                $counter = 0;
                while (have_rows('tab')) : the_row();
                    $counter++;
                    $tabContent = get_sub_field('content');
                    $tabImage = get_sub_field('image'); ?>

                    <section id="tab-item-<?php echo $counter; ?>">
                        <?php if (hush_get_theme_option_value('tab', 'image_tabs') == true) {
                            if ($tabImage != '') { ?>
                                <div>
                                    <img src="<?php echo $tabImage['url']; ?>">
                                </div>
                        <?php }
                        }
                        ?>

                        <div class="content">
                            <?php echo $tabContent; ?>
                        </div>
                    </section>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>