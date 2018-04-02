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

		public static function feed_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'feed'       => '',
				'container'  => 'ucf-social-feed-' . wp_rand(),
				'layout'     => 'default',
				'grid-width' => 320,
				'grid-rows'  => 3,
				'class'      => ''
			), $atts, 'ucf-social-feed' );

			ob_start();
			echo UCF_Social_Common::display_social_feed( $atts );
			return ob_get_clean();
		}
	}

	add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'icons_shortcode' ) );
	add_shortcode( 'ucf-social-links', array( 'UCF_Social_Shortcode', 'links_shortcode' ) );
	add_shortcode( 'ucf-social-feed', array( 'UCF_Social_Shortcode', 'feed_shortcode' ) );
}
