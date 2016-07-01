<?php
add_action('admin_menu', 'create_admin_menu_geo');
add_action('init', 'soulmedic_geo_css');

function create_admin_menu_geo() {
	add_menu_page ('Theme Support', 'Theme Support','manage_theme','soulmedic_geo_support','soulmedic_geo_support', '', 27); //after soulmedic-geo menu
}

function soulmedic_geo_css() {
	wp_register_style('soulmedic_geo_css.css', THEME_CHILD_URL.'/framework/admin/admin.css', '', $GLOBALS['THEME_CSS_VERSION'], '');
	wp_enqueue_style('soulmedic_geo_css.css');
}
?>