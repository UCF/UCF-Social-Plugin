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
				'layout'     => 'default',
				'color'      => 'color',
				'icon_class' => '',
				'size'       => 'md'
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
						'name'      => 'Circle Color Scheme',
						'param'     => 'color',
						'desc'      => 'The color scheme to apply to the icons.',
						'type'      => 'select',
						'options'   => UCF_Social_Config::get_social_icon_colors(),
						'default'   => 'color'
					),
					array(
						'name'      => 'Icon Class(es)',
						'param'     => 'icon_class',
						'desc'      => 'CSS class(es) apply to each inner icon.',
						'type'      => 'text',
						'default'   => ''
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
				'linkedin'   => UCF_Social_Config::get_option_or_default( 'include_linkedin_sharing' ),
				'email'      => UCF_Social_Config::get_option_or_default( 'include_email_sharing' ),
			), $atts, 'ucf-social-links' );

			$atts_formatted = array_merge(
				$atts,
				array(
					'facebook' => UCF_Social_Config::format_option( $atts['facebook'], 'include_facebook_sharing' ),
					'twitter'  => UCF_Social_Config::format_option( $atts['twitter'], 'include_twitter_sharing' ),
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

	}

}

// Register shortcodes and shortcode interface options
add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'icons_shortcode' ) );
add_shortcode( 'ucf-social-links', array( 'UCF_Social_Shortcode', 'links_shortcode' ) );
