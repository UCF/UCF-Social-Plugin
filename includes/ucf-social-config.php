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
			);

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
				'include_css'      => get_option( self::$option_prefix . 'include_css', $defaults['include_css'] ),
				'facebook_url'     => get_option( self::$option_prefix . 'facebook_url', $defaults['facebook_url'] ),
				'twitter_url'      => get_option( self::$option_prefix . 'twitter_url', $defaults['twitter_url'] ),
				'google_url'       => get_option( self::$option_prefix . 'google_url', $defaults['google_url'] ),
				'linkedin_url'     => get_option( self::$option_prefix . 'linkedin_url', $defaults['linkedin_url'] ),
				'instagram_url'    => get_option( self::$option_prefix . 'instagram_url', $defaults['instagram_url'] ),
				'youtube_url'      => get_option( self::$option_prefix . 'youtube_url', $defaults['youtube_url'] ),
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
		 * Applies formatting to an array of shortcode attributes. Intended to
		 * be passed to the 'shortcode_atts_sc_ucf_social' hook.
		 **/
		public static function format_sc_atts( $out, $pairs, $atts, $shortcode ) {
			return self::format_options( $out );
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
			// Shortcode atts
			add_filter( 'shortcode_atts_sc_ucf_social', array( 'UCF_Social_Config', 'format_sc_atts' ), 10, 4 );
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

			// Register setting sections
			add_settings_section(
				'ucf_social_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_social' // settings page slug
			);

			// Register fields
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
			add_settings_field(
				self::$option_prefix . 'facebook_url',
				'Facebook URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'facebook_url',
					'description' => 'The Facebook URL to use for social assets.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'twitter_url',
				'Twitter URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'twitter_url',
					'description' => 'The Twitter URL to use for social assets.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'google_url',
				'Google+ URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'google_url',
					'description' => 'The Google+ URL to use for social assets.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'linkedin_url',
				'LinkedIn URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'linkedin_url',
					'description' => 'The LinkedIn URL to use for social assets.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'instagram_url',
				'Instagram URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'instagram_url',
					'description' => 'The Instagram URL to use for social assets.',
					'type'        => 'text'
				)
			);
			add_settings_field(
				self::$option_prefix . 'youtube_url',
				'Youtube URL',  // formatted field title
				array( 'UCF_Social_Config', 'display_settings_field' ), // display callback
				'ucf_social',  // settings page slug
				'ucf_social_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'youtube_url',
					'description' => 'The Youtube URL to use for social assets.',
					'type'        => 'text'
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
		</div>

		<?php
			echo ob_get_clean();
		}

	}

	// Register settings and options.
	add_action( 'admin_init', array( 'UCF_Social_Config', 'settings_init' ) );
	add_action( 'admin_menu', array( 'UCF_Social_Config', 'add_options_page' ) );

	// Apply custom formatting to shortcode attributes and options.
	UCF_Social_Config::add_option_formatting_filters();
}
