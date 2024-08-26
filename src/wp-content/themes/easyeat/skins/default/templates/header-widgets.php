<?php
/**
 * The template to display the widgets area in the header
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

// Header sidebar
$easyeat_header_name    = easyeat_get_theme_option( 'header_widgets' );
$easyeat_header_present = ! easyeat_is_off( $easyeat_header_name ) && is_active_sidebar( $easyeat_header_name );
if ( $easyeat_header_present ) {
	easyeat_storage_set( 'current_sidebar', 'header' );
	$easyeat_header_wide = easyeat_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $easyeat_header_name ) ) {
		dynamic_sidebar( $easyeat_header_name );
	}
	$easyeat_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $easyeat_widgets_output ) ) {
		$easyeat_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $easyeat_widgets_output );
		$easyeat_need_columns   = strpos( $easyeat_widgets_output, 'columns_wrap' ) === false;
		if ( $easyeat_need_columns ) {
			$easyeat_columns = max( 0, (int) easyeat_get_theme_option( 'header_columns' ) );
			if ( 0 == $easyeat_columns ) {
				$easyeat_columns = min( 6, max( 1, easyeat_tags_count( $easyeat_widgets_output, 'aside' ) ) );
			}
			if ( $easyeat_columns > 1 ) {
				$easyeat_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $easyeat_columns ) . ' widget', $easyeat_widgets_output );
			} else {
				$easyeat_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $easyeat_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'easyeat_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $easyeat_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $easyeat_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'easyeat_action_before_sidebar', 'header' );
				easyeat_show_layout( $easyeat_widgets_output );
				do_action( 'easyeat_action_after_sidebar', 'header' );
				if ( $easyeat_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $easyeat_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'easyeat_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
