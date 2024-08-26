<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

$easyeat_template_args = get_query_var( 'easyeat_template_args' );

if ( is_array( $easyeat_template_args ) ) {
	$easyeat_columns    = empty( $easyeat_template_args['columns'] ) ? 2 : max( 1, $easyeat_template_args['columns'] );
	$easyeat_blog_style = array( $easyeat_template_args['type'], $easyeat_columns );
    $easyeat_columns_class = easyeat_get_column_class( 1, $easyeat_columns, ! empty( $easyeat_template_args['columns_tablet']) ? $easyeat_template_args['columns_tablet'] : '', ! empty($easyeat_template_args['columns_mobile']) ? $easyeat_template_args['columns_mobile'] : '' );
} else {
	$easyeat_template_args = array();
	$easyeat_blog_style = explode( '_', easyeat_get_theme_option( 'blog_style' ) );
	$easyeat_columns    = empty( $easyeat_blog_style[1] ) ? 2 : max( 1, $easyeat_blog_style[1] );
    $easyeat_columns_class = easyeat_get_column_class( 1, $easyeat_columns );
}
$easyeat_expanded   = ! easyeat_sidebar_present() && easyeat_get_theme_option( 'expand_content' ) == 'expand';

$easyeat_post_format = get_post_format();
$easyeat_post_format = empty( $easyeat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $easyeat_post_format );

?><div class="<?php
	if ( ! empty( $easyeat_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( easyeat_is_blog_style_use_masonry( $easyeat_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $easyeat_columns ) : esc_attr( $easyeat_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $easyeat_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $easyeat_columns )
				. ' post_layout_' . esc_attr( $easyeat_blog_style[0] )
				. ' post_layout_' . esc_attr( $easyeat_blog_style[0] ) . '_' . esc_attr( $easyeat_columns )
	);
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
								: explode( ',', $easyeat_template_args['meta_parts'] )
								)
							: easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) );

	easyeat_show_post_featured( apply_filters( 'easyeat_filter_args_featured',
		array(
			'thumb_size' => ! empty( $easyeat_template_args['thumb_size'] )
				? $easyeat_template_args['thumb_size']
				: easyeat_get_thumb_size(
					'classic' == $easyeat_blog_style[0]
						? ( strpos( easyeat_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $easyeat_columns > 2 ? 'big' : 'huge' )
								: ( $easyeat_columns > 2
									? ( $easyeat_expanded ? 'square' : 'square' )
									: ($easyeat_columns > 1 ? 'square' : ( $easyeat_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( easyeat_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $easyeat_columns > 2 ? 'masonry-big' : 'full' )
								: ($easyeat_columns === 1 ? ( $easyeat_expanded ? 'huge' : 'big' ) : ( $easyeat_columns <= 2 && $easyeat_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $easyeat_hover,
			'meta_parts' => $easyeat_components,
			'no_links'   => ! empty( $easyeat_template_args['no_links'] ),
        ),
        'content-classic',
        $easyeat_template_args
    ) );

	// Title and post meta
	$easyeat_show_title = get_the_title() != '';
	$easyeat_show_meta  = count( $easyeat_components ) > 0 && ! in_array( $easyeat_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $easyeat_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'easyeat_filter_show_blog_meta', $easyeat_show_meta, $easyeat_components, 'classic' ) ) {
				if ( count( $easyeat_components ) > 0 ) {
					do_action( 'easyeat_action_before_post_meta' );
					easyeat_show_post_meta(
						apply_filters(
							'easyeat_filter_post_meta_args', array(
							'components' => join( ',', $easyeat_components ),
							'seo'        => false,
							'echo'       => true,
						), $easyeat_blog_style[0], $easyeat_columns
						)
					);
					do_action( 'easyeat_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'easyeat_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'easyeat_action_before_post_title' );
				if ( empty( $easyeat_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'easyeat_action_after_post_title' );
			}

			if( !in_array( $easyeat_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'easyeat_filter_show_blog_readmore', ! $easyeat_show_title || ! empty( $easyeat_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $easyeat_template_args['no_links'] ) ) {
						do_action( 'easyeat_action_before_post_readmore' );
						easyeat_show_post_more_link( $easyeat_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'easyeat_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $easyeat_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('easyeat_filter_show_blog_excerpt', empty($easyeat_template_args['hide_excerpt']) && easyeat_get_theme_option('excerpt_length') > 0, 'classic')) {
			easyeat_show_post_content($easyeat_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $easyeat_template_args['more_button'] )) {
			if ( empty( $easyeat_template_args['no_links'] ) ) {
				do_action( 'easyeat_action_before_post_readmore' );
				easyeat_show_post_more_link( $easyeat_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'easyeat_action_after_post_readmore' );
			}
		}
		$easyeat_content = ob_get_contents();
		ob_end_clean();
		easyeat_show_layout($easyeat_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
