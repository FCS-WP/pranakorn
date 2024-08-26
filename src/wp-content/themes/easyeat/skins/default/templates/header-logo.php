<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

$easyeat_args = get_query_var( 'easyeat_logo_args' );

// Site logo
$easyeat_logo_type   = isset( $easyeat_args['type'] ) ? $easyeat_args['type'] : '';
$easyeat_logo_image  = easyeat_get_logo_image( $easyeat_logo_type );
$easyeat_logo_text   = easyeat_is_on( easyeat_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$easyeat_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $easyeat_logo_image['logo'] ) || ! empty( $easyeat_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $easyeat_logo_image['logo'] ) ) {
			if ( empty( $easyeat_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($easyeat_logo_image['logo']) && (int) $easyeat_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$easyeat_attr = easyeat_getimagesize( $easyeat_logo_image['logo'] );
				echo '<img src="' . esc_url( $easyeat_logo_image['logo'] ) . '"'
						. ( ! empty( $easyeat_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $easyeat_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $easyeat_logo_text ) . '"'
						. ( ! empty( $easyeat_attr[3] ) ? ' ' . wp_kses_data( $easyeat_attr[3] ) : '' )
						. '>';
			}
		} else {
			easyeat_show_layout( easyeat_prepare_macros( $easyeat_logo_text ), '<span class="logo_text">', '</span>' );
			easyeat_show_layout( easyeat_prepare_macros( $easyeat_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
