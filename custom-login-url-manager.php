<?php
/*
Plugin Name: Custom Login URL Manager - Hide Login Admin URL
Plugin URI: https://wordpress.org/plugins/custom-login-url-manager/
Description:  A plugin that allows you to change your login address in WordPress and redirect blocked addresses to a specified URL.
Version: 1.1.2
Author: CPManager
Author URI: https://custompostmanager.com/
Text Domain: custom-login-url-manager
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Blokada bezpośredniego dostępu do pliku
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Ładowanie plików językowych
add_action( 'plugins_loaded', 'clumanager_load_textdomain' );
function clumanager_load_textdomain() {
    load_plugin_textdomain( 'custom-login-url-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function clum_translate_plugin_description( $translated_text, $text, $domain ) {
    if ( $domain === 'custom-login-url-manager' && $text === 'A plugin that allows you to change your login address in WordPress and redirect blocked addresses to a specified URL.' ) {
        $translated_text = __( 'A plugin that allows you to change your login address in WordPress and redirect blocked addresses to a specified URL.', 'custom-login-url-manager' );
    }
    return $translated_text;
}
add_filter( 'gettext', 'clum_translate_plugin_description', 10, 3 );

// Ładowanie plików CSS w panelu administracyjnym
add_action('admin_enqueue_scripts', 'clumanager_enqueue_admin_styles');
function clumanager_enqueue_admin_styles() {
    wp_enqueue_style('clumanager-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/admin-styles.css');
}

// Dodanie głównego menu wtyczki oraz podmenu ustawień
add_action('admin_menu', 'clumanager_add_admin_menu');
function clumanager_add_admin_menu() {
    add_menu_page(
        __('Custom Login Manager', 'custom-login-url-manager'),  // Tytuł strony
        __('Custom Login Manager', 'custom-login-url-manager'),  // Nazwa w menu
        'manage_options',  // Uprawnienia
        'custom-login-url-manager',  // Unikalny identyfikator strony (bez .php)
        'clumanager_main_page',  // Callback do wyświetlenia zawartości strony głównej
        'dashicons-admin-network',  // Ikona wtyczki
        6  // Pozycja w menu
    );

    add_submenu_page(
        'custom-login-url-manager',  // Główne menu (rodzic)
        __('Settings', 'custom-login-url-manager'),  // Tytuł strony
        __('Settings', 'custom-login-url-manager'),  // Nazwa w menu
        'manage_options',  // Uprawnienia
        'custom-login-url-settings',  // Unikalny identyfikator strony (bez .php)
        'clumanager_settings_page'  // Callback do wyświetlenia zawartości strony ustawień
    );
}

// Dodanie linku do ustawień na liście wtyczek
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'clu_add_settings_link' );

if ( ! function_exists( 'clu_add_settings_link' ) ) {
    function clu_add_settings_link( $links ) {
        // Używamy __(), aby zwrócić przetłumaczony tekst
        $settings_link = '<a href="admin.php?page=custom-login-url-settings">' . __( 'Settings', 'custom-login-url-manager' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
}

// Dodanie linka "Postaw mi kawę" obok "Deactivate"
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'clu_add_donate_link');
if ( ! function_exists( 'clu_add_donate_link' ) ) {
    function clu_add_donate_link($links) {
        $donate_link = '<a href="https://ko-fi.com/wpdesigner" target="_blank">' . __('Buy me Coffee', 'custom-login-url-manager') . '</a>';
        array_push($links, $donate_link);
        return $links;
    }
}

// Callback do wyświetlenia głównej strony wtyczki
function clumanager_main_page() {
    $info_page = new CLUMANAGER_Login_Info();
    $info_page->display_info_page();
}

// Wczytanie pliku ustawień z katalogu admin
require_once plugin_dir_path(__FILE__) . 'admin/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-login-url-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-login-url-info.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-login-url-notice.php';