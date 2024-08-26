<?php
/**
 * The template to display Admin notices
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.1
 */

$easyeat_theme_slug = get_option( 'template' );
$easyeat_theme_obj  = wp_get_theme( $easyeat_theme_slug );
?>
<div class="easyeat_admin_notice easyeat_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$easyeat_theme_img = easyeat_get_file_url( 'screenshot.jpg' );
	if ( '' != $easyeat_theme_img ) {
		?>
		<div class="easyeat_notice_image"><img src="<?php echo esc_url( $easyeat_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'easyeat' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="easyeat_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'easyeat' ),
				$easyeat_theme_obj->get( 'Name' ) . ( EASYEAT_THEME_FREE ? ' ' . __( 'Free', 'easyeat' ) : '' ),
				$easyeat_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="easyeat_notice_text">
		<p class="easyeat_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $easyeat_theme_obj->description ) );
			?>
		</p>
		<p class="easyeat_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'easyeat' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="easyeat_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=easyeat_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'easyeat' );
			?>
		</a>
	</div>
</div>
