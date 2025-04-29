<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
// Load the ACF plugin if it is not already loaded.
// if (!function_exists('acf_add_local_field_group')) {
//     return;
// }
// // Register the ACF block
// function befphoto_register_acf_blocks() {
//     /**
//      * We register our block's with WordPress's handy
//      * register_block_type();
//      *
//      * @link https://developer.wordpress.org/reference/functions/register_block_type/
//      */
//     register_block_type( __DIR__ . '/blocks/gallery' );
//      wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css', [], null);
//     wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', ['jquery'], null, true);
// }
// // Here we call our befphoto_register_acf_block() function on init.
// add_action( 'init', 'befphoto_register_acf_blocks' );


if (function_exists('acf_register_block_type')) {
    add_action('acf/init', 'register_photo_share_acf_blocks');
}

function register_photo_share_acf_blocks() {
   
       acf_register_block_type(array(
        'name'              => 'bef_photo_share',
        'title'             => __('Photo Share'),
        'description'       => __('Display Photo Gallery.'),
         'render_callback'   => 'render_bef_photo_share_block',
        'render_template'   => plugin_dir_path(__FILE__) . '../blocks/gallery/gallery.php',
        'category'          => 'bef-acf-blocks',
        'icon'              => 'table-col-after',
        'keywords'          => array('block', 'acf'),
         'enqueue_assets'    => function() {
             wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css', [], null);
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', ['jquery'], null, true);
             wp_enqueue_style('photo-share-style', plugins_url('../blocks/gallery/gallery.css', __FILE__), array(), '1.5', 'all');
        },
    ));

   
}