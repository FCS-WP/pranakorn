<?php
/**
 * The template to display Admin notices
 *
 * @package EASYEAT
 * @since EASYEAT 1.0.64
 */

$easyeat_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$easyeat_skins_args = get_query_var( 'easyeat_skins_notice_args' );
?>
<div class="easyeat_admin_notice easyeat_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'easyeat' ); ?>
	</h3>
	<?php

	// Description
	$easyeat_total      = $easyeat_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$easyeat_skins_msg  = $easyeat_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $easyeat_total, 'easyeat' ), $easyeat_total ) . '</strong>'
							: '';
	$easyeat_total      = $easyeat_skins_args['free'];
	$easyeat_skins_msg .= $easyeat_total > 0
							? ( ! empty( $easyeat_skins_msg ) ? ' ' . esc_html__( 'and', 'easyeat' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $easyeat_total, 'easyeat' ), $easyeat_total ) . '</strong>'
							: '';
	$easyeat_total      = $easyeat_skins_args['pay'];
	$easyeat_skins_msg .= $easyeat_skins_args['pay'] > 0
							? ( ! empty( $easyeat_skins_msg ) ? ' ' . esc_html__( 'and', 'easyeat' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $easyeat_total, 'easyeat' ), $easyeat_total ) . '</strong>'
							: '';
	?>
	<div class="easyeat_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'easyeat' ), $easyeat_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="easyeat_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $easyeat_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'easyeat' );
			?>
		</a>
	</div>
</div>
