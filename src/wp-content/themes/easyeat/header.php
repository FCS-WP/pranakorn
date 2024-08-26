<?php
/**
 * The Header: Logo and main menu
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( easyeat_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'easyeat_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'easyeat_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('easyeat_action_body_wrap_attributes'); ?>>

		<?php do_action( 'easyeat_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'easyeat_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('easyeat_action_page_wrap_attributes'); ?>>

			<?php do_action( 'easyeat_action_page_wrap_start' ); ?>

			<?php
			$easyeat_full_post_loading = ( easyeat_is_singular( 'post' ) || easyeat_is_singular( 'attachment' ) ) && easyeat_get_value_gp( 'action' ) == 'full_post_loading';
			$easyeat_prev_post_loading = ( easyeat_is_singular( 'post' ) || easyeat_is_singular( 'attachment' ) ) && easyeat_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $easyeat_full_post_loading && ! $easyeat_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="easyeat_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'easyeat_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'easyeat' ); ?></a>
				<?php if ( easyeat_sidebar_present() ) { ?>
				<a class="easyeat_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'easyeat_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'easyeat' ); ?></a>
				<?php } ?>
				<a class="easyeat_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'easyeat_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'easyeat' ); ?></a>

				<?php
				do_action( 'easyeat_action_before_header' );

				// Header
				$easyeat_header_type = easyeat_get_theme_option( 'header_type' );
				if ( 'custom' == $easyeat_header_type && ! easyeat_is_layouts_available() ) {
					$easyeat_header_type = 'default';
				}
				get_template_part( apply_filters( 'easyeat_filter_get_template_part', "templates/header-" . sanitize_file_name( $easyeat_header_type ) ) );

				// Side menu
				if ( in_array( easyeat_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'easyeat_action_after_header' );

			}
			?>

			<?php do_action( 'easyeat_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( easyeat_is_off( easyeat_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $easyeat_header_type ) ) {
						$easyeat_header_type = easyeat_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $easyeat_header_type && easyeat_is_layouts_available() ) {
						$easyeat_header_id = easyeat_get_custom_header_id();
						if ( $easyeat_header_id > 0 ) {
							$easyeat_header_meta = easyeat_get_custom_layout_meta( $easyeat_header_id );
							if ( ! empty( $easyeat_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$easyeat_footer_type = easyeat_get_theme_option( 'footer_type' );
					if ( 'custom' == $easyeat_footer_type && easyeat_is_layouts_available() ) {
						$easyeat_footer_id = easyeat_get_custom_footer_id();
						if ( $easyeat_footer_id ) {
							$easyeat_footer_meta = easyeat_get_custom_layout_meta( $easyeat_footer_id );
							if ( ! empty( $easyeat_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'easyeat_action_page_content_wrap_class', $easyeat_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'easyeat_filter_is_prev_post_loading', $easyeat_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( easyeat_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'easyeat_action_page_content_wrap_data', $easyeat_prev_post_loading );
			?>>
				<?php
				do_action( 'easyeat_action_page_content_wrap', $easyeat_full_post_loading || $easyeat_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'easyeat_filter_single_post_header', easyeat_is_singular( 'post' ) || easyeat_is_singular( 'attachment' ) ) ) {
					if ( $easyeat_prev_post_loading ) {
						if ( easyeat_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'easyeat_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$easyeat_path = apply_filters( 'easyeat_filter_get_template_part', 'templates/single-styles/' . easyeat_get_theme_option( 'single_style' ) );
					if ( easyeat_get_file_dir( $easyeat_path . '.php' ) != '' ) {
						get_template_part( $easyeat_path );
					}
				}

				// Widgets area above page
				$easyeat_body_style   = easyeat_get_theme_option( 'body_style' );
				$easyeat_widgets_name = easyeat_get_theme_option( 'widgets_above_page' );
				$easyeat_show_widgets = ! easyeat_is_off( $easyeat_widgets_name ) && is_active_sidebar( $easyeat_widgets_name );
				if ( $easyeat_show_widgets ) {
					if ( 'fullscreen' != $easyeat_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					easyeat_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $easyeat_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'easyeat_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $easyeat_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'easyeat_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'easyeat_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="easyeat_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( easyeat_is_singular( 'post' ) || easyeat_is_singular( 'attachment' ) )
							&& $easyeat_prev_post_loading 
							&& easyeat_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'easyeat_action_between_posts' );
						}

						// Widgets area above content
						easyeat_create_widgets_area( 'widgets_above_content' );

						do_action( 'easyeat_action_page_content_start_text' );
