<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function quick_top_is_dark_mode_enabled() {
    $options = quick_top_get_settings();
    return ! empty( $options['dark_mode_enabled'] );
}

function quick_top_dark_mode_enqueue() {
    if ( ! quick_top_is_dark_mode_enabled() ) {
        return;
    }

    $options = quick_top_get_settings();

    wp_enqueue_style(
        'quick-top-dark-mode',
        plugins_url( '../assets/css/dark-mode.css', __FILE__ ),
        array(),
        '1.0.1'
    );

    wp_enqueue_script(
        'quick-top-dark-mode',
        plugins_url( '../assets/js/dark-mode.js', __FILE__ ),
        array(),
        '1.0.1',
        true
    );

    wp_localize_script(
        'quick-top-dark-mode',
        'quickTopDarkMode',
        array(
            'defaultMode'   => isset( $options['dark_mode_default'] ) ? $options['dark_mode_default'] : 'light',
            'showToggle'    => ! empty( $options['dark_mode_toggle'] ),
            'togglePos'     => isset( $options['dark_mode_toggle_position'] ) ? $options['dark_mode_toggle_position'] : 'bottom-left',
            'storageKey'    => 'quick_top_dark_mode',
            'labels'        => array(
                'enable'  => __( 'Enable dark mode', 'quick-top' ),
                'disable' => __( 'Disable dark mode', 'quick-top' ),
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'quick_top_dark_mode_enqueue' );

/**
 * Apply dark mode class early to avoid flash of light theme.
 */
function quick_top_dark_mode_head_script() {
    if ( ! quick_top_is_dark_mode_enabled() ) {
        return;
    }

    $options      = quick_top_get_settings();
    $default_mode = isset( $options['dark_mode_default'] ) ? $options['dark_mode_default'] : 'light';
    ?>
    <script>
    (function () {
        try {
            var key = 'quick_top_dark_mode';
            var saved = localStorage.getItem(key);
            var mode = saved || <?php echo wp_json_encode( $default_mode ); ?>;
            var isDark = mode === 'dark';

            if (mode === 'system') {
                isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            if (isDark) {
                document.documentElement.classList.add('quick-top-dark-mode');
            }
        } catch (e) {}
    })();
    </script>
    <?php
}
add_action( 'wp_head', 'quick_top_dark_mode_head_script', 1 );

function quick_top_dark_mode_toggle_button() {
    if ( ! quick_top_is_dark_mode_enabled() ) {
        return;
    }

    $options = quick_top_get_settings();
    if ( empty( $options['dark_mode_toggle'] ) ) {
        return;
    }

    $position = isset( $options['dark_mode_toggle_position'] ) ? $options['dark_mode_toggle_position'] : 'bottom-left';
    ?>
    <button
        type="button"
        id="quick-top-dark-toggle"
        class="quick-top-dark-toggle quick-top-dark-toggle--<?php echo esc_attr( $position ); ?>"
        aria-pressed="false"
        aria-label="<?php esc_attr_e( 'Toggle dark mode', 'quick-top' ); ?>"
        title="<?php esc_attr_e( 'Toggle dark mode', 'quick-top' ); ?>"
    >
        <span class="quick-top-dark-toggle__icon quick-top-dark-toggle__icon--moon" aria-hidden="true">
            <i class="fa fa-moon"></i>
        </span>
        <span class="quick-top-dark-toggle__icon quick-top-dark-toggle__icon--sun" aria-hidden="true">
            <i class="fa fa-sun"></i>
        </span>
    </button>
    <?php
}
add_action( 'wp_footer', 'quick_top_dark_mode_toggle_button', 5 );
