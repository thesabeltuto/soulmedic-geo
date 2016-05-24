<?php
// Global define variables
define('THEME_FILE', __FILE__ );
define('THEME_DIR', get_template_directory().'-geo');
define('THEME_URL', get_template_directory_uri().'-geo');

// Global variables
$THEME_VERSION = '1.1.1';
$THEME_CSS_VERSION = '1.0.9';

require_once(THEME_DIR.'/framework/admin.php');
require_once(THEME_DIR.'/framework/integrations.php');
require_once(THEME_DIR.'/framework/shortcodes.php');

//error_reporting(E_ALL); ini_set('display_errors', 1);
add_filter('gform_field_value_day', 'gw_day');
function gw_day($value) {
    $timestamp = strtotime(date('Y-m-d'));
    $day = date('d', $timestamp);
    return $day;
}
add_filter('gform_field_value_month', 'gw_month');
function gw_month($value) {
    $timestamp = strtotime(date('Y-m-d'));
    $month = date('F', $timestamp);
    return $month;
}
?>