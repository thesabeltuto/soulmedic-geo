<?php
// Global define variables
$THEME_CHILD = '-geo';
define('THEME_CHILD_FILE', __FILE__ );
define('THEME_CHILD_DIR', get_template_directory().$THEME_CHILD);
define('THEME_CHILD_URL', get_template_directory_uri().$THEME_CHILD);

// Global variables
$THEME_VERSION = '1.1.2';
$THEME_CSS_VERSION = '1.0.9';

require_once(THEME_CHILD_DIR.'/framework/admin.php');
require_once(THEME_CHILD_DIR.'/framework/integrations.php');
require_once(THEME_CHILD_DIR.'/framework/shortcodes.php');

//error_reporting(E_ALL); ini_set('display_errors', 1);

add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

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