<div class="mainSlider" style="<?php echo $shortcode['style']; ?>" data-speed="<?php echo $shortcode['speed'] * 1000; ?>" data-pause="<?php echo $shortcode['pause'] * 1000; ?>">
    <div class="mainSliderItemsWrapper">
        <div class="mainSliderItems">
            <?php
            // Added by Nikhil Kavungal on 17th August 2014 start
            // reason - main slider items were not displayed as per latest post
            if (isset($slides)) {
                $slides = array_reverse($slides);
            }
            // Added by Nikhil Kavungal on 17th August 2014 end
            foreach ($slides as $slide):
                ?>
                <div class="mainSliderItemsEntry">
                    <img src="<?php echo $slide['options']['image']; ?>" class="mainSliderItemsEntryImg" alt="" />
                    <div class="mainSliderItemsEntryBox bgcolor2<?php if ($shortcode['toggle_caption']) echo ' mainSliderItemsEntryBoxToggle'; ?>">
                        <div class="mainSliderItemsEntryBoxBorder"></div>
                        <div class="mainSliderItemsEntryBoxTitle textcolor2 font3">
                            <?php if (empty($slide['options']['url'])): ?>
                                <?php echo get_the_title($slide['post']->ID); ?>
                            <?php else: ?>
                                <a href="<?php echo $slide['options']['url']; ?>"><?php echo get_the_title($slide['post']->ID); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="mainSliderItemsEntryBoxContent textcolor3">
                            <?php echo $slide['options']['description']; ?>
                        </div>
                        <div class="mainSliderItemsEntryBoxButtons">
                            <div class="mainSliderItemsEntryBoxButtonsPrev bgcolor3 bgcolor_hover"></div>
                            <div class="mainSliderItemsEntryBoxButtonsNext bgcolor3 bgcolor_hover"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="mainSliderNav">
        <div class="mainSliderNavBar bgcolor"></div>
    </div>
</div>