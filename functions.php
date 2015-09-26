<?php
/* ============================== TESLA FRAMEWORK ====================================================================================================================== */

require_once(get_template_directory() . '/tesla_framework/tesla.php');
require_once(get_template_directory() . '/tesla_framework/extensions/twitteroauth/twitteroauth.php');



/* ============================== THEME FEATURES ====================================================================================================================== */

function teslawp_theme_features() {

    register_nav_menus(array(
        'teslawp_menu' => 'Tesla Header Menu'
    ));

    if (!isset($content_width))
        $content_width = 960;

    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Blog Sidebar',
            'id' => 'blog-sidebar',
            'description' => 'This sidebar is located on the left side of the content on the blog page.',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widgetTitle font1 widgettitle">',
            'after_title' => '</div>'
        ));
        register_sidebar(array(
            'name' => 'Footer Sidebar',
            'id' => 'footer-sidebar',
            'description' => 'This sidebar is located in the footer area of the blog page.',
            'class' => '',
            'before_widget' => '<div class="footerColumn"><div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="titleContainer titleFooter font1 widgettitle"><div class="title">',
            'after_title' => '</div></div>'
        ));
        register_sidebar(array(
            'name' => 'Page Sidebar',
            'id' => 'page-sidebar',
            'description' => 'This sidebar is located on the left side of the content on user created pages. This is the default sidebar for pages.',
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widgetTitle font1 widgettitle">',
            'after_title' => '</div>'
        ));

        for ($i = 1; $i <= 10; $i++)
            register_sidebar(array(
                'name' => 'Alternative Sidebar #' . $i,
                'id' => 'alt-sidebar-' . $i,
                'description' => 'This sidebar is can be chosen as an alternative for Page Sidebar.',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget %2$s font2">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widgetTitle font1 widgettitle">',
                'after_title' => '</div>'
            ));
    }

    add_theme_support('post-thumbnails');

    add_theme_support('automatic-feed-links');
}

teslawp_theme_features();



/* ============================== LANGUAGE SETUP ====================================================================================================================== */

function my_theme_setup() {
    load_theme_textdomain('teslawp', get_template_directory() . '/language');
}

add_action('after_setup_theme', 'my_theme_setup');



/* ============================== SCRIPTS & STYLES ====================================================================================================================== */

function teslawp_scripts() {

    wp_enqueue_style('teslawp-style', get_template_directory_uri() . '/css/style.css', false, null);
    wp_enqueue_style('teslawp-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array('teslawp-style'), null);
    wp_enqueue_style('teslawp-style-wp', get_template_directory_uri() . '/style.css', false, null);

    wp_enqueue_script('jquery');

    wp_enqueue_script('teslawp-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), null);
    wp_enqueue_script('teslawp-main-script', get_template_directory_uri() . '/js/script.js', array('jquery', 'teslawp-plugins'), null);

    wp_localize_script("teslawp-main-script", "teslawp_main", array("ajaxurl" => admin_url("admin-ajax.php")));

    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script("comment-reply", array('jquery'));

    $protocol = is_ssl() ? 'https' : 'http';

    if (_go('logo_text_font')) {
        $font = str_replace(' ', '+', _go('logo_text_font'));
        wp_enqueue_style('tesla-custom-font', "$protocol://fonts.googleapis.com/css?family=$font");
    }
}

function teslawp_admin_scripts($hook_suffix) {
    if ('widgets.php' == $hook_suffix) {
        wp_enqueue_media();
        wp_enqueue_script('teslawp-widget-script', get_template_directory_uri() . '/js/teslawp_admin_widgets.js', array('media-upload', 'media-views'), null);
    }
    if ($hook_suffix == 'post-new.php' || $hook_suffix == 'post.php') {
        wp_enqueue_script('teslawp-post-script', get_template_directory_uri() . '/js/teslawp_admin_post.js', array('jquery'), null);
    }
}

if (!is_admin())
    add_action('wp_enqueue_scripts', 'teslawp_scripts');
else
    add_action('admin_enqueue_scripts', 'teslawp_admin_scripts');

function teslawp_header() {
    $background_image = _go('bg_image');
    $background_position = _go('bg_image_position');
    $background_repeat = _go('bg_image_repeat');
    $background_attachment = _go('bg_image_attachment');
    $background_color = _go('bg_color');
    echo '<style type="text/css">';
    echo '.teslawp_custom_background{';
    if (!empty($background_image))
        echo 'background-image: url(' . $background_image . ');';
    if (!empty($background_position)) {
        echo 'background-position: ';
        switch ($background_position) {
            case 'Left':
                echo 'top left';
                break;
            case 'Center':
                echo 'top center';
                break;
            case 'Right':
                echo 'top right';
                break;
            default:
                break;
        }
        echo ';';
    }
    if (!empty($background_repeat)) {
        echo 'background-repeat: ';
        switch ($background_repeat) {
            case 'No Repeat':
                echo 'no-repeat';
                break;
            case 'Tile':
                echo 'repeat';
                break;
            case 'Tile Horizontally':
                echo 'repeat-x';
                break;
            case 'Tile Vertically':
                echo 'repeat-y';
                break;
            default:
                break;
        }
        echo ';';
    }
    if (!empty($background_attachment)) {
        echo 'background-attachment: ';
        switch ($background_attachment) {
            case 'Scroll':
                echo 'scroll';
                break;
            case 'Fixed':
                echo 'fixed';
                break;
            default:
                break;
        }
        echo ';';
    }
    if (!empty($background_color))
        echo 'background-color: ' . $background_color . ';';
    echo '}';
    echo _go('custom_css');
    $default = _go('site_color');
    if (empty($default))
        $default = '#c0392b';
    ?>
    <style type="text/css">
        .textcolor{
            color: <?php echo $default; ?>;
        }
        .textcolor_hover:hover{
            color: <?php echo $default; ?>;
        }
        .bgcolor{
            background-color: <?php echo $default; ?>;
        }
        .bgcolor_hover:hover{
            background-color: <?php echo $default; ?>;
        }
        .bordercolor{
            border-color: <?php echo $default; ?>;
        }
        .social a:hover img{
            background-color: <?php echo $default; ?>;
        }
        .menuContainer>ul.menu>li.menuactive>a,
        .menuContainer>ul.menu>li>a:hover{
            background-color: <?php echo $default; ?>;
        }
        .menuContainer div.menuLevel>ul.menuDrop>li:hover>a{
            background-color: <?php echo $default; ?>;
        }
        .menuContainer div.menuLevel>ul.menuDrop>li>div.menuDropArrow{
            background-color: <?php echo $default; ?>;
        }
        .titleContainer{
            border-bottom-color: <?php echo $default; ?>;
        }
        .titleContainer .title{
            border-bottom-color: <?php echo $default; ?>;
        }
        .titleContainer .clientsNav .clientsNavPrev{
            background-color: <?php echo $default; ?>;
        }
        .titleContainer .clientsNav .clientsNavNext{
            background-color: <?php echo $default; ?>;
        }
        .widgetFlickr .widgetFlickrImg:hover{
            border-color: <?php echo $default; ?>;
        }
        .contact .contactForm fieldset.contactFormButtons input[type="submit"]:hover,
        .contactForm fieldset.contactFormButtons input[type="submit"]:hover,
        .contact .contactForm fieldset.contactFormButtons input[type="reset"]:hover,
        .contactForm fieldset.contactFormButtons input[type="reset"]:hover{
            background-color: <?php echo $default; ?>;
        }
        .pageSlider ul.pageSliderNav li.active,
        .pageSlider ul.pageSliderNav li:hover{
            background-color: <?php echo $default; ?>;
        }
        .widgetCategories ul li a span{
            background-color: <?php echo $default; ?>;
        }
        .widgetCategories ul li a:hover{
            color: <?php echo $default; ?>;
        }
        .widgetGallery .widgetGalleryImg a:hover img{
            border-color: <?php echo $default; ?>;
        }
        .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a span{
            background-color: <?php echo $default; ?>;
        }
        .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a:hover img{
            border-color: <?php echo $default; ?>;
        }
        .works .worksFilter ul.worksFilterCategories li.worksFilterCategoriesActive div,
        .works .worksFilter ul.worksFilterCategories li:hover div{
            background-color: <?php echo $default; ?>;
        }
        .works .worksViews .worksViewsOption.worksViewsOptionActive,
        .works .worksViews .worksViewsOption:hover{
            border-color: <?php echo $default; ?>;
        }
        .works .worksContainer.worksContainerView1 .worksEntry .worksEntryContainer .worksEntryInfo .worksEntryInfoMore:hover{
            background-color: <?php echo $default; ?>;
        }
        .works .worksContainer.worksContainerView2 .worksEntry .worksEntryContainer .worksEntryInfo .worksEntryInfoTitle a:hover{
            color: <?php echo $default; ?>;
        }
        .blog .blogEntry .blogEntryTitle a:hover{
            color: <?php echo $default; ?>;
        }
        .blog .blogEntry .blogEntryFooter .blogEntryFooterComments a{
            color: <?php echo $default; ?>;
            border-color: <?php echo $default; ?>;
        }
        .blogNav a.blogNavActive,
        .blogNav a:hover{
            color: <?php echo $default; ?>;
        }
        .post .postForm .postFormButtons input:hover{
            background-color: <?php echo $default; ?>;
        }
        .project .projectInfo .projectInfoDetails .projectInfoDetailsEntry .projectInfoDetailsEntryBody a{
            color: <?php echo $default; ?>;
        }
        .footer .footerColumn .widget .widgetBody a:hover{
            color: <?php echo $default; ?>;
        }
        .sidebar .widget_teslawp_categories ul li a span{
            background-color: <?php echo $default; ?>;
        }
        ul.page-numbers a:hover,
        ul.page-numbers span.current{
            color: <?php echo $default; ?>;
        }
        #postForm p.form-submit #submit:hover{
            background-color: <?php echo $default; ?>;
        }
        #reply-title a:hover{
            color: <?php echo $default; ?>;
        }
        .sidebar .widget table tfoot tr td a:hover{
            color: <?php echo $default; ?>;
        }
        .sidebar .widget table tbody tr td a:hover{
            background-color: <?php echo $default; ?>;
        }
        .sidebar .widget .tagcloud a:hover,
        .sidebar .widget .textwidget a:hover{
            color: <?php echo $default; ?>;
        }
        .sidebar .widget .widgetTitle a:hover{
            color: <?php echo $default; ?>;
        }
        .sidebar .widget #searchform #searchsubmit:hover{
            background-color: <?php echo $default; ?>;
        }
        .sidebar .widgetWorks .widgetWorksEntry .widgetWorksEntryImg a:hover{
            border-color: <?php echo $default; ?>;
        }
        .searchNoResults form input#searchsubmit:hover{
            background-color: <?php echo $default; ?>;
        }
        .footerColumn a:hover{
            color: <?php echo $default; ?>;
        }
        .footerColumn .widget_search #searchsubmit:hover{
            background-color: <?php echo $default; ?>;
        }
        .menuContainer > ul.menu > li.current_page_item > a,
        .menuContainer > ul.menu > li.current-menu-item > a{
            background-color: <?php echo $default; ?>;
        }
        .post-numbers{
            color: <?php echo $default; ?>;
        }
        .post-numbers a:hover,
        .postFooter a:hover,
        .pingback a:hover,
        .postCommentsEntryBodyMessage a:hover,
        .post .postBody a:hover,
        .pageContents a:hover,
        .postCommentsEntryBodyUser a:hover,
        .trackback a:hover{
            color: <?php echo $default; ?>;
        }
        .pageContents input[type="submit"]:hover,
        .pageContents input[type="reset"]:hover{
            background-color: <?php echo $default; ?>;
        }
        .sidebar .widget ul li a:hover, .sidebar .widget_teslawp_categories ul li a:hover{
            color: <?php echo $default; ?>;
        }
    </style>

    <?php
    echo '</style>';
}

add_action('wp_head', 'teslawp_header', 1000);

function teslawp_footer() {
    echo _go('tracking_code');
}

add_action('wp_footer', 'teslawp_footer', 1000);



/* ============================== WIDGETS ====================================================================================================================== */

class Tesla_contact_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_contact', 'Tesla - Contact', array(
            'description' => __('Contact details', 'teslawp'),
            'classname' => 'widget_teslawp_contact',
                ), array('width' => 400, 'height' => 350)
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Contact', 'teslawp') : $instance['title'], $instance, $this->id_base);
        $company = empty($instance['company']) ? 'Company' : $instance['company'];
        $text = empty($instance['text']) ? "Address\nCity, State Zip\n+123 456 7890\n+123 456 7890\nemail@address.com" : $instance['text'];
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <div class="widgetBody">
            <div class="widgetAddress">
                <div class="widgetAddressCompany"><?php echo $company; ?></div>
                <?php echo!empty($instance['filter']) ? wpautop($text) : $text; ?>
            </div>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['company'] = strip_tags($new_instance['company']);
        if (current_user_can('unfiltered_html'))
            $instance['text'] = $new_instance['text'];
        else
            $instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text'])));
        $instance['filter'] = isset($new_instance['filter']);
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => 'Contact', 'text' => "Address\nCity, State Zip\n+123 456 7890\n+123 456 7890\nemail@address.com", 'company' => 'Company', 'filter' => 1));
        $title = strip_tags($instance['title']);
        $text = esc_textarea($instance['text']);
        $company = strip_tags($instance['company']);
        $filter = $instance['filter'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('company'); ?>"><?php _e('Company:', 'teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('company'); ?>" name="<?php echo $this->get_field_name('company'); ?>" type="text" value="<?php echo esc_attr($company); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Contact details:', 'teslawp'); ?></label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
        </p>

        <p>
            <input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked($filter); ?> />&nbsp;
            <label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add line breaks', 'teslawp'); ?></label>
        </p>
        <?php
    }

}

class Tesla_categories_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_categories', 'Tesla - Categories', array(
            'description' => __('A list of categories', 'teslawp'),
            'classname' => 'widget_teslawp_categories',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Categories', 'teslawp') : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <ul>
            <?php
            $cat_args['title_li'] = '';
            wp_list_categories(apply_filters('widget_teslawp_categories_args', $cat_args));
            ?>
        </ul>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = esc_attr($instance['title']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'teslawp'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

}

class Tesla_twitter_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_twitter', 'Tesla - Twitter', array(
            'description' => __('A list of latest tweets', 'teslawp'),
            'classname' => 'widget_teslawp_twitter',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Twitter', 'teslawp') : $instance['title'], $instance, $this->id_base);
        $user = empty($instance['user']) ? 'teslathemes' : $instance['user'];
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 3;

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;

        echo self::twitter_generate_output($user, $number);

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['user'] = strip_tags($new_instance['user']);
        $instance['number'] = (int) strip_tags($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $user = isset($instance['user']) ? esc_attr($instance['user']) : 'teslathemes';
        $number = isset($instance['number']) ? absint($instance['number']) : 3;
        ?>
        <p>
            <label><?php _e('Title:', 'teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label> 
            <label><?php _e('Twitter user:', 'teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($user); ?>" /></label> 
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Number of posts to show:', 'teslawp'); ?>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </label>
        </p>
        <?php
    }

    private static function twitter_get_tweets($twitteruser) {

        $cache = get_transient('revoke_twitter');

        if (is_array($cache) && array_key_exists($twitteruser, $cache))
            return $cache[$twitteruser];

        $consumerkey = _go('twitter_consumerkey');
        $consumersecret = _go('twitter_consumersecret');
        $accesstoken = _go('twitter_accesstoken');
        $accesstokensecret = _go('twitter_accesstokensecret');

        if (empty($consumerkey) || empty($consumersecret) || empty($accesstoken) || empty($accesstokensecret))
            return null;

        $connection = self::getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $twitteruser);

        if (!is_array($cache))
            $cache = array();
        $cache[$twitteruser] = $tweets;
        set_transient('revoke_twitter', $cache, 60);

        return $tweets;
    }

    private static function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
        $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
        return $connection;
    }

    private static function linkify($status_text) {
        // linkify URLs
        $status_text = preg_replace(
                '/(https?:\/\/\S+)/', '<a href="\1">\1</a>', $status_text
        );

        // linkify twitter users
        $status_text = preg_replace(
                '/(^|\s)@(\w+)/', '\1@<a href="http://twitter.com/\2">\2</a>', $status_text
        );

        // linkify tags
        $status_text = preg_replace(
                '/(^|\s)#(\w+)/', '\1#<a href="http://search.twitter.com/search?q=%23\2">\2</a>', $status_text
        );

        return $status_text;
    }

    private static function twitter_generate_output($user, $number) {

        $tweets = self::twitter_get_tweets($user);

        if (is_null($tweets))
            return 'Twitter is not configured.';

        $number = min(20, $number);

        $tweets = array_slice($tweets, 0, $number);

        $output = '<div class="widgetBody widgetTwitter" data-user="<?php echo $user; ?>" data-posts="<?php echo $number; ?>">';

        $first_tweet = true;

        $time = time();

        foreach ($tweets as $tweet) {

            $date = $tweet->created_at;
            $date = date_parse($date);
            $date = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
            $date = $time - $date;

            $seconds = $date % 60;
            $date = floor($date / 60);
            $minutes = $date % 60;
            if ($minutes) {
                $date = floor($date / 60);
                $hours = $date % 24;
                if ($hours) {
                    $date = floor($date / 24);
                    $days = $date % 7;
                    if ($days) {
                        $date = floor($date / 7);
                        $weeks = $date;
                        if ($weeks)
                            $date = $weeks . ' week' . (1 === $weeks ? '' : 's') . ' ago';
                        else
                            $date = $days . ' day' . (1 === $days ? '' : 's') . ' ago';
                    } else
                        $date = $hours . ' hour' . (1 === $hours ? '' : 's') . ' ago';
                } else
                    $date = $minutes . ' minute' . (1 === $minutes ? '' : 's') . ' ago';
            } else
                $date = 'less than a minute ago';

            if ($first_tweet)
                $first_tweet = false;
            else
                $output .= '<div class="widgetPostsEntryDelimiter widgetPostsEntryDelimiterSmall"></div>';

            $output .=
                    '<div class="widgetTwitterPost">' .
                    '<div class="widgetTwitterPostText">' .
                    self::linkify($tweet->text) .
                    '</div>' .
                    '<div class="widgetTwitterPostDate textcolor8">' .
                    $date .
                    '</div>' .
                    '</div>';
        }

        $output .= '</div>';

        return $output;
    }

}

class Tesla_flickr_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_flickr', 'Tesla - Flickr', array(
            'description' => __('A list of Flickr images', 'teslawp'),
            'classname' => 'widget_teslawp_flickr',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Flickr widget', 'teslawp') : $instance['title'], $instance, $this->id_base);
        $user = empty($instance['user']) ? '97073871@N04' : $instance['user'];
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 12;

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <div class="widgetBody widgetFlickr" data-user="<?php echo $user; ?>" data-images="<?php echo $number; ?>"></div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['user'] = strip_tags($new_instance['user']);
        $instance['number'] = (int) strip_tags($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $user = isset($instance['user']) ? esc_attr($instance['user']) : '97073871@N04';
        $number = isset($instance['number']) ? absint($instance['number']) : 12;
        ?>
        <p>
            <label><?php _e('Title:', 'teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label> 
            <label><?php _e('Flickr user id:', 'teslawp'); ?><input class="widefat" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($user); ?>" /></label> 
            <label for="<?php echo $this->get_field_id('number'); ?>">
                <?php _e('Number of posts to show:', 'teslawp'); ?>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
            </label>
        </p>
        <?php
    }

}

class Tesla_latest_posts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_latest_posts', 'Tesla - Latest Posts', array(
            'description' => __('A list of the latest posts', 'teslawp'),
            'classname' => 'widget_teslawp_latest_posts',
                )
        );
        $this->alt_option_name = 'widget_teslawp_latest_posts_entries';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_teslawp_latest_posts_cache', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Latest Posts', 'teslawp') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 10;

        $r = new WP_Query(apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true)));
        if ($r->have_posts()) :
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>
            <?php if ($args['id'] === 'footer-sidebar'): ?>
                <div class="widgetBody widgetPosts">
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <div class="widgetPostsEntry">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="widgetPostsEntryAvatar">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="widgetPostsEntryBody">
                                <div class="widgetPostsEntryBodyTitle">
                                    <a class="textcolor7" href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                                <div class="widgetPostsEntryBodyText">
                                    <?php echo get_the_excerpt() . '&nbsp;<a class="widgetPostsEntryBodyTextMore bgcolor" href="' . get_permalink() . '"></a>'; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($r->have_posts()): ?>
                            <div class="widgetPostsEntryDelimiter"></div>
                            <?php
                        else: break;
                        endif;
                        ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <ul>
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <li>
                            <span class="post-date"><?php echo get_the_date('d M'); ?></span>
                            <a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php
                                if (get_the_title())
                                    the_title();
                                else
                                    the_ID();
                                ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_teslawp_latest_posts_cache', $cache, 'widget');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_teslawp_latest_posts_entries']))
            delete_option('widget_teslawp_latest_posts_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_teslawp_latest_posts_cache', 'widget');
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'teslawp'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'teslawp'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <?php
    }

}

class Tesla_sidebar_gallery_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_sidebar_gallery', 'Tesla - Sidebar Gallery', array(
            'description' => __('A gallery of images', 'teslawp'),
            'classname' => 'widget_teslawp_sidebar_gallery',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Sidebar Gallery', 'teslawp') : $instance['title'], $instance, $this->id_base);
        $category = $instance['category'];

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <div class="widgetGallery">
            <?php
            if (isset($instance['category']) && $instance['category'] !== '') {
                $args = array(
                    'numberposts' => $instance['number'],
                    'category' => $instance['category'],
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'meta_key' => '_thumbnail_id',
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'suppress_filters' => true
                );
                $query = get_posts($args);
                foreach ($query as $q) {
                    echo '<div class="widgetGalleryImg">';
                    echo '<a href="' . get_permalink($q->ID) . '">';
                    echo get_the_post_thumbnail($q->ID);
                    echo '</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = $new_instance['category'] === '' ? NULL : (int) strip_tags($new_instance['category']);
        $instance['number'] = (int) strip_tags($new_instance['number']);

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'category' => ''));
        $title = esc_attr($instance['title']);
        $category = esc_attr($instance['category']);
        $number = isset($instance['number']) ? absint($instance['number']) : 9;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'teslawp'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of images to show:', 'teslawp'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                <?php
                $term = term_exists($instance['category'], 'category');
                if ($instance['category'] === '' || $term === 0 || $term === null)
                    echo '<option value=""> - Choose a category - </option>';
                $cats = get_categories();
                foreach ($cats as $c) {
                    $option = '<option value="' . $c->cat_ID . '"' . selected($instance['category'], $c->cat_ID, false) . '>';
                    $option .= $c->cat_name;
                    $option .= '</option>';
                    echo $option;
                }
                ?>
            </select>
        </p>
        <?php
    }

}

class Tesla_recent_works_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'teslawp_recent_works', 'Tesla - Recent Works', array(
            'description' => __('A list of recent works', 'teslawp'),
            'classname' => 'widget_teslawp_recent_works',
                )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Works', 'teslawp') : $instance['title'], $instance, $this->id_base);
        $category = $instance['category'];
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        ?>
        <div class="widgetWorks">
            <?php
            // Added by Nikhil Kavungal on 17th August 2014 start
            // reason - Recent Works widget didnt show the Portfolio works
            // 
            // if (isset($instance['category']) && $instance['category'] !== '') {
            $cat_args['title_li'] = '';
            // $args = array(
            // 'numberposts' => $instance['number'],
            // 'category' => $instance['category'],
            // 'orderby' => 'post_date',
            // 'order' => 'DESC',
            // 'post_type' => 'teslawp_portfolio',
            // 'post_status' => 'publish',
            // 'suppress_filters' => true
            // );

            $args = array(
                'numberposts' => $instance['number'],
                'post_type' => 'teslawp_portfolio',
                'orderby' => 'post_date',
                'order' => 'desc',
                'post_status' => 'publish'
            );
            if (isset($instance['category']) && $instance['category'] !== '') {
                $args['teslawp_portfolio_tax'] = $instance['category'];
            }
            $query = get_posts($args);
            // echo '<pre>' . print_r($query, true) . '</pre>asdasdas';
            echo '<ul>';
            foreach ($query as $q) {
                // echo '<div class="widgetWorksEntry">';
                // echo '<div class="widgetWorksEntryImg">';
                echo '<li>';
                echo '<a href="' . get_permalink($q->ID) . '">';
                // echo '<span></span>';
                echo $q->post_title;
                echo '</a>';
                echo '</li>';
                // echo '</div>';
                // echo '<div class="widgetWorksEntryInfo">';
                // echo $q->post_excerpt;
                // echo '</div>';
                // echo '</div>';
            }
            echo '</ul>';
            // }
            // Added by Nikhil Kavungal on 17th August 2014 end
            ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        // Added by Nikhil Kavungal on 17th August 2014 start
        // Reason: Category value was displayed as int so removed the int casting for category
        $instance['category'] = $new_instance['category'] === '' ? NULL : strip_tags($new_instance['category']);
        // Added by Nikhil Kavungal on 17th August 2014 end
        $instance['number'] = (int) strip_tags($new_instance['number']);
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'category' => ''));
        $title = esc_attr($instance['title']);
        $category = esc_attr($instance['category']);
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'teslawp'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of works to show:', 'teslawp'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>
        <p>
            <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
                <?php
                $term = term_exists($instance['category'], 'category');
                if ($instance['category'] === '' || $term === 0 || $term === null)
                    echo '<option value=""> - Choose a category - </option>';
                $cats = Tesla_slider::get_categories('teslawp_portfolio', true);
                foreach ($cats as $key => $category_label) {
                    $option = '<option value="' . $key . '"' . selected($instance['category'], $key, false) . '>';
                    $option .= $category_label;
                    $option .= '</option>';
                    echo $option;
                }
                ?>
            </select>
        </p>
        <?php
    }

}

function teslawp_register_widgets() {
    register_widget('Tesla_categories_widget');
    register_widget('Tesla_latest_posts_widget');
    register_widget('Tesla_sidebar_gallery_widget');
    register_widget('Tesla_recent_works_widget');
    register_widget('Tesla_twitter_widget');
    register_widget('Tesla_flickr_widget');
    register_widget('Tesla_contact_widget');
}

add_action('widgets_init', 'teslawp_register_widgets');

class Walker_Category_teslawp extends Walker_Category {

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        extract($args);

        $cat_name = esc_attr($category->name);
        $cat_name = apply_filters('list_cats', $cat_name, $category);
        $link = '<a href="' . esc_url(get_term_link($category)) . '" ';
        if ($use_desc_for_title == 0 || empty($category->description))
            $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s'), $cat_name)) . '"';
        else
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        $link .= '><span></span>';
        $link .= $cat_name . '</a>';

        if (!empty($feed_image) || !empty($feed)) {
            $link .= ' ';

            if (empty($feed_image))
                $link .= '(';

            $link .= '<a href="' . esc_url(get_term_feed_link($category->term_id, $category->taxonomy, $feed_type)) . '"';

            if (empty($feed)) {
                $alt = ' alt="' . sprintf(__('Feed for all posts filed under %s'), $cat_name) . '"';
            } else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
            }

            $link .= '>';

            if (empty($feed_image))
                $link .= $name;
            else
                $link .= "<img src='$feed_image'$alt$title" . ' />';

            $link .= '</a>';

            if (empty($feed_image))
                $link .= ')';
        }

        if (!empty($show_count))
            $link .= ' (' . intval($category->count) . ')';

        if ('list' == $args['style']) {
            $output .= "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;
            if (!empty($current_category)) {
                $_current_category = get_term($current_category, $category->taxonomy);
                if ($category->term_id == $current_category)
                    $class .= ' current-cat';
                elseif ($category->term_id == $_current_category->parent)
                    $class .= ' current-cat-parent';
            }
            $output .= ' class="' . $class . '"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }

}

/* ============================== FILTERS ====================================================================================================================== */

function widget_teslawp_categories_args_filter() {
    $args = func_get_args();
    $args[0]['walker'] = new Walker_Category_teslawp;
    return $args[0];
}

function teslawp_read_more_filter() {
    return '';
}

add_filter('widget_teslawp_categories_args', 'widget_teslawp_categories_args_filter');
add_filter('excerpt_more', 'teslawp_read_more_filter');



/* ============================== COMMENTS ====================================================================================================================== */

function teslawp_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
            ?>
            <div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php _e('Pingback:', 'teslawp'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('(Edit)', 'teslawp'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
            default :
                global $post;
                ?>

                <div <?php comment_class(array('postCommentsEntry')); ?>>

                    <div class="postCommentsEntryAvatar">
                        <?php echo get_avatar($comment, 50); ?>
                    </div>

                    <div class="postCommentsEntryBody">

                        <div class="postCommentsEntryBodyUser">
                            <?php echo get_comment_author_link(); ?>
                        </div>
                        <div class="postCommentsEntryBodyDate">
                            <?php comment_date('F jS, Y'); ?> at <?php comment_time('g:i a'); ?>
                        </div>
                        <div class="postCommentsEntryBodyMessage">
                            <?php if ('0' == $comment->comment_approved) : ?>
                                <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'teslawp'); ?></p>
                            <?php endif; ?>
                            <?php comment_text(); ?>
                        </div>
                        <div class="postCommentsEntryBodyButton" id="comment-<?php comment_ID(); ?>">
                            <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'teslawp'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            <?php edit_comment_link(__('Edit', 'teslawp')); ?>
                        </div>
                        <div class="postCommentsEntryBodyReplies">

                            <?php
                            break;
                    endswitch;
                }

                function teslawp_comment_end($comment, $args, $depth) {
                    $GLOBALS['comment'] = $comment;
                    switch ($comment->comment_type) :
                        case 'pingback' :
                        case 'trackback' :
                            ?>
                        </div>
                        <?php
                        break;
                    default :
                        ?>
                    </div></div></div>
            <?php
            break;
    endswitch;
}

/* ============================== META BOXES ====================================================================================================================== */

function teslawp_featured_video($post) {
    wp_nonce_field(-1, 'teslawp_featured_video_nonce');
    $value = get_post_meta($post->ID, 'teslawp_featured_video_id', true);
    $enabled = get_post_meta($post->ID, 'teslawp_featured_video_enabled', true);
    ?>
    <label><input <?php if ($enabled === '1') echo 'checked="checked" '; ?>value="" type="checkbox" name="teslawp_featured_video_input_check_name" id="teslawp_featured_video_input_check_id"> <?php _e('Enable featured video', 'teslawp'); ?></label>
    <br/>
    <?php
    echo '<input ' . ($enabled === '0' || $enabled === '' ? 'style="display:none;" ' : '') . 'type="text" id="teslawp_featured_video_input_id" name="teslawp_featured_video_input_name" value="' . esc_attr($value) . '" size="25" />';
}

function teslawp_featured_video_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_featured_video_nonce']) || !wp_verify_nonce($_POST['teslawp_featured_video_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $video = $_POST['teslawp_featured_video_input_name'];
        $enabled = $_POST['teslawp_featured_video_input_check_name'] === NULL ? '0' : '1';

        add_post_meta($post_id, 'teslawp_featured_video_id', $video, true) or
                update_post_meta($post_id, 'teslawp_featured_video_id', $video);
        add_post_meta($post_id, 'teslawp_featured_video_enabled', $enabled, true) or
                update_post_meta($post_id, 'teslawp_featured_video_enabled', $enabled);
    }
}

function teslawp_disable_title($post) {
    wp_nonce_field(-1, 'teslawp_disable_title_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_title_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_title_input_check">
        <?php _e('Disable Page Title', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_disable_sidebar($post) {
    wp_nonce_field(-1, 'teslawp_disable_sidebar_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_sidebar_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_sidebar_input_check">
        <?php _e('Disable Page Sidebar', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_alternative_sidebar($post) {

    global $wp_registered_sidebars;

    $custom = get_post_custom($post->ID);

    if (isset($custom['custom_sidebar']))
        $val = $custom['custom_sidebar'][0];
    else
        $val = "default";

    wp_nonce_field(-1, 'custom_sidebar_nonce');

    $output = '<p>' . __("Choose a sidebar to be displayed", 'teslawp') . '</p>';
    $output .= "<select name='custom_sidebar'>";

    $output .= "<option";
    if ($val == "default")
        $output .= " selected='selected'";
    $output .= " value='default'>" . __('default', 'teslawp') . "</option>";

    foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
        $output .= "<option";
        if ($sidebar_id == $val)
            $output .= " selected='selected'";
        $output .= " value='" . $sidebar_id . "'>" . $sidebar['name'] . "</option>";
    }

    $output .= "</select>";

    echo $output;
}

function teslawp_disable_padding($post) {
    wp_nonce_field(-1, 'teslawp_disable_padding_nonce');
    $enabled = get_post_meta($post->ID, 'teslawp_disable_padding_check', true);
    ?>
    <label>
        <input <?php checked($enabled); ?> type="checkbox" name="teslawp_disable_padding_input_check">
        <?php _e('Revome the spacing at the bottom of the page', 'teslawp'); ?>
    </label>
    <?php
}

function teslawp_disable_title_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_title_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_title_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_title_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_title_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_title_check', $enabled);
    }
}

function teslawp_disable_sidebar_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_sidebar_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_sidebar_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_sidebar_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_sidebar_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_sidebar_check', $enabled);
    }
}

function teslawp_alternative_sidebar_save($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['custom_sidebar_nonce']) || !wp_verify_nonce($_POST['custom_sidebar_nonce']))
        return;

    if (!current_user_can('edit_page', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {
        $data = $_POST['custom_sidebar'];

        add_post_meta($post_id, "custom_sidebar", $data, true) or
                update_post_meta($post_id, "custom_sidebar", $data);
    }
}

function teslawp_disable_padding_save($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['teslawp_disable_padding_nonce']) || !wp_verify_nonce($_POST['teslawp_disable_padding_nonce']))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (wp_is_post_revision($post_id) === false) {

        $enabled = $_POST['teslawp_disable_padding_input_check'] === NULL ? false : true;

        add_post_meta($post_id, 'teslawp_disable_padding_check', $enabled, true) or
                update_post_meta($post_id, 'teslawp_disable_padding_check', $enabled);
    }
}

function teslawp_meta_boxes() {
    add_meta_box('teslawp_featured_video_id', 'Featured Video', 'teslawp_featured_video', 'post', 'side', 'low');
    add_meta_box('teslawp_featured_video_id', 'Featured Video', 'teslawp_featured_video', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_title_id', 'Disable Title', 'teslawp_disable_title', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_sidebar', 'Disable Sidebar', 'teslawp_disable_sidebar', 'page', 'side', 'low');
    add_meta_box('teslawp_alternative_sidebar', 'Alternative Sidebar', 'teslawp_alternative_sidebar', 'page', 'side', 'low');
    add_meta_box('teslawp_disable_padding', 'Disable Page Bottom Padding', 'teslawp_disable_padding', 'page', 'side', 'low');
}

add_action('add_meta_boxes', 'teslawp_meta_boxes');
add_action('save_post', 'teslawp_featured_video_save');
add_action('save_post', 'teslawp_disable_title_save');
add_action('save_post', 'teslawp_disable_sidebar_save');
add_action('save_post', 'teslawp_alternative_sidebar_save');
add_action('save_post', 'teslawp_disable_padding_save');



/* ============================== MENU ====================================================================================================================== */

class Tesla_Nav_Menu_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"menuLevel\"><ul class=\"sub-menu menuDrop font3\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>' . ($depth ? '<div class="menuDropArrow"></div>' : '');

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}

class Tesla_List_Pages_Walker extends Walker_Page {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"menuLevel\"><ul class='children menuDrop font3'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }

    function start_el(&$output, $page, $depth, $args, $current_page = 0) {
        if ($depth)
            $indent = str_repeat("\t", $depth);
        else
            $indent = '';

        extract($args, EXTR_SKIP);
        $css_class = array('page_item', 'page-item-' . $page->ID);
        if (!empty($current_page)) {
            $_current_page = get_post($current_page);
            if (in_array($page->ID, $_current_page->ancestors))
                $css_class[] = 'current_page_ancestor';
            if ($page->ID == $current_page)
                $css_class[] = 'current_page_item';
            elseif ($_current_page && $page->ID == $_current_page->post_parent)
                $css_class[] = 'current_page_parent';
        } elseif ($page->ID == get_option('page_for_posts')) {
            $css_class[] = 'current_page_parent';
        }

        $css_class = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

        $output .= $indent . '<li class="' . $css_class . '">' . ($depth ? '<div class="menuDropArrow"></div>' : '') . '<a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters('the_title', $page->post_title, $page->ID) . $link_after . '</a>';

        if (!empty($show_date)) {
            if ('modified' == $show_date)
                $time = $page->post_modified;
            else
                $time = $page->post_date;

            $output .= " " . mysql2date($date_format, $time);
        }
    }

}

class Tesla_Nav_Menu_Select_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    function start_el(&$output, $item, $depth = 0, $args, $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $output .= "\t<option class=\"level-$depth\" value=\"" . $item->url . "\"";
        if (isset($args->selected) && $item->url == $args->selected)
            $output .= ' selected="selected"';
        $output .= '>';
        $title = $item->title;
        $output .= $pad . esc_html($title);
    }

    function end_el(&$output, $item, $depth = 0, $args) {
        $output .= "</option>\n";
    }

}

class Tesla_List_Pages_Select_Walker extends Walker_Page {

    function start_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        
    }

    function start_el(&$output, $page, $depth = 0, $args, $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $url = get_permalink($page->ID);

        $output .= "\t<option class=\"level-$depth\" value=\"" . $url . "\"";
        if (isset($args->selected) && $url == $args->selected)
            $output .= ' selected="selected"';
        $output .= '>';
        $title = $page->post_title;
        $output .= $pad . esc_html($title);
    }

    function end_el(&$output, $page, $depth = 0, $args) {
        $output .= "</option>\n";
    }

}

/* ============================== SHORTCODES ====================================================================================================================== */

function teslawp_column_first_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'size' => 4,
        'style' => '',
                    ), $atts));
    $size = (int) $size;
    return '<div class="row-fluid"><div class="span' . $size . '" style="' . $style . '">' . do_shortcode($content) . '</div>';
}

function teslawp_column_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'size' => 4,
        'style' => '',
                    ), $atts));
    $size = (int) $size;
    return '<div class="span' . $size . '" style="' . $style . '">' . do_shortcode($content) . '</div>';
}

function teslawp_column_last_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'size' => 4,
        'style' => '',
                    ), $atts));
    $size = (int) $size;
    return '<div class="span' . $size . '" style="' . $style . '">' . do_shortcode($content) . '</div></div>';
}

add_shortcode('teslawp_column_first', 'teslawp_column_first_shortcode');
add_shortcode('teslawp_column', 'teslawp_column_shortcode');
add_shortcode('teslawp_column_last', 'teslawp_column_last_shortcode');
add_shortcode('tesla_column_first', 'teslawp_column_first_shortcode');
add_shortcode('tesla_column', 'teslawp_column_shortcode');
add_shortcode('tesla_column_last', 'teslawp_column_last_shortcode');

function teslawp_map_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'height' => '384px',
        'width' => '100%',
        'address' => 'London, UK',
        'style' => ''
                    ), $atts));
    return '<iframe style="height:' . $height . ';width:' . $width . ';' . $style . '" src="http://maps.google.com/maps?q=' . urlencode($address) . '&amp;output=embed&amp;iwloc" class="teslawp_map"></iframe>';
}

add_shortcode('teslawp_map', 'teslawp_map_shortcode');

// Start - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.
//function tesla_map_shortcode($atts, $content = null) {
//    extract(shortcode_atts(array(
//        'height' => '384px',
//        'width' => '100%',
//        'address' => 'London, UK',
//        'style' => ''
//                    ), $atts));
//    return '<div class="teslawp_map" style="height:' . $height . ';width:' . $width . ';' . $style . '" id="map-canvas"></div>';
//}
//add_shortcode('tesla_map', 'tesla_map_shortcode');
// End - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.
// Start - Changed by Nikhil Kavungal on 7th Sept 2014 for re-designing of Contact Us page.
function teslawp_contact_shortcode($atts, $content = null) {
    $mandatory_text = '<b><font color="red">*</font></b>&nbsp;';
    $td_border_zero_style_text = 'valign="top" style="border-top:0px;"';
    $mandatory_sign = ' * ';
    $td_label_style_text = 'valign="top" style="border-top:0px;width:25%"';
    $row_break_text = '<tr>
                    <td colspan="3" ' . $td_border_zero_style_text . '>&nbsp;</td>
                </tr>';

    extract(shortcode_atts(array(
        'title' => '',
        'style' => ''
                    ), $atts));
    if (empty($title))
        $title = _go('form_title');
    if (empty($title))
        $title = 'Don\'t Be Shy, Come Along & Say Hi';
    $output = '<form class="contactForm" action="" style="' . $style . '">
            <div class="contactFormTitle font1">
                ' . $title . '
                <input name="action" type="hidden" value="teslawp_contact" />
            </div>
            <div class="">
            <div id="contactResult" class="contactResult">
                &nbsp; &nbsp;            
            </div>
            <table>
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'Name</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '><input type="text" id="contact_page_name" name="input-name" value="" placeholder="' . __('Name', 'teslawp') . $mandatory_sign . '"></td>
                </tr>
                ' . $row_break_text . '
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'Email ID</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '><input type="text" id="contact_page_email" size="50" maxlength="30" name="input-email" value="" placeholder="' . __('Email ID', 'teslawp') . $mandatory_sign . '"></td>
                </tr>
                ' . $row_break_text . '
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'Subject</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '><input type="text" id="contact_page_subject" size="50" maxlength="30"  name="input-subject" value="" placeholder="' . __('Subject', 'teslawp') . $mandatory_sign . '"></td>
                </tr>
                ' . $row_break_text . '
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'Phone No</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '><input type="text" id="contact_page_phone_no" maxlength=10 name="input-phone" value="" placeholder="' . __('Phone No', 'teslawp') . $mandatory_sign . '"></td>
                </tr>
                ' . $row_break_text . '
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'Message</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '> 
                        <fieldset class="contactFormMessage">
                            <textarea rows="" cols="" id="contact_page_message" name="input-message" placeholder="' . __('Type your message here', 'teslawp') . $mandatory_sign . '"></textarea>
                        </fieldset>
                    </td>
                </tr>
                ' . $row_break_text . '
                <tr>
                    <td ' . $td_label_style_text . '>' . $mandatory_text . 'How Did You Hear About Fotoskarma</td>       
                    <td ' . $td_border_zero_style_text . '>:</td>
                    <td ' . $td_border_zero_style_text . '> 
                        <input type="radio" name="site_reference" value="client">&nbsp;&nbsp;A Client<br>
                        <input type="radio" name="site_reference" value="friend">&nbsp;&nbsp;A Friend<br>
                        <input type="radio" name="site_reference" value="social_media">&nbsp;&nbsp;Social Media<br>
                        <input type="radio" name="site_reference" value="search_engine">&nbsp;&nbsp;Search Engine<br>
                        <input type="radio" name="site_reference" value="other" >&nbsp;&nbsp;Other &nbsp; &nbsp;
                        <input type="text" id="site_reference_others" style="display:none;" name="site_reference_others" placeholder="' . __('Please specify', 'teslawp') . $mandatory_sign . '"><br>
                    </td>
                </tr>
                ' . $row_break_text . '
                 <tr>
                    <td colspan="3" align="center" ' . $td_border_zero_style_text . '>
                        <fieldset class="contactFormButtons">
                            <input type="submit" style="height:42px" id="contact_page_send_mail" value="' . __('Send', 'teslawp') . '">
                        </fieldset>
                    </td>
                </tr>
            </table>
        </form>';
    return $output;
}

add_shortcode('teslawp_contact', 'teslawp_contact_shortcode');
add_shortcode('tesla_contact', 'teslawp_contact_shortcode');

function teslawp_contact_ajax() {
    $receiver_mail = _go('email_contact');
    if (!empty($receiver_mail)) {
        $mail_title_prefix = _go('email_prefix');
        if (empty($mail_title_prefix))
            $mail_title_prefix = '[' . get_bloginfo('name') . ']';
        if (!empty($_POST['input-name']) && !empty($_POST['input-email']) && !empty($_POST['input-subject']) && !empty($_POST['input-phone']) && !empty($_POST['input-message']) && !empty($_POST['site_reference'])) {
            $sender_name = $_POST['input-name'];
            $sender_email = $_POST['input-email'];
            $sender_subject = $_POST['input-subject'];
            $sender_phone = $_POST['input-phone'];
            $sender_message_text = $_POST['input-message'];
            $site_reference = $_POST['site_reference'];
            $others_site_reference = $_POST['site_reference_others'];

            $referred_by_value = $site_reference . ' - ' . $others_site_reference;
            global $current_user;
            get_currentuserinfo();
            $sender_message = ' Hi ' . $current_user->data->display_name . ', <br><br><br>'
                    . 'You have a message. <br>
                        <table>
                            <tr>
                                <td style="width:50%" valign="top"><b>Message From</b></td>
                                <td valign="top">:</td>
                                <td valign="top">' . $sender_name . '</td>
                            </tr>
                            <tr>
                                <td style="width:50%" valign="top"><b>Sender Email ID</b></td>
                                <td valign="top">:</td>
                                <td valign="top">' . $sender_email . '</td>
                            </tr>
                            <tr>
                                <td style="width:50%" valign="top"><b>Sender Phone No</b></td>
                                <td valign="top">:</td>
                                <td valign="top">' . $sender_phone . '</td>
                            </tr>
                            <tr>
                                <td style="width:50%;" valign="top" height="100%"><b>Message</b></td>
                                <td  valign="top">:</td>
                                <td valign="top">' . $sender_message_text . '</td>
                            </tr>
                            <tr>
                                <td style="width:50%;" valign="top" height="100%"><b>Referred By</b></td>
                                <td  valign="top">:</td>
                                <td valign="top">' . $referred_by_value . '</td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        -Regards,
                        <br>
                        <i>Fotoskarma</i> <br>';

            if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
                if (strlen(trim($sender_phone)) < 10) {
                    $result = __("0_Phone No should be atleast 10 digits.", 'teslawp');
                } else {
                    if ($site_reference == 'other' && empty($others_site_reference)) {
                        $result = __("0_Please fill in all the required fields.", 'teslawp');
                    } else {
                        $subject = $mail_title_prefix . ' message from ' . $sender_name . ' - ' . $sender_subject;
                        $headers = '';
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                        $headers .= 'From:' . $sender_email . "\r\n" . 'CC: sachinity@gmail.com';
                        if (mail($receiver_mail, $subject, $sender_message, $headers))
                            $result = __("1_Your message was successfully sent.", 'teslawp');
                        else
                            $result = __("0_Operation could not be completed.", 'teslawp');
                    }
                }
            } else {
                $result = __("0_Please enter a valid email id.", 'teslawp');
            }
        } else {
            $result = __("0_Please fill in all the required fields.", 'teslawp');
        }
    } else {
        $result = __('0_Error! There is no e-mail configured to receive the messages.', 'teslawp');
    }
    echo $result;
    die;
}

//function teslawp_contact_shortcode($atts, $content = null) {
//    extract(shortcode_atts(array(
//        'title' => '',
//        'style' => ''
//                    ), $atts));
//    if (empty($title))
//        $title = _go('form_title');
//    if (empty($title))
//        $title = 'Don\'t Be Shy, Come Along & Say Hi';
//    $output = '<form class="contactForm" action="" style="' . $style . '">
//            <div class="contactFormTitle font1">
//                ' . $title . '
//                <input name="action" type="hidden" value="teslawp_contact" />
//            </div>
//            <fieldset class="contactFormDetails">
//                <input type="text" name="input-name" value="" placeholder="' . __('Name', 'teslawp') . '">
//                <input type="text" name="input-subject" value="" placeholder="' . __('Subject', 'teslawp') . '">
//            </fieldset>
//            <fieldset class="contactFormMessage">
//                <textarea rows="" cols="" name="input-message" placeholder="' . __('Type your message here', 'teslawp') . '"></textarea>
//            </fieldset>
//            <fieldset class="contactFormButtons">
//                <input type="submit" value="' . __('Send', 'teslawp') . '">
//            </fieldset>
//        </form>
//        <div class="contactResult"></div>';
//    return $output;
//}
//
//add_shortcode('teslawp_contact', 'teslawp_contact_shortcode');
//add_shortcode('tesla_contact', 'teslawp_contact_shortcode');
//
//function teslawp_contact_ajax() {
//    $receiver_mail = _go('email_contact');
//    if (!empty($receiver_mail)) {
//        $mail_title_prefix = _go('email_prefix');
//        if (empty($mail_title_prefix))
//            $mail_title_prefix = '[' . get_bloginfo('name') . ']';
//        if (!empty($_POST['input-name']) && !empty($_POST['input-subject']) && !empty($_POST['input-message'])) {
//            $subject = $mail_title_prefix . ' message from ' . $_POST['input-name'];
//            $headers = '';
//            $headers .= 'MIME-Version: 1.0' . "\r\n";
//            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//            $headers .= 'From: noreply' . "\r\n";
//            if (mail($receiver_mail, $subject, $_POST['input-message'], $headers))
//                $result = __("Your message was successfully sent.", 'teslawp');
//            else
//                $result = __("Operation could not be completed.", 'teslawp');
//        }else {
//            $result = __("Please fill in all the required fields.", 'teslawp');
//        }
//    } else {
//        $result = __('Error! There is no e-mail configured to receive the messages.', 'teslawp');
//    }
//    echo $result;
//    die;
//}
// End - Changed by Nikhil Kavungal on 7th Sept 2014 for re-designing of Contact Us page.

add_action("wp_ajax_teslawp_contact", "teslawp_contact_ajax");
add_action("wp_ajax_nopriv_teslawp_contact", "teslawp_contact_ajax");

function teslawp_post_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'speed' => 4,
        'pause' => 8
                    ), $atts));
    $speed = (int) $speed;
    $pause = (int) $pause;
    $before = '
    <div class="pageSlider" style="' . $style . '" data-speed="' . ($speed * 1000) . '" data-pause="' . ($pause * 1000) . '">
        <div class="pageSliderItems">
            <ul>
    ';
    $after = '
            </ul>
        </div>
    </div>
    ';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_secondary_slider', 'teslawp_post_slider_shortcode');

function teslawp_post_slider_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'image' => '',
        'style' => ''
                    ), $atts));
    $output = '<li><img src="' . $image . '" alt="" /></li>';
    return $output;
}

add_shortcode('teslawp_secondary_slider_item', 'teslawp_post_slider_item_shortcode');

function teslawp_clients_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => 'our clients',
        'style' => ''
                    ), $atts));
    $before = '
    <div class="clients" style="' . $style . '">
        <div class="titleContainer font1">
            <div class="title">
                ' . $title . '
            </div>
            <div class="clientsNav">
                <div class="clientsNavPrev"></div>
                <div class="clientsNavNext"></div>
            </div>
        </div>
        <ul>
    ';
    $after = '
        </ul>
    </div>
    ';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_clients_slider', 'teslawp_clients_slider_shortcode');

function teslawp_clients_slider_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'image' => ''
                    ), $atts));
    $output = '<li><img src="' . $image . '" alt="" /></li>';
    return $output;
}

add_shortcode('teslawp_clients_slider_item', 'teslawp_clients_slider_item_shortcode');

function teslawp_testimonial_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'image' => '',
        'author' => '',
        'wide' => 'false',
        'style' => ''
                    ), $atts));
    $output = '
    <div class="testimonialbg' . ($wide === 'true' ? ' testimonialbgwide' : '') . '" style="' . $style . '">
        <div class="testimonial">
            <div class="testimonialImg bordercolor">
                <img src="' . $image . '" alt="" />
            </div>
            <div class="testimonialContent font4">
                <div class="testimonialContentText textcolor4">
                    ' . do_shortcode($content) . '
                </div>
                <div class="testimonialContentAuthor textcolor5">
                    &HorizontalLine; ' . $author . '
                </div>
            </div>
        </div>
    </div>
    ';
    return $output;
}

add_shortcode('teslawp_testimonial', 'teslawp_testimonial_shortcode');

global $teslawp_main_slider_toggle_caption;

function teslawp_main_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'speed' => 4,
        'pause' => 8,
        'toggle_caption' => true
                    ), $atts));
    $speed = (int) $speed;
    $pause = (int) $pause;
    $toggle_caption = (bool) $toggle_caption;
    global $teslawp_main_slider_toggle_caption;
    $teslawp_main_slider_toggle_caption = $toggle_caption;
    $before = '<div class="mainSlider" style="' . $style . '" data-speed="' . ($speed * 1000) . '" data-pause="' . ($pause * 1000) . '">
        <div class="mainSliderItemsWrapper">
            <div class="mainSliderItems">';
    $after = '</div>
        </div>
        <div class="mainSliderNav">
            <div class="mainSliderNavBar bgcolor"></div>
        </div>
    </div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_main_slider', 'teslawp_main_slider_shortcode');

function teslawp_main_slider_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'image' => '',
        'style' => ''
                    ), $atts));
    global $teslawp_main_slider_toggle_caption;
    $before = '
        <div class="mainSliderItemsEntry">
            <img src="' . $image . '" class="mainSliderItemsEntryImg" alt="" />
            <div class="mainSliderItemsEntryBox bgcolor2' . ($teslawp_main_slider_toggle_caption ? ' mainSliderItemsEntryBoxToggle' : '') . '">
                <div class="mainSliderItemsEntryBoxBorder"></div>
                <div class="mainSliderItemsEntryBoxTitle textcolor2 font3">
                    ' . $title . '
                </div>
                <div class="mainSliderItemsEntryBoxContent textcolor3">
                    ';
    $after = '
                </div>
                <div class="mainSliderItemsEntryBoxButtons">
                    <div class="mainSliderItemsEntryBoxButtonsPrev bgcolor3 bgcolor_hover"></div>
                    <div class="mainSliderItemsEntryBoxButtonsNext bgcolor3 bgcolor_hover"></div>
                </div>
            </div>
        </div>
        ';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_main_slider_item', 'teslawp_main_slider_item_shortcode');

function teslawp_portofolio_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                    ), $atts));
    $before = '<div class="works">';
    $after = '</div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio', 'teslawp_portofolio_shortcode');
add_shortcode('teslawp_portfolio', 'teslawp_portofolio_shortcode');

function teslawp_portofolio_categories_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                    ), $atts));
    $before = '<div class="worksFilter">
                        <div class="worksFilterText textcolor6">
                            ' . __('Featured Work:', 'teslawp') . '
                        </div>
                        <ul class="worksFilterCategories">
                            <li class="textcolor6 worksFilterCategoriesActive bordercolor3" data-category="all">
                                <div class="bordercolor3">
                                    ' . __('all', 'teslawp') . '
                                </div>
                            </li>';
    $after = '</ul>
                    </div>
                    <div class="worksViews">
                        <div class="worksViewsOption bordercolor3 worksViewsOptionActive" data-class="worksContainerView1" style="display:none">
                            <img src="' . get_template_directory_uri() . '/images/options/sort_opt1.png" alt="" />
                        </div>
                        <div id="nk_view_second_option" class="worksViewsOption bordercolor3" data-class="worksContainerView2" style="display:none">
                            <img src="' . get_template_directory_uri() . '/images/options/sort_opt2.png" alt="" />
                        </div>
                    </div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_categories', 'teslawp_portofolio_categories_shortcode');
add_shortcode('teslawp_portfolio_categories', 'teslawp_portofolio_categories_shortcode');

function teslawp_portofolio_category_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'slug' => ''
                    ), $atts));
    $before = '<li class="textcolor6 bordercolor3" data-category="' . ($slug === '' ? $content : $slug) . '">
                                <div class="bordercolor3">';
    $after = '</div>
                            </li>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_category', 'teslawp_portofolio_category_shortcode');
add_shortcode('teslawp_portfolio_category', 'teslawp_portofolio_category_shortcode');

function teslawp_portofolio_items_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                    ), $atts));
    $before = '<div class="worksContainer worksContainerView1">';
    $after = '</div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_items', 'teslawp_portofolio_items_shortcode');
add_shortcode('teslawp_portfolio_items', 'teslawp_portofolio_items_shortcode');

function teslawp_portofolio_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'categories' => '',
        'image_small' => '',
        'image_big' => '',
        'url' => '',
        'title' => '',
        'no_more' => false
                    ), $atts));
    $no_more = (bool) $no_more;
    $before = '<div class="worksEntry" data-categories="' . $categories . '">
        <div class="worksEntryContainer">
            <div class="worksEntryInfo">
                <div class="worksEntryInfoTitle">
                    <a href="' . $url . '">
                        ' . $title . '
                    </a>
                </div>';
    $after = (!$no_more ? '<div class="worksEntryInfoMore"><a href="' . $url . '">' . __('read more', 'teslawp') . '</a></div>' : '') .
            '</div>
            <a href="' . $url . '"><img class="worksEntryImg" src="' . $image_small . '" alt="" /></a>
            <img class="worksEntryImgBig" src="' . $image_big . '" alt="" />
        </div>
    </div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_item', 'teslawp_portofolio_item_shortcode');
add_shortcode('teslawp_portfolio_item', 'teslawp_portofolio_item_shortcode');

function teslawp_portofolio_item_description_small_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'category' => '',
                    ), $atts));
    $before = '<div  class="worksEntryInfoExcerpt">';
    $after = '</div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_item_description_small', 'teslawp_portofolio_item_description_small_shortcode');
add_shortcode('teslawp_portfolio_item_description_small', 'teslawp_portofolio_item_description_small_shortcode');

function teslawp_portofolio_item_description_big_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'category' => '',
                    ), $atts));
    $before = '<div  class="worksEntryInfoExcerptBig">';
    $after = '</div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_portofolio_item_description_big', 'teslawp_portofolio_item_description_big_shortcode');
add_shortcode('teslawp_portfolio_item_description_big', 'teslawp_portofolio_item_description_big_shortcode');

function teslawp_project_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
                    ), $atts));
    $before = '<div class="project">';
    $after = '</div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_project', 'teslawp_project_shortcode');

function teslawp_project_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'speed' => 4,
        'pause' => 8
                    ), $atts));
    $speed = (int) $speed;
    $pause = (int) $pause;
    $before = '
    <div class="pageSlider" style="' . $style . '" data-speed="' . ($speed * 1000) . '" data-pause="' . ($pause * 1000) . '">
        <div class="pageSliderItems">
            <ul>
    ';
    $after = '
            </ul>
        </div>
    </div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_project_slider', 'teslawp_project_slider_shortcode');

function teslawp_project_slider_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'image' => ''
                    ), $atts));
    $output = '<li><img src="' . $image . '" alt="" /></li>';
    return $output;
}

add_shortcode('teslawp_project_slider_item', 'teslawp_project_slider_item_shortcode');

function teslawp_project_info_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'title' => '',
        'description' => '',
        'categories' => '',
        'skills' => '',
        'url' => '',
                    ), $atts));
    $output = '
    <div class="projectInfo">
        <div class="projectInfoTitle font1">
            ' . $title . '
        </div>
        <div class="projectInfoDescription">
            ' . $description . '
        </div>
        <div class="projectInfoDetails">
            <div class="projectInfoDetailsTitle font1">
                ' . __('Project Details', 'teslawp') . '
            </div>
            <div class="projectInfoDetailsEntry">
                <div class="projectInfoDetailsEntryTitle">
                    ' . __('Categories', 'teslawp') . '
                </div>
                <div class="projectInfoDetailsEntryBody">
                    ' . $categories . '
                </div>
            </div>
            <div class="projectInfoDetailsEntry">
                <div class="projectInfoDetailsEntryTitle">
                    ' . __('Skills', 'teslawp') . '
                </div>
                <div class="projectInfoDetailsEntryBody">
                    ' . $skills . '
                </div>
            </div>
            <div class="projectInfoDetailsEntry">
                <div class="projectInfoDetailsEntryTitle">
                    ' . __('Project url', 'teslawp') . '
                </div>
                <div class="projectInfoDetailsEntryBody">
                    <a href="' . $url . '">' . __('Project link', 'teslawp') . '</a>
                </div>
            </div>
        </div>
    </div>
    ';
    return $output;
}

add_shortcode('teslawp_project_info', 'teslawp_project_info_shortcode');

function teslawp_project_related_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
                    ), $atts));
    $before = '
    <div class="projectRelated">
        <div class="titleContainer font1">
            <div class="title">
                ' . __('related works', 'teslawp') . '
            </div>
            <div class="clientsNav">
                <div class="clientsNavPrev"></div>
                <div class="clientsNavNext"></div>
            </div>
        </div>
        <ul>
    ';
    $after = '</ul>
    </div>';
    return $before . do_shortcode(str_replace('<br />', '', shortcode_unautop($content))) . $after;
}

add_shortcode('teslawp_project_related', 'teslawp_project_related_shortcode');

function teslawp_project_related_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'title' => '',
        'description' => '',
        'image' => '',
        'url' => '',
                    ), $atts));
    $output = '
    <li>
        <a href="' . $url . '">
            <img src="' . $image . '" alt="" />
        </a>
        <div class="title">
            <a href="' . $url . '">
                ' . $title . '
            </a>
        </div>
        <div class="description">
            ' . $description . '
        </div>
    </li>
    ';
    return $output;
}

add_shortcode('teslawp_project_related_item', 'teslawp_project_related_item_shortcode');



/* ============================== FORMATTING ====================================================================================================================== */

remove_filter('the_content', 'wpautop');


/* ============================== TO GET THE CAPTION OF IMAGES ===================================================================================================== */
/*
 * Added by Nikhil Kavungal
 */

function wp_get_attachment($attachment_id) {
    $attachment = get_post($attachment_id);
    return array(
        'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink($attachment->ID),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

function get_attachment_id($guid) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'posts';
    $posts = $wpdb->get_results("SELECT ID FROM $table_name where guid='$guid' ");
    $image_caption = '';
    // Echo the title of the first scheduled post
    if (isset($posts[0]->ID)) {
        $attachment_array = wp_get_attachment($posts[0]->ID);
        $image_caption = $attachment_array['caption'];
    }
    return $image_caption;
}

// Start - Added by Nikhil Kavungal on 9th September 2014 for validation of comment form
function comment_validation_init() {
    if (is_single() && comments_open()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // clearing the fields on load
                $('#author').val('');
                $('#email').val('');
                $('#comment').val('');
                function validateEmail(sEmail) {
                    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                    if (filter.test(sEmail)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }

                $('#comment_submit').click(function() {
                    $('#errorNotificationArea').removeAttr('class');
                    $('#errorNotificationArea').html('');
                    var email_id = 'logged_in_as_user';
                    if ($('#email').val() != undefined) {
                        email_id = $('#email').val().trim();
                    }

                    var author = 'logged_in_as_user';
                    if ($('#author').val() != undefined) {
                        author = $('#author').val().trim();
                    }
                    var message = $('#comment').val().trim();
                    if (email_id.length > 0 && author.length > 0 && message.length > 0) {
                        // email validation
                        if ($.trim(email_id).length == 0) {
                            $('#errorNotificationArea').html('Please enter valid email address');
                            $('#errorNotificationArea').attr('class', 'error');
                            return false;
                        }
                        if (email_id == 'logged_in_as_user') {
                            return true;
                        }
                        else {
                            if (validateEmail(email_id)) {
                                return true;
                            } else {
                                $('#errorNotificationArea').html('Invalid Email Address');
                                $('#errorNotificationArea').attr('class', 'error');
                                return false;
                            }
                        }
                    } else {
                        $('#errorNotificationArea').html('Please enter values for all the mandatory fields.');
                        $('#errorNotificationArea').attr('class', 'error');
                        return false;
                    }
                });
            });
        </script>
        <?php
    }
}

add_action('wp_footer', 'comment_validation_init');
// End - Added by Nikhil Kavungal on 9th September 2014 for validation of comment form