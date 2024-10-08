<?php
/**
 * Shortcode: TGenerator (Gutenberg support)
 *
 * @package ThemeREX Addons
 * @since v2.22.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

use TrxAddons\AiHelper\OpenAi;
use TrxAddons\AiHelper\Lists;
use TrxAddons\AiHelper\Utils;

// Gutenberg Block
//------------------------------------------------------

// Add scripts and styles for the editor
if ( ! function_exists( 'trx_addons_gutenberg_sc_tgenerator_editor_assets' ) ) {
	add_action( 'enqueue_block_editor_assets', 'trx_addons_gutenberg_sc_tgenerator_editor_assets', TRX_ADDONS_GUTENBERG_EDITOR_BLOCK_REGISTRATION_PRIORITY );
	function trx_addons_gutenberg_sc_tgenerator_editor_assets() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			wp_enqueue_script(
				'trx-addons-gutenberg-editor-block-tgenerator',
				trx_addons_get_file_url( TRX_ADDONS_PLUGIN_ADDONS . 'ai-helper/shortcodes/tgenerator/gutenberg/tgenerator.gutenberg-editor.js' ),
				trx_addons_block_editor_dependencis(),
				filemtime( trx_addons_get_file_dir( TRX_ADDONS_PLUGIN_ADDONS . 'ai-helper/shortcodes/tgenerator/gutenberg/tgenerator.gutenberg-editor.js' ) ),
				true
			);
		}
	}
}

// Block register
if ( ! function_exists( 'trx_addons_sc_tgenerator_add_in_gutenberg' ) ) {
	add_action( 'init', 'trx_addons_sc_tgenerator_add_in_gutenberg' );
	function trx_addons_sc_tgenerator_add_in_gutenberg() {
		if ( trx_addons_exists_gutenberg() && trx_addons_get_setting( 'allow_gutenberg_blocks' ) ) {
			register_block_type(
				'trx-addons/tgenerator',
				apply_filters('trx_addons_gb_map', array(
					'attributes'      => array_merge(
						array(
							'type'               => array(
								'type'    => 'string',
								'default' => 'default',
							),
							'model'              => array(
								'type'    => 'string',
								'default' => '',
							),						
							'override_config'    => array(
								'type'    => 'string',
								'default' => '',
							),						
							'prompt'             => array(
								'type'    => 'string',
								'default' => '',
							),						
							'prompt_width'       => array(
								'type'    => 'number',
								'default' => 100,
							),
							'placeholder_text'   => array(
								'type'    => 'string',
								'default' => '',
							),						
							'button_text'        => array(
								'type'    => 'string',
								'default' => '',
							),						
							'align'              => array(
								'type'    => 'string',
								'default' => '',
							),						
							'premium'            => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'show_limits'        => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'system_prompt'      => array(
								'type'    => 'string',
								'default' => '',
							),
							'temperature'       => array(
								'type'    => 'number',
								'default' => (float)trx_addons_get_option( 'ai_helper_sc_tgenerator_temperature' ),
							),
							'max_tokens'        => array(
								'type'    => 'number',
								'default' => 0,
							),
							// Rerender
							'reload'            => array(
								'type'    => 'string',
								'default' => '',
							),
						),
						! apply_filters( 'trx_addons_filter_add_title_param', true, 'trx-addons/tgenerator' ) ? array() : trx_addons_gutenberg_get_param_title(),
						! apply_filters( 'trx_addons_filter_add_title_param', true, 'trx-addons/tgenerator' ) ? array() : trx_addons_gutenberg_get_param_button(),
						trx_addons_gutenberg_get_param_id()
					),
					'render_callback' => 'trx_addons_gutenberg_sc_tgenerator_render_block',
				), 'trx-addons/tgenerator' )
			);
		}
	}
}

// Block render
if ( ! function_exists( 'trx_addons_gutenberg_sc_tgenerator_render_block' ) ) {
	function trx_addons_gutenberg_sc_tgenerator_render_block( $attributes = array() ) {
		return trx_addons_sc_tgenerator( $attributes );
	}
}

// Return list of allowed layouts
if ( ! function_exists( 'trx_addons_gutenberg_sc_tgenerator_get_layouts' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_layouts', 'trx_addons_gutenberg_sc_tgenerator_get_layouts', 10, 1 );
	function trx_addons_gutenberg_sc_tgenerator_get_layouts( $array = array() ) {
		$array['sc_tgenerator'] = apply_filters( 'trx_addons_sc_type', array( 'default' => __( 'Default', 'trx_addons' ) ), 'trx_sc_tgenerator' );
		return $array;
	}
}

// Add shortcode-specific lists to the js vars
if ( ! function_exists( 'trx_addons_gutenberg_sc_tgenerator_params' ) ) {
	add_filter( 'trx_addons_filter_gutenberg_sc_params', 'trx_addons_gutenberg_sc_tgenerator_params', 10, 1 );
	function trx_addons_gutenberg_sc_tgenerator_params( $vars = array() ) {
		// If editor is active now
		$is_edit_mode = trx_addons_is_post_edit();

		$vars['sc_tgenerator_models'] = ! $is_edit_mode ? array() : Lists::get_list_ai_text_models();
		$vars['sc_tgenerator_models_flowise_ai'] = ! $is_edit_mode ? array() : array_values( array_filter( array_keys( $vars['sc_tgenerator_models'] ), function( $key ) { return Utils::is_flowise_ai_model( $key ); } ) );
		$vars['sc_tgenerator_aligns'] = ! $is_edit_mode ? array() : trx_addons_get_list_sc_aligns();
		$vars['sc_tgenerator_max_tokens'] = ! $is_edit_mode ? Utils::get_default_max_tokens() : Utils::get_max_tokens( 'sc_tgenerator' );
		$vars['sc_tgenerator_temperature'] = (float)trx_addons_get_option( 'ai_helper_sc_tgenerator_temperature' );
		return $vars;
	}
}
