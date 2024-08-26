<?php
$easyeat_woocommerce_sc = easyeat_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $easyeat_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$easyeat_scheme = easyeat_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $easyeat_scheme ) && ! easyeat_is_inherit( $easyeat_scheme ) ) {
			echo ' scheme_' . esc_attr( $easyeat_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( easyeat_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( easyeat_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$easyeat_css      = '';
			$easyeat_bg_image = easyeat_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$easyeat_anchor_icon = easyeat_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$easyeat_anchor_text = easyeat_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $easyeat_anchor_icon ) || ! empty( $easyeat_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $easyeat_anchor_icon ) ? ' icon="' . esc_attr( $easyeat_anchor_icon ) . '"' : '' )
											. ( ! empty( $easyeat_anchor_text ) ? ' title="' . esc_attr( $easyeat_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( easyeat_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' easyeat-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$easyeat_css      = '';
				$easyeat_bg_mask  = easyeat_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$easyeat_bg_color_type = easyeat_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $easyeat_bg_color_type ) {
					$easyeat_bg_color = easyeat_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$easyeat_caption     = easyeat_get_theme_option( 'front_page_woocommerce_caption' );
				$easyeat_description = easyeat_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $easyeat_caption ) || ! empty( $easyeat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $easyeat_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $easyeat_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $easyeat_caption, 'easyeat_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $easyeat_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $easyeat_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $easyeat_description ), 'easyeat_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $easyeat_woocommerce_sc ) {
						$easyeat_woocommerce_sc_ids      = easyeat_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$easyeat_woocommerce_sc_per_page = count( explode( ',', $easyeat_woocommerce_sc_ids ) );
					} else {
						$easyeat_woocommerce_sc_per_page = max( 1, (int) easyeat_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$easyeat_woocommerce_sc_columns = max( 1, min( $easyeat_woocommerce_sc_per_page, (int) easyeat_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$easyeat_woocommerce_sc}"
										. ( 'products' == $easyeat_woocommerce_sc
												? ' ids="' . esc_attr( $easyeat_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $easyeat_woocommerce_sc
												? ' category="' . esc_attr( easyeat_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $easyeat_woocommerce_sc
												? ' orderby="' . esc_attr( easyeat_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( easyeat_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $easyeat_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $easyeat_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
