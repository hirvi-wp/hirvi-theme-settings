<?php
/**
 * Plugin Name: HWP - Theme Settings
 * Plugin URI: https://hirvi.no
 * Description: Configure core theme settings for your theme.
 * Author: Chris Magnussen
 * Author URI: https://hirvi.no/team/chris-magnussen
 * Version: 0.1
 * Text Domain: hwp-theme
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require(__DIR__ . '/vendor/autoload.php');
}

use HWP\Theme\Settings;

// Default tabs
$tabs = [
    \HWP\Theme\Tabs\Head::class,
    //\HWP\Theme\Tabs\Scripts::class,
];

// TODO
// Enqueue scripts i header.blade.php
// Få inn flere settings
// Sosiale medier plugin

// Register all default tabs
foreach($tabs as $tab) {
    $instance = new $tab();
    add_filter('hwp_theme_tabs', [$instance, 'register']);
    add_action('init', [$instance, 'run'], 9999);
}

// Create admin panel
$settings = new Settings();
add_action('carbon_register_fields', [$settings, 'setup']);
add_action('carbon_after_save_theme_options', [$settings, 'handleData']);