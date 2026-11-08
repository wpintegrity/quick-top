jQuery(document).ready(function($) {
    // Keep third-party promo banners out of the QuickTop UI.
    function scrubForeignNotices() {
        var selectors = [
            '.dokan-admin-notice',
            '.dokan-message',
            '[class*="black-friday"]',
            '[class*="bfcm"]',
            '.qt-admin .notice:not(.settings-error)',
            '.qt-shell > .notice',
            '.qt-hero + .notice',
            '.qt-hero .notice'
        ];

        $(selectors.join(',')).each(function() {
            var $el = $(this);
            if ($el.closest('.qt-settings').length) {
                return;
            }
            $el.remove();
        });
    }

    scrubForeignNotices();
    setTimeout(scrubForeignNotices, 300);
    setTimeout(scrubForeignNotices, 1200);

    var $form = $('#quick_top_live_preview');
    var $preview = $('#quick-top-preview');
    var mediaFrame = null;

    function getSetting(name, fallback) {
        var $field = $form.find('[name="quick_top_settings[' + name + ']"]');

        if (!$field.length) {
            return fallback;
        }

        if ($field.is(':checkbox')) {
            return $field.is(':checked') ? $field.val() : '';
        }

        var value = $field.val();
        return (value === undefined || value === null || value === '') ? fallback : value;
    }

    function withUnit(value, unit) {
        if (value === '' || value === null || value === undefined) {
            return '';
        }
        return String(value) + unit;
    }

    function updateLivePreview() {
        var icon = getSetting('icon', 'fa-arrow-up');
        var customUrl = getSetting('custom_icon_url', '');
        var bgColor = getSetting('icon_bg_color', '#000000');
        var iconColor = getSetting('icon_color', '#ffffff');
        var iconSize = getSetting('icon_size', '24');
        var bgWidth = getSetting('bg_width', '50');
        var bgHeight = getSetting('bg_height', '50');
        var padding = getSetting('padding', '10');
        var borderRadius = getSetting('border_radius', '50');
        var marginTop = getSetting('margin_top', '0');
        var marginRight = getSetting('margin_right', '0');
        var marginBottom = getSetting('margin_bottom', '0');
        var marginLeft = getSetting('margin_left', '0');

        $preview.css({
            'background-color': bgColor,
            'color': iconColor,
            'font-size': withUnit(iconSize, 'px'),
            'width': withUnit(bgWidth, 'px'),
            'height': withUnit(bgHeight, 'px'),
            'padding': withUnit(padding, 'px'),
            'margin-top': withUnit(marginTop, 'px'),
            'margin-right': withUnit(marginRight, 'px'),
            'margin-bottom': withUnit(marginBottom, 'px'),
            'margin-left': withUnit(marginLeft, 'px'),
            'border-radius': withUnit(borderRadius, 'px'),
            'box-sizing': 'border-box',
            'display': 'inline-flex',
            'align-items': 'center',
            'justify-content': 'center'
        });

        if (customUrl) {
            $preview.html(
                '<img class="quick-top-custom-icon" src="' + customUrl + '" alt="" style="width:' + iconSize + 'px;height:' + iconSize + 'px;object-fit:contain;display:block;" />'
            );
        } else {
            $preview.html('<i class="fa ' + icon + '" aria-hidden="true"></i>');
        }
    }

    function setCustomIcon(id, url) {
        $('#quick_top_custom_icon_id').val(id || '');
        $('#quick_top_custom_icon_url').val(url || '');

        var $previewBox = $('#quick_top_custom_icon_preview');
        var $remove = $('#quick_top_remove_icon');
        var $upload = $('#quick_top_upload_icon');

        if (url) {
            $previewBox.addClass('has-image').html('<img src="' + url + '" alt="">');
            $remove.removeClass('is-hidden');
            $upload.text('Replace Icon');
        } else {
            $previewBox.removeClass('has-image').html('<span class="qt-media-placeholder">No custom icon</span>');
            $remove.addClass('is-hidden');
            $upload.text('Upload PNG / SVG');
        }

        updateLivePreview();
    }

    function openMediaLibrary() {
        if (typeof wp === 'undefined' || !wp.media) {
            return;
        }

        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        mediaFrame = wp.media({
            title: 'Select or upload icon',
            button: { text: 'Use this icon' },
            library: { type: ['image', 'image/svg+xml'] },
            multiple: false
        });

        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            var url = attachment.url || '';
            var mime = (attachment.mime || '').toLowerCase();
            var filename = (attachment.filename || url).toLowerCase();
            var ok = mime.indexOf('image/') === 0 || filename.indexOf('.svg') !== -1 || filename.indexOf('.png') !== -1;

            if (!ok) {
                window.alert('Please upload a PNG or SVG icon.');
                return;
            }

            setCustomIcon(attachment.id, url);
        });

        mediaFrame.open();
    }

    function switchTab(tabName) {
        var $tabs = $('.qt-tab');
        var $panels = $('.qt-tab-panel');

        $tabs.removeClass('is-active').attr('aria-selected', 'false');
        $panels.removeClass('is-active').attr('hidden', true);

        $tabs.filter('[data-qt-tab="' + tabName + '"]').addClass('is-active').attr('aria-selected', 'true');
        $panels.filter('[data-qt-panel="' + tabName + '"]').addClass('is-active').removeAttr('hidden');
    }

    $form.on('input change', 'input, select', updateLivePreview);
    $('#quick_top_upload_icon').on('click', openMediaLibrary);
    $('#quick_top_remove_icon').on('click', function(e) {
        e.preventDefault();
        setCustomIcon('', '');
    });
    $('.qt-tab').on('click', function() {
        switchTab($(this).data('qt-tab'));
    });

    updateLivePreview();
});
