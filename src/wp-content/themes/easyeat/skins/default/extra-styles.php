<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'easyeat_extra_styles_get_css' ) ) {
	add_filter( 'easyeat_filter_get_css', 'easyeat_extra_styles_get_css', 10, 2 );
	function easyeat_extra_styles_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS


.sc_testimonials_common [class*="column"] .sc_testimonials_item_content, 
.sc_testimonials_common .sc_testimonials_item_content,
.awards_slider .widget_slider .slider_type_images .slider-slide .slide_info .slide_cats,
.sc_slider_controls.slider_pagination_style_title.sc_slider_controls_light .slider_pagination_wrap .slider_pagination_bullet {
	{$fonts['h5_font-family']}
}
.sc_socials.sc_socials.sc_socials_icons_names .social_item .social_name {
	{$fonts['p_font-family']}
}


CSS;
		}

		return $css;
	}
}

