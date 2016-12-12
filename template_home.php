<?php
/*
Template Name: Home Page Template
*/
//get the header
get_header(); 
//start the page loop
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<section class="home-login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-5 col-sm-2">
				<?php the_content(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-5 col-sm-2">	
				<?php 
				$documents = get_post_type_archive_link( 'documents' );
				$args = array('redirect'=> $documents,'value_remember' => true, 'label_username' => __( 'Username' ),);
				wp_login_form( $args ); 
				?> 				
			</div>
		</div>
		<div class="row" id="registrationform">
			<div class="col-sm-offset-5 col-sm-2">
				<?php echo do_shortcode('[contact-form-7 id="20" title="Contact form 1"]'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-5 col-sm-2">				
				<div class="registerlink">
					<a class="btn btn-primary">Click here to register</a>	
				</div>			
			</div>
		</div>
	</div>
</section>
		
<?php
endwhile; else : 	
echo '<p> Sorry, no posts matched your criteria. </p>';
endif;
get_footer();