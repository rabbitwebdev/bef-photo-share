<?php
/**
 * Plugin Name: BEF Photo Share
 * Plugin URI:  https://yourwebsite.com
 * Description: A custom ACF block for sharing photos with captions.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: bef-photo-share
 * License: GPL2
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Plugin setup
 */

require_once plugin_dir_path(__FILE__) . 'functions/functions.php';

// Enqueue block-specific styles
function bef_enqueue_photo_share_assets() {
    wp_enqueue_style('bef-photo-share-style', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css', [], null);
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', 'bef_enqueue_photo_share_assets');

