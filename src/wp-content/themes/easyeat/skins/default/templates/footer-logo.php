<?php
/**
 * The template to display the site logo in the footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */

// Logo
if ( easyeat_is_on( easyeat_get_theme_option( 'logo_in_footer' ) ) ) {
	$easyeat_logo_image = easyeat_get_logo_image( 'footer' );
	$easyeat_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $easyeat_logo_image['logo'] ) || ! empty( $easyeat_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $easyeat_logo_image['logo'] ) ) {
					$easyeat_attr = easyeat_getimagesize( $easyeat_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $easyeat_logo_image['logo'] ) . '"'
								. ( ! empty( $easyeat_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $easyeat_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'easyeat' ) . '"'
								. ( ! empty( $easyeat_attr[3] ) ? ' ' . wp_kses_data( $easyeat_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $easyeat_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $easyeat_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
