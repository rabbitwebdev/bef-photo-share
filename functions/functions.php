<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
// Load the post types if it is not already loaded.
require_once plugin_dir_path(__FILE__) . '../includes/register-blocks.php';
require_once plugin_dir_path(__FILE__) . '../includes/register-post-type.php';
require_once plugin_dir_path(__FILE__) . '../includes/register-acf.php';

function bef_load_photo_share_template($template) {
    if (get_post_type() == 'photo-share' ) {
        $new_template = plugin_dir_path(__FILE__) . '../template/single-photo-share.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'bef_load_photo_share_template');

