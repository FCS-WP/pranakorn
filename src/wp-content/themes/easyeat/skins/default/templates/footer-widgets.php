<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.10
 */

// Footer sidebar
$easyeat_footer_name    = easyeat_get_theme_option( 'footer_widgets' );
$easyeat_footer_present = ! easyeat_is_off( $easyeat_footer_name ) && is_active_sidebar( $easyeat_footer_name );
if ( $easyeat_footer_present ) {
	easyeat_storage_set( 'current_sidebar', 'footer' );
	$easyeat_footer_wide = easyeat_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $easyeat_footer_name ) ) {
		dynamic_sidebar( $easyeat_footer_name );
	}
	$easyeat_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $easyeat_out ) ) {
		$easyeat_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $easyeat_out );
		$easyeat_need_columns = true;   //or check: strpos($easyeat_out, 'columns_wrap')===false;
		if ( $easyeat_need_columns ) {
			$easyeat_columns = max( 0, (int) easyeat_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $easyeat_columns ) {
				$easyeat_columns = min( 4, max( 1, easyeat_tags_count( $easyeat_out, 'aside' ) ) );
			}
			if ( $easyeat_columns > 1 ) {
				$easyeat_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $easyeat_columns ) . ' widget', $easyeat_out );
			} else {
				$easyeat_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $easyeat_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'easyeat_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $easyeat_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $easyeat_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'easyeat_action_before_sidebar', 'footer' );
				easyeat_show_layout( $easyeat_out );
				do_action( 'easyeat_action_after_sidebar', 'footer' );
				if ( $easyeat_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $easyeat_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'easyeat_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
