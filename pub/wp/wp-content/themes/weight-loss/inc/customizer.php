<?php
/**
 * Weight Loss: Customizer
 *
 * @subpackage Weight Loss
 * @since 1.0
 */

use WPTRT\Customize\Section\Weight_Loss_Button;

add_action( 'customize_register', function( $manager ) {

	$manager->register_section_type( Weight_Loss_Button::class );

	$manager->add_section(
		new Weight_Loss_Button( $manager, 'weight_loss_pro', [
			'title' => __( 'Weight Loss Pro', 'weight-loss' ),
			'priority' => 0,
			'button_text' => __( 'Go Pro', 'weight-loss' ),
			'button_url'  => esc_url( 'https://www.luzuk.com/product/weight-loss-wordpress-theme/', 'weight-loss')
		] )
	);

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'weight-loss-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
		[ 'customize-controls' ],
		$version,
		true
	);

	wp_enqueue_style(
		'weight-loss-customize-section-button',
		get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
		[ 'customize-controls' ],
 		$version
	);

} );

function weight_loss_customize_register( $wp_customize ) {

	$wp_customize->add_setting('weight_loss_logo_padding',array(
		'sanitize_callback'	=> 'esc_html'
	));
	$wp_customize->add_control('weight_loss_logo_padding',array(
		'label' => __('Logo Margin','weight-loss'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting('weight_loss_logo_top_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_logo_top_padding',array(
		'type' => 'number',
		'description' => __('Top','weight-loss'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('weight_loss_logo_bottom_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_logo_bottom_padding',array(
		'type' => 'number',
		'description' => __('Bottom','weight-loss'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('weight_loss_logo_left_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_logo_left_padding',array(
		'type' => 'number',
		'description' => __('Left','weight-loss'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('weight_loss_logo_right_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
 	));
 	$wp_customize->add_control('weight_loss_logo_right_padding',array(
		'type' => 'number',
		'description' => __('Right','weight-loss'),
		'section' => 'title_tagline',
    ));

	$wp_customize->add_setting('weight_loss_show_site_title',array(
		'default' => true,
		'sanitize_callback'	=> 'weight_loss_sanitize_checkbox'
	));
	$wp_customize->add_control('weight_loss_show_site_title',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Site Title','weight-loss'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting('weight_loss_site_title_font_size',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_site_title_font_size',array(
		'type' => 'number',
		'label' => __('Site Title Font Size','weight-loss'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_setting('weight_loss_show_tagline',array(
		'default' => true,
		'sanitize_callback'	=> 'weight_loss_sanitize_checkbox'
	));
	$wp_customize->add_control('weight_loss_show_tagline',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Site Tagline','weight-loss'),
		'section' => 'title_tagline'
	));

	$wp_customize->add_setting('weight_loss_site_tagline_font_size',array(
		'default' => '',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_site_tagline_font_size',array(
		'type' => 'number',
		'label' => __('Site Tagline Font Size','weight-loss'),
		'section' => 'title_tagline',
	));

	$wp_customize->add_panel( 'weight_loss_panel_id', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Settings', 'weight-loss' ),
		'description' => __( 'Description of what this panel does.', 'weight-loss' ),
	) );

	$wp_customize->add_section( 'weight_loss_theme_options_section', array(
    	'title'      => __( 'General Settings', 'weight-loss' ),
		'priority'   => 30,
		'panel' => 'weight_loss_panel_id'
	) );

	$wp_customize->add_setting('weight_loss_theme_options',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'weight_loss_sanitize_choices'
	));
	$wp_customize->add_control('weight_loss_theme_options',array(
		'type' => 'select',
		'label' => __('Blog Page Sidebar Layout','weight-loss'),
		'section' => 'weight_loss_theme_options_section',
		'choices' => array(
		   'Left Sidebar' => __('Left Sidebar','weight-loss'),
		   'Right Sidebar' => __('Right Sidebar','weight-loss'),
		   'One Column' => __('One Column','weight-loss'),
		   'Three Columns' => __('Three Columns','weight-loss'),
		   'Four Columns' => __('Four Columns','weight-loss'),
		   'Grid Layout' => __('Grid Layout','weight-loss')
		),
	));

	$wp_customize->add_setting('weight_loss_single_post_sidebar',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'weight_loss_sanitize_choices'
	));
	$wp_customize->add_control('weight_loss_single_post_sidebar',array(
        'type' => 'select',
        'label' => __('Single Post Sidebar Layout','weight-loss'),
        'section' => 'weight_loss_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','weight-loss'),
            'Right Sidebar' => __('Right Sidebar','weight-loss'),
            'One Column' => __('One Column','weight-loss')
        ),
	));

	$wp_customize->add_setting('weight_loss_page_sidebar',array(
		'default' => 'One Column',
		'sanitize_callback' => 'weight_loss_sanitize_choices'
	));
	$wp_customize->add_control('weight_loss_page_sidebar',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','weight-loss'),
        'section' => 'weight_loss_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','weight-loss'),
            'Right Sidebar' => __('Right Sidebar','weight-loss'),
            'One Column' => __('One Column','weight-loss')
        ),
	));

	$wp_customize->add_setting('weight_loss_archive_page_sidebar',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'weight_loss_sanitize_choices'
	));
	$wp_customize->add_control('weight_loss_archive_page_sidebar',array(
        'type' => 'select',
        'label' => __('Archive & Search Page Sidebar Layout','weight-loss'),
        'section' => 'weight_loss_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','weight-loss'),
            'Right Sidebar' => __('Right Sidebar','weight-loss'),
            'One Column' => __('One Column','weight-loss'),
		    'Three Columns' => __('Three Columns','weight-loss'),
		    'Four Columns' => __('Four Columns','weight-loss'),
            'Grid Layout' => __('Grid Layout','weight-loss')
        ),
	));

	//Header
	$wp_customize->add_section( 'weight_loss_header_section' , array(
    	'title'    => __( 'Header', 'weight-loss' ),
		'priority' => null,
		'panel' => 'weight_loss_panel_id'
	) );

	$wp_customize->add_setting('weight_loss_header_btn_text',array(
    	'default' => '',
    	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('weight_loss_header_btn_text',array(
	   	'type' => 'text',
	   	'label' => __('Add Button Text','weight-loss'),
	   	'section' => 'weight_loss_header_section',
	));

	$wp_customize->add_setting('weight_loss_header_btn_url',array(
    	'default' => '',
    	'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('weight_loss_header_btn_url',array(
	   	'type' => 'text',
	   	'label' => __('Add Button URL','weight-loss'),
	   	'section' => 'weight_loss_header_section',
	));

	//home page slider
	$wp_customize->add_section( 'weight_loss_slider_section' , array(
    	'title'    => __( 'Slider Settings', 'weight-loss' ),
		'priority' => null,
		'panel' => 'weight_loss_panel_id'
	) );

	$wp_customize->add_setting('weight_loss_slider_hide_show',array(
    	'default' => false,
    	'sanitize_callback'	=> 'weight_loss_sanitize_checkbox'
	));
	$wp_customize->add_control('weight_loss_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide Slider','weight-loss'),
	   	'section' => 'weight_loss_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'weight_loss_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'weight_loss_sanitize_dropdown_pages'
		));
		$wp_customize->add_control( 'weight_loss_slider' . $count, array(
			'label' => __('Select Slider Image Page', 'weight-loss' ),
			'description'=> __('Image size (540px x 380px)','weight-loss'),
			'section' => 'weight_loss_slider_section',
			'type' => 'dropdown-pages'
		));
	}

	$wp_customize->add_setting('weight_loss_slider_excerpt_length',array(
		'default' => '15',
		'sanitize_callback'	=> 'weight_loss_sanitize_float'
	));
	$wp_customize->add_control('weight_loss_slider_excerpt_length',array(
		'type' => 'number',
		'label' => __('Slider Excerpt Length','weight-loss'),
		'section' => 'weight_loss_slider_section',
	));

	$wp_customize->add_setting( 'weight_loss_slider_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	   ));
	 $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'weight_loss_slider_color', array(
		   'label' => 'Text Color',
		'section' => 'weight_loss_slider_section',
	   )));

	//Services Section
	$wp_customize->add_section('weight_loss_service_section',array(
		'title'	=> __('Service Section','weight-loss'),
		'description'=> __('Note : This section will appear below the slider.','weight-loss'),
		'panel' => 'weight_loss_panel_id',
	));

    $wp_customize->add_setting('weight_loss_small_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('weight_loss_small_title',array(
		'label'	=> __('Section Small Title','weight-loss'),
		'section' => 'weight_loss_service_section',
		'type' => 'text'
	));

    $wp_customize->add_setting('weight_loss_section_title',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('weight_loss_section_title',array(
		'label'	=> __('Section Title','weight-loss'),
		'section' => 'weight_loss_service_section',
		'type' => 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('weight_loss_category_setting',array(
		'default' => 'select',
		'sanitize_callback' => 'weight_loss_sanitize_choices',
	));
	$wp_customize->add_control('weight_loss_category_setting',array(
		'type' => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category To Display Post','weight-loss'),
		'section' => 'weight_loss_service_section',
	));

	$wp_customize->add_setting( 'weight_loss_service_color', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	   ));
	 $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'weight_loss_service_color', array(
		   'label' => 'Text Color',
		'section' => 'weight_loss_service_section',
	   )));

	//Footer
    $wp_customize->add_section( 'weight_loss_footer', array(
    	'title'  => __( 'Footer Setting', 'weight-loss' ),
		'priority' => null,
		'panel' => 'weight_loss_panel_id'
	) );

	$wp_customize->add_setting('weight_loss_show_back_totop',array(
       'default' => true,
       'sanitize_callback'	=> 'weight_loss_sanitize_checkbox'
    ));
    $wp_customize->add_control('weight_loss_show_back_totop',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Back to Top','weight-loss'),
       'section' => 'weight_loss_footer'
    ));

    $wp_customize->add_setting('weight_loss_footer_copy',array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('weight_loss_footer_copy',array(
		'label'	=> __('Copyright Text','weight-loss'),
		'section' => 'weight_loss_footer',
		'setting' => 'weight_loss_footer_copy',
		'type' => 'text'
	));

	$wp_customize->add_setting('weight_loss_footer_link',array(
		'default' => '//www.luzuk.com/product/weight-loss-wordpress-theme/',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('weight_loss_footer_link',array(
		'label'	=> __('Copyright Link','weight-loss'),
		'section' => 'weight_loss_footer',
		'setting' => 'weight_loss_footer_link',
		'type' => 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'weight_loss_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'weight_loss_customize_partial_blogdescription',
	) );
}
add_action( 'customize_register', 'weight_loss_customize_register' );

function weight_loss_customize_partial_blogname() {
	bloginfo( 'name' );
}

function weight_loss_customize_partial_blogdescription() {
	bloginfo( 'description' );
}