<?php
/**
 * Registers the social shortcode
 * @author RJ Bruneel
 * @since 1.0.0
 * @param array $atts | Assoc. array of shortcode options
 * @return array
 **/

if ( ! class_exists( 'UCF_Social_Shortcode' ) ) {
	class UCF_Social_Shortcode {
		public static function icons_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'layout' => 'default',
				'color'  => 'color',
				'size'   => 'md'
			), $atts, 'ucf-social-icons' );

			ob_start();
			echo UCF_Social_Common::display_social_icons( $atts );
			return ob_get_clean();
		}

		public static function icons_shortcode_interface( $registered_shortcodes ) {
			if ( class_exists( 'WP_SCIF_Config' ) ) {
				$fields = array(
					array(
						'name'      => 'Layout',
						'param'     => 'layout',
						'desc'      => 'The layout to display this list of icons',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_icon_layouts(),
						'default'   => 'default'
					),
					array(
						'name'      => 'Color Scheme',
						'param'     => 'color',
						'desc'      => 'The color scheme to apply to the icons.',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_icon_colors(),
						'default'   => 'color'
					),
					array(
						'name'      => 'Size',
						'param'     => 'size',
						'desc'      => 'What size each icon should be.',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_icon_sizes(),
						'default'   => 'md'
					),
				);
				$shortcode = array(
					'command' => 'ucf-social-icons',
					'name'    => 'UCF Social Icons',
					'desc'    => 'Displays a list of round social icons that link to social media profiles.',
					'content' => false,
					'fields'  => $fields,
					'preview' => false,
					'group'   => 'UCF Social'
				);

				$registered_shortcodes[] = $shortcode;
				return $registered_shortcodes;
			}
		}

		public static function links_shortcode( $atts ) {
			global $post;
			$permalink = $share_text = '';
			if ( $post ) {
				$permalink = get_permalink( $post );
				$share_text = get_the_title( $post );
			}

			$atts = shortcode_atts( array(
				'layout'     => 'default',
				'size'       => 'sm',
				'permalink'  => $permalink,
				'share_text' => $share_text,
				'facebook'   => UCF_Social_Config::get_option_or_default( 'include_facebook_sharing' ),
				'twitter'    => UCF_Social_Config::get_option_or_default( 'include_twitter_sharing' ),
				'google'     => UCF_Social_Config::get_option_or_default( 'include_google_sharing' ),
				'linkedin'   => UCF_Social_Config::get_option_or_default( 'include_linkedin_sharing' ),
				'email'      => UCF_Social_Config::get_option_or_default( 'include_email_sharing' ),
			), $atts, 'ucf-social-links' );

			$atts_formatted = array_merge(
				$atts,
				array(
					'facebook' => UCF_Social_Config::format_option( $atts['facebook'], 'include_facebook_sharing' ),
					'twitter'  => UCF_Social_Config::format_option( $atts['twitter'], 'include_twitter_sharing' ),
					'google'   => UCF_Social_Config::format_option( $atts['google'], 'include_google_sharing' ),
					'linkedin' => UCF_Social_Config::format_option( $atts['linkedin'], 'include_linkedin_sharing' ),
					'email'    => UCF_Social_Config::format_option( $atts['email'], 'include_email_sharing' ),
				)
			);

			ob_start();
			echo UCF_Social_Common::display_social_links( $atts_formatted );
			return ob_get_clean();
		}

		public static function links_shortcode_interface( $registered_shortcodes ) {
			if ( class_exists( 'WP_SCIF_Config' ) ) {
				$fields = array(
					array(
						'name'      => 'Layout',
						'param'     => 'layout',
						'desc'      => 'The layout to display this list of buttons',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_link_layouts(),
						'default'   => 'default'
					),
					array(
						'name'      => 'Size',
						'param'     => 'size',
						'desc'      => 'What size each button should be.',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_link_sizes(),
						'default'   => 'md'
					),
					array(
						'name'      => 'Shareable Permalink',
						'param'     => 'permalink',
						'desc'      => 'The link that should be shared when the user clicks a share button. The current page/post will be used by default.',
						'type'      => 'text'
					),
					array(
						'name'      => 'Share Text',
						'param'     => 'share_text',
						'desc'      => 'Text that should be included in shared tweets and emails with the permalink. The current page/post title will be used by default.',
						'type'      => 'text'
					),
					array(
						'name'      => 'Include Facebook',
						'param'     => 'facebook',
						'desc'      => 'Whether Facebook should be included in the list of share buttons.',
						'type'      => 'checkbox',
						'default'   => UCF_Social_Config::get_option_or_default( 'include_facebook_sharing' )
					),
					array(
						'name'      => 'Include Twitter',
						'param'     => 'twitter',
						'desc'      => 'Whether Twitter should be included in the list of share buttons.',
						'type'      => 'checkbox',
						'default'   => UCF_Social_Config::get_option_or_default( 'include_twitter_sharing' )
					),
					array(
						'name'      => 'Include Google+',
						'param'     => 'google',
						'desc'      => 'Whether Google+ should be included in the list of share buttons.',
						'type'      => 'checkbox',
						'default'   => UCF_Social_Config::get_option_or_default( 'include_google_sharing' )
					),
					array(
						'name'      => 'Include LinkedIn',
						'param'     => 'linkedin',
						'desc'      => 'Whether LinkedIn should be included in the list of share buttons.',
						'type'      => 'checkbox',
						'default'   => UCF_Social_Config::get_option_or_default( 'include_linkedin_sharing' )
					),
					array(
						'name'      => 'Include Email',
						'param'     => 'email',
						'desc'      => 'Whether Email should be included in the list of share buttons.',
						'type'      => 'checkbox',
						'default'   => UCF_Social_Config::get_option_or_default( 'include_email_sharing' )
					),
				);
				$shortcode = array(
					'command' => 'ucf-social-links',
					'name'    => 'UCF Social Links',
					'desc'    => 'Displays a list of social sharing buttons (like/share/tweet)',
					'content' => false,
					'fields'  => $fields,
					'preview' => false,
					'group'   => 'UCF Social'
				);

				$registered_shortcodes[] = $shortcode;
				return $registered_shortcodes;
			}
		}

		public static function feed_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'feed'         => UCF_Social_Config::get_option_or_default( 'curator_default_feed' ), // feed ID
				'layout'       => 'default', // layout for social feed parent elem
				'type'         => '', // override the feed type to use
				'class'        => '', // classes to be applied to parent elem
				'container'    => 'ucf-social-feed-' . wp_rand(), // ID to be applied to the feed container elem
				'options_file' => '', // attachment ID of a JSON file that contains widget options
			), $atts, 'ucf-social-feed' );

			// START backward compatibility
			switch ( $atts['layout'] ) {
				case 'grid':
					$atts['layout'] = 'default';
					$atts['type'] = 'Grid';
					break;
				case 'waterfall':
					$atts['layout'] = 'default';
					$atts['type'] = 'Waterfall';
					break;
			}
			// END backward compatibility

			ob_start();
			echo UCF_Social_Common::display_social_feed( $atts );
			return ob_get_clean();
		}

		public static function feed_shortcode_interface( $registered_shortcodes ) {
			if ( class_exists( 'WP_SCIF_Config' ) ) {
				$fields = array(
					array(
						'name'      => 'Feed ID',
						'param'     => 'feed',
						'desc'      => 'Specify a unique feed to display by its ID.',
						'type'      => 'text',
						'default'   => UCF_Social_Config::get_option_or_default( 'curator_default_feed' )
					),
					array(
						'name'      => 'Layout',
						'param'     => 'layout',
						'desc'      => 'The layout to display this social feed',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_feed_layouts(),
						'default'   => 'default'
					),
					array(
						'name'      => 'Type',
						'param'     => 'type',
						'desc'      => 'Overrides the <a href="https://github.com/curatorio/widgets#widgets" target="_blank">type of widget</a> to use for this feed.',
						'type'      => 'text'
					),
					array(
						'name'      => 'CSS Class(es)',
						'param'     => 'class',
						'desc'      => 'CSS classes to be applied to the wrapper element surrounding the widget.',
						'type'      => 'text'
					),
					array(
						'name'      => 'Container ID',
						'param'     => 'container',
						'desc'      => 'ID to apply to the widget\'s container element. Must be unique. Defaults to a randomized value.',
						'type'      => 'text'
					),
					array(
						'name'      => 'Options File',
						'param'     => 'options_file',
						'desc'      => 'Either an attachment ID or direct URL that points to a JSON file containing widget configuration overrides. See <a href="https://github.com/curatorio/widgets#customisation" target="_blank">Curator\'s widget documentation</a> for available options. The JSON file should contain only the options object.',
						'type'      => 'text'
					),
				);
				$shortcode = array(
					'command' => 'ucf-social-feed',
					'name'    => 'UCF Social Feed',
					'desc'    => 'Displays a Curator.io social feed widget.',
					'content' => false,
					'fields'  => $fields,
					'preview' => false,
					'group'   => 'UCF Social'
				);

				$registered_shortcodes[] = $shortcode;
				return $registered_shortcodes;
			}
		}
	}

}

// Register shortcodes and shortcode interface options
add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'icons_shortcode' ) );
add_shortcode( 'ucf-social-links', array( 'UCF_Social_Shortcode', 'links_shortcode' ) );
add_shortcode( 'ucf-social-feed', array( 'UCF_Social_Shortcode', 'feed_shortcode' ) );
