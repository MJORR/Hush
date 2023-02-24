<div class="testimonials__rows__row alt">
	<div class="testimonials__rows__alt">
	    <?php
	    $image = get_field('image', $item);

	    //testimonial image
	    if (hush_get_theme_option_value('testimonials', 'display_image') == true && hush_get_theme_option_value('testimonials', 'display_background_image') == false) : ?>
	        <?php if ($image) : ?>
	            <div class="testimonials__rows__image alt">
	                <?php
	                get_template_part("components/background", null, ['background' => $image]);
	                ?>
	            </div>
	        <?php endif; ?>
	    <?php endif; ?>

	    <div class="testimonials__rows__content">
		    <div class="testimonials__rows__name">
	            <?php echo get_the_title($item); ?>
	        </div>

	        <?php
	        if (get_field('company', $item)) :
	        ?>
	            <div class="testimonials__rows__company">
	                <?php the_field('company', $item); ?>
	            </div>
	        <?php
	        endif; // item['company']
	        ?>
        </div>

    </div>

    <div class="testimonials__rows__container">
        <div class="testimonials__rows__text">
            <?php the_field('content', $item); ?>
        </div>
    </div>
</div>