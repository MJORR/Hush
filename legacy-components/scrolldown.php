<?php
if (hush_get_theme_option_value('scrolldown', 'scroll_type') == 'mobile')
    $mobile .= ' mobile no-animation';
?>


<div class="scrolldown <?php echo hush_get_theme_options('scrolldown'); ?>">
    <div class="scrolldown__inner">
        <span class="scrolldown__title <?php echo $mobile; ?>">
            <?php if (hush_get_theme_option_value('scrolldown', 'scroll_type') == 'mobile') { ?>
                <div class="icon-scroll"></div>
            <?php } else { ?>
                <?php echo hush_get_theme_option_value('scrolldown', 'text'); ?>
            <?php } ?>
        </span>
        <div class="scrolldown__main <?php echo $mobile; ?>"></div>
    </div>
</div>