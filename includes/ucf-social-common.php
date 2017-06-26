<?php
/**
 * Place common functions here.
 **/
if ( !class_exists( 'UCF_Social_Common' ) ) {
	class UCF_Social_Common {
		public static function display_social( $layout='default' ) {
			if ( has_action( 'ucf_social_display_' . $layout . '_before' ) ) {
				do_action( 'ucf_social_display_' . $layout . '_before' );
			}
			if ( has_action( 'ucf_social_display_' . $layout  ) ) {
				do_action( 'ucf_social_display_' . $layout );
			}
			if ( has_action( 'ucf_social_display_' . $layout . '_after' ) ) {
				do_action( 'ucf_social_display_' . $layout . '_after' );
			}
		}
	}
}
if ( !function_exists( 'ucf_social_display_default_before' ) ) {
	function ucf_social_display_default_before() {
		ob_start();
	?>
		<div class="ucf-social ucf-social-default">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_social_display_default_before', 'ucf_social_display_default_before', 10, 0 );

}

if ( !function_exists( 'ucf_social_display_default' ) ) {

	function ucf_social_display_default() {
		ob_start();
	?>
		<!-- TODO -->
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_social_display_default', 'ucf_social_display_default', 10, 0 );

}

if ( !function_exists( 'ucf_social_display_default_after' ) ) {

	function ucf_social_display_default_after() {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}
	add_action( 'ucf_social_display_default_after', 'ucf_social_display_default_after', 10, 0 );
}
if ( ! function_exists( 'ucf_social_enqueue_assets' ) ) {
	function ucf_social_enqueue_assets() {
		// CSS
		$include_css = UCF_social_Config::get_option_or_default( 'include_css' );
		$css_deps = apply_filters( 'ucf_social_style_deps', array() );
		if ( $include_css ) {
			wp_enqueue_style( 'ucf_social_css', plugins_url( 'static/css/ucf-social.min.css', UCF_SOCIAL__PLUGIN_FILE ), $css_deps, false, 'screen' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'ucf_social_enqueue_assets' );
}
