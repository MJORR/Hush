<?php
$icon = $args['icon'];

if ($icon['icon_type'] ?? false) :
?>

    <div class="icon">
        <?php
        // Icon
        if ($icon['icon_type'] == 'icon') :
            echo $icon['icon_fa'];
        // Image
        else :
            if ($args['title'] ?? false) {
                $alt = $args['title'];
            } else {
                $alt = $icon['icon_image']['title'] ?? "";
            }
        ?>
            <img src="<?php echo $icon['icon_image']['sizes']['large']; ?>" alt="<?php echo $alt; ?>">
        <?php
        endif; // Icon
        ?>
    </div>
<?php
endif; // icon
?>