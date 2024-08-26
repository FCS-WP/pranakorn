<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.50
 */

$easyeat_template_args = get_query_var( 'easyeat_template_args' );
if ( is_array( $easyeat_template_args ) ) {
	$easyeat_columns    = empty( $easyeat_template_args['columns'] ) ? 2 : max( 1, $easyeat_template_args['columns'] );
	$easyeat_blog_style = array( $easyeat_template_args['type'], $easyeat_columns );
} else {
	$easyeat_template_args = array();
	$easyeat_blog_style = explode( '_', easyeat_get_theme_option( 'blog_style' ) );
	$easyeat_columns    = empty( $easyeat_blog_style[1] ) ? 2 : max( 1, $easyeat_blog_style[1] );
}
$easyeat_blog_id       = easyeat_get_custom_blog_id( join( '_', $easyeat_blog_style ) );
$easyeat_blog_style[0] = str_replace( 'blog-custom-', '', $easyeat_blog_style[0] );
$easyeat_expanded      = ! easyeat_sidebar_present() && easyeat_get_theme_option( 'expand_content' ) == 'expand';
$easyeat_components    = ! empty( $easyeat_template_args['meta_parts'] )
							? ( is_array( $easyeat_template_args['meta_parts'] )
								? join( ',', $easyeat_template_args['meta_parts'] )
								: $easyeat_template_args['meta_parts']
								)
							: easyeat_array_get_keys_by_value( easyeat_get_theme_option( 'meta_parts' ) );
$easyeat_post_format   = get_post_format();
$easyeat_post_format   = empty( $easyeat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $easyeat_post_format );

$easyeat_blog_meta     = easyeat_get_custom_layout_meta( $easyeat_blog_id );
$easyeat_custom_style  = ! empty( $easyeat_blog_meta['scripts_required'] ) ? $easyeat_blog_meta['scripts_required'] : 'none';

if ( ! empty( $easyeat_template_args['slider'] ) || $easyeat_columns > 1 || ! easyeat_is_off( $easyeat_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $easyeat_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( easyeat_is_off( $easyeat_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $easyeat_custom_style ) ) . "-1_{$easyeat_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $easyeat_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $easyeat_columns )
					. ' post_layout_' . esc_attr( $easyeat_blog_style[0] )
					. ' post_layout_' . esc_attr( $easyeat_blog_style[0] ) . '_' . esc_attr( $easyeat_columns )
					. ( ! easyeat_is_off( $easyeat_custom_style )
						? ' post_layout_' . esc_attr( $easyeat_custom_style )
							. ' post_layout_' . esc_attr( $easyeat_custom_style ) . '_' . esc_attr( $easyeat_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'easyeat_action_show_layout', $easyeat_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $easyeat_template_args['slider'] ) || $easyeat_columns > 1 || ! easyeat_is_off( $easyeat_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
