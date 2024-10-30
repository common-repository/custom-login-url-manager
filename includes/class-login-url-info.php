<?php
// Blokada bezpośredniego dostępu do pliku
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Klasa odpowiedzialna za wyświetlanie informacji o wtyczce
class CLUMANAGER_Login_Info {

    public function display_info_page() {
        echo '<div class="wrap clumanager-info">';
        echo '<h1>'.esc_html__( 'Welcome to Custom Login URL Manager', 'custom-login-url-manager' ).'</h1>';
        echo '<p>'.esc_html__( 'Thank you for using Custom Login URL Manager! This plugin helps you enhance the security of your WordPress site by allowing you to change the default login URL and redirect unauthorized login attempts.', 'custom-login-url-manager' ).'</p>';
        
        echo '<h2>'.esc_html__( 'Key Features:', 'custom-login-url-manager' ).'</h2>';
        echo '<ul>';
        echo '<li>'.esc_html__( 'Change the default WordPress login URL (wp-login.php) to a custom URL for added security.', 'custom-login-url-manager' ).'</li>';
        echo '<li>'.esc_html__( 'Redirect unauthorized access attempts to wp-login.php or wp-admin to a specified URL, such as a custom error page or homepage.', 'custom-login-url-manager' ).'</li>';
        echo '<li>'.esc_html__( 'User-friendly interface for easy configuration of login URL and redirect settings.', 'custom-login-url-manager' ).'</li>';
        echo '<li>'.esc_html__( 'Translation-ready for localization into any language.', 'custom-login-url-manager' ).'</li>';
        echo '<li>'.esc_html__( 'Lightweight and optimized for performance.', 'custom-login-url-manager' ).'</li>';
        echo '</ul>';
        
        echo '<p>'.esc_html__( 'To get started, navigate to the "Settings" page in the Custom Login Manager menu to configure your custom login URL and redirect options.', 'custom-login-url-manager' ).'</p>';
        echo '</div>';
    }
}
