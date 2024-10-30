=== Custom Login URL Manager - Hide Login Admin URL ===

Contributors: wpdesignerpl  
Tags: login url, custom login, security, login redirect, wp-login.php  
Requires at least: 6.2  
Tested up to: 6.6  
Stable tag: 1.1.2  
Requires PHP: 7.2.5  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Change the default WordPress login URL and redirect unauthorized attempts to a specified page for enhanced security.

== Description ==

Custom Login URL Manager allows you to secure your WordPress site by changing the default login URL (wp-login.php) to a custom URL. This helps protect against unauthorized login attempts and automated bots trying to access your admin panel.

**Key Features:**

* **Custom Login URL**: Replace the default WordPress login URL with a custom one.
* **Login URL Redirect**: Redirect unauthorized access attempts (e.g., wp-login.php or wp-admin) to a specified URL, such as a custom error page or homepage.
* **User-Friendly Interface**: Easily configure your login URL and redirect settings through the WordPress admin panel.
* **Security Enhancement**: Hides the default login page, adding an extra layer of security to your website.
* **Translation Ready**: .pot file included for easy translation into different languages.
* **Languages**: Available in both English and Polish.

== Installation ==

1. Upload the `custom-login-url-manager` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Navigate to "Custom Login Manager" in the WordPress admin panel to configure the plugin settings.

== Frequently Asked Questions ==

= How do I change my login URL? =

After activating the plugin, go to the "Custom Login Manager" settings page in the WordPress admin panel. Enter your desired login URL in the appropriate field and save your settings.

= What happens if someone tries to access wp-login.php? =

Unauthorized attempts to access the default wp-login.php page will be automatically redirected to the URL you specify in the plugin settings.

= Can I reset the login URL to default? =

Yes, you can revert to the default login page by removing the custom URL from the settings and saving the changes.

= Is the plugin compatible with the latest version of WordPress? =

Yes, the plugin is tested up to WordPress version 6.6.

= Can I translate the plugin? =

Yes, the plugin is translation-ready with a .pot file included for easy localization.

== Screenshots ==

1. Plugin Settings Page – Configure custom login URL and redirect options.
2. Unauthorized Access Redirect – Example of redirecting to a 404 page for unauthorized attempts.

== Changelog ==

= 1.1.0 =
* Added custom redirect options for unauthorized login attempts.
* Improved user interface for easier configuration.
* Tested with the latest WordPress version.

= 1.1.1 =
* Initial release of the plugin.

= 1.1.2 =
* Update to add new features such as unauthorized access redirects and enhanced security.
* Added support for Polish language.

== Upgrade Notice ==

= 1.1.2 =
* Update to add new features such as unauthorized access redirects and enhanced security.

== License ==

This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; version 2 of the License, or (at your option) any later version.

== Donate Link ==

If you'd like to support the development of this plugin, consider donating at: https://ko-fi.com/wpdesigner
