<?php
/**
 * Generate custom CSS for theme hovers
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'easyeat_hovers_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'easyeat_hovers_theme_setup3', 3 );
	function easyeat_hovers_theme_setup3() {

		// Add 'Buttons hover' option
		easyeat_storage_set_array_after(
			'options', 'border_radius', array(
				'button_hover' => array(
					'title'   => esc_html__( "Button hover", 'easyeat' ),
					'desc'    => wp_kses_data( __( 'Select a hover effect for theme buttons', 'easyeat' ) ),
					'std'     => 'default',
					'options' => array(
						'default'      => esc_html__( 'Fade', 'easyeat' ),
						'slide_left'   => esc_html__( 'Slide from Left', 'easyeat' ),
						'slide_right'  => esc_html__( 'Slide from Right', 'easyeat' ),
						'slide_top'    => esc_html__( 'Slide from Top', 'easyeat' ),
						'slide_bottom' => esc_html__( 'Slide from Bottom', 'easyeat' ),
					),
					'type'    => 'hidden', // old value "select"
				),
				'image_hover'  => array(
					'title'    => esc_html__( "Image hover", 'easyeat' ),
					'desc'     => wp_kses_data( __( 'Select a hover effect for theme images', 'easyeat' ) ),
					'std'      => 'link',
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'easyeat' ),
					),
					'options'  => easyeat_get_list_hovers(),
					'type'     => 'select',
				),
			)
		);
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'easyeat_hovers_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'easyeat_hovers_theme_setup9', 9 );
	function easyeat_hovers_theme_setup9() {
		add_action( 'wp_enqueue_scripts', 'easyeat_hovers_frontend_scripts', 1100 );      // Priority 1100 -  after theme scripts (1000)
		add_action( 'wp_enqueue_scripts', 'easyeat_hovers_frontend_styles', 1100 );       // Priority 1100 -  after theme/skin styles (1050)
		add_action( 'wp_enqueue_scripts', 'easyeat_hovers_responsive_styles', 2100 );     // Priority 2100 -  after theme/skin responsive (2000)
		add_filter( 'easyeat_filter_localize_script', 'easyeat_hovers_localize_script' );
		add_filter( 'easyeat_filter_merge_scripts', 'easyeat_hovers_merge_scripts' );
		add_filter( 'easyeat_filter_merge_styles', 'easyeat_hovers_merge_styles' );
		add_filter( 'easyeat_filter_merge_styles_responsive', 'easyeat_hovers_merge_styles_responsive' );
	}
}

// Enqueue hover styles and scripts
if ( ! function_exists( 'easyeat_hovers_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'easyeat_hovers_frontend_scripts', 1100 );
	function easyeat_hovers_frontend_scripts() {
		if ( easyeat_is_on( easyeat_get_theme_option( 'debug_mode' ) ) ) {
			$easyeat_url = easyeat_get_file_url( 'theme-specific/theme-hovers/theme-hovers.js' );
			if ( '' != $easyeat_url ) {
				wp_enqueue_script( 'easyeat-hovers', $easyeat_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'easyeat_hovers_frontend_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'easyeat_hovers_frontend_styles', 1100 );
	function easyeat_hovers_frontend_styles() {
		if ( easyeat_is_on( easyeat_get_theme_option( 'debug_mode' ) ) ) {
			$easyeat_url = easyeat_get_file_url( 'theme-specific/theme-hovers/theme-hovers.css' );
			if ( '' != $easyeat_url ) {
				wp_enqueue_style( 'easyeat-hovers', $easyeat_url, array(), null );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'easyeat_hovers_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'easyeat_hovers_responsive_styles', 2100 );
	function easyeat_hovers_responsive_styles() {
		if ( easyeat_is_on( easyeat_get_theme_option( 'debug_mode' ) ) ) {
			$easyeat_url = easyeat_get_file_url( 'theme-specific/theme-hovers/theme-hovers-responsive.css' );
			if ( '' != $easyeat_url ) {
				wp_enqueue_style( 'easyeat-hovers-responsive', $easyeat_url, array(), null );
			}
		}
	}
}

// Merge hover effects into single css
if ( ! function_exists( 'easyeat_hovers_merge_styles' ) ) {
	//Handler of the add_filter( 'easyeat_filter_merge_styles', 'easyeat_hovers_merge_styles' );
	function easyeat_hovers_merge_styles( $list ) {
		$list[] = 'theme-specific/theme-hovers/theme-hovers.css';
		return $list;
	}
}

// Merge hover effects to the single css (responsive)
if ( ! function_exists( 'easyeat_hovers_merge_styles_responsive' ) ) {
	//Handler of the add_filter( 'easyeat_filter_merge_styles_responsive', 'easyeat_hovers_merge_styles_responsive' );
	function easyeat_hovers_merge_styles_responsive( $list ) {
		$list[] = 'theme-specific/theme-hovers/theme-hovers-responsive.css';
		return $list;
	}
}

// Add hover effect's vars to the localize array
if ( ! function_exists( 'easyeat_hovers_localize_script' ) ) {
	//Handler of the add_filter( 'easyeat_filter_localize_script','easyeat_hovers_localize_script' );
	function easyeat_hovers_localize_script( $arr ) {
		$arr['button_hover'] = easyeat_get_theme_option( 'button_hover' );
		return $arr;
	}
}

// Merge hover effects to the single js
if ( ! function_exists( 'easyeat_hovers_merge_scripts' ) ) {
	//Handler of the add_filter( 'easyeat_filter_merge_scripts', 'easyeat_hovers_merge_scripts' );
	function easyeat_hovers_merge_scripts( $list ) {
		$list[] = 'theme-specific/theme-hovers/theme-hovers.js';
		return $list;
	}
}

// Add hover icons on the featured image
if ( ! function_exists( 'easyeat_hovers_add_icons' ) ) {
	function easyeat_hovers_add_icons( $hover, $args = array() ) {

		// Additional parameters
		$args = array_merge(
			array(
				'cat'        => '',
				'image'      => null,
				'no_links'   => false,
				'link'       => '',
				'post_info'  => '',
				'meta_parts' => ''
			), $args
		);

        $post_link = empty( $args['no_links'] )
            ? ( ! empty( $args['link'] )
                ? $args['link']
                : apply_filters( 'easyeat_filter_get_post_link', get_permalink() )
            )
            : '';
		$no_link   = 'javascript:void(0)';
		$target    = ! empty( $post_link ) && easyeat_is_external_url( $post_link ) ? ' target="_blank" rel="nofollow"' : '';

		if ( in_array( $hover, array( 'icons', 'zoom' ) ) ) {
			// Hover style 'Icons and 'Zoom'
			if ( $args['image'] ) {
				$large_image = $args['image'];
			} else {
				$attachment = wp_get_attachment_image_src( get_post_thumbnail_id(), 'masonry-big' );
				if ( ! empty( $attachment[0] ) ) {
					$large_image = $attachment[0];
				}
			}
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			?>
			<div class="icons">
				<a href="<?php echo ! empty( $post_link ) ? esc_url( $post_link ) : $no_link; ?>" <?php easyeat_show_layout($target); ?> aria-hidden="true" class="icon-link
									<?php
									if ( empty( $large_image ) ) {
										echo ' single_icon';
									}
									?>
				"></a>
				<?php if ( ! empty( $large_image ) ) { ?>
				<a href="<?php echo esc_url( $large_image ); ?>" aria-hidden="true" class="icon-search" title="<?php the_title_attribute( '' ); ?>"></a>
				<?php } ?>
			</div>
			<?php

		} elseif ( 'shop' == $hover ) {
			// Hover style 'Shop'
			global $product;
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			$tpl = easyeat_storage_get('extended_products_tpl');

			if ( !empty($tpl) && 'creative' == $tpl && ! is_object( $args['cat'] ) ) { ?>
				<div class="top-info">
					<?php
					if ( easyeat_exists_wishlist() ) {
						easyeat_show_layout(do_shortcode("[ti_wishlists_addtowishlist loop=yes]"));
					}
					?>
				</div>
				<div class="bottom-info">
					<?php
					if ( easyeat_exists_quick_view() ) { ?>
						<div class="woosq_wrap">
							<?php
								easyeat_show_layout(do_shortcode("[woosq id='{$product->get_id()}' type='link']"));
							?>
						</div>
					<?php } ?>
					<div class="add_to_cart_wrap">
						<?php
						easyeat_show_layout(
							'<a rel="nofollow" href="' . esc_url($product->add_to_cart_url()) . '" 
													aria-hidden="true" 
													data-quantity="1" 
													data-product_id="' . esc_attr($product->is_type('variation') ? $product->get_parent_id() : $product->get_id()) . '"
													data-product_sku="' . esc_attr($product->get_sku()) . '"
													class="shop_cart icon-shopping-cart button add_to_cart_button'
							. ' product_type_' . $product->get_type()
							. ' product_' . ($product->is_purchasable() && $product->is_in_stock() ? 'in' : 'out') . '_stock'
							. ($product->supports('ajax_add_to_cart') ? ' ajax_add_to_cart' : '')
							. '">'
							. ( $product->is_type('variable') 
								? esc_html__('Select Options', 'easyeat')
								: ( $product->is_in_stock() ? esc_html__('Add to Cart', 'easyeat') : esc_html__('Read More', 'easyeat') )
								)
							. '</a>'
						);
						?>
					</div>
				</div>
				<?php
			} else if (!empty($tpl) && 'plain' == $tpl && ! is_object( $args['cat'] )) { ?>
				<div class="top-info">
					<?php
					if ( easyeat_exists_wishlist() ) {
						easyeat_show_layout(do_shortcode("[ti_wishlists_addtowishlist loop=yes]"));
					}
					?>
				</div>
				<?php
			} else if (!empty($tpl) && 'pure' == $tpl && ! is_object( $args['cat'] )) { ?>
				<div class="top-info">
					<?php
					if ( easyeat_exists_wishlist() ) {
						easyeat_show_layout(do_shortcode("[ti_wishlists_addtowishlist loop=yes]"));
					}
					?>
				</div>
				<?php
				if ( easyeat_exists_quick_view() ) { ?>
					<div class="bottom-info">
						<div class="woosq_wrap">
							<?php
								easyeat_show_layout(do_shortcode("[woosq id='{$product->get_id()}' type='link']"));
							?>
						</div>
					</div>
				<?php
				}
			} else {
				?>
				<div class="icons">
					<?php
					if ( !empty($tpl) && 'hovered' == $tpl ) { ?>
						<div class="item-hovered-info">
							<?php do_action( 'woocommerce_loop_item_hovered' ); ?>
						</div>
						<?php
					}

					if ( ! is_object( $args['cat'] ) ) {

						if ( function_exists('easyeat_exists_wishlist') && easyeat_exists_wishlist() ) {
							easyeat_show_layout(do_shortcode("[ti_wishlists_addtowishlist loop=yes]"));
						}

						if ( !empty($tpl) && 'simple' == $tpl ) {

						} else {
							easyeat_show_layout(
									'<a rel="nofollow" href="' . esc_url($product->add_to_cart_url()) . '" 
															aria-hidden="true" 
															data-quantity="1" 
															data-product_id="' . esc_attr($product->is_type('variation') ? $product->get_parent_id() : $product->get_id()) . '"
															data-product_sku="' . esc_attr($product->get_sku()) . '"
															class="shop_cart icon-shopping-cart button add_to_cart_button'
									. ' product_type_' . $product->get_type()
									. ' product_' . ($product->is_purchasable() && $product->is_in_stock() ? 'in' : 'out') . '_stock'
									. ($product->supports('ajax_add_to_cart') ? ' ajax_add_to_cart' : '')
									. '"><span class="icon-anim"></span>'
									. '</a>'
							);
						}
					}
					?>
					<a href="<?php echo esc_url( is_object( $args['cat'] ) ? get_term_link( $args['cat']->slug, 'product_cat' ) : get_permalink() ); ?>" aria-hidden="true" class="shop_link">
						<span class="icon-anim"></span>
					</a>
				</div>
				<?php
			}
		} elseif ( 'icon' == $hover ) {
			// Hover style 'Icon'
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			?>
			<div class="icons"><a href="<?php echo ! empty( $post_link ) ? esc_url( $post_link ) : $no_link; ?>" <?php easyeat_show_layout($target); ?> aria-hidden="true" class="icon-search-alt"></a></div>
			<?php

		} elseif ( 'dots' == $hover ) {
			// Hover style 'Dots'
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			?>
			<a href="<?php echo ! empty( $post_link ) ? esc_url( $post_link ) : $no_link; ?>" <?php easyeat_show_layout($target); ?> aria-hidden="true" class="icons"><span></span><span></span><span></span></a>
			<?php

		} elseif ( 'link' == $hover ) {
			// Hover style 'Link'
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			?>
			<a href="<?php echo ! empty( $post_link ) ? esc_url( $post_link ) : $no_link; ?>" <?php easyeat_show_layout($target); ?> aria-hidden="true" class="link"></a>
			<?php

		} elseif ( 'info' == $hover ) {
			// Hover style 'Info'
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			} else {
				$easyeat_components = empty( $args['meta_parts'] )
										? easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) )
										: ( is_array( $args['meta_parts'] )
											? $args['meta_parts']
											: explode( ',', $args['meta_parts'] )
											);
				?>
				<div class="post_info">
					<div class="post_descr">
						<?php
						if ( ! empty( $easyeat_components ) && count( $easyeat_components ) > 0 ) {
							if ( apply_filters( 'easyeat_filter_show_blog_meta', true, $easyeat_components ) ) {
								easyeat_show_post_meta(
									apply_filters(
										'easyeat_filter_post_meta_args', array(
										'components' => join( ',', $easyeat_components ),
										'seo'        => false,
										'echo'       => true,
									), 'hover_' . $hover, 1
									)
								);
							}
						}
						?>
					</div>
					<?php
					if ( apply_filters( 'easyeat_filter_show_blog_title', true ) ) {
						?>
						<h4 class="post_title">
							<?php
							if ( ! empty( $post_link ) ) {
								?>
								<a href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?>>
								<?php
							}
							the_title();
							if ( ! empty( $post_link ) ) {
								?>
								</a>
								<span class="hover-arrow"></span>
								<?php
							}
							?>
						</h4>
						<?php
					}

					if ( ! empty( $post_link ) ) {
						?>
						<a class="post_link" href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?>></a>
						<?php
					}
					?>
				</div>
				<?php
			}

		} elseif ( in_array( $hover, array( 'fade', 'pull', 'slide', 'border', 'excerpt' ) ) ) {
			// Hover style 'Fade', 'Slide', 'Pull', 'Border', 'Excerpt'
			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			} else {
				?>
				<div class="post_info">
					<div class="post_info_back">
						<?php
						if ( apply_filters( 'easyeat_filter_show_blog_title', true ) ) {
							?>
							<h4 class="post_title">
								<?php
								if ( ! empty( $post_link ) ) {
									?>
									<a href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?>>
									<?php
								}
								the_title();
								if ( ! empty( $post_link ) ) {
									?>
									</a>
									<?php
								}
								?>
							</h4>
							<?php
						}
						?>
						<div class="post_descr">
							<?php
							if ( 'excerpt' != $hover ) {
								$easyeat_components = empty( $args['meta_parts'] )
														? easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) )
														: ( is_array( $args['meta_parts'] )
															? $args['meta_parts']
															: explode( ',', $args['meta_parts'] )
															);
								if ( ! empty( $easyeat_components ) ) {
									if ( apply_filters( 'easyeat_filter_show_blog_meta', true, $easyeat_components ) ) {
										easyeat_show_post_meta(
											apply_filters(
												'easyeat_filter_post_meta_args', array(
													'components' => join( ',', $easyeat_components ),
													'seo'        => false,
													'echo'       => true,
												), 'hover_' . $hover, 1
											)
										);
									}
								}
							}
							// Remove the condition below if you want display excerpt
							if ( 'excerpt' == $hover ) {
								if ( apply_filters( 'easyeat_filter_show_blog_excerpt', true ) ) {
									?>
									<div class="post_excerpt"><?php
										easyeat_show_layout( get_the_excerpt() );
									?></div>
									<?php
								}
							}
							?>
						</div>
						<?php
						if ( ! empty( $post_link ) ) {
							?>
							<a class="post_link" href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?>></a>
							<?php
						}
						?>
					</div>
					<?php
					if ( ! empty( $post_link ) ) {
						?>
						<a class="post_link" href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?>></a>
						<?php
					}
					?>
				</div>
				<?php
			}

		} else {

			do_action( 'easyeat_action_custom_hover_icons', $args, $hover );

			if ( ! empty( $args['post_info'] ) ) {
				easyeat_show_layout( $args['post_info'] );
			}
			if ( ! empty( $post_link ) ) {
				?>
				<a href="<?php echo esc_url( $post_link ); ?>" <?php easyeat_show_layout($target); ?> aria-hidden="true" class="icons"></a>
				<?php
			}
		}
	}
}
