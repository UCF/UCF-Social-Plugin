<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_Social_Common' ) ) {
	class UCF_Social_Common {

		/**
		* Displays the social icons
		* @author RJ Bruneel
		* @since 1.0
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_icons( $atts ) {
				$before = ucf_social_icons_display_before( $atts );
				if ( has_filter( 'ucf_social_icons_display_before' ) ) {
					$before = apply_filters( 'ucf_social_icons_display_before', $before, $atts );
				}

				$content = ucf_social_icons_display( $atts );
				if ( has_filter( 'ucf_social_icons_display' ) ) {
					$content = apply_filters( 'ucf_social_icons_display', $content, $atts );
				}

				$after = ucf_social_icons_display_after( $atts );
				if ( has_filter( 'ucf_social_icons_display_after' ) ) {
					$after = apply_filters( 'ucf_social_icons_display_after', $after, $atts );
				}

				return $before . $content . $after;
		}

		/**
		* Displays the social links
		* @author RJ Bruneel
		* @since 1.0
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_links( $atts ) {
			$before = ucf_social_links_display_before( $atts );
			if ( has_filter( 'ucf_social_links_display_before' ) ) {
				$before = apply_filters( 'ucf_social_links_display_before', $before, $atts );
			}

			$content = ucf_social_links_display( $atts );
			if ( has_filter( 'ucf_social_links_display' ) ) {
				$content = apply_filters( 'ucf_social_links_display', $content, $atts );
			}

			$after = ucf_social_links_display_after( $atts );
			if ( has_filter( 'ucf_social_links_display_after' ) ) {
				$after = apply_filters( 'ucf_social_links_display_after', $after, $atts );
			}

			return $before . $content . $after;
		}

		/**
		* Displays the social feed
		* @author RJ Bruneel
		* @since 1.0.4
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_feed( $atts ) {
			$before = ucf_social_feed_display_before( $atts );
			if ( has_filter( 'ucf_social_feed_display_before' ) ) {
				$before = apply_filters( 'ucf_social_feed_display_before', $before, $atts );
			}

			$content = ucf_social_feed_display( $atts );
			if ( has_filter( 'ucf_social_feed_display' ) ) {
				$content = apply_filters( 'ucf_social_feed_display', $content, $atts );
			}

			$after = ucf_social_feed_display_after( $atts );
			if ( has_filter( 'ucf_social_feed_display_after' ) ) {
				$after = apply_filters( 'ucf_social_feed_display_after', $after, $atts );
			}

			return $before . $content . $after;
		}

		/**
		 * Determines whether the provided content contains a [ucf-social-feed]
		 * shortcode.
		 * @author Jo Dickson
		 * @since 1.0.6
		 * @param string $content | arbitrary string of content
		 * @return boolean
		 */
		public static function has_social_feed( $content ) {
			$has_feed = false;
			ob_start();
			echo do_shortcode( $content );
			$content_processed = ob_get_clean();

			// Check against unprocessed string contents for the
			// [ucf-social-feed] shortcode, as well as processed string
			// contents for substrings that are likely to be present in social
			// feed templates
			if (
				has_shortcode( $content, 'ucf-social-feed' )
				|| ( strpos( $content_processed, 'new Curator.' ) !== false || strpos( $content_processed, 'ucf-social-feed' ) !== false )
			) {
				$has_feed = true;
			}

			return $has_feed;
		}

	}
}

/**
* Display the content before the social icons
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display_before' ) ) {
	function ucf_social_icons_display_before( $atts ) {
		ob_start();
	?>
		<div class="ucf-social-icons">
	<?php
		return ob_get_clean();
	}
}

/**
* Display the social icons content
* @author RJ Bruneel
* @since 1.0
* @param array $atts | Assoc. array of shortcode options
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display' ) ) {
	function ucf_social_icons_display( $atts ) {
		$google_url     = UCF_Social_Config::get_option_or_default( 'google_url' );
		$linkedin_url   = UCF_Social_Config::get_option_or_default( 'linkedin_url' );
		$twitter_url    = UCF_Social_Config::get_option_or_default( 'twitter_url' );
		$facebook_url   = UCF_Social_Config::get_option_or_default( 'facebook_url' );
		$instagram_url  = UCF_Social_Config::get_option_or_default( 'instagram_url' );
		$youtube_url    = UCF_Social_Config::get_option_or_default( 'youtube_url' );

		ob_start();
	?>
		<?php if ( $google_url ) : ?>
			<a class="ucf-social-link btn-google <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $google_url; ?>">
				<span class="fa fa-google-plus" aria-hidden="true"></span>
				<p class="sr-only">Follow us on Google+</p>
			</a>
		<?php endif; ?>
		<?php if ( $linkedin_url ) : ?>
			<a class="ucf-social-link btn-linkedin <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $linkedin_url; ?>">
				<span class="fa fa-linkedin" aria-hidden="true"></span>
				<p class="sr-only">View our LinkedIn page</p>
			</a>
		<?php endif; ?>
		<?php if ( $twitter_url ) : ?>
			<a class="ucf-social-link btn-twitter <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $twitter_url; ?>">
				<span class="fa fa-twitter" aria-hidden="true"></span>
				<p class="sr-only">Follow us on Twitter</p>
			</a>
		<?php endif; ?>
		<?php if ( $facebook_url ) : ?>
			<a class="ucf-social-link btn-facebook <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $facebook_url; ?>">
				<span class="fa fa-facebook" aria-hidden="true"></span>
				<p class="sr-only">Like us on Facebook</p>
			</a>
		<?php endif; ?>
		<?php if ( $instagram_url ) : ?>
			<a class="ucf-social-link btn-instagram <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $instagram_url; ?>">
				<span class="fa fa-instagram" aria-hidden="true"></span>
				<p class="sr-only">Find us on Instagram</p>
			</a>
		<?php endif; ?>
		<?php if ( $youtube_url ) : ?>
			<a class="ucf-social-link btn-youtube <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $youtube_url; ?>">
				<span class="fa fa-youtube" aria-hidden="true"></span>
				<p class="sr-only">Follow us on YouTube</p>
			</a>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}
}

/**
* Display the content after the social icons
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display_after' ) ) {
	function ucf_social_icons_display_after( $atts ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
}

/**
* Display the content before the social links
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_links_display_before' ) ) {
	function ucf_social_links_display_before( $atts ) {
		ob_start();
		if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] . '_before' ) ) {
			echo apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_before', '', $atts );
		}
		return ob_get_clean();
	}
}

/**
* Display the social links content
* @author RJ Bruneel
* @since 1.0
* @param array $atts | Assoc. array of shortcode options
* @return string
**/
if ( ! function_exists( 'ucf_social_links_display' ) ) {
	function ucf_social_links_display( $atts ) {
		ob_start();
		if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] ) ) {
			echo apply_filters( 'ucf_social_links_display_' . $atts['layout'], '', $atts );
		}
		return ob_get_clean();
	}
}

/**
* Display the content after the social links
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_links_display_after' ) ) {
	function ucf_social_links_display_after( $atts ) {
		ob_start();
		if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] . '_after' ) ) {
			echo apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_after', '', $atts );
		}
		return ob_get_clean();
	}
}

/**
* Display the content before the social feed
* @author RJ Bruneel
* @since 1.0.4
* @return string
**/
if ( ! function_exists( 'ucf_social_feed_display_before' ) ) {
	function ucf_social_feed_display_before( $atts ) {
		ob_start();
	?>
		<aside class="ucf-social-feed <?php echo $atts['class']; ?>">
	<?php
		return ob_get_clean();
	}
}

/**
* Display the social feed content
* @author RJ Bruneel
* @since 1.0.4
* @param array $atts | Assoc. array of shortcode options
* @return string
**/
if ( ! function_exists( 'ucf_social_feed_display' ) ) {
	function ucf_social_feed_display( $atts ) {
		global $post;
		if ( !$post ) { return; }  // back out if there's no post data to reference

		ob_start();
		if ( has_filter( 'ucf_social_feed_display_' . $atts['layout'] ) ) {
			echo apply_filters( 'ucf_social_feed_display_' . $atts['layout'], '', $atts );
		}
		return ob_get_clean();
	}
}

/**
* Display the content after the social feed
* @author RJ Bruneel
* @since 1.0.4
* @return string
**/
if ( ! function_exists( 'ucf_social_feed_display_after' ) ) {
	function ucf_social_feed_display_after( $atts ) {
		ob_start();
	?>
		</aside>
	<?php
		return ob_get_clean();
	}
}

/**
* Enqueue css assets for the plugin
* @author RJ Bruneel
* @since 1.0
**/
if ( ! function_exists( 'ucf_social_enqueue_assets' ) ) {
	function ucf_social_enqueue_assets() {
		global $post;

		$include_css = UCF_Social_Config::get_option_or_default( 'include_css' );
		if ( $include_css ) {
			wp_enqueue_style( 'ucf_social_css', plugins_url( 'static/css/ucf-social.min.css', UCF_SOCIAL__PLUGIN_FILE ), false, false, 'all' );
		}

		if ( is_a( $post, 'WP_Post' ) && UCF_Social_Common::has_social_feed( $post->post_content ) ) {
			wp_enqueue_style( 'ucf_social_curator_css', UCF_Social_Config::get_option_or_default( 'ucf_social_curator_css_url' ), false, false, 'all' );
			wp_enqueue_script( 'ucf_social_curator', UCF_Social_Config::get_option_or_default( 'ucf_social_curator_js_url' ), false, false, true );
			wp_enqueue_script( 'ucf_social_curator_js', plugins_url( 'static/js/ucf-social.min.js', UCF_SOCIAL__PLUGIN_FILE ), false, false, true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'ucf_social_enqueue_assets' );
}
