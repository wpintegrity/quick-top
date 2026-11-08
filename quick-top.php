<?php
/**
 * Plugin Name:       Quick Top and WP Dark Mode
 * Plugin URI:        https://github.com/wpintegrity/quick-top
 * Description:       Modern scroll-to-top button and full-site dark mode for WordPress.
 * Version:           1.4.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Tanvir Hasan
 * Author URI:        https://profiles.wordpress.org/tanvirh/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       quick-top
 * Domain Path:       /languages
 *
 * @package Quick_Top
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QUICK_TOP_VERSION', '1.4.0' );
define( 'QUICK_TOP_FILE', __FILE__ );
define( 'QUICK_TOP_PATH', plugin_dir_path( __FILE__ ) );
define( 'QUICK_TOP_URL', plugin_dir_url( __FILE__ ) );

require_once QUICK_TOP_PATH . 'includes/admin-settings.php';
require_once QUICK_TOP_PATH . 'includes/front-end-display.php';
require_once QUICK_TOP_PATH . 'includes/dark-mode.php';

/**
 * Load plugin textdomain.
 */
function quick_top_load_textdomain() {
	load_plugin_textdomain( 'quick-top', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'quick_top_load_textdomain' );

/**
 * Enqueue admin styles and scripts.
 *
 * @param string $hook Current admin page hook.
 */
function quick_top_admin_enqueue( $hook ) {
	if ( 'toplevel_page_quick-top-settings' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'quick-top-admin-fonts',
		'https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700&family=Source+Sans+3:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_media();

	wp_enqueue_style(
		'quick-top-font-awesome-fonts',
		QUICK_TOP_URL . 'assets/css/fontawesome-fonts.css',
		array(),
		'6.5.2'
	);

	wp_enqueue_style(
		'quick-top-font-awesome',
		QUICK_TOP_URL . 'assets/css/fontawesome.min.css',
		array( 'quick-top-font-awesome-fonts' ),
		'6.5.2'
	);

	wp_enqueue_style(
		'quick-top-admin',
		QUICK_TOP_URL . 'assets/css/admin.css',
		array( 'quick-top-admin-fonts', 'quick-top-font-awesome' ),
		QUICK_TOP_VERSION
	);

	wp_enqueue_script(
		'quick-top-admin',
		QUICK_TOP_URL . 'assets/js/admin.js',
		array( 'jquery' ),
		QUICK_TOP_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'admin_enqueue_scripts', 'quick_top_admin_enqueue' );

/**
 * Allow SVG uploads for admins (needed for custom Quick Top icons).
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function quick_top_allow_svg_uploads( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'quick_top_allow_svg_uploads' );

/**
 * Fix SVG filetype detection for admin uploads.
 *
 * @param array  $data     File data.
 * @param string $file     Full path.
 * @param string $filename File name.
 * @param array  $mimes    Mime types.
 * @return array
 */
function quick_top_fix_svg_filetype( $data, $file, $filename, $mimes ) {
	unset( $file );

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

/**
 * Enqueue front-end assets only when features are enabled.
 */
function quick_top_frontend_enqueue() {
	$options       = quick_top_get_settings();
	$scroll_on     = ! empty( $options['enabled'] );
	$dark_mode_on  = ! empty( $options['dark_mode_enabled'] );

	if ( ! $scroll_on && ! $dark_mode_on ) {
		return;
	}

	if ( $scroll_on || $dark_mode_on ) {
		wp_enqueue_style(
			'quick-top-font-awesome-fonts',
			QUICK_TOP_URL . 'assets/css/fontawesome-fonts.css',
			array(),
			'6.5.2'
		);

		wp_enqueue_style(
			'quick-top-font-awesome',
			QUICK_TOP_URL . 'assets/css/fontawesome.min.css',
			array( 'quick-top-font-awesome-fonts' ),
			'6.5.2'
		);
	}

	if ( $scroll_on ) {
		wp_enqueue_style(
			'quick-top-frontend',
			QUICK_TOP_URL . 'assets/css/frontend.css',
			array( 'quick-top-font-awesome' ),
			QUICK_TOP_VERSION
		);

		wp_enqueue_script(
			'quick-top-frontend',
			QUICK_TOP_URL . 'assets/js/frontend.js',
			array( 'jquery' ),
			QUICK_TOP_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'quick_top_frontend_enqueue' );
