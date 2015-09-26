<?php
define('THEME_OPTIONS', THEME_NAME . '_options');

class Tesla_admin extends TeslaFramework {

    private $admin_options;

    public function __construct() {
        parent::__construct();
        //loading helpers
        $this->load->helper('admin');
        //Generating admin panel
        $this->admin_options = include TT_THEME_DIR . '/theme_config/admin-options.php';
        $this->register_admin_settings();
        $this->add_admin_menu_page();
        $this->enqueue_admin_js_css();
    }

    private function register_admin_settings() {
        add_action('admin_init', array($this, 'theme_options_init'));
        add_action('init', array($this, 'theme_options_defaults'));
    }

    function theme_options_init() {
        //-------theme settings--------------------------------
        register_setting(THEME_OPTIONS, THEME_OPTIONS);
        add_action('wp_ajax_save_options', array($this, 'save_options_ajax'));
    }

    function save_options_ajax() {
        //check_ajax_referer('test-theme-data', 'security');

        $options = $_POST[THEME_OPTIONS];

        if (!empty($options)) {
            _clean_options($options);
            $options = serialize($options);
            $result = update_option(THEME_OPTIONS, $options);
            if ($result) {
                die('options updated');
            } else {
                die('options did not change');
            }
        } else {
            die('No data sent');
        }
    }

    function theme_options_defaults() {

        $my_var_that_holds_options = get_option(THEME_OPTIONS); //getting theme options from DB , if no options FALSE returned
        //     var_dump(seek_multidim_array_all_alt($this->admin_options,'id'));
        if (!$my_var_that_holds_options) {   //checking if no theme options where setup (first time use of theme)
            $result = seek_options($this->admin_options, 'id'); //getting all fields with key = 'id' from theme options array
            $ids = explode(' ', trim($result));
            foreach ($ids as $id) {  //building defaults as ''
                $defaults[$id] = '';
            }
            $defaults = serialize($defaults);
            update_option(THEME_OPTIONS, $defaults);  //Inserting defaults to DB
        }
    }

    private function add_admin_menu_page() {
        //-------Menu add admin page-------------------------
        add_action("admin_menu", array($this, "setup_theme_admin_menus"));
    }

    function setup_theme_admin_menus() {
        add_theme_page('Theme settings', THEME_PRETTY_NAME, 'manage_options', THEME_NAME . '_options', array($this, 'theme_options_do_page'), $this->get_admin_favico_dir());
    }

    public function get_admin_favico_dir() {
        $favico_dir = (!empty($this->admin_options['favico']['dir']) ) ? TT_THEME_URI . $this->admin_options['favico']['dir'] : '';
        return $favico_dir;
    }

    function theme_options_do_page() {
        $this->load->view('admin', $this->admin_options);  //Loading Theme Options Admin Panel View
    }

    private function enqueue_admin_js_css() {
        add_action("admin_init", array($this, "if_admin_panel_enqueue"));
    }

    //-------adding css nad javascript to admin head--------
    function if_admin_panel_enqueue() {
        if (isset($_GET['page']) && $_GET['page'] == THEME_NAME . '_options') {
            add_action('admin_enqueue_scripts', array($this, 'admin_panel_page_head'));
        }
    }

    function admin_panel_page_head() {
        //enqueue scripts-----------
        echo '<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css">'; //default google font import
        echo "<script type='text/javascript'>var TT_FW = '" . TT_FW . "',THEME_NAME='" . THEME_NAME . "',updated=false</script>"; // Tesla Framework directory ,theme name, and updated options variable passed to js side
        // Start - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.
        // echo '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>'; //google maps api in admin head
        // End - Commented by Nikhil Kavungal on 7th Sept 2014 for removing maps from Contact Us page.
        if (!empty($this->admin_options['scripts'])) {
            foreach ($this->admin_options['scripts'] as $script) {
                if (is_array($script)) {
                    foreach ($script as $included_script)
                        wp_enqueue_script($included_script);
                } else
                    wp_enqueue_script('admin-' . $script, TT_FW . '/static/js/' . $script . '.js', array('jquery'));
            }
        } else
            wp_enqueue_script('admin-bootstrap', $script, TT_FW . '/static/js/bootstrap.js', array('jquery'));
        //enqueue styles------------
        if (!empty($this->admin_options['styles'])) {
            foreach ($this->admin_options['styles'] as $style) {
                if (is_array($style)) {
                    foreach ($style as $included_style)
                        wp_enqueue_style($included_style);
                } else
                    wp_enqueue_style('admin-css-' . $style, TT_FW . '/static/css/' . $style . '.css');
            }
        } else
            wp_enqueue_style('admin-bootstrap', TT_FW . '/static/css/bootstrap.css');
        if (function_exists('wp_enqueue_media'))
            wp_enqueue_media();
        wp_enqueue_style('jquery-ui-css', 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css');
    }

    /**
     * ======================================Auto import XML DEMO CONTENT================================================================
     */
    function import_xml_on_activation() {
        add_action('admin_menu', array($this, 'import_add_menu_page'));
        add_action('wp_ajax_import_xml', array($this, 'import_xml_ajax'));
    }

    function admin_import_head() {
        //wp_enqueue_script('jquery');
        wp_enqueue_style('admin-bootstrap', TT_FW . '/static/css/style.css');
        ?>
        <script type='text/javascript'>var TT_FW = '<?php echo TT_FW ?>', THEME_NAME = '<?php echo THEME_NAME ?>'</script>
        <?php
    }

    function autoimport_page() {
        ?>
        <div id='result_content'>
            <div id="tt_import_alert">
                <span>Warning !</span>
                Importing Demo Content will add posts and media files to your wordpress. It is not recommended to do it if you already have your own content.
                It would be better if you back up your data before importing the demo content.
            </div>
            <button class='btn' id='import_xml_button'>Import Demo Content</button>
            <div id='result'></div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#import_xml_button').on('click', function() {
                    $(this).addClass('.button_loading');
                    $('#import_xml_button,#tt_import_alert').fadeOut('slow')
                    $(this).text('Importing...');
                    $("#result").html('<div class="tt_wait_import" style="text-align:center">Importing Demo Content. Please sit back and relax while magic happens.<br>\
                                <img src="' + TT_FW + '/static/images/loading_import.gif" alt="wait">\
                              </div>')
                    $.post(ajaxurl, {action: 'import_xml'}, function(response) {
                        $('#result').html(response.replace(/[_0-9]+$/, ''));
                        console.log(response);
                    });
                })
            })
        </script>
        <?php
        return;
    }

    function import_xml_ajax() {
        require_once TT_FW_DIR . '/extensions/autoimport/autoimporter.php';

        if (!class_exists('Auto_Importer'))
            die('Auto_Importer not found');

        // call the function
        $args = array(
            'file' => TT_THEME_DIR . '/theme_config/import.xml',
            'map_user_id' => 1
        );

        auto_import($args);
    }

//=============================================END AUTOIMPORT DEMO CONTENT XML====================================================
}
