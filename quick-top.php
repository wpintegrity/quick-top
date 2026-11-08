<?php
/*
* Plugin Name: Quick Top and WP Dark Mode
* Description: Modern scroll-to-top button and full-site dark mode for WordPress.
* Version: 1.3.0
* Author: Tanvir Hasan
* Author URI: https://profiles.wordpress.org/tanvirh/
* Text Domain: quick-top
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/admin-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/front-end-display.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/dark-mode.php';

// Enqueue admin styles and scripts
function quick_top_admin_enqueue($hook) {
    if ( $hook !== 'toplevel_page_quick-top-settings' ) {
        return;
    }

    wp_enqueue_style(
        'quick-top-admin-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Source+Sans+3:wght@400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_media();

    wp_register_style( 'quick-top-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', array( 'quick-top-admin-fonts' ), '1.3.0' );
    wp_enqueue_style( 'quick-top-admin' );

    wp_register_script( 'quick-top-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery' ), '1.3.0', true );
    wp_enqueue_script( 'quick-top-admin' );
}
add_action( 'admin_enqueue_scripts', 'quick_top_admin_enqueue' );

/**
 * Allow SVG uploads for admins (needed for custom Quick Top icons).
 */
function quick_top_allow_svg_uploads( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
    }
    return $mimes;
}
add_filter( 'upload_mimes', 'quick_top_allow_svg_uploads' );

function quick_top_fix_svg_filetype( $data, $file, $filename, $mimes ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return $data;
    }

    $filetype = wp_check_filetype( $filename, $mimes );
    if ( 'svg' === $filetype['ext'] ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'quick_top_fix_svg_filetype', 10, 4 );

// Enqueue front-end styles and scripts
function quick_top_frontend_enqueue() {
    wp_register_style( 'quick-top-frontend', plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css', array(), '1.3.0' );
    wp_enqueue_style( 'quick-top-frontend' );

    wp_register_script( 'quick-top-frontend', plugin_dir_url( __FILE__ ) . 'assets/js/frontend.js', array( 'jquery' ), '1.3.0', true );
    wp_enqueue_script( 'quick-top-frontend' );
}
add_action( 'wp_enqueue_scripts', 'quick_top_frontend_enqueue' );

// Enqueue Local Font Awesome
function quick_top_enqueue_font_awesome() {
    wp_register_style(
        'quick-top-font-awesome-fonts',
        plugin_dir_url( __FILE__ ) . 'assets/css/fontawesome-fonts.css',
        array(),
        '6.5.2'
    );
    wp_register_style(
        'quick-top-font-awesome',
        plugin_dir_url( __FILE__ ) . 'assets/css/fontawesome.min.css',
        array( 'quick-top-font-awesome-fonts' ),
        '6.5.2'
    );
    wp_enqueue_style( 'quick-top-font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'quick_top_enqueue_font_awesome' );
add_action( 'admin_enqueue_scripts', 'quick_top_enqueue_font_awesome' );
?>
