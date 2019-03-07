<?php
/**
 *  Get Google Fonts
 */

/* Get Google Fonts for your site */
if ( ! function_exists( 'chromium_get_default_fonts' ) ) {
  function chromium_get_default_fonts() {
 		$site_default_fonts = array();
 		$site_default_fonts[] = get_theme_mod('primary_font_family', 'Rubik');
        $site_default_fonts[] = get_theme_mod('logo_font_family', 'Rubik');
 		$site_default_fonts[] = get_theme_mod('header_font_family', 'Rubik');
 		$site_default_fonts[] = get_theme_mod('fields_font_family', 'Rubik');
 		$site_default_fonts = array_unique($site_default_fonts);
 		return $site_default_fonts;
 }
}

/* Setting Google Fonts for your site */
if ( !function_exists('chromium_google_fonts_url') ) {
	function chromium_google_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = apply_filters('chromium_fonts_default_subset', 'latin,latin-ext');
		$font_var  = apply_filters('chromium_fonts_default_weights', '100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic');

		/* Get default fonts used in theme */
		if ( function_exists( 'chromium_get_default_fonts' ) ) {
			$chromium_default_fonts = chromium_get_default_fonts();
		}

		if ( is_array($chromium_default_fonts) && !empty($chromium_default_fonts) ) {
			foreach ( $chromium_default_fonts as $single_font ) {
				/*  Translators: If there are characters in your language that are not
				 *  supported by font, translate this to 'off'. Do not translate
				 *  into your own language.
				 */
				if ( 'off' !== _x( 'on', $single_font . ' font: on or off', 'chromium' ) ) {
					$fonts[] = $single_font . ':' . $font_var;
				}
			}
			unset($single_font);
		} else {
			if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'chromium' ) ) {
				$fonts[] = 'Open Sans:' . $font_var;
			}
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'chromium' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
}

/**
 *  Add used fonts to frontend
 */
function chromium_add_fonts_styles() {
	wp_enqueue_style( 'chromium-google-fonts', chromium_google_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'chromium_add_fonts_styles' );

/**
 * Add preconnect for Google Fonts.
 */

if ( ! function_exists( 'chromium_resource_hints' ) ) :

function chromium_resource_hints( $urls, $relation_type ) {
 if ( wp_style_is( 'chromium-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
   $urls[] = array(
     'href' => 'https://fonts.gstatic.com',
     'crossorigin',
   );
 }
 return $urls;
}
add_filter( 'wp_resource_hints', 'chromium_resource_hints', 10, 2 );

endif;