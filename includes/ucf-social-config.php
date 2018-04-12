<?php
/**
 * Handles plugin configuration
 */

if ( !class_exists( 'UCF_Social_Config' ) ) {

	class UCF_Social_Config {
		public static
			$option_prefix = 'ucf_social_',
			$option_defaults = array(
				'include_css' => true,
				'facebook_url' => '',
				'twitter_url' => '',
				'google_url' => '',
				'linkedin_url' => '',
				'instagram_url' => '',
				'youtube_url' => '',
				'include_facebook_sharing' => true,
				'include_twitter_sharing' => true,
				'include_google_sharing' => true,
				'include_linkedin_sharing' => false,
				'include_email_sharing' => false,
				'curator_default_feed' => '',
				'curator_default_type' => 'Waterfall',
				'curator_api_key' => '',
				'curator_widget_version' => '3.1'
			),
			$curator_data_transient = 'ucf_social_curator_api_data';

		public static function get_social_icon_layouts() {
			$layouts = array(
				'default' => 'Default Layout',
			);
			$layouts = apply_filters( self::$option_prefix . 'get_social_icon_layouts', $layouts );
			return $layouts;
		}

		public static function get_social_icon_colors() {
			$options = array(
				'color' => 'Color',
				'grey'  => 'Grey'
			);
			$options = apply_filters( self::$option_prefix . 'get_social_icon_colors', $options );
			return $options;
		}

		public static function get_social_icon_sizes() {
			$options = array(
				'sm' => 'Small',
				'md' => 'Medium',
				'lg' => 'Large'
			);
			$options = apply_filters( self::$option_prefix . 'get_social_icon_sizes', $options );
			return $options;
		}

		public static function get_social_link_layouts() {
			$layouts = array(
				'default' => 'Default Layout',
			);
			$layouts = apply_filters( self::$option_prefix . 'get_social_link_layouts', $layouts );
			return $layouts;
		}

		public static function get_social_link_sizes() {
			$options = array(
				'sm' => 'Small',
				'md' => 'Medium',
				'lg' => 'Large'
			);
			$options = apply_filters( self::$option_prefix . 'get_social_link_sizes', $options );
			return $options;
		}

		public static function get_social_feed_layouts() {
			$layouts = array(
				'default'      => 'Default Layout',
				'scrollbox_sm' => 'Scrollbox - Small',
				'scrollbox'    => 'Scrollbox - Medium',
				'scrollbox_lg' => 'Scrollbox - Large'
			);
			$layouts = apply_filters( self::$option_prefix . 'get_social_feed_layouts', $layouts );
			return $layouts;
		}

		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin activation.
		 *
		 * @return void
		 **/
		public static function add_options() {
			$defaults = self::$option_defaults; // don't use self::get_option_defaults() here (default options haven't been set yet)

			add_option( self::$option_prefix . 'include_css', $defaults['include_css'] );
			add_option( self::$option_prefix . 'facebook_url', $defaults['facebook_url'] );
			add_option( self::$option_prefix . 'twitter_url', $defaults['twitter_url'] );
			add_option( self::$option_prefix . 'google_url', $defaults['google_url'] );
			add_option( self::$option_prefix . 'linkedin_url', $defaults['linkedin_url'] );
			add_option( self::$option_prefix . 'instagram_url', $defaults['instagram_url'] );
			add_option( self::$option_prefix . 'youtube_url', $defaults['youtube_url'] );
			add_option( self::$option_prefix . 'include_facebook_sharing', $defaults['include_facebook_sharing'] );
			add_option( self::$option_prefix . 'include_twitter_sharing', $defaults['include_twitter_sharing'] );
			add_option( self::$option_prefix . 'include_google_sharing', $defaults['include_google_sharing'] );
			add_option( self::$option_prefix . 'include_linkedin_sharing', $defaults['include_linkedin_sharing'] );
			add_option( self::$option_prefix . 'include_email_sharing', $defaults['include_email_sharing'] );
			add_option( self::$option_prefix . 'curator_default_feed', $defaults['curator_default_feed'] );
			add_option( self::$option_prefix . 'curator_default_type', $defaults['curator_default_type'] );
			add_option( self::$option_prefix . 'curator_api_key', $defaults['curator_api_key'] );
			add_option( self::$option_prefix . 'curator_widget_version', $defaults['curator_widget_version'] );
		}

		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin uninstallation.
		 *
		 * @return void
		 **/
		public static function delete_options() {
			delete_option( self::$option_prefix . 'include_css' );
			delete_option( self::$option_prefix . 'facebook_url' );
			delete_option( self::$option_prefix . 'twitter_url' );
			delete_option( self::$option_prefix . 'google_url' );
			delete_option( self::$option_prefix . 'linkedin_url' );
			delete_option( self::$option_prefix . 'instagram_url' );
			delete_option( self::$option_prefix . 'youtube_url' );
			delete_option( self::$option_prefix . 'include_facebook_sharing' );
			delete_option( self::$option_prefix . 'include_twitter_sharing' );
			delete_option( self::$option_prefix . 'include_google_sharing' );
			delete_option( self::$option_prefix . 'include_linkedin_sharing' );
			delete_option( self::$option_prefix . 'include_email_sharing' );
			delete_option( self::$option_prefix . 'curator_default_feed' );
			delete_option( self::$option_prefix . 'curator_default_type' );
			delete_option( self::$option_prefix . 'curator_api_key' );
			delete_option( self::$option_prefix . 'curator_widget_version' );
		}

		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the options page.
		 *
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			// Apply default values configurable within the options page:
			$configurable_defaults = array(
				'include_css'              => get_option( self::$option_prefix . 'include_css', $defaults['include_css'] ),
				'facebook_url'             => get_option( self::$option_prefix . 'facebook_url', $defaults['facebook_url'] ),
				'twitter_url'              => get_option( self::$option_prefix . 'twitter_url', $defaults['twitter_url'] ),
				'google_url'               => get_option( self::$option_prefix . 'google_url', $defaults['google_url'] ),
				'linkedin_url'             => get_option( self::$option_prefix . 'linkedin_url', $defaults['linkedin_url'] ),
				'instagram_url'            => get_option( self::$option_prefix . 'instagram_url', $defaults['instagram_url'] ),
				'youtube_url'              => get_option( self::$option_prefix . 'youtube_url', $defaults['youtube_url'] ),
				'include_facebook_sharing' => get_option( self::$option_prefix . 'include_facebook_sharing', $defaults['include_facebook_sharing'] ),
				'include_twitter_sharing'  => get_option( self::$option_prefix . 'include_twitter_sharing', $defaults['include_twitter_sharing'] ),
				'include_google_sharing'   => get_option( self::$option_prefix . 'include_google_sharing', $defaults['include_google_sharing'] ),
				'include_linkedin_sharing' => get_option( self::$option_prefix . 'include_linkedin_sharing', $defaults['include_linkedin_sharing'] ),
				'include_email_sharing'    => get_option( self::$option_prefix . 'include_email_sharing', $defaults['include_email_sharing'] ),
				'curator_default_feed'     => get_option( self::$option_prefix . 'curator_default_feed', $defaults['curator_default_feed'] ),
				'curator_default_type'     => get_option( self::$option_prefix . 'curator_default_type', $defaults['curator_default_type'] ),
				'curator_api_key'          => get_option( self::$option_prefix . 'curator_api_key', $defaults['curator_api_key'] ),
				'curator_widget_version'   => get_option( self::$option_prefix . 'curator_widget_version', $defaults['curator_widget_version'] ),
			);

			// Force configurable options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}

		/**
		 * Performs typecasting, sanitization, etc on an array of plugin options.
		 *
		 * @param array $list | Assoc. array of plugin options, e.g. [ 'option_name' => 'val', ... ]
		 * @return array
		 **/
		public static function format_options( $list ) {
			foreach ( $list as $key => $val ) {
				switch ( $key ) {
					case 'include_css':
					case 'include_facebook_sharing':
					case 'include_twitter_sharing':
					case 'include_google_sharing':
					case 'include_linkedin_sharing':
					case 'include_email_sharing':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
					default:
						break;
				}
			}

			return $list;
		}

		/**
		 * Applies formatting to a single option. Intended to be passed to the
		 * 'option_{$option}' hook.
		 **/
		public static function format_option( $value, $option_name ) {
			$option_formatted = self::format_options( array( $option_name => $value ) );
			return $option_formatted[$option_name];
		}

		/**
		 * Adds filters for shortcode and plugin options that apply our
		 * formatting rules to attribute/option values.
		 **/
		public static function add_option_formatting_filters() {
			// Options
			$defaults = self::$option_defaults;
			foreach ( $defaults as $option => $default ) {
				add_filter( 'option_{$option}', array( 'UCF_Social_Config', 'format_option' ), 10, 2 );
			}
		}

		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 *
		 * @param $option_name
		 * @return mixed
		 **/
		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name           = self::$option_prefix . $option_name_no_prefix;
			$defaults              = self::get_option_defaults();

			return get_option( $option_name, $defaults[$option_name_no_prefix] );
		}

		/**
		 * Initializes setting registration with the Settings API.
		 **/
		public static function settings_init() {
			// Register settings
			register_setting( 'ucf_social', self::$option_prefix . 'include_css' );
			register_setting( 'ucf_social', self::$option_prefix . 'facebook_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'twitter_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'google_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'linkedin_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'instagram_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'youtube_url' );
			register_setting( 'ucf_social', self::$option_prefix . 'include_facebook_sharing' );
			register_setting( 'ucf_social', self::$option_prefix . 'include_twitter_sharing' );
			register_setting( 'ucf_social', self::$option_prefix . 'include_google_sharing' );
			register_setting( 'ucf_social', self::$option_prefix . 'include_linkedin_sharing' );
			register_setting( 'ucf_social', self::$option_prefix . 'include_email_sharing' );
			register_setting( 'ucf_social', self::$option_prefix . 'curator_api_key' );
			register_setting( 'ucf_social', self::$option_prefix . 'curator_default_feed' );
			register_setting( 'ucf_social', self::$option_prefix . 'curator_default_type' );
			register_setting( 'ucf_social', self::$option_prefix . 'curator_widget_version' );

			// Register setting sections
			add_settings_section(
				'ucf_social_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_social' // settings page slug
			);
			add_settings_section(
				'ucf_social_section_icons', // option section slug
				'Social Icon Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_social' // settings page slug
			);
			add_settings_section(
				'ucf_social_section_links', // option section slug
				'Social Share Link Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_social' // settings page slug
			);
			add_settings_section(
				'ucf_social_section_feed', // option section slug
				'Social Feed (Curator.io) Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_social' // settings page slug
			);

			// Register fields - general
			add_settings_field(
				self::$option_prefix . 'include_css',
				'Include Default CSS',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_css',
					'description' => 'Include the default css stylesheet for social assets within the theme.<br>Leave this checkbox checked unless your theme provides custom styles for social assets.',
					'type'        => 'checkbox'
				)
			);

			// Register fields - icon settings
			add_settings_field(
				self::$option_prefix . 'facebook_url',
				'Facebook URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'facebook_url',
					'description' => 'The Facebook URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'twitter_url',
				'Twitter URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'twitter_url',
					'description' => 'The Twitter URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'google_url',
				'Google+ URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'google_url',
					'description' => 'The Google+ URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'linkedin_url',
				'LinkedIn URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'linkedin_url',
					'description' => 'The LinkedIn URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'instagram_url',
				'Instagram URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'instagram_url',
					'description' => 'The Instagram URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'youtube_url',
				'YouTube URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_icons',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'youtube_url',
					'description' => 'The YouTube URL to use in the [ucf-social-icons] shortcode output.',
					'type'        => 'text'
				)
			);

			// Register fields - share link settings
			add_settings_field(
				self::$option_prefix . 'include_facebook_sharing',
				'Facebook',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_links',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_facebook_sharing',
					'description' => 'Include a Facebook share link in the [ucf-social-links] shortcode output by default.<br>Can be overridden per-shortcode with the <code>facebook</code> attribute.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'include_twitter_sharing',
				'Twitter',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_links',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_twitter_sharing',
					'description' => 'Include a Twitter share link in the [ucf-social-links] shortcode output by default.<br>Can be overridden per-shortcode with the <code>twitter</code> attribute.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'include_google_sharing',
				'Google+',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_links',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_google_sharing',
					'description' => 'Include a Google+ share link in the [ucf-social-links] shortcode output by default.<br>Can be overridden per-shortcode with the <code>google</code> attribute.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'include_linkedin_sharing',
				'LinkedIn',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_links',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_linkedin_sharing',
					'description' => 'Include a LinkedIn share link in the [ucf-social-links] shortcode output by default.<br>Can be overridden per-shortcode with the <code>linkedin</code> attribute.',
					'type'        => 'checkbox'
				)
			);
			add_settings_field(
				self::$option_prefix . 'include_email_sharing',
				'Email',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ),  // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_links',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_email_sharing',
					'description' => 'Include an email share link in the [ucf-social-links] shortcode output by default.<br>Can be overridden per-shortcode with the <code>email</code> attribute.',
					'type'        => 'checkbox'
				)
			);

			// Register fields - social feed settings
			add_settings_field(
				self::$option_prefix . 'curator_api_key',
				'Curator API Key',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_feed',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'curator_api_key',
					'description' => 'API key for Curator API access. If provided, feed customization settings will be retrieved and applied to feeds referenced via the [ucf-social-feed] shortcode.',
					'type'        => 'password'
				)
			);
			add_settings_field(
				self::$option_prefix . 'curator_default_feed',
				'Curator Default Feed ID',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_feed',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'curator_default_feed',
					'description' => 'A default feed ID to use in [ucf-social-feed] shortcodes when an explicit <code>feed</code> attribute isn\'t provided.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'curator_default_type',
				'Curator Default Feed Type',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_feed',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'curator_default_type',
					'description' => 'The type of feed to use by default in [ucf-social-feed] when an explicit <code>type</code> attribute or option override isn\'t provided.',
					'type'        => 'select',
					'choices'     => array(
						'Waterfall' => 'Waterfall',
						'Carousel'  => 'Carousel',
						'Grid'      => 'Grid',
						'Panel'     => 'Panel'
					)
				)
			);
			add_settings_field(
				self::$option_prefix . 'curator_widget_version',
				'Curator Widget Version',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_feed',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'curator_widget_version',
					'description' => 'Version of Curator.io\'s widget CSS and JS to use for all feeds on this site.<br>Note that feeds may be generated and published under different version numbers, and may need to be upgraded within Curator.io to work with the widget version specified here. You can upgrade your feed\'s widget version from the "Publish" view in the Curator.io admin if a newer version is available.',
					'type'        => 'smalltext'
				)
			);
		}

		/**
		 * Displays an individual setting's field markup.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$choices       = isset( $args['choices'] ) ? $args['choices'] : null;
			$markup        = '';

			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'select':
					ob_start();
				?>
					<select id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>">
					<?php
					if ( $choices ):
						foreach ( $choices as $value => $text ):
					?>
						<option value="<?php echo $value; ?>" <?php echo ( $current_value === $value ) ? 'selected' : ''; ?>><?php echo $text; ?></option>
					<?php
						endforeach;
					endif;
					?>
					</select>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'password':
					ob_start();
				?>
					<input type="password" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="regular-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'smalltext':
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="small-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="regular-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}
		?>

		<?php
			echo $markup;
		}


		/**
		 * Registers the settings page to display in the WordPress admin.
		 **/
		public static function add_options_page() {
			$page_title = 'UCF Social Settings';
			$menu_title = 'UCF Social';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_social';
			$callback   = array( 'UCF_Social_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}


		/**
		 * Displays the plugin's settings page form.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_social' );
				do_settings_sections( 'ucf_social' );
				submit_button();
				?>
			</form>
			<hr>
			<form method="post" action="admin-post.php">
				<h2>Flush Curator.io Transient Data</h2>
				<p class="description">
					If a Curator API key is provided above, feed customization settings will be imported from Curator and applied to feeds embedded via the [ucf-social-feed] shortcode. Those settings are then saved as transient data, and will be referenced until the transient either expires, or is flushed using the button below.
				</p>
				<p class="description">
					If you make changes to your feed's customization settings within Curator, you'll need to flush this transient data to immediately see your changes on this site.
				</p>

				<br>

				<p class="description">
					Click the button below to flush any existing Curator feed data and re-request fresh data.
				</p>

				<?php if ( isset( $_GET['ucf_social_transient_data_flushed'] ) && $_GET['ucf_social_transient_data_flushed'] === '1' ): ?>
				<div class="notice notice-success is-dismissible">
					<p>Curator transient data was flushed successfully.</p>
				</div>
				<?php endif; ?>

				<input type="hidden" name="action" value="ucf_social_flush_transient_data">

				<br>
				<button class="button" id="ucf_social_flush_transient_data">Flush Transient Data</button>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}


		/**
		 * Plugin settings page action that flushes Curator.io transient data.
		 *
		 * @since 3.0.0
		 * @return void
		 */
		public static function flush_transient_data() {
			delete_transient( self::$curator_data_transient );

			$data = UCF_Social_Common::get_social_feed_data();

			wp_redirect( admin_url( 'options-general.php?page=ucf_social&ucf_social_transient_data_flushed=1' ) );
			exit;
		}

	}

}


// Register settings and options.
add_action( 'admin_init', array( 'UCF_Social_Config', 'settings_init' ) );
add_action( 'admin_menu', array( 'UCF_Social_Config', 'add_options_page' ) );
add_action( 'admin_post_ucf_social_flush_transient_data', array( 'UCF_Social_Config', 'flush_transient_data' ) );

// Apply custom formatting to shortcode attributes and options.
UCF_Social_Config::add_option_formatting_filters();
