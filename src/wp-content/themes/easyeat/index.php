<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

$easyeat_template = apply_filters( 'easyeat_filter_get_template_part', easyeat_blog_archive_get_template() );

if ( ! empty( $easyeat_template ) && 'index' != $easyeat_template ) {

	get_template_part( $easyeat_template );

} else {

	easyeat_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$easyeat_stickies   = is_home()
								|| ( in_array( easyeat_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) easyeat_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$easyeat_post_type  = easyeat_get_theme_option( 'post_type' );
		$easyeat_args       = array(
								'blog_style'     => easyeat_get_theme_option( 'blog_style' ),
								'post_type'      => $easyeat_post_type,
								'taxonomy'       => easyeat_get_post_type_taxonomy( $easyeat_post_type ),
								'parent_cat'     => easyeat_get_theme_option( 'parent_cat' ),
								'posts_per_page' => easyeat_get_theme_option( 'posts_per_page' ),
								'sticky'         => easyeat_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $easyeat_stickies )
															&& count( $easyeat_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		easyeat_blog_archive_start();

		do_action( 'easyeat_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'easyeat_action_before_page_author' );
			get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'easyeat_action_after_page_author' );
		}

		if ( easyeat_get_theme_option( 'show_filters' ) ) {
			do_action( 'easyeat_action_before_page_filters' );
			easyeat_show_filters( $easyeat_args );
			do_action( 'easyeat_action_after_page_filters' );
		} else {
			do_action( 'easyeat_action_before_page_posts' );
			easyeat_show_posts( array_merge( $easyeat_args, array( 'cat' => $easyeat_args['parent_cat'] ) ) );
			do_action( 'easyeat_action_after_page_posts' );
		}

		do_action( 'easyeat_action_blog_archive_end' );

		easyeat_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'easyeat_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
