<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<main id="skip-content" role="main">

	<?php do_action( 'weight_loss_above_slider' ); ?>

	<?php if( get_theme_mod('weight_loss_slider_hide_show') != ''){ ?>
		<section id="slider">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			    <?php $weight_loss_slider_pages = array();
			    for ( $count = 1; $count <= 4; $count++ ) {
			        $mod = intval( get_theme_mod( 'weight_loss_slider'. $count ));
			        if ( 'page-none-selected' != $mod ) {
			          $weight_loss_slider_pages[] = $mod;
			        }
			    }
		      	if( !empty($weight_loss_slider_pages) ) :
			        $args = array(
			          	'post_type' => 'page',
			          	'post__in' => $weight_loss_slider_pages,
			          	'orderby' => 'post__in'
			        );
		        	$query = new WP_Query( $args );
		        if ( $query->have_posts() ) :
		          	$i = 1;
		    	?>     
				    <div class="carousel-inner" role="listbox">
				      	<?php  while ( $query->have_posts() ) : $query->the_post(); ?>
					        <div <?php if($i == 1){echo 'class="carousel-item fade-in-image active"';} else{ echo 'class="carousel-item fade-in-image"';}?>>
					        	<div class="container py-5 my-md-5">
						        	<div class="row">
						        		<div class="col-lg-6 col-md-6 align-self-center slider-content">
						        			<div class="carousel-caption">
									            <div class="inner-carousel">
									              	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													  <p class="mb-0"><?php $weight_loss_excerpt = get_the_excerpt(); echo esc_html( weight_loss_string_limit_words( $weight_loss_excerpt, esc_attr(get_theme_mod('weight_loss_slider_excerpt_length','15') ) )); ?></p>
									              	<a href="<?php the_permalink(); ?>" class="read-btn"><span><?php echo esc_html('Read More','weight-loss'); ?></span><span class="screen-reader-text"><?php echo esc_html('Read More','weight-loss'); ?></span></a>
							            		</div>
							            	</div>
						        		</div>
						        		<div class="col-lg-6 col-md-6 align-self-center">
						        			<div class="sliderimg">
					            				<?php if(has_post_thumbnail()) {?>
					            					<img src="<?php esc_url(the_post_thumbnail_url('full')); ?>" alt="<?php the_title_attribute(); ?> "/>
					            				<?php } else {?>
					            					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slider.png" alt="<?php the_title_attribute(); ?> "/>
					            				<?php }?>
										    </div>
						        		</div>
						        	</div>
						        </div>
					        </div>
				      	<?php $i++; endwhile; 
				      	wp_reset_postdata();?>
				    </div>
			    <?php else : ?>
			    	<div class="no-postfound"></div>
	      		<?php endif;
			    endif;?>
			    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			      	<span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-angle-left"></i></span>
			      	<span class="screen-reader-text"><?php esc_html_e( 'Prev','weight-loss' );?></span>
			    </a>
			    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			      	<span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-angle-right"></i></span>
			      	<span class="screen-reader-text"><?php esc_html_e( 'Next','weight-loss' );?></span>
			    </a>
			</div>
		  	<div class="clearfix"></div>
		</section>
	<?php }?>
	
	<?php do_action('weight_loss_below_slider'); ?>

	<?php if(get_theme_mod('weight_loss_section_title') != '' || get_theme_mod('weight_loss_small_title') != '' || get_theme_mod('weight_loss_category_setting') != ''){ ?>
		<section id="service-section" class="py-5">
			<div class="container">
				<div class="service-head text-center mb-5">
					<?php if(get_theme_mod('weight_loss_small_title') != ''){?>
						<strong class="small-title"><?php echo esc_html(get_theme_mod('weight_loss_small_title')); ?></strong>
					<?php }?>
					<?php if(get_theme_mod('weight_loss_section_title') != ''){?>
						<h3><?php echo esc_html(get_theme_mod('weight_loss_section_title')); ?></h3>
					<?php }?>
				</div>
				<?php $weight_loss_catData1 =  get_theme_mod('weight_loss_category_setting');
				if($weight_loss_catData1){ 
					$args = array(
						'post_type' => 'post',
						'category_name' => esc_html($weight_loss_catData1 ,'weight-loss'),
			        ); ?>
			        <div class="row">
		        		<?php $query = new WP_Query( $args );
			          	if ( $query->have_posts() ) :
			        		while( $query->have_posts() ) : $query->the_post(); ?>
			          			<div class="col-lg-4 col-md-6">
			          				<div class="service-box">
	          							<div class="service-image">
	          								<?php the_post_thumbnail(); ?>
	          							</div>
          								<div class="service-content mt-3">
				            				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							              	<p class="mb-0"><?php $weight_loss_excerpt = get_the_excerpt(); echo esc_html( weight_loss_string_limit_words( $weight_loss_excerpt,12 ) ); ?></p>
							              	<div class="read-btn">
							              		<a href="<?php the_permalink(); ?>"><span><?php echo esc_html('Read More','weight-loss'); ?></span><span class="screen-reader-text"><?php echo esc_html('Read More','weight-loss'); ?></span></a>
							              	</div>
			            				</div>
			          				</div>
							    </div>
			          		<?php endwhile; 
			          		wp_reset_postdata(); ?>
			          	<?php else : ?>
			              	<div class="no-postfound"></div>
			            <?php endif; ?>
	          		</div>
	      		<?php }?>
			</div>
		</section>
	<?php }?>

	<?php do_action('weight_loss_below_service_section'); ?>

	<div class="container">
	  	<?php while ( have_posts() ) : the_post(); ?>
	  		<div class="lz-content">
	        	<?php the_content(); ?>
	        </div>
	    <?php endwhile; // end of the loop. ?>
	</div>
</main>

<?php get_footer(); ?>