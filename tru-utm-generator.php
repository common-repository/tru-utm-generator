<?php
/**
  Plugin Name: Tru UTM Generator
  Plugin URI: https://wordpress.org/plugins/tru-utm-generator/
  Description: Generate UTM links
  Author: mndpsingh287
  Version: 1.0
  Author https://profiles.wordpress.org/mndpsingh287/
  License: GPLv2
 **/
if (!defined('TRU_UTM_PLUGIN_PATH')) {
    define('TRU_UTM_PLUGIN_PATH', plugin_dir_path(__FILE__));
}
if (!defined('TRU_UTM_PLUGIN_URL')) {
    define('TRU_UTM_PLUGIN_URL', plugins_url('', __FILE__));
}
if (!defined('TRU_UTM_FILE_PATH')):
    define('TRU_UTM_FILE_PATH', dirname(__FILE__));
  endif;

if (!defined('TRU_UTM_FILE')):
    define('TRU_UTM_FILE', __FILE__);
endif;  

if(!class_exists('tru_utm_generator')) {
    include('classes/tru_utm_generator.php');
}