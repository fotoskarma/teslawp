<div class="testimonial_slider" data-speed="<?php echo $shortcode['speed']*1000; ?>" data-pause="<?php echo $shortcode['pause']*1000; ?>">
	<?php $i=0; foreach($slides as $slide): ?>
	<div class="testimonialbg<?php if($shortcode['wide']) echo ' testimonialbgwide'; ?><?php if(!empty($shortcode['class'])) echo ' '.$shortcode['class']; ?><?php if($i) echo ' testimonial_hidden'; else echo ' testimonial_active'; ?>">
	    <div class="testimonial">
	        <div class="testimonialImg bordercolor">
	            <img src="<?php echo $slide['options']['image']; ?>" alt="" />
	        </div>
	        <div class="testimonialContent font4">
	            <div class="testimonialContentText textcolor4">
	                <?php echo $slide['options']['testimonial']; ?>
	            </div>
	            <div class="testimonialContentAuthor textcolor5">
	                &HorizontalLine; <?php
	                	if(empty($slide['options']['url']))
	                		echo $slide['options']['author'];
	                	else
	                		echo '<a href="'.$slide['options']['url'].'">'.$slide['options']['author'].'</a>';
	                ?>
	            </div>
	        </div>
	    </div>
	</div>
	<?php $i++; endforeach; ?>
</div>