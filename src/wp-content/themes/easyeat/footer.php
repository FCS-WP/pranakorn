<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package EASYEAT
 * @since EASYEAT 1.0
 */

							do_action( 'easyeat_action_page_content_end_text' );
							
							// Widgets area below the content
							easyeat_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'easyeat_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'easyeat_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'easyeat_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'easyeat_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$easyeat_body_style = easyeat_get_theme_option( 'body_style' );
					$easyeat_widgets_name = easyeat_get_theme_option( 'widgets_below_page' );
					$easyeat_show_widgets = ! easyeat_is_off( $easyeat_widgets_name ) && is_active_sidebar( $easyeat_widgets_name );
					$easyeat_show_related = easyeat_is_single() && easyeat_get_theme_option( 'related_position' ) == 'below_page';
					if ( $easyeat_show_widgets || $easyeat_show_related ) {
						if ( 'fullscreen' != $easyeat_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $easyeat_show_related ) {
							do_action( 'easyeat_action_related_posts' );
						}

						// Widgets area below page content
						if ( $easyeat_show_widgets ) {
							easyeat_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $easyeat_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'easyeat_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'easyeat_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! easyeat_is_singular( 'post' ) && ! easyeat_is_singular( 'attachment' ) ) || ! in_array ( easyeat_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="easyeat_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'easyeat_action_before_footer' );

				// Footer
				$easyeat_footer_type = easyeat_get_theme_option( 'footer_type' );
				if ( 'custom' == $easyeat_footer_type && ! easyeat_is_layouts_available() ) {
					$easyeat_footer_type = 'default';
				}
				get_template_part( apply_filters( 'easyeat_filter_get_template_part', "templates/footer-" . sanitize_file_name( $easyeat_footer_type ) ) );

				do_action( 'easyeat_action_after_footer' );

			}
			?>

			<?php do_action( 'easyeat_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'easyeat_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'easyeat_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>