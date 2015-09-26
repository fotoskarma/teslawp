<?php
$disable_title = get_post_meta(get_the_id(), 'teslawp_disable_title_check', true);
$disable_sidebar = get_post_meta(get_the_id(), 'teslawp_disable_sidebar_check', true);
$disable_padding = get_post_meta(get_the_id(), 'teslawp_disable_padding_check', true);

$custom_options = get_post_custom(get_the_ID());  
  
if(isset($custom_options['custom_sidebar'])&&$custom_options['custom_sidebar'][0]!=='default')  
{  
    $sidebar_choice = $custom_options['custom_sidebar'][0];  
}  
else  
{  
    $sidebar_choice = "page-sidebar";  
}
?>

<?php get_header(); ?>

<?php if (empty($disable_sidebar)&&is_active_sidebar($sidebar_choice)) echo '<div class="streched">'; ?>

<?php if(have_posts()) : the_post(); ?>

<?php 
if(empty($disable_title)):
?>
	<div class="titleContainer font1 titlePage<?php if (!is_active_sidebar($sidebar_choice)) echo ' titleBordered'; ?>">
	    <div class="title">
	        <?php the_title(); ?>
	    </div>
	</div>
<?php endif; ?>

<div class="page<?php if(!empty($disable_padding)) echo ' page-no-padding'; ?>">
	<div class="pageContents">
		<?php if(get_post_meta(get_the_ID(), 'teslawp_featured_video_enabled', true)==='1')
            echo '<div class="pageFeaturedVideo">'.get_post_meta(get_the_ID(), 'teslawp_featured_video_id', true).'</div>';
        else if (has_post_thumbnail()): ?>
            <div class="pageFeaturedImage">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
		<?php the_content(); ?>
	</div>
    <?php comments_template(); ?>
</div>

<?php endif; ?>

<?php if (empty($disable_sidebar)&&is_active_sidebar($sidebar_choice)): ?>
	</div>
	<div class="sidebar">
        <?php dynamic_sidebar($sidebar_choice); ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>