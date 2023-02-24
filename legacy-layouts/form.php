<?php

/**
 * Form
 * 
 * Displays a form.
 */

$layout_options = '';
$title = false;
$description = false;

$form = get_sub_field('gf_form');
$title = get_sub_field('display_form_title');
$description = get_sub_field('display_form_description');

if ($title) :
    $title = true;
endif;

if ($description) :
    $description = true;
endif;


// background
include(locate_template('includes/background.php'));
?>

<div class="form <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <?php
        if ($form)
            gravity_form($form, $title, $description, false, null, true);
        ?>
    </div>
</div>