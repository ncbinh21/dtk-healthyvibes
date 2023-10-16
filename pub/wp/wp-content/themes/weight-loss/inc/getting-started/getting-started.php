<?php
//about theme info
add_action( 'admin_menu', 'weight_loss_gettingstarted' );
function weight_loss_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'weight-loss'), esc_html__('About Theme', 'weight-loss'), 'edit_theme_options', 'weight_loss_guide', 'weight_loss_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function weight_loss_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'weight_loss_admin_theme_style');

//guidline for about theme
function weight_loss_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'weight-loss' );

?>

<div class="wrapper-info">
	<div class="col-left">
		<div class="intro">
			<h3><?php esc_html_e( 'Welcome to Weight Loss WordPress Theme', 'weight-loss' ); ?> <span>Version: <?php echo esc_html($theme['Version']);?></span></h3>
		</div>
		<div class="started">
			<hr>
			<div class="free-doc">
				<div class="lz-4">
					<h4><?php esc_html_e( 'Start Customizing', 'weight-loss' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Go to', 'weight-loss' ); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizer', 'weight-loss' ); ?> </a> <?php esc_html_e( 'and start customizing your website', 'weight-loss' ); ?></span>
					</ul>
				</div>
				<div class="lz-4">
					<h4><?php esc_html_e( 'Support', 'weight-loss' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Send your query to our', 'weight-loss' ); ?> <a href="<?php echo esc_url( WEIGHT_LOSS_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Support', 'weight-loss' ); ?></a></span>
					</ul>
				</div>
			</div>
			<p><?php esc_html_e( 'Weight Loss is a stunning, elegant, modern, and free WP theme created for fitness freaks, weight loss centers, health and nutrition experts, fitness and healthy living, lifestyle websites, wellness and yoga centers, dieticians, and all the relevant businesses and professions that are somehow related to weight loss and health. It is very well documented and can explain everything to the users who are new to WP regarding its use. This theme is WPML and RTL compatible and makes use of well-written HTML codes that are further optimized for bringing a clean, and lightweight design. This results in pages that load at a quick speed and deliver faster page load time You will get a user-friendly interface and plenty of personalization options included. It has a responsive design that makes your website look beautiful on every screen. You will get many sections such as the Testimonial section, Team section, Blog section, etc. Besides that, there are many interactive Call to Action Buttons (CTAs) available that will not only act as a guide for your audience but also takes care of the conversions. You will find many translation options as this theme is WPML and RTL compatible and is crafted using a powerful Bootstrap framework.', 'weight-loss')?></p>
			<hr>			
			<div class="col-left-inner">
				<h3><?php esc_html_e( 'Get started with Free Weight Loss Theme', 'weight-loss' ); ?></h3>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/customizer-image.png" alt="" />
			</div>
		</div>
	</div>
	<div class="col-right">
		<div class="col-left-area">
			<h3><?php esc_html_e('Premium Theme Information', 'weight-loss'); ?></h3>
			<hr>
		</div>
		<div class="centerbold">
			<a href="<?php echo esc_url( WEIGHT_LOSS_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'weight-loss'); ?></a>
			<a href="<?php echo esc_url( WEIGHT_LOSS_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'weight-loss'); ?></a>
			<a href="<?php echo esc_url( WEIGHT_LOSS_PRO_DOCS ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'weight-loss'); ?></a>
			<hr class="secondhr">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/weight-loss.jpg" alt="" />
		</div>
		<h3><?php esc_html_e( 'PREMIUM THEME FEATURES', 'weight-loss'); ?></h3>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon01.png" alt="" />
			<h4><?php esc_html_e( 'Banner Slider', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon02.png" alt="" />
			<h4><?php esc_html_e( 'Theme Options', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon03.png" alt="" />
			<h4><?php esc_html_e( 'Custom Innerpage Banner', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon04.png" alt="" />
			<h4><?php esc_html_e( 'Custom Colors and Images', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon05.png" alt="" />
			<h4><?php esc_html_e( 'Fully Responsive', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon06.png" alt="" />
			<h4><?php esc_html_e( 'Hide/Show Sections', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon07.png" alt="" />
			<h4><?php esc_html_e( 'Woocommerce Support', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon08.png" alt="" />
			<h4><?php esc_html_e( 'Limit to display number of Posts', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon09.png" alt="" />
			<h4><?php esc_html_e( 'Multiple Page Templates', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon10.png" alt="" />
			<h4><?php esc_html_e( 'Custom Read More link', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon11.png" alt="" />
			<h4><?php esc_html_e( 'Code written with WordPress standard', 'weight-loss'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon12.png" alt="" />
			<h4><?php esc_html_e( '100% Multi language', 'weight-loss'); ?></h4>
		</div>
	</div>
</div>
<?php } ?>