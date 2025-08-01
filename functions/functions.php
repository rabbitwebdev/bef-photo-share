<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
// Load the post types if it is not already loaded.
require_once plugin_dir_path(__FILE__) . '../includes/register-blocks.php';
require_once plugin_dir_path(__FILE__) . '../includes/register-post-type.php';
require_once plugin_dir_path(__FILE__) . '../includes/register-acf.php';



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

add_action('wp_ajax_send_newsletter_download', 'handle_newsletter_download');
add_action('wp_ajax_nopriv_send_newsletter_download', 'handle_newsletter_download');

function handle_newsletter_download() {
    if (empty($_POST['email']) || empty($_POST['selected_images'])) {
        wp_send_json(['success' => false, 'message' => 'Email and images required.']);
    }

    $email = sanitize_email($_POST['email']);
    $images = $_POST['selected_images'];

    // 1. Add user to newsletter (optional: integrate Mailchimp, FluentCRM, etc.)
    // For now, we just log it or save it in WP options
    // add_subscriber_to_newsletter($email);

    // 2. Create ZIP file
    $zip = new ZipArchive();
    $zip_name = 'gallery-download-' . time() . '.zip';
    $upload_dir = wp_upload_dir();
    $zip_path = $upload_dir['path'] . '/' . $zip_name;
    $zip_url = $upload_dir['url'] . '/' . $zip_name;

    if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($images as $file_url) {
            $file_name = basename($file_url);
            $file_content = file_get_contents($file_url);
            if ($file_content !== false) {
                $zip->addFromString($file_name, $file_content);
            }
        }
        $zip->close();

        // 3. Send email with download link
        $subject = "Your image download link";
        $message = "Hi,\n\nThanks for subscribing! You can download your images here:\n\n" . $zip_url;
        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        wp_mail($email, $subject, $message, $headers);

        wp_send_json(['success' => true, 'message' => 'Check your email for the download link!']);
    } else {
        wp_send_json(['success' => false, 'message' => 'Failed to create zip file.']);
    }
}


// add_action('wp_ajax_bulk_download_images', 'handle_bulk_image_download');
// add_action('wp_ajax_nopriv_bulk_download_images', 'handle_bulk_image_download');

// function handle_bulk_image_download() {
//     if (empty($_POST['selected_images']) || !is_array($_POST['selected_images'])) {
//         wp_die('No images selected');
//     }

//     $zip = new ZipArchive();
//     $zip_name = sanitize_file_name($_POST['zip_name'] ?? 'gallery-download') . '.zip';
//     $zip_path = wp_upload_dir()['path'] . '/' . $zip_name;

//     if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
//         foreach ($_POST['selected_images'] as $file_url) {
//             $file_name = basename($file_url);
//             $file_content = file_get_contents($file_url);

//             if ($file_content !== false) {
//                 $zip->addFromString($file_name, $file_content);
//             }
//         }
//         $zip->close();

//         header('Content-Type: application/zip');
//         header('Content-Disposition: attachment; filename="' . $zip_name . '"');
//         header('Content-Length: ' . filesize($zip_path));
//         readfile($zip_path);

//         unlink($zip_path); // Clean up
//         exit;
//     } else {
//         wp_die('Could not create zip file');
//     }
// }

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