<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function quick_top_add_admin_menu() {
    add_menu_page(
        'Quick Top and WP Dark Mode',
        'Quick Top',
        'manage_options',
        'quick-top-settings',
        'quick_top_settings_page',
        'dashicons-arrow-up-alt',
        100
    );
}
add_action( 'admin_menu', 'quick_top_add_admin_menu' );

function quick_top_get_settings() {
    $defaults = array(
        'enabled'         => 0,
        'border_radius'   => 50,
        'mobile_enabled'  => 1,
        'icon'            => 'fa-arrow-up',
        'custom_icon_id'  => 0,
        'custom_icon_url' => '',
        'icon_color'      => '#ffffff',
        'icon_bg_color'   => '#000000',
        'icon_size'       => 24,
        'bg_width'        => 50,
        'bg_height'       => 50,
        'padding'         => 10,
        'margin_top'      => 0,
        'margin_right'    => 20,
        'margin_bottom'   => 20,
        'margin_left'     => 0,
        'position'                   => 'bottom-right',
        'scroll_distance'            => 100,
        'dark_mode_enabled'          => 0,
        'dark_mode_default'          => 'light',
        'dark_mode_toggle'           => 1,
        'dark_mode_toggle_position'  => 'bottom-left',
    );

    $options = get_option( 'quick_top_settings', array() );
    if ( ! is_array( $options ) ) {
        $options = array();
    }

    return wp_parse_args( $options, $defaults );
}

function quick_top_settings_page() {
    $options = quick_top_get_settings();
    $preview_styles = sprintf(
        'background-color:%1$s;color:%2$s;font-size:%3$spx;width:%4$spx;height:%5$spx;padding:%6$spx;margin:%7$spx %8$spx %9$spx %10$spx;border-radius:%11$spx;box-sizing:border-box;display:inline-flex;align-items:center;justify-content:center;',
        esc_attr( $options['icon_bg_color'] ),
        esc_attr( $options['icon_color'] ),
        esc_attr( $options['icon_size'] ),
        esc_attr( $options['bg_width'] ),
        esc_attr( $options['bg_height'] ),
        esc_attr( $options['padding'] ),
        esc_attr( $options['margin_top'] ),
        esc_attr( $options['margin_right'] ),
        esc_attr( $options['margin_bottom'] ),
        esc_attr( $options['margin_left'] ),
        esc_attr( $options['border_radius'] )
    );
    $scroll_on = ! empty( $options['enabled'] );
    $dark_on   = ! empty( $options['dark_mode_enabled'] );
    ?>
    <div class="wrap qt-notice-sink">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Quick Top and WP Dark Mode', 'quick-top' ); ?></h1>
    </div>

    <div class="qt-admin">
        <div class="qt-shell">
            <header class="qt-hero">
                <div class="qt-hero__brand">
                    <span class="qt-mark" aria-hidden="true">
                        <i class="fa fa-arrow-up"></i>
                    </span>
                    <div class="qt-hero__copy">
                        <p class="qt-kicker"><?php esc_html_e( 'Settings', 'quick-top' ); ?></p>
                        <h1 class="qt-title">Quick Top and WP Dark Mode</h1>
                        <p class="qt-subtitle">Scroll to top and full-site dark mode, tuned in one place.</p>
                    </div>
                </div>
                <div class="qt-hero__meta">
                    <span class="qt-pill <?php echo $scroll_on ? 'is-on' : ''; ?>">
                        <span class="qt-pill__dot"></span>
                        Scroll <?php echo $scroll_on ? 'On' : 'Off'; ?>
                    </span>
                    <span class="qt-pill <?php echo $dark_on ? 'is-on' : ''; ?>">
                        <span class="qt-pill__dot"></span>
                        Dark Mode <?php echo $dark_on ? 'On' : 'Off'; ?>
                    </span>
                </div>
            </header>

            <div class="qt-layout">
                <form id="quick_top_live_preview" method="post" action="options.php" class="qt-panel qt-settings">
                    <?php settings_fields( 'quick_top_settings_group' ); ?>

                    <nav class="qt-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Quick Top and WP Dark Mode settings', 'quick-top' ); ?>">
                        <button type="button" class="qt-tab is-active" data-qt-tab="scroll" role="tab" aria-selected="true">
                            <i class="fa fa-arrow-up" aria-hidden="true"></i>
                            Scroll Button
                        </button>
                        <button type="button" class="qt-tab" data-qt-tab="dark" role="tab" aria-selected="false">
                            <i class="fa fa-moon" aria-hidden="true"></i>
                            Dark Mode
                        </button>
                    </nav>

                    <div class="qt-tab-panels">
                        <section class="qt-tab-panel is-active" data-qt-panel="scroll" role="tabpanel">
                            <div class="qt-section-head">
                                <h2>Scroll Button</h2>
                                <p>Shape, color, and when the back-to-top control appears.</p>
                            </div>
                            <table class="form-table qt-form-table" role="presentation">
                                <?php do_settings_fields( 'quick-top-settings', 'quick_top_main_section' ); ?>
                            </table>
                        </section>

                        <section class="qt-tab-panel" data-qt-panel="dark" role="tabpanel" hidden>
                            <div class="qt-section-head">
                                <h2>Dark Mode</h2>
                                <p>Flip the whole frontend to dark and let visitors switch back.</p>
                            </div>
                            <table class="form-table qt-form-table" role="presentation">
                                <?php do_settings_fields( 'quick-top-settings', 'quick_top_dark_mode_section' ); ?>
                            </table>
                        </section>
                    </div>

                    <div class="qt-actions">
                        <?php submit_button( 'Save Changes', 'primary qt-save', 'submit', false ); ?>
                        <span class="qt-actions__hint">Changes apply on the next page load.</span>
                    </div>
                </form>

                <aside class="qt-panel qt-preview">
                    <div class="qt-preview__head">
                        <h2>Live Preview</h2>
                        <p>Updates as you edit the scroll button.</p>
                    </div>
                    <div class="qt-preview__stage">
                        <div class="qt-preview__chrome">
                            <span></span><span></span><span></span>
                        </div>
                        <div class="qt-preview__canvas">
                            <div class="qt-preview__lines" aria-hidden="true">
                                <span></span><span></span><span></span>
                            </div>
                            <div id="quick-top-preview" style="<?php echo esc_attr( $preview_styles ); ?>">
                                <?php echo quick_top_get_icon_markup( $options ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        </div>
                    </div>
                    <ul class="qt-preview__notes">
                        <li>Icon, custom PNG/SVG, colors, size, and radius sync live.</li>
                        <li>Dark mode is controlled from the Dark Mode tab.</li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
    <?php
}

function quick_top_register_settings() {
    register_setting( 'quick_top_settings_group', 'quick_top_settings' );

    add_settings_section(
        'quick_top_main_section',
        'Main Settings',
        'quick_top_main_section_callback',
        'quick-top-settings'
    );

    add_settings_field(
        'quick_top_enable',
        'Enable',
        'quick_top_enable_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );

    add_settings_field(
        'quick_top_border_radius',
        'Border Radius',
        'quick_top_border_radius_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );

    add_settings_field(
        'quick_top_mobile_enable',
        'Enable on Mobile',
        'quick_top_mobile_enable_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );

    add_settings_field(
        'quick_top_icon',
        'Icon',
        'quick_top_icon_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_custom_icon',
        'Custom Icon',
        'quick_top_custom_icon_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_icon_color',
        'Icon Color',
        'quick_top_icon_color_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_icon_bg_color',
        'Icon Background Color',
        'quick_top_icon_bg_color_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_icon_size',
        'Icon Size',
        'quick_top_icon_size_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_bg_width',
        'Background Width',
        'quick_top_bg_width_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_bg_height',
        'Background Height',
        'quick_top_bg_height_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_padding',
        'Padding',
        'quick_top_padding_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_margin',
        'Margin',
        'quick_top_margin_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_position',
        'Position',
        'quick_top_position_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );
    add_settings_field(
        'quick_top_scroll_distance',
        'Scroll Distance',
        'quick_top_scroll_distance_callback',
        'quick-top-settings',
        'quick_top_main_section'
    );

    add_settings_section(
        'quick_top_dark_mode_section',
        'WP Dark Mode',
        'quick_top_dark_mode_section_callback',
        'quick-top-settings'
    );

    add_settings_field(
        'quick_top_dark_mode_enabled',
        'Enable Dark Mode',
        'quick_top_dark_mode_enabled_callback',
        'quick-top-settings',
        'quick_top_dark_mode_section'
    );

    add_settings_field(
        'quick_top_dark_mode_default',
        'Default Mode',
        'quick_top_dark_mode_default_callback',
        'quick-top-settings',
        'quick_top_dark_mode_section'
    );

    add_settings_field(
        'quick_top_dark_mode_toggle',
        'Show Frontend Toggle',
        'quick_top_dark_mode_toggle_callback',
        'quick-top-settings',
        'quick_top_dark_mode_section'
    );

    add_settings_field(
        'quick_top_dark_mode_toggle_position',
        'Toggle Button Position',
        'quick_top_dark_mode_toggle_position_callback',
        'quick-top-settings',
        'quick_top_dark_mode_section'
    );
}
add_action( 'admin_init', 'quick_top_register_settings' );

function quick_top_main_section_callback() {
    echo 'Customize your Quick Top scroll button.';
}

function quick_top_enable_callback() {
    $options = quick_top_get_settings();
    ?>
    <label class="switch">
        <input type="checkbox" name="quick_top_settings[enabled]" value="1" <?php checked( 1, (int) $options['enabled'] ); ?>>
        <span class="slider round"></span>
    </label>
    <?php
}

function quick_top_border_radius_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[border_radius]" value="<?php echo esc_attr( $options['border_radius'] ); ?>" min="0" max="50">
    <span>px</span>
    <?php
}

function quick_top_mobile_enable_callback() {
    $options = quick_top_get_settings();
    ?>
    <label class="switch">
        <input type="checkbox" name="quick_top_settings[mobile_enabled]" value="1" <?php checked( 1, (int) $options['mobile_enabled'] ); ?>>
        <span class="slider round"></span>
    </label>
    <?php
}

function quick_top_get_custom_icon_url( $options = null ) {
    if ( null === $options ) {
        $options = quick_top_get_settings();
    }

    $icon_id = isset( $options['custom_icon_id'] ) ? absint( $options['custom_icon_id'] ) : 0;
    if ( $icon_id ) {
        $url = wp_get_attachment_url( $icon_id );
        if ( $url ) {
            return $url;
        }
    }

    return ! empty( $options['custom_icon_url'] ) ? esc_url_raw( $options['custom_icon_url'] ) : '';
}

function quick_top_get_icon_markup( $options = null ) {
    if ( null === $options ) {
        $options = quick_top_get_settings();
    }

    $custom_url = quick_top_get_custom_icon_url( $options );
    $icon_size  = isset( $options['icon_size'] ) ? absint( $options['icon_size'] ) : 24;

    if ( $custom_url ) {
        return sprintf(
            '<img class="quick-top-custom-icon" src="%1$s" alt="" width="%2$d" height="%2$d" decoding="async" />',
            esc_url( $custom_url ),
            max( 10, $icon_size )
        );
    }

    $icon = ! empty( $options['icon'] ) ? $options['icon'] : 'fa-arrow-up';
    return '<i class="fa ' . esc_attr( $icon ) . '" aria-hidden="true"></i>';
}

function quick_top_icon_callback() {
    $options = quick_top_get_settings();
    ?>
    <select name="quick_top_settings[icon]" id="quick_top_icon_select">
        <option value="fa-arrow-up" <?php selected( $options['icon'], 'fa-arrow-up' ); ?>>Arrow Up</option>
        <option value="fa-arrow-down" <?php selected( $options['icon'], 'fa-arrow-down' ); ?>>Arrow Down</option>
        <option value="fa-arrow-left" <?php selected( $options['icon'], 'fa-arrow-left' ); ?>>Arrow Left</option>
        <option value="fa-arrow-right" <?php selected( $options['icon'], 'fa-arrow-right' ); ?>>Arrow Right</option>
        <option value="fa-chevron-up" <?php selected( $options['icon'], 'fa-chevron-up' ); ?>>Chevron Up</option>
        <option value="fa-chevron-down" <?php selected( $options['icon'], 'fa-chevron-down' ); ?>>Chevron Down</option>
        <option value="fa-chevron-left" <?php selected( $options['icon'], 'fa-chevron-left' ); ?>>Chevron Left</option>
        <option value="fa-chevron-right" <?php selected( $options['icon'], 'fa-chevron-right' ); ?>>Chevron Right</option>
    </select>
    <p class="description"><?php esc_html_e( 'Used when no custom PNG/SVG is uploaded.', 'quick-top' ); ?></p>
    <?php
}

function quick_top_custom_icon_callback() {
    $options    = quick_top_get_settings();
    $icon_id    = isset( $options['custom_icon_id'] ) ? absint( $options['custom_icon_id'] ) : 0;
    $icon_url   = quick_top_get_custom_icon_url( $options );
    $has_custom = ! empty( $icon_url );
    ?>
    <div class="qt-media-field" data-qt-media>
        <input type="hidden" name="quick_top_settings[custom_icon_id]" id="quick_top_custom_icon_id" value="<?php echo esc_attr( $icon_id ); ?>">
        <input type="hidden" name="quick_top_settings[custom_icon_url]" id="quick_top_custom_icon_url" value="<?php echo esc_attr( $icon_url ); ?>">

        <div class="qt-media-preview<?php echo $has_custom ? ' has-image' : ''; ?>" id="quick_top_custom_icon_preview">
            <?php if ( $has_custom ) : ?>
                <img src="<?php echo esc_url( $icon_url ); ?>" alt="">
            <?php else : ?>
                <span class="qt-media-placeholder"><?php esc_html_e( 'No custom icon', 'quick-top' ); ?></span>
            <?php endif; ?>
        </div>

        <div class="qt-media-actions">
            <button type="button" class="button qt-media-upload" id="quick_top_upload_icon">
                <?php echo $has_custom ? esc_html__( 'Replace Icon', 'quick-top' ) : esc_html__( 'Upload PNG / SVG', 'quick-top' ); ?>
            </button>
            <button type="button" class="button-link qt-media-remove<?php echo $has_custom ? '' : ' is-hidden'; ?>" id="quick_top_remove_icon">
                <?php esc_html_e( 'Remove', 'quick-top' ); ?>
            </button>
        </div>
        <p class="description"><?php esc_html_e( 'Upload a PNG or SVG. Custom icon overrides the Font Awesome icon above.', 'quick-top' ); ?></p>
    </div>
    <?php
}

function quick_top_icon_color_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="color" name="quick_top_settings[icon_color]" value="<?php echo esc_attr( $options['icon_color'] ); ?>">
    <?php
}

function quick_top_icon_bg_color_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="color" name="quick_top_settings[icon_bg_color]" value="<?php echo esc_attr( $options['icon_bg_color'] ); ?>">
    <?php
}

function quick_top_icon_size_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[icon_size]" value="<?php echo esc_attr( $options['icon_size'] ); ?>" min="10" max="100">
    <?php
}

function quick_top_bg_width_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[bg_width]" value="<?php echo esc_attr( $options['bg_width'] ); ?>" min="10" max="500">
    <?php
}

function quick_top_bg_height_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[bg_height]" value="<?php echo esc_attr( $options['bg_height'] ); ?>" min="10" max="500">
    <?php
}

function quick_top_padding_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[padding]" value="<?php echo esc_attr( $options['padding'] ); ?>" min="0" max="100">
    <?php
}

function quick_top_margin_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[margin_top]" placeholder="Top" value="<?php echo esc_attr( $options['margin_top'] ); ?>" min="0" max="100">
    <input type="number" name="quick_top_settings[margin_right]" placeholder="Right" value="<?php echo esc_attr( $options['margin_right'] ); ?>" min="0" max="100">
    <input type="number" name="quick_top_settings[margin_bottom]" placeholder="Bottom" value="<?php echo esc_attr( $options['margin_bottom'] ); ?>" min="0" max="100">
    <input type="number" name="quick_top_settings[margin_left]" placeholder="Left" value="<?php echo esc_attr( $options['margin_left'] ); ?>" min="0" max="100">
    <?php
}

function quick_top_position_callback() {
    $options = quick_top_get_settings();
    ?>
    <select name="quick_top_settings[position]">
        <option value="bottom-right" <?php selected( $options['position'], 'bottom-right' ); ?>>Bottom Right</option>
        <option value="bottom-left" <?php selected( $options['position'], 'bottom-left' ); ?>>Bottom Left</option>
        <option value="top-right" <?php selected( $options['position'], 'top-right' ); ?>>Top Right</option>
        <option value="top-left" <?php selected( $options['position'], 'top-left' ); ?>>Top Left</option>
    </select>
    <?php
}

function quick_top_scroll_distance_callback() {
    $options = quick_top_get_settings();
    ?>
    <input type="number" name="quick_top_settings[scroll_distance]" value="<?php echo esc_attr( $options['scroll_distance'] ); ?>" min="0" max="1000">
    <?php
}

function quick_top_dark_mode_section_callback() {
    echo 'Turn the entire website into dark mode. Visitors can also switch using the floating toggle.';
}

function quick_top_dark_mode_enabled_callback() {
    $options = quick_top_get_settings();
    ?>
    <label class="switch">
        <input type="checkbox" name="quick_top_settings[dark_mode_enabled]" value="1" <?php checked( 1, (int) $options['dark_mode_enabled'] ); ?>>
        <span class="slider round"></span>
    </label>
    <p class="description">When enabled, the whole frontend site can switch to dark mode.</p>
    <?php
}

function quick_top_dark_mode_default_callback() {
    $options = quick_top_get_settings();
    ?>
    <select name="quick_top_settings[dark_mode_default]">
        <option value="light" <?php selected( $options['dark_mode_default'], 'light' ); ?>>Light</option>
        <option value="dark" <?php selected( $options['dark_mode_default'], 'dark' ); ?>>Dark</option>
        <option value="system" <?php selected( $options['dark_mode_default'], 'system' ); ?>>Follow System</option>
    </select>
    <p class="description">Used when a visitor has not chosen a preference yet.</p>
    <?php
}

function quick_top_dark_mode_toggle_callback() {
    $options = quick_top_get_settings();
    ?>
    <label class="switch">
        <input type="checkbox" name="quick_top_settings[dark_mode_toggle]" value="1" <?php checked( 1, (int) $options['dark_mode_toggle'] ); ?>>
        <span class="slider round"></span>
    </label>
    <p class="description">Show a moon/sun button so visitors can toggle dark mode.</p>
    <?php
}

function quick_top_dark_mode_toggle_position_callback() {
    $options = quick_top_get_settings();
    ?>
    <select name="quick_top_settings[dark_mode_toggle_position]">
        <option value="bottom-left" <?php selected( $options['dark_mode_toggle_position'], 'bottom-left' ); ?>>Bottom Left</option>
        <option value="bottom-right" <?php selected( $options['dark_mode_toggle_position'], 'bottom-right' ); ?>>Bottom Right</option>
        <option value="top-left" <?php selected( $options['dark_mode_toggle_position'], 'top-left' ); ?>>Top Left</option>
        <option value="top-right" <?php selected( $options['dark_mode_toggle_position'], 'top-right' ); ?>>Top Right</option>
    </select>
    <?php
}
?>
