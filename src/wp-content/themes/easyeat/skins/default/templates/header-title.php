<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

// Page (category, tag, archive, author) title

if ( easyeat_need_page_title() ) {
	easyeat_sc_layouts_showed( 'title', true );
	easyeat_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								easyeat_show_post_meta(
									apply_filters(
										'easyeat_filter_post_meta_args', array(
											'components' => join( ',', easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'counters' ) ) ),
											'seo'        => easyeat_is_on( easyeat_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$easyeat_blog_title           = easyeat_get_blog_title();
							$easyeat_blog_title_text      = '';
							$easyeat_blog_title_class     = '';
							$easyeat_blog_title_link      = '';
							$easyeat_blog_title_link_text = '';
							if ( is_array( $easyeat_blog_title ) ) {
								$easyeat_blog_title_text      = $easyeat_blog_title['text'];
								$easyeat_blog_title_class     = ! empty( $easyeat_blog_title['class'] ) ? ' ' . $easyeat_blog_title['class'] : '';
								$easyeat_blog_title_link      = ! empty( $easyeat_blog_title['link'] ) ? $easyeat_blog_title['link'] : '';
								$easyeat_blog_title_link_text = ! empty( $easyeat_blog_title['link_text'] ) ? $easyeat_blog_title['link_text'] : '';
							} else {
								$easyeat_blog_title_text = $easyeat_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $easyeat_blog_title_class ); ?>">
								<?php
								$easyeat_top_icon = easyeat_get_term_image_small();
								if ( ! empty( $easyeat_top_icon ) ) {
									$easyeat_attr = easyeat_getimagesize( $easyeat_top_icon );
									?>
									<img src="<?php echo esc_url( $easyeat_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'easyeat' ); ?>"
										<?php
										if ( ! empty( $easyeat_attr[3] ) ) {
											easyeat_show_layout( $easyeat_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $easyeat_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $easyeat_blog_title_link ) && ! empty( $easyeat_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $easyeat_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $easyeat_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'easyeat_action_breadcrumbs' );
						$easyeat_breadcrumbs = ob_get_contents();
						ob_end_clean();
						easyeat_show_layout( $easyeat_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
