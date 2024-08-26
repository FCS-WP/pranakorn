<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package EASYEAT
 * @since EASYEAT 1.71.0
 */

$easyeat_template_args = get_query_var( 'easyeat_template_args' );
if ( ! is_array( $easyeat_template_args ) ) {
	$easyeat_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$easyeat_columns       = 1;

$easyeat_expanded      = ! easyeat_sidebar_present() && easyeat_get_theme_option( 'expand_content' ) == 'expand';

$easyeat_post_format   = get_post_format();
$easyeat_post_format   = empty( $easyeat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $easyeat_post_format );

if ( is_array( $easyeat_template_args ) ) {
	$easyeat_columns    = empty( $easyeat_template_args['columns'] ) ? 1 : max( 1, $easyeat_template_args['columns'] );
	$easyeat_blog_style = array( $easyeat_template_args['type'], $easyeat_columns );
	if ( ! empty( $easyeat_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $easyeat_columns > 1 ) {
	    $easyeat_columns_class = easyeat_get_column_class( 1, $easyeat_columns, ! empty( $easyeat_template_args['columns_tablet']) ? $easyeat_template_args['columns_tablet'] : '', ! empty($easyeat_template_args['columns_mobile']) ? $easyeat_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $easyeat_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $easyeat_post_format ) );
	easyeat_add_blog_animation( $easyeat_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$easyeat_hover      = ! empty( $easyeat_template_args['hover'] ) && ! easyeat_is_inherit( $easyeat_template_args['hover'] )
							? $easyeat_template_args['hover']
							: easyeat_get_theme_option( 'image_hover' );
	$easyeat_components = ! empty( $easyeat_template_args['meta_parts'] )
							? ( is_array( $easyeat_template_args['meta_parts'] )
								? $easyeat_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $easyeat_template_args['meta_parts'] ) )
								)
							: easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) );
	easyeat_show_post_featured( apply_filters( 'easyeat_filter_args_featured',
		array(
			'no_links'   => ! empty( $easyeat_template_args['no_links'] ),
			'hover'      => $easyeat_hover,
			'meta_parts' => $easyeat_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $easyeat_template_args['thumb_size'] )
								? $easyeat_template_args['thumb_size']
								: easyeat_get_thumb_size( 
								in_array( $easyeat_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( easyeat_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $easyeat_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$easyeat_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$easyeat_show_title = get_the_title() != '';
		$easyeat_show_meta  = count( $easyeat_components ) > 0 && ! in_array( $easyeat_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $easyeat_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'easyeat_filter_show_blog_categories', $easyeat_show_meta && in_array( 'categories', $easyeat_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'easyeat_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						easyeat_show_post_meta( apply_filters(
															'easyeat_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $easyeat_hover, 1
															)
											);
						?>
					</div>
					<?php
					$easyeat_components = easyeat_array_delete_by_value( $easyeat_components, 'categories' );
					do_action( 'easyeat_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'easyeat_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'easyeat_action_before_post_title' );
					if ( empty( $easyeat_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'easyeat_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $easyeat_template_args['excerpt_length'] ) && ! in_array( $easyeat_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$easyeat_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'easyeat_filter_show_blog_excerpt', empty( $easyeat_template_args['hide_excerpt'] ) && easyeat_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				easyeat_show_post_content( $easyeat_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'easyeat_filter_show_blog_meta', $easyeat_show_meta, $easyeat_components, 'band' ) ) {
			if ( count( $easyeat_components ) > 0 ) {
				do_action( 'easyeat_action_before_post_meta' );
				easyeat_show_post_meta(
					apply_filters(
						'easyeat_filter_post_meta_args', array(
							'components' => join( ',', $easyeat_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'easyeat_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'easyeat_filter_show_blog_readmore', ! $easyeat_show_title || ! empty( $easyeat_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $easyeat_template_args['no_links'] ) ) {
				do_action( 'easyeat_action_before_post_readmore' );
				easyeat_show_post_more_link( $easyeat_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'easyeat_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $easyeat_template_args ) ) {
	if ( ! empty( $easyeat_template_args['slider'] ) || $easyeat_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
