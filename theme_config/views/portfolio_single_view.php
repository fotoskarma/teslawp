<?php $slide = $slides[0]; ?>
<div class="project">

    <div class="">
        <div class="projectInfoDescription">
            <?php echo $slide['options']['full_description']; ?>
        </div>
    </div>
    <br>
    <div class="pageSlider" style="<?php echo $shortcode['style']; ?>" data-speed="<?php echo $shortcode['speed'] * 1000; ?>" data-pause="<?php echo $shortcode['pause'] * 1000; ?>">
        <!--        <div><?php
        foreach ($slide['options']['image_slider'] as $ima) {
            echo '<pre>' . print_r(getimagesize($ima), true) . '</pre>sfjbgsdf';
        }
        ?></div>-->
        <div class="pageSliderItems">
            <ul>
                <?php foreach ($slide['options']['image_slider'] as $image): ?>
                    <!--Start - Changes made by Nikhil Kavungal on 13th Sept 2014 for center alignment of Image thats been shot vertically i.e. 360X540---> 
                    <?php
                    // Start - Changes made by Nikhil on 23rd Sept 2014 to resolve the image padding issue.
                    $style_str = '';
                    // End - Changes made by Nikhil on 23rd Sept 2014 to resolve the image padding issue.
                    $dimensions_array = getimagesize($image);
                    if (isset($dimensions_array)) {
                        $width_of_img = $dimensions_array[0];
                        $height_of_img = $dimensions_array[1];

                        if ($width_of_img == 360 && $height_of_img == 540) {
                            $style_str = 'style="padding-left: 27%; background: rgba(0, 0, 0, 0.9);"';
                        }
                    }
                    ?>
                    <!--<li><img src="<?php echo $image; ?>" alt="" /></li>-->
                    <li <?php echo $style_str ?>><img src="<?php echo $image; ?>" alt="" /></li>
                    <!--End - Changes made by Nikhil Kavungal on 13th Sept 2014 for center alignment of Image thats been shot vertically i.e. 360X540---> 
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<!-- added by Nikhil Kavungal to display the caption/ description of images-->
<div class="project">
    <div id="cs_image_caption" style="position:relative">
        <?php
        // echo print_r(get_attachment_id('http://localhost/fotokonnect/wp-content/uploads/2014/07/bp17.jpg'), true);
        $image_list = $slide['options']['image_slider'];
        $caption_div = '<div id="img_caption_div">';
        $counter = 0;
        foreach ($image_list as $image) {
            $caption_div.= '<div id="caption_' . $counter . '" style="display:none" class="projectInfoDescription nik_caption_class">' . get_attachment_id($image) . '</div>';
            $counter++;
        }
        $caption_div.= '</div>';
        echo $caption_div;
        ?>
    </div>
</div>

<div class="project">
    <!-- <div class="projectInfo">
         <div class="projectInfoDescription">
    <?php echo $slide['options']['full_description']; ?>
         </div>
                 <div class="projectInfoDetails">
                     <div class="projectInfoDetailsTitle font1">
    <?php _e('Project Details', 'teslawp'); ?>
                     </div>
                     <div class="projectInfoDetailsEntry">
                         <div class="projectInfoDetailsEntryTitle">
    <?php _e('Categories', 'teslawp'); ?>
                         </div>
                         <div class="projectInfoDetailsEntryBody">
    <?php
    if (empty($slide['options']['categories']))
        echo implode(', ', array_values($slide['categories']));
    else
        echo $slide['options']['categories'];
    ?>
                         </div>
                     </div>
         <div class="projectInfoDetailsEntry">
             <div class="projectInfoDetailsEntryTitle">
    <?php _e('Skills', 'teslawp'); ?>
             </div>
             <div class="projectInfoDetailsEntryBody">
    <?php echo $slide['options']['skills']; ?>
             </div>
         </div>
                     <div class="projectInfoDetailsEntry">
             <div class="projectInfoDetailsEntryTitle">
    <?php _e('Project url', 'teslawp'); ?>
             </div>
             <div class="projectInfoDetailsEntryBody">
                 <a href="<?php echo empty($slide['options']['url']) ? get_permalink($slide['post']->ID) : $slide['options']['url']; ?>" target="_blank"><?php _e('Project link', 'teslawp'); ?></a>
             </div>
         </div>
                 </div>
     </div>-->
    <div style="height: 50px"></div>
    <?php if (!empty($slide['related'])): ?>
        <div class="projectRelated">
            <div class="titleContainer font1">
                <div class="title">
                    <?php _e('related works', 'teslawp'); ?>
                </div>
                <div class="clientsNav">
                    <div class="clientsNavPrev"></div>
                    <div class="clientsNavNext"></div>
                </div>
            </div>
            <ul>
                <?php foreach ($slide['related'] as $related): ?>
                    <li>
                        <a href="<?php echo get_permalink($related['post']->ID); ?>">
                            <img src="<?php echo $related['options']['related_image']; ?>" alt="" />
                            <!-- Start - Changes done by Nikhil Kavungal on 7th Sept 2014 for fixing the incorrect hyperlink being generated on Related Works block -->
                            <div class="title">
                                <?php echo get_the_title($related['post']->ID); ?>
                            </div>
                        </a>
                        <!--
                        <div class="title">
                            <a href="<?php echo $related['options']['url']; ?>">
                        <?php echo get_the_title($related['post']->ID); ?>
                            </a>
                        </div>
                        <div class="description">
                        <?php echo $related['options']['related_description'] ?>
                        </div>
                        -->
                        <!-- End - Changes done by Nikhil Kavungal on 7th Sept 2014 for fixing the incorrect hyperlink being generated on Related Works block -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>