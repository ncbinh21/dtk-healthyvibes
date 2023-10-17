<?php 

	$weight_loss_custom_style = '';

	// Logo Size
	$weight_loss_logo_top_padding = get_theme_mod('weight_loss_logo_top_padding');
	$weight_loss_logo_bottom_padding = get_theme_mod('weight_loss_logo_bottom_padding');
	$weight_loss_logo_left_padding = get_theme_mod('weight_loss_logo_left_padding');
	$weight_loss_logo_right_padding = get_theme_mod('weight_loss_logo_right_padding');

	if( $weight_loss_logo_top_padding != '' || $weight_loss_logo_bottom_padding != '' || $weight_loss_logo_left_padding != '' || $weight_loss_logo_right_padding != ''){
		$weight_loss_custom_style .=' .logo {';
			$weight_loss_custom_style .=' padding-top: '.esc_attr($weight_loss_logo_top_padding).'px; padding-bottom: '.esc_attr($weight_loss_logo_bottom_padding).'px; padding-left: '.esc_attr($weight_loss_logo_left_padding).'px; padding-right: '.esc_attr($weight_loss_logo_right_padding).'px;';
		$weight_loss_custom_style .=' }';
	}

	// Site Title Font Size
	$weight_loss_slider_hide_show = get_theme_mod('weight_loss_slider_hide_show',false);
	if( $weight_loss_slider_hide_show == false){
		$weight_loss_custom_style .=' .page-template-custom-home-page #header {';
			$weight_loss_custom_style .=' border-bottom: 1px solid #609a33;';
		$weight_loss_custom_style .=' }';
	}

	// Site Title Font Size
	$weight_loss_site_title_font_size = get_theme_mod('weight_loss_site_title_font_size');
	if( $weight_loss_site_title_font_size != ''){
		$weight_loss_custom_style .=' h1.site-title a, p.site-title a {';
			$weight_loss_custom_style .=' font-size: '.esc_attr($weight_loss_site_title_font_size).'px;';
		$weight_loss_custom_style .=' }';
	}

	// Site Tagline Font Size
	$weight_loss_site_tagline_font_size = get_theme_mod('weight_loss_site_tagline_font_size');
	if( $weight_loss_site_tagline_font_size != ''){
		$weight_loss_custom_style .=' p.site-description {';
			$weight_loss_custom_style .=' font-size: '.esc_attr($weight_loss_site_tagline_font_size).'px;';
		$weight_loss_custom_style .=' }';
	}

	// Header Image
	$header_image_url = weight_loss_banner_image( $image_url = '' );
	if( $header_image_url != ''){
		$weight_loss_custom_style .=' #inner-pages-header {';
			$weight_loss_custom_style .=' background-image: url('. esc_url( $header_image_url ).'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;';
		$weight_loss_custom_style .=' }';
		$weight_loss_custom_style .=' .header-overlay {';
			$weight_loss_custom_style .=' position: absolute; 	width: 100%; height: 100%; 	top: 0; left: 0; background: #000; opacity: 0.3;';
		$weight_loss_custom_style .=' }';
	} else {
		$weight_loss_custom_style .=' #inner-pages-header {';
			$weight_loss_custom_style .=' background:linear-gradient(180deg,#949292 27%,#969595 55%,#ccc 78%); ';
		$weight_loss_custom_style .=' }';
	}

	$weight_loss_slider_hide_show = get_theme_mod('weight_loss_slider_hide_show',false);
	if( $weight_loss_slider_hide_show == true){
		$weight_loss_custom_style .=' .page-template-custom-home-page #inner-pages-header {';
			$weight_loss_custom_style .=' display:none;';
		$weight_loss_custom_style .=' }';
	}

	//Slider color
	$weight_loss_slider_color = get_theme_mod('weight_loss_slider_color');

	if ( $weight_loss_slider_color != '') {
		$weight_loss_custom_style .=' #slider h2 a {';
			$weight_loss_custom_style .=' color:'.esc_attr($weight_loss_slider_color).';';
		$weight_loss_custom_style .=' }';
	}

	//Service color
	$weight_loss_service_color = get_theme_mod('weight_loss_service_color');

	if ( $weight_loss_service_color != '') {
		$weight_loss_custom_style .=' .service-box h4 a {';
			$weight_loss_custom_style .=' color:'.esc_attr($weight_loss_service_color).';';
		$weight_loss_custom_style .=' }';
	}