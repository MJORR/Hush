<?php

/**
 * Downloads
 * 
 * Displays in a table.
 * 
 */
$layout_options = '';
$white = '';

// background
include(locate_template('includes/background.php'));

if (get_sub_field('background_type') == 1):
    $white = true;
endif;

$tab = get_sub_field('new_tab');

?>

<div class="downloads <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo hush_get_theme_options('downloads'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">

        <?php 
        //heading option
        if(get_sub_field('heading')): ?>
            <h2><?php the_sub_field('heading'); ?></h2>
        <?php endif; ?>

        <table class="downloads-table" id="downloadsTable">
            <tr class="downloads-heading <?php if (hush_get_theme_option_value('downloads', 'show_more') == true) : ?>description<?php endif; ?>">
                <th class="sortTable" data-type="0"><span><?php _e('File', 'hush-parent') ?></span></th>

                <?php if (hush_get_theme_option_value('downloads', 'show_more') == true) : ?>
                    <th><?php _e('Description', 'hush-parent') ?></th>
                <?php endif; ?>
                
                <th class="sortTable" data-type="1"><span><?php _e('Type', 'hush-parent') ?></span></th>
                <th class="sortTable" data-type="2"><span><?php _e('Size', 'hush-parent') ?></span></th>
                <th class="sortTable" data-type="3"><span><?php _e('Date', 'hush-parent') ?></span></th>
            </tr>
        
            <?php $counter = 0; 
            if (have_rows('downloads')) :
                while (have_rows('downloads')) : the_row();
                
                    $file = get_sub_field('file');
                    $url = $file['url'];
                    $title = $file['title'];
                    $description = $file['description'];
                    $date = $file['date'];
                    $date = new DateTime($date);
                    $finalVal = $date->format('jS F Y'); 
                    $type = pathinfo($url);
                    $counter++; ?>

                    <tr class="downloads-rows <?php if (hush_get_theme_option_value('downloads', 'show_more') == true) : ?>description<?php endif; ?>">
                        <td>
                            <a href="<?php echo esc_attr($url); ?>" <?php if ( $tab ): ?> target="_blank" <?php endif; ?>>
                                <?php echo esc_html($title); ?>
                            </a>
                        </td>
                        <?php if (hush_get_theme_option_value('downloads', 'show_more') == true) : ?>
                            <td class="info">
                                <a class="download-read-more" role="button" data-target="<?php echo $counter;?>"><?php _e('More Info', 'hush-parent'); ?></a>
                            </td>
                        <?php endif; ?>
                        <td class="type">
                           <?php echo $type["extension"]; ?>
                        </td>
                        <td>
                            <?php echo human_filesize($file['filesize']); ?>
                        </td>
                        <td>
                            <?php echo esc_html($finalVal); ?>
                        </td>
                        <td class="download-more-info" data-attr="<?php echo $counter;?>">
                            <?php the_sub_field('content'); ?>
                        </td>
                    </tr>

            <?php endwhile;
            endif; ?>

        </table>

    </div>
</div>