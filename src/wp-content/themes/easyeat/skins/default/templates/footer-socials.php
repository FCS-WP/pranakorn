<?php
/**
 * The template to display the socials in the footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */


// Socials
if ( easyeat_is_on( easyeat_get_theme_option( 'socials_in_footer' ) ) ) {
	$easyeat_output = easyeat_get_socials_links();
	if ( '' != $easyeat_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php easyeat_show_layout( $easyeat_output ); ?>
			</div>
		</div>
		<?php
	}
}
