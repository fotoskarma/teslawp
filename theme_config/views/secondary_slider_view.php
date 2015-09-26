<div class="pageSlider" style="<?php echo $shortcode['style']; ?>" data-speed="<?php echo $shortcode['speed']*1000; ?>" data-pause="<?php echo $shortcode['pause']*1000; ?>">
    <div class="pageSliderItems">
        <ul>
			<?php foreach($slides as $slide): ?>
        	<li><img src="<?php echo $slide['options']['image']; ?>" alt="" /></li>
	        <?php endforeach; ?>
        </ul>
    </div>
</div>