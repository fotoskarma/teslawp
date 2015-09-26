<?php
$teslawp_blog_title = _go('blog_title');
if(empty($teslawp_blog_title))
    $revokje_blog_title = __('Blog','teslawp');
?>

<?php get_header(); ?>

<?php if (is_active_sidebar('blog-sidebar')) echo '<div class="streched">'; ?>

<?php if (have_posts()) : ?>
    <div class="titleContainer font1 titlePage"><div class="title">
        <?php
        if(is_archive())
            if(is_category())
                single_cat_title(__('Category','teslawp').': ');
            elseif(is_tag())
                single_tag_title(__('Tag','teslawp').': ');
            elseif(is_day())
                echo __('Archive','teslawp').': '.get_the_date('F jS, Y');
            elseif(is_month())
                echo __('Archive','teslawp').': '.get_the_date('F, Y');
            elseif(is_year())
                echo __('Archive','teslawp').': '.get_the_date('Y');
            else
                echo 'Archive';
        elseif(is_search())
            echo __('Search','teslawp').': '.get_search_query();
        else
            echo $teslawp_blog_title;
        ?>
    </div></div>
    <div class="blog">
        <?php while (have_posts()) : the_post(); ?>


            <div <?php post_class(array('blogEntry')); ?> id="<?php the_ID(); ?>">
                <?php
                if(!is_archive()):
                    if (get_post_meta(get_the_ID(), 'teslawp_featured_video_enabled', true) === '1')
                        echo '<div class="blogEntryFeatured"><div class="blogEntryFeaturedVideo">' . get_post_meta(get_the_ID(), 'teslawp_featured_video_id', true) . '</div></div>';
                    else if (has_post_thumbnail()):
                        ?>
                        <div class="blogEntryFeatured">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <h2 class="blogEntryTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php if(is_sticky()) echo '<span class="blogEntryTitleFeatured">'.__('featured','teslawp').'</span>'; ?></h2>

                <div class="entry blogEntryExcerpt">
                    <?php if(!is_archive()) the_excerpt(); ?>
                </div>
                <div class="blogEntryFooter">
                    <div class="blogEntryFooterDate">
                        <?php echo get_the_date('d M Y'); ?>
                    </div>
                    <div class="blogEntryFooterDelimiter">
                        /
                    </div>
                    <div class="blogEntryFooterComments">
                        <a href="<?php the_permalink(); ?>">
                            <?php comments_number(); ?>
                        </a>
                    </div>
                </div>
            </div> <!-- .post -->

        <?php endwhile; ?>
    </div>
<?php else : ?>
<?php if(is_search()): ?>
    <div class="titleContainer font1 titlePage"><div class="title"><?php _e('Search:','teslawp'); ?> <?php the_search_query(); ?></div></div>
    <div class="searchNoResults">
        <h2 class="searchNoResultsTitle"><?php _e('No Results','teslawp'); ?></h2>
        <p><?php _e('Try searching again.','teslawp'); ?></p>
        <div class="searchNoResultsForm font2">
            <?php get_search_form(); ?>
        </div>
    </div>
<?php else: ?>
    <div class="titleContainer font1 titlePage<?php if (!is_active_sidebar('blog-sidebar')) echo ' titleBordered'; ?>"><div class="title"><?php _e('Not Found','teslawp'); ?></div></div>
<?php endif; ?>
<?php endif; ?>



<?php if (is_active_sidebar('blog-sidebar')): ?>

    </div>
    <div class="sidebar">
        <?php dynamic_sidebar('blog-sidebar'); ?>
    </div>
    <div class="streched">
        <?php
        global $wp_query;
        $big = 999999999; // need an unlikely integer
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '/page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'type' => 'list',
                'next_text' => __('&rarr;', 'teslawp'),
                'prev_text' => __('&larr;', 'teslawp'),
            ));
        }
        ?>
    </div>

    <?php
else:

    global $wp_query;
    $big = 999999999; // need an unlikely integer
    $total_pages = $wp_query->max_num_pages;
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'type' => 'list',
            'next_text' => __('&rarr;', 'teslawp'),
            'prev_text' => __('&larr;', 'teslawp'),
        ));
    }

endif;
?>

<?php get_footer(); ?>