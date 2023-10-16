<?php
/**
 * Weight Loss functions and definitions
 *
 * @subpackage Weight Loss
 * @since 1.0
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Weight_Loss_Loader.php' );

$Weight_Loss_Loader = new \WPTRT\Autoload\Weight_Loss_Loader();

$Weight_Loss_Loader->weight_loss_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$Weight_Loss_Loader->weight_loss_register();

function weight_loss_setup() {
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background', $defaults = array(
	    'default-color'          => '',
	    'default-image'          => '',
	    'default-repeat'         => '',
	    'default-position-x'     => '',
	    'default-attachment'     => '',
	    'wp-head-callback'       => '_custom_background_cb',
	    'admin-head-callback'    => '',
	    'admin-preview-callback' => ''
	));

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'weight-loss' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );

	// Theme Activation Notice
	global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'weight_loss_activation_notice' );
	}

}
add_action( 'after_setup_theme', 'weight_loss_setup' );

// Notice after Theme Activation
function weight_loss_activation_notice() {
	echo '<div class="notice notice-success is-dismissible start-notice">';
		echo '<h3>'. esc_html__( 'Welcome to Luzuk!!', 'weight-loss' ) .'</h3>';
		echo '<p>'. esc_html__( 'Thank you for choosing Weight Loss theme. It will be our pleasure to have you on our Welcome page to serve you better.', 'weight-loss' ) .'</p>';
		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=weight_loss_guide' ) ) .'" class="button button-primary">'. esc_html__( 'GET STARTED', 'weight-loss' ) .'</a></p>';
	echo '</div>';
}

function weight_loss_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'weight-loss' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'weight-loss' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'weight-loss' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h2 class="widget-title">',
		'after_title'   => '</h2></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'weight-loss' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'weight-loss' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'weight-loss' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'weight-loss' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'weight-loss' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'weight_loss_widgets_init' );

function weight_loss_fonts_url(){

	$font_families = array(
		'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900'
	);

	$fonts_url = add_query_arg( array(
		'family' => implode( '&family=', $font_families ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	$contents = wptt_get_webfont_url( esc_url_raw( $fonts_url ) );
	return $contents;
}

//Enqueue scripts and styles.
function weight_loss_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'weight-loss-fonts', weight_loss_fonts_url(), array(), null );
	
	//Bootstarp 
	wp_enqueue_style( 'bootstrap-css', esc_url( get_template_directory_uri() ).'/assets/css/bootstrap.css' );
	
	// Theme stylesheet.
	wp_enqueue_style( 'weight-loss-basic-style', get_stylesheet_uri() );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'weight-loss-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'weight-loss-style' ), '1.0' );
		wp_style_add_data( 'weight-loss-ie9', 'conditional', 'IE 9' );
	}
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'weight-loss-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'weight-loss-style' ), '1.0' );
	wp_style_add_data( 'weight-loss-ie8', 'conditional', 'lt IE 9' );

	//font-awesome
	wp_enqueue_style( 'font-awesome-css', esc_url( get_template_directory_uri() ).'/assets/css/fontawesome-all.css' );

	require get_parent_theme_file_path( '/lz-custom-style.php' );
	wp_add_inline_style( 'weight-loss-basic-style',$weight_loss_custom_style );

	wp_enqueue_script( 'weight-loss-navigation-jquery', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap-js', esc_url( get_template_directory_uri() ). '/assets/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', esc_url( get_template_directory_uri() ). '/assets/js/jquery.superfish.js', array('jquery') ,'',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'weight_loss_scripts' );

function weight_loss_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'weight_loss_front_page_template' );

define('WEIGHT_LOSS_LIVE_DEMO',__('http://www.luzukdemo.com/demo/weight-loss/','weight-loss'));
define('WEIGHT_LOSS_PRO_DOCS',__('https://www.luzukdemo.com/docs/weight-loss/','weight-loss'));
define('WEIGHT_LOSS_BUY_NOW',__('https://www.luzuk.com/product/weight-loss-wordpress-theme/','weight-loss'));
define('WEIGHT_LOSS_SUPPORT',__('https://wordpress.org/support/theme/weight-loss/','weight-loss'));
define('WEIGHT_LOSS_CREDIT',__('https://www.luzuk.com/themes/free-weight-loss-wordpress-theme/','weight-loss'));

if ( ! function_exists( 'weight_loss_credit' ) ) {
	function weight_loss_credit(){
		echo "<a href=".esc_url(WEIGHT_LOSS_CREDIT)." target='_blank'>".esc_html__('','weight-loss')."</a>";
	}
}

function weight_loss_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function weight_loss_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function weight_loss_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function weight_loss_sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/* Excerpt Limit Begin */
function weight_loss_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'weight_loss_loop_columns');
if (!function_exists('weight_loss_loop_columns')) {
	function weight_loss_loop_columns() {
		return 3; // 3 products per row
	}
}

/* Breadcrumb Begin */
function weight_loss_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
			echo esc_url(home_url());
		echo '">';
			bloginfo('name');
		echo "</a> ";
		if (is_category() || is_single()) {
			echo "&nbsp;&#187;&nbsp;";
			the_category(', ');
			if (is_single()) {
				echo "&nbsp;&#187;&nbsp;";
				echo "<span> ";
					the_title();
				echo "</span>";
			}
		} elseif (is_page()) {
			echo "&nbsp;&#187;&nbsp;";
			echo "<span>";
				the_title();
			echo "</span> ";
		}
	}
}

function weight_loss_banner_image( $image_url ){
    global $post;

    if( is_singular() ){
        $image_url      = get_the_post_thumbnail_url( $post->ID, 'full' );
    }
    return $image_url;
}

require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/getting-started/getting-started.php' );

require get_parent_theme_file_path( '/inc/wptt-webfont-loader.php' );