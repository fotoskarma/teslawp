<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">

        <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
        <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->

        <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
        <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!--Start - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.-->
       <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>-->
        <!--End - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.-->
        <?php
        // echo _gmap('map-canvas');
        // Start - Changes made by Nikhil Kavungal on Sept 20th 2014 to display the title bar icon
        $favicon = _go('favicon');
        if (empty($favicon))
            $favicon = get_template_directory_uri() . '/images/favicon.png';
        echo '<link rel="icon" type="image/png" href="' . $favicon . '">';
        // End - Changes made by Nikhil Kavungal on Sept 20th 2014 to display the title bar icon
        ?>

        <?php wp_head(); ?>

    </head>
    <body <?php body_class(array('font3 teslawp_custom_background')); ?>>
        <!-- Start - Changes made by Nikhil K on 7th Sept 2014 to remove the top lower gray band and changing the color of top band to that of logo's color -->
        <div class="borderline1"></div>
      <div class="loader"></div>
        <!--<div class="borderline2"></div>-->
        <!-- End - Changes made by Nikhil K on 7th Sept 2014 to remove the top lower gray band and changing the color of top band to that of logo's color -->
        <div class="wrapper">
            <div class="header"><!-- HEADER START -->
                <?php
                $logo = _go('logo_text');
                if (empty($logo)) {
                    $logo = _go('logo_image');
                    if (empty($logo))
                        $logo = get_template_directory_uri() . '/images/logo.png';
                    echo '<div class="logo"><a href="' . home_url() . '"><img src="' . $logo . '" alt="logo" /></a></div>';
                }else {
                    $text_color = _go('logo_text_color');
                    if (empty($text_color))
                        $text_color = '#c0392b';
                    echo '<div class="logo" style="margin-top:0;"><a href="' . home_url() . '"><span style="line-height:43px;font-family:' . _go('logo_text_font') . ';color:' . $text_color . ';font-size:' . _go('logo_text_size') . 'px;">' . $logo . '</span></a></div>';
                }
                ?>
                <?php
                $teslawp_social = array(
                    'facebook' => _go('social_platforms_facebook'),
                    'twitter' => _go('social_platforms_twitter'),
                    'google' => _go('social_platforms_google'),
                    'pinterest' => _go('social_platforms_pinterest'),
                    'linkedin' => _go('social_platforms_linkedin'),
                    'dribble' => _go('social_platforms_dribbble'),
                    'behance' => _go('social_platforms_behance'),
                    'youtube' => _go('social_platforms_youtube'),
                    'flickr' => _go('social_platforms_flickr')
                );
                $teslawp_social_values = array_values($teslawp_social);
                $teslawp_social_filtered = array_filter($teslawp_social_values);
                if (!empty($teslawp_social_filtered)):
                    ?>
                    <div class="social">
                        <?php if (!empty($teslawp_social['facebook'])): ?>
                            <a href="<?php echo $teslawp_social['facebook']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/facebook.png" alt="facebook" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['twitter'])): ?>
                            <a href="<?php echo $teslawp_social['twitter']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/twitter.png" alt="twitter" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['google'])): ?>
                            <a href="<?php echo $teslawp_social['google']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/googleplus.png" alt="google plus" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['pinterest'])): ?>
                            <a href="<?php echo $teslawp_social['pinterest']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/pinterest.png" alt="pinterest" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['linkedin'])): ?>
                            <a href="<?php echo $teslawp_social['linkedin']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/linkedin.png" alt="linkedin" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['dribble'])): ?>
                            <a href="<?php echo $teslawp_social['dribble']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/dribble.png" alt="dribble" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['behance'])): ?>
                            <a href="<?php echo $teslawp_social['behance']; ?>" target="_blank">
                                <img style="width:20px;height:auto;" src="<?php echo get_template_directory_uri(); ?>/images/social/behance.png" alt="behance" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['youtube'])): ?>
                            <a href="<?php echo $teslawp_social['youtube']; ?>" target="_blank">
                                <img style="width:20px;height:auto;" src="<?php echo get_template_directory_uri(); ?>/images/social/youtube.png" alt="youtube" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['flickr'])): ?>
                            <a href="<?php echo $teslawp_social['flickr']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/flickr.png" alt="flickr" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($teslawp_social['rss'])): ?>
                            <a href="<?php echo $teslawp_social['rss']; ?>" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/social/rss.png" alt="rss" />
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="menuContainer">
                    <?php
                    if (has_nav_menu('teslawp_menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'teslawp_menu',
                            'menu' => '',
                            'container' => false,
                            'container_class' => '',
                            'container_id' => '',
                            'menu_class' => 'menu font1',
                            'menu_id' => '',
                            'echo' => true,
                            'fallback_cb' => false,
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'depth' => 0,
                            'walker' => new Tesla_Nav_Menu_Walker
                        ));
                        wp_nav_menu(array(
                            'theme_location' => 'teslawp_menu',
                            'menu' => '',
                            'container' => false,
                            'container_class' => '',
                            'container_id' => '',
                            'menu_class' => '',
                            'menu_id' => '',
                            'echo' => true,
                            'fallback_cb' => false,
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'items_wrap' => '<select id="%1$s" class="%2$s"><option> -- Select A Page -- </option>%3$s</select>',
                            'depth' => 0,
                            'walker' => new Tesla_Nav_Menu_Select_Walker
                        ));
                    } else {
                        echo '<ul class="menu font1">' . wp_list_pages(array(
                            'depth' => 0,
                            'show_date' => '',
                            'date_format' => get_option('date_format'),
                            'child_of' => 0,
                            'exclude' => '',
                            'include' => '',
                            'title_li' => '',
                            'echo' => 0,
                            'authors' => '',
                            'sort_column' => 'menu_order, post_title',
                            'link_before' => '',
                            'link_after' => '',
                            'walker' => new Tesla_List_Pages_Walker,
                            'post_type' => 'page',
                            'post_status' => 'publish'
                        )) . '</ul>';
                        echo '<select><option> -- Select A Page -- </option>' . wp_list_pages(array(
                            'depth' => 0,
                            'show_date' => '',
                            'date_format' => get_option('date_format'),
                            'child_of' => 0,
                            'exclude' => '',
                            'include' => '',
                            'title_li' => '',
                            'echo' => 0,
                            'authors' => '',
                            'sort_column' => 'menu_order, post_title',
                            'link_before' => '',
                            'link_after' => '',
                            'walker' => new Tesla_List_Pages_Select_Walker,
                            'post_type' => 'page',
                            'post_status' => 'publish'
                        )) . '</select>';
                    }
                    ?>
                </div>
            </div><!-- HEADER END -->
        </div>
        <div id="contents"><!-- CONTENTS START -->
            <div class="wrapper">