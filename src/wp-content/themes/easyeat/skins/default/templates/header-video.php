<?php
/**
 * The template to display the background video in the header
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.14
 */
$easyeat_header_video = easyeat_get_header_video();
$easyeat_embed_video  = '';
if ( ! empty( $easyeat_header_video ) && ! easyeat_is_from_uploads( $easyeat_header_video ) ) {
	if ( easyeat_is_youtube_url( $easyeat_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $easyeat_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php easyeat_show_layout( easyeat_get_embed_video( $easyeat_header_video ) ); ?></div>
		<?php
	}
}
