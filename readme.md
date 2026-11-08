# Quick Top and WP Dark Mode

**Version:** 1.4.0  
**Author:** [Tanvir Hasan](https://profiles.wordpress.org/tanvirh/)  
**Requires WordPress:** 6.4+  
**Tested up to:** WordPress 7.1  
**Requires PHP:** 7.4+  
**License:** GPLv2 or later

A WordPress plugin that adds a fully customizable **Back to Top** button and a complete **site-wide Dark Mode** experience — managed from one modern settings screen.

---

## Features

### 1. Scroll to Top Button
Add a floating back-to-top control that appears after visitors scroll down.

- Enable / disable anytime
- Control **scroll distance** before the button shows
- Position in any corner:
  - Bottom Right
  - Bottom Left
  - Top Right
  - Top Left
- Customize:
  - Icon color
  - Background color
  - Icon size
  - Button width & height
  - Padding
  - Margin (top / right / bottom / left)
  - Border radius
- Show or hide on **mobile**

### 2. Custom Icon Upload (PNG / SVG)
Use your own brand icon instead of only presets.

- Upload **PNG** or **SVG** from the Media Library
- Replace or remove anytime
- Custom icon **overrides** Font Awesome icons
- Live preview updates immediately

### 3. Built-in Font Awesome Icons
If no custom file is uploaded, choose from:

- Arrow Up / Down / Left / Right
- Chevron Up / Down / Left / Right

### 4. Live Preview
Design the button without guessing.

- Instant preview for icon, custom image, colors, size, and radius
- Mini browser-style preview stage
- Faster visual tuning before saving

### 5. WP Dark Mode
Turn the entire frontend website dark with one setting.

- Enable / disable site-wide dark mode
- Default mode options:
  - **Light**
  - **Dark**
  - **Follow System**
- Optional floating **moon / sun** toggle for visitors
- Toggle position in any corner
- Visitor preference saved in browser `localStorage`
- Applies across the whole page (theme UI included)
- Media (images/videos) stay visually natural

### 6. Modern Admin Settings UI
A clean, tabbed settings experience:

- **Scroll Button** tab
- **Dark Mode** tab
- Status pills for Scroll On/Off and Dark Mode On/Off
- Soft modern layout with focused controls

---

## Perfect For

- Long-form blogs and content sites
- WooCommerce / Dokan stores
- Brands that want a custom scroll icon
- Sites that need visitor-friendly dark browsing

---

## Installation

1. Upload the `quick-top` folder to `/wp-content/plugins/`, **or** install via **Plugins → Add New**.
2. Activate **Quick Top and WP Dark Mode**.
3. Open **Quick Top** from the WordPress admin menu.
4. Configure the **Scroll Button** and **Dark Mode** tabs.
5. Click **Save Changes**.

---

## Quick Start

### Set up the Back to Top button
1. Go to **Quick Top → Scroll Button**
2. Turn **Enable** on
3. Choose an icon **or** upload a custom PNG/SVG
4. Adjust colors, size, position, and scroll distance
5. Save

### Set up Dark Mode
1. Go to **Quick Top → Dark Mode**
2. Turn **Enable Dark Mode** on
3. Choose default mode (Light / Dark / Follow System)
4. Optionally enable the frontend toggle
5. Save, then visit your site and use the moon/sun button

---

## Frequently Asked Questions

### Can I upload my own icon?
Yes. Use **Custom Icon** to upload a PNG or SVG. It replaces the Font Awesome icon.

### Does Dark Mode work with any theme?
It is designed to work across most WordPress themes and page builders by applying a full-frontend dark treatment.

### Can visitors toggle dark mode themselves?
Yes. Enable **Show Frontend Toggle**. Their choice is remembered for later visits.

### Can I hide the scroll button on mobile?
Yes. Disable **Enable on Mobile**.

### Where are the settings?
In the admin sidebar under **Quick Top**.

---

## Changelog

### 1.4.0
- Refreshed WordPress.org banner, icon, and screenshots
- Added GitHub Actions deploy so publishing a GitHub Release updates WordPress.org
- Confirmed packaging for future automated releases

### 1.3.1
- Confirmed compatibility with WordPress 7.1.x
- Updated plugin headers (`Requires at least`, `Requires PHP`, `Domain Path`)
- Added modern `register_setting` sanitize callback
- Load front-end assets only when features are enabled
- Use deferred script loading strategy where supported

### 1.3.0
- Added custom PNG/SVG icon upload for the scroll button
- Custom icons override Font Awesome presets
- Improved frontend button markup and scroll behavior
- Allowed SVG uploads for administrators

### 1.2.2
- Renamed plugin to Quick Top and WP Dark Mode
- Updated branding across settings and documentation

### 1.2.0
- Redesigned modern settings page with tabs and live preview
- Improved admin UI layout and status indicators

### 1.1.0
- Added full-site WP Dark Mode
- Added frontend moon/sun toggle with saved preference
- Added Light / Dark / Follow System defaults

### 1.0.0
- Initial release with customizable scroll-to-top button

---

## Support

Author profile: [Tanvir Hasan on WordPress.org](https://profiles.wordpress.org/tanvirh/)
