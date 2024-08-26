<?php
/**
 * The template to display single post
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

// Full post loading
$full_post_loading          = easyeat_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = easyeat_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = easyeat_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$easyeat_related_position   = easyeat_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$easyeat_posts_navigation   = easyeat_get_theme_option( 'posts_navigation' );
$easyeat_prev_post          = false;
$easyeat_prev_post_same_cat = easyeat_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( easyeat_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	easyeat_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'easyeat_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $easyeat_posts_navigation ) {
		$easyeat_prev_post = get_previous_post( $easyeat_prev_post_same_cat );  // Get post from same category
		if ( ! $easyeat_prev_post && $easyeat_prev_post_same_cat ) {
			$easyeat_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $easyeat_prev_post ) {
			$easyeat_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $easyeat_prev_post ) ) {
		easyeat_sc_layouts_showed( 'featured', false );
		easyeat_sc_layouts_showed( 'title', false );
		easyeat_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $easyeat_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/content', 'single-' . easyeat_get_theme_option( 'single_style' ) ), 'single-' . easyeat_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $easyeat_related_position, 'inside' ) === 0 ) {
		$easyeat_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'easyeat_action_related_posts' );
		$easyeat_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $easyeat_related_content ) ) {
			$easyeat_related_position_inside = max( 0, min( 9, easyeat_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $easyeat_related_position_inside ) {
				$easyeat_related_position_inside = mt_rand( 1, 9 );
			}

			$easyeat_p_number         = 0;
			$easyeat_related_inserted = false;
			$easyeat_in_block         = false;
			$easyeat_content_start    = strpos( $easyeat_content, '<div class="post_content' );
			$easyeat_content_end      = strrpos( $easyeat_content, '</div>' );

			for ( $i = max( 0, $easyeat_content_start ); $i < min( strlen( $easyeat_content ) - 3, $easyeat_content_end ); $i++ ) {
				if ( $easyeat_content[ $i ] != '<' ) {
					continue;
				}
				if ( $easyeat_in_block ) {
					if ( strtolower( substr( $easyeat_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$easyeat_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $easyeat_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $easyeat_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$easyeat_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $easyeat_content[ $i + 1 ] && in_array( $easyeat_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$easyeat_p_number++;
					if ( $easyeat_related_position_inside == $easyeat_p_number ) {
						$easyeat_related_inserted = true;
						$easyeat_content = ( $i > 0 ? substr( $easyeat_content, 0, $i ) : '' )
											. $easyeat_related_content
											. substr( $easyeat_content, $i );
					}
				}
			}
			if ( ! $easyeat_related_inserted ) {
				if ( $easyeat_content_end > 0 ) {
					$easyeat_content = substr( $easyeat_content, 0, $easyeat_content_end ) . $easyeat_related_content . substr( $easyeat_content, $easyeat_content_end );
				} else {
					$easyeat_content .= $easyeat_related_content;
				}
			}
		}

		easyeat_show_layout( $easyeat_content );
	}

	// Comments
	do_action( 'easyeat_action_before_comments' );
	comments_template();
	do_action( 'easyeat_action_after_comments' );

	// Related posts
	if ( 'below_content' == $easyeat_related_position
		&& ( 'scroll' != $easyeat_posts_navigation || easyeat_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || easyeat_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'easyeat_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $easyeat_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $easyeat_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $easyeat_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $easyeat_prev_post ) ); ?>"
			<?php do_action( 'easyeat_action_nav_links_single_scroll_data', $easyeat_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
