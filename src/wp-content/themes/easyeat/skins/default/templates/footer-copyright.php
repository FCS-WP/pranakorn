<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$easyeat_copyright_scheme = easyeat_get_theme_option( 'copyright_scheme' );
if ( ! empty( $easyeat_copyright_scheme ) && ! easyeat_is_inherit( $easyeat_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $easyeat_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$easyeat_copyright = easyeat_get_theme_option( 'copyright' );
			if ( ! empty( $easyeat_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$easyeat_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $easyeat_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$easyeat_copyright = easyeat_prepare_macros( $easyeat_copyright );
				// Display copyright
				echo wp_kses( nl2br( $easyeat_copyright ), 'easyeat_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
