<?php
/**
 * The template to display default site footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$easyeat_footer_scheme = easyeat_get_theme_option( 'footer_scheme' );
if ( ! empty( $easyeat_footer_scheme ) && ! easyeat_is_inherit( $easyeat_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $easyeat_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
