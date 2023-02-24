<?php

/**
 * Gallery
 * 
 * Displays a gallery of images
 * With an extra option of adding the caption to the images.
 * 
 */

?>

<div class="image-gallery <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> layout-nobackground <?php echo hush_get_theme_options('gallery'); ?> " <?php hush_animation(); ?>>
    <div class="container">

        <?php
        $images = get_sub_field('gallery');
        if ($images) :
        ?>
            <div class="image-gallery__gallery">
                <div class="image-gallery__gallery__main">
                    <?php
                    foreach ($images as $image) :
                    ?>
                        <div class="image-gallery__gallery__large">

                            <button class="enlarge" data-target="<?php echo $image['id']; ?>">
                                <i aria-hidden class="far fa-search-plus" title="Enlarge"></i>
                                <span class="sr-only">Enlarge</span>
                            </button>

                            <?php
                            get_template_part('components/background', null, ['background' => $image['sizes']['large']]);
                            ?>

                            <?php if (hush_get_theme_option_value('gallery', 'captions') == true) { ?>

                                <?php if ($image['caption'] != '') { ?>
                                    <div class="image-gallery__gallery__caption">
                                        <p><?php echo $image['caption']; ?></p>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

                <div class="image-gallery__gallery__thumbs">
                    <?php
                    foreach ($images as $image) :
                    ?>
                        <div class="image-gallery__gallery__thumb">
                            <?php
                            get_template_part('components/background', null, ['background' => $image['sizes']['large']]);
                            ?>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

                <?php foreach ($images as $image) : ?>
                    <div class="image-gallery__gallery__popup" data-attr="<?php echo $image['id']; ?>">
                        <div class="image-gallery__gallery__popup__wrapper">
                            <i class="fa fa-times"></i>

                            <div class="image-gallery__gallery__popup__wrapper__content">
                                <div class="image-container">
                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php
        endif; // images
        ?>

    </div>
</div>