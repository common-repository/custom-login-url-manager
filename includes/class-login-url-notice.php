<?php
// Blokada bezpośredniego dostępu
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CLUMANAGER_Admin_Notice {

    public function __construct() {
        // Wyświetlenie notyfikacji tylko dla administratorów
        add_action('admin_notices', array($this, 'clumanager_show_notice'));
        add_action('admin_init', array($this, 'clumanager_dismiss_notice'));
    }

    // Funkcja do wyświetlania notyfikacji
    public function clumanager_show_notice() {
        // Sprawdzamy, czy użytkownik już nie kliknął "Nie pokazuj ponownie"
        if (get_option('clumanager_admin_notice_dismissed') == true) {
            return;
        }

        // Generowanie nonce
        $dismiss_url = add_query_arg(
            array(
                'clumanager_dismiss_notice' => '1',
                '_wpnonce' => wp_create_nonce('clumanager_dismiss_notice_nonce')
            )
        );

        ?>
        <div class="notice notice-info is-dismissible clumanager-admin-notice">
            <p>
                <?php esc_html_e('Hello! We’re glad to see you’ve been using Custom Login URL Manager. If you’re happy with the plugin, we’d be thrilled if you could leave us a rating. Your support helps us grow and improve.', 'custom-login-url-manager'); ?>
            </p>
            <p>
                <a href="https://wordpress.org/support/plugin/custom-login-url-manager/reviews/" target="_blank" class="button-primary"><?php esc_html_e('Rate this plugin', 'custom-login-url-manager'); ?></a>
                <a href="https://ko-fi.com/wpdesigner" target="_blank" class="button-secondary black"><?php esc_html_e('Buy me Coffee', 'custom-login-url-manager'); ?></a>
                <a href="<?php echo esc_url($dismiss_url); ?>" class="button-secondary"><?php esc_html_e('Don\'t show again', 'custom-login-url-manager'); ?></a>
            </p>
        </div>
        <?php
    }

    // Funkcja do ukrycia notyfikacji, kiedy użytkownik kliknie "Nie pokazuj ponownie"
    public function clumanager_dismiss_notice() {
        if (isset($_GET['clumanager_dismiss_notice']) && $_GET['clumanager_dismiss_notice'] == '1') {
            // Weryfikacja nonce przed przetwarzaniem żądania
            if (isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'clumanager_dismiss_notice_nonce')) {
                update_option('clumanager_admin_notice_dismissed', true);
            }
        }
    }
}

new CLUMANAGER_Admin_Notice();
