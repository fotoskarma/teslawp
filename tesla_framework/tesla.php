<?php
//define TeslaThemesFramework directory name
define('TTF', dirname(__FILE__));
//Load framework constants
require_once TTF . '/config/constants.php';

//Load theme details
require_once TT_THEME_DIR . '/theme_config/theme-details.php';

//Load main framework class
require_once TTF . '/core/teslaframework.php';
require_once TTF . '/core/tesla_admin.php';
require_once TTF . '/core/tt_load.php';
//Admin load
$TTA = new Tesla_admin;
//Slider
require_once TTF . '/core/tesla_slider.php';
Tesla_slider::init();