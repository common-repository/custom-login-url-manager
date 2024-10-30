<?php

if (!defined('ABSPATH')) {
    exit;
}

class CLUMANAGER_Login_Handler {
    private $new_login_slug;
    private $wp_login_php;

    public function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init() {
        // Pobranie niestandardowego URL logowania z opcji
        $this->new_login_slug = $this->new_login_url();
        $this->wp_login_php = ABSPATH . 'wp-login.php';

        add_action('init', array($this, 'handle_request'), 1);
        add_action('wp_loaded', array($this, 'handle_admin_access'), 1);
        add_filter('site_url', array($this, 'site_url'), 10, 4);
        add_filter('network_site_url', array($this, 'network_site_url'), 10, 3);
        add_filter('wp_redirect', array($this, 'wp_redirect'), 10, 2);
        add_filter('site_option_welcome_email', array($this, 'welcome_email'));
        add_filter('login_url', array($this, 'login_url'), 10, 3);

        remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
    }

    // Pobranie nowego URL logowania ustawionego w opcjach
    private function new_login_url() {
        $custom_url = get_option('clumanager_custom_login_url', 'custom');
        return trim($custom_url, '/');
    }

    // Obsługa przekierowania z /admin/ na niestandardowy URL logowania lub stronę główną
    public function handle_request() {
        global $pagenow;

        // Sprawdzamy, czy zmienna $_SERVER['REQUEST_URI'] jest zdefiniowana
        if (isset($_SERVER['REQUEST_URI'])) {
            // Używamy wp_parse_url() zamiast parse_url() i sanitizujemy dane
            $request = wp_parse_url(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])));
            $path = isset($request['path']) ? untrailingslashit($request['path']) : '';

            // Blokowanie dostępu do wp-login.php, jeśli nie jest to niestandardowa strona logowania
            if ($pagenow === 'wp-login.php' && $path !== home_url($this->new_login_slug, 'relative')) {
                $this->wp_login_php_block();
                exit;
            }

            // Przekierowanie z /admin/ na domyślną stronę główną lub na niestandardowy "Redirect URL"
            if ($path === untrailingslashit(home_url('admin', 'relative'))) {
                $redirect_url = get_option('clumanager_redirect_url');
                if (empty($redirect_url)) {
                    $redirect_url = home_url('/'); // Domyślna strona główna, jeśli nie ustawiono redirect URL
                }
                wp_safe_redirect($redirect_url);
                exit;
            }

            // Obsługa niestandardowego slugu logowania
            if ($path === home_url($this->new_login_slug, 'relative') || 
                (!get_option('permalink_structure') && isset($_GET[$this->new_login_slug]))) {

                // Sprawdzamy, czy nonce został przekazany i czy jest poprawny, tylko jeśli istnieje w żądaniu
                if (isset($_POST['custom_login_nonce'])) {
                    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['custom_login_nonce'])), 'custom_login_action')) {
                        // Jeśli nonce nie jest poprawny, wyświetlamy komunikat o błędzie lub przekierowujemy
                        wp_die(esc_html__('Unauthorized access.', 'custom-login-url-manager'));
                    }
                }

                // Ładujemy stronę niestandardowego logowania
                $this->load_custom_login_page();
            }
        }
    }

    public function handle_admin_access() {
        if (!is_user_logged_in() && $this->is_wp_admin()) {
            $this->wp_login_php_block();
            exit;
        }
    }

    private function is_wp_admin() {
        // Sprawdzamy, czy zmienna $_SERVER['REQUEST_URI'] jest zdefiniowana
        if (isset($_SERVER['REQUEST_URI'])) {
            // Sanitacja i odsleshowanie zmiennej REQUEST_URI
            $current_url = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
            return (strpos($current_url, '/wp-admin') !== false);
        }
        return false; // Jeśli zmienna nie jest ustawiona, zwracamy false
    }

    private function wp_login_php_block() {
        $redirect_url = get_option('clumanager_redirect_url');
        if (empty($redirect_url)) {
            $redirect_url = home_url('/');
        }
        wp_safe_redirect($redirect_url);
        exit;
    }

    private function load_custom_login_page() {
        global $error, $interim_login, $action, $user_login;
        @require_once $this->wp_login_php;
        exit;
    }

    public function site_url($url, $path, $scheme, $blog_id) {
        return $this->filter_wp_login_php($url, $scheme);
    }

    public function network_site_url($url, $path, $scheme) {
        return $this->filter_wp_login_php($url, $scheme);
    }

    public function wp_redirect($location, $status) {
        return $this->filter_wp_login_php($location);
    }

    public function welcome_email($value) {
        return str_replace('wp-login.php', trailingslashit($this->new_login_slug), $value);
    }

    public function login_url($login_url, $redirect, $force_reauth) {
        if ($force_reauth === false) {
            $login_url = home_url($this->new_login_slug, 'relative');
            if (!empty($redirect)) {
                $login_url = add_query_arg('redirect_to', urlencode($redirect), $login_url);
            }
        }
        return $login_url;
    }

    private function filter_wp_login_php($url, $scheme = null) {
        if (strpos($url, 'wp-login.php') !== false) {
            $args = explode('?', $url);
            if (isset($args[1])) {
                parse_str($args[1], $args);
                $url = add_query_arg($args, home_url($this->new_login_slug, $scheme));
            } else {
                $url = home_url($this->new_login_slug, $scheme);
            }
        }
        return $url;
    }
}

new CLUMANAGER_Login_Handler();
