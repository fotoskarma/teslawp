<?php get_header(); ?>



<?php if (is_active_sidebar('blog-sidebar')) echo '<div class="streched">'; ?>
<?php while (have_posts()) : the_post(); ?>
    <!--Added by Nikhil Kavungal on 17th Aug 2014 start-->
    <!--Reason - Post title was being displayed as "Single POST"-->
        <!--<div class="titleContainer font1 titlePage<?php if (!is_active_sidebar('blog-sidebar')) echo ' titleBordered'; ?>"><div class="title"><?php _e('Single post', 'teslawp'); ?></div></div>-->
    <div class="titleContainer font1 titlePage<?php if (!is_active_sidebar('blog-sidebar')) echo ' titleBordered'; ?>"><div class="title"><?php _e(the_title(), 'teslawp'); ?></div></div>
    <!--Added by Nikhil Kavungal on 17th Aug 2014 end-->
    <div class="post" id="<?php the_ID(); ?>">
        <?php
        if (get_post_meta(get_the_ID(), 'teslawp_featured_video_enabled', true) === '1')
            echo '<div class="postFeatured"><div class="postFeaturedVideo">' . get_post_meta(get_the_ID(), 'teslawp_featured_video_id', true) . '</div></div>';
        else if (has_post_thumbnail()):
            ?>
            <div class="postFeatured">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
        <!--Start - Commented by Nikhil Kavungal on 13th Sept 2014 to avoid duplicate post titles-->
        <!--<h2 class="postTitle"><?php the_title(); ?></h2>-->
        <!--End - Commented by Nikhil Kavungal on 13th Sept 2014 to avoid duplicate post titles-->
        <div <?php post_class('postBody'); ?>>
            <?php the_content(); ?>
        </div>
        <?php
        wp_link_pages(array(
            'before' => '<p class="post-numbers">',
            'after' => '</p>',
            'link_before' => '',
            'link_after' => '',
            'next_or_number' => 'number',
            'pagelink' => '%',
            'echo' => 1
        ));
        ?>
        <div class="postFooter">
            <div class="postFooterComments">
                <?php comments_number(); ?>
            </div>
            <div class="postFooterDate">
                <?php _e('posted by', 'teslawp'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'teslawp'); ?> <?php the_date('l, F jS, Y'); ?> <?php _e('at', 'teslawp'); ?> <?php the_time('g:i a'); ?> <?php _e('in', 'teslawp'); ?> <?php the_category(', '); ?>
            </div>
            <?php the_tags('<p class="teslawp_tags">' . __('tags', 'teslawp') . ': ', ', ', '</p>'); ?>
        </div>
        <?php comments_template(); ?>
    </div> <!-- .post -->

<?php endwhile; ?>
<?php if (is_active_sidebar('blog-sidebar')): ?>

    </div>
    <div class="sidebar">
        <?php dynamic_sidebar('blog-sidebar'); ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>