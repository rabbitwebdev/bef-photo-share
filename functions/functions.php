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

if (isset($_POST['bulk_download']) && !empty($_POST['selected_images'])) {
    $zip = new ZipArchive();
    $zip_name = 'gallery-download-' . time() . '.zip';
    $zip_path = __DIR__ . '/' . $zip_name;

    if ($zip->open($zip_path, ZipArchive::CREATE) === TRUE) {
        foreach ($_POST['selected_images'] as $file_url) {
            $file_content = file_get_contents($file_url);
            $file_name = basename($file_url);
            $zip->addFromString($file_name, $file_content);
        }
        $zip->close();

        // Send the zip file to the browser
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zip_name);
        header('Content-Length: ' . filesize($zip_path));
        readfile($zip_path);

        // Optional: delete zip after download
        unlink($zip_path);
        exit;
    } else {
        echo "Failed to create zip file.";
    }
}