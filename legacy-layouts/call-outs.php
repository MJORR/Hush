<?php

/**
 * Call outs
 * 
 * Displays an alert messages to use to bring attention to something
 * 
 */

$layout_options = '';
$link_content = '';
$title = '';

// link
$div_type = 'div';
if (get_sub_field('add_link')) {
    $layout_options .= " option-link";

    $div_type = 'a';

    $link = get_sub_field('button');
    $link['download_file'] = false;

    // download
    if ($link['type'] == 'download') {
        $link['tab'] = false;
        $link['download_file'] = true;
        $link['link'] = 'href="' . $link['download']['url'] . '"';
    }
    // internal
    elseif ($link['type'] == 'in') {
        $link['tab'] = false;
        $link['link'] = 'href="' . $link['in'] . '"';
    }
    // external
    elseif ($link['type'] == 'out') {
        $link['tab'] = 'target="_blank"';
        $link['link'] = 'href="' . $link['out'] . '"';
    }
    // email
    elseif ($link['type'] == 'email') {
        $link['tab'] = 'target="_blank"';
        $link['link'] = "href='mailto:" . $link['email_address'] . "'";
    }
    // telephone
    elseif ($link['type'] == 'phone') {
        $telephone = $link['telephone'];
        $telephone_number_only = preg_replace("/[^0-9]/", "", $telephone);
        $link['link'] = "href='tel:" . $telephone_number_only . "'";
        $link['tab'] = 'target="_blank"';
    }

    $title = $link['text'];
    $link_content = $link['link'] . $link['tab'] . $link['download_file'];
}

?>

<div class="call-outs <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-nobackground <?php echo hush_get_theme_options('call_outs'); ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>

    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <<?php echo $div_type; ?> title="<?php echo $title; ?>" <?php echo $link_content; ?> class="call-outs-content <?php echo hush_convert_option_text(get_sub_field('color')); ?>">

            <?php
            if (get_sub_field('show_icon')) :
                // icon
                $icon = get_sub_field('icon');
                if ($icon) :
            ?>
                    <div class="call-outs-content-icon">
                        <?php echo $icon; ?>
                    </div>
            <?php
                endif; // icon
            endif;
            ?>

            <div class="call-outs-content-text">
                <h3><?php the_sub_field('title'); ?></h3>
                <?php echo get_sub_field('text'); ?>
            </div>

        </<?php echo $div_type; ?>>
    </div>
</div>