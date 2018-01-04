=== UCF Social Plugin ===
Contributors: ucfwebcom
Tags: ucf, social
Requires at least: 4.7.3
Tested up to: 4.7.3
Stable tag: 1.0.5
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides a shortcode, functions, and default styles for displaying UCF social assets.


== Description ==

This plugin provides a shortcode, helper functions, and default styles for displaying social assets.  It is written to work out-of-the-box for non-programmers, but is also extensible and customizable for developers.


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

= 1.0.6 =
Bug Fix:
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
