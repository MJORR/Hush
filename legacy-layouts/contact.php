<?php

/**
 * Contact
 * 
 * Displays contact form.
 */

$layout_options = '';

// map position
$layout_options .= ' option-map-' . strtolower(preg_replace('/\s+/', '', get_sub_field('display_map_position')));

// background
include(locate_template('includes/background.php'));

// button classes
if ($is_preview ?? false)
    $form_classes = 'data-form="' . hush_get_theme_options("forms") . '"';

if(get_sub_field('filled_icons')):
    $awesome = 'fas';
else:
    $awesome = 'far';
endif;

?>

<div class="contact <?php echo ($is_preview ?? false) ? 'is-preview' : ''; ?> <?php echo $layout_options; ?>" <?php hush_animation(); ?> <?php echo $form_classes ?? null; ?>>
    <div class="<?php echo hush_get_container_size(get_sub_field('container') ?? 'normal'); ?>">
        <div class="contact-container">
            <div class="form">
                <div class="form__inner">
                    <?php
                    $form_id = get_sub_field('gf_form');
                    gravity_form($form_id, true, true);
                    ?>

                    <?php if (!get_sub_field('display_image')): ?>
                        <?php if (get_sub_field('display_opening_hours')) : ?>
                            <div class="global-contact opening-times">

                                <?php if (get_sub_field('display_extra_details')) : ?>
                                    <?php the_sub_field('extra_details'); ?>
                                <?php endif; ?>

                                <div class="contact">
                                    <?php if (get_sub_field('contact_details_title')) : ?>
                                        <h3><?php the_sub_field('contact_details_title'); ?></h3>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('main_contact_person')) : ?>
                                        <p><i class="<?php echo $awesome; ?> fa-user-circle"></i> <?php the_sub_field('main_contact_person'); ?></p>
                                    <?php endif; ?>

                                    <?php if (get_field('email_address', 'option')) : ?>
                                        <p><a href="mailto:<?php echo get_field('email_address', 'option'); ?>" aria-label="Email Address"><i class="<?php echo $awesome; ?> fa-envelope"></i> <?php echo get_field('email_address', 'option'); ?></a></p>
                                    <?php endif; ?>

                                    <?php if (get_field('telephone', 'option')) : ?>
                                        <?php $telephone = get_field('telephone', 'option'); ?>
                                        <p><a href="tel:<?php echo encode_tel($telephone); ?>" aria-label="Telephone Number"><i class="<?php echo $awesome; ?> fa-phone"></i> <?php echo $telephone; ?></a></p>
                                    <?php endif; ?>

                                    <?php if (get_field('address', 'option')) : ?>
                                        <div class="address">
                                            <i class="<?php echo $awesome; ?> fa-map-marker-alt"></i>
                                            <p><?php the_field('address', 'option'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="opening-times">
                                    <?php the_sub_field('opening_times'); ?>
                                </div>
                            </div>
                        <?php else: ?>    
                            <?php if (get_sub_field('display_contact_details')) : ?>
                                <div class="global-contact">
                                    <?php if (get_sub_field('contact_details_title')) : ?>
                                        <h3><?php the_sub_field('contact_details_title'); ?></h3>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('display_extra_details')) : ?>
                                        <?php the_sub_field('extra_details'); ?>
                                    <?php endif; ?>

                                    <div class="contact">
                                        <?php if (get_sub_field('main_contact_person')) : ?>
                                            <p><i class="<?php echo $awesome; ?> fa-user-circle"></i> <?php the_sub_field('main_contact_person'); ?></p>
                                        <?php endif; ?>

                                        <?php if (get_field('email_address', 'option')) : ?>
                                            <p><a href="mailto:<?php echo get_field('email_address', 'option'); ?>" aria-label="Email Address"><i class="<?php echo $awesome; ?> fa-envelope"></i> <?php echo get_field('email_address', 'option'); ?></a></p>
                                        <?php endif; ?>

                                        <?php if (get_field('telephone', 'option')) : ?>
                                            <?php $telephone = get_field('telephone', 'option'); ?>
                                            <p><a href="tel:<?php echo encode_tel($telephone); ?>" aria-label="Telephone Number"><i class="<?php echo $awesome; ?> fa-phone"></i> <?php echo $telephone; ?></a></p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (get_field('address', 'option')) : ?>
                                        <div class="address">
                                            <i class="<?php echo $awesome; ?> fa-map-marker-alt"></i>
                                            <p><?php the_field('address', 'option'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    <?php endif; ?> 
                </div>
            </div>

            <div class="map <?php if (get_sub_field('display_image')): echo 'image'; endif; ?>">

                <?php if (get_sub_field('display_image')): ?>
                        <?php if (get_sub_field('display_opening_hours')) : ?>
                            <div class="global-contact opening-times">
                                
                                <?php if (get_sub_field('display_extra_details')) : ?>
                                    <?php the_sub_field('extra_details'); ?>
                                <?php endif; ?>

                                <div class="contact">
                                    <?php if (get_sub_field('contact_details_title')) : ?>
                                        <h3><?php the_sub_field('contact_details_title'); ?></h3>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('main_contact_person')) : ?>
                                        <p><i class="<?php echo $awesome; ?> fa-user-circle"></i> <?php the_sub_field('main_contact_person'); ?></p>
                                    <?php endif; ?>

                                    <?php if (get_field('email_address', 'option')) : ?>
                                        <p><a href="mailto:<?php echo get_field('email_address', 'option'); ?>" aria-label="Email Address"><i class="<?php echo $awesome; ?> fa-envelope"></i> <?php echo get_field('email_address', 'option'); ?></a></p>
                                    <?php endif; ?>

                                    <?php if (get_field('telephone', 'option')) : ?>
                                        <?php $telephone = get_field('telephone', 'option'); ?>
                                        <p><a href="tel:<?php echo encode_tel($telephone); ?>" aria-label="Telephone Number"><i class="<?php echo $awesome; ?> fa-phone"></i> <?php echo $telephone; ?></a></p>
                                    <?php endif; ?>

                                    <?php if (get_field('address', 'option')) : ?>
                                        <div class="address">
                                            <i class="<?php echo $awesome; ?> fa-map-marker-alt"></i>
                                            <p><?php the_field('address', 'option'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="opening-times">
                                    <?php the_sub_field('opening_times'); ?>
                                </div>
                            </div>
                        <?php else: ?>    
                            <?php if (get_sub_field('display_contact_details')) : ?>
                                <div class="global-contact">
                                    <?php if (get_sub_field('contact_details_title')) : ?>
                                        <h3><?php the_sub_field('contact_details_title'); ?></h3>
                                    <?php endif; ?>

                                    <?php if (get_sub_field('display_extra_details')) : ?>
                                        <?php the_sub_field('extra_details'); ?>
                                    <?php endif; ?>

                                    <div class="contact">
                                        <?php if (get_sub_field('main_contact_person')) : ?>
                                            <p><i class="<?php echo $awesome; ?> fa-user-circle"></i> <?php the_sub_field('main_contact_person'); ?></p>
                                        <?php endif; ?>

                                        <?php if (get_field('email_address', 'option')) : ?>
                                            <p><a href="mailto:<?php echo get_field('email_address', 'option'); ?>" aria-label="Email Address"><i class="<?php echo $awesome; ?> fa-envelope"></i> <?php echo get_field('email_address', 'option'); ?></a></p>
                                        <?php endif; ?>

                                        <?php if (get_field('telephone', 'option')) : ?>
                                            <?php $telephone = get_field('telephone', 'option'); ?>
                                            <p><a href="tel:<?php echo encode_tel($telephone); ?>" aria-label="Telephone Number"><i class="<?php echo $awesome; ?> fa-phone"></i> <?php echo $telephone; ?></a></p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (get_field('address', 'option')) : ?>
                                        <div class="address">
                                            <i class="<?php echo $awesome; ?> fa-map-marker-alt"></i>
                                            <p><?php the_field('address', 'option'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                    <?php endif; ?> 

                <?php if (get_sub_field('display_image')): ?>
                    <?php $image = get_sub_field('image'); ?>
                    <img src="<?php echo $image['url']; ?>">
                <?php else: ?>    
                    <?php the_sub_field('google_maps_embed'); ?>
                <?php endif; ?> 
            </div>
        </div>

    </div>
</div>