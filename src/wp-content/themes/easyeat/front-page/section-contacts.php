<div class="front_page_section front_page_section_contacts<?php
	$easyeat_scheme = easyeat_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $easyeat_scheme ) && ! easyeat_is_inherit( $easyeat_scheme ) ) {
		echo ' scheme_' . esc_attr( $easyeat_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( easyeat_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( easyeat_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$easyeat_css      = '';
		$easyeat_bg_image = easyeat_get_theme_option( 'front_page_contacts_bg_image' );
		if ( ! empty( $easyeat_bg_image ) ) {
			$easyeat_css .= 'background-image: url(' . esc_url( easyeat_get_attachment_url( $easyeat_bg_image ) ) . ');';
		}
		if ( ! empty( $easyeat_css ) ) {
			echo ' style="' . esc_attr( $easyeat_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$easyeat_anchor_icon = easyeat_get_theme_option( 'front_page_contacts_anchor_icon' );
	$easyeat_anchor_text = easyeat_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $easyeat_anchor_icon ) || ! empty( $easyeat_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $easyeat_anchor_icon ) ? ' icon="' . esc_attr( $easyeat_anchor_icon ) . '"' : '' )
									. ( ! empty( $easyeat_anchor_text ) ? ' title="' . esc_attr( $easyeat_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( easyeat_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' easyeat-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$easyeat_css      = '';
			$easyeat_bg_mask  = easyeat_get_theme_option( 'front_page_contacts_bg_mask' );
			$easyeat_bg_color_type = easyeat_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $easyeat_bg_color_type ) {
				$easyeat_bg_color = easyeat_get_theme_option( 'front_page_contacts_bg_color' );
			} elseif ( 'scheme_bg_color' == $easyeat_bg_color_type ) {
				$easyeat_bg_color = easyeat_get_scheme_color( 'bg_color', $easyeat_scheme );
			} else {
				$easyeat_bg_color = '';
			}
			if ( ! empty( $easyeat_bg_color ) && $easyeat_bg_mask > 0 ) {
				$easyeat_css .= 'background-color: ' . esc_attr(
					1 == $easyeat_bg_mask ? $easyeat_bg_color : easyeat_hex2rgba( $easyeat_bg_color, $easyeat_bg_mask )
				) . ';';
			}
			if ( ! empty( $easyeat_css ) ) {
				echo ' style="' . esc_attr( $easyeat_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$easyeat_caption     = easyeat_get_theme_option( 'front_page_contacts_caption' );
			$easyeat_description = easyeat_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $easyeat_caption ) || ! empty( $easyeat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $easyeat_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $easyeat_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $easyeat_caption, 'easyeat_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $easyeat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $easyeat_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $easyeat_description ), 'easyeat_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$easyeat_content = easyeat_get_theme_option( 'front_page_contacts_content' );
			$easyeat_layout  = easyeat_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $easyeat_layout && ( ! empty( $easyeat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $easyeat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $easyeat_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $easyeat_content, 'easyeat_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $easyeat_layout && ( ! empty( $easyeat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$easyeat_sc = easyeat_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $easyeat_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $easyeat_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					easyeat_show_layout( do_shortcode( $easyeat_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $easyeat_layout && ( ! empty( $easyeat_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
