<?php

/**
 * Theme Customizer Options
 *
 * @package WordPress
 * @since 3.4.0
 */

/**
 * Defines all of the sections, settings, and controls for the various
 * options in the Theme customizer
 *
 * @param   object    $wp_customize    A reference to the Theme Customizer
 * @package Geneplate\Inc
 *
 */

add_action( 'customize_register', 'geneplate_customize_register' );
function geneplate_customize_register( $wp_customize ) {

  	/* Background Image Options
	 *------------------------------------------*/

	$wp_customize->add_section(
		'geneplate_cover_options', array(
            'title'    => __( 'Default Cover Image', 'geneplate' ),
            'priority' => 190,
            'description' => __( "When you share a post on Facebook, your featured image or an image from your post will be used as the cover art. If WordPress can't find an image, it will use this one.", 'geneplate' )
		)
	);

	$wp_customize->add_setting(
		'geneplate_cover_image', array(
			'default'    =>  '',
	        'transport'  =>  'postMessage'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize,
			'geneplate_cover_image', array(
				'label'    => __( 'Default Cover Image', 'geneplate' ),
				'section'  => 'geneplate_cover_options',
				'settings' => 'geneplate_cover_image'
			)
		)
	);


}
