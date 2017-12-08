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
				if ( has_filter( 'ucf_social_display_before' ) ) {
					$before = apply_filters( 'ucf_social_display_before', $before, $atts );
				}

				$content = ucf_social_icons_display( $atts );
				if ( has_filter( 'ucf_social_display' ) ) {
					$content = apply_filters( 'ucf_social_display', $content, $atts );
				}

				$after = ucf_social_icons_display_after( $atts );
				if ( has_filter( 'ucf_social_display_after' ) ) {
					$after = apply_filters( 'ucf_social_display_after', $after, $atts );
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
			if ( has_filter( 'ucf_social_display_before' ) ) {
				$before = apply_filters( 'ucf_social_display_before', $before, $atts );
			}

			$content = ucf_social_links_display( $atts );
			if ( has_filter( 'ucf_social_display' ) ) {
				$content = apply_filters( 'ucf_social_display', $content, $atts );
			}

			$after = ucf_social_links_display_after( $atts );
			if ( has_filter( 'ucf_social_display_after' ) ) {
				$after = apply_filters( 'ucf_social_display_after', $after, $atts );
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
			if ( has_filter( 'ucf_social_display_before' ) ) {
				$before = apply_filters( 'ucf_social_display_before', $before, $atts );
			}

			$content = ucf_social_feed_display( $atts );
			if ( has_filter( 'ucf_social_display' ) ) {
				$content = apply_filters( 'ucf_social_display', $content, $atts );
			}

			$after = ucf_social_feed_display_after( $atts );
			if ( has_filter( 'ucf_social_display_after' ) ) {
				$after = apply_filters( 'ucf_social_display_after', $after, $atts );
			}

			return $before . $content . $after;
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
		echo ob_get_clean();
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
			$atts = shortcode_atts( array(
				'size'  => 'md',
				'color' => 'color'
			), $atts );

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
		echo ob_get_clean();
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
		echo ob_get_clean();
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
	?>
		<aside class="ucf-social-links">
	<?php
		echo ob_get_clean();
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
		$atts = shortcode_atts( array(
			'size'  => 'md'
		), $atts );

		global $post;
		if ( !$post ) { return; }  // back out if there's no post data to reference
		$permalink = urlencode( get_permalink( $post->ID ) );

		ob_start();
	?>
		<a class="btn btn-facebook color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" title="Like this story on Facebook">
			<span class="fa fa-facebook"></span> Like
		</a>
		<a class="btn btn-twitter color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo $permalink; ?>" title="Tweet this story">
			<span class="fa fa-twitter"></span> Tweet
		</a>
		<a class="btn btn-google color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" title="Share this story on Google+">
			<span class="fa fa-google-plus"></span> Share
		</a>
	<?php
		echo ob_get_clean();
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
	?>
		</aside>
	<?php
		echo ob_get_clean();
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
		<aside class="ucf-social-feed">
	<?php
		echo ob_get_clean();
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
		$atts = shortcode_atts( array(
			'feed'       => '',
			'container'  => 'ucf-social-feed',
			'layout'     => 'waterfall',
			'grid-width' => 320,
			'grid-rows'  => 3
		), $atts );

		global $post;
		if ( !$post ) { return; }  // back out if there's no post data to reference
		$permalink = urlencode( get_permalink( $post->ID ) );

		ob_start();
	?>
		<div id="<?php echo $atts['container']; ?>"></div>
		<script type="text/javascript">
			$(function() {
			<?php if($atts['layout'] === 'waterfall') : ?>
				var widget = new Curator.Waterfall({
					container:'#<?php echo $atts['container']; ?>',
					feedId:'<?php echo $atts['feed']; ?>',
				<?php if($atts['grid-width'] > 0) : ?>
					waterfall: {
						gridWidth:<?php echo $atts['grid-width']; ?>
					}
				<?php endif; ?>
				});
			<?php endif;
			if($atts['layout'] === 'grid') : ?>
				var widget = new Curator.Grid({
					container:'#<?php echo $atts['container']; ?>',
					feedId:'<?php echo $atts['feed']; ?>',
					grid: {
						minWidth:<?php echo $atts['grid-width']; ?>,
						rows: <?php echo $atts['grid-rows']; ?>
					}
				});
			<?php endif; ?>
			});
		</script>
	<?php
		echo ob_get_clean();
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
		echo ob_get_clean();
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

		if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'ucf-social-feed') ) {
			wp_enqueue_style( 'ucf_social_curator_css', '//cdn.curator.io/2.1/css/curator.css', false, false, 'all' );
			wp_enqueue_script( 'ucf_social_script', '//cdn.curator.io/2.1/js/curator.js', false, false, true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'ucf_social_enqueue_assets' );
}
