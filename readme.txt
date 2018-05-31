=== UCF Social Plugin ===
Contributors: ucfwebcom
Tags: ucf, social
Requires at least: 4.7.3
Tested up to: 4.9.6
Stable tag: 3.0.1
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides a shortcode, functions, and default styles for displaying UCF social assets.


== Description ==

This plugin provides shortcodes and default styles for displaying social icons, sharing links, and social feeds via Curator.io.  It is written to work out-of-the-box for non-programmers, but is also extensible and customizable for developers.


== Installation ==

= Manual Installation =
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "Settings > UCF Social".

= WP CLI Installation =
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Social-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "Settings > UCF Social".

== Dependencies ==

* Athena-Framework or Bootstrap 4
* FontAwesome

== Changelog ==

= 3.0.1 =
Enhancements:
- Reordered the social-icons order.

= 3.0.0 =
Enhancements:
- Refactored how social feed widgets are generated via the `[ucf-social-feed]` shortcode, and how customization options are applied to them.
  - Customization options for feeds will now be fetched from Curator directly if a Curator API key is set in the plugin's settings.
  - Individual widget settings can still be overridden using the new `options_file` shortcode attribute, and settings in the provided JSON file will take precedence over settings fetched from Curator.  The `options_file` attribute will accept either an attachment ID or a direct URL to a JSON file.  See <a href="https://github.com/curatorio/widgets#widget-options">Curator's widget documentation</a> for information on how to structure options.
  - Added the new `type` attribute to replace what we were using previously on the `layout` attribute (for defining whether the widget should be "Waterfall", "Grid", etc). The `layout` attribute should now be used for overrides to how widget markup is generated, but we've added some backward compatibility for existing shortcodes that still use the `layout` attribute for this.
  - 3 new layouts have been added: `scrollbox`, `scrollbox_sm`, and `scrollbox_lg`, which wrap the generated widget in a scrollable `div` at larger screen widths.
- Added the ability to specify a default feed ID, feed type, and widget version in plugin settings.  Curator widget CSS/JS is now enqueued based on the widget version specified.
- Added a transient flush button to the plugin settings page, which will flush and re-fetch cached Curator feed customization data from Curator's API.
- Added basic compatibility with the WP Shortcode Interface plugin.

Breaking changes:
- The `grid-rows` and `grid-width` shortcode attributes on `[ucf-social-feed]` have been *removed*.  You should now apply these overrides within Curator directly or by using the new `options_file` attribute.

= 2.1.0 =
Enhancements:
- Added plugin options and attributes to the `[ucf-social-links]` shortcode that allow you to specify what social sharing links you'd like to include/exclude.  For backward compatibility, Facebook, Twitter, and Google+ are enabled by default.
- Added LinkedIn and Email link options for `[ucf-social-links]`
- Split existing plugins options out into grouped sections
- Removed unused shortcode attr formatting hook + method (`UCF_Social_Config::format_sc_atts()`)

= 2.0.0 =
Enhancements:
- Adds a non-nested layout system for all shortcodes.  All shortcodes now support the 'layout' attribute, and all have a standard 'default' layout.  All `before` and `after` layout parts can now be overridden via hooks.
- Re-organized layout functions and styles into separate files.
- Added `permalink` and `share_text` attributes to the [ucf-social-links] shortcode, which allow you to specify a custom URL that should be shared (in lieu of the current global `$post`'s permalink), and adjust the contents of a generated tweet message, respectively.
- Updated markup for social links to add `aria-hidden` to FA icons, genericize the share titles for each button ("share this content" vs "share this story"), and wrap the inner text of each button in a span (`.btn-text`) to make it easier to apply style overrides.

Bug fixes:
- Updated all layout functions to _return_ instead of _echo_ their results
- Fixed duplicate ID issue with the social feed shortcode's generated placeholder div by implementing a unique ID by default (using `wp_rand()`)
- Fixed `has_filter()` checks in includes/ucf-social-common.php that all checked the same set of filters (instead of shortcode-specific filters)

Breaking changes:

Because this version removes existing functions and hooks, it is tagged with a major version bump; however, you should be able to seamlessly upgrade to this version from 1.0.7 as long as you weren't utilizing any of those functions/hooks directly.  See list below for a list of what's been removed.

Removed/renamed functions:
- `ucf_social_icons_display_before()` -> `ucf_social_icons_display_default_before()`
- `ucf_social_icons_display()` -> `ucf_social_icons_display_default()`
- `ucf_social_icons_display_after()` -> `ucf_social_icons_display_default_after()`
- `ucf_social_links_display_before()` -> `ucf_social_links_display_default_before()`
- `ucf_social_links_display()` -> `ucf_social_links_display_default()`
- `ucf_social_links_display_after()` -> `ucf_social_links_display_default_after()`
- `ucf_social_feed_display_before()` -> `ucf_social_feed_display_default_before()`
- `ucf_social_feed_display()` -> `ucf_social_feed_display_default()`
- `ucf_social_feed_display_after()` -> `ucf_social_feed_display_default_after()`

Removed hooks:
- `ucf_social_display_before` (use shortcode-specific `before` hook instead)
- `ucf_social_display` (use shortcode-specific hook instead)
- `ucf_social_display_after` (use shortcode-specific `after` hook instead)

= 1.0.7 =
Bug Fixes:
* Fixed potential issues with `do_shortcode()` call in `UCF_Social_Common::has_social_feed()` by wrapping it within an output buffer to ensure all returned contents are captured/not echoed when called in `ucf_social_enqueued_assets`.

= 1.0.6 =
Enhancements:
* Added logic to lazy load social feeds

= 1.0.5 =
Bug Fix:
* Added back logic to include the social css

= 1.0.4 =
Enhancements:
* Added social feed shortcode

= 1.0.3 =
Enhancements:
* Added margin-bottom to social link buttons to accommodate vertical stacking
* Added missing plugin description

= 1.0.2 =
* Bug Fixes.

= 1.0.1 =
* Fixed shortcode output buffering issues.

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Installation Requirements ==

None


== Development & Contributing ==

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.
