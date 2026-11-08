<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function quick_top_enqueue_scripts() {
    $options = quick_top_get_settings();

    if ( empty( $options['enabled'] ) ) {
        return;
    }

    $position      = isset( $options['position'] ) ? $options['position'] : 'bottom-right';
    $border_radius = isset( $options['border_radius'] ) ? intval( $options['border_radius'] ) . 'px' : '50%';
    $icon_bg_color = isset( $options['icon_bg_color'] ) ? esc_attr( $options['icon_bg_color'] ) : '#000';
    $icon_color    = isset( $options['icon_color'] ) ? esc_attr( $options['icon_color'] ) : '#fff';
    $icon_size     = isset( $options['icon_size'] ) ? intval( $options['icon_size'] ) . 'px' : '24px';
    $bg_width      = isset( $options['bg_width'] ) ? intval( $options['bg_width'] ) . 'px' : '50px';
    $bg_height     = isset( $options['bg_height'] ) ? intval( $options['bg_height'] ) . 'px' : '50px';
    $padding       = isset( $options['padding'] ) ? intval( $options['padding'] ) . 'px' : '10px';
    $margin_top    = isset( $options['margin_top'] ) ? intval( $options['margin_top'] ) . 'px' : '0';
    $margin_right  = isset( $options['margin_right'] ) ? intval( $options['margin_right'] ) . 'px' : '0';
    $margin_bottom = isset( $options['margin_bottom'] ) ? intval( $options['margin_bottom'] ) . 'px' : '0';
    $margin_left   = isset( $options['margin_left'] ) ? intval( $options['margin_left'] ) . 'px' : '0';

    $position_styles = '';
    switch ( $position ) {
        case 'bottom-left':
            $position_styles = 'bottom: 20px; left: 20px;';
            break;
        case 'top-right':
            $position_styles = 'top: 20px; right: 20px;';
            break;
        case 'top-left':
            $position_styles = 'top: 20px; left: 20px;';
            break;
        case 'bottom-right':
        default:
            $position_styles = 'bottom: 20px; right: 20px;';
            break;
    }

    $style = "
        #quick-top {
            position: fixed;
            {$position_styles}
            background-color: {$icon_bg_color};
            color: {$icon_color};
            font-size: {$icon_size};
            width: {$bg_width};
            height: {$bg_height};
            padding: {$padding};
            margin-top: {$margin_top};
            margin-right: {$margin_right};
            margin-bottom: {$margin_bottom};
            margin-left: {$margin_left};
            border-radius: {$border_radius};
            box-sizing: border-box;
        }
        #quick-top .quick-top-custom-icon {
            width: {$icon_size};
            height: {$icon_size};
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
            display: block;
        }
    ";

    wp_add_inline_style( 'quick-top-frontend', $style );

    if ( empty( $options['mobile_enabled'] ) ) {
        wp_add_inline_style( 'quick-top-frontend', '@media (max-width: 768px) { #quick-top { display: none !important; } }' );
    }
}
add_action( 'wp_enqueue_scripts', 'quick_top_enqueue_scripts', 20 );

function quick_top_display_button() {
    $options = quick_top_get_settings();

    if ( empty( $options['enabled'] ) ) {
        return;
    }

    $scroll_distance = isset( $options['scroll_distance'] ) ? absint( $options['scroll_distance'] ) : 100;
    $has_custom      = (bool) quick_top_get_custom_icon_url( $options );

    printf(
        '<button type="button" id="quick-top" class="quick-top-button%s" data-scroll-distance="%d" aria-label="%s">%s</button>',
        $has_custom ? ' has-custom-icon' : '',
        $scroll_distance,
        esc_attr__( 'Back to top', 'quick-top' ),
        quick_top_get_icon_markup( $options ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    );
}
add_action( 'wp_footer', 'quick_top_display_button' );
