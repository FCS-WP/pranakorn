<?php
/**
 * The Portfolio template to display the content
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

$easyeat_post_format = get_post_format();
$easyeat_post_format = empty( $easyeat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $easyeat_post_format );

?><div class="
<?php
if ( ! empty( $easyeat_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( easyeat_is_blog_style_use_masonry( $easyeat_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $easyeat_columns ) : esc_attr( $easyeat_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $easyeat_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $easyeat_columns )
		. ( 'portfolio' != $easyeat_blog_style[0] ? ' ' . esc_attr( $easyeat_blog_style[0] )  . '_' . esc_attr( $easyeat_columns ) : '' )
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

	$easyeat_hover   = ! empty( $easyeat_template_args['hover'] ) && ! easyeat_is_inherit( $easyeat_template_args['hover'] )
								? $easyeat_template_args['hover']
								: easyeat_get_theme_option( 'image_hover' );

	if ( 'dots' == $easyeat_hover ) {
		$easyeat_post_link = empty( $easyeat_template_args['no_links'] )
								? ( ! empty( $easyeat_template_args['link'] )
									? $easyeat_template_args['link']
									: get_permalink()
									)
								: '';
		$easyeat_target    = ! empty( $easyeat_post_link ) && easyeat_is_external_url( $easyeat_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$easyeat_components = ! empty( $easyeat_template_args['meta_parts'] )
							? ( is_array( $easyeat_template_args['meta_parts'] )
								? $easyeat_template_args['meta_parts']
								: explode( ',', $easyeat_template_args['meta_parts'] )
								)
							: easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) );

	// Featured image
	easyeat_show_post_featured( apply_filters( 'easyeat_filter_args_featured',
        array(
			'hover'         => $easyeat_hover,
			'no_links'      => ! empty( $easyeat_template_args['no_links'] ),
			'thumb_size'    => ! empty( $easyeat_template_args['thumb_size'] )
								? $easyeat_template_args['thumb_size']
								: easyeat_get_thumb_size(
									easyeat_is_blog_style_use_masonry( $easyeat_blog_style[0] )
										? (	strpos( easyeat_get_theme_option( 'body_style' ), 'full' ) !== false || $easyeat_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( easyeat_get_theme_option( 'body_style' ), 'full' ) !== false || $easyeat_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => easyeat_is_blog_style_use_masonry( $easyeat_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $easyeat_components,
			'class'         => 'dots' == $easyeat_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $easyeat_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $easyeat_post_link )
												? '<a href="' . esc_url( $easyeat_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $easyeat_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $easyeat_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $easyeat_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!