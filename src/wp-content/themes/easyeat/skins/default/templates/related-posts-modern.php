<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

$easyeat_link        = get_permalink();
$easyeat_post_format = get_post_format();
$easyeat_post_format = empty( $easyeat_post_format ) ? 'standard' : str_replace( 'post-format-', '', $easyeat_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $easyeat_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	easyeat_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'easyeat_filter_related_thumb_size', easyeat_get_thumb_size( (int) easyeat_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( easyeat_get_post_categories( '' ), 'easyeat_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $easyeat_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'easyeat' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $easyeat_link ) . '" class="post_meta_item post_date">' . wp_kses_data( easyeat_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
