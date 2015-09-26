<div class="works">
    <div class="worksFilter">
        <div class="worksFilterText textcolor6">
            <?php _e('Featured Work:', 'teslawp'); ?>
        </div>
        <ul class="worksFilterCategories">
            <!-- style added by Nikhil so as to hide the ALL category-->
            <li class="textcolor6 bordercolor3" data-category="all" style="display:none">
                <!-- style added by Nikhil so as to hide the ALL category-->
                <div class="bordercolor3">
                    <?php _e('all', 'teslawp'); ?>
                </div>
            </li>
            <!-- counter added by Nikhil K so as to assign an id for the first specific category which will be selected on site load -->
            <?php
            $category_counter = 0;
            foreach ($all_categories as $category_slug => $category_name):
                ?>
                <!--Start - Commented by Nikhil K on 20th Sept 2014 to rectify the issue identified during load of Work Items-->
                <!--<li class="textcolor6 bordercolor3" data-category="<?php echo $category_slug; ?>" id="<?php if ($category_counter === 0) echo 'firstCategoryId_' . $category_name ?>">-->
                <li class="textcolor6 bordercolor3 <?php if ($category_counter === 0) echo worksFilterCategoriesActive ?> " data-category="<?php echo $category_slug; ?>" id="<?php if ($category_counter === 0) echo 'firstCategoryId_' . $category_name ?>">
                    <!--Start - Commented by Nikhil K on 20th Sept 2014 to rectify the issue identified during load of Work Items-->
                    <div class="bordercolor3">
    <?php echo $category_name; ?>
                    </div>
                </li>
                <?php
                $category_counter++;
            endforeach;
            ?>
            <!-- counter added by Nikhil K so as to assign an id for the first specific category which will be selected on site load -->
        </ul>
    </div>
    <div class="worksViews">
        <div class="worksViewsOption bordercolor3 worksViewsOptionActive" data-class="worksContainerView1" style="display:none">
            <img src="<?php echo get_template_directory_uri(); ?>/images/options/sort_opt1.png" alt="" />
        </div>
        <div id="nk_view_second_option" class="worksViewsOption bordercolor3 worksViewsOptionActive" style="display:none" data-class="worksContainerView2">
            <img src="<?php echo get_template_directory_uri(); ?>/images/options/sort_opt2.png" alt="" />
        </div>
    </div>
    <div class="worksContainer worksContainerView1">
<?php foreach ($slides as $slide): ?>
            <div class="worksEntry" data-categories="<?php echo implode(' ', array_keys($slide['categories'])); ?>">
                <div class="worksEntryContainer">
                    <div class="worksEntryInfo">
                        <div class="worksEntryInfoTitle">
                            <a href="<?php echo get_permalink($slide['post']->ID); ?>">
    <?php echo get_the_title($slide['post']->ID); ?>
                            </a>
                        </div>
                        <div  class="worksEntryInfoExcerpt">
                            <?php echo $slide['options']['small_description']; ?>
                        </div>
                        <div  class="worksEntryInfoExcerptBig">
                        <?php echo $slide['options']['big_description']; ?>
                        </div>
                                <?php if (!$shortcode['no_more']): ?>
                            <div class="worksEntryInfoMore">
                                <a href="<?php echo get_permalink($slide['post']->ID); ?>">
                            <?php _e('read more', 'teslawp'); ?>
                                </a>
                            </div>
    <?php endif; ?>
                    </div>
                    <a href="<?php echo get_permalink($slide['post']->ID); ?>"><img class="worksEntryImg" src="<?php echo $slide['options']['small_image']; ?>" alt="" /></a>
                    <img class="worksEntryImgBig" src="<?php echo $slide['options']['big_image']; ?>" alt="" />
                </div>
            </div>
<?php endforeach; ?>
    </div>
</div>