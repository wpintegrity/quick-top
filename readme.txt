=== Quick Top and WP Dark Mode ===
Contributors: tanvirh
Author: Tanvir Hasan
Author URI: https://profiles.wordpress.org/tanvirh/
Donate link: https://profiles.wordpress.org/tanvirh/
Tags: scroll to top, back to top, dark mode, night mode, custom icon, svg, png, floating button
Requires at least: 6.4
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.4.0
Version: 1.4.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://wordpress.org/plugins/quick-top

A customizable back-to-top button with custom PNG/SVG icons, live preview, and full-site WP Dark Mode for WordPress.

== Description ==

**Quick Top and WP Dark Mode** helps visitors move around your site faster and browse more comfortably at night.

It gives you a fully customizable floating **Back to Top** button and a complete **site-wide Dark Mode** experience. Everything is managed from one modern settings screen with live preview.

= Scroll to Top Button =

Add a floating back-to-top control that appears after visitors scroll down the page.

* Enable or disable the button anytime
* Choose when it appears with scroll distance
* Pick corner position: bottom-right, bottom-left, top-right, or top-left
* Control size, padding, margin, and border radius
* Customize icon color and background color
* Enable or hide the button on mobile devices

= Custom Icons (PNG / SVG) =

Upload your own branding icon instead of using only presets.

* Upload PNG or SVG from the WordPress Media Library
* Replace or remove the custom icon anytime
* Custom icon overrides the built-in Font Awesome icon
* Live preview updates instantly when you change the icon

= Built-in Font Awesome Icons =

If you do not upload a custom file, choose from ready-made icons:

* Arrow Up / Down / Left / Right
* Chevron Up / Down / Left / Right

= Live Preview =

See button style changes before saving.

* Icon, custom image, colors, size, and radius update live
* Preview panel mimics a mini browser stage
* Saves time while designing the perfect button look

= WP Dark Mode =

Turn your entire frontend website into a dark theme with one toggle.

* Enable or disable Dark Mode site-wide
* Choose default mode: Light, Dark, or Follow System
* Show a floating moon/sun toggle for visitors
* Place the dark-mode toggle in any corner
* Remembers visitor preference in browser local storage
* Applies dark mode across the whole page, including theme UI

= Modern Admin Settings =

A clean, tabbed settings experience:

* **Scroll Button** tab for back-to-top controls
* **Dark Mode** tab for night-mode options
* Status pills show whether Scroll and Dark Mode are On/Off
* Designed for fast setup without clutter

= Perfect For =

* Blogs and content sites with long pages
* WooCommerce / Dokan stores
* Brands that want a custom scroll icon
* Sites that need a visitor-friendly dark theme

== Installation ==

1. Upload the `quick-top` folder to `/wp-content/plugins/`, or install via **Plugins → Add New**.
2. Activate **Quick Top and WP Dark Mode** from the Plugins screen.
3. Go to **Quick Top** in the WordPress admin menu.
4. Configure the **Scroll Button** and **Dark Mode** tabs.
5. Click **Save Changes**.

== Frequently Asked Questions ==

= Can I upload my own icon? =

Yes. Use the **Custom Icon** field to upload a PNG or SVG. That custom file will replace the Font Awesome icon.

= Does Dark Mode work with any theme? =

Yes. Dark Mode is applied across the frontend so it works with most WordPress themes and page builders. Images and media are handled so they stay visually natural.

= Can visitors turn dark mode on and off? =

Yes. Enable **Show Frontend Toggle** and visitors get a floating moon/sun button. Their choice is remembered for later visits.

= Can I hide the scroll button on mobile? =

Yes. Turn off **Enable on Mobile** in the Scroll Button settings.

= Where do I find the settings? =

Open **Quick Top** from the left admin menu.

== Screenshots ==

1. Scroll Button settings with live preview
2. Dark Mode settings tab
3. Frontend dark mode with floating toggle
4. Frontend light mode with back-to-top and dark mode controls

== Changelog ==

= 1.4.0 =
* Refreshed WordPress.org banner, icon, and screenshots
* Added GitHub Actions deploy so publishing a GitHub Release updates WordPress.org
* Confirmed packaging for future automated releases

= 1.3.1 =
* Confirmed compatibility with WordPress 7.1.x
* Updated plugin headers (Requires at least, Requires PHP, Domain Path)
* Added modern register_setting sanitize callback
* Load front-end assets only when features are enabled
* Use deferred script loading strategy where supported

= 1.3.0 =
* Added custom PNG/SVG icon upload for the scroll button
* Custom icons override Font Awesome presets
* Improved frontend button markup and scroll behavior
* Allowed SVG uploads for administrators

= 1.2.2 =
* Renamed plugin to Quick Top and WP Dark Mode
* Updated branding across settings and documentation

= 1.2.0 =
* Redesigned modern settings page with tabs and live preview
* Improved admin UI layout and status indicators

= 1.1.0 =
* Added full-site WP Dark Mode
* Added frontend moon/sun toggle with saved preference
* Added Light / Dark / Follow System defaults

= 1.0.0 =
* Initial release with customizable scroll-to-top button

== Upgrade Notice ==

= 1.4.0 =
Branding update with new banner, icon, and screenshots. Future releases deploy from GitHub to WordPress.org.

= 1.3.1 =
Compatibility update for the latest WordPress 7.1 release, with safer settings sanitization and conditional asset loading.

= 1.3.0 =
Adds custom PNG/SVG icon upload for the Quick Top button, plus improved frontend behavior.
