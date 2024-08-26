<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

if ( easyeat_sidebar_present() ) {
	
	$easyeat_sidebar_type = easyeat_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $easyeat_sidebar_type && ! easyeat_is_layouts_available() ) {
		$easyeat_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $easyeat_sidebar_type ) {
		// Default sidebar with widgets
		$easyeat_sidebar_name = easyeat_get_theme_option( 'sidebar_widgets' );
		easyeat_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $easyeat_sidebar_name ) ) {
			dynamic_sidebar( $easyeat_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$easyeat_sidebar_id = easyeat_get_custom_sidebar_id();
		do_action( 'easyeat_action_show_layout', $easyeat_sidebar_id );
	}
	$easyeat_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $easyeat_out ) ) {
		$easyeat_sidebar_position    = easyeat_get_theme_option( 'sidebar_position' );
		$easyeat_sidebar_position_ss = easyeat_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $easyeat_sidebar_position );
			echo ' sidebar_' . esc_attr( $easyeat_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $easyeat_sidebar_type );

			$easyeat_sidebar_scheme = apply_filters( 'easyeat_filter_sidebar_scheme', easyeat_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $easyeat_sidebar_scheme ) && ! easyeat_is_inherit( $easyeat_sidebar_scheme ) && 'custom' != $easyeat_sidebar_type ) {
				echo ' scheme_' . esc_attr( $easyeat_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="easyeat_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'easyeat_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $easyeat_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$easyeat_title = apply_filters( 'easyeat_filter_sidebar_control_title', 'float' == $easyeat_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'easyeat' ) : '' );
				$easyeat_text  = apply_filters( 'easyeat_filter_sidebar_control_text', 'above' == $easyeat_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'easyeat' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $easyeat_title ); ?>"><?php echo esc_html( $easyeat_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'easyeat_action_before_sidebar', 'sidebar' );
				easyeat_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $easyeat_out ) );
				do_action( 'easyeat_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'easyeat_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
