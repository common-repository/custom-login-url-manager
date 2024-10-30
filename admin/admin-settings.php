<?php
// Blokada bezpośredniego dostępu do pliku
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Dodanie strony ustawień dla wtyczki
function clumanager_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Custom Login URL Manager - Settings', 'custom-login-url-manager'); ?></h1>

        <?php 
        // Sprawdzenie, czy 'settings-updated' i '_wpnonce' są ustawione oraz odpowiednia walidacja i sanityzacja
            if ( isset( $_GET['settings-updated'], $_GET['_wpnonce'] ) ) {

                // Odpowiednie odslashowanie danych i sanityzacja
                $nonce = sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) );

                // Weryfikacja nonce
                if ( wp_verify_nonce( $nonce, 'save_settings_action' ) ) {
                    if ( $_GET['settings-updated'] == 'true' ) {
                        echo '<div id="message" class="updated notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully!', 'custom-login-url-manager') . '</p></div>';
                    } elseif ( $_GET['settings-updated'] == 'false' ) {
                        echo '<div id="message" class="error notice notice-error is-dismissible"><p>' . esc_html__('Failed to save settings. Please try again.', 'custom-login-url-manager') . '</p></div>';
                    }
                } else {
                    echo '<div id="message" class="error notice notice-error is-dismissible"><p>' . esc_html__('Nonce verification failed. Please try again.', 'custom-login-url-manager') . '</p></div>';
                }
            }
        ?>

        <form method="post" action="options.php">
            <?php
            // Rejestracja pól ustawień
            settings_fields('clumanager-settings-group');
            // Wyświetlenie sekcji ustawień
            do_settings_sections('clumanager-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Custom Login URL', 'custom-login-url-manager'); ?></th>
                    <td>
                        <input type="text" name="clumanager_custom_login_url" value="<?php echo esc_attr(get_option('clumanager_custom_login_url')); ?>" placeholder="<?php esc_attr_e('e.g., login', 'custom-login-url-manager'); ?>" />
                        <p class="description"><?php esc_html_e('Change the default login URL to enhance the security of your site by hiding the standard wp-login.php.', 'custom-login-url-manager'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Redirect URL', 'custom-login-url-manager'); ?></th>
                    <td>
                        <input type="text" name="clumanager_redirect_url" value="<?php echo esc_attr(get_option('clumanager_redirect_url')); ?>" placeholder="<?php esc_attr_e('e.g., 404', 'custom-login-url-manager'); ?>" />
                        <p class="description"><?php esc_html_e('Specify the URL to redirect unauthorized users who try to access wp-login.php, wp-admin, or admin without proper permissions. If left empty, it will redirect to the homepage.', 'custom-login-url-manager'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Rejestracja opcji wtyczki
add_action('admin_init', 'clumanager_register_settings');
function clumanager_register_settings() {
    // Rejestracja opcji
    register_setting('clumanager-settings-group', 'clumanager_custom_login_url');
    register_setting('clumanager-settings-group', 'clumanager_redirect_url');
}

// Wyświetlanie komunikatów o zapisie
add_action( 'admin_notices', 'clumanager_admin_notices' );
function clumanager_admin_notices() {
    settings_errors();
}
